<?php

namespace PaperG\FirehoundBlob\Dcm;

use PaperG\FirehoundBlob\Utility;

class DcmCreativeAsset
{

    use Utility;

    const UUID = 'uuid';
    const AD_TAG = 'adTag';
    const IMAGE_URL = 'imageUrl';
    const WIDTH = 'width';
    const HEIGHT = 'height';
    const ACTIVE = 'active';
    const ARCHIVED = 'archived';

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $adTag;

    /**
     * @var string
     */
    private $imageUrl;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var bool
     */
    private $archived;

    public function __construct($array = [])
    {
        $this->fromArray($array);
    }

    public function toArray()
    {
        return [
            self::UUID => $this->uuid,
            self::AD_TAG => $this->adTag,
            self::IMAGE_URL => $this->imageUrl,
            self::WIDTH => $this->width,
            self::HEIGHT => $this->height,
            self::ACTIVE => $this->active,
            self::ARCHIVED => $this->archived,
        ];
    }

    public function fromArray($array)
    {
        $this->uuid = $this->safeGet($array, self::UUID);
        $this->adTag = $this->safeGet($array, self::AD_TAG);
        $this->imageUrl = $this->safeGet($array, self::IMAGE_URL);
        $this->width = $this->safeGet($array, self::WIDTH);
        $this->height = $this->safeGet($array, self::HEIGHT);
        $this->active = $this->safeGet($array, self::ACTIVE);
        $this->archived = $this->safeGet($array, self::ARCHIVED);
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param string $adTag
     */
    public function setAdTag($adTag)
    {
        $this->adTag = $adTag;
    }

    /**
     * @return string
     */
    public function getAdTag()
    {
        return $this->adTag;
    }

    /**
     * @param boolean $archived
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;
    }

    /**
     * @return boolean
     */
    public function isArchived()
    {
        return $this->archived;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }
} 
