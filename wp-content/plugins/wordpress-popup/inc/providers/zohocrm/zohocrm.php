<?php
/**
 * Main file for Zoho CRM
 *
 * @package Hustle
 */

/**
 * Direct Load
 */
require_once __DIR__ . '/hustle-zohocrm-api.php';
require_once __DIR__ . '/hustle-zohocrm-form-settings.php';
require_once __DIR__ . '/hustle-zohocrm-form-hooks.php';
require_once __DIR__ . '/hustle-zohocrm.php';
Hustle_Providers::get_instance()->register( 'Hustle_ZohoCRM' );
