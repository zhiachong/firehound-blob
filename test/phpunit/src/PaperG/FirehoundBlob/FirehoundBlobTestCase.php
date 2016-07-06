<?php
/**
 * Created by PhpStorm.
 * User: allentsai
 * Date: 3/3/16
 * Time: 3:29 PM
 */

class FirehoundBlobTestCase extends \PHPUnit_Framework_TestCase
{
    protected function buildMock($className)
    {
        return $this->getMockBuilder($className)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function addExpectation(
        PHPUnit_Framework_MockObject_MockObject $mockObject,
        $times,
        $methodName,
        $args = null,
        $retVal = null
    ) {
        $invocation = $mockObject->expects($times)
            ->method($methodName);
        if (!empty($args)) {
            $invocation->with($args);
        }

        if (!empty($retVal)) {
            $invocation->willReturn($retVal);
        }
    }
} 
