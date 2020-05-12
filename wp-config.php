<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

 set_time_limit(300);
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'igpmarket' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'R/d3cTnhCuEz{f`VZZt)i-!z^K&&w})b=}T8_8&>05)PJl{&TSB/L&`^zea{70kW' );
define( 'SECURE_AUTH_KEY',  '.RD|Lkw7VBPw<@0aV3dW|<P7w2V+s<tzlt*&+Lq[K2S+6tbZH4rhm/Y1moEPK]mf' );
define( 'LOGGED_IN_KEY',    ':ImR_s;>cVyF$ki#yOEf$W[76X8xfwm#5J~krnZR<*iO#:nnLcpf/mEStH_w|D3D' );
define( 'NONCE_KEY',        'VZ8^1k.P7xt6;ko=$uVOOp-5,xnYuSxO0+:%8T5R{+.S.!9;zl2Rg {6Zh7TS*QJ' );
define( 'AUTH_SALT',        'J.#[V%e{^3fL^|flnoEo08,o)D8e}9F`G3_n75hzD}i,UmN,ity)]A<o(-UR[mjp' );
define( 'SECURE_AUTH_SALT', 'pw|*Gqy(&`&XdWoJS:H46Q* YfQB^#.bjlS==b!U./9;]%Ph+7^RG1)]Bkr_LkU-' );
define( 'LOGGED_IN_SALT',   'ui1;]DLdy~VUjJ?3@n~[ rvFCg #vr+`UwW&HfNF|eU^%)oe25!$?69>aq,Rj&Tx' );
define( 'NONCE_SALT',       '~%[;s*Y^nT;1ItY;APj|@(<OPdUtf}8z-$),UFD@PviCst!}/M^WBf$QCtv#GX9S' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
