<?php

namespace PaperG\FirehoundBlob\Facebook;


use PaperG\FirehoundBlob\BlobInterface;
use PaperG\FirehoundBlob\Facebook\CreativeData\FacebookCarouselCreativeData;
use PaperG\FirehoundBlob\Utility;

class FacebookCreative implements BlobInterface
{
    use Utility;

    const TYPE = 'type';
    const OBJECTS = 'objects';
    const VERSION = 'version';

    const CURRENT_VERSION = 1;

    /**
     * @var string
     */
    private $type;

    /**
     * @var FacebookCreativeData[]
     */
    private $objects;

    public function __construct($array = null)
    {
        $this->fromArray($array);
    }

    /**
     * @param FacebookCreativeData[]|FacebookCarouselCreativeData[] $objects
     */
    public function setObjects($objects)
    {
        $this->objects = $objects;
    }

    /**
     * @return FacebookCreativeData[]|FacebookCarouselCreativeData[]
     */
    public function getObjects()
    {
        return $this->objects;
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
        $creativeData = $this->getObjects();
        $creativeType = $this->getType();

        return !(empty($creativeType) || empty($creativeData));
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array =  [
            self::TYPE => $this->type,
            self::VERSION => self::CURRENT_VERSION
        ];

        $objects = null;
        if (!empty($this->objects)) {
            $objects = [];
            foreach ($this->objects as $creativeData) {
                $objects[] = $creativeData->toArray();
            }
        }

        $array[self::OBJECTS] = $objects;

        return $array;
    }

    /**
     * @param array $array
     */
    public function fromArray($array)
    {
        $this->type = $this->safeGet($array, self::TYPE);
        $objects = $this->safeGet($array, self::OBJECTS, []);
        $objectArray = [];
        foreach ($objects as $object) {
            if ($this->type == 'carousel') {
                $objectArray[] = new FacebookCarouselCreativeData($object);
            } else {
                $objectArray[] = new FacebookCreativeData($object); //versioned, might need builder
            }
        }

        $this->objects = $objectArray;
    }

}
