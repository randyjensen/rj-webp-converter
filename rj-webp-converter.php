<?php
/*
 * Plugin Name: RJ WebP Converter
 * Version: 1.0.0
 * Plugin URI: http://www.randyjensen.com/
 * Description: Automatically convert any images to WebP as they are uploaded to the Media Uploader.
 * Author: Randy Jensen
 * Author URI: http://www.randyjensen.com/
 * Requires at least: 3.9
 * Tested up to: 3.9.1
 *
 * @package WordPress
 * @author Randy Jensen
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-rj-webp-converter.php' );

// Load plugin libraries
require_once( 'includes/lib/class-rj-webp-converter-admin-main.php' );

/**
 * Returns the main instance of RJ_WebP_Converter to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object RJ_WebP_Converter
 */
function RJ_WebP_Converter () {
	$instance = RJ_WebP_Converter::instance( __FILE__, '1.0.0' );

	return $instance;
}

RJ_WebP_Converter();
