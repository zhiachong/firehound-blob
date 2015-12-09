<?php

namespace PaperG\FirehoundBlob\CampaignData;

class Targeting
{
    protected $geographic;

    //used for serialization
    CONST GEOGRAPHIC = "geographic";
    CONST VERSION = "version";

    CONST CURR_VERSION = 0;

    /**
     * @param null|CampaignGeoTargetingData $geographic
     */
    public function __construct(
        $geographic
    )
    {
        $this->geographic = $geographic;
    }

    public function toAssociativeArray()
    {
        $array = [
            self::VERSION => self::CURR_VERSION
        ];

        if ( isset($this->geographic) )
        {
            $array[self::GEOGRAPHIC] = $this->geographic->toAssociativeArray();
        }

        return $array;
    }

    public static function fromAssociativeArray($targetingArray)
    {
        $geographic = isset($targetingArray[self::GEOGRAPHIC]) ? new CampaignGeoTargetingData($targetingArray[self::GEOGRAPHIC]) : null;

        $targeting = new Targeting($geographic);
        return $targeting;
    }

    public function isValid()
    {
        //todo: flesh this out
        return true;
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
