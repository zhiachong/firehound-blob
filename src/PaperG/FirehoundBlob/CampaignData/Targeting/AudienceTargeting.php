<?php
/**
 * Created by PhpStorm.
 * User: allentsai
 * Date: 3/3/16
 * Time: 11:43 AM
 */

namespace PaperG\FirehoundBlob\CampaignData\Targeting;


class AudienceTargeting
{

    const AUDIENCE_GROUP_IDS = 'audienceGroupIds';
    const GENDER = 'gender';
    const MAX_AGE = 'maxAge';
    const MIN_AGE = 'minAge';

    /**
     * @var string|null
     */
    private $gender;

    /**
     * @var null|array
     */
    private $audienceGroupIds;

    /**
     * @var int|null
     */
    private $minAge;

    /**
     * @var int|null
     */
    private $maxAge;

    public function __construct($array = null)
    {
        $this->audienceGroupIds = isset($array[self::AUDIENCE_GROUP_IDS]) ? $array[self::AUDIENCE_GROUP_IDS] : null;
        $this->gender = isset($array[self::GENDER]) ? $array[self::GENDER] : null;
        $this->maxAge = isset($array[self::MAX_AGE]) ? $array[self::MAX_AGE] : null;
        $this->minAge = isset($array[self::MIN_AGE]) ? $array[self::MIN_AGE] : null;
    }

    /**
     * @param array|null $groupIds
     */
    public function setAudienceGroupIds($groupIds)
    {
        $this->audienceGroupIds = $groupIds;
    }

    /**
     * @return array|null
     */
    public function getAudienceGroupIds()
    {
        return $this->audienceGroupIds;
    }


    /**
     * @param null|string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return null|string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param int|null $maxAge
     */
    public function setMaxAge($maxAge)
    {
        $this->maxAge = $maxAge;
    }

    /**
     * @return int|null
     */
    public function getMaxAge()
    {
        return $this->maxAge;
    }

    /**
     * @param int|null $minAge
     */
    public function setMinAge($minAge)
    {
        $this->minAge = $minAge;
    }

    /**
     * @return int|null
     */
    public function getMinAge()
    {
        return $this->minAge;
    }

    /**
     * @return array
     */
    public function toAssociativeArray()
    {
        $array = [];

        $array[self::AUDIENCE_GROUP_IDS] = $this->audienceGroupIds;
        $array[self::GENDER] = $this->gender;
        $array[self::MAX_AGE] = $this->maxAge;
        $array[self::MIN_AGE] = $this->minAge;

        return $array;
    }
}
