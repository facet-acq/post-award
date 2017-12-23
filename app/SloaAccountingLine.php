<?php

namespace App;

class SloaAccountingLine extends AccountingLine
{
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
            'fiscal_year' => $issueYear.$closeYear,
            'main_account' => $this->main_account,
            'sub_allocation' => $this->sub_allocation
        ];
    }

    public function expiresInFiscalYear()
    {
        return null;
    }

    public function accountingSystemOfRecord()
    {
        return $this->agency_accounting_identifier;
    }
}
