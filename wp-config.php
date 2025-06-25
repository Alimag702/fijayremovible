<?php
define( 'WP_CACHE', true );
//Begin Really Simple Security key
define('RSSSL_KEY', 'XUvgJkEiHlMmuR2pVC4vrIexQzhbHnHj7MpUMdV4H4fplzadRBEp9vxMORIerGmF');
//END Really Simple Security key

//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL cookie settings

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'fijayremovible' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '(Hm`S`KWq?09Fz+tMQPsJz*cx0JvWQ{XoE}$XvFW$lK$p&G!Tc@tRSAh/T`l(0}m' );
define( 'SECURE_AUTH_KEY',  '9h@+3^pF|E@f$=dduma @l9($xTr=h4yNkk{$99S0-P:b8f$K/s+NWRSrW6@iw8u' );
define( 'LOGGED_IN_KEY',    'xh4Dcp<$}/;%5HrP~5Jg`w-!;eXNd_|?aN+h%ZCJneS^mV%Prt{@ qo3[1sx*V%m' );
define( 'NONCE_KEY',        ' 1]oeH__CFLEs74]wonOh]oaKqyXtgvhl.thI|FkkL9L=|$B).(?yGA=Z&#*]?@?' );
define( 'AUTH_SALT',        '>Hbl<hk_!; o{#C`Hf>~ZA2`W{zWO)2B!6@gFaGU&M=n`Y38~%UDh%R`Chp!R0 >' );
define( 'SECURE_AUTH_SALT', '.?D/=w?R,$h;/oE_pO:IIkHca>Sd@p^HH+|N|p7{_]).DP7L2 cG-Y-5J6u<7,V+' );
define( 'LOGGED_IN_SALT',   ':~*@X&,p0PW4b[gEbWEIk2!bw15P&Yn{M+>cNW1>F`[Jipu9H_/_yOA:6ekLH{C<' );
define( 'NONCE_SALT',       '%<Tq<@5HR}&i>EIbD`$p+!yC;KUj6FnC0Jd%s*^2K` &/`+C7buW[|^@?,Yl~$6_' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', false );


/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
