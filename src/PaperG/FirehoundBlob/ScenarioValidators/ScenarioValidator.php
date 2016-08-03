<?php
/**
 *
 * Author: zhiachong (zTime)
 * Time: 7/14/16 - 3:44 PM
 * Filename: ScenarioValidator.php
 */

namespace PaperG\FirehoundBlob\ScenarioValidators;

use PaperG\FirehoundBlob\BlobInterface;
use PaperG\FirehoundBlob\ScenarioBlob;

interface ScenarioValidator {

    const VALIDATION_RESULT = "validationResult";
    const VALIDATION_MESSAGE = "validationMessage";

    /**
     * Determines if a create blob is valid
     * @param $blob BlobInterface
     *
     * @return ValidationResult
     */
    public function isValidCreateBlob($blob);

    /**
     * Determines if an update blob is valid
     * @param $blob BlobInterface
     *
     * @return ValidationResult
     */
    public function isValidUpdateBlob($blob);
}

