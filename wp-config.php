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
define('DB_NAME', 'desc');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'fOOzQFFm F3i;lmbFXmW;N5A+z#,U@oHzpbV3].*I,pL>Y9cP}^(tjGysT@yu83&');
define('SECURE_AUTH_KEY',  '?sRl@AG3VwllJjdzbKh DNNT3ep+GQO^{mu>sV=n=l/I=ENX+:`37gVPhVU.,XCK');
define('LOGGED_IN_KEY',    'N9:uF}eqE?a(j?b*nP$=j`9$*}PvVgLDCx:$x.C3mRDP;IugRLX<n9O1GJ!#Wr13');
define('NONCE_KEY',        '0eu8dGg/f5j$jf+1-6fK5T0wZ:de+(z#>v26roZ]0%a|<kb)to?>4ssL}>A#^3*L');
define('AUTH_SALT',        'aIf-[.!L#?)CxumLJ}l&=}POnh>l(O,v-7 e_}X[r6?`^$a,ASA&lhuH!g`*A*FF');
define('SECURE_AUTH_SALT', 'X8czlNgdNT?`|Ub~s-#^E)z^AMCBbX_/IJc;[gzb7Pc-iDW/x  ,Y5uXXq:<s.pa');
define('LOGGED_IN_SALT',   'jsg-2:}a|Wg)=*Fr :;TKb<_Z#~9@3JIu^OPu1rH<38]=Dm X6AH]y;yY1Kil{Du');
define('NONCE_SALT',       '+0hU#t~[mc04Q/(i%)R]Q93hz8u>W$$$n%kC>>ikli-A:{7I4*G ,CmB{_7hgn88');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
