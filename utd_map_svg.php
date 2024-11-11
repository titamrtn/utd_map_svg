<?php
/**
 * Plugin Name: Map SVG
 * Plugin URI: https://jattendsunlien.fr/
 * Update URI: https://jattendsunlien.fr/plugins/utd_map_svg/info
 * Description: Plugins pour gerer les maps interactive
 * Version: 1.0
 * Author: Rajaonah Tojoniaina Nandrianina
 * Author URI: https://nandrianina.com
 */


require_once __DIR__ . '/vendor/autoload.php';

define('MAP_SVG_PLUGIN_DIR', plugin_dir_path(__FILE__));

\UtdMapSvg\Shortcode::init();