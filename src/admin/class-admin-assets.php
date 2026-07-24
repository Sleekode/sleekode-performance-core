<?php

declare(strict_types=1);

namespace Sleekode\PerformanceCore\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class AdminAssets {


	public function boot(): void {

		add_action(
			'admin_enqueue_scripts',
			[
				$this,
				'enqueue',
			]
		);

	}


	public function enqueue(
		string $hook
	): void {


		if (
			'index.php' !== $hook
		) {
			return;
		}


		wp_enqueue_style(
			'sleekode-performance-core-admin',
			SLEEKODE_PERFORMANCE_CORE_URL
			. 'assets/css/admin.css',
			[],
			SLEEKODE_PERFORMANCE_CORE_VERSION
		);

	}

}