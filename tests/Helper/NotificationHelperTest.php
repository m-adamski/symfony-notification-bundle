<?php

namespace Adamski\Symfony\NotificationBundleTests\Helper;

use Adamski\Symfony\NotificationBundle\Helper\NotificationHelper;
use Adamski\Symfony\NotificationBundle\Model\Notification;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\Routing\Router;

class NotificationHelperTest extends TestCase {

    /**
     * @var array
     */
    protected $notificationBag;

    /**
     * @var NotificationHelper
     */
    protected $notificationHelper;

    /**
     * {@inheritdoc}
     */
    protected function setUp() {
        $sessionMock = $this->createMock(FlashBag::class);
        $sessionMock->method("set")->willReturnCallback([$this, "setSession"]);
        $sessionMock->method("get")->willReturnCallback([$this, "getSession"]);

        $routerMock = $this->createMock(Router::class);
        $routerMock->method("generate")->willReturn("http://example.com");

        $this->notificationBag = [];
        $this->notificationHelper = new NotificationHelper($sessionMock, $routerMock);
    }

    /**
     * Test of addNotification method.
     */
    public function testAddNotification() {

        // Add sample notification & create expected collection
        $this->notificationHelper->addNotification(NotificationHelper::ERROR_TYPE, "text");
        $expectedCollection[] = new Notification(NotificationHelper::ERROR_TYPE, "text");

        $this->assertEquals($expectedCollection, $this->getSession("NotificationsBag"));
    }

    /**
     * Test of clear method.
     */
    public function testClear() {

        // Add sample notification & create expected collection
        $this->notificationHelper->addNotification(NotificationHelper::ERROR_TYPE, "text");
        $expectedCollection[] = new Notification(NotificationHelper::ERROR_TYPE, "text");

        $this->assertEquals($expectedCollection, $this->getSession("NotificationsBag"));

        // Clear session
        $this->notificationHelper->clear();
        $this->assertEquals([], $this->getSession("NotificationsBag"));
    }

    /**
     * Test of getNotifications method.
     */
    public function testGetNotifications() {

        // Add sample notification & create expected collection
        $this->notificationHelper->addNotification(NotificationHelper::ERROR_TYPE, "text");
        $expectedCollection[] = new Notification(NotificationHelper::ERROR_TYPE, "text");

        $this->assertEquals($expectedCollection, $this->notificationHelper->getNotifications());
    }

    /**
     * @param string $namespace
     * @return array
     */
    public function getSession(string $namespace) {
        return array_key_exists($namespace, $this->notificationBag) ? $this->notificationBag[$namespace] : [];
    }

    /**
     * @param string $namespace
     * @param array  $notification
     */
    public function setSession(string $namespace, array $notification) {
        $this->notificationBag[$namespace] = $notification;
    }
}
