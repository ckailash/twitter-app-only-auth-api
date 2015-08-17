<?php namespace Ckailash\TwitterAppOnlyAuth;

use Exception;
use tmhOAuth;

class TwitterAppOnlyAuth extends tmhOAuth
{

	private $tConfig;

	private $parentConfig;

	private $debug;
	private $log = [];

	public function __construct($config = array())
	{

		$this->tConfig = $config;

		if (is_array($config['twitter-app-only-auth-config::config']))
		{
			$this->tConfig = $config['twitter-app-only-auth-config::config'];
		}
		else if (is_array($config['twitter-app-only-auth-config']))
		{
			$this->tConfig = $config['twitter-app-only-auth-config'];
		}
		else
		{
			throw new Exception('No config found');
		}

		if (empty($this->tConfig['CONSUMER_KEY']) || empty($this->tConfig['CONSUMER_SECRET'])) {

			throw new Exception('Config empty! Please check the package configuration file');

		}

		$this->debug = (isset($this->tConfig['debug']) && $this->tConfig['debug']) ? true : false;

		$this->parentConfig = [];
		$this->parentConfig['consumer_key'] = $this->tConfig['CONSUMER_KEY'];
		$this->parentConfig['consumer_secret'] = $this->tConfig['CONSUMER_SECRET'];
		$this->parentConfig['use_ssl'] = $this->tConfig['USE_SSL'];
		$this->parentConfig['user_agent'] = "cktaoa " . parent::VERSION;

		parent::__construct($this->parentConfig);

	}

	private function log($message)
	{
		if ($this->debug) {
			$this->log[] = $message;
		}
	}

	private function logs()
	{
		return $this->log;
	}

	private function formatResponse($response, $format = 'object')
	{
		switch ($format) {
			default :
			case 'object' :
				$retResponse = json_decode($response['response']);
				break;
			case 'json'   :
				$retResponse = $response['response'];
				break;
			case 'array'  :
				$retResponse = json_decode($response['response'], true);
				break;
		}

		return $retResponse;
	}

	public function query($name, $reqMethod = 'GET', $params = [])
	{
		$this->config['host'] = $this->tConfig['API_URL'];

		$url = parent::url($this->tConfig['API_VERSION'] . '/' . $name);

		$queryParams = [
			'method' => $reqMethod,
			'host' => $name,
			'url' => $url,
			'params' => $params
		];

		\Log::info("qp = ".print_r($queryParams, true));

		parent::apponly_request($queryParams);

		$response = $this->response;

		$error = $response['error'];

		if ($error) {
			$this->log('ERROR_CODE : ' . $response['errorno']);
			$this->log('ERROR_MSG : ' . $response['error']);
		}

		if (isset($response['code']) && $response['code'] != 200) {
			$_response = json_decode($response['response'], true);

			if (array_key_exists('errors', $_response)) {
				$error_code = $_response['errors'][0]['code'];
				$error_msg = $_response['errors'][0]['message'];
			} else {
				$error_code = $response['code'];
				$error_msg = $_response['error'];
			}

			$this->log('ERROR_CODE : ' . $error_code);
			$this->log('ERROR_MSG : ' . $error_msg);
			throw new Exception('[' . $error_code . '] ' . $error_msg, $response['code']);
		}

		if (isset($params['format'])) {
			$retResponse = $this->formatResponse($response, $params['format']);
		} else {
			$retResponse = $this->formatResponse($response);
		}

		return $retResponse;
	}

	public function get($name, $params = [])
	{
		return $this->query($name, 'GET', $params);
	}

	/**
	 * Returns a collection of relevant Tweets matching a search term.
	 *
	 * Parameters :
	 * - q
	 * - geocode
	 * - lang
	 * - locale
	 * - result_type (mixed|recent|popular)
	 * - count (1-100)
	 * - until (YYYY-MM-DD)
	 * - since_id
	 * - max_id
	 *
	 */
	public function getSearch($params = [])
	{
		if (!array_key_exists('q', $params)) {
			throw new Exception('Parameter required missing : q');
		}

		return $this->get('search/tweets', $params);
	}
}