<?php
/**
 * Created by PhpStorm.
 * User: allentsai
 * Date: 7/6/16
 * Time: 2:20 PM
 */

namespace PaperG\Common\Test;


use PaperG\FirehoundBlob\BasicInfo;
use PaperG\FirehoundBlob\BlobInterface;

class AudienceExtensionBlob implements BlobInterface
{
    const BASIC_INFO = "basicInfo";
    const OBJECT_BLOB = "objectBlob";

    /**
     * @var BasicInfo
     */
    private $basicInfo;

    /**
     * @var BlobInterface
     */
    private $objectBlob;

    public function __construct() {}

    public function toArray()
    {
        return [
            self::BASIC_INFO => $this->basicInfo->toArray(),
            self::OBJECT_BLOB => $this->objectBlob->toArray()
        ];
    }

    public function fromArray($array) {
        $this->basicInfo = $array[self::BASIC_INFO];
        $this->objectBlob = $array[self::OBJECT_BLOB];
    }

    public function validate() {
        return $this->basicInfo->validate() && $this->objectBlob->validate();
    }
} 
