<?php

namespace PaperG\FirehoundBlob;

use PaperG\FirehoundBlob\CampaignData\Budget;
use PaperG\FirehoundBlob\CampaignData\Context;
use PaperG\FirehoundBlob\CampaignData\Creative;
use PaperG\FirehoundBlob\CampaignData\ExchangeTargeting;
use PaperG\FirehoundBlob\CampaignData\PlatformTargeting;
use PaperG\FirehoundBlob\CampaignData\Targeting;

class FirehoundBlob
{
    /* @var string $name A human readable name */
    protected $name = null;

    /* @var string $identifier Used to identify a campaign uniquely across all services */
    protected $identifier = null;

    /* @var int $startDate An int representing the timestamp of a \DateTime */
    protected $startDate = null;

    /* @var int $endDate An int representing the timestamp of a \DateTime */
    protected $endDate = null;

    /*
     * eg. array(
     *      "default" => array(
     *          "amount" => 100
     *          "amount_type" => "dollar"
     *          "type" => "lifetime"
     *      ),
     *      "feed" => array(
     *          "amount" => 123,
     *          "amount_type" => "impression",
     *          "type" => "daily"
     *      )
     * )
     * This example shows a $100 budget
     *
     * @var Budget[]|null $budget An array of Budgets
     */
    protected $budgets = null;

    /* @var Targeting $targeting An array of various types of targeting from demographics to geographic
     * eg.
     * [
     *   "geographic" => [
     *      "zip" => [12345,12346,123457]
     *      "region" => [1,2]
     *      "country" => [123]
     *   ],
     *   "demographic" => [1,2,3],
     *   "group" => [22,89]
     * ]
     *
     * This example shows some geographic targeting that has specific zip list, region list and country list.
     * It has a demographic targeting for some age and gender groups.
     * It has group targeting for some defined groups that map to different kinds of groups on various exchanges.
     */
    protected $targeting = null;

    /* @var Context $context An array of custom values that can be used for exchange specific actions or customizations */
    protected $context = null;

    /* @var PlatformTargeting $platformTargeting An array of various platforms to target
     * eg.
     * [
     *   "mobile" => true,
     *   "desktop" => true
     * ]
     */
    protected $platformTargeting = null;

    /* @var ExchangeTargeting $exchangeTargeting An array of various exchanges to target
     * eg.
     * [
     *   "AppNexus" => true,
     *   "Facebook" => true
     * ]
     */
    protected $exchangeTargeting = null;

    /**
     * @var null|CampaignData\Creative[]
     */
    protected $creatives = null;

    const CURRENT_VERSION = 2;

    //these values are used for serializing the blob
    const NAME = "name";
    const IDENTIFIER = "identifier";
    const START_DATE = "start_date";
    const END_DATE = "end_date";
    const BUDGETS = "budgets";
    const TARGETING = "targeting";
    const CONTEXT = "context";
    const PLATFORM_TARGETING = "platform_targeting";
    const EXCHANGE_TARGETING = "exchange_targeting";
    const CREATIVES = "creatives";
    const CREATIVE = "creative";
    const VERSION = "version";

    /**
     * @param String $name
     * @param String $identifier
     * @param int $startDate TimeStamp of date
     * @param int $endDate TimeStamp of date
     * @param Budget[] $budgets
     * @param Targeting $targeting
     * @param PlatformTargeting $platformTargeting
     * @param ExchangeTargeting $exchangeTargeting
     * @param Creative[] $creatives
     * @param null|Context $context
     */
    public function __construct(
        $name,
        $identifier,
        $startDate,
        $endDate,
        $budgets,
        $targeting,
        $platformTargeting,
        $exchangeTargeting,
        $creatives,
        $context = null
    ) {
        $this->name = $name;
        $this->identifier = $identifier;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->budgets = $budgets;
        $this->targeting = $targeting;
        $this->platformTargeting = $platformTargeting;
        $this->exchangeTargeting = $exchangeTargeting;
        $this->creatives = $creatives;

        //may not necessarily have any context
        $this->context = is_null($context) ? new Context() : $context;
    }

    public function toAssociativeArray()
    {
        $budgets = array();
        if (!is_null($this->budgets)) {

            foreach ($this->budgets as $key => $budget) {
                $budgets[$key] = $budget->toAssociativeArray();
            }
        }
        $array = array(
            self::NAME => isset($this->name) ? $this->name : null,
            self::IDENTIFIER => isset($this->identifier) ? $this->identifier : null,
            self::START_DATE => isset($this->startDate) ? $this->startDate : null,
            self::END_DATE => isset($this->endDate) ? $this->endDate : null,
            self::BUDGETS => isset($this->budgets) ? $budgets : null,
            self::TARGETING => isset($this->targeting) ? $this->targeting->toAssociativeArray() : null,
            self::CONTEXT => isset($this->context) ? $this->context->toAssociativeArray() : null,
            self::PLATFORM_TARGETING => isset($this->platformTargeting)
                    ? $this->platformTargeting->toAssociativeArray() : null,
            self::EXCHANGE_TARGETING => isset($this->exchangeTargeting)
                    ? $this->exchangeTargeting->toAssociativeArray() : null,
            self::CREATIVES => isset($this->creatives) ? $this->getCreativesAsArray() : null,
            self::VERSION => self::CURRENT_VERSION,
        );

        return $array;
    }

    private function getCreativesAsArray()
    {
        $creatives = null;
        if (is_array($this->creatives)) {
            $creatives = [];
            /**
             * @var $creative Creative
             */
            foreach ($this->creatives as $creative) {
                $creatives[] = $creative->toAssociativeArray();
            }
        }

        return $creatives;
    }

    public static function fromAssociativeArray($firehoundBlobArray)
    {
        $name = isset($firehoundBlobArray[self::NAME]) ? $firehoundBlobArray[self::NAME] : null;
        $identifier = isset($firehoundBlobArray[self::IDENTIFIER]) ? $firehoundBlobArray[self::IDENTIFIER] : null;
        $startDate = isset($firehoundBlobArray[self::START_DATE]) ? $firehoundBlobArray[self::START_DATE] : null;
        $endDate = isset($firehoundBlobArray[self::END_DATE]) ? $firehoundBlobArray[self::END_DATE] : null;
        $budgets = null;
        if (isset($firehoundBlobArray[self::BUDGETS]) && is_array($firehoundBlobArray[self::BUDGETS])) {
            $budgets = array();
            foreach ($firehoundBlobArray[self::BUDGETS] as $key => $budgetArray) {
                $budgets[$key] = Budget::fromAssociativeArray($budgetArray);
            }
        }
        $budget = is_array($budgets) ? $budgets : null;
        $targeting = isset($firehoundBlobArray[self::TARGETING]) ? Targeting::fromAssociativeArray(
            $firehoundBlobArray[self::TARGETING]
        ) : null;
        $platformTargeting = isset($firehoundBlobArray[self::PLATFORM_TARGETING]) ? PlatformTargeting::fromAssociativeArray(
            $firehoundBlobArray[self::PLATFORM_TARGETING]
        ) : null;
        $exchangeTargeting = isset($firehoundBlobArray[self::EXCHANGE_TARGETING]) ? ExchangeTargeting::fromAssociativeArray(
            $firehoundBlobArray[self::EXCHANGE_TARGETING]
        ) : null;
        $creative = self::getCreativeFromBlobArray($firehoundBlobArray);
        $context = isset($firehoundBlobArray[self::CONTEXT]) ? Context::fromAssociativeArray(
            $firehoundBlobArray[self::CONTEXT]
        ) : null;

        $firehoundBlob = new FirehoundBlob(
            $name,
            $identifier,
            $startDate,
            $endDate,
            $budget,
            $targeting,
            $platformTargeting,
            $exchangeTargeting,
            $creative,
            $context
        );

        return $firehoundBlob;
    }

    private static function  getCreativeFromBlobArray($array)
    {
        $creativeArray = null;
        if (isset($array[self::CREATIVES])) {
            $creatives = $array[self::CREATIVES];
            if (is_array($creatives)) {
                foreach ($creatives as $creative) {
                    if (is_array($creative)) {
                        $creativeArray[] = Creative::fromAssociativeArray($creative);
                    }
                }

                return $creativeArray;
            }
        }

        //support version 1
        if (isset($array[self::CREATIVE])) {
            $creative = Creative::fromAssociativeArray($array[self::CREATIVE]);
            $creativeArray = [$creative];
        }

        return $creativeArray;
    }

    public function isValid($checkValidForCreation, &$outErrorMessage)
    {
        if (empty($this->identifier)) {
            $outErrorMessage = "Identifier is missing";
            return false;
        }

        if (is_null($this->platformTargeting) || !$this->platformTargeting->isValid()) {
            $outErrorMessage = "Platform targeting is not completed or is invalid";
            return false;
        }

        if (is_null($this->exchangeTargeting) || !$this->exchangeTargeting->isValid()) {
            $outErrorMessage = "Exchange targeting is not completed or is invalid";
            return false;
        }


        if (true === $checkValidForCreation) {
            return $this->validateForCreation($outErrorMessage);
        } // else partial update

        //in a partial update, nulls are allowed
        if (!is_null($this->budgets)) {
            $validBudget = $this->validateBudget();

            if (!$validBudget) {
                $outErrorMessage = "Budget is invalid";
                return false;
            }
        }

        if (!is_null($this->targeting) && !$this->targeting->isValid()) {
            $outErrorMessage = "Targeting is invalid";
            return false;
        }

        if (!is_null($this->creatives) && !$this->hasValidCreatives()) {
            $outErrorMessage = "Creative is invalid";
            return false;
        }

        return true;
    }

    private function validateForCreation(&$outErrorMessage)
    {
        //for creation we need more values filled out
        $validBudget = $this->validateBudget();

        if (!$validBudget) {
            $outErrorMessage = "Budget is not completed or is invalid: " . print_r($this->budgets, true);
            return false;
        }

        if (is_null($this->targeting) || !$this->targeting->isValid()) {
            $outErrorMessage = "Targeting is not completed or is invalid";
            return false;
        }

        if (is_null($this->creatives) || !$this->hasValidCreatives()) {
            $outErrorMessage = "Creative is not completed or is invalid";
            return false;
        }

        return true;
    }

    /**
     * Creatives must be an array
     *
     * @return bool
     */
    private function hasValidCreatives()
    {
        if (is_array($this->creatives)) {
            /**
             * @var $creative Creative
             */
            foreach ($this->creatives as $creative) {
                if (!$creative->isValid()) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }

    /**
     * @param \PaperG\FirehoundBlob\CampaignData\Budget|null $budget
     */
    public function setBudget(Budget $budget = null)
    {
        $this->budgets[Budget::DEFAULT_KEY] = $budget;
    }


    /**
     * @return \PaperG\FirehoundBlob\CampaignData\Budget
     */
    public function getBudget()
    {
        return isset($this->budgets[Budget::DEFAULT_KEY]) ? $this->budgets[Budget::DEFAULT_KEY] : null;
    }

    public function getBudgets()
    {
        return $this->budgets;
    }

    /**
     * @param $key
     * @param Budget $budget
     */
    public function setBudgetByKey($key, Budget $budget)
    {
        $this->budgets[$key] = $budget;
    }

    /**
     * @param $key
     * @return null|Budget
     */
    public function getBudgetByKey($key)
    {
        if (isset($this->budgets[$key])) {
            return $this->budgets[$key];
        }

        return null;
    }

    /**
     * @param Context $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * @return Context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * A convenience function to avoid lengthy if statements when getting a context value which may or may not exist
     *
     * @param String $key A known key name for a value inside context
     * @return null|String
     */
    public function getContextByKey($key)
    {
        return $this->context->getValueByKey($key);
    }

    /**
     * A convenience function to set specific context values for the blob
     *
     * @param $key
     * @param $value
     */
    public function setContextByKey($key, $value)
    {
        $this->context->setValueByKey($key, $value);
    }

    /**
     * @return null|Creative
     */
    public function getCreative()
    {
        if (!empty($this->creatives)) {
            return $this->creatives[0];
        }

        return null;
    }

    /**
     * @param \PaperG\FirehoundBlob\CampaignData\Creative[] $creative
     */
    public function setCreatives($creative)
    {
        $this->creatives = $creative;
    }

    /**
     * @return \PaperG\FirehoundBlob\CampaignData\Creative[]
     */
    public function getCreatives()
    {
        return $this->creatives;
    }

    /**
     * @param int $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return int
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \PaperG\FirehoundBlob\CampaignData\ExchangeTargeting $exchangeTargeting
     */
    public function setExchangeTargeting($exchangeTargeting)
    {
        $this->exchangeTargeting = $exchangeTargeting;
    }

    /**
     * @return \PaperG\FirehoundBlob\CampaignData\ExchangeTargeting
     */
    public function getExchangeTargeting()
    {
        return $this->exchangeTargeting;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \PaperG\FirehoundBlob\CampaignData\PlatformTargeting $platformTargeting
     */
    public function setPlatformTargeting($platformTargeting)
    {
        $this->platformTargeting = $platformTargeting;
    }

    /**
     * @return \PaperG\FirehoundBlob\CampaignData\PlatformTargeting
     */
    public function getPlatformTargeting()
    {
        return $this->platformTargeting;
    }

    /**
     * @param int $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return int
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \PaperG\FirehoundBlob\CampaignData\Targeting|null $targeting
     */
    public function setTargeting($targeting)
    {
        $this->targeting = $targeting;
    }

    /**
     * @return \PaperG\FirehoundBlob\CampaignData\Targeting
     */
    public function getTargeting()
    {
        return $this->targeting;
    }

    /**
     * validateBudget treats null as invalid, but array() as valid
     *
     * @return bool
     */
    private function validateBudget()
    {
        $validBudget = false;
        if (is_array($this->budgets)) // null is generally an invalid budget
        {
            $validBudget = true;
            /**
             * @var $budget Budget
             */
            foreach ($this->budgets as $budget) {
                if (!is_null($budget) && !$budget->isValid()) {
                    $validBudget = false;
                    break;
                }
            }
        }

        return $validBudget;
    }
}
