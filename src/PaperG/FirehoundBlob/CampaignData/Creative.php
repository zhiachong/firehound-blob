<?php

namespace PaperG\FirehoundBlob\CampaignData;

class Creative
{
    //adtags
    protected $adtagJavascriptSecure = null;
    protected $adtagJavascriptInsecure = null;
    protected $adtagIframeSecure = null;
    protected $adtagIframeInsecure = null;

    //base creative, usually for Facebook
    protected $mediaUrl = null;
    protected $callToActionText = null;
    protected $caption = null;
    protected $landingPage = null;

    //used for serialization
    CONST ADTAG_JAVASCRIPT_SECURE = "adtag_javascript_secure";
    CONST ADTAG_JAVASCRIPT_INSECURE = "adtag_javascript_insecure";
    CONST ADTAG_IFRAME_SECURE = "adtag_iframe_secure";
    CONST ADTAG_IFRAME_INSECURE = "adtag_iframe_insecure";
    CONST MEDIA_URL = "media_url";
    CONST CALL_TO_ACTION = "call_to_action";
    CONST CAPTION = "caption";
    CONST LANDING_PAGE = "landing_page";
    CONST VERSION = "version";

    CONST CURR_VERSION = 0;

    public function __construct(
        $adtagJavascriptSecure = null,
        $adtagJavascriptInsecure = null,
        $adtagIframeSecure = null,
        $adtagIframeInsecure = null,
        $mediaUrl = null,
        $callToActionText = null,
        $caption = null,
        $landingPage = null
    )
    {
        $this->adtagJavascriptSecure = $adtagJavascriptSecure;
        $this->adtagJavascriptInsecure = $adtagJavascriptInsecure;
        $this->adtagIframeSecure = $adtagIframeSecure;
        $this->adtagIframeInsecure = $adtagIframeInsecure;
        $this->mediaUrl = $mediaUrl;
        $this->callToActionText = $callToActionText;
        $this->caption = $caption;
        $this->landingPage = $landingPage;
    }

    public function toAssociativeArray()
    {
        return [
            self::ADTAG_JAVASCRIPT_SECURE       => $this->adtagJavascriptSecure,
            self::ADTAG_JAVASCRIPT_INSECURE     => $this->adtagJavascriptInsecure,
            self::ADTAG_IFRAME_SECURE           => $this->adtagIframeSecure,
            self::ADTAG_IFRAME_INSECURE         => $this->adtagIframeInsecure,
            self::MEDIA_URL                     => $this->mediaUrl,
            self::CALL_TO_ACTION                => $this->callToActionText,
            self::CAPTION                       => $this->caption,
            self::LANDING_PAGE                  => $this->landingPage,
            self::VERSION                       => self::CURR_VERSION
        ];
    }

    public static function fromAssociativeArray($creativeArray)
    {
        $adtagJavascriptSecure = isset($creativeArray[self::ADTAG_JAVASCRIPT_SECURE]) ? $creativeArray[self::ADTAG_JAVASCRIPT_SECURE] : null;
        $adtagJavascriptInsecure = isset($creativeArray[self::ADTAG_JAVASCRIPT_INSECURE]) ? $creativeArray[self::ADTAG_JAVASCRIPT_INSECURE] : null;
        $adtagIframeSecure = isset($creativeArray[self::ADTAG_IFRAME_SECURE]) ? $creativeArray[self::ADTAG_IFRAME_SECURE] : null;
        $adtagIframeInsecure = isset($creativeArray[self::ADTAG_IFRAME_INSECURE]) ? $creativeArray[self::ADTAG_IFRAME_INSECURE] : null;
        $mediaUrl = isset($creativeArray[self::MEDIA_URL]) ? $creativeArray[self::MEDIA_URL] : null;
        $callToActionText = isset($creativeArray[self::CALL_TO_ACTION]) ? $creativeArray[self::CALL_TO_ACTION] : null;
        $caption    = isset($creativeArray[self::CAPTION]) ? $creativeArray[self::CAPTION] : null;
        $landingPage = isset($creativeArray[self::LANDING_PAGE]) ? $creativeArray[self::LANDING_PAGE] : null;

        $creative = new Creative(
            $adtagJavascriptSecure,
            $adtagJavascriptInsecure,
            $adtagIframeSecure,
            $adtagIframeInsecure,
            $mediaUrl,
            $callToActionText,
            $caption,
            $landingPage
        );

        return $creative;
    }

    public function isValid()
    {
        return isset($this->adtagJavascriptSecure) || isset($this->adtagJavascriptInsecure)
            || isset($this->adtagIframeSecure) || isset($this->adtagIframeInsecure)
            || (isset($this->mediaUrl) && isset($this->callToActionText));
    }

    /**
     * @param null|Array $adtagIframeInsecure An associative array of ad tags, dimension names taken from Dimension.php
     * eg. ["medium_rectangle" => "<iframe>blah</iframe>"
     */
    public function setAdtagIframeInsecure($adtagIframeInsecure)
    {
        $this->adtagIframeInsecure = $adtagIframeInsecure;
    }

    /**
     * @return null|Array Return an associative array of ad tags, dimension names taken from Dimension.php
     * eg. ["medium_rectangle" => "<iframe>blah</iframe>"
     */
    public function getAdtagIframeInsecure()
    {
        return $this->adtagIframeInsecure;
    }

    /**
     * @param null|Array $adtagIframeSecure An associative array of ad tags, dimension names taken from Dimension.php
     * eg. ["medium_rectangle" => "<iframe>blah</iframe>"
     */
    public function setAdtagIframeSecure($adtagIframeSecure)
    {
        $this->adtagIframeSecure = $adtagIframeSecure;
    }

    /**
     * @return null|Array Return an associative array of ad tags, dimension names taken from Dimension.php
     * eg. ["medium_rectangle" => "<iframe>blah</iframe>"
     */
    public function getAdtagIframeSecure()
    {
        return $this->adtagIframeSecure;
    }

    /**
     * @param null|Array $adtagJavascriptInsecure An associative array of ad tags, dimension names taken from Dimension.php
     * eg. ["medium_rectangle" => "<script>blah</script>"
     */
    public function setAdtagJavascriptInsecure($adtagJavascriptInsecure)
    {
        $this->adtagJavascriptInsecure = $adtagJavascriptInsecure;
    }

    /**
     * @return null|Array Return an associative array of ad tags, dimension names taken from Dimension.php
     * eg. ["medium_rectangle" => "<script>blah</script>"
     */
    public function getAdtagJavascriptInsecure()
    {
        return $this->adtagJavascriptInsecure;
    }

    /**
     * @param null|Array $adtagJavascriptSecure An associative array of ad tags, dimension names taken from Dimension.php
     * eg. ["medium_rectangle" => "<script>blah</script>"
     */
    public function setAdtagJavascriptSecure($adtagJavascriptSecure)
    {
        $this->adtagJavascriptSecure = $adtagJavascriptSecure;
    }

    /**
     * @return null|Array Return an associative array of ad tags, dimension names taken from Dimension.php
     * eg. ["medium_rectangle" => "<script>blah</script>"
     */
    public function getAdtagJavascriptSecure()
    {
        return $this->adtagJavascriptSecure;
    }

    /**
     * @param null|String $callToActionText
     */
    public function setCallToActionText($callToActionText)
    {
        $this->callToActionText = $callToActionText;
    }

    /**
     * @return null|String
     */
    public function getCallToActionText()
    {
        return $this->callToActionText;
    }

    /**
     * @param null|String $mediaUrl
     */
    public function setMediaUrl($mediaUrl)
    {
        $this->mediaUrl = $mediaUrl;
    }

    /**
     * @return null|String
     */
    public function getMediaUrl()
    {
        return $this->mediaUrl;
    }

    /**
     * @param null $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * @return null
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param null $landingPage
     */
    public function setLandingPage($landingPage)
    {
        $this->landingPage = $landingPage;
    }

    /**
     * @return null
     */
    public function getLandingPage()
    {
        return $this->landingPage;
    }
}
