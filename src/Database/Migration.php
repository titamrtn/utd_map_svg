<?php

namespace UtdMapSvg\Database;

class Migration {
	const DB_VERSION = 1;
	const VERSION_NAME = 'utd_map_svg_db_version';

	private function __construct() {
		$this->setup();
		$this->upgrade();
	}

	public static function init(): Migration {
		return new self();
	}

	private function setup(): void {
		$current_db_version = get_option( self::VERSION_NAME );

		if ( empty( $current_db_version ) ) {
			$this->createTable();
			add_option( self::VERSION_NAME, 1 );
		}

	}

	private function upgrade(): void {
		$current_db_version = get_option( self::VERSION_NAME );

		for ( $version = $current_db_version + 1; $version <= self::DB_VERSION; $version ++ ) {
			$versionUpgradeMethod = 'upgradeToVersion' . $version;
			if ( method_exists( $this, $versionUpgradeMethod ) ) {
				$this->$versionUpgradeMethod();
			}
		}
	}

	private function createTable(): void {
		global $wpdb;
		$table_name      = $wpdb->prefix . 'utd_map_svg';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
    		name varchar(255) NOT NULL,
    		slug varchar(255) NOT NULL UNIQUE,
    		countries text NOT NULL,
    		fill_color varchar(255) NOT NULL,
    		hover_color varchar(255) NOT NULL,
    		highlight_color varchar(255) NOT NULL,
            PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

}