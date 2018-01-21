<?php

namespace App;

use Illuminate\Support\Carbon;

class SloaAccountingLine extends AccountingLine
{
    /**
     * Sets fields available for mass assignment
     */
    protected $fillable = [
        'sub_class',
        'department_transfer',
        'department_regular',
        'bpoa',
        'epoa',
        'availability_type',
        'main_account',
        'sub_account',
        'business_event_type_code',
        'object_class',
        'reimbursable_flag',
        'budget_line_item',
        'security_cooperation',
        'security_cooperation_implementing_agency_code',
        'security_cooperation_case_designator',
        'security_cooperation_case_line_item_identifier',
        'sub_allocation',
        'agency_disbursing_identifier_code',
        'agency_accounting_identifier',
        'funding_center_identifier',
        'cost_center_identifier',
        'project_identifier',
        'activity_identifier',
        'cost_element_code',
        'work_order_number',
        'functional_area'
    ];

    /**
     * Returns the Treasury reportable data
     *
     * @returns array
     */
    public function treasuryData()
    {
        $issueYear = 'XXXX';
        $closeYear = 'XXXX';

        if (is_null($this->availability_type)) {
            if (!isset($this->bpoa)) {
                throw new Exception("BPOA is not provided");
            }

            if (!isset($this->epoa)) {
                throw new Exception("EPOA is not provided");
            }

            $issueYear = $this->bpoa->year;
            $closeYear = $this->epoa->year;
        }

        return [
            'department_regular' => $this->department_regular,
            'department_transfer' => $this->department_transfer,
            'fiscal_year' => $issueYear . $closeYear,
            'main_account' => $this->main_account,
            'sub_allocation' => $this->sub_allocation
        ];
    }

    /**
     * Returns fiscal year in which funds expire
     */
    public function expiresInFiscalYear()
    {
        if (is_null($this->availability_type)) {
            if (!isset($this->epoa)) {
                throw new Exception("EPOA is not provided");
            }
            return $this->epoa->addYear(5);
        }
        return null;
    }

    /**
     * Identifies the accounting system of record referenced by the accounting line
     *
     * @return string
     */
    public function accountingSystemOfRecord()
    {
        return $this->agency_accounting_identifier;
    }

    /**
     * Creates a SLOA Accounting Line from the hat delimited string
     *
     * @return App\SloaAccountingLine
     */
    public static function fromHatDelimiter($strSloaData)
    {
        $sloa = (new static);

        $parsed = $sloa->parseSloaDelimited($strSloaData);

        return $sloa->create([
            'sub_class' => $parsed[0],
            'department_transfer' => $parsed[1],
            'department_regular' => $parsed[2],
            'bpoa' => Carbon::createFromDate((int)$parsed[3], 10, 1, 'America/New_York'),
            'epoa' => Carbon::createFromDate((int)$parsed[4], 9, 30, 'America/New_York'),
            'availability_type' => $parsed[5],
            'main_account' => $parsed[6],
            'sub_account' => $parsed[7],
            'business_event_type_code' => $parsed[8],
            'object_class' => $parsed[9],
            'reimbursable_flag' => $parsed[10],
            'budget_line_item' => $parsed[11],
            'security_cooperation' => $parsed[12],
            'security_cooperation_implementing_agency_code' => $parsed[13],
            'security_cooperation_case_designator' => $parsed[14],
            'security_cooperation_case_line_item_identifier' => $parsed[15],
            'sub_allocation' => $parsed[16],
            'agency_disbursing_identifier_code' => $parsed[17],
            'agency_accounting_identifier' => $parsed[18],
            'funding_center_identifier' => $parsed[19],
            'cost_center_identifier' => $parsed[20],
            'project_identifier' => $parsed[21],
            'activity_identifier' => $parsed[22],
            'cost_element_code' => $parsed[23],
            'work_order_number' => $parsed[24],
            'functional_area' => $parsed[25]
        ]);
    }

    /**
     * Parses hat delimited string of values into data elements
     *
     * @return array
     */
    protected function parseSloaDelimited($strSloaData)
    {
        /*
         * For some strange reason, they want to open with a delimiter
         *
         * This violates the basics of RFC-4180 that everyone seems to agree on
         *   field_0[delimiter]
         *   [delimiter]field_1
         *
         * No idea why they do this, but at least it's in the standard!
         *
         * http://dcmo.defense.gov/Portals/47/Documents/SFIS/SLoA_Accounting_Class_Memo.pdf
         *
         * See page 7, bullet 6
         */

        $strData = substr($strSloaData, 1, strlen($strSloaData));
        $delimited = explode('^', $strData);

        if (count($delimited) != 26) {
            throw new \Exception('The delimited string does not include 26 data elements');
        }

        foreach ($delimited as $key => $element) {
            $delimited[$key] = $this->swapZeroLengthStringWithNull($element);
        }

        return $delimited;
    }

    /**
     * Gracefully handle delimited string values with actual null elements
     */
    protected function swapZeroLengthStringWithNull($element)
    {
        if ($element === '') {
            return null;
        }
        return $element;
    }
}
