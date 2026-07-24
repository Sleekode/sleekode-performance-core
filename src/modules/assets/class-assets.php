<?php

declare(strict_types=1);

namespace Sleekode\PerformanceCore\Modules\Assets;

use Sleekode\PerformanceCore\Core\Options;
use Sleekode\PerformanceCore\Core\FeatureRegistry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Assets {

	public function boot(): void {

		add_action(
			'wp_enqueue_scripts',
			[
				$this,
				'optimize',
			],
			200
		);

	}

	public function optimize(): void {

		foreach (
			FeatureRegistry::assets()
			as $key => $feature
		) {

			if (
				! Options::enabled( $key )
			) {
				continue;
			}


			$this->disable(
				$key
			);

		}

	}

	private function disable(
		string $feature
	): void {

		switch ( $feature ) {

			case 'disable_wp_embed':

				wp_dequeue_script(
					'wp-embed'
				);

				break;


			case 'disable_dashicons':

				if (
					! is_user_logged_in()
				) {

					wp_dequeue_style(
						'dashicons'
					);

				}

				break;


			case 'disable_block_library':

				wp_dequeue_style(
					'wp-block-library'
				);

				break;

		}

	}

}