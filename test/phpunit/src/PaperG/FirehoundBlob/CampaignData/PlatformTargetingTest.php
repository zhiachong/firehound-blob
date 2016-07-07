<?php

use PaperG\FirehoundBlob\CampaignData\PlatformTargeting;

class PlatformTargetingTest extends FirehoundBlobTestCase
{
    public function test_getSetDesktop_shouldReturnCorrectValue()
    {
        $desktop = true;
        $platformTargeting = new PlatformTargeting(false, false);

        $this->assertFalse($platformTargeting->getDesktop());
        $platformTargeting->setDesktop($desktop);
        $this->assertTrue($platformTargeting->getDesktop());
        $platformTargeting->setDesktop(false);
        $this->assertFalse($platformTargeting->getDesktop());
    }

    public function test_getSetMobile_shouldReturnCorrectValue()
    {
        $mobile = true;
        $platformTargeting = new PlatformTargeting(false, false);

        $this->assertFalse($platformTargeting->getMobile());
        $platformTargeting->setMobile($mobile);
        $this->assertTrue($platformTargeting->getMobile());
        $platformTargeting->setMobile(false);
        $this->assertFalse($platformTargeting->getMobile());
    }

    public function test_isValid_returnsCorrectValues()
    {
        $platformTargeting = new PlatformTargeting(false, false);
        $this->assertFalse($platformTargeting->isValid());
        $platformTargeting->setDesktop(true);
        $this->assertTrue($platformTargeting->isValid());
        $platformTargeting->setMobile(true);
        $this->assertTrue($platformTargeting->isValid());
        $platformTargeting->setDesktop(false);
        $this->assertTrue($platformTargeting->isValid());
    }

    public function test_toFromAssociativeArray_shouldBeCorrect()
    {
        $platformTargeting = new PlatformTargeting(false, false);
        $array = $platformTargeting->toAssociativeArray();
        $this->assertEquals(
            array(
                PlatformTargeting::DESKTOP=> false,
                PlatformTargeting::MOBILE => false,
                PlatformTargeting::VERSION => PlatformTargeting::CURR_VERSION
            ),
            $array
        );

        $newPlatformTargeting = PlatformTargeting::fromAssociativeArray($array);
        $this->assertFalse($newPlatformTargeting->getMobile());
        $this->assertFalse($newPlatformTargeting->getDesktop());
    }
} 
