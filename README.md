# Notification Bundle for Symfony

The Symfony Bundle, which aims to simplify the communication with the end user.
By using simple functions, we can create information that will later be displayed to the user.

## Installation

This bundle can be installed by Composer:

```
$ composer require m-adamski/symfony-notification-bundle
```

## How to use it?

The helper provides a set of functions with which you can add a notification to the set, create a notification redirection, clear the list of all notifications.

| Method                    | Description                                                                                                                     |
| ------------------------- | ------------------------------------------------------------------------------------------------------------------------------- |
| addNotification           | The function adds a notification of a specific type and message content                                                         |
| redirectNotification      | The function returns a redirection to a specific URL address and adds a notification about certain parameters                   |
| routeRedirectNotification | Like the redirectNotification function, a redirection to a specific route is returned. Notification is created and added to set |
| clear                     | The function clears the set of all notifications                                                                                |
| getNotifications          | The function returns a list of all notifications                                                                                |

In order for the notifications to be displayed, a reference to the function should be placed in the template.

```(html)
{{ notification() }}
```

## License

MIT
