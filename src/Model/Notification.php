<?php

namespace Adamski\Symfony\NotificationBundle\Model;

class Notification {

    protected string $type;
    protected string $text;

    /**
     * Notification constructor.
     *
     * @param string $type
     * @param string $text
     */
    public function __construct(string $type, string $text) {
        $this->type = $type;
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getType(): string {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getText(): string {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void {
        $this->text = $text;
    }

    /**
     * @return array
     */
    public function __serialize(): array {
        return [$this->getType(), $this->getText()];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void {
        list($this->type, $this->text) = $data;
    }
}
