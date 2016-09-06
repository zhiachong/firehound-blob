<?php
/**
 *
 * Author: zhiachong (zTime)
 * Time: 7/14/16 - 3:52 PM
 * Filename: FacebookUnmanagedValidator.php
 */

namespace PaperG\FirehoundBlob\ScenarioValidators;

use PaperG\FirehoundBlob\CampaignData\Context;
use PaperG\FirehoundBlob\Facebook\UnmanagedFacebookBlob;
use PaperG\FirehoundBlob\Facebook\Validators\UnmanagedFacebookBlobValidator;
use PaperG\FirehoundBlob\ScenarioBlob;

class UnmanagedFacebookValidator extends UnmanagedFacebookBlobValidator implements ScenarioValidator
{
    /**
     * Determines if a create blob is valid
     *
     * @param $blob ScenarioBlob
     *
     * @return ValidationResult
     */
    public function isValidCreateBlob($blob)
    {
        /**
         * @var $fbBlob UnmanagedFacebookBlob
         */
        $fbBlob = $blob->getBlob();
        $result = $this->validateOptionalFields($fbBlob);
        $createResult = $this->validateCreate($fbBlob);
        $createResult->setResult($result->getResult() && $createResult->getResult())
            ->appendError($result->getMessage());

        return $createResult;
    }

    /**
     * Determines if an update blob is valid
     *
     * @param $blob ScenarioBlob
     *
     * @return ValidationResult
     */
    public function isValidUpdateBlob($blob)
    {
        /**
         * @var $fbBlob UnmanagedFacebookBlob
         */
        $fbBlob = $blob->getBlob();
        $result = $this->validateOptionalFields($fbBlob);
        $createResult = $this->validateUpdate($fbBlob);
        $createResult->setResult($result->getResult() && $createResult->getResult())
            ->appendError($result->getMessage());

        return $createResult;
    }

    private function validateOptionalFields(UnmanagedFacebookBlob $facebookBlob)
    {
        return $this->validateTargeting($facebookBlob);
    }

    private function validateTargeting(UnmanagedFacebookBlob $facebookBlob)
    {
        $validationResult = true;
        $validationMessage = "";

        $geographicTargeting = $facebookBlob->getGeographicTargeting(); // instantiated by default
        if (!empty($geographicTargeting) && !$geographicTargeting->isEmpty() && !$geographicTargeting->isValid()) {
            $validationMessage .= "Geographic targeting is invalid. ";
            $validationResult = false;
        }

        $demographicTargeting = $facebookBlob->getDemographicTargeting();
        if (!empty($demographicTargeting) && !$demographicTargeting->isValid()) {
            $validationMessage .= "Demographic targeting is invalid. ";
            $validationResult = false;
        }

        $audienceTargeting = $facebookBlob->getAudienceTargeting(); // instantiated by default
        if (!empty($audienceTargeting) && !$audienceTargeting->isEmpty() && !$audienceTargeting->isValid()) {
            $validationMessage .= "Audience targeting is invalid. ";
            $validationResult = false;
        }

        return new ValidationResult($validationResult, $validationMessage);
    }
}

