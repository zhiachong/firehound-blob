<?php
/**
 * Created by PhpStorm.
 * User: allentsai
 * Date: 7/6/16
 * Time: 4:12 PM
 */

namespace PaperG\Common\Test\Facebook;


use PaperG\FirehoundBlob\Facebook\FacebookCreative;
use PaperG\FirehoundBlob\Facebook\FacebookCreativeData;
use PaperG\FirehoundBlob\Facebook\UnmanagedFacebookBlob;

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
        $mockType = 'mock type';
        $mockMediaUrl = 'mock media url';
        $mockPrimary = [
            FacebookCreativeData::MEDIA_URL => $mockMediaUrl,
            FacebookCreativeData::VERSION => FacebookCreativeData::CURRENT_VERSION
        ];

        $mockFacebookCreative = $this->buildMock('PaperG\FirehoundBlob\Facebook\FacebookCreative');
        $mockArray = [
            FacebookCreative::TYPE => $mockType,
            FacebookCreative::VERSION => FacebookCreative::CURRENT_VERSION,
            FacebookCreative::PRIMARY => $mockPrimary,
            FacebookCreative::CHILD_ATTACHMENTS => []
        ];
        $this->addExpectation($mockFacebookCreative, $this->once(), 'toArray', null, $mockArray);
        $mockCreatives = [$mockFacebookCreative];
        $this->sut->setStatus($mockStatus);
        $this->sut->setStartDate($mockStart);
        $this->sut->setEndDate($mockEnd);
        $this->sut->setObjectsToUpdate($mockObjects);
        $this->sut->setAdAccountId($mockAdAccountId);
        $this->sut->setPageId($mockPageId);
        $this->sut->setAccessToken($mockAccessToken);
        $this->sut->setCreatives($mockCreatives);

        $array  = $this->sut->toArray();

        $new = new UnmanagedFacebookBlob();
        $new->fromArray($array);
        $creatives = $new->getCreatives();
        $this->sut->setCreatives([]);
        $new->setCreatives([]);
        $this->assertEquals($this->sut, $new);

        $this->assertEquals($mockMediaUrl, $creatives[0]->getPrimary()->getMediaUrl());
        $this->assertEquals($mockType, $creatives[0]->getType());
    }
}
