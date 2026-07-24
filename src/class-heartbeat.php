<?php

declare(strict_types=1);

namespace Sleekode\PerformanceCore;

use Sleekode\PerformanceCore\Core\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Heartbeat {

	public function boot(): void {

		add_filter(
			'heartbeat_settings',
			[
				$this,
				'modify_interval',
			]
		);
	}


	public function modify_interval(
		array $settings
	): array {

		$interval = Options::heartbeat_interval();


		if ( $interval >= 15 ) {

			$settings['interval'] = $interval;

		}


		return $settings;
	}
}