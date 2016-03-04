<?php

namespace PaperG\FirehoundBlob\CampaignData;

use PaperG\FirehoundBlob\CampaignData\Targeting\AudienceTargeting;

class Targeting
{
    /* @var CampaignGeoTargetingData $geographic */
    protected $geographic;

    /**
     * @var AudienceTargeting
     */
    protected $audienceTargeting;

    //used for serialization
    CONST GEOGRAPHIC = "geographic";
    CONST AUDIENCE_TARGETING = "audienceTargeting";
    CONST VERSION = "version";

    CONST CURR_VERSION = 0;

    /**
     * @param null|CampaignGeoTargetingData $geographic
     * @param null|AudienceTargeting $audienceTargeting
     */
    public function __construct(
        $geographic,
        $audienceTargeting = null
    )
    {
        $this->geographic = $geographic;
        $this->audienceTargeting = $audienceTargeting;
    }

    public function toAssociativeArray()
    {
        $array = [
            self::VERSION => self::CURR_VERSION
        ];

        if (isset($this->geographic)) {
            $array[self::GEOGRAPHIC] = $this->geographic->toAssociativeArray();
        }

        if (isset($this->audienceTargeting)) {
            $array[self::AUDIENCE_TARGETING] = $this->audienceTargeting->toAssociativeArray();
        }

        return $array;
    }

    public static function fromAssociativeArray($targetingArray)
    {
        $geographic = isset($targetingArray[self::GEOGRAPHIC])
            ? new CampaignGeoTargetingData($targetingArray[self::GEOGRAPHIC]) : null;
        $audienceTargeting = isset($targetingArray[self::AUDIENCE_TARGETING])
            ? new AudienceTargeting($targetingArray[self::AUDIENCE_TARGETING]) : null;

        $targeting = new Targeting($geographic, $audienceTargeting);
        return $targeting;
    }

    public function isValid()
    {
        //todo: flesh this out
        return true;
    }

    public function setAudienceTargeting(AudienceTargeting $audience)
    {
        $this->audienceTargeting = $audience;
    }

    public function getAudienceTargeting()
    {
        return $this->audienceTargeting;
    }

    /**
     * @param CampaignGeoTargetingData $geographic
     */
    public function setGeographic(CampaignGeoTargetingData $geographic)
    {
        $this->geographic = $geographic;
    }

    /**
     * @return null|CampaignGeoTargetingData
     */
    public function getGeographic()
    {
        return $this->geographic;
    }
}
