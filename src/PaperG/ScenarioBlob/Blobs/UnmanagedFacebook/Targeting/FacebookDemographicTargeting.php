<?php

namespace PaperG\ScenarioBlob\Blobs\UnmanagedFacebook\Targeting;


use PaperG\ScenarioBlob\BlobInterface;
use PaperG\ScenarioBlob\Utility;

class FacebookDemographicTargeting implements BlobInterface
{
    use Utility;

    const MAX_AGE = 'maxAge';
    const MIN_AGE = 'minAge';
    const GENDER = 'gender';

    /**
     * @var int
     */
    private $minAge;

    /**
     * @var int
     */
    private $maxAge;

    /**
     * @var string
     */
    private $gender;

    /**
     * @param array|null $array
     */
    public function __construct($array = null)
    {
        $this->fromArray($array);
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param int $maxAge
     */
    public function setMaxAge($maxAge)
    {
        $this->maxAge = $maxAge;
    }

    /**
     * @return int
     */
    public function getMaxAge()
    {
        return $this->maxAge;
    }

    /**
     * @param int $minAge
     */
    public function setMinAge($minAge)
    {
        $this->minAge = $minAge;
    }

    /**
     * @return int
     */
    public function getMinAge()
    {
        return $this->minAge;
    }

    public function isValid()
    {
        return $this->getMinAge >= 18 && $this->getMaxAge <= 65;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            self::MAX_AGE => $this->maxAge,
            self::MIN_AGE => $this->minAge,
            self::GENDER => $this->gender
        ];
    }

    /**
     * @param $array array
     */
    public function fromArray($array)
    {
        $this->maxAge = $this->safeGet($array, self::MAX_AGE);
        $this->minAge = $this->safeGet($array, self::MIN_AGE, 18);
        $this->gender = $this->safeGet($array, self::GENDER);
    }
}
