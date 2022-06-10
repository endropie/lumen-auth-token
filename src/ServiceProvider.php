<?php

namespace Endropie\LumenAuthToken;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Endropie\LumenAuthToken\Guards\JWTGuard;
use Endropie\LumenAuthToken\Guards\TokenGuard;
use Endropie\LumenAuthToken\Providers\TokenProvider;
use Endropie\LumenAuthToken\Support\TokenUser;

class ServiceProvider extends BaseServiceProvider
{
	public function boot(): void
	{
		$this->extendAuthGuard();
	}

	public function register(): void
	{
        //
	}

	private function extendAuthGuard(): void
	{
		$this->app->auth->extend('jwt', function ($app, $name, array $config) {

			if ($config['provider'] == 'token') {
				return new TokenGuard(new TokenProvider(TokenUser::class));
			}

			return new JWTGuard(auth()->createUserProvider($config['provider']));
		});
	}
}
