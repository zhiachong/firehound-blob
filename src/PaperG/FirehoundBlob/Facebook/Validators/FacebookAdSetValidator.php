<?php

namespace PaperG\FirehoundBlob\Facebook\Validators;

use PaperG\FirehoundBlob\Facebook\FacebookAdSet;
use PaperG\FirehoundBlob\JsonValidator;

class FacebookAdSetValidator extends JsonValidator
{
    const RELATIVE_PATH = '/../../Schema/Facebook/facebookAdSet.json';

    protected function getSchemaPath()
    {
        return 'file://' . realpath(__DIR__ . self::RELATIVE_PATH);
    }

    /**
     * @param FacebookAdSet $adSet
     * @return \PaperG\FirehoundBlob\ScenarioValidators\ValidationResult
     */
    public function validate($adSet)
    {
        return parent::validate($adSet->toAssociativeArray());
    }
} 
