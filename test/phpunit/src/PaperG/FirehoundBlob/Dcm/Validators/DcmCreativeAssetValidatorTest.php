<?php

namespace PaperG\Common\Test\Dcm\Validators;

use PaperG\FirehoundBlob\Dcm\DcmCreativeAsset;
use PaperG\FirehoundBlob\Dcm\Validators\DcmCreativeAssetValidator;

class DcmCreativeAssetValidatorTest extends \FirehoundBlobTestCase
{
    /**
     * @var DcmCreativeAssetValidator
     */
    private $sut;

    public function setUp()
    {
        $this->sut = new DcmCreativeAssetValidator();
    }

    public function testIsValidCreateReturnsTrue()
    {
        $validAsset = new DcmCreativeAsset();
        $validAsset->setUuid('mock uuid');
        $validAsset->setImageUrl('mock image url');
        $validAsset->setAdTag('mock ad tag');
        $validAsset->setAdSizeName('Ad size Name');
        $result = $this->sut->isValidCreate($validAsset);
        $this->assertEquals('', $result->getMessage());
        $this->assertTrue($result->getResult());
    }

    public function testIsValidCreateReturnsFalse()
    {
        $invalidAsset = new DcmCreativeAsset();
        $result = $this->sut->isValidCreate($invalidAsset);
        $this->assertFalse($result->getResult());
        $expectedString = "[uuid] NULL value found, but a string is required. "
            . "ImageUrl is required for create. "
            . "AdTag is required for create.";
        $this->assertEquals($expectedString, $result->getMessage());
    }

    public function testIsValidUpdateReturnsTrue()
    {
        $validAsset = new DcmCreativeAsset();
        $validAsset->setUuid('mock uuid');
        $validAsset->setImageUrl('mock image url'); //Tests that we don't need ad tag
        $result = $this->sut->isValidUpdate($validAsset);
        $this->assertTrue($result->getResult());
        $this->assertEquals('', $result->getMessage());
    }

    public function testIsValidUpdateReturnsFalse()
    {
        $invalidAsset = new DcmCreativeAsset();
        $invalidAsset->setUuid('mock uuid');
        $result = $this->sut->isValidUpdate($invalidAsset);
        $this->assertFalse($result->getResult());
        $expectedString = "Ad Tag or Image Url must be provided";
        $this->assertEquals($expectedString, $result->getMessage());
    }

    public function testIsValidCreateInvalidAdSizeName()
    {
        $validAsset = new DcmCreativeAsset();
        $validAsset->setUuid('mock uuid');
        $validAsset->setImageUrl('mock image url');
        $validAsset->setAdTag('mock ad tag');
        $validAsset->setAdSizeName(1234);
        $result = $this->sut->isValidCreate($validAsset);
        $this->assertEquals(
            '[adSizeName] Integer value found, but a string or a null is required.',
            $result->getMessage()
        );
        $this->assertFalse($result->getResult());
    }

    public function testIsValidUpdateInvalidAdSizeName()
    {
        $validAsset = new DcmCreativeAsset();
        $validAsset->setUuid('mock uuid');
        $validAsset->setImageUrl('mock image url');
        $validAsset->setAdTag('mock ad tag');
        $validAsset->setAdSizeName(1234);
        $result = $this->sut->isValidUpdate($validAsset);
        $this->assertEquals('[adSizeName] Integer value found, but a string or a null is required.', $result->getMessage());
        $this->assertFalse($result->getResult());
    }

    public function testIsValidUpdateValidAdSizeName()
    {
        $validAsset = new DcmCreativeAsset();
        $validAsset->setUuid('mock uuid');
        $validAsset->setImageUrl('mock image url');
        $validAsset->setAdTag('mock ad tag');
        $validAsset->setAdSizeName('asdf');
        $result = $this->sut->isValidUpdate($validAsset);
        $this->assertEquals('', $result->getMessage());
        $this->assertTrue($result->getResult());
    }
} 
