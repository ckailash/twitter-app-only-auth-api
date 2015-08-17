<?php namespace Ckailash\TwitterAppOnlyAuth\Commands;

use Illuminate\Console\Command;
use tmhOAuth;

class GenerateBearer extends Command
{

	protected $name = 'twitter-app-only-auth:generate-bearer {consumer_key} {consumer_secret}';

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'twitter-app-only-auth:generate-bearer
                        {consumer_key : Twitter Consumer Key}
                        {consumer_secret : Twitter Consumer Secret}';

	protected $description = 'Generates bearer token to be used for app only requests';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	private function safe_encode($data)
	{
		if (is_array($data)) {
			return array_map(array($this, 'safe_encode'), $data);
		} else if (is_scalar($data)) {
			return str_ireplace(
				array('+', '%7E'),
				array(' ', '~'),
				rawurlencode($data)
			);
		} else {
			return '';
		}
	}

	private function bearerTokenCredentials()
	{
		$consumerKey = $this->argument('consumer_key');
		$consumerSecret = $this->argument('consumer_secret');

		$credentials = implode(':', array(
			$this->safe_encode($consumerKey),
			$this->safe_encode($consumerSecret)
		));
		return base64_encode($credentials);
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$bearer = $this->bearerTokenCredentials();
		$params = array(
			'grant_type' => 'client_credentials',
		);
		$tmhOAuth = new tmhOAuth([
			'consumer_key' => $this->argument('consumer_key'),
			'consumer_secret' => $this->argument('consumer_secret')
		]);

		$code = $tmhOAuth->request(
			'POST',
			$tmhOAuth->url('/oauth2/token', null),
			$params,
			false,
			false,
			array(
				'Authorization' => "Basic ${bearer}"
			)
		);
		if ($code == 200) {
			$data = json_decode($tmhOAuth->response['response']);
			if (isset($data->token_type) && strcasecmp($data->token_type, 'bearer') === 0) {
				$new_bearer = $data->access_token;
				echo 'Your app-only bearer token is: ' . $new_bearer . PHP_EOL;
			}
		} else {
			print_r($tmhOAuth->response);
		}
	}

}