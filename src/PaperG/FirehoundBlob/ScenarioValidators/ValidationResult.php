<?php

namespace PaperG\FirehoundBlob\ScenarioValidators;


class ValidationResult
{
    private $result;
    private $message;

    public function __construct($result, $message) {
        $this->result = $result;
        $this->message = $message;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getMessage()
    {
        return $this->message;
    }
} 
