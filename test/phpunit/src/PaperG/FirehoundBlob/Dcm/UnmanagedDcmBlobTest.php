<?php

namespace PaperG\Common\Test\Dcm;


use PaperG\FirehoundBlob\Dcm\DcmCreativeAsset;
use PaperG\FirehoundBlob\Dcm\UnmanagedDcmBlob;

class UnmanagedDcmBlobTest extends \FirehoundBlobTestCase
{
    /**
     *
     */
    public function testToFromArray()
    {
        $sut = new UnmanagedDcmBlob();
        $mockAdTag = "mock ad tag";
        $mockCreativeAssetArray = [
            DcmCreativeAsset::ACTIVE => true,
            DcmCreativeAsset::AD_TAG => $mockAdTag
        ];
        $testArray = [
            UnmanagedDcmBlob::CREATIVE_ASSETS => [
                $mockCreativeAssetArray
            ]
        ];

        $sut->fromArray($testArray);
        $assets = $sut->getCreativeAssets();
        $asset = $assets[0];
        $this->assertTrue($asset->isActive());
        $this->assertEquals($mockAdTag,$asset->getAdTag());

        $array = $sut->toArray();
        $this->assertEquals(
            $testArray[UnmanagedDcmBlob::CREATIVE_ASSETS][0][DcmCreativeAsset::ACTIVE],
            $array[UnmanagedDcmBlob::CREATIVE_ASSETS][0][DcmCreativeAsset::ACTIVE]
        );

        $this->assertEquals(
            $testArray[UnmanagedDcmBlob::CREATIVE_ASSETS][0][DcmCreativeAsset::AD_TAG],
            $array[UnmanagedDcmBlob::CREATIVE_ASSETS][0][DcmCreativeAsset::AD_TAG]
        );
    }
} 
