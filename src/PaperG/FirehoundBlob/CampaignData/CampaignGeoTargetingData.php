<?php
/**
 *
 * Author: zhiachong (zTime)
 * Time: 10/9/14 - 2:06 PM
 * Filename: CampaignGeoTargetingData.php
 *
 * This is a wrapper class responsible for wrapping up all the campaign geo targeting data.
 */

namespace PaperG\FirehoundBlob\CampaignData;

// TODO: remove city targets from this class completely and rely on city_target_ids instead
class CampaignGeoTargetingData
{
    private $regionAction;
    private $regionTargets;
    private $zipAction;
    private $zipTargets;
    private $countryAction;
    private $countryTargets;
    private $dmaAction;
    private $dmaTargets;
    private $cityAction;
    private $cityTargets;
    private $cityTargetIds;

    const REGION_ACTION   = "region_action";
    const REGION_TARGETS  = "region_targets";
    const ZIP_ACTION      = "zip_action";
    const ZIP_TARGETS     = "zip_targets";
    const COUNTRY_ACTION  = "country_action";
    const COUNTRY_TARGETS = "country_targets";
    const DMA_ACTION      = "dma_action";
    const DMA_TARGETS     = "dma_targets";
    const CITY_ACTION     = "city_action";
    const CITY_TARGETS    = "city_targets";
    const CITY_TARGET_IDS = "city_target_ids";
    const INCLUDE_ACTION  = 'include';

    public function __construct($campaignGeoTargetingObj = null)
    {
        if (!is_array($campaignGeoTargetingObj))
        {
            $campaignGeoTargetingObj = (array)$campaignGeoTargetingObj;
        }

        if (!empty($campaignGeoTargetingObj))
        {
            $this->fromAssociativeArray($campaignGeoTargetingObj);
        }
    }

    /**
     * Returns a generic list of city target IDs of the form array(1,2,3,4)
     * @return array
     */
    public function getCityTargetIds()
    {
        return $this->cityTargetIds;
    }

    /**
     * Expects a list of array of city target IDs of the form array(1,2,3,4)
     * @param array $cityTargetIds
     */
    public function setCityTargetIds($cityTargetIds)
    {
        $this->cityTargetIds = $cityTargetIds;
    }

    /**
     * @return mixed
     */
    public function getCityAction()
    {
        return $this->cityAction;
    }

    /**
     * @param mixed $cityAction
     */
    public function setCityAction($cityAction)
    {
        $this->cityAction = $cityAction;
    }

    /**
     * @return mixed
     */
    public function getCityTargets()
    {
        return $this->cityTargets;
    }

    /**
     * @param mixed $cityTargets
     */
    public function setCityTargets($cityTargets)
    {
        $this->cityTargets = $cityTargets;
    }

    /**
     * @return mixed
     */
    public function getCountryAction()
    {
        return $this->countryAction;
    }

    /**
     * @param mixed $countryAction
     */
    public function setCountryAction($countryAction)
    {
        $this->countryAction = $countryAction;
    }

    /**
     * @return mixed
     */
    public function getCountryTargets()
    {
        return $this->countryTargets;
    }

    /**
     * @param mixed $countryTargets
     */
    public function setCountryTargets($countryTargets)
    {
        $this->countryTargets = $countryTargets;
    }

    /**
     * @return mixed
     */
    public function getDmaAction()
    {
        return $this->dmaAction;
    }

    /**
     * @param mixed $dmaAction
     */
    public function setDmaAction($dmaAction)
    {
        $this->dmaAction = $dmaAction;
    }

    /**
     * @return mixed
     */
    public function getDmaTargets()
    {
        return $this->dmaTargets;
    }

    /**
     * @param mixed $dmaTargets
     */
    public function setDmaTargets($dmaTargets)
    {
        $this->dmaTargets = $dmaTargets;
    }

    /**
     * @return mixed
     */
    public function getRegionAction()
    {
        return $this->regionAction;
    }

    /**
     * @param mixed $regionAction
     */
    public function setRegionAction($regionAction)
    {
        $this->regionAction = $regionAction;
    }

    /**
     * @return mixed (array of objects with 'region' => 'country_code_ae:region_code')
     */
    public function getRegionTargets()
    {
        return $this->regionTargets;
    }

    /**
     * @param mixed $regionTargets
     */
    public function setRegionTargets($regionTargets)
    {
        $this->regionTargets = $regionTargets;
    }

    /**
     * @return mixed
     */
    public function getZipAction()
    {
        return $this->zipAction;
    }

    /**
     * @param mixed $zipAction
     */
    public function setZipAction($zipAction)
    {
        $this->zipAction = $zipAction;
    }

    /**
     * @return array of objects having from_zip and to_zip properties
     */
    public function getZipTargets()
    {
        return $this->zipTargets;
    }

    /**
     * @param mixed $zipTargets
     */
    public function setZipTargets($zipTargets)
    {
        $this->zipTargets = $zipTargets;
    }


    public function toAssociativeArray()
    {
        return array(
            self::REGION_ACTION   => $this->regionAction,
            self::REGION_TARGETS  => $this->regionTargets,
            self::ZIP_ACTION      => $this->zipAction,
            self::ZIP_TARGETS     => $this->zipTargets,
            self::COUNTRY_ACTION  => $this->countryAction,
            self::COUNTRY_TARGETS => $this->countryTargets,
            self::DMA_ACTION      => $this->dmaAction,
            self::DMA_TARGETS     => $this->dmaTargets,
            self::CITY_ACTION     => $this->cityAction,
            self::CITY_TARGETS    => $this->cityTargets,
            self::CITY_TARGET_IDS => $this->cityTargetIds
        );
    }

    public function fromAssociativeArray($campaignGeoTargetingObj)
    {
        if (!empty($campaignGeoTargetingObj))
        {
            $this->regionAction = isset($campaignGeoTargetingObj[self::REGION_ACTION])
                ? $campaignGeoTargetingObj[self::REGION_ACTION] : null;

            if (isset($campaignGeoTargetingObj[self::REGION_TARGETS]))
            {
                $this->regionTargets = $campaignGeoTargetingObj[self::REGION_TARGETS];
            }

            if (isset($campaignGeoTargetingObj[self::ZIP_ACTION]))
            {
                $this->zipAction = $campaignGeoTargetingObj[self::ZIP_ACTION];
            }

            if (isset($campaignGeoTargetingObj[self::ZIP_TARGETS]))
            {
                $this->zipTargets = $campaignGeoTargetingObj[self::ZIP_TARGETS];
            }

            if (isset($campaignGeoTargetingObj[self::COUNTRY_ACTION]))
            {
                $this->countryAction = $campaignGeoTargetingObj[self::COUNTRY_ACTION];
            }

            if (isset($campaignGeoTargetingObj[self::COUNTRY_TARGETS]))
            {
                $this->countryTargets = $campaignGeoTargetingObj[self::COUNTRY_TARGETS];
            }

            if (isset($campaignGeoTargetingObj[self::DMA_ACTION]))
            {
                $this->dmaAction = $campaignGeoTargetingObj[self::DMA_ACTION];
            }

            if (isset($campaignGeoTargetingObj[self::DMA_TARGETS]))
            {
                $this->dmaTargets = $campaignGeoTargetingObj[self::DMA_TARGETS];
            }

            if (isset($campaignGeoTargetingObj[self::CITY_ACTION]))
            {
                $this->cityAction = $campaignGeoTargetingObj[self::CITY_ACTION];
            }

            if (isset($campaignGeoTargetingObj[self::CITY_TARGETS]))
            {
                $this->cityTargets = $campaignGeoTargetingObj[self::CITY_TARGETS];
            }

            if (isset($campaignGeoTargetingObj[self::CITY_TARGET_IDS]))
            {
                $this->cityTargetIds = $campaignGeoTargetingObj[self::CITY_TARGET_IDS];
            }
        }
    }
}

