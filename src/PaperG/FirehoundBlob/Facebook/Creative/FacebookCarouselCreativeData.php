<?php

namespace PaperG\FirehoundBlob\Facebook\Creative;

use PaperG\FirehoundBlob\Facebook\FacebookCreativeData;
use PaperG\FirehoundBlob\Utility;

class FacebookCarouselCreativeData extends FacebookCreativeData
{
    use Utility;

    const PRIMARY = "primary";
    const MULTI_SHARE_END_CARD = "multiShareEndCard";
    const MULTI_SHARE_OPTIMIZED = "multiShareOptimized";

    /**
     * @var bool
     */
    private $primary;

    /**
     * @var bool
     */
    private $useEndCard;

    /**
     * @var bool
     */
    private $optimized;

    /**
     * @param array|null $array
     */
    public function __construct($array = null)
    {
        $this->fromArray($array);
    }

    /**
     * @param bool $endCard
     */
    public function setUseEndCard($endCard)
    {
        $this->useEndCard = $endCard;
    }

    /**
     * @return bool
     */
    public function hasUseEndCard()
    {
        return $this->useEndCard;
    }

    /**
     * @param bool $optimized
     */
    public function setUseOptimized($optimized)
    {
        $this->optimized = $optimized;
    }

    /**
     * @return bool
     */
    public function hasUseOptimized()
    {
        return $this->optimized;
    }

    /**
     * @param bool $primary
     */
    public function setIsPrimary($primary)
    {
        $this->primary = $primary;
    }

    /**
     * @return bool
     */
    public function isPrimary()
    {
        return $this->primary;
    }

    public function fromArray($array)
    {
        if (!empty($array)) {
            parent::fromArray($array);
            $this->primary = $this->safeGet($array, self::PRIMARY);
            $this->optimized = $this->safeGet($array, self::MULTI_SHARE_OPTIMIZED);
            $this->useEndCard = $this->safeGet($array, self::MULTI_SHARE_END_CARD);
        }
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array[self::PRIMARY] = $this->primary;
        $array[self::MULTI_SHARE_END_CARD] = $this->useEndCard;
        $array[self::MULTI_SHARE_OPTIMIZED] = $this->optimized;

        return $array;
    }
} 
