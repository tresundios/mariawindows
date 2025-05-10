<?php
define('WP_CACHE', true); // Added by SpeedyCache

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'mariabea_auto' );

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
define( 'AUTH_KEY',         'fq7s7m4g3bwqj9afsevxanmcwsswnvdgtdjarwlpfxruswur1kesoahjsiev8taj' );
define( 'SECURE_AUTH_KEY',  'ologhgpvkhmskxwnmdftu8ctglfqdjgqeo1yk4ns40ufeeya7jelmq0vj66i4hmf' );
define( 'LOGGED_IN_KEY',    'aejzituxa1bcpdimmpn163lgqbtodexkywuj7ul93mgjocmr4dv3ysqkcabnhtvt' );
define( 'NONCE_KEY',        '1q8cmol6mfvjunskdgiaembgb04bdbu9j1mr2pnizrqd2j91h41d1us1qfo4ll2r' );
define( 'AUTH_SALT',        'jgpt4hiqa8big6l6jxzvffd2wgdyumzgtegjrwabxkn9jhfnfl0uslf2cr5hpn24' );
define( 'SECURE_AUTH_SALT', 'towarjy2rwzhqhzqbj5n5l35zatqmwx86efilhaclkprmpsgexwzq3sp5suc47j4' );
define( 'LOGGED_IN_SALT',   'tgazihtnobsmcdtektql65np32kdngkteebselzroajhyb1peos444rsg6lugwxz' );
define( 'NONCE_SALT',       'w21ce6lrsuv4asgqfvxu8yf8nm9e6rmb4s0r3jfhk2mrzrx5xyceoldh7tsh1x89' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
