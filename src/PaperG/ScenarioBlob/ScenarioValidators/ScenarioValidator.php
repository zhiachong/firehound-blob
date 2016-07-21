<?php
/**
 *
 * Author: zhiachong (zTime)
 * Time: 7/14/16 - 3:44 PM
 * Filename: ScenarioValidator.php
 */

namespace PaperG\ScenarioBlob\ScenarioValidators;

use PaperG\ScenarioBlob\ScenarioBlob;

interface ScenarioValidator {

    const VALIDATION_RESULT = "validationResult";
    const VALIDATION_MESSAGE = "validationMessage";

    /**
     * Determines if a create blob is valid
     * @param $blob ScenarioBlob
     *
     * @return array Example: {"validationResult": true , "validationMessage": "status is not filled" }
     */
    public function isValidCreateBlob($blob);

    /**
     * Determines if an update blob is valid
     * @param $blob ScenarioBlob
     *
     * @return array Example: {"validationResult": true , "validationMessage": "status is not filled" }
     */
    public function isValidUpdateBlob($blob);
}

