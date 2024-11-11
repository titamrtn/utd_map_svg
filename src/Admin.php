<?php

namespace UtdMapSvg;

class Admin {

	private function __construct() {
		add_action( 'admin_menu', [ $this, 'addAdminMenu' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueueScripts' ] );
		add_action('admin_post_utd_map_svg_save', [ $this, 'save' ]);
	}

	public static function init() {
		return new self();
	}

	public function save() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Unauthorized user' );
		}

		$url = $_POST['url'] ?? [];

		$urls = [];
		foreach ( $url as $code => $value ) {
			$urls[ $code ] = esc_url( $value );
		}

		update_option( 'utd_map_svg_urls', $urls );

		wp_redirect( admin_url( 'admin.php?page=utd_map_svg&render=map_list' ) );
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
			'manage_options',
			'utd_map_svg',
			[ $this, 'renderAdminPage' ],
			'dashicons-admin-site',
		);
	}

	public function renderAdminPage(): void {
		$render = $_GET['render'] ?? 'map_list';

		$urls = get_option( 'utd_map_svg_urls', [] );
		include_once MAP_SVG_PLUGIN_DIR . 'views/admin/admin.php';
	}
}