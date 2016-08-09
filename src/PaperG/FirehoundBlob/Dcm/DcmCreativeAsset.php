<?php

namespace PaperG\FirehoundBlob\Dcm;

use PaperG\FirehoundBlob\Utility;

class DcmCreativeAsset
{

    use Utility;

    const UUID = 'uuid';
    const AD_TAG = 'adTag';
    const NAME  = 'name';
    const IMAGE_URL = 'imageUrl';
    const WIDTH = 'width';
    const HEIGHT = 'height';
    const PLATFORM = 'platform';

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
     * @var string
     */
    private $platform;

    /**
     * @var string
     */
    private $name;

    public function __construct($array = [])
    {
        $this->fromArray($array);
    }

    public function toArray()
    {
        return [
            self::UUID => $this->uuid,
            self::NAME => $this->name,
            self::AD_TAG => $this->adTag,
            self::IMAGE_URL => $this->imageUrl,
            self::WIDTH => $this->width,
            self::HEIGHT => $this->height,
            self::PLATFORM => $this->platform
        ];
    }

    public function fromArray($array)
    {
        $this->uuid = $this->safeGet($array, self::UUID);
        $this->name = $this->safeGet($array, self::NAME);
        $this->adTag = $this->safeGet($array, self::AD_TAG);
        $this->imageUrl = $this->safeGet($array, self::IMAGE_URL);
        $this->width = $this->safeGet($array, self::WIDTH);
        $this->height = $this->safeGet($array, self::HEIGHT);
        $this->platform = $this->safeGet($array, self::PLATFORM);
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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

    /**
     * @return string
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param $platform
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }
} 
