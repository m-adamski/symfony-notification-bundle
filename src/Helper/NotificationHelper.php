<?php

namespace Adamski\Symfony\NotificationBundle\Helper;

use Adamski\Symfony\NotificationBundle\Model\Notification;
use Symfony\Component\HttpFoundation\RequestStack;

class NotificationHelper {
    const DEFAULT_NAMESPACE = "_application.session.notifications";

    public function __construct(
        private readonly RequestStack $requestStack,
    ) {}

    /**
     * Add notification to the namespace collection.
     *
     * @param Notification $notification
     * @param string       $namespace
     *
     * @return $this
     */
    public function add(Notification $notification, string $namespace = self::DEFAULT_NAMESPACE): self {
        $this->requestStack->getSession()->set($namespace, [...$this->get($namespace), $notification]);

        return $this;
    }

    /**
     * Get notification from the namespace collection.
     *
     * @param string $namespace
     *
     * @return array
     */
    public function get(string $namespace = self::DEFAULT_NAMESPACE): array {
        return $this->requestStack->getSession()->remove($namespace) ?? [];
    }

    /**
     * Clear notifications in the namespace collection.
     *
     * @param string $namespace
     *
     * @return $this
     */
    public function clear(string $namespace = self::DEFAULT_NAMESPACE): self {
        $this->requestStack->getSession()->set($namespace, []);

        return $this;
    }
}
