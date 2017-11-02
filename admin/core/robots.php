<?php

/**
 * Virtual Robots.txt - Core - Robots class
 *
 * @package Virtual Robots.txt
 * @subpackage Virtual Robots.txt Core
 */
class VRTRBT_Core_Robots {



	// Constants
	// ----------------------------------------------------------------------------------------------------



	// WP option name
	const OPTION_KEY = 'vrtrbt-robotstxt';



	// Output procedures
	// ----------------------------------------------------------------------------------------------------


	/**
	 * Show the robots.txt values and die
	 */
	public static function output() {

		// Text header
		header( 'Content-Type: text/plain; charset=utf-8' );

		// Output and die
		die(self::get_value());
	}



	// Physical robots.txt file
	// ----------------------------------------------------------------------------------------------------



	/**
	 * Expected robots.txt path
	 */
	public static function robotstxt_path() {
		return ABSPATH.'robots.txt';
	}



	/**
	 * Attempt to remove robots.txt physical file
	 */
	public static function remove_robotstxt_file() {

		// Initialize
		$path = self::robotstxt_path();

		// Check file
		if (!file_exists($path))
			return true;

		// Remove file
		@unlink($path);

		// Check if exists
		return !file_exists($path);
	}



	// Data access
	// ----------------------------------------------------------------------------------------------------



	/**
	 * Retrieves robots.txt value
	 */
	public static function get_value() {
		return get_option(self::OPTION_KEY);
	}



	/**
	 * Saves robots.txt value
	 * Prevent an autoloaded option
	 */
	public static function set_value($value) {
		update_option(self::OPTION_KEY, $value, false);
	}



	// Activation and uninstall
	// ----------------------------------------------------------------------------------------------------



	/**
	 * Check in a previous option exists and saves a default value
	 */
	public static function activation() {
		if (false === self::get_value())
			self::set_value('User-agent: *'."\n".'Disallow:'."\n");
	}



	/**
	 * Remove the current option value
	 */
	public static function uninstall() {
		delete_option(self::OPTION_KEY);
	}



}
