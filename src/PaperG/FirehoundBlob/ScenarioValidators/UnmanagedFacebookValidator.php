<?php
/**
 *
 * Author: zhiachong (zTime)
 * Time: 7/14/16 - 3:52 PM
 * Filename: FacebookUnmanagedValidator.php
 */

namespace PaperG\FirehoundBlob\ScenarioValidators;


use PaperG\FirehoundBlob\CampaignData\Budget;
use PaperG\FirehoundBlob\CampaignData\Context;
use PaperG\FirehoundBlob\Facebook\FacebookAdSet;
use PaperG\FirehoundBlob\Facebook\UnmanagedFacebookBlob;
use PaperG\FirehoundBlob\ScenarioBlob;

class UnmanagedFacebookValidator implements ScenarioValidator
{
    private function validateRequiredCreateFields(UnmanagedFacebookBlob $facebookBlob)
    {
        $coreFieldsValidationResults = $this->validateCoreRequiredFields($facebookBlob);
        $validationResult = $coreFieldsValidationResults->getResult();
        $validationMessage = $coreFieldsValidationResults->getMessage();

        $status = $facebookBlob->getStatus();
        if (empty($status) || !$this->validateStatus($status)) {
            $validationMessage .= "Blob doesn't contain valid status. ";
            $validationResult = false;
        }

        $adSets = $facebookBlob->getAdSets();
        if (empty($adSets) || !$this->validateAdSets($adSets)) {
            $validationMessage .= "Blob doesn't contain ad sets or the ad sets are not valid. ";
            $validationResult = false;
        }

        $creatives = $facebookBlob->getCreatives();
        $isValid = true;
        if (!empty($creatives)) {
            foreach ($creatives as $creative) {
                if (!$creative->isValid()) {
                    $isValid = false;
                    break;
                }
            }
        }

        if (empty($creatives) || !$isValid) {
            $validationMessage .= "Blob doesn't contain any creative or the creatives are not valid. ";
            $validationResult = false;
        }

        return new ValidationResult($validationResult, $validationMessage);
    }

    private function validateRequiredUpdateFields(UnmanagedFacebookBlob $facebookBlob)
    {
        $coreFieldsValidationResults = $this->validateCoreRequiredFields($facebookBlob);
        $validationResult = $coreFieldsValidationResults->getResult();
        $validationMessage = $coreFieldsValidationResults->getMessage();

        $status = $facebookBlob->getStatus();
        if (!empty($status) && !$this->validateStatus($status)) {
            $validationMessage .= "Blob doesn't contain valid status. Status is: " . $status;
            $validationResult = false;
        }

        $adSets = $facebookBlob->getAdSets();
        if (!empty($adSets) && !$this->validateAdSets($adSets)) {
            $validationMessage .= "Blob doesn't contain ad sets or the ad sets are not valid. ";
            $validationResult = false;
        }

        $creatives = $facebookBlob->getCreatives();
        $isValid = true;
        if (!empty($creatives)) {
            foreach ($creatives as $creative) {
                if (!$creative->isValid()) {
                    $isValid = false;
                    break;
                }
            }
        }

        if (!$isValid) {
            $validationMessage .= "Blob doesn't contain any creative or the creatives are not valid. ";
            $validationResult = false;
        }

        return new ValidationResult($validationResult, $validationMessage);
    }

    private function validateCoreRequiredFields(UnmanagedFacebookBlob $facebookBlob)
    {
        $validationResult  = true;
        $validationMessage = '';

        $adAcctId = $facebookBlob->getAdAccountId();
        if (empty($adAcctId) || !is_string($adAcctId)) {
            $validationMessage .= "Blob doesn't contain a valid ad account ID. ";
            $validationResult = false;
        }

        $pageId = $facebookBlob->getPageId();
        if (empty($pageId) || !is_string($pageId)) {
            $validationMessage .= "Blob doesn't contain a valid page ID. ";
            $validationResult = false;
        }

        $accessToken = $facebookBlob->getAccessToken();
        if (empty($accessToken) || !is_string($accessToken)) {
            $validationMessage .= "Blob doesn't contain a valid access token. ";
            $validationResult = false;
        }

        return new ValidationResult($validationResult, $validationMessage);
    }

    private function validateOptionalFields(UnmanagedFacebookBlob $facebookBlob)
    {
        $validateTargeting = $this->validateTargeting($facebookBlob);
        $validationResult = $validateTargeting->getResult();
        $validationMessage = $validateTargeting->getMessage();

        $startDate = $facebookBlob->getStartDate();
        if (!empty($startDate) && !is_numeric($startDate)) {
            $validationMessage .= "Start date is non-numerical. ";
            $validationResult = false;
        }

        $endDate = $facebookBlob->getEndDate();
        if (!empty($endDate) && !is_numeric($endDate)) {
            $validationMessage .= "End date is non-numerical. ";
            $validationResult = false;
        }

        $budget = $facebookBlob->getBudget();
        if (!empty($budget) && !$this->validateBudget($budget)) {
            $validationMessage .= "Budget is invalid. ";
            $validationResult = false;
        }

        return new ValidationResult($validationResult, $validationMessage);
    }

    private function validateTargeting(UnmanagedFacebookBlob $facebookBlob)
    {
        $validationResult = true;
        $validationMessage = "";

        $geographicTargeting = $facebookBlob->getGeographicTargeting();
        if (!empty($geographicTargeting) && !$geographicTargeting->isValid()) {
            $validationMessage .= "Geographic targeting is invalid. ";
            $validationResult = false;
        }

        $demographicTargeting = $facebookBlob->getDemographicTargeting();
        if (!empty($demographicTargeting) && !$demographicTargeting->isValid()) {
            $validationMessage .= "Demographic targeting is invalid. ";
            $validationResult = false;
        }

        $audienceTargeting = $facebookBlob->getAudienceTargeting();
        if (!empty($audienceTargeting) && !$audienceTargeting->isValid()) {
            $validationMessage .= "Audience targeting is invalid. ";
            $validationResult = false;
        }

        return new ValidationResult($validationResult, $validationMessage);
    }

    private function validateStatus($status) {
        $validStatuses = [Context::STATUS_ACTIVE, Context::STATUS_INACTIVE];
        return is_string($status) && in_array(strtolower($status), $validStatuses);
    }

    /**
     * @param $facebookAdSets FacebookAdSet []
     *
     * @return bool
     */
    private function validateAdSets($facebookAdSets)
    {
        if (!empty($facebookAdSets)) {
            foreach ($facebookAdSets as $adSet) {
                /** @var $adSet FacebookAdSet */
                if (!$adSet->validate()) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param $budget
     *
     * @return bool
     */
    private function validateBudget(Budget $budget)
    {
        if ($budget->getBudgetType() != Budget::BUDGET_TYPE_DAILY ||
            $budget->getAmountType() != Budget::AMOUNT_TYPE_DOLLAR ||
            !$budget->isValid()
        ) {
            return false;
        }

        return true;
    }

    private function validate(ScenarioBlob $blob, $isCreate)
    {
        $facebookBlob = $blob->getBlob();

        if (empty($facebookBlob)) {

            return new ValidationResult(false, "Facebook unmanaged blob is empty.");
        }

        $validateResults = ($isCreate) ?
            $this->validateRequiredCreateFields($facebookBlob) :
            $this->validateRequiredUpdateFields($facebookBlob);

        $optionalFieldsValidationResults = $this->validateOptionalFields($facebookBlob);
        $validationResult = $validateResults->getResult() && $optionalFieldsValidationResults->getResult();
        $validationMessage = $validateResults->getMessage() . $optionalFieldsValidationResults->getMessage();

        return new ValidationResult($validationResult, $validationMessage);
    }
    /**
     * Determines if a create blob is valid
     *
     * @param $blob ScenarioBlob
     *
     * @return ValidationResult
     */
    public function isValidCreateBlob($blob)
    {
        return $this->validate($blob, true);
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
        return $this->validate($blob, false);
    }
}

