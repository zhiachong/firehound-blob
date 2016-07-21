<?php
/**
 *
 * Author: zhiachong (zTime)
 * Time: 7/18/16 - 2:24 PM
 * Filename: BasicInfoValidatorTest.php
 */
namespace PaperG\Common\Test;

use PaperG\ScenarioBlob\ScenarioValidators\BasicInfoValidator;

class BasicInfoValidatorTest extends \PHPUnit_Framework_TestCase
{
    private $sut;

    public function setUp()
    {
        $this->sut = new BasicInfoValidator();
    }

    public function test_isValidCreateBlob_WithValidBlobAndIsCreateRequest_ReturnsTrue()
    {
        $mockScenarioBlob = $this->getMockBuilder('PaperG\ScenarioBlob\ScenarioBlob')->disableOriginalConstructor()->getMock();
        $mockBasicInfo    = $this->getMockBuilder('\PaperG\ScenarioBlob\BasicInfo')->disableOriginalConstructor()->getMock();

        $mockScenarioBlob->expects($this->once())
                         ->method('getBasicInfo')
                         ->will($this->returnValue($mockBasicInfo));

        $mockBasicInfo->expects($this->once())
                      ->method('getName')
                      ->will($this->returnValue('hello world'));
        $mockBasicInfo->expects($this->once())
                      ->method('getUuid')
                      ->will($this->returnValue('129-csdf'));
        $mockBasicInfo->expects($this->once())
                      ->method('getMetadata')
                      ->will($this->returnValue('Hello world this is a testing framework'));
        $mockBasicInfo->expects($this->once())
                      ->method('getScenario')
                      ->will($this->returnValue('AppNexus-Desktop'));

        $results = $this->sut->isValidCreateBlob($mockScenarioBlob);
        $this->assertEquals(true, $results['validationResult']);
    }

    public function test_isValidCreateBlob_WithMissingScenarioAndIsCreateRequest_ReturnsFalse()
    {
        $mockScenarioBlob = $this->getMockBuilder('PaperG\ScenarioBlob\ScenarioBlob')->disableOriginalConstructor()->getMock();
        $mockBasicInfo    = $this->getMockBuilder('\PaperG\ScenarioBlob\BasicInfo')->disableOriginalConstructor()->getMock();

        $mockScenarioBlob->expects($this->once())
                         ->method('getBasicInfo')
                         ->will($this->returnValue($mockBasicInfo));

        $mockBasicInfo->expects($this->once())
                      ->method('getName')
                      ->will($this->returnValue('hello world'));
        $mockBasicInfo->expects($this->once())
                      ->method('getUuid')
                      ->will($this->returnValue('129-csdf'));
        $mockBasicInfo->expects($this->once())
                      ->method('getMetadata')
                      ->will($this->returnValue('Hello world this is a testing framework'));
        $mockBasicInfo->expects($this->once())
                      ->method('getScenario')
                      ->will($this->returnValue(''));

        $results = $this->sut->isValidCreateBlob($mockScenarioBlob);
        $this->assertEquals(false, $results['validationResult']);
        $this->assertEquals("Basic info does not contain valid scenario. ", $results["validationMessage"]);
    }

    public function test_isValidUpdateBlob_WithUpdateRequest_ReturnsFalse()
    {
        $mockScenarioBlob = $this->getMockBuilder('PaperG\ScenarioBlob\ScenarioBlob')->disableOriginalConstructor()->getMock();
        $mockBasicInfo    = $this->getMockBuilder('\PaperG\ScenarioBlob\BasicInfo')->disableOriginalConstructor()->getMock();

        $mockScenarioBlob->expects($this->once())
                         ->method('getBasicInfo')
                         ->will($this->returnValue($mockBasicInfo));

        $mockBasicInfo->expects($this->once())
                      ->method('getName')
                      ->will($this->returnValue(1234)); // 1234 is a number, not a string. Should error
        $mockBasicInfo->expects($this->once())
                      ->method('getUuid')
                      ->will($this->returnValue([1, 2, 3])); // this is an array, not a string. Should error
        $mockBasicInfo->expects($this->once())
                      ->method('getMetadata')
                      ->will($this->returnValue('Hello world this is a testing framework'));
        $mockBasicInfo->expects($this->once())
                      ->method('getScenario')
                      ->will($this->returnValue('')); // Scenario is not one of the valid scenarios

        $results = $this->sut->isValidUpdateBlob($mockScenarioBlob);
        $this->assertEquals(false, $results['validationResult']);
        $this->assertEquals(
            "Basic info's name is not a valid string. Basic info's UUID is not a valid string. Basic info does not contain valid scenario. ",
            $results["validationMessage"]
        );
    }

}

