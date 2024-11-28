<?php
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
define( 'DB_NAME', 'web_Nurjihan' );

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
define( 'AUTH_KEY',         'LA8lQNG(,xVWl6N.pi/GmKQ09B:qS,8MC@bXe(2F[G(H=qKhApJ|HVBusv4WT*Kx' );
define( 'SECURE_AUTH_KEY',  'k`V6. _U6YS#4L.w`bkBbCNfBtA6G`OnxUgmI#:PnM3=@Ffe?Z}Ook4{[|7/h{!m' );
define( 'LOGGED_IN_KEY',    '94{}Q0{u1u!nIK})`Gl9 4v^Ktx|I2n*mBow&FSBbq!]VhQ@dz* .IS9&w/wVtW|' );
define( 'NONCE_KEY',        'H#29@aCcSQ7QN*G7U|d7NJL~Mdc$G(:G,ri70EL~w~G40L@L8;sv&W/z[m-Di}J}' );
define( 'AUTH_SALT',        ']z:Bu<k0oCm>nc=1&@f`*E:>>P.OS+5 C2%}pnc5;`<?B/FGz72t6wmpWzzOpjLz' );
define( 'SECURE_AUTH_SALT', 'A})]7U;giY]Kg*5&7{QgJyV+c+Hc!f,vGg<vxn#@5DT`w6~c?VD:jVT^m~P?dmY)' );
define( 'LOGGED_IN_SALT',   '#A#]ONgT3Jy;zXLQi8<[~;}*~r7%1Te_5Q%i/D9m|38R=qktu{>//egnWW8hM?@!' );
define( 'NONCE_SALT',       '(o-`qZzO^gY_u7vJm%-0tt,<) ~-nnFpI+@PCLBI}0zB[5V&Az`lRJSVbcVO71%>' );

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
