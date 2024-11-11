<?php

namespace UtdMapSvg;

class Updater {

	const PLUGIN_SLUG = 'utd_map_svg';
	private string $slugPath;

	private function __construct() {
		add_filter('plugins_api', [$this, 'pluginInfo'], 20, 3);
		add_filter( 'update_plugins_jattendsunlien.fr', [ $this, 'checkForUpdates' ], 20, 4);

		$this->slugPath = self::PLUGIN_SLUG . '/' . self::PLUGIN_SLUG . '.php';
	}

	public static function init(): Updater {
		return new self();
	}

	public function pluginInfo( $res, $action, $args ) {
		if ( $action !== 'plugin_information' ) {
			return $res;
		}

		if ( $this->slugPath !== $args->slug ) {
			return $res;
		}
		$change_log = $this->loadChangelog();

		if ( ! $change_log ) {
			return $res;
		}

		$res = (object) [
			'name'           => 'Meteo',
			'slug'           => self::PLUGIN_SLUG,
			'path'           => $this->slugPath,
			'version'        => $change_log->version,
			'author'         => 'Rajaonah Tojoniaina Nandrianina',
			'author_profile' => 'https://nandrianina.com',
			'download_link'  => $change_log->download_url,
			'trunk'          => $change_log->download_url,
			'sections'       => [
				'changelog' => nl2br($change_log->changelog),
			],
		];
	}

	public function loadChangelog() {
		$info = wp_remote_get(
			'https://jattendsunlien.fr/plugins/'.self::PLUGIN_SLUG.'/info',
			[ 'timeout' => 10, 'headers' => [ 'Accept' => 'application/json' ] ]
		);
		if ( ! is_wp_error( $info ) && 200 === wp_remote_retrieve_response_code( $info ) ) {
			return json_decode( wp_remote_retrieve_body( $info ) );
		}

		return false;
	}

	public function checkForUpdates( $update, array $plugin_data, string $plugin_file, $locales ) {
		if ( $plugin_file !== $this->slugPath ) return $update;
		if ( ! empty( $update ) ) return $update;
		$changelog = $this->loadChangelog();

		if ( ! version_compare( $plugin_data['Version'], $changelog->version, '<' ) ) return $update;
		return [
			'slug' => self::PLUGIN_SLUG,
			'version' => $changelog->version,
			'url' => $plugin_data['PluginURI'],
			'package' => $changelog->download_url,
		];
	}
}