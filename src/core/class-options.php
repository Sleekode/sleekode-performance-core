<?php

declare(strict_types=1);

namespace Sleekode\PerformanceCore\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Options {


	private const OPTION_NAME = 'sleekode_performance_core_settings';


	/**
	 * Get all plugin options.
	 */
	public static function all(): array {

		$defaults = [
			'heartbeat_interval'	=> 60,
			'disable_generator'		=> 0,
			'disable_emoji'			=> 0,
			'disable_wlwmanifest'	=> 0,
			'disable_rsd'			=> 0,
			'disable_shortlink'		=> 0,
			'disable_wp_embed'		=> 0,
			'disable_dashicons'		=> 0,
			'disable_block_library'	=> 0,
		];


		$options = get_option(
			self::OPTION_NAME,
			[]
		);


		if ( ! is_array( $options ) ) {

			$options = [];

		}


		return array_merge(
			$defaults,
			$options
		);

	}


	/**
	 * Get single option value.
	 */
	public static function get(
		string $key,
		mixed $default = null
	): mixed {


		$options = self::all();


		return $options[ $key ] ?? $default;

	}


	/**
	 * Check enabled option.
	 */
	public static function enabled(
		string $key
	): bool {


		return (bool) self::get(
			$key,
			false
		);

	}


	/**
	 * Get heartbeat interval.
	 */
	public static function heartbeat_interval(): int {


		return absint(
			self::get(
				'heartbeat_interval',
				60
			)
		);

	}


	/**
	 * update
	 */
	public static function update(
		array $options
	): bool {

		return update_option(
			self::OPTION_NAME,
			self::sanitize( $options )
		);

	}

	/**
	 * sanitize
	 */
	public static function sanitize(
		array $input
	): array {

		$heartbeat_interval = isset(
			$input['heartbeat_interval']
		)
			? absint(
				$input['heartbeat_interval']
			)
			: 60;
		if ( $heartbeat_interval < 15 ) {
			$heartbeat_interval = 15;
		}
		if ( $heartbeat_interval > 3600 ) {
			$heartbeat_interval = 3600;
		}

		return [

			'heartbeat_interval' => $heartbeat_interval,


			'disable_generator' => isset(
				$input['disable_generator']
				)
				? 1
				: 0,


			'disable_emoji' => isset(
				$input['disable_emoji']
				)
				? 1
				: 0,


			'disable_wlwmanifest' => isset(
				$input['disable_wlwmanifest']
				)
				? 1
				: 0,


			'disable_rsd' => isset(
				$input['disable_rsd']
				)
				? 1
				: 0,


			'disable_shortlink' => isset(
				$input['disable_shortlink']
				)
				? 1
				: 0,

			'disable_wp_embed' => isset(
				$input['disable_wp_embed']
				)
				? 1
				: 0,


			'disable_dashicons' => isset(
				$input['disable_dashicons']
				)
				? 1
				: 0,


			'disable_block_library' => isset(
				$input['disable_block_library']
				)
				? 1
				: 0,

		];
	}
}