# Twitter Application-only authentication

Twitter Application-only API for Laravel 5.

## Installation

Add `ckailash/twitter-app-only-auth` to `composer.json`.
```
"ckailash/twitter-app-only-auth": "~1.0"
```

Run `composer update` to get the latest version

Or run
```
composer require ckailash/twitter-app-only-auth
```

Now open up `/config/app.php` and add the service provider to your `providers` array.
```php
'providers' => [
	'Ckailash\TwitterAppOnlyAuth\TwitterAppOnlyAuthServiceProvider',
]
```


## Configuration

Run `php artisan vendor:publish` and modify the config file with your own information.
```
/config/ttwitter.php
```

Add the following to your .env file and you'll be on your way:
```
T_CONSUMER_KEY = 
T_CONSUMER_SECRET = 
```
