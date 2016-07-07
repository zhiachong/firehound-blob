<?php
/**
 * Created by PhpStorm.
 * User: allentsai
 * Date: 7/6/16
 * Time: 5:19 PM
 */

namespace PaperG\FirehoundBlob\Facebook;


use PaperG\FirehoundBlob\BlobInterface;
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
     * @param FacebookCreativeData[] $objects
     */
    public function setObjects($objects)
    {
        $this->objects = $objects;
    }

    /**
     * @return FacebookCreativeData[]
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

            $objectArray[] = new FacebookCreativeData($object); //versioned, might need builder
        }

        $this->objects = $objectArray;
    }
} 
