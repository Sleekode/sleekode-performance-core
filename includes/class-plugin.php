<?php

declare(strict_types=1);

namespace Sleekode\PerformanceCore;

use Sleekode\PerformanceCore\Core\Options;
use Sleekode\PerformanceCore\Modules\Dashboard\Dashboard;
use Sleekode\PerformanceCore\Core\FeatureManager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Plugin {

	private static ?self $instance = null;

	public static function instance(): self {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function boot(): void {

		add_action(
			'init',
			[
				$this,
				'init',
			]
		);
	}

	public function init(): void {

		$options = Options::all();

		if ( is_admin() ) {

			$admin = new Admin();
			$admin->boot();

			$admin_assets = new \Sleekode\PerformanceCore\Admin\AdminAssets();
			$admin_assets->boot();

			$heartbeat = new Heartbeat();
			$heartbeat->boot();

			$actions = new Actions();
			$actions->boot();

			$dashboard = new Dashboard();
			$dashboard->boot();

		}

		$feature_manager = new FeatureManager();
		$feature_manager->boot();

		$assets = new \Sleekode\PerformanceCore\Modules\Assets\Assets();
		$assets->boot();

	}
}