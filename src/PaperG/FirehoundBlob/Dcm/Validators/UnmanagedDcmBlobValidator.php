<?php

namespace PaperG\FirehoundBlob\Dcm\Validators;


use PaperG\FirehoundBlob\Dcm\UnmanagedDcmBlob;
use PaperG\FirehoundBlob\ScenarioValidators\ScenarioValidator;
use PaperG\FirehoundBlob\ScenarioValidators\ValidationResult;

class UnmanagedDcmBlobValidator implements ScenarioValidator
{
    private $assetValidator;

    public function __construct(DcmCreativeAssetValidator $assetValidator = null)
    {
        $this->assetValidator = isset($assetValidator) ? $assetValidator : new DcmCreativeAssetValidator();
    }

    /**
     * @param UnmanagedDcmBlob $blob
     * @return array|void
     */
    public function isValidCreateBlob($blob)
    {
        $result = $this->isValid($blob);
        $valid = $result->getResult();
        $messages = [$result->getMessage()];

        $assets = $blob->getCreativeAssets();

        if (!empty($assets)) {
            foreach ($assets as $asset) {
                $result = $this->assetValidator->isValidCreate($asset);
                if (!$result->getResult()) {
                    $valid = false;
                    $messages[] = $result->getMessage();
                }
            }
        }

        return new ValidationResult($valid, implode(' ', $messages));
    }

    /**
     * @param UnmanagedDcmBlob $blob
     * @return array|void
     */
    public function isValidUpdateBlob($blob)
    {
        $result = $this->isValid($blob);
        $valid = $result->getResult();
        $messages = [$result->getMessage()];
        $assets = $blob->getCreativeAssets();
        if (!empty($assets)) {
            foreach ($assets as $asset) {
                $result = $this->assetValidator->isValidUpdate($asset);
                if (!$result->getResult()) {
                    $valid = false;
                    $messages[] = $result->getMessage();
                }
            }
        }

        return new ValidationResult($valid, implode(' ', $messages));
    }

    private function isValid(UnmanagedDcmBlob $blob) {
        $valid = true;
        $messages = [];

        $advertiserId = $blob->getAdvertiserId();
        if (empty($advertiserId)) {
            $valid = false;
            $messages[] = 'Missing AdvertiserId for UnmanagedDcmBlob creation request.';
        }

        $assets = $blob->getCreativeAssets();
        if (empty($assets)) {
            $valid = false;
            $messages[] = 'DCM blob must have creative assets.';
        }

        $publicationId = $blob->getPublicationId();
        if (empty($publicationId)) {
            $valid = false;
            $messages[] = 'Missing AdvertiserId for UnmanagedDcmBlob creation request.';
        }

        return new ValidationResult($valid, implode(' ', $messages));
    }
} 
