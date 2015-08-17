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

Run `composer dump-autoload` to reload the autoload files

Run `php artisan twitter-app-only-auth:generate-bearer <twitter-consumer-key> <twitter-consumer-key-secret>` to get the bearer token required to interact with the twitter API as an app.

Run `php artisan vendor:publish` and modify the config file with your own information.
```
/config/twitter-app-only-auth-config.php
```

Add the following to your .env file and you'll be on your way:
```
T_CONSUMER_KEY= 
T_CONSUMER_SECRET= 
T_BEARER_TOKEN= 
```
