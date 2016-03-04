<?php
/**
 * Created by PhpStorm.
 * User: allentsai
 * Date: 3/3/16
 * Time: 3:29 PM
 */

class FirehoundBlobTestCase extends \PHPUnit_Framework_TestCase{
    protected function buildMock($className)
    {
        return $this->getMockBuilder($className)
            ->disableOriginalConstructor()
            ->getMock();
    }
} 
