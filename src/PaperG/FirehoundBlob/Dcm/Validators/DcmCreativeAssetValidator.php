<?php

namespace PaperG\FirehoundBlob\Dcm\Validators;

use PaperG\FirehoundBlob\Dcm\DcmCreativeAsset;
use PaperG\FirehoundBlob\ScenarioValidators\ValidationResult;

class DcmCreativeAssetValidator
{
    /**
     * @param DcmCreativeAsset $asset
     * @return ValidationResult
     */
    public function isValidCreate(DcmCreativeAsset $asset)
    {
        $result = $this->validateAssetTypes($asset);
        $valid = $result->getResult();
        $messages = [];

        $message = $result->getMessage();
        if (!empty($message)) {
            $messages[] = $message;
        }

        $uuid = $asset->getUuid();
        if (empty($uuid)) {
            $valid = false;
            $messages[] = "Uuid is required for create.";
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
        $result = $this->validateAssetTypes($asset);
        $valid = $result->getResult();
        $messages = [];

        $message = $result->getMessage();
        if (!empty($message)) {
            $messages[] = $message;
        }

        $uuid = $asset->getUuid();
        if (empty($uuid)) {
            $valid = false;
            $messages[] = "Uuid is required for update.";
        }

        $imageUrl = $asset->getImageUrl();
        $adTag = $asset->getAdTag();
        if (empty($imageUrl) && empty($adTag)) {
            $valid = false;
            $messages[] = "At least ad tag or image url must be given for update, neither were provided.";
        }

        return new ValidationResult($valid, implode(" ", $messages));
    }

    private function validateAssetTypes(DcmCreativeAsset $asset)
    {
        $valid = true;
        $messages = [];

        $uuid = $asset->getUuid();
        if (!empty($uuid) && !is_string($uuid)) {
            $valid = false;
            $messages[] = 'Uuid must be a string.';
        }

        $adTag = $asset->getAdTag();
        if (!empty($adTag) && !is_string($adTag)) {
            $valid = false;
            $messages[] = 'Ad tag must be a string.';
        }

        $imageUrl = $asset->getImageUrl();
        if (!empty($imageUrl) && !is_string($imageUrl)) {
            $valid = false;
            $messages[] = 'Image url must be a string.';
        }

        $width = $asset->getWidth();
        if (!empty($width) && !is_int($width)) {
            $valid = false;
            $messages[] = 'Width must be an int.';
        }

        $height = $asset->getHeight();
        if (!empty($height) && !is_int($height)) {
            $valid = false;
            $messages[] = 'Height must be an int.';
        }

        $name = $asset->getName();
        if (!empty($name) && !is_string($name)) {
            $valid = false;
            $messages[] = 'Name must be a string.';
        }

        $platform = $asset->getPlatform();
        if (!empty($platform) && !is_string($platform)) {
            $valid = false;
            $messages[] = 'Platform must be a string';
        }

        return new ValidationResult($valid, implode(" ", $messages));
    }
} 
