<?php
/**
 * Created by PhpStorm.
 * User: allentsai
 * Date: 11/18/15
 * Time: 6:20 PM
 */

namespace PaperG\Common\CampaignData\Context;

use FacebookAds\Object\Campaign;
use PaperG\Facebook\FacebookAdSet;

class FacebookContext
{

    const AD_ACCOUNT_ID = "adAccountId";
    const AD_SETS = "adSets";
    const PAGE_ID = "pageId";
    const ACCESS_TOKEN = "accessToken";

    private $adAccountId;
    private $pageId;
    private $accessToken;

    /**
     * @var FacebookAdSet[]
     */
    private $adSets;

    public function setPageId($pageId)
    {
        $this->pageId = $pageId;
    }

    public function setAdAccountId($adAccountId)
    {
        $this->adAccountId = $adAccountId;
    }

    public function getAdAccountId()
    {
        return $this->adAccountId;
    }

    public function getPageId()
    {
        return $this->pageId;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @param $adSets FacebookAdSet[]
     */
    public function setAdSets($adSets)
    {
        $this->adSets = $adSets;
    }

    public function getAdSets()
    {
        return $this->adSets;
    }

    public function toAssociativeArray()
    {
        $adSets = array();

        foreach ($this->adSets as $adSet) {
            $adSets[] = $adSet->toAssociativeArray();
        }

        return array(
            self::AD_ACCOUNT_ID => $this->adAccountId,
            self::AD_SETS => $adSets,
            self::PAGE_ID => $this->pageId,
            self::ACCESS_TOKEN => $this->accessToken
        );
    }

    public function fromAssociativeArray($array)
    {
        $this->adAccountId = isset($array[self::AD_ACCOUNT_ID]) ? $array[self::AD_ACCOUNT_ID] : null;
        $this->pageId = isset($array[self::PAGE_ID]) ? $array[self::PAGE_ID] : null;
        $this->accessToken = isset($array[self::ACCESS_TOKEN]) ? $array[self::ACCESS_TOKEN] : null;

        $adSets = array();
        if (isset($array[self::AD_SETS]))
        {
            foreach($array[self::AD_SETS] as $adSetArray)
            {

                $adSet = new FacebookAdSet();
                $adSet->fromAssociativeArray($adSetArray);
                $adSets[] = $adSet;
            }
        }

        $this->adSets = $adSets;
    }

    public static function translateStatus($status)
    {
        if ($status == "paused" || $status == "inactive")
        {
            return Campaign::STATUS_PAUSED;
        }

        return $status;
    }
}
