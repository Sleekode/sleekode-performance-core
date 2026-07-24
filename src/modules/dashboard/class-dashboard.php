<?php

declare(strict_types=1);

namespace Sleekode\PerformanceCore\Modules\Dashboard;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Dashboard {


	public function boot(): void {

		add_action(
			'wp_dashboard_setup',
			[
				$this,
				'register_widget',
			]
		);

	}


	public function register_widget(): void {

		wp_add_dashboard_widget(
			'sleekode_performance_overview',
			'Sleekode Performance Overview',
			[
				$this,
				'render',
			]
		);

	}


	public function render(): void {

		$status = new Status();

		$heartbeat = $status->heartbeat();

		$optimization = $status->optimization_count();
		$assets = $status->assets_count();

		$cleanup = $status->cleanup();

		$optimization_items = $status->optimization_items();
		$assets_items       = $status->assets_items();

		$performance_status = $status->performance_status();

		?>

		<div class="sleekode-performance-overview">

			<div class="section">
			<h3>
				<?php
					echo esc_html__(
						'Performance Status',
						'sleekode-performance-core'
					);
				?>
			</h3>
			<p>
				<?php
				echo esc_html(
					sprintf(
						/* translators: %s: performance score */
						__(
							'Current performance status: %s.',
							'sleekode-performance-core'
						),
						$performance_status
					)
				);
				?>
			</p>
			</div>

			<table class="widefat striped">
				<tbody>
					<tr>
						<td>
							<?php
							echo esc_html__(
								'Heartbeat',
								'sleekode-performance-core'
							);
							?>
						</td>
						<td class="countView">
							<?php
							echo esc_html(
								sprintf(
									/* translators: %d: seconds */
									__(
										'%d seconds',
										'sleekode-performance-core'
									),
									$heartbeat
								)
							);
							?>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="widefat striped">
				<tbody>
					<tr>
						<td>
							<?php
							echo esc_html__(
								'Optimization',
								'sleekode-performance-core'
							);
							?>
						</td>
						<td class="countView">
							<?php
							echo esc_html(
								sprintf(
									/* translators: %d: enabled count */
									__(
										'%d enabled',
										'sleekode-performance-core'
									),
									$optimization
								)
							);
							?>
						</td>
					</tr>
				</tbody>
			</table>

			<div class="section">
			<h3>
				<?php
					echo esc_html__(
						'Enabled Optimizations',
						'sleekode-performance-core'
					);
				?>
			</h3>
			<?php if ( ! empty( $optimization_items ) ) : ?>
			<ul>
				<?php foreach ( $optimization_items as $item ) : ?>

					<li>

						<strong>
							<?php echo esc_html( $item['label'] ); ?>
						</strong>

						<?php if ( ! empty( $item['description'] ) ) : ?>

							<p>
								<?php echo esc_html( $item['description'] ); ?>
							</p>

						<?php endif; ?>

					</li>

				<?php endforeach; ?>
			</ul>
			<?php else : ?>
			<p>
				<?php
				echo esc_html__(
					'No optimizations enabled.',
					'sleekode-performance-core'
				);
				?>
			</p>
			<?php endif; ?>
			</div>

			<table class="widefat striped">
				<tbody>
					<tr>
						<td>
							<?php
							echo esc_html__(
								'Assets',
								'sleekode-performance-core'
							);
							?>
						</td>
						<td class="countView">
							<?php
							echo esc_html(
								sprintf(
									/* translators: %d: enabled count */
									__(
										'%d enabled',
										'sleekode-performance-core'
									),
									$assets
								)
							);
							?>
						</td>
					</tr>
				</tbody>
			</table>

			<div class="section">
			<h3>
				<?php
					echo esc_html__(
						'Enabled Assets',
						'sleekode-performance-core'
					);
				?>
			</h3>
			<?php if ( ! empty( $assets_items ) ) : ?>
			<ul>
				<?php foreach ( $assets_items as $item ) : ?>

					<li>

						<strong>
							<?php echo esc_html( $item['label'] ); ?>
						</strong>

						<?php if ( ! empty( $item['description'] ) ) : ?>

							<p>
								<?php echo esc_html( $item['description'] ); ?>
							</p>

						<?php endif; ?>

					</li>

				<?php endforeach; ?>
			</ul>
			<?php else : ?>
			<p>
				<?php
				echo esc_html__(
					'No assets enabled.',
					'sleekode-performance-core'
				);
				?>
			</p>
			<?php endif; ?>
			</div>

			<table class="widefat striped">
				<tbody>
					<tr>
						<td>
							<?php
							echo esc_html__(
								'Revisions',
								'sleekode-performance-core'
							);
							?>
						</td>
						<td class="countView">
							<?php
							echo esc_html(
								$cleanup['revisions']
							);
							?>
						</td>
					</tr>
					<tr>
						<td>
							<?php
							echo esc_html__(
								'Auto Drafts',
								'sleekode-performance-core'
							);
							?>
						</td>
						<td class="countView">
							<?php
							echo esc_html(
								$cleanup['auto_drafts']
							);
							?>
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
						<td class="countView">
							<?php
							echo esc_html(
								$cleanup['trash']
							);
							?>
						</td>
					</tr>
				</tbody>
			</table>

		</div>

		<?php

	}

}