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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/home/storage/vhosts/charles-dewidehem-caltagirone.students-laplateforme.io/httpdocs/mycms/wp-content/plugins/wp-super-cache/' );
define( 'DB_NAME', 'charles-dewidehem-caltagirone_wp_pcgaming' );

/** MySQL database username */
define( 'DB_USER', 'wp_charles' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Charles_89!!!' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '4w:81~llDU42!@va:n03x1tgMeI4VGpL9Qt7Z@qtY0[;c+9pc8x+4Q;58nB~Ic(e');
define('SECURE_AUTH_KEY', 'f823;/H8Y%5;d9hZ|530e7vK(i8n6p%766z);WhJ4[H#z0#3k9)2*z|/|0s9mWJG');
define('LOGGED_IN_KEY', '(t/Z%7;45An(fC-7s(+7;*t/a[Ll|cQ813(mms)h07y5D*7~3NL_y08*nPdh3W9-');
define('NONCE_KEY', 'GE/#/5av:]mY;Vg1k_Np/m7~;-8Pll06*&@ANO2~kn|T354H);73GDh52@-OSu5@');
define('AUTH_SALT', 'LcLR(330|)398ny25lN;JF9j7(V4@0z6(K;-#&/ty#0@6|4tI4-|sTfx9+*3AUR7');
define('SECURE_AUTH_SALT', 'CWNRx6Das2P1FFUg11VkXCBG34KFi~rhVzdg)G1an0%vxK27H!8B1*7IJ7fP(hrS');
define('LOGGED_IN_SALT', ']g&yzn)aE1J(TLCX+7FAt;~7f]gm~q2h;tIj6~2[O~x6Fia&i0xO%P(282x167v0');
define('NONCE_SALT', 'd7#I00G7wsb[f9T#q9xgFv%p2dmO#F|/](pd(_9J-:!8GS+22N|nD3~D8(987|_:');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'ZNoNx_';


define('WP_ALLOW_MULTISITE', true);
define( 'DISALLOW_FILE_EDIT', true );
define( 'CONCATENATE_SCRIPTS', false );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
