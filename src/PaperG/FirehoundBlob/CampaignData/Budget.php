<?php

namespace PaperG\FirehoundBlob\CampaignData;

use PaperG\ScenarioBlob\BlobInterface;

class Budget implements BlobInterface
{
    CONST DEFAULT_KEY = "default";
    CONST MOBILE_KEY  = "mobile";

    CONST AMOUNT_TYPE_IMPRESSION    = "impression";
    CONST AMOUNT_TYPE_DOLLAR        = "dollar";

    CONST BUDGET_TYPE_LIFETIME  = "lifetime";
    CONST BUDGET_TYPE_DAILY     = "daily";

    /**
     * @var string $budgetType The type of budget, either daily or lifetime
     */
    protected $budgetType = null;

    /* @var int $amount The size of the budget with type determined separately */
    protected $amount = null;

    /* @var String $amountType The type of amount, current choices are impression or dollar amount */
    protected $amountType = null;

    //these values are used for serialization
    CONST AMOUNT = "amount";
    CONST AMOUNT_TYPE = "type";
    CONST BUDGET_TYPE = "budget_type";
    CONST VERSION = "version";
    CONST SETTINGS = "budgets";

    CONST CURR_VERSION = 0;

    public function __construct($amount, $amountType = null, $budgetType = null)
    {
        $this->amount = $amount;
        $this->amountType = isset($amountType) ? $amountType : self::AMOUNT_TYPE_IMPRESSION;
        $this->budgetType = isset($budgetType) ? $budgetType : self::BUDGET_TYPE_LIFETIME;
    }

    public function toAssociativeArray()
    {
        return [
            self::AMOUNT        => $this->amount,
            self::AMOUNT_TYPE   => $this->amountType,
            self::BUDGET_TYPE   => $this->budgetType,
            self::VERSION       => self::CURR_VERSION
        ];
    }

    public static function fromAssociativeArray($budgetArray)
    {
        $amount = isset($budgetArray[self::AMOUNT]) ? intval($budgetArray[self::AMOUNT]) : null;
        $amountType = isset($budgetArray[self::AMOUNT_TYPE]) ? $budgetArray[self::AMOUNT_TYPE] : null;
        $budgetType = isset($budgetArray[self::BUDGET_TYPE]) ? $budgetArray[self::BUDGET_TYPE] : null;

        $budget = new Budget($amount, $amountType, $budgetType);
        return $budget;
    }

    public function isValid()
    {
        return ($this->amount > 0)
            && ($this->amountType == self::AMOUNT_TYPE_IMPRESSION || $this->amountType == self::AMOUNT_TYPE_DOLLAR);
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param null|string $type
     */
    public function setAmountType($type)
    {
        $this->amountType = $type;
    }

    /**
     * @return null|string
     */
    public function getAmountType()
    {
        return $this->amountType;
    }

    /**
     * @param string $budgetType
     */
    public function setBudgetType($budgetType)
    {
        $this->budgetType = $budgetType;
    }

    /**
     * @return string
     */
    public function getBudgetType()
    {
        return $this->budgetType;
    }

    public function toArray()
    {
        return $this->toAssociativeArray();
    }

    public function fromArray($budgetArray)
    {
        $this->amount = isset($budgetArray[self::AMOUNT]) ? intval($budgetArray[self::AMOUNT]) : null;
        $this->amountType = isset($budgetArray[self::AMOUNT_TYPE]) ? $budgetArray[self::AMOUNT_TYPE] : null;
        $this->budgetType = isset($budgetArray[self::BUDGET_TYPE]) ? $budgetArray[self::BUDGET_TYPE] : null;

    }
}
