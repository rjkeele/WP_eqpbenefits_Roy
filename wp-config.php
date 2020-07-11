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
define( 'DB_NAME', 'royhahn' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'TTBo7eioC+n3Ii%V+9uAh0>p&>xP+/+W1;0tSI&k83v_`NSul1{{_ODsw]oH;(7j' );
define( 'SECURE_AUTH_KEY',  'N.D:6^5vpEw`dHV:nJZfe/C&e9Bjt1Swz*%=@PM`+L~gyu?q@jYH}~#@7J-#(@tg' );
define( 'LOGGED_IN_KEY',    '1e-aPaPgTvd5LYM,SQKu)$Y!M8DHDt`5;B~7Op);V*RU*EI&]|bCqTnFEo)DhTHQ' );
define( 'NONCE_KEY',        'mdM8zp2aP=ldC~@r7R.(A>l1=P$hp#r?$K6&3d{kR{iG(DG[JRtY^@/g-2{D6Nzy' );
define( 'AUTH_SALT',        '>?/BedLQicmtUA[x/a{-PKew/sL3=BTBqB{H4Kdm<mO[O=ro@cIPR0,j,%)>J5pi' );
define( 'SECURE_AUTH_SALT', '>c(LXFHQW:Lq2Tde*?@5G()LUDW/B3I(p@{qTw_{tCc[|_fNL,TMmw!0)Goot^>/' );
define( 'LOGGED_IN_SALT',   '`[NxXrlv3%gDZZ]up64m_/T411K(XK7]U^h#},#qKoAzfN+ab2FZ**w@Pe`BZhi]' );
define( 'NONCE_SALT',       ']k(Vhn6f(K[$.n_HC)4B_UrqQ#V2ZBz^tv=i#6eD 1lc&px=<YOA}Su8>i/QMd#t' );

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

//@ini_set( 'upload_max_filesize' , '128M' );
//@ini_set( 'post_max_size', '128M');
//@ini_set( 'memory_limit', '256M' );
//@ini_set( 'max_execution_time', '300' );
//@ini_set( 'max_input_time', '300' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
