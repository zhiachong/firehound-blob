<?php
/**
 * Created by PhpStorm.
 * User: allentsai
 * Date: 7/6/16
 * Time: 5:23 PM
 */

namespace PaperG\ScenarioBlob\Blobs\UnmanagedFacebook;


use PaperG\ScenarioBlob\BlobInterface;
use PaperG\ScenarioBlob\Utility;

class FacebookCreativeData implements BlobInterface
{
    use Utility;

    const MEDIA_URL = "media_url";
    const CALL_TO_ACTION = "call_to_action";
    const MESSAGE = "message";
    const CAPTION = "caption";
    const LANDING_PAGE = "landing_page";
    const VERSION = "version";
    const NAME = "name";
    const DESCRIPTION = "description";
    const VARIATION_ID = 'variation_id';

    const CURRENT_VERSION = 1;

    //base creative, usually for Facebook
    /**
     * @var string
     */
    private $mediaUrl;

    /**
     * @var string
     */
    private $callToAction;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $caption;

    /**
     * @var string
     */
    private $landingPage;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $variationId;

    /**
     * @param array|null $array
     */
    public function __construct($array = null)
    {
        $this->fromArray($array);
    }

    /**
     * @param string $callToAction
     */
    public function setCallToAction($callToAction)
    {
        $this->callToAction = $callToAction;
    }

    /**
     * @return string
     */
    public function getCallToAction()
    {
        return $this->callToAction;
    }

    /**
     * @param string $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $landingPage
     */
    public function setLandingPage($landingPage)
    {
        $this->landingPage = $landingPage;
    }

    /**
     * @return string
     */
    public function getLandingPage()
    {
        return $this->landingPage;
    }

    /**
     * @param string $mediaUrl
     */
    public function setMediaUrl($mediaUrl)
    {
        $this->mediaUrl = $mediaUrl;
    }

    /**
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->mediaUrl;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
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
     * @param string $variationId
     */
    public function setVariationId($variationId)
    {
        $this->variationId = $variationId;
    }

    /**
     * @return string
     */
    public function getVariationId()
    {
        return $this->variationId;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            self::MEDIA_URL => $this->getMediaUrl(),
            self::CALL_TO_ACTION => $this->getCallToAction(),
            self::MESSAGE => $this->getMessage(),
            self::CAPTION => $this->getCaption(),
            self::LANDING_PAGE => $this->getLandingPage(),
            self::NAME => $this->getName(),
            self::DESCRIPTION => $this->getDescription(),
            self::VARIATION_ID => $this->getVariationId(),
            self::VERSION => self::CURRENT_VERSION
        ];
    }

    /**
     * @param array $array
     */
    public function fromArray($array)
    {
        $this->mediaUrl = $this->safeGet($array, self::MEDIA_URL);
        $this->callToAction = $this->safeGet($array, self::CALL_TO_ACTION);
        $this->message = $this->safeGet($array, self::MESSAGE);
        $this->caption = $this->safeGet($array, self::CAPTION);
        $this->landingPage = $this->safeGet($array, self::LANDING_PAGE);
        $this->name = $this->safeGet($array, self::NAME);
        $this->description = $this->safeGet($array, self::DESCRIPTION);
        $this->variationId = $this->safeGet($array, self::VARIATION_ID);
    }
}
