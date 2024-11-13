<?php

namespace UtdMapSvg;

use UtdMapSvg\Database\Database;

class Admin {

	private $mapForm;

	private function __construct() {
		add_action( 'admin_menu', [ $this, 'addAdminMenu' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueueScripts' ] );

		$this->mapForm = new Form\MapForm();
	}

	public static function init() {
		return new self();
	}

	public function enqueueScripts( $page ): void {
		if ( $page === 'toplevel_page_utd_map_svg' ) {
			wp_enqueue_script(
				'utd-map-svg-drag',
				plugin_dir_url( MAP_SVG_PLUGIN_DIR ) . 'assets/js/drag.js',
				[ 'jquery' ],
				false, true );
		}
	}

	public function addAdminMenu(): void {
		add_menu_page(
			'Map SVG',
			'Map SVG',
			'publish_posts',
			'utd_map_svg',
			[ $this, 'routePage' ],
			'dashicons-admin-site',
		);
	}

	public function routePage(): void {
		$render = $_GET['render'] ?? 'map_list';

		match ( $render ) {
			'map_list' => $this->mapList(),
			'add','edit' => $this->mapForm->render(),
			default => $this->renderUnknown(),
		};
	}

	private function mapList() {
		$maps = Database::getAll();

		$urls = get_option( 'utd_map_svg_urls', [] );
		include_once MAP_SVG_PLUGIN_DIR . 'views/admin/admin.php';
	}

	private function renderUnknown(): void {
		echo '<h2 style="color: red">Action inconnue</h2>';
	}
}