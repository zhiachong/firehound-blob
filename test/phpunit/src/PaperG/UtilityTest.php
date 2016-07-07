<?php
/**
 * Created by PhpStorm.
 * User: allentsai
 * Date: 7/6/16
 * Time: 3:40 PM
 */

namespace src\PaperG;


class UtilityTest extends \FirehoundBlobTestCase
{
    /**
     * @var object
     */
    private $sut;

    public function setUp()
    {
        $this->sut = $this->getObjectForTrait('\PaperG\FirehoundBlob\Utility');
    }

    /**
     * @coversDefaultClass safeGet
     */
    public function testSafeGet()
    {
        $mockValue  = "mockValue";
        $mockKey = "mockKey";
        $mockArray = [$mockKey => $mockValue];
        $mockMissingKey = "missingKey";
        $mockDefault = "mockDefault";
        $result = $this->sut->safeGet($mockArray, $mockKey);
        $this->assertEquals($mockValue, $result);

        $result = $this->sut->safeGet($mockArray, $mockMissingKey, $mockDefault);
        $this->assertEquals($mockDefault, $result);
    }
} 
