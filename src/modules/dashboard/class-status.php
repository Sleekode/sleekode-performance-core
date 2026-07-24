<?php

declare(strict_types=1);

namespace Sleekode\PerformanceCore\Modules\Dashboard;

use Sleekode\PerformanceCore\Core\Options;
use Sleekode\PerformanceCore\Cleanup;
use Sleekode\PerformanceCore\Core\FeatureRegistry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Status {

	public function heartbeat(): int {

		return Options::heartbeat_interval();

	}

	public function optimization_count(): int {

		$count = 0;

		foreach (
			array_keys(
				FeatureRegistry::optimizations()
			)
			as $option
		) {

			if ( Options::enabled( $option ) ) {
				$count++;
			}

		}

		return $count;

	}

	public function assets_count(): int {

		$count = 0;

		foreach (
			array_keys(
				FeatureRegistry::assets()
			)
			as $option
		) {

			if ( Options::enabled( $option ) ) {
				$count++;
			}

		}

		return $count;

	}

	public function cleanup(): array {

		$cleanup = new Cleanup();


		return [
			'revisions'   => $cleanup->count_revisions(),
			'auto_drafts' => $cleanup->count_auto_drafts(),
			'trash'       => $cleanup->count_trash(),
		];

	}

	public function optimization_items(): array {

		$items = [];

		foreach (
			FeatureRegistry::optimizations()
			as $key => $feature
		) {

			if (
				Options::enabled( $key )
			) {

				$items[] = [
					'label'       => $feature['label'],
					'description' => $feature['description'] ?? '',
				];

			}

		}

		return $items;

	}

	public function assets_items(): array {

		$items = [];

		foreach (
			FeatureRegistry::assets()
			as $key => $feature
		) {

			if (
				Options::enabled( $key )
			) {

				$items[] = [
					'label'       => $feature['label'],
					'description' => $feature['description'] ?? '',
				];

			}

		}

		return $items;

	}

	public function performance_status(): string {

		$score = 0;

		if ( $this->heartbeat() >= 60 ) {
			$score++;
		}

		if ( $this->optimization_count() > 0 ) {
			$score++;
		}

		if ( $this->assets_count() > 0 ) {
			$score++;
		}

		if ( $score >= 3 ) {
			return 'Good';
		}

		if ( $score >= 1 ) {
			return 'Fair';
		}

		return 'Basic';

	}
}