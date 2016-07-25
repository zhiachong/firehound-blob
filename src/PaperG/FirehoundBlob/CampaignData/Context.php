<?php

namespace PaperG\FirehoundBlob\CampaignData;

use PaperG\Common\AppNexusDataIncludeFrame;
use PaperG\FirehoundBlob\CampaignData\Context\FacebookContext;
use PaperG\PlaceLocal\API\AppNexus\ExchangeCampaign;
use PaperG\PlaceLocal\Common\CampaignAudienceGroups;

//TODO: Pull these out of PlaceLocal or otherwise abstract them

class Context
{
    /* @var Array $values An associative array of values */
    protected $values;

    CONST STATUS_ACTIVE       = "active";
    CONST STATUS_INACTIVE     = "inactive";

    //These are values used for most exchanges
    CONST ADVERTISER_ID              = "advertiserId"; //int
    CONST ADVERTISER_NAME            = "advertiserName"; //string
    CONST CAMPAIGN_ID                = "campaignId"; //int
    CONST SMART_GROUP_ID             = "smartGroupId"; //int
    CONST INDUSTRY_ID                = "industryId"; //int
    CONST FROZEN                     = "frozen"; //bool
    CONST STATUS                     = "status"; //Expected values are "active", "inactive", todo: perhaps promote this as a full field
    CONST LANGUAGES                  = "languages"; //int array
    CONST AUDIENCE_GROUPS            = "audienceGroups"; //CampaignAudienceGroups
    CONST APPNEXUS_OBJECT_INCLUSIONS = "appnexusObjectInclusions"; //an AppNexus specific component to specify which objects to update
    CONST FACEBOOK_CONTEXT          = "facebookContext";

    //These are values used mostly by AppNexus
    CONST PUBLICATION_NAME          = "publicationName"; //string
    CONST PUBLICATION_ID            = "publicationId"; //int

    CONST APPNEXUS_VALUES           = "appnexusValues"; //this is a PaperG\PlaceLocal\API\AppNexus\ExchangeCampaign

    public function __construct($values = Array())
    {
        $this->values = $values;
    }

    public function toAssociativeArray()
    {
        $assocArray = Array();

        foreach ($this->values as $currKey => $currValue)
        {
            $assocArray[$currKey] = $currValue;
        }

        /* @var ExchangeCampaign $exchangeCampaign */
        $exchangeCampaign = self::getValueByKey(self::APPNEXUS_VALUES);
        if (!is_null($exchangeCampaign))
        {
            $assocArray[self::APPNEXUS_VALUES] = $exchangeCampaign->toAssociativeArray();
        }

        /* @var CampaignAudienceGroups $audienceGroups */
        $audienceGroups = self::getValueByKey(self::AUDIENCE_GROUPS);
        if (!is_null($audienceGroups))
        {
            $assocArray[self::AUDIENCE_GROUPS] = $audienceGroups->toAssociativeArray();
        }

        /* @var AppNexusDataIncludeFrame $appnexusObjectList */
        $appnexusObjectList = self::getValueByKey(self::APPNEXUS_OBJECT_INCLUSIONS);
        if (!is_null($appnexusObjectList))
        {
            $assocArray[self::APPNEXUS_OBJECT_INCLUSIONS] = $appnexusObjectList->toAssociativeArray();
        }

        /**
         * @var FacebookContext $facebookContext
         */
        $facebookContext = self::getValueByKey(self::FACEBOOK_CONTEXT);
        if (!is_null($facebookContext))
        {
            $assocArray[self::FACEBOOK_CONTEXT] = $facebookContext->toAssociativeArray();
        }

        return $assocArray;
    }

    public static function fromAssociativeArray($assocArray)
    {
        $values = Array();

        foreach ($assocArray as $currKey => $currValue)
        {
            $values[$currKey] = $currValue;
        }

        if (isset($assocArray[self::APPNEXUS_VALUES]))
        {
            $exchangeCampaign = new ExchangeCampaign();
            $exchangeCampaign->fromAssociativeArray($assocArray[self::APPNEXUS_VALUES]);
            $values[self::APPNEXUS_VALUES] = $exchangeCampaign;
        }

        if (isset($assocArray[self::AUDIENCE_GROUPS]))
        {
            $audienceGroups = new CampaignAudienceGroups(Array());
            $audienceGroups->fromAssociativeArray($assocArray[self::AUDIENCE_GROUPS]);
            $values[self::AUDIENCE_GROUPS] = $audienceGroups;
        }

        if (isset($assocArray[self::APPNEXUS_OBJECT_INCLUSIONS]))
        {
            $appnexusObjectList = new AppNexusDataIncludeFrame();
            $appnexusObjectList->fromAssociativeArray($assocArray[self::APPNEXUS_OBJECT_INCLUSIONS]);
            $values[self::APPNEXUS_OBJECT_INCLUSIONS] = $appnexusObjectList;
        }

        if (isset($assocArray[self::FACEBOOK_CONTEXT]))
        {
            $facebookContext = new FacebookContext();
            $facebookContext->fromAssociativeArray($assocArray[self::FACEBOOK_CONTEXT]);
            $values[self::FACEBOOK_CONTEXT] = $facebookContext;
        }

        $context = new Context($values);
        return $context;
    }

    public function getValueByKey($key)
    {
        if (empty($this->values))
        {
            return null;
        }
        else if (isset($this->values[$key]))
        {
            return $this->values[$key];
        }

        return null;
    }

    public function setValueByKey($key, $value)
    {
        //we make this a no-op to make it easier for blindly setting values
        //null is considered "do nothing", boolean false is considered a removal of a value
        if (is_null($value))
        {
            return;
        }

        $this->values[$key] = $value;
    }

    //these are common enough values that we make specific functions for them
    //these functions also help a lot with unit testing
    /**
     * @return null|int
     */
    public function getAdvertiserId()
    {
        return self::getValueByKey(self::ADVERTISER_ID);
    }

    /**
     * @param int $advertiserId
     */
    public function setAdvertiserId($advertiserId)
    {
        self::setValueByKey(self::ADVERTISER_ID, $advertiserId);
    }

    /**
     * @return null|String
     */
    public function getAdvertiserName()
    {
        return self::getValueByKey(self::ADVERTISER_NAME);
    }

    /**
     * @return null|int
     */
    public function getCampaignId()
    {
        return self::getValueByKey(self::CAMPAIGN_ID);
    }

    /**
     * @return null|int
     */
    public function getSmartGroupId()
    {
        return self::getValueByKey(self::SMART_GROUP_ID);
    }

    /**
     * @return null|int Top level industry id for placelocal-campaign
     */
    public function getIndustryId()
    {
        return self::getValueByKey(self::INDUSTRY_ID);
    }

    /**
     * @return null|boolean Determines whether some values are locked or not
     */
    public function getFrozen()
    {
        return self::getValueByKey(self::FROZEN);
    }

    /**
     * @return null|int
     */
    public function getStatus()
    {
        return self::getValueByKey(self::STATUS);
    }

    /**
     * @return null|Array An array of ints
     */
    public function getLanguages()
    {
        return self::getValueByKey(self::LANGUAGES);
    }

    /**
     * @return null|String
     */
    public function getPublicationName()
    {
        return self::getValueByKey(self::PUBLICATION_NAME);
    }

    /**
     * @return null|int
     */
    public function getPublicationId()
    {
        return self::getValueByKey(self::PUBLICATION_ID);
    }

    /**
     * @return null|ExchangeCampaign
     */
    public function getAppNexusValues()
    {
        return self::getValueByKey(self::APPNEXUS_VALUES);
    }

    /**
     * @return null|CampaignAudienceGroups
     */
    public function getAudienceGroups()
    {
        return self::getValueByKey(self::AUDIENCE_GROUPS);
    }

    /**
     * @return null|AppNexusDataIncludeFrame
     */
    public function getAppnexusObjectInclusions()
    {
        return self::getValueByKey(self::APPNEXUS_OBJECT_INCLUSIONS);
    }

    /**
     * @return null|FacebookContext
     */
    public function getFacebookContext()
    {
        return self::getValueByKey(self::FACEBOOK_CONTEXT);
    }

    public function setFacebookContext($facebookContext)
    {
        self::setValueByKey(self::FACEBOOK_CONTEXT, $facebookContext);
    }
}
