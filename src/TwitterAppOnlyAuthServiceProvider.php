<?php namespace Ckailash\TwitterAppOnlyAuth;

use Ckailash\TwitterAppOnlyAuth\Commands\GenerateBearer;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class TwitterAppOnlyAuthServiceProvider extends LaravelServiceProvider
{

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->handleConfigs();
		$this->registerCommands();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		// Bind any implementations.
		$app = $this->app ?: app();

		$this->commands('generatebearer');

		$this->app['twitter_app_only_auth'] = $this->app->share(function () use ($app) {
			return new TwitterAppOnlyAuth($app['config']);
		});

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{

		return ['twitter_app_only_auth'];

	}

	private function handleConfigs()
	{

		$configPath = __DIR__ . '/../config/twitter-app-only-auth-config.php';

		$this->publishes([$configPath => config_path('twitter-app-only-auth-config.php')]);

		$this->mergeConfigFrom($configPath, 'twitter-app-only-auth-config');
	}

	private function registerCommands()
	{
		$this->app['generatebearer'] = $this->app->share(function($app)
		{
			return new GenerateBearer();
		});
	}
}
