# notify-php

Simple Class for sending JSON-RPC notifications as POST-Request.
Can for example be used together with [notify-bridge](https://github.com/xat/notify-bridge) to
send notifications out of PHP to Browser-Clients (Push notifications).

```php
// Create an an instance,
// using the default configuration
$notify = new Notify();

// Send an update notification
$notify->emit('update');

// Send an update notification
// with some data attached
$notify->emit('update', array('yet another notification'));
```

For more information just look into the Code of the class. There
is not much magic going on.

## License
Copyright (c) 2012 Simon Kusterer
Licensed under the MIT license.