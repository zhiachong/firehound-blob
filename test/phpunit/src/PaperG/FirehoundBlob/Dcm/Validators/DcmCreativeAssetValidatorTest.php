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
        $result = $this->sut->isValidCreate($validAsset);
        $this->assertEquals('', $result->getMessage());
        $this->assertTrue($result->getResult());
    }

    public function testIsValidCreateReturnsFalse()
    {
        $invalidAsset = new DcmCreativeAsset();
        $result = $this->sut->isValidCreate($invalidAsset);
        $this->assertFalse($result->getResult());
        $expectedString = "Uuid is required for create. ImageUrl is required for create. AdTag is required for create.";
        $this->assertEquals($expectedString, $result->getMessage());
    }

    public function testIsValidUpdateReturnsTrue()
    {
        $validAsset = new DcmCreativeAsset();
        $validAsset->setUuid('mock uuid');
        $validAsset->setImageUrl('mock image url');
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
        $expectedString = "At least ad tag or image url must be given for update, neither were provided.";
        $this->assertEquals($expectedString, $result->getMessage());
    }
} 
