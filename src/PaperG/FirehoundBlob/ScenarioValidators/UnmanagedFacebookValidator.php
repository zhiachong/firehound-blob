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
use PaperG\FirehoundBlob\Facebook\FacebookCreative;
use PaperG\FirehoundBlob\Facebook\Targeting\FacebookAudienceTargeting;
use PaperG\FirehoundBlob\Facebook\Targeting\FacebookDemographicTargeting;
use PaperG\FirehoundBlob\Facebook\Targeting\FacebookGeographicTargeting;
use PaperG\FirehoundBlob\Facebook\UnmanagedFacebookBlob;
use PaperG\FirehoundBlob\ScenarioBlob;

class UnmanagedFacebookValidator implements ScenarioValidator
{
    private function validateRequiredCreateFields(UnmanagedFacebookBlob $facebookBlob)
    {
        $validationMessage = '';
        $validationResult  = true;

        $coreFieldsValidationResults = $this->validateCoreRequiredFields($facebookBlob);
        $validationResult &= $coreFieldsValidationResults[self::VALIDATION_RESULT];
        $validationMessage .= $coreFieldsValidationResults[self::VALIDATION_MESSAGE];

        $status = $facebookBlob->getStatus();
        if (empty($status) || !$this->validateStatus($status)) {
            $validationMessage .= "Blob doesn't contain valid status. ";
            $validationResult &= false;
        }

        $adSets = $facebookBlob->getAdSets();
        if (empty($adSets) || !$this->validateAdSets($adSets)) {
            $validationMessage .= "Blob doesn't contain ad sets or the ad sets are not valid. ";
            $validationResult &= false;
        }

        $creative = $facebookBlob->getCreative();
        if (empty($creative) || !$this->validateCreative($creative)) {
            $validationMessage .= "Blob doesn't contain creative or the creative is not valid. ";
            $validationResult &= false;
        }

        return [self::VALIDATION_RESULT => $validationResult, self::VALIDATION_MESSAGE => $validationMessage];
    }

    private function validateRequiredUpdateFields(UnmanagedFacebookBlob $facebookBlob)
    {
        $validationResult = true;
        $validationMessage = '';

        $coreFieldsValidationResults = $this->validateCoreRequiredFields($facebookBlob);
        $validationResult &= $coreFieldsValidationResults[self::VALIDATION_RESULT];
        $validationMessage .= $coreFieldsValidationResults[self::VALIDATION_MESSAGE];

        $status = $facebookBlob->getStatus();
        if (!empty($status) && !$this->validateStatus($status)) {
            $validationMessage .= "Blob doesn't contain valid status. Status is: " . $status;
            $validationResult &= false;
        }

        $adSets = $facebookBlob->getAdSets();
        if (!empty($adSets) && !$this->validateAdSets($adSets)) {
            $validationMessage .= "Blob doesn't contain ad sets or the ad sets are not valid. ";
            $validationResult &= false;
        }

        $creative = $facebookBlob->getCreative();
        if (empty($creative) || !$this->validateCreative($creative)) {
            $validationMessage .= "Blob doesn't contain creative or the creative is not valid. ";
            $validationResult &= false;
        }

        return [self::VALIDATION_RESULT => $validationResult, self::VALIDATION_MESSAGE => $validationMessage];
    }

    private function validateCoreRequiredFields(UnmanagedFacebookBlob $facebookBlob)
    {
        $validationResult  = true;
        $validationMessage = '';

        $adAcctId = $facebookBlob->getAdAccountId();
        if (empty($adAcctId) || !is_string($adAcctId)) {
            $validationMessage .= "Blob doesn't contain a valid ad account ID. ";
            $validationResult &= false;
        }

        $pageId = $facebookBlob->getPageId();
        if (empty($pageId) || !is_string($pageId)) {
            $validationMessage .= "Blob doesn't contain a valid page ID. ";
            $validationResult &= false;
        }

        $accessToken = $facebookBlob->getAccessToken();
        if (empty($accessToken) || !is_string($accessToken)) {
            $validationMessage .= "Blob doesn't contain a valid access token. ";
            $validationResult &= false;
        }

        return [
            self::VALIDATION_RESULT  => $validationResult,
            self::VALIDATION_MESSAGE => $validationMessage
        ];
    }

    private function validateOptionalFields(UnmanagedFacebookBlob $facebookBlob)
    {
        $validationResult  = true;
        $validationMessage = '';

        $startDate = $facebookBlob->getStartDate();
        if (!empty($startDate) && !is_numeric($startDate)) {
            $validationMessage .= "Start date is non-numerical. ";
            $validationResult &= false;
        }

        $endDate = $facebookBlob->getEndDate();
        if (!empty($endDate) && !is_numeric($endDate)) {
            $validationMessage .= "End date is non-numerical. ";
            $validationResult &= false;
        }

        $budget = $facebookBlob->getBudget();
        if (!empty($budget) && !$this->validateBudget($budget)) {
            $validationMessage .= "Budget is invalid. ";
            $validationResult &= false;
        }

        $geographicTargeting = $facebookBlob->getGeographicTargeting();
        if (!empty($geographicTargeting) && !$this->validateGeographicTargeting($geographicTargeting)) {
            $validationMessage .= "Geographic targeting is invalid. ";
            $validationResult &= false;
        }

        $demographicTargeting = $facebookBlob->getDemographicTargeting();
        if (!empty($demographicTargeting) && !$this->validateDemographicTargeting($demographicTargeting)) {
            $validationMessage .= "Demographic targeting is invalid. ";
            $validationResult &= false;
        }

        $audienceTargeting = $facebookBlob->getAudienceTargeting();
        if (!empty($audienceTargeting) && !$this->validateAudienceTargeting($audienceTargeting)) {
            $validationMessage .= "Audience targeting is invalid. ";
            $validationResult &= false;
        }

        return [self::VALIDATION_RESULT => $validationResult, self::VALIDATION_MESSAGE => $validationMessage];
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
     * @param $creative FacebookCreative
     *
     * @return bool
     */
    private function validateCreative($creative)
    {
        if (!empty($creative)) {
            $creativeData = $creative->getObjects();
            $creativeType = $creative->getType();

            if (empty($creativeType) || empty($creativeData)) {
                return false;
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

    private function validateGeographicTargeting(FacebookGeographicTargeting $geoTargeting)
    {
        if (!(
            (!empty($geoTargeting->getCountryAction()) && !empty($geoTargeting->getCountryIds())) ||
            (!empty($geoTargeting->getCityAction()) && !empty($geoTargeting->getCityIds())) ||
            (!empty($geoTargeting->getRegionAction()) && !empty($geoTargeting->getRegionIds())) ||
            (!empty($geoTargeting->getPostalAction()) && !empty($geoTargeting->getPostalCodes()))
        )
        ) {
            return false;
        }

        return true;
    }

    private function validateDemographicTargeting(FacebookDemographicTargeting $demographicTargeting)
    {
        if ($demographicTargeting->getMinAge() < 18 ||
            $demographicTargeting->getMaxAge() > 65
        ) {
            return false;
        }

        return true;
    }

    private function validateAudienceTargeting(FacebookAudienceTargeting $audienceTargeting)
    {
        if (empty($audienceTargeting->getType()) ||
            empty($audienceTargeting->getIds()) ||
            !is_array(($audienceTargeting->getIds()))
        ) {
            return false;
        }

        return true;
    }

    /**
     * Determines if a create blob is valid
     *
     * @param $blob ScenarioBlob
     *
     * @return array Example: {"validationResult": true , "validationMessage": "status is not filled" }
     */
    public function isValidCreateBlob($blob)
    {
        $facebookBlob = $blob->getBlob();

        if (empty($facebookBlob)) {
            return [self::VALIDATION_RESULT => false, self::VALIDATION_MESSAGE => "Facebook unmanaged blob is empty. "];
        }

        $validateResults = $this->validateRequiredCreateFields($facebookBlob);
        $optionalFieldsValidationResults = $this->validateOptionalFields($facebookBlob);

        return [
            self::VALIDATION_RESULT  => $validateResults[self::VALIDATION_RESULT] && $optionalFieldsValidationResults[self::VALIDATION_RESULT],
            self::VALIDATION_MESSAGE => $validateResults[self::VALIDATION_MESSAGE] . $optionalFieldsValidationResults[self::VALIDATION_MESSAGE]
        ];
    }

    /**
     * Determines if an update blob is valid
     *
     * @param $blob ScenarioBlob
     *
     * @return array Example: {"validationResult": true , "validationMessage": "status is not filled" }
     */
    public function isValidUpdateBlob($blob)
    {
        $facebookBlob = $blob->getBlob();

        if (empty($facebookBlob)) {
            return [self::VALIDATION_RESULT => false, self::VALIDATION_MESSAGE => "Facebook unmanaged blob is empty. "];
        }

        $validateResults = $this->validateRequiredUpdateFields($facebookBlob);
        $optionalFieldsValidationResults = $this->validateOptionalFields($facebookBlob);

        return [
            self::VALIDATION_RESULT  => $validateResults[self::VALIDATION_RESULT] && $optionalFieldsValidationResults[self::VALIDATION_RESULT],
            self::VALIDATION_MESSAGE => $validateResults[self::VALIDATION_MESSAGE] . $optionalFieldsValidationResults[self::VALIDATION_MESSAGE]
        ];
    }
}

