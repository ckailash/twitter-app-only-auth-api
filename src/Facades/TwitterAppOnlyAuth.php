<?php namespace Ckailash\TwitterAppOnlyAuth\Facades;

use Illuminate\Support\Facades\Facade;

class TwitterAppOnlyAuth extends Facade {
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'twitter_app_only_auth'; }
}