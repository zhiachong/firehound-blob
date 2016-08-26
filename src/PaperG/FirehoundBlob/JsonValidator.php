<?php

namespace PaperG\FirehoundBlob;

use JsonSchema\Validator;
use PaperG\FirehoundBlob\ScenarioValidators\ValidationResult;

abstract class JsonValidator
{

    /**
     * @var \JsonSchema\Validator
     */
    private $validator;

    public function __construct(Validator $validator = null)
    {
        $this->validator = isset($validator) ? $validator : new Validator();
    }

    abstract protected function getSchemaPath();

    public function validate($data)
    {
        $data = json_decode(json_encode($data));
        $this->validator->check($data, (object)['$ref' => $this->getSchemaPath()]);
        $result = false;

        if ($this->validator->isValid()) {
            return new ValidationResult(true, '');
        }

        $messages = array_map(
            function ($error) {
                return sprintf("[%s] %s.", $error['property'], $error['message']);
            },
            $this->validator->getErrors()
        );

        return new ValidationResult($result, trim(implode(' ', $messages)));
    }
} 
