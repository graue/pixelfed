<?php

namespace App\Services;

use Cache;

class MarkerService
{
	const CACHE_KEY = 'pf:services:markers:timeline:';

	public static function get($profileId, $timeline = 'home')
	{
		return Cache::get(self::CACHE_KEY . $timeline . ':' . $profileId);
	}

	public static function set($profileId, $timeline = 'home', $entityId)
	{
		$existing = self::get($profileId, $timeline);
		$key = self::CACHE_KEY . $timeline . ':' . $profileId;
		$val = [
			'last_read_id' => (string) $entityId,
			'version' => $existing ? ($existing['version'] + 1) : 1,
			'updated_at' => now()->format('c')
		];
		Cache::put($key, $val, 2592000);
		return $val;
	}
}
