<?php

namespace Adamski\Symfony\NotificationBundleTests\Helper;

use Adamski\Symfony\NotificationBundle\Helper\NotificationHelper;
use Adamski\Symfony\NotificationBundle\Model\Notification;
use Adamski\Symfony\NotificationBundle\Model\Type;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

class NotificationHelperTest extends TestCase {
    protected array $notificationBag;
    protected NotificationHelper $notificationHelper;

    protected function setUp(): void {
        $sessionMock = $this->createMock(Session::class);
        $sessionMock->method("set")->willReturnCallback([$this, "setSession"]);
        $sessionMock->method("get")->willReturnCallback([$this, "getSession"]);
        $sessionMock->method("remove")->willReturnCallback([$this, "removeSession"]);

        $requestStackMock = $this->createMock(RequestStack::class);
        $requestStackMock->method("getSession")->willReturn($sessionMock);

        $this->notificationBag = [];
        $this->notificationHelper = new NotificationHelper($requestStackMock);
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

    public function getSession(string $namespace): array {
        return array_key_exists($namespace, $this->notificationBag) ? $this->notificationBag[$namespace] : [];
    }

    public function removeSession(string $namespace): array {
        $sessionValue = $this->getSession($namespace);
        $this->notificationBag[$namespace] = [];

        return $sessionValue;
    }

    public function setSession(string $namespace, array $notification): void {
        $this->notificationBag[$namespace] = $notification;
    }
}
