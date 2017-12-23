<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSloaAccountingLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * The descriptions for all of these fields have been taken directly from the SLOA memorandum openly available from DCMO
     * The author does not attest to the relevancy of the descriptions themselves, but includes them instead to reduce reference materials required for database analysis
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sloa_accounting_lines', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->string('sub_class', 2)
                ->nullable()
                ->comment('Grouping of a transaction type; a.k.a. Sub-level Prefix');
            $table->string('department_transfer', 3)
                ->nullable()
                ->comment('Transfer of obligation authority; a.k.a. Allocation Transfer Agency Identifier');
            $table->string('department_regular', 3)
                ->comment('Congressional Appropriation Owner');
            $table->dateTime('bpoa')
                ->nullable()
                ->index()
                ->coment('Beginning Period of Availability Fiscal Year Date');
            $table->dateTime('epoa')
                ->nullable()
                ->index()
                ->coment('Ending Period of Availability Fiscal Year Date');
            $table->string('availability_type', 1)
                ->nullable()
                ->comment('A24 in SFIS, e.g., X for no-year money');
            $table->string('main_account', 4)
                ->comment('Appropriation Symbol or Basic Symbol');
            $table->string('sub_account', 3)
                ->nullable()
                ->comment('Indicates the relationship to the Main Account');
            $table->string('business_event_type_code', 8)
                ->nullable()
                ->comment('Replaces Transaction Codes');
            $table->string('object_class', 6)
                ->nullable()
                ->comment('Will initially be implemented at the three-digit level as in SFIS with room to expand to six, e.g., 252');
            $table->string('reimbursable_flag', 1)
                ->nullable()
                ->comment('Direct, Reimbursable Code');
            $table->string('budget_line_item', 16)
                ->nullable()
                ->comment('Further sub-divides the Treasury Account Fund Symbol below sub-activity; a.k.a. Budget Sub-Activity BSA in MilPers');
            $table->string('security_cooperation', 3)
                ->nullable()
                ->comment('The country, customer, or U.S. program receiving the product/service');
            $table->string('security_cooperation_implementing_agency_code', 1)
                ->nullable()
                ->comment('Identifies the U.S. MILDEP or agency which is executing the FMS sale on behalf of the U.S. Government; e.g., B-Army, D-Air Force, P-Navy');
            $table->string('security_cooperation_case_designator', 4)
                ->nullable()
                ->comment('Identifies the FMS or Security Cooperation contractual sales agreement between countries');
            $table->string('security_cooperation_case_line_item_identifier', 3)
                ->nullable()
                ->comment('Security Cooperation (SC) Customer; Identifies a detailed line-item requirement');
            $table->string('sub_allocation', 4)
                ->nullable()
                ->comment('Use of this data element is exclusive to sub-allocation purposes, useful for Financial Reporting');
            $table->string('agency_disbursing_identifier_code', 8)
                ->nullable()
                ->comment('Synonymous with Treasury DSSN definitions for each disbursing office');
            $table->string('agency_accounting_identifier', 6)
                ->comment('Fiscal Station Number; Comptroller defined; Identifies the accounting system responsible for the accounting event');
            $table->string('funding_center_identifier', 16)
                ->nullable()
                ->comment('Cost Object/Cost Accounting (CA) section in SFIS; Army = Funds Center, ASN; Air Force = OAC, OBAN; Navy = BCN');
            $table->string('cost_center_identifier', 16)
                ->nullable()
                ->comment('CA section in SFIS; e.g., Army = Cost Center, ASN; Air Force = Resource Center/Cost Center (RC/CC); Navy = BCN');
            $table->string('project_identifier', 25)
                ->nullable()
                ->comment('CA section in SFIS; e.g., Army = WBS; Air Force = Project; Navy = WBS (Cost Code)');
            $table->string('activity_identifier', 16)
                ->nullable()
                ->comment('CA section in SFIS; e.g., Army = Activity/Network; Air Force = Activity or Special Project; Navy = Activity');
            $table->string('cost_element_code', 15)
                ->nullable()
                ->comment('CA section in SFIS; e.g., Army = Commitment Item; Air Force = Element of Expense Investment Code (EEIC); Navy = Cost Element ');
            $table->string('work_order_number', 16)
                ->nullable()
                ->comment('CCA section in SFIS; e.g., Army = Internal Order; Air Force = Job Order; Navy = Job Order (Cost Code)');
            $table->string('functional_area', 16)
                ->nullable()
                ->comment('CA section in SFIS; e.g., Army = Functional Area; Air Force = Budget/Project');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sloa_accounting_lines');
    }
}
