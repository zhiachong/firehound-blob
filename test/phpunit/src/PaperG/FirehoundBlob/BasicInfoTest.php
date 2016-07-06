<?php
/**
 * Created by PhpStorm.
 * User: allentsai
 * Date: 7/6/16
 * Time: 1:42 PM
 */

namespace PaperG\Common\Test;


use PaperG\FirehoundBlob\BasicInfo;

class BasicInfoTest extends \FirehoundBlobTestCase
{
    /**
     * @var BasicInfo
     */
    private $sut;

    public function setUp()
    {
        $this->sut = new BasicInfo();
    }

    public function testToFromArray()
    {
        $mockName = "mock name";
        $mockUuid = "mockUuid";
        $mockMeta = "mockMeta";
        $mockScenario = "mockScenario";
        $mockBlobArray = ["mock values"];
        $mockBlob = $this->buildMock('PaperG\FirehoundBlob\BlobInterface');
        $this->addExpectation($mockBlob, $this->once(), 'toArray', null, $mockBlobArray);
        $this->sut->setBlob($mockBlob);
        $this->sut->setName($mockName);
        $this->sut->setUuid($mockUuid);
        $this->sut->setMetadata($mockMeta);
        $this->sut->setScenario($mockScenario);

        $array = $this->sut->toArray();
        $array[BasicInfo::BLOB] = $mockBlob;

        $newBlob = new BasicInfo();
        $newBlob->fromArray($array);

        $this->assertEquals($this->sut, $newBlob);
    }
} 
