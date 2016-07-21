<?php

namespace PaperG\ScenarioBlob\Blobs\UnmanagedFacebook\Targeting;


use PaperG\ScenarioBlob\Utility;

class FacebookAudienceTargeting
{
    use Utility;

    const TYPE = 'type';
    const IDS  = 'ids';

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $ids;

    public function __construct($array = null)
    {
        $this->fromArray($array);
    }

    /**
     * @param array $ids
     */
    public function setIds($ids)
    {
        $this->ids = $ids;
    }

    /**
     * @return array
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    public function isValid()
    {
        return !empty($this->getType()) &&
               !empty($this->getIds()) &&
               is_array(($this->getIds()));
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            self::TYPE => $this->type,
            self::IDS  => $this->ids
        ];
    }

    /**
     * @param $array array
     */
    public function fromArray($array)
    {
        $this->type = $this->safeGet($array, self::TYPE);
        $this->ids  = $this->safeGet($array, self::IDS);
    }
}
