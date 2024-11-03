<?php

namespace Adamski\Symfony\NotificationBundleTests\Helper;

use Adamski\Symfony\NotificationBundle\Helper\NotificationHelper;
use Adamski\Symfony\NotificationBundle\Model\Notification;
use Adamski\Symfony\NotificationBundle\Model\Type;
use PHPUnit\Framework\TestCase;

class NotificationHelperTest extends TestCase {
    protected NotificationHelper $notificationHelper;

    protected function setUp(): void {
        $this->notificationHelper = new NotificationHelper();
    }

    public function testCollection(): void {

        $firstSampleNotification = new Notification(Type::WARNING, "First Sample Notification");
        $secondSampleNotification = new Notification(Type::SUCCESS, "Second Sample Notification");

        // Add sample notifications
        $this->notificationHelper
            ->add($firstSampleNotification)
            ->add($secondSampleNotification)
            ->add($firstSampleNotification, "sample-namespace");

        $defaultNamespace = [$firstSampleNotification, $secondSampleNotification];
        $sampleNamespace = [$firstSampleNotification];

        $this->assertEquals($defaultNamespace, $this->notificationHelper->get());
        $this->assertEquals($sampleNamespace, $this->notificationHelper->get("sample-namespace"));
    }

    public function testClear(): void {
        $sampleNotification = new Notification(Type::WARNING, "Sample Notification");
        $this->notificationHelper->add($sampleNotification);

        $this->assertEquals([$sampleNotification], $this->notificationHelper->get());

        $this->notificationHelper->clear();
        $this->assertEquals([], $this->notificationHelper->get());
    }
}
