<?php

declare(strict_types=1);

namespace Sleekode\PerformanceCore;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Security {

	public static function verify_nonce(
		string $action,
		string $nonce
	): bool {

		return (bool) wp_verify_nonce(
			$nonce,
			$action
		);
	}


	public static function can_manage(): bool {

		return current_user_can(
			'manage_options'
		);
	}
}