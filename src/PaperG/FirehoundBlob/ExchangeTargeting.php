<?php

namespace PaperG\Common\CampaignData;

class ExchangeTargeting
{
    /* @var Boolean $appnexus Whether to target AppNexus*/
    protected $appnexus;

    /* @var Boolean $facebook Whether to target Facebook*/
    protected $facebook;

    //used for serialization
    CONST APPNEXUS = "appnexus";
    CONST FACEBOOK = "facebook";
    CONST VERSION  = "version";

    CONST CURR_VERSION = 0;

    public function __construct(
        $appnexus,
        $facebook
    )
    {
        $this->appnexus = $appnexus;
        $this->facebook = $facebook;
    }

    public function toAssociativeArray()
    {
        return [
            self::APPNEXUS => $this->appnexus,
            self::FACEBOOK => $this->facebook,
            self::VERSION  => self::CURR_VERSION
        ];
    }

    public static function fromAssociativeArray($exchangeTargeting)
    {
        $appnexus = isset($exchangeTargeting[self::APPNEXUS]) ? $exchangeTargeting[self::APPNEXUS] : null;
        $facebook = isset($exchangeTargeting[self::FACEBOOK]) ? $exchangeTargeting[self::FACEBOOK] : null;

        $exchangeTargeting = new ExchangeTargeting($appnexus, $facebook);
        return $exchangeTargeting;
    }

    public function isValid()
    {
        //we should be targeting at least one exchange
        return $this->appnexus || $this->facebook;
    }

    /**
     * @param boolean $appnexus
     */
    public function setAppnexus($appnexus)
    {
        $this->appnexus = $appnexus;
    }

    /**
     * @return boolean
     */
    public function getAppnexus()
    {
        return $this->appnexus;
    }

    /**
     * @param boolean $facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * @return boolean
     */
    public function getFacebook()
    {
        return $this->facebook;
    }
}
