<?php

namespace Adamski\Symfony\NotificationBundle\Twig;

use Adamski\Symfony\NotificationBundle\Helper\NotificationHelper;
use Exception;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NotificationExtension extends AbstractExtension {

    /**
     * @param NotificationHelper $notificationHelper
     */
    public function __construct(
        protected readonly NotificationHelper $notificationHelper
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array {
        return [
            new TwigFunction("notification", [$this, "renderNotification"], ["is_safe" => ["html"], "needs_environment" => true])
        ];
    }

    /**
     * Render Notifications template.
     *
     * @param Environment $environment
     * @return bool|string
     */
    public function renderNotification(Environment $environment): bool|string {

        // Get stored Notifications
        $storedNotifications = $this->notificationHelper->getNotifications();

        if (count($storedNotifications) > 0) {
            try {
                return $environment->render("@Notification/notification.html.twig", ["notifications" => $storedNotifications]);
            } catch (Exception $exception) {
                return false;
            }
        }

        return false;
    }
}
