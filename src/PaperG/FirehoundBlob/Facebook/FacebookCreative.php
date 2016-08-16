<?php

namespace PaperG\FirehoundBlob\Facebook;

use PaperG\FirehoundBlob\BlobInterface;
use PaperG\FirehoundBlob\Facebook\CreativeData\FacebookCarouselCreativeData;
use PaperG\FirehoundBlob\Utility;

class FacebookCreative implements BlobInterface
{
    use Utility;

    const TYPE              = 'type';
    const CHILD_ATTACHMENTS = 'child_attachments';
    const PRIMARY           = 'primary';
    const VERSION           = 'version';
    const LINK_TYPE         = 'link';
    const CAROUSEL_TYPE     = 'carousel';

    public static $validAdTypes = [self::LINK_TYPE, self::CAROUSEL_TYPE];

    const CURRENT_VERSION = 1;

    /**
     * @var string
     */
    private $type;

    /**
     * @var FacebookCreativeData
     */
    private $primary;

    /**
     * @var FacebookCreativeData[]
     */
    private $childAttachments;

    public function __construct($array = null)
    {
        $this->fromArray($array);
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
     * @return FacebookCreativeData[]
     */
    public function getChildAttachments()
    {
        return $this->childAttachments;
    }

    /**
     * @param FacebookCreativeData[] $childAttachments
     */
    public function setChildAttachments($childAttachments)
    {
        $this->childAttachments = $childAttachments;
    }

    /**
     * @return FacebookCreativeData
     */
    public function getPrimary()
    {
        return $this->primary;
    }

    /**
     * @param FacebookCreativeData $primary
     */
    public function setPrimary($primary)
    {
        $this->primary = $primary;
    }

    public function isValid()
    {
        $creativeData = $this->getPrimary();
        $creativeType = $this->getType();

        return !empty($creativeType) && !empty($creativeData) && in_array($creativeType, self::$validAdTypes);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = [
            self::TYPE    => $this->type,
            self::VERSION => self::CURRENT_VERSION,
            self::PRIMARY => $this->getPrimary()->toArray()
        ];

        $childAttachmentsArray = null;
        $childAttachments      = $this->getChildAttachments();
        if (!empty($childAttachments)) {
            foreach ($childAttachments as $creative) {
                $childAttachmentsArray[] = $creative->toArray();
            }
        }

        $array[self::CHILD_ATTACHMENTS] = $childAttachmentsArray;

        return $array;
    }

    /**
     * @param array $array
     */
    public function fromArray($array)
    {
        $this->type       = $this->safeGet($array, self::TYPE);
        $primary    = $this->safeGet($array, self::PRIMARY);
        $childAttachments = $this->safeGet($array, self::CHILD_ATTACHMENTS, []);

        $this->primary = $this->createCreativeData($primary);

        $objectsArray = [];
        foreach ($childAttachments as $object) {
            $objectsArray[]  = $this->createCreativeData($object);
        }

        $this->childAttachments = $objectsArray;
    }

    private function createCreativeData($creative)
    {
        if ($this->type == self::CAROUSEL_TYPE) {
            return new FacebookCarouselCreativeData($creative);
        }
        
        return new FacebookCreativeData($creative);
    }
}
