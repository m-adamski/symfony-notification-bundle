<?php

namespace Adamski\Symfony\NotificationBundle\Helper;

use Adamski\Symfony\NotificationBundle\Model\Notification;

class NotificationHelper {
    const DEFAULT_NAMESPACE = "_application.notifications";
    private array $notifications = [];

    /**
     * Add notification to the namespace collection.
     *
     * @param Notification $notification
     * @param string       $namespace
     * @return $this
     */
    public function add(Notification $notification, string $namespace = self::DEFAULT_NAMESPACE): self {
        $this->notifications[$namespace][] = $notification;

        return $this;
    }

    /**
     * Get notification from the namespace collection.
     *
     * @param string $namespace
     * @return array
     */
    public function get(string $namespace = self::DEFAULT_NAMESPACE): array {
        return $this->notifications[$namespace] ?? [];
    }

    /**
     * Clear notifications in the namespace collection.
     *
     * @param string $namespace
     * @return $this
     */
    public function clear(string $namespace = self::DEFAULT_NAMESPACE): self {
        $this->notifications[$namespace] = [];

        return $this;
    }
}
