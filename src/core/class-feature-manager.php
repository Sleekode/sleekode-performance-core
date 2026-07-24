<?php

declare(strict_types=1);

namespace Sleekode\PerformanceCore\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class FeatureManager {


	public function boot(): void {

		foreach (
			FeatureRegistry::optimizations()
			as $key => $feature
		) {

			if (
				Options::enabled( $key )
			) {

				$this->load(
					$key
				);

			}

		}

	}


	private function load(
		string $feature
	): void {

		switch ( $feature ) {

			case 'disable_generator':
				remove_action(
					'wp_head',
					'wp_generator'
				);
				break;


			case 'disable_wlwmanifest':
				remove_action(
					'wp_head',
					'wlwmanifest_link'
				);
				break;


			case 'disable_rsd':
				remove_action(
					'wp_head',
					'rsd_link'
				);
				break;


			case 'disable_shortlink':
				remove_action(
					'wp_head',
					'wp_shortlink_wp_head'
				);
				break;


			case 'disable_emoji':
				$this->disable_emoji();
				break;

		}

	}


	private function disable_emoji(): void {

		remove_action(
			'wp_head',
			'print_emoji_detection_script',
			7
		);

		remove_action(
			'wp_print_styles',
			'print_emoji_styles'
		);

		remove_action(
			'admin_print_scripts',
			'print_emoji_detection_script'
		);

		remove_action(
			'admin_print_styles',
			'print_emoji_styles'
		);

	}

}