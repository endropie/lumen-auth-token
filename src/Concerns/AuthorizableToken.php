<?php

namespace App\Extensions\AuthToken\Concerns;

use Illuminate\Support\Carbon;
use App\Extensions\AuthToken\Support\JWT;

trait AuthorizableToken
{
	public function getJwtId(): string
	{
		return $this->getKey();
	}

	public function getJwtValidFromTime(): ?Carbon
	{
		return null;
	}

	public function getJwtValidUntilTime(): ?Carbon
	{
		$expiration = config('jwt.expiration');

		return $expiration ? app(Carbon::class)->now()->addMinutes($expiration) : null;
	}

	public function getJwtCustomClaims(): array
	{
		return [];
	}

	public function token(array $config = []): string
	{
		return JWT::encodeToken($this, $config);
	}
}
