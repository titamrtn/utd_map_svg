<?php

namespace UtdMapSvg\Database;

use UtdMapSvg\Database\Entity\Map;

class Database {

	const TABLE_NAME = 'utd_map_svg';

	public static function insert(Map $map): void {
		global $wpdb;
		$table_name = $wpdb->prefix . self::TABLE_NAME;

		$wpdb->insert(
			$table_name,
			$map->toArray()
		);
	}

	public static function update(Map $map): void {
		global $wpdb;
		$table_name = $wpdb->prefix . self::TABLE_NAME;

		$wpdb->update(
			$table_name,
			$map->toArray(),
			[ 'id' => $map->id ]
		);
	}

	public static function delete(int $id): void {
		global $wpdb;
		$table_name = $wpdb->prefix . self::TABLE_NAME;

		$wpdb->delete(
			$table_name,
			[ 'id' => $id ]
		);
	}

	public static function get(int $id): ?Map {
		global $wpdb;
		$table_name = $wpdb->prefix . self::TABLE_NAME;
		$sql        = "SELECT * FROM $table_name WHERE id = $id";

		$data = $wpdb->get_row( $sql, ARRAY_A );

		if ( ! $data ) {
			return null;
		}

		return Map::fromArray( $data );
	}

	public static function getAll(): array {
		global $wpdb;
		$table_name = $wpdb->prefix . self::TABLE_NAME;
		$sql        = "SELECT * FROM $table_name";

		$data = $wpdb->get_results( $sql, ARRAY_A );

		if ( ! $data ) {
			return [];
		}

		return array_map( [ Map::class, 'fromArray' ], $data );
	}

	public static function getBySlug( mixed $slug ): ?Map {
		global $wpdb;
		$table_name = $wpdb->prefix . self::TABLE_NAME;
		$sql        = "SELECT * FROM $table_name WHERE slug = '$slug'";

		$data = $wpdb->get_row( $sql, ARRAY_A );

		if ( ! $data ) {
			return null;
		}

		return Map::fromArray( $data );
	}
}