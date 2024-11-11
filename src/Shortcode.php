<?php

namespace UtdMapSvg;

class Shortcode {

	private function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueueScripts' ] );
		add_shortcode( 'utd_map_svg', [ $this, 'render' ] );
	}

	public static function init() {
		return new self();
	}

	public function enqueueScripts(): void {
		wp_register_style( 'utd-map-svg', plugin_dir_url( MAP_SVG_PLUGIN_DIR ) . 'assets/css/style.css' );
	}

	public function render( $atts ): false|string {
		$shortcode_atts = shortcode_atts( [
			'map' => 'world',
			'line' => '#000000',
			'fill' => '#edf09c',
			'hover' => '#f00',
		], $atts );

		$fill = $shortcode_atts['fill'];
		$line = $shortcode_atts['line'];
		$hover = $shortcode_atts['hover'];

		$mapID = 'map-' . $shortcode_atts['map'];

		wp_enqueue_style( 'utd-map-svg' );

		ob_start();
		include MAP_SVG_PLUGIN_DIR . 'views/' . $shortcode_atts['map'] . '.php';
		return ob_get_clean();
	}

}