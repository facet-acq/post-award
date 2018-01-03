<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\SloaAccountingLine;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

/**
 * @SuppressWarnings(PHPMD.ExcessiveMethods)
 */
class SloaAccountingLineTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_adds_a_guid_to_each_fund_as_the_id()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->uuid);
        $this->assertEquals(36, strlen($sloaAccountingLine->uuid));
    }

    /** @test */
    public function it_can_identify_its_supporting_fund()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->funds);
        $this->assertCount(1, $sloaAccountingLine->funds);
        $this->assertEquals($sloaAccountingLine->uuid, $sloaAccountingLine->funds->first()->accountable_id);
    }

    /** @test */
    public function it_tracks_the_sub_class_and_allows_it_to_be_null()
    {
        // Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['sub_class' => '46']);
        $this->assertNotNull($sloaAccountingLine->sub_class);
        $this->assertDatabaseHas('sloa_accounting_lines', ['sub_class' => $sloaAccountingLine->sub_class]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['sub_class' => null]);
        $this->assertNull($sloaAccountingLine->sub_class);
        $this->assertDatabaseHas('sloa_accounting_lines', ['sub_class' => null]);
    }

    /** @test */
    public function it_tracks_the_department_transfer_and_allows_it_to_be_null()
    {
        // Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['department_transfer' => '11']);
        $this->assertNotNull($sloaAccountingLine->department_transfer);
        $this->assertDatabaseHas('sloa_accounting_lines', ['department_transfer' => $sloaAccountingLine->department_transfer]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['department_transfer' => null]);
        $this->assertNull($sloaAccountingLine->department_transfer);
        $this->assertDatabaseHas('sloa_accounting_lines', ['department_transfer' => null]);
    }

    /** @test */
    public function it_tracks_the_department_regular()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->department_regular);
        $this->assertDatabaseHas('sloa_accounting_lines', [
            'department_regular' => $sloaAccountingLine->department_regular
        ]);
    }

    /** @test */
    public function it_tracks_the_beginning_period_of_availability_fiscal_year_date_and_allows_it_to_be_null()
    {
        // Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->bpoa);
        $this->assertDatabaseHas('sloa_accounting_lines', ['bpoa' => $sloaAccountingLine->bpoa]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['bpoa' => null]);
        $this->assertNull($sloaAccountingLine->bpoa);
        $this->assertDatabaseHas('sloa_accounting_lines', ['bpoa' => $sloaAccountingLine->bpoa]);
    }

    /** @test */
    public function it_tracks_the_ending_period_of_availability_fiscal_year_date_and_allows_it_to_be_null()
    {
        // Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->epoa);
        $this->assertDatabaseHas('sloa_accounting_lines', ['epoa' => $sloaAccountingLine->epoa]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['epoa' => null]);
        $this->assertNull($sloaAccountingLine->epoa);
        $this->assertDatabaseHas('sloa_accounting_lines', ['epoa' => $sloaAccountingLine->epoa]);
    }

    /** @test */
    public function it_tracks_the_availability_type_and_allows_it_to_be_null()
    {
        // Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['availability_type' => 'X']);
        $this->assertNotNull($sloaAccountingLine->availability_type);
        $this->assertDatabaseHas('sloa_accounting_lines', ['availability_type' => $sloaAccountingLine->availability_type]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['availability_type' => null]);
        $this->assertNull($sloaAccountingLine->availability_type);
        $this->assertDatabaseHas('sloa_accounting_lines', ['availability_type' => $sloaAccountingLine->availability_type]);
    }

    /** @test */
    public function it_tracks_the_main_account()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->main_account);
        $this->assertDatabaseHas('sloa_accounting_lines', ['main_account' => $sloaAccountingLine->main_account]);
    }

    /** @test */
    public function it_tracks_the_sub_account_and_allows_it_to_be_null()
    {
        // Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->sub_account);
        $this->assertDatabaseHas('sloa_accounting_lines', ['sub_account' => $sloaAccountingLine->sub_account]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['sub_account' => null]);
        $this->assertNull($sloaAccountingLine->sub_account);
        $this->assertDatabaseHas('sloa_accounting_lines', ['sub_account' => $sloaAccountingLine->sub_account]);
    }

    /** @test */
    public function it_tracks_the_business_event_type_code_and_allows_it_to_be_null()
    {
        // Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->business_event_type_code);
        $this->assertDatabaseHas('sloa_accounting_lines', ['business_event_type_code' => $sloaAccountingLine->business_event_type_code]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['business_event_type_code' => null]);
        $this->assertNull($sloaAccountingLine->business_event_type_code);
        $this->assertDatabaseHas('sloa_accounting_lines', ['business_event_type_code' => $sloaAccountingLine->business_event_type_code]);
    }

    /** @test */
    public function it_tracks_the_object_class_and_allows_it_to_be_null()
    {
        // Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->object_class);
        $this->assertDatabaseHas('sloa_accounting_lines', ['object_class' => $sloaAccountingLine->object_class]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['object_class' => null]);
        $this->assertNull($sloaAccountingLine->object_class);
        $this->assertDatabaseHas('sloa_accounting_lines', ['object_class' => $sloaAccountingLine->object_class]);
    }

    /** @test */
    public function it_tracks_the_reimbursable_flag_and_allows_it_to_be_null()
    {
        // Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->reimbursable_flag);
        $this->assertDatabaseHas('sloa_accounting_lines', ['reimbursable_flag' => $sloaAccountingLine->reimbursable_flag]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['reimbursable_flag' => null]);
        $this->assertNull($sloaAccountingLine->reimbursable_flag);
        $this->assertDatabaseHas('sloa_accounting_lines', ['reimbursable_flag' => $sloaAccountingLine->reimbursable_flag]);
    }

    /** @test */
    public function it_tracks_the_budget_line_item_and_allows_it_to_be_null()
    {
        // Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->budget_line_item);
        $this->assertDatabaseHas('sloa_accounting_lines', ['budget_line_item' => $sloaAccountingLine->budget_line_item]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['budget_line_item' => null]);
        $this->assertNull($sloaAccountingLine->budget_line_item);
        $this->assertDatabaseHas('sloa_accounting_lines', ['budget_line_item' => $sloaAccountingLine->budget_line_item]);
    }

    /** @test */
    public function it_tracks_the_security_cooperation_and_allows_it_to_be_null()
    {
        // Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->security_cooperation);
        $this->assertDatabaseHas('sloa_accounting_lines', ['security_cooperation' => $sloaAccountingLine->security_cooperation]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['security_cooperation' => null]);
        $this->assertNull($sloaAccountingLine->security_cooperation);
        $this->assertDatabaseHas('sloa_accounting_lines', ['security_cooperation' => $sloaAccountingLine->security_cooperation]);
    }

    /** @test */
    public function it_tracks_the_security_cooperation_implementing_agency_code_and_allows_it_to_be_null()
    {
        //Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->security_cooperation_implementing_agency_code);
        $this->assertDatabaseHas('sloa_accounting_lines', ['security_cooperation_implementing_agency_code' => $sloaAccountingLine->security_cooperation_implementing_agency_code]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['security_cooperation_implementing_agency_code' => null]);
        $this->assertNull($sloaAccountingLine->security_cooperation_implementing_agency_code);
        $this->assertDatabaseHas('sloa_accounting_lines', ['security_cooperation_implementing_agency_code' => $sloaAccountingLine->security_cooperation_implementing_agency_code]);
    }

    /** @test */
    public function it_tracks_the_security_cooperation_case_designator_and_allows_it_to_be_null()
    {
        // Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->security_cooperation_case_designator);
        $this->assertDatabaseHas('sloa_accounting_lines', ['security_cooperation_case_designator' => $sloaAccountingLine->security_cooperation_case_designator]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['security_cooperation_case_designator' => null]);
        $this->assertNull($sloaAccountingLine->security_cooperation_case_designator);
        $this->assertDatabaseHas('sloa_accounting_lines', ['security_cooperation_case_designator' => $sloaAccountingLine->security_cooperation_case_designator]);
    }

    /** @test */
    public function it_tracks_the_security_cooperation_case_line_item_identifier_and_allows_it_to_be_null()
    {
        // Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->security_cooperation_case_line_item_identifier);
        $this->assertDatabaseHas('sloa_accounting_lines', ['security_cooperation_case_line_item_identifier' => $sloaAccountingLine->security_cooperation_case_line_item_identifier]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['security_cooperation_case_line_item_identifier' => null]);
        $this->assertNull($sloaAccountingLine->security_cooperation_case_line_item_identifier);
        $this->assertDatabaseHas('sloa_accounting_lines', ['security_cooperation_case_line_item_identifier' => $sloaAccountingLine->security_cooperation_case_line_item_identifier]);
    }

    /** @test */
    public function it_tracks_the_sub_allocation_and_allow_it_to_be_null()
    {
        // Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->sub_allocation);
        $this->assertDatabaseHas('sloa_accounting_lines', ['sub_allocation' => $sloaAccountingLine->sub_allocation]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['sub_allocation' => null]);
        $this->assertNull($sloaAccountingLine->sub_allocation);
        $this->assertDatabaseHas('sloa_accounting_lines', ['sub_allocation' => $sloaAccountingLine->sub_allocation]);
    }

    /** @test */
    public function it_tracks_the_agency_disbursing_identifier_code_and_allow_it_to_be_null()
    {
        // Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->agency_disbursing_identifier_code);
        $this->assertDatabaseHas('sloa_accounting_lines', ['agency_disbursing_identifier_code' => $sloaAccountingLine->agency_disbursing_identifier_code]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['agency_disbursing_identifier_code' => null]);
        $this->assertNull($sloaAccountingLine->agency_disbursing_identifier_code);
        $this->assertDatabaseHas('sloa_accounting_lines', ['agency_disbursing_identifier_code' => $sloaAccountingLine->agency_disbursing_identifier_code]);
    }

    /** @test */
    public function it_tracks_the_agency_accounting_identifier()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->agency_accounting_identifier);
        $this->assertDatabaseHas('sloa_accounting_lines', ['agency_accounting_identifier' => $sloaAccountingLine->agency_accounting_identifier]);
    }

    // TODO write a test to make sure this isn't null

    /** @test */
    public function it_tracks_the_funding_center_identifier_and_allow_it_to_be_null()
    {
        //Tracking
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();
        $this->assertNotNull($sloaAccountingLine->funding_center_identifier);
        $this->assertDatabaseHas('sloa_accounting_lines', ['funding_center_identifier' => $sloaAccountingLine->funding_center_identifier]);

        // Nullable
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['funding_center_identifier' => null]);
        $this->assertNull($sloaAccountingLine->funding_center_identifier);
        $this->assertDatabaseHas('sloa_accounting_lines', ['funding_center_identifier' => $sloaAccountingLine->funding_center_identifier]);
    }

    /** @test */
    public function it_tracks_the_cost_center_identifier()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->cost_center_identifier);
        $this->assertDatabaseHas('sloa_accounting_lines', ['cost_center_identifier' => $sloaAccountingLine->cost_center_identifier]);
    }

    /** @test */
    public function it_allows_the_cost_center_identifier_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['cost_center_identifier' => null]);

        $this->assertNull($sloaAccountingLine->cost_center_identifier);
        $this->assertDatabaseHas('sloa_accounting_lines', ['cost_center_identifier' => $sloaAccountingLine->cost_center_identifier]);
    }

    /** @test */
    public function it_tracks_the_project_identifier()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->project_identifier);
        $this->assertDatabaseHas('sloa_accounting_lines', ['project_identifier' => $sloaAccountingLine->project_identifier]);
    }

    /** @test */
    public function it_allows_the_project_identifier_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['project_identifier' => null]);

        $this->assertNull($sloaAccountingLine->project_identifier);
        $this->assertDatabaseHas('sloa_accounting_lines', ['project_identifier' => $sloaAccountingLine->project_identifier]);
    }

    /** @test */
    public function it_tracks_the_activity_identifier()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->activity_identifier);
        $this->assertDatabaseHas('sloa_accounting_lines', ['activity_identifier' => $sloaAccountingLine->activity_identifier]);
    }

    /** @test */
    public function it_allows_the_activity_identifier_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['activity_identifier' => null]);

        $this->assertNull($sloaAccountingLine->activity_identifier);
        $this->assertDatabaseHas('sloa_accounting_lines', ['activity_identifier' => $sloaAccountingLine->activity_identifier]);
    }

    /** @test */
    public function it_tracks_the_cost_element_code()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->cost_element_code);
        $this->assertDatabaseHas('sloa_accounting_lines', ['cost_element_code' => $sloaAccountingLine->cost_element_code]);
    }

    /** @test */
    public function it_allows_the_cost_element_code_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['cost_element_code' => null]);

        $this->assertNull($sloaAccountingLine->cost_element_code);
        $this->assertDatabaseHas('sloa_accounting_lines', ['cost_element_code' => $sloaAccountingLine->cost_element_code]);
    }

    /** @test */
    public function it_tracks_the_work_order_number()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->work_order_number);
        $this->assertDatabaseHas('sloa_accounting_lines', ['work_order_number' => $sloaAccountingLine->work_order_number]);
    }

    /** @test */
    public function it_allows_the_work_order_number_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['work_order_number' => null]);

        $this->assertNull($sloaAccountingLine->work_order_number);
        $this->assertDatabaseHas('sloa_accounting_lines', ['work_order_number' => $sloaAccountingLine->work_order_number]);
    }

    /** @test */
    public function it_tracks_the_functional_area()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->functional_area);
        $this->assertDatabaseHas('sloa_accounting_lines', ['functional_area' => $sloaAccountingLine->functional_area]);
    }

    /** @test */
    public function it_allows_the_functional_area_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['functional_area' => null]);

        $this->assertNull($sloaAccountingLine->functional_area);
        $this->assertDatabaseHas('sloa_accounting_lines', ['functional_area' => $sloaAccountingLine->functional_area]);
    }

    /** @test */
    public function it_returns_the_accounting_system_of_record()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->accountingSystemOfRecord());
        $this->assertEquals($sloaAccountingLine->agency_accounting_identifier, $sloaAccountingLine->accountingSystemOfRecord());
    }

    /** @test */
    public function it_returns_the_treasury_data()
    {
        // Given a SLOA Working Capital Fund
        $workingCapitalLine = factory(SloaAccountingLine::class)->create([
            'bpoa' => null,
            'epoa' => null,
            'availability_type' => 'X'
        ]);

        // The working capital fund should populate fiscal year as 'X' signifying perpetuality
        $expectedTreasuryData = [
            "department_regular" => $workingCapitalLine->department_regular,
            "department_transfer" => $workingCapitalLine->department_transfer,
            "fiscal_year" => "XXXXXXXX",
            "main_account" => $workingCapitalLine->main_account,
            "sub_allocation" => $workingCapitalLine->sub_allocation
        ];

        // When treasury data is requested
        $treasuryData = $workingCapitalLine->treasuryData();
        // Then the expected treasury elements should be returned as an array
        $this->assertEquals($expectedTreasuryData, $treasuryData);

        // Given a SLOA General Appropriations Fund
        $generalFundsLine = factory(SloaAccountingLine::class)->create();

        // The general fund should populate fiscal year as a concatenation of beginning and ending years
        $expectedTreasuryData = [
            "department_regular" => $generalFundsLine->department_regular,
            "department_transfer" => $generalFundsLine->department_transfer,
            "fiscal_year" => $generalFundsLine->bpoa->year . $generalFundsLine->epoa->year,
            "main_account" => $generalFundsLine->main_account,
            "sub_allocation" => $generalFundsLine->sub_allocation
        ];

        // When treasury data is requested
        $treasuryData = $generalFundsLine->treasuryData();
        // Then the expected treasury elements should be returned as an array
        $this->assertEquals($expectedTreasuryData, $treasuryData);
    }

    /** @test */
    public function it_parses_the_hat_delimited_format()
    {
        $strSloaData = "^^^097^2018^2020^^0400^002^DISB^252^R^111^^^^^2504^1700^021001^^^^^^^";

        SloaAccountingLine::fromHatDelimiter($strSloaData);

        $this->assertDatabaseHas('sloa_accounting_lines', [
            'sub_class' => null,
            'department_transfer' => null,
            'department_regular' => '097',
            'bpoa' => Carbon::createFromDate(2018, 10, 1, 'America/New_York'),
            'epoa' => Carbon::createFromDate(2020, 9, 30, 'America/New_York'),
            'availability_type' => null,
            'main_account' => '0400',
            'sub_account' => '002',
            'business_event_type_code' => 'DISB',
            'object_class' => '252',
            'reimbursable_flag' => 'R',
            'budget_line_item' => '111',
            'security_cooperation' => null,
            'security_cooperation_implementing_agency_code' => null,
            'security_cooperation_case_designator' => null,
            'security_cooperation_case_line_item_identifier' => null,
            'sub_allocation' => '2504',
            'agency_disbursing_identifier_code' =>'1700',
            'agency_accounting_identifier' => '021001',
            'funding_center_identifier' => null,
            'cost_center_identifier' => null,
            'project_identifier' => null,
            'activity_identifier' => null,
            'cost_element_code' => null,
            'work_order_number' => null,
            'functional_area' => null
        ]);
    }
}
