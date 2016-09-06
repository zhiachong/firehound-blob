<?php

namespace PaperG\FirehoundBlob\Dcm\Validators;


use PaperG\FirehoundBlob\Dcm\UnmanagedDcmBlob;
use PaperG\FirehoundBlob\JsonValidator;
use PaperG\FirehoundBlob\ScenarioBlob;
use PaperG\FirehoundBlob\ScenarioValidators\ScenarioValidator;
use PaperG\FirehoundBlob\ScenarioValidators\ValidationResult;

class UnmanagedDcmBlobValidator extends JsonValidator implements ScenarioValidator
{

    const RELATIVE_PATH = '/../../Schema/Dcm/unmanagedDcmBlob.json';

    private $assetValidator;

    public function __construct(DcmCreativeAssetValidator $assetValidator = null)
    {
        parent::__construct();
        $this->assetValidator = isset($assetValidator) ? $assetValidator : new DcmCreativeAssetValidator();
    }

    protected function getSchemaPath()
    {
        return 'file://' . realpath(__DIR__ . self::RELATIVE_PATH);
    }

    /**
     * @param ScenarioBlob $blob
     * @return ValidationResult
     */
    public function isValidCreateBlob($blob)
    {
        /**
         * @var $dcmBlob UnmanagedDcmBlob
         */
        $dcmBlob = $blob->getBlob();
        $result = $this->isValid($dcmBlob);
        $valid = $result->getResult();
        $messages = [$result->getMessage()];

        $assets = $dcmBlob->getCreativeAssets();

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
     * @param ScenarioBlob $blob
     * @return ValidationResult
     */
    public function isValidUpdateBlob($blob)
    {
        /**
         * @var $dcmBlob UnmanagedDcmBlob
         */
        $dcmBlob = $blob->getBlob();
        $dcmResult = $this->isValid($dcmBlob);
        $valid = $dcmResult->getResult();
        $messages = [];
        $message = $dcmResult->getMessage();
        if (!empty($message)) {
            $messages[] = $message;
        }

        $assets = $dcmBlob->getCreativeAssets();
        if (!empty($assets)) {
            foreach ($assets as $asset) {
                $result = $this->assetValidator->isValidUpdate($asset);
                if (!$result->getResult()) {
                    $valid = false;
                    $messages[] = $result->getMessage();
                }
            }
        }

        return new ValidationResult($valid, implode(" ", $messages));
    }

    /**
     * @param UnmanagedDcmBlob $blob
     * @return ValidationResult
     */
    private function isValid(UnmanagedDcmBlob $blob) {
        return $this->validate($blob->toArray());
    }
} 
