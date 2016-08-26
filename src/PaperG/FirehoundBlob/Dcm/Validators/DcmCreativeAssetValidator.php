<?php

namespace PaperG\FirehoundBlob\Dcm\Validators;

use PaperG\FirehoundBlob\Dcm\DcmCreativeAsset;
use PaperG\FirehoundBlob\JsonValidator;
use PaperG\FirehoundBlob\ScenarioValidators\ValidationResult;

class DcmCreativeAssetValidator extends JsonValidator
{

    const RELATIVE_PATH = '/../../Schema/Dcm/dcmCreativeAsset.json';

    protected function getSchemaPath()
    {
        return 'file://' . realpath(__DIR__ . self::RELATIVE_PATH);
    }

    /**
     * @param DcmCreativeAsset $asset
     * @return ValidationResult
     */
    public function isValidCreate(DcmCreativeAsset $asset)
    {
        $result = $this->validate($asset->toArray());
        $valid = $result->getResult();
        $messages = [];

        $message = $result->getMessage();
        if (!empty($message)) {
            $messages[] = $message;
        }

        $imageUrl = $asset->getImageUrl();
        if (empty($imageUrl)) {
            $valid = false;
            $messages[] = "ImageUrl is required for create.";
        }

        $adTag = $asset->getAdTag();
        if (empty($adTag)) {
            $valid = false;
            $messages[] = "AdTag is required for create.";
        }

        return new ValidationResult($valid, implode(" ", $messages));
    }

    /**
     * @param DcmCreativeAsset $asset
     * @return ValidationResult
     */
    public function isValidUpdate(DcmCreativeAsset $asset)
    {
        $result = $this->validate($asset->toArray());
        $valid = $result->getResult();
        $messages = [];
        $message = $result->getMessage();
        if (!empty($message)) {
            $messages[] = $message;
        }

        $imageUrl = $asset->getImageUrl();
        $adTag = $asset->getAdTag();
        if (empty($imageUrl) && empty($adTag)) {
            $messages[] = "Ad Tag or Image Url must be provided";
            $valid = false;
        }

        return new ValidationResult($valid, implode(" ", $messages));
    }
} 
