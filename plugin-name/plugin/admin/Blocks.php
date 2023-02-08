<?php
/**
 * Register blocks and their dependencies.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

declare(strict_types=1);

namespace PluginName;

/**
 * Register blocks and their dependencies.
 *
 *
 * @since      1.0.0
 * @package    PluginName
 * @subpackage PluginName/admin
 */
class Blocks {
	protected $blocks;
  protected $blocks_to_modify;

	public function init() {
		$this->blocks = [
			[
				'name'      => 'example block',
				'json'      => true,
				'js-render' => true,
			],
		];

    // Pre-existing blocks to modify.
		$this->blocks_to_modify = [];

    $this->admin_assets();
		$this->modify_blocks();
		$this->block_styles();
	}

	private function admin_assets() {
		foreach ( $this->blocks as $block ) {
			$pascal_case = str_replace( ' ', '', ucwords( $block['name'] ) );
			$kebab_case  = str_replace( ' ', '-', $block['name'] );

			$class_name = 'PluginName\\' . $pascal_case . 'Block';
			$instance   = false;

			if ( class_exists( $class_name ) ) {
				$instance = new $class_name();
			}

			$block_type = sprintf( '%s/%s', PLUGIN_NAME_BLOCK_NAMESPACE, $kebab_case );

			$args = [
				'editor_script' => PLUGIN_NAME_BLOCK_NAMESPACE . '-blocks-script',
				'editor_style'  => PLUGIN_NAME_BLOCK_NAMESPACE . '-blocks-css',
			];

			if ( ! empty( $block['json'] ) ) {
				$block_folder = sprintf( '%sblocks/build/%s', PLUGIN_NAME_ROOT, $kebab_case );
				$block_type = sprintf( '%s/block.json', $block_folder, $kebab_case );
				$asset_data = include( $block_folder . '/index.asset.php' );
				$block_data = json_decode( file_get_contents( $block_type ), true );

				// Enable using block.json to add non-block scripts and styles.
				if ( empty( $block_data['name'] ) && ( count( $block_data['otherScripts'] ) || count( $block_data['otherStyles'] ) ) ) {
					add_action(
						'enqueue_block_assets',
						function() use ( $block_data, $kebab_case, $asset_data ) {
							$other_scripts = ! empty( $block_data['otherScripts'] ) ? $block_data['otherScripts'] : [];
							$other_styles  = ! empty( $block_data['otherStyles'] ) ? $block_data['otherStyles'] : [];

							foreach ( $other_scripts as $key => $filename ) {
								wp_enqueue_script(
									sprintf( '%s-%s-other-script-%s', $kebab_case, $key ),
									sprintf( '%s/blocks/build/%s/%s', PLUGIN_NAME_WEB_ROOT, $kebab_case, $filename ),
									$asset_data['dependencies'],
									$asset_data['version']
								);
							}

							foreach ( $other_styles as $key => $filename ) {
								wp_enqueue_style(
									sprintf( 'umw-%s-other-style-%s', $kebab_case, $key ),
									sprintf( '%s/blocks/build/%s/%s', PLUGIN_NAME_WEB_ROOT, $kebab_case, $filename )
								);
							}
						}
					);
				}
				$args = [];
			}

			$args['render_callback'] = $instance && empty( $block['js-render'] ) ? [ $instance, 'render' ] : null;

			register_block_type( $block_type, $args );
		}

	}

	private function modify_blocks() {
		$modifications = [];

		foreach ( $this->blocks_to_modify as $block ) {
			$pascal_case = str_replace( ' ', '', ucwords( $block ) );
			$class = "ModifyCore{$pascal_case}Block";

			$modifications[] = new $class();
		}
	}

	private function block_styles() {
		register_block_style(
			'core/heading',
			[
				'name'         => 'eyebrow',
				'label'        => __( 'Eyebrow', PLUGIN_NAME_BLOCK_NAMESPACE ),
				'style_handle' => PLUGIN_NAME_BLOCK_NAMESPACE . '-eyebrow',
			]
		);
	}
}
