<?php

declare(strict_types=1);

namespace Sleekode\PerformanceCore;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Loader {


	public static function register(): void {

		spl_autoload_register(
			static function ( string $class ): void {


				$prefix = 'Sleekode\\PerformanceCore\\';


				if (
					0 !== strpos(
						$class,
						$prefix
					)
				) {
					return;
				}


				$relative = str_replace(
					$prefix,
					'',
					$class
				);


				$parts = explode(
					'\\',
					$relative
				);


				$class_name = array_pop(
					$parts
				);


				$sub_directory = '';

				if ( ! empty( $parts ) ) {

					$sub_directory = strtolower(
						implode(
							'/',
							$parts
						)
					) . '/';

				}


				$file_name = 'class-'
					. strtolower(
						preg_replace(
							'/([a-z])([A-Z])/',
							'$1-$2',
							$class_name
						)
					)
					. '.php';


				$locations = [
					'includes/',
					'src/' . $sub_directory,
					'src/',
				];


				foreach ( $locations as $location ) {


					$file = SLEEKODE_PERFORMANCE_CORE_PATH
						. $location
						. $file_name;


					if ( file_exists( $file ) ) {

						require_once $file;

						return;

					}

				}

			}
		);

	}

}