<?php

namespace PaperG\Common\CampaignData;

class PlatformTargeting
{
    /* @var Boolean $desktop Whether to target desktop*/
    protected $desktop;

    /* @var Boolean $mobile Whether to target mobile*/
    protected $mobile;

    //used for serialization
    CONST DESKTOP = "desktop";
    CONST MOBILE = "mobile";
    CONST VERSION = "version";

    CONST CURR_VERSION = 0;

    public function __construct(
        $desktop,
        $mobile
    )
    {
        $this->desktop = $desktop;
        $this->mobile = $mobile;
    }

    public function toAssociativeArray()
    {
        return [
            self::DESKTOP => $this->desktop,
            self::MOBILE  => $this->mobile,
            self::VERSION => self::CURR_VERSION
        ];
    }

    public static function fromAssociativeArray($platformTargetingArray)
    {
        $desktop = isset($platformTargetingArray[self::DESKTOP]) ? boolval($platformTargetingArray[self::DESKTOP]) : false;
        $mobile = isset($platformTargetingArray[self::MOBILE]) ? boolval($platformTargetingArray[self::MOBILE]) : false;

        $platformTargeting = new PlatformTargeting($desktop, $mobile);
        return $platformTargeting;
    }

    public function isValid()
    {
        //should target at least one platform
        return $this->desktop || $this->mobile;
    }

    /**
     * @param boolean $desktop
     */
    public function setDesktop($desktop)
    {
        $this->desktop = $desktop;
    }

    /**
     * @return boolean
     */
    public function getDesktop()
    {
        return $this->desktop;
    }

    /**
     * @param boolean $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return boolean
     */
    public function getMobile()
    {
        return $this->mobile;
    }
}
