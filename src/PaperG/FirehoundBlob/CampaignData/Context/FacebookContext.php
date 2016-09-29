<?php
namespace PaperG\FirehoundBlob\CampaignData\Context;


use PaperG\FirehoundBlob\Facebook\FacebookAdSet;

class FacebookContext
{
    const AD_ACCOUNT_ID = "adAccountId";
    const AD_SETS = "adSets";
    const PAGE_ID = "pageId";
    const ACCESS_TOKEN = "accessToken";
    const IG_ACTOR_ID = "igActorId";

    private $adAccountId = null;
    private $pageId = null;
    private $accessToken = null;
    private $igActorId = null;

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

    public function getIgActorId()
    {
        return $this->igActorId;
    }

    public function setIgActorId($igActorId)
    {
        $this->igActorId = $igActorId;
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
            self::ACCESS_TOKEN => $this->accessToken,
            self::IG_ACTOR_ID => $this->igActorId
        );
    }

    public function fromAssociativeArray($array)
    {
        $this->adAccountId = isset($array[self::AD_ACCOUNT_ID]) ? $array[self::AD_ACCOUNT_ID] : null;
        $this->pageId = isset($array[self::PAGE_ID]) ? $array[self::PAGE_ID] : null;
        $this->accessToken = isset($array[self::ACCESS_TOKEN]) ? $array[self::ACCESS_TOKEN] : null;
        $this->igActorId = isset($array[self::IG_ACTOR_ID]) ? $array[self::IG_ACTOR_ID] : null;

        $adSets = array();
        if (isset($array[self::AD_SETS])) {
            foreach ($array[self::AD_SETS] as $adSetArray) {

                $adSet = new FacebookAdSet();
                $adSet->fromAssociativeArray($adSetArray);
                $adSets[] = $adSet;
            }
        }

        $this->adSets = $adSets;
    }
} 
