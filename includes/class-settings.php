<?php

declare(strict_types=1);

namespace Sleekode\PerformanceCore;

use Sleekode\PerformanceCore\Core\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Settings {


	public function register(): void {

		register_setting(
			'sleekode_performance_core_settings',
			'sleekode_performance_core_settings',
			[
				'sanitize_callback' => [
					Options::class,
					'sanitize',
				],
			]
		);

	}

	public function get(): array {

		return Options::all();

	}

}