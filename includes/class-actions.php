<?php

declare(strict_types=1);

namespace Sleekode\PerformanceCore;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Actions {

	public function boot(): void {

		add_action(
			'admin_post_sleekode_cleanup_revisions',
			[
				$this,
				'cleanup_revisions',
			]
		);

		add_action(
			'admin_post_sleekode_cleanup_autodrafts',
			[
				$this,
				'cleanup_auto_drafts',
			]
		);


		add_action(
			'admin_post_sleekode_cleanup_trash',
			[
				$this,
				'cleanup_trash',
			]
		);
	}


	public function cleanup_revisions(): void {


		if (
			! Security::can_manage()
		) {

			wp_die(
				esc_html__(
					'Permission denied.',
					'sleekode-performance-core'
				)
			);

		}


		check_admin_referer(
			'sleekode_cleanup_revisions'
		);


		$cleanup = new Cleanup();

		$count = $cleanup->delete_revisions();


		$this->redirect(
			$count
		);
	}

	public function cleanup_auto_drafts(): void {

		$this->check_permission(
			'sleekode_cleanup_autodrafts'
		);


		$cleanup = new Cleanup();

		$count = $cleanup->delete_auto_drafts();


		$this->redirect(
			$count
		);

	}

	public function cleanup_trash(): void {


		$this->check_permission(
			'sleekode_cleanup_trash'
		);


		$cleanup = new Cleanup();

		$count = $cleanup->delete_trash();


		$this->redirect(
			$count
		);

	}

	private function check_permission(
		string $nonce
	): void {

		if (
			! Security::can_manage()
		) {

			wp_die(
				esc_html__(
					'Permission denied.',
					'sleekode-performance-core'
				)
			);

		}

		check_admin_referer(
			$nonce
		);

	}

	private function redirect(
		int $count
	): void {

		set_transient(
			'sleekode_cleanup_notice',
			$count,
			30
		);


		wp_safe_redirect(
			add_query_arg(
				[
					'page' => 'sleekode-performance-core',
				],
				admin_url(
					'options-general.php'
				)
			)
		);

		exit;

	}
}