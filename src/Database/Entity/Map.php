<?php

namespace UtdMapSvg\Database\Entity;

class Map {

	public $id;
	public $name;
	public $slug;
	public $countries;
	public $fill_color;
	public $hover_color;
	public $highlight_color;

	public function __construct( $id = null, $name = null, $slug = null, $countries= [], $fill_color = null, $hover_color = null, $highlight_color = null ) {
		$this->id = $id;
		$this->name = $name;
		$this->slug = $slug;
		$this->fill_color = $fill_color;
		$this->hover_color = $hover_color;
		$this->highlight_color = $highlight_color;

		if(is_string($countries)){
			$this->countries = json_decode($countries, true);
		} else {
			$this->countries = $countries;
		}
	}

	public function toArray(): array {
		return [
			'id' => $this->id,
			'name' => $this->name,
			'slug' => $this->slug,
			'countries' => json_encode($this->countries),
			'fill_color' => $this->fill_color,
			'hover_color' => $this->hover_color,
			'highlight_color' => $this->highlight_color,
		];
	}

	public static function fromArray( array $data ): Map {

		$countries = [];

		if ( !empty( $data['countries'] ) ) {
			if( is_string( $data['countries'] ) ) {
				$data['countries'] = json_decode( $data['countries'] , true );
			}

			$countries = $data['countries'];
		}

		return new self(
			$data['id'] ?? null,
			$data['name'] ?? null,
			$data['slug'] ?? null,
			$countries,
			$data['fill_color'] ?? null,
			$data['hover_color'] ?? null,
			$data['highlight_color'] ?? null
		);
	}

}