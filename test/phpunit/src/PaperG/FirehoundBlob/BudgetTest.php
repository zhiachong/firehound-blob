<?php

use PaperG\FirehoundBlob\CampaignData\Budget;

class BudgetTest extends \PHPUnit_Framework_TestCase
{
    public function test_getSetAmount_returnsCorrectly()
    {
        $mockAmount = 1;
        $mockNewAmount  = 2;
        $mockType = "mock";
        $budget = new Budget($mockAmount);
        $budget->setAmountType($mockType);
        $this->assertEquals($mockType, $budget->getAmountType());
        $this->assertFalse($budget->isValid());
        $budget->setAmount($mockNewAmount);
        $this->assertEquals($mockNewAmount, $budget->getAmount());
    }

    public function test_getSetAmountType_returnsCorrectly()
    {
        $mockAmount = 1;
        $mockType = "mock";
        $budget = new Budget($mockAmount);
        $budget->setAmountType($mockType);
        $this->assertEquals($mockType, $budget->getAmountType());
        $this->assertFalse($budget->isValid());
    }

    public function test_getSetBudgetType_returnsCorrectly()
    {
        $mockAmount = 1;
        $mockType = "lifetime";
        $budget = new Budget($mockAmount);
        $budget->setBudgetType($mockType);
        $this->assertEquals($mockType, $budget->getBudgetType());
    }

    public function test_isValid_returnsCorrectly()
    {
        $mockAmount  = 0;
        $budget = new Budget($mockAmount);
        $this->assertFalse($budget->isValid());
        $budget->setAmount(100);
        $this->assertTrue($budget->isValid());
    }

    public function test_toFromAssociativeArray_returnsCorrectly()
    {
        $mockAmount = 1;
        $mockAmountType = "dollars";
        $mockBudgetType = "daily";
        $mockArray = array(
            Budget::AMOUNT => $mockAmount,
            Budget::AMOUNT_TYPE => $mockAmountType,
            Budget::BUDGET_TYPE => $mockBudgetType
        );

        $budget = Budget::fromAssociativeArray($mockArray);
        $this->assertEquals($mockAmount, $budget->getAmount());
        $this->assertEquals($mockAmountType, $budget->getAmountType());
        $this->assertEquals($mockBudgetType, $budget->getBudgetType());

        $mockArray[Budget::VERSION] = Budget::CURR_VERSION;
        $this->assertEquals($mockArray, $budget->toAssociativeArray());
    }
}
