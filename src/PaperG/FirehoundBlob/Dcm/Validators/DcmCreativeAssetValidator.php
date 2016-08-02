<?php

namespace PaperG\FirehoundBlob\Dcm\Validators;


use PaperG\FirehoundBlob\Dcm\DcmCreativeAsset;
use PaperG\FirehoundBlob\ScenarioValidators\ValidationResult;

class DcmCreativeAssetValidator
{
    public function isValidCreate(DcmCreativeAsset $asset)
    {
        $valid = true;
        $messages = [];
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

    public function isValidUpdate(DcmCreativeAsset $asset)
    {
        $valid = true;
        $messages = [];
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
} 
