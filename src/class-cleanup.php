<?php

declare(strict_types=1);

namespace Sleekode\PerformanceCore;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Cleanup {

	public function count_revisions(): int {

		$posts = get_posts(
			[
				'post_type'      => 'revision',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			]
		);

		return count( $posts );

	}

	public function count_auto_drafts(): int {

		$posts = get_posts(
			[
				'post_status'    => 'auto-draft',
				'post_type'      => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			]
		);

		return count( $posts );

	}

	public function count_trash(): int {

		$posts = get_posts(
			[
				'post_status'    => 'trash',
				'post_type'      => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			]
		);

		return count( $posts );

	}


	public function delete_revisions(): int {

		$revisions = get_posts(
			[
				'post_type'      => 'revision',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			]
		);

		$count = 0;

		foreach ( $revisions as $revision_id ) {

			if (
				wp_delete_post(
					$revision_id,
					true
				)
			) {

				$count++;

			}

		}

		return $count;

	}

	public function delete_auto_drafts(): int {

		$auto_drafts = get_posts(
			[
				'post_status'    => 'auto-draft',
				'post_type'      => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			]
		);

		$count = 0;

		foreach ( $auto_drafts as $auto_draft_id ) {

			if (
				wp_delete_post(
					$auto_draft_id,
					true
				)
			) {

				$count++;

			}

		}

		return $count;

	}

	public function delete_trash(): int {

		$trash = get_posts(
			[
				'post_status'    => 'trash',
				'post_type'      => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			]
		);

		$count = 0;

		foreach ( $trash as $trash_id ) {

			if (
				wp_delete_post(
					$trash_id,
					true
				)
			) {

				$count++;

			}

		}

		return $count;

	}

}