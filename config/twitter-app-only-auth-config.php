<?php

/**
 * Your package config would go here
 */

return [

	'API_URL'             => 'api.twitter.com',
	'API_VERSION'         => '1.1',
	'AUTHENTICATE_URL'    => 'https://api.twitter.com/oauth/authenticate',
	'AUTHORIZE_URL'       => 'https://api.twitter.com/oauth/authorize',
	'ACCESS_TOKEN_URL'    => 'https://api.twitter.com/oauth/access_token',
	'REQUEST_TOKEN_URL'   => 'https://api.twitter.com/oauth/request_token',
	'USE_SSL'             => true,

	'CONSUMER_KEY'        => env('T_CONSUMER_KEY', ''),
	'CONSUMER_SECRET'     => env('T_CONSUMER_SECRET', ''),
	'BEARER_TOKEN'        => env('T_BEARER_TOKEN', ''),
];
