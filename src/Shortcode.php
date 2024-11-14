<?php

namespace UtdMapSvg;

use UtdMapSvg\Data\Country;
use UtdMapSvg\Database\Database;

class Shortcode {

	private function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueueScripts' ] );
		add_shortcode( 'utd_map_svg', [ $this, 'render' ] );
	}

	public static function init(): Shortcode {
		return new self();
	}

	public function enqueueScripts(): void {
		wp_register_style( 'utd-map-svg', plugin_dir_url( MAP_SVG_PLUGIN_DIR ) . 'assets/css/style.css' );
	}

	public function render( $atts ): false|string {

		$shortcode_atts = shortcode_atts( [
			'map' => 'world',
			'id' => null,
		], $atts );


		$map = Database::getBySlug( $shortcode_atts['id'] );

        $urls = [];

		if( ! $map ) {
			return 'Map non trouver';
		}

        foreach ($map->countries as $country) {
            $urls[$country['country']] = $country['url'];
        }

        $countries = Country::LIST;

		$mapID = 'map-' . $shortcode_atts['map'];

		wp_enqueue_style( 'utd-map-svg' );

		ob_start();
		include MAP_SVG_PLUGIN_DIR . 'views/' . $shortcode_atts['map'] . '.php';
		return ob_get_clean();
	}

}