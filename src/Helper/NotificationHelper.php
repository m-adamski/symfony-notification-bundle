<?php

namespace Adamski\Symfony\NotificationBundle\Helper;

use Adamski\Symfony\NotificationBundle\Model\Notification;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

class NotificationHelper {

    const SESSION_NAMESPACE = "_notification_bundle.notification";

    const ALERT_TYPE = "alert";
    const SUCCESS_TYPE = "success";
    const WARNING_TYPE = "warning";
    const ERROR_TYPE = "error";
    const INFO_TYPE = "info";
    const INFORMATION_TYPE = "information";

    private array           $allowedTypes = ["alert", "success", "warning", "error", "info", "information"];
    private RequestStack    $requestStack;
    private RouterInterface $router;

    /**
     * @param RequestStack    $requestStack
     * @param RouterInterface $router
     */
    public function __construct(RequestStack $requestStack, RouterInterface $router) {
        $this->requestStack = $requestStack;
        $this->router = $router;
    }

    /**
     * Add Notification with specified type and text.
     *
     * @param string $type
     * @param string $text
     */
    public function addNotification(string $type, string $text): void {

        // Check if specified notification type is allowed
        if (!in_array($type, $this->allowedTypes)) {
            throw new InvalidArgumentException("Specified notification type is not allowed");
        }

        // Get stored Notifications
        $storedNotifications = $this->requestStack->getSession()->get(self::SESSION_NAMESPACE);

        // Add new Notification
        $storedNotifications[] = new Notification($type, $text);

        // Store Notifications in Session
        $this->requestStack->getSession()->set(self::SESSION_NAMESPACE, $storedNotifications);
    }

    /**
     * Add Notification and redirect to specified Url.
     *
     * @param string $url
     * @param string $type
     * @param string $text
     * @return RedirectResponse
     */
    public function redirectNotification(string $url, string $type, string $text): RedirectResponse {
        $this->addNotification($type, $text);

        return new RedirectResponse($url);
    }

    /**
     * Add Notification and redirect to specified Route.
     *
     * @param string $route
     * @param string $type
     * @param string $text
     * @param array  $routeParams
     * @return RedirectResponse
     */
    public function routeRedirectNotification(string $route, string $type, string $text, array $routeParams = []): RedirectResponse {
        return $this->redirectNotification(
            $this->router->generate($route, $routeParams), $type, $text
        );
    }

    /**
     * Clear Notifications collection.
     */
    public function clear(): void {
        $this->requestStack->getSession()->set(self::SESSION_NAMESPACE, []);
    }

    /**
     * Get Notifications collection.
     *
     * @return array
     */
    public function getNotifications(): array {
        return $this->requestStack->getSession()->get(self::SESSION_NAMESPACE);
    }
}
