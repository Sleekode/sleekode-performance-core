<?php

declare(strict_types=1);

namespace Sleekode\PerformanceCore;

use Sleekode\PerformanceCore\Core\FeatureRegistry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Admin {


	public function boot(): void {

		add_action(
			'admin_menu',
			[
				$this,
				'add_menu',
			]
		);

		add_action(
			'admin_init',
			[
				$this,
				'register_settings',
			]
		);
	}


	public function add_menu(): void {

		add_options_page(
			'Sleekode Performance Core',
			'Sleekode Performance Core',
			'manage_options',
			'sleekode-performance-core',
			[
				$this,
				'render_page',
			]
		);
	}


	public function register_settings(): void {

		$settings = new Settings();

		$settings->register();
	}


	public function render_page(): void {

		if (
			! Security::can_manage()
		) {
			return;
		}

		$settings = new Settings();
		$data     = $settings->get();
		$cleanup = new Cleanup();

		?>
		<div class="wrap">

			<?php

				$count = get_transient(
					'sleekode_cleanup_notice'
				);


				if ( false !== $count ) {

					delete_transient(
						'sleekode_cleanup_notice'
					);

					?>

					<div class="notice notice-success is-dismissible">

						<p>
							<?php
							echo esc_html(
								sprintf(
									/* translators: %d: deleted count */
									__(
										'%d items deleted.',
										'sleekode-performance-core'
									),
									absint( $count )
								)
							);
							?>
						</p>

					</div>

					<?php

				}
			?>

			<h1>
					<?php
						echo esc_html__(
							'Sleekode Performance Core',
							'sleekode-performance-core'
						);
					?>
			</h1>

			<form method="post" action="options.php">

				<?php
				settings_fields(
					'sleekode_performance_core_settings'
				);

				?>

				<h2>
					<?php
					echo esc_html__(
						'General',
						'sleekode-performance-core'
					);
					?>
				</h2>

				<table class="form-table">
					<tr>
						<th>
							<?php
								echo esc_html__(
									'Heartbeat interval',
									'sleekode-performance-core'
								);
							?>
						</th>
						<td>
							<input
								type="number"
								name="sleekode_performance_core_settings[heartbeat_interval]"
								value="<?php echo esc_attr( $data['heartbeat_interval'] ); ?>"
							>
							<?php
								echo esc_html__(
									'sec.',
									'sleekode-performance-core'
								);
							?>
						</td>
					</tr>
				</table>

				<h2>
					<?php
					echo esc_html__(
						'Optimization',
						'sleekode-performance-core'
					);
					?>
				</h2>

				<table class="form-table">
					<tr>
						<th>
							<?php
							echo esc_html__(
								'Optimization Features',
								'sleekode-performance-core'
							);
							?>
						</th>
						<td>
							<?php foreach ( FeatureRegistry::optimizations() as $key => $feature ) : ?>
								<label>
								<input
									type="checkbox"
									name="sleekode_performance_core_settings[<?php echo esc_attr( $key ); ?>]"
									value="1"
									<?php checked(
										$data[ $key ],
										1
									); ?>
								>
								<?php echo esc_html( $feature['label'] ); ?>
								</label>
								<?php if ( ! empty( $feature['description'] ) ) : ?>
								<p class="description">
									<?php echo esc_html( $feature['description'] ); ?>
								</p>
								<?php endif; ?>
								<br>
							<?php endforeach; ?>
						</td>
					</tr>
				</table>

				<h2>
					<?php
					echo esc_html__(
						'Assets',
						'sleekode-performance-core'
					);
					?>
				</h2>

				<table class="form-table">
					<tr>
						<th>
							<?php
							echo esc_html__(
								'Asset Optimization',
								'sleekode-performance-core'
							);
							?>
						</th>
						<td>
							<?php foreach ( FeatureRegistry::assets() as $key => $feature ) : ?>
								<label>
								<input
									type="checkbox"
									name="sleekode_performance_core_settings[<?php echo esc_attr( $key ); ?>]"
									value="1"
									<?php checked(
										$data[ $key ],
										1
									); ?>
								>
								<?php echo esc_html( $feature['label'] ); ?>
								</label>
								<?php if ( ! empty( $feature['description'] ) ) : ?>
								<p class="description">
									<?php echo esc_html( $feature['description'] ); ?>
								</p>
								<?php endif; ?>
								<br>
							<?php endforeach; ?>
						</td>
					</tr>
				</table>

				<hr>

				<h2>
					<?php
					echo esc_html__(
						'Maintenance',
						'sleekode-performance-core'
					);
					?>
				</h2>

				<p>
					<?php
					echo esc_html__(
						'Remove unnecessary WordPress data.',
						'sleekode-performance-core'
					);
					?>
				</p>

				<table class="widefat">
				<tr>
					<td>
						<?php
						echo esc_html__(
							'Post revisions',
							'sleekode-performance-core'
						);
						?>
					</td>
					<td>
						<?php
						echo esc_html(
							$cleanup->count_revisions()
						);
						?>
					</td>
					<td>
						<a
							class="button"
							href="<?php echo esc_url(
								wp_nonce_url(
									admin_url(
										'admin-post.php?action=sleekode_cleanup_revisions'
									),
									'sleekode_cleanup_revisions'
								)
							); ?>"
						>
							<?php
							echo esc_html__(
								'Delete',
								'sleekode-performance-core'
							);
							?>
						</a>
					</td>
				</tr>
				<tr>
					<td>
						<?php
						echo esc_html__(
							'Auto drafts',
							'sleekode-performance-core'
						);
						?>
					</td>
					<td>
						<?php
						echo esc_html(
							$cleanup->count_auto_drafts()
						);
						?>
					</td>
					<td>
						<a class="button"
						href="<?php echo esc_url(
							wp_nonce_url(
								admin_url(
									'admin-post.php?action=sleekode_cleanup_autodrafts'
								),
								'sleekode_cleanup_autodrafts'
							)
						); ?>">
							<?php
							echo esc_html__(
								'Delete',
								'sleekode-performance-core'
							);
							?>
						</a>
					</td>
				</tr>
				<tr>
					<td>
						<?php
						echo esc_html__(
							'Trash',
							'sleekode-performance-core'
						);
						?>
					</td>
					<td>
						<?php
						echo esc_html(
							$cleanup->count_trash()
						);
						?>
					</td>
					<td>
						<a class="button"
						href="<?php echo esc_url(
							wp_nonce_url(
								admin_url(
									'admin-post.php?action=sleekode_cleanup_trash'
								),
								'sleekode_cleanup_trash'
							)
						); ?>">
							<?php
							echo esc_html__(
								'Delete',
								'sleekode-performance-core'
							);
							?>
						</a>
					</td>
				</tr>
				</table>

				<?php
				submit_button();
				?>

			</form>

		</div>
		<?php
	}
}