<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\SloaAccountingLine;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $sloaAccountingLine->funds()->create(['amount' => 100]);
        $this->assertNotNull($sloaAccountingLine->funds);
        $this->assertCount(1, $sloaAccountingLine->funds);
    }

    /** @test */
    public function it_tracks_the_sub_class()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['sub_class' => '46']);

        $this->assertNotNull($sloaAccountingLine->sub_class);
        $this->assertDatabaseHas('sloa_accounting_lines', ['sub_class' => $sloaAccountingLine->sub_class]);
    }

    /** @test */
    public function it_allows_the_sub_class_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['sub_class' => null]);

        $this->assertNull($sloaAccountingLine->sub_class);
        $this->assertDatabaseHas('sloa_accounting_lines', ['sub_class' => null]);
    }

    /** @test */
    public function it_tracks_the_department_transfer()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['department_transfer' => '11']);

        $this->assertNotNull($sloaAccountingLine->department_transfer);
        $this->assertDatabaseHas('sloa_accounting_lines', ['department_transfer' => $sloaAccountingLine->department_transfer]);
    }

    /** @test */
    public function it_allows_the_department_transfer_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['department_transfer' => null]);

        $this->assertNull($sloaAccountingLine->department_transfer);
        $this->assertDatabaseHas('sloa_accounting_lines', ['department_transfer' => null]);
    }

    /** @test */
    public function it_tracks_the_department_regular()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->department_regular);
        $this->assertDatabaseHas('sloa_accounting_lines', ['department_regular' => $sloaAccountingLine->department_regular]);
    }

    // TODO figure out how to assert that if you do pass null as department_regular an exception is thrown as an expected test

    /** @test */
    public function it_tracks_the_beginning_period_of_availability_fiscal_year_date()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->bpoa);
        $this->assertDatabaseHas('sloa_accounting_lines', ['bpoa' => $sloaAccountingLine->bpoa]);
    }

    /** @test */
    public function it_allows_the_beginning_period_of_availability_fiscal_year_date_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['bpoa' => null]);

        $this->assertNull($sloaAccountingLine->bpoa);
        $this->assertDatabaseHas('sloa_accounting_lines', ['bpoa' => $sloaAccountingLine->bpoa]);
    }

    /** @test */
    public function it_tracks_the_ending_period_of_availability_fiscal_year_date()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->epoa);
        $this->assertDatabaseHas('sloa_accounting_lines', ['epoa' => $sloaAccountingLine->epoa]);
    }

    /** @test */
    public function it_allows_the_ending_period_of_availability_fiscal_year_date_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['epoa' => null]);

        $this->assertNull($sloaAccountingLine->epoa);
        $this->assertDatabaseHas('sloa_accounting_lines', ['epoa' => $sloaAccountingLine->epoa]);
    }

    /** @test */
    public function it_tracks_the_availability_type()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['availability_type' => 'X']);

        $this->assertNotNull($sloaAccountingLine->availability_type);
        $this->assertDatabaseHas('sloa_accounting_lines', ['availability_type' => $sloaAccountingLine->availability_type]);
    }

    /** @test */
    public function it_allows_the_availability_type_to_be_null()
    {
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
    public function it_tracks_the_sub_account()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->sub_account);
        $this->assertDatabaseHas('sloa_accounting_lines', ['sub_account' => $sloaAccountingLine->sub_account]);
    }

    /** @test */
    public function it_allows_the_sub_account_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['sub_account' => null]);

        $this->assertNull($sloaAccountingLine->sub_account);
        $this->assertDatabaseHas('sloa_accounting_lines', ['sub_account' => $sloaAccountingLine->sub_account]);
    }

    /** @test */
    public function it_tracks_the_business_event_type_code()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->business_event_type_code);
        $this->assertDatabaseHas('sloa_accounting_lines', ['business_event_type_code' => $sloaAccountingLine->business_event_type_code]);
    }

    /** @test */
    public function it_allows_the_business_event_type_code_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['business_event_type_code' => null]);

        $this->assertNull($sloaAccountingLine->business_event_type_code);
        $this->assertDatabaseHas('sloa_accounting_lines', ['business_event_type_code' => $sloaAccountingLine->business_event_type_code]);
    }

    /** @test */
    public function it_tracks_the_object_class()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->object_class);
        $this->assertDatabaseHas('sloa_accounting_lines', ['object_class' => $sloaAccountingLine->object_class]);
    }

    /** @test */
    public function it_allows_the_object_class_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['object_class' => null]);

        $this->assertNull($sloaAccountingLine->object_class);
        $this->assertDatabaseHas('sloa_accounting_lines', ['object_class' => $sloaAccountingLine->object_class]);
    }

    /** @test */
    public function it_tracks_the_reimbursable_flag()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->reimbursable_flag);
        $this->assertDatabaseHas('sloa_accounting_lines', ['reimbursable_flag' => $sloaAccountingLine->reimbursable_flag]);
    }

    /** @test */
    public function it_allows_the_reimbursable_flag_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['reimbursable_flag' => null]);

        $this->assertNull($sloaAccountingLine->reimbursable_flag);
        $this->assertDatabaseHas('sloa_accounting_lines', ['reimbursable_flag' => $sloaAccountingLine->reimbursable_flag]);
    }

    /** @test */
    public function it_tracks_the_budget_line_item()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->budget_line_item);
        $this->assertDatabaseHas('sloa_accounting_lines', ['budget_line_item' => $sloaAccountingLine->budget_line_item]);
    }

    /** @test */
    public function it_allows_the_budget_line_item_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['budget_line_item' => null]);

        $this->assertNull($sloaAccountingLine->budget_line_item);
        $this->assertDatabaseHas('sloa_accounting_lines', ['budget_line_item' => $sloaAccountingLine->budget_line_item]);
    }

    /** @test */
    public function it_tracks_the_security_cooperation()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->security_cooperation);
        $this->assertDatabaseHas('sloa_accounting_lines', ['security_cooperation' => $sloaAccountingLine->security_cooperation]);
    }

    /** @test */
    public function it_allows_the_security_cooperation_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['security_cooperation' => null]);

        $this->assertNull($sloaAccountingLine->security_cooperation);
        $this->assertDatabaseHas('sloa_accounting_lines', ['security_cooperation' => $sloaAccountingLine->security_cooperation]);
    }

    /** @test */
    public function it_tracks_the_security_cooperation_implementing_agency_code()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->security_cooperation_implementing_agency_code);
        $this->assertDatabaseHas('sloa_accounting_lines', ['security_cooperation_implementing_agency_code' => $sloaAccountingLine->security_cooperation_implementing_agency_code]);
    }

    /** @test */
    public function it_allows_the_security_cooperation_implementing_agency_code_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['security_cooperation_implementing_agency_code' => null]);

        $this->assertNull($sloaAccountingLine->security_cooperation_implementing_agency_code);
        $this->assertDatabaseHas('sloa_accounting_lines', ['security_cooperation_implementing_agency_code' => $sloaAccountingLine->security_cooperation_implementing_agency_code]);
    }

    /** @test */
    public function it_tracks_the_security_cooperation_case_designator()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->security_cooperation_case_designator);
        $this->assertDatabaseHas('sloa_accounting_lines', ['security_cooperation_case_designator' => $sloaAccountingLine->security_cooperation_case_designator]);
    }

    /** @test */
    public function it_allows_the_security_cooperation_case_designator_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['security_cooperation_case_designator' => null]);

        $this->assertNull($sloaAccountingLine->security_cooperation_case_designator);
        $this->assertDatabaseHas('sloa_accounting_lines', ['security_cooperation_case_designator' => $sloaAccountingLine->security_cooperation_case_designator]);
    }

    /** @test */
    public function it_tracks_the_security_cooperation_case_line_item_identifier()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->security_cooperation_case_line_item_identifier);
        $this->assertDatabaseHas('sloa_accounting_lines', ['security_cooperation_case_line_item_identifier' => $sloaAccountingLine->security_cooperation_case_line_item_identifier]);
    }

    /** @test */
    public function it_allows_the_security_cooperation_case_line_item_identifier_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['security_cooperation_case_line_item_identifier' => null]);

        $this->assertNull($sloaAccountingLine->security_cooperation_case_line_item_identifier);
        $this->assertDatabaseHas('sloa_accounting_lines', ['security_cooperation_case_line_item_identifier' => $sloaAccountingLine->security_cooperation_case_line_item_identifier]);
    }

    /** @test */
    public function it_tracks_the_sub_allocation()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->sub_allocation);
        $this->assertDatabaseHas('sloa_accounting_lines', ['sub_allocation' => $sloaAccountingLine->sub_allocation]);
    }

    /** @test */
    public function it_allows_the_sub_allocation_to_be_null()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create(['sub_allocation' => null]);

        $this->assertNull($sloaAccountingLine->sub_allocation);
        $this->assertDatabaseHas('sloa_accounting_lines', ['sub_allocation' => $sloaAccountingLine->sub_allocation]);
    }

    /** @test */
    public function it_tracks_the_agency_disbursing_identifier_code()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->agency_disbursing_identifier_code);
        $this->assertDatabaseHas('sloa_accounting_lines', ['agency_disbursing_identifier_code' => $sloaAccountingLine->agency_disbursing_identifier_code]);
    }

    /** @test */
    public function it_allows_the_agency_disbursing_identifier_code_to_be_null()
    {
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
    public function it_tracks_the_funding_center_identifier()
    {
        $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

        $this->assertNotNull($sloaAccountingLine->funding_center_identifier);
        $this->assertDatabaseHas('sloa_accounting_lines', ['funding_center_identifier' => $sloaAccountingLine->funding_center_identifier]);
    }

    /** @test */
    public function it_allows_the_funding_center_identifier_to_be_null()
    {
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

    // TODO write a method that makes this thing a hat delimited string
}
