<?php

namespace PaperG\ScenarioBlob;


use PaperG\ScenarioBlob\Blobs\UnmanagedFacebook\UnmanagedFacebookBlob;

class ScenarioBlob implements BlobInterface
{
    use Utility;

    const BASIC_INFO = 'basicInfo';
    const BLOB = 'blob';

    /**
     * @var BasicInfo
     */
    private $basicInfo;

    /**
     * @var BlobInterface
     */
    private $blob;

    public function __construct($array = null)
    {
        $this->fromArray($array);
    }

    /**
     * @param \PaperG\ScenarioBlob\BasicInfo $basicInfo
     */
    public function setBasicInfo($basicInfo)
    {
        $this->basicInfo = $basicInfo;
    }

    /**
     * @return \PaperG\ScenarioBlob\BasicInfo
     */
    public function getBasicInfo()
    {
        return $this->basicInfo;
    }

    /**
     * @param \PaperG\ScenarioBlob\BlobInterface $blob
     */
    public function setBlob($blob)
    {
        $this->blob = $blob;
    }

    /**
     * @return \PaperG\ScenarioBlob\BlobInterface
     */
    public function getBlob()
    {
        return $this->blob;
    }

    public function fromArray($array)
    {
        $this->basicInfo = new BasicInfo($this->safeGet($array, self::BASIC_INFO));

        $scenario = $this->basicInfo->getScenario();

        $blobArray = $this->safeGet($array, self::BLOB);
        switch ($scenario) {
            case Scenario::FB_UNMANAGED:
                $this->blob = new UnmanagedFacebookBlob($blobArray);
                break;
            default:
                break;
        }
    }

    public function toArray()
    {
        return [
            self::BASIC_INFO => $this->basicInfo->toArray(),
            self::BLOB => $this->blob->toArray()
        ];
    }
}
