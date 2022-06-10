<?php

namespace App\Extensions\AuthToken;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Extensions\AuthToken\Guards\JWTGuard;
use App\Extensions\AuthToken\Guards\TokenGuard;
use App\Extensions\AuthToken\Providers\TokenProvider;
use App\Extensions\AuthToken\Support\TokenUser;

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
