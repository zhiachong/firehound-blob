<?php
/**
 * Created by PhpStorm.
 * User: allentsai
 * Date: 5/26/16
 * Time: 2:57 PM
 */

namespace PaperG\FirehoundBlob\CampaignData;


class CityRadius
{

    const CITY_ID = "cityId";
    const RADIUS  = "radius";

    private $cityId;
    private $radius;

    public function __construct($array)
    {
        $this->fromArray($array);
    }

    public function fromArray($array)
    {
        $this->cityId = isset($array[self::CITY_ID]) ? $array[self::CITY_ID] : null;
        $this->radius = isset($array[self::RADIUS]) ? $array[self::RADIUS] : null;
    }

    public function toArray()
    {
        return [
            self::CITY_ID => $this->cityId,
            self::RADIUS  => $this->radius
        ];
    }
}
