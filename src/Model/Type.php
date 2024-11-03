<?php

namespace Adamski\Symfony\NotificationBundle\Model;

enum Type {
    case ALERT;
    case WARNING;
    case NOTICE;
    case SUCCESS;
    case ERROR;
}
