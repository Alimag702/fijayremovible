<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Main file for Newsletter
 *
 * @package Hustle
 */

/**
 * Direct Load
 */
require_once __DIR__ . '/hustle-newsletter.php';
require_once __DIR__ . '/hustle-newsletter-form-settings.php';
require_once __DIR__ . '/hustle-newsletter-form-hooks.php';
Hustle_Providers::get_instance()->register( 'Hustle_Newsletter' );
