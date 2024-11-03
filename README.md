# Notification Bundle for Symfony

The Symfony Bundle was created to support simple notifications.
Compared to previous versions, this one is based on simple methods of creating and adding notifications.

Version 5.0 doesn't have compatibility with previous versions.

## Installation

Composer can install this bundle:

```
$ composer require m-adamski/symfony-notification-bundle
```

## How to use it?

Compared to the previous version, to add a notification, we call the ``add`` function:

```php
use Adamski\Symfony\NotificationBundle\Helper\NotificationHelper;
use Adamski\Symfony\NotificationBundle\Model\Notification;
use Adamski\Symfony\NotificationBundle\Model\Type;

$this->notificationHelper
    ->add(new Notification(Type::SUCCESS, "Sample notification"))
    ->add(new Notification(Type::SUCCESS, "Second sample notification"));
```

The custom Twig function is responsible for displaying notifications (place it somewhere in the template):

```html
{{ notification() }}
```

## License

MIT
