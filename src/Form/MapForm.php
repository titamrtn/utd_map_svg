<?php

namespace UtdMapSvg\Form;

use UtdMapSvg\Data\Country;
use UtdMapSvg\Database\Database;
use UtdMapSvg\Database\Entity\Map;

class MapForm {

	public function __construct() {
		add_action( 'admin_post_utd_map_svg_save', [ $this, 'save' ] );
		add_action( 'admin_post_utd_map_svg_delete', [ $this, 'delete' ] );
	}

	public function render(): void {
		$map = new Map();

		if ( isset( $_GET['map_id'] ) ) {
			$map = Database::get( $_GET['map_id'] );
		}

		if ( isset( $_GET['slug'] ) ) {
			$map = Database::getBySlug( $_GET['slug'] );
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

		$countries = Country::LIST;
		include_once MAP_SVG_PLUGIN_DIR . 'views/admin/map_form.php';
	}

	public function save(): void {

		$countries = [];
		if ( ! empty( $_POST['countries'] ) && ! empty( $_POST['url'] ) ) {
			foreach ( $_POST['countries'] as $key => $country ) {
				$countries[] = [
					'country' => $country,
					'url'     => $_POST['url'][ $key ],
				];
			}
		}

		$map = new Map(
			$_POST['id'] ?? null,
			$_POST['name'] ?? null,
			$_POST['slug'] ?? null,
			$countries,
			$_POST['fill_color'] ?? '#1e73be',
			$_POST['hover_color'] ?? '#dd3333',
			$_POST['highlight_color'] ?? '#81d742',
		);

		if ( $map->id ) {
			Database::update( $map );
		} else {
			Database::insert( $map );
		}

		wp_redirect( admin_url( 'admin.php?page=utd_map_svg&render=map_list' ) );
	}

}