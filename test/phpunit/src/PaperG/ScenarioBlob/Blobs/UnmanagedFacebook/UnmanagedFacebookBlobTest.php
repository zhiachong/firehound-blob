<?php
/**
 * Created by PhpStorm.
 * User: allentsai
 * Date: 7/6/16
 * Time: 4:12 PM
 */

namespace PaperG\Common\Test\Facebook;


use PaperG\ScenarioBlob\Blobs\UnmanagedFacebook\UnmanagedFacebookBlob;

class UnmanagedFacebookBlobTest extends \FirehoundBlobTestCase
{
    /**
     * @var UnmanagedFacebookBlob
     */
    private $sut;

    public function setUp()
    {
        $this->sut = new UnmanagedFacebookBlob();
    }

    public function testToFromArray() {
        $mockStatus = "status";
        $mockStart = "start";
        $mockEnd  = "end";
        $mockObjects  = "objects";
        $mockAdAccountId = "ad account";
        $mockPageId = "page id";
        $mockAccessToken  = "mock access token";
        $this->sut->setStatus($mockStatus);
        $this->sut->setStartDate($mockStart);
        $this->sut->setEndDate($mockEnd);
        $this->sut->setObjectsToUpdate($mockObjects);
        $this->sut->setAdAccountId($mockAdAccountId);
        $this->sut->setPageId($mockPageId);
        $this->sut->setAccessToken($mockAccessToken);

        $array  = $this->sut->toArray();

        $new = new UnmanagedFacebookBlob();
        $new->fromArray($array);

        $this->assertEquals($this->sut, $new);
    }
}
