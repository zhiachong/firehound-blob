<?php

namespace PaperG\ScenarioBlob\Blobs\UnmanagedFacebook\Targeting;


use PaperG\ScenarioBlob\BlobInterface;
use PaperG\ScenarioBlob\Utility;

class FacebookGeographicTargeting implements BlobInterface
{
    use Utility;

    const COUNTRY_IDS    = 'countryIds';
    const REGION_IDS     = 'regionIds';
    const CITY_IDS       = 'cityIds';
    const POSTAL_CODES   = 'postalCodes';
    const COUNTRY_ACTION = 'countryAction';
    const REGION_ACTION  = 'regionAction';
    const CITY_ACTION    = 'cityAction';
    const POSTAL_ACTION  = 'postalAction';

    const VERSION = 'version';

    const CURRENT_VERSION = 1;

    /**
     * @var array
     */
    private $countryIds;

    /**
     * @var array
     */
    private $regionIds;

    /**
     * @var array
     */
    private $cityIds;

    /**
     * @var array
     */
    private $postalCodes;

    /**
     * @var string
     */
    private $countryAction;

    /**
     * @var string
     */
    private $regionAction;

    /**
     * @var string
     */
    private $cityAction;

    /**
     * @var string
     */
    private $postalAction;

    /**
     * @param array|null $array
     */
    public function __construct($array = null)
    {
        $this->fromArray($array);
    }

    /**
     * @param string $cityAction
     */
    public function setCityAction($cityAction)
    {
        $this->cityAction = $cityAction;
    }

    /**
     * @return string
     */
    public function getCityAction()
    {
        return $this->cityAction;
    }

    /**
     * @param array $cityIds
     */
    public function setCityIds($cityIds)
    {
        $this->cityIds = $cityIds;
    }

    /**
     * @return array
     */
    public function getCityIds()
    {
        return $this->cityIds;
    }

    /**
     * @param string $countryAction
     */
    public function setCountryAction($countryAction)
    {
        $this->countryAction = $countryAction;
    }

    /**
     * @return string
     */
    public function getCountryAction()
    {
        return $this->countryAction;
    }

    /**
     * @param array $countryIds
     */
    public function setCountryIds($countryIds)
    {
        $this->countryIds = $countryIds;
    }

    /**
     * @return array
     */
    public function getCountryIds()
    {
        return $this->countryIds;
    }

    /**
     * @param string $postalAction
     */
    public function setPostalAction($postalAction)
    {
        $this->postalAction = $postalAction;
    }

    /**
     * @return string
     */
    public function getPostalAction()
    {
        return $this->postalAction;
    }

    /**
     * @param array $postalCodes
     */
    public function setPostalCodes($postalCodes)
    {
        $this->postalCodes = $postalCodes;
    }

    /**
     * @return array
     */
    public function getPostalCodes()
    {
        return $this->postalCodes;
    }

    /**
     * @param string $regionAction
     */
    public function setRegionAction($regionAction)
    {
        $this->regionAction = $regionAction;
    }

    /**
     * @return string
     */
    public function getRegionAction()
    {
        return $this->regionAction;
    }

    /**
     * @param array $regionIds
     */
    public function setRegionIds($regionIds)
    {
        $this->regionIds = $regionIds;
    }

    /**
     * @return array
     */
    public function getRegionIds()
    {
        return $this->regionIds;
    }

    public function isValid()
    {
        return (
            (!empty($this->getCountryAction()) && !empty($this->getCountryIds())) ||
            (!empty($this->getCityAction()) && !empty($this->getCityIds())) ||
            (!empty($this->getRegionAction()) && !empty($this->getRegionIds())) ||
            (!empty($this->getPostalAction()) && !empty($this->getPostalCodes()))
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            self::COUNTRY_IDS => $this->getCountryIds(),
            self::REGION_IDS => $this->getRegionIds(),
            self::CITY_IDS => $this->getCityIds(),
            self::POSTAL_CODES => $this->getPostalCodes(),
            self::COUNTRY_ACTION => $this->getCountryAction(),
            self::REGION_ACTION => $this->getRegionAction(),
            self::CITY_ACTION => $this->getCityAction(),
            self::POSTAL_ACTION => $this->getPostalAction(),
            self::VERSION => self::CURRENT_VERSION
        ];
    }

    /**
     * @param $array array
     */
    public function fromArray($array)
    {
        $this->setCountryIds($this->safeGet($array, self::COUNTRY_IDS));
        $this->setRegionIds($this->safeGet($array, self::REGION_IDS));
        $this->setCityIds($this->safeGet($array, self::CITY_IDS));
        $this->setPostalCodes($this->safeGet($array, self::POSTAL_CODES));
        $this->setCountryAction($this->safeGet($array, self::COUNTRY_ACTION));
        $this->setRegionAction($this->safeGet($array, self::REGION_ACTION));
        $this->setCityAction($this->safeGet($array, self::CITY_ACTION));
        $this->setPostalAction($this->safeGet($array, self::POSTAL_ACTION));
    }
}
