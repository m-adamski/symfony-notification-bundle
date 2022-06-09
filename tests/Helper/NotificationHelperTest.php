<?php

namespace Adamski\Symfony\NotificationBundleTests\Helper;

use Adamski\Symfony\NotificationBundle\Helper\NotificationHelper;
use Adamski\Symfony\NotificationBundle\Model\Notification;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;

class NotificationHelperTest extends TestCase {

    protected array              $notificationBag;
    protected NotificationHelper $notificationHelper;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void {
        $sessionMock = $this->createMock(Session::class);
        $sessionMock->method("set")->willReturnCallback([$this, "setSession"]);
        $sessionMock->method("get")->willReturnCallback([$this, "getSession"]);

        $requestStackMock = $this->createMock(RequestStack::class);
        $requestStackMock->method("getSession")->willReturn($sessionMock);

        $routerMock = $this->createMock(Router::class);
        $routerMock->method("generate")->willReturn("http://example.com");

        $this->notificationBag = [];
        $this->notificationHelper = new NotificationHelper($requestStackMock, $routerMock);
    }

    /**
     * Test of addNotification method.
     */
    public function testAddNotification(): void {

        // Add sample notification & create expected collection
        $this->notificationHelper->addNotification(NotificationHelper::ERROR_TYPE, "text");
        $expectedCollection[] = new Notification(NotificationHelper::ERROR_TYPE, "text");

        $this->assertEquals($expectedCollection, $this->getSession("_notification_bundle.notification"));
    }

    /**
     * Test of clear method.
     */
    public function testClear(): void {

        // Add sample notification & create expected collection
        $this->notificationHelper->addNotification(NotificationHelper::ERROR_TYPE, "text");
        $expectedCollection[] = new Notification(NotificationHelper::ERROR_TYPE, "text");

        $this->assertEquals($expectedCollection, $this->getSession("_notification_bundle.notification"));

        // Clear session
        $this->notificationHelper->clear();
        $this->assertEquals([], $this->getSession("_notification_bundle.notification"));
    }

    /**
     * Test of getNotifications method.
     */
    public function testGetNotifications(): void {

        // Add sample notification & create expected collection
        $this->notificationHelper->addNotification(NotificationHelper::ERROR_TYPE, "text");
        $expectedCollection[] = new Notification(NotificationHelper::ERROR_TYPE, "text");

        $this->assertEquals($expectedCollection, $this->notificationHelper->getNotifications());
    }

    /**
     * @param string $namespace
     * @return array
     */
    public function getSession(string $namespace): array {
        return array_key_exists($namespace, $this->notificationBag) ? $this->notificationBag[$namespace] : [];
    }

    /**
     * @param string $namespace
     * @param array  $notification
     */
    public function setSession(string $namespace, array $notification): void {
        $this->notificationBag[$namespace] = $notification;
    }
}
