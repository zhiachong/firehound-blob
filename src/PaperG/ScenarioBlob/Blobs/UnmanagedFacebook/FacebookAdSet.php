<?php

namespace PaperG\ScenarioBlob\Blobs\UnmanagedFacebook;

class FacebookAdSet
{

    const OPTIMIZATION_GOAL = "optimizationGoal";
    const LIFETIME_BUDGET = "lifetimeBudget";
    const BID_AMOUNT = "bidAmount";
    const PLACEMENTS = "placements";
    const AD_SET_ID = "adSetId";
    const TYPE = "type";

    /**
     * @var int|null the ad set id if known
     */
    private $adSetId = null;

    /**
     * @var string from FacebookAds/Object/Values/AdObjectives
     */
    private $optimizationGoal;

    /**
     * @var int amount to bid in cents
     */
    private $bidAmount;

    /**
     * @var string[] from FacebookAds/Object/Values/PageTypes.  At least one must be provided, because otherwise we
     * have no easy way to differentiate our ad sets/placements
     */
    private $placements;

    /**
     * @var string
     */
    private $type;

    /**
     * @param int $bidAmount
     */
    public function setBidAmount($bidAmount)
    {
        $this->bidAmount = $bidAmount;
    }

    /**
     * @return int
     */
    public function getBidAmount()
    {
        return $this->bidAmount;
    }

    /**
     * @param string $optimizationGoal from FacebookAds/Object/Values/OptimizationGoals
     */
    public function setOptimizationGoal($optimizationGoal)
    {
        $this->optimizationGoal = $optimizationGoal;
    }

    /**
     * @return string
     */
    public function getOptimizationGoal()
    {
        return $this->optimizationGoal;
    }

    /**
     * @param string[] $placements Array of strings that should be from FacebookAds/Object/Values/PageTypes
     */
    public function setPlacements($placements)
    {
        $this->placements = $placements;
    }

    /**
     * @return string[]
     */
    public function getPlacements()
    {
        return $this->placements;
    }

    public function setAdSetId($adSetId)
    {
        $this->adSetId = $adSetId;
    }

    public function getAdSetId()
    {
        return $this->adSetId;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function toAssociativeArray()
    {
        return array(
            self::OPTIMIZATION_GOAL => $this->optimizationGoal,
            self::BID_AMOUNT => $this->bidAmount,
            self::PLACEMENTS => $this->placements,
            self::AD_SET_ID => $this->adSetId,
            self::TYPE => $this->type
        );
    }

    public function fromAssociativeArray($array)
    {
        $this->optimizationGoal = isset($array[self::OPTIMIZATION_GOAL]) ? $array[self::OPTIMIZATION_GOAL] : null;
        $this->bidAmount = isset($array[self::BID_AMOUNT]) ? $array[self::BID_AMOUNT] : null;
        $this->placements = isset($array[self::PLACEMENTS]) ? $array[self::PLACEMENTS] : null;
        $this->adSetId = isset($array[self::AD_SET_ID]) ? $array[self::AD_SET_ID] : null;
        $this->type = isset($array[self::TYPE]) ? $array[self::TYPE] : null;
    }

    /**
     * @param null|[] $validPlacements Typically the returned value from FacebookSDK
     * PageTypes::getInstance()->getValues()
     * @param null|[] $validOptimizationGoals Typically the returned value from FacebookSDK
     * OptimizationGoals::getInstance()->getValues()
     * @return bool
     */
    public function validate($validPlacements = null, $validOptimizationGoals = null)
    {
        $valid = $this->validatePlacements($validPlacements);
        $valid = $valid && $this->validateGoal($validOptimizationGoals);

        return $valid;
    }

    private function validatePlacements($validPlacements)
    {
        if (empty($validPlacements)) {
            return true;
        }

        $valid = !empty($this->placements);
        $valid = $valid && is_array($this->placements);
        if ($valid) {
            foreach ($this->placements as $placement) {
                $valid = $valid && in_array($placement, $validPlacements);
            }
        }

        return $valid;
    }

    private function validateGoal($validOptimizationGoals)
    {
        if (empty($validOptimizationGoals)) {
            return true;
        }

        return in_array($this->optimizationGoal, $validOptimizationGoals);
    }
}
