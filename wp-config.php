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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'vfirstad_tamnguyen' );

/** MySQL database username */
define( 'DB_USER', 'vfirstad_tamnguyen' );

/** MySQL database password */
define( 'DB_PASSWORD', 'P57FRKYd' );

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
define( 'AUTH_KEY',         '6H&rbWdimr~q7.AO?@EYd} H.i-;=m3A0OH$^4|{hct%+oxiV|2/pobSNrzlwagn' );
define( 'SECURE_AUTH_KEY',  'v#Ob.4VqY3y9vS{95>;rHyv_qE}ss&gY)I>@#NXci6:A=w^KSa:]tga8T?Ym8TN?' );
define( 'LOGGED_IN_KEY',    '#Hlmh`.]WxfmCU8l2jspGtN$X3cpb+q:+]dqY(OJ+oyhTpwCfrgn4|RSdkCo*h,E' );
define( 'NONCE_KEY',        'm%}ayRk%$lb^Y(!E+}?0(4!>JE0@G@~wC*O{b6qj#0JhK8;GSNlrT0+10lB*Wnw3' );
define( 'AUTH_SALT',        'L+oM*v6iF*R8#C{oTd3}>[y%ZH+%2i~2<t:%0$4S/K+9YT;@&+(Bwx0xv%b&mQ>0' );
define( 'SECURE_AUTH_SALT', 'h(/M|!sf1*HeJ=y,owFYX9W0028)}>mE~~7uNpq+~B/ D?;)E4/JYCj=J~?ooKE[' );
define( 'LOGGED_IN_SALT',   '4gjC.Gs5C!;H?34udxGN >>}_qW7Mx6D@k_XlBF}0HM-)- #LWkXndH;Z_H2,^:J' );
define( 'NONCE_SALT',       'r>B7~^r (YZaoyhg]%*p}_`DG-=.TRwT zVIcX`4`N+2.VI0@Oy!F/zND)?e&4-g' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
