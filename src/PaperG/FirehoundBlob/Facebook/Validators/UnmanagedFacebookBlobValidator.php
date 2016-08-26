<?php

namespace PaperG\FirehoundBlob\Facebook\Validators;

use PaperG\FirehoundBlob\Facebook\UnmanagedFacebookBlob;
use PaperG\FirehoundBlob\JsonValidator;

class UnmanagedFacebookBlobValidator extends JsonValidator
{
    const RELATIVE_PATH = '/../../Schema/Facebook/unmanagedFacebookBlob.json';
    const RELATIVE_CREATE_PATH = '/../../Schema/Facebook/unmanagedFacebookBlobCreate.json';
    const RELATIVE_UPDATE_PATH = '/../../Schema/Facebook/unmanagedFacebookBlobUpdate.json';
    private $path;

    protected function getSchemaPath()
    {
        if (empty($this->path)) {
            return 'file://' . realpath(__DIR__ . self::RELATIVE_PATH);
        }

        return 'file://' . realpath(__DIR__ . $this->path);
    }

    public function validateCreate(UnmanagedFacebookBlob $blob)
    {
        $this->path = self::RELATIVE_CREATE_PATH;
        return parent::validate($blob->toArray());
    }

    public function validateUpdate(UnmanagedFacebookBlob $blob)
    {
        $this->path = self::RELATIVE_UPDATE_PATH;
        return parent::validate($blob->toArray());
    }
}
