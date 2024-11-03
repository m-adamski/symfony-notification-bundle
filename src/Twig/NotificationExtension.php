<?php

namespace Adamski\Symfony\NotificationBundle\Twig;

use Adamski\Symfony\NotificationBundle\Helper\NotificationHelper;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NotificationExtension extends AbstractExtension {
    public function __construct(
        private readonly NotificationHelper $notificationHelper,
    ) {
    }

    public function getFunctions(): array {
        return [
            new TwigFunction("notification", [$this, "renderNotification"], ["is_safe" => ["html"], "needs_environment" => true])
        ];
    }

    public function renderNotification(Environment $twig, string $namespace = NotificationHelper::DEFAULT_NAMESPACE): string {
        return $twig->render("@Notification/notification.html.twig", [
            "notifications" => $this->notificationHelper->get($namespace)
        ]);
    }
}
