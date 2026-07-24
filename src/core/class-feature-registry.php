<?php

declare(strict_types=1);

namespace Sleekode\PerformanceCore\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class FeatureRegistry {

	/**
	 * Optimization features.
	 */
	public static function optimizations(): array {

		return [
			'disable_generator' => [
				'label' => __(
					'WordPress version display',
					'sleekode-performance-core'
				),

				'description' => __(
					'Removes WordPress version information from the page source.',
					'sleekode-performance-core'
				),
			],

			'disable_emoji' => [
				'label' => __(
					'Emoji functionality',
					'sleekode-performance-core'
				),

				'description' => __(
					'Removes emoji scripts and styles from WordPress.',
					'sleekode-performance-core'
				),
			],

			'disable_wlwmanifest' => [
				'label' => __(
					'WLW Manifest',
					'sleekode-performance-core'
				),

				'description' => __(
					'Removes the Windows Live Writer manifest link.',
					'sleekode-performance-core'
				),
			],

			'disable_rsd' => [
				'label' => __(
					'RSD link',
					'sleekode-performance-core'
				),

				'description' => __(
					'Removes the Really Simple Discovery link.',
					'sleekode-performance-core'
				),
			],

			'disable_shortlink' => [
				'label' => __(
					'Shortlink',
					'sleekode-performance-core'
				),

				'description' => __(
					'Removes WordPress shortlink information.',
					'sleekode-performance-core'
				),
			],
		];

	}

	/**
	 * Asset optimization features.
	 */
	public static function assets(): array {

		return [
			'disable_wp_embed' => [
				'label' => __(
					'wp-embed script',
					'sleekode-performance-core'
				),

				'description' => __(
					'Removes unnecessary embed JavaScript.',
					'sleekode-performance-core'
				),
			],

			'disable_dashicons' => [
				'label' => __(
					'Dashicons for visitors',
					'sleekode-performance-core'
				),

				'description' => __(
					'Prevents Dashicons from loading on the frontend.',
					'sleekode-performance-core'
				),
			],

			'disable_block_library' => [
				'label' => __(
					'Block Library CSS',
					'sleekode-performance-core'
				),

				'description' => __(
					'Removes unused block editor styles from the frontend.',
					'sleekode-performance-core'
				),
			],
		];

	}

}