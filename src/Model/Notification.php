<?php

namespace Adamski\Symfony\NotificationBundle\Model;

use Serializable;

class Notification implements Serializable {

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
    public function setType(string $type) {
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
    public function setText(string $text) {
        $this->text = $text;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): ?string {
        return serialize([
            $this->type,
            $this->text
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized) {
        list ($this->type, $this->text) = unserialize($serialized);
    }
}
