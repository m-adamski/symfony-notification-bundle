<?php

namespace Adamski\Symfony\NotificationBundle\Model;

class Notification {
    public function __construct(
        private Type   $type,
        private string $message,
    ) {}

    public function getType(): Type {
        return $this->type;
    }

    public function setType(Type $type): Notification {
        $this->type = $type;
        return $this;
    }

    public function getMessage(): string {
        return $this->message;
    }

    public function setMessage(string $message): Notification {
        $this->message = $message;
        return $this;
    }

    public function __serialize(): array {
        return [$this->getType(), $this->getMessage()];
    }

    public function __unserialize(array $data): void {
        list($this->type, $this->message) = $data;
    }
}
