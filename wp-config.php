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
define('DB_NAME', 'wp_qlokare');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'n#b-,/+[st5c3`w>t-`erIB^2VrR_9^(Kp*uOw]xj[0%|r&]o.-&xTe):!Gymy>V');
define('SECURE_AUTH_KEY',  'UdQi/Dzc4OL1D&aw:`|m,aqEv5n`97G,!r*tN$@3jcn~wZ}KzS8:*SAGu.u;B&PJ');
define('LOGGED_IN_KEY',    'n;l!P?.JC+^YWUl@ :+<rKtgU|k>7^y&=bXS[|Dnh-+*zAJ+gW#zum,IJ>i*vk?{');
define('NONCE_KEY',        '|-f6Z~u3WxQF2>(2x1W^_%?KjAhj|!alde}gy{7^|$C`tB+8Y9%5V;]uV:T_fvuT');
define('AUTH_SALT',        'HZwHH#mGNR3kR- %X7}8pkuLN&cAdRQlZi.a-XY#TCyGsg8klt9_fgAd6 C!Us=|');
define('SECURE_AUTH_SALT', 'iH2|ja4WjXShcV7.yU{;!mN);7_%?-LvL}W+z0q~ueX8Ax[nZ)^nO5|dU-x`wm73');
define('LOGGED_IN_SALT',   'fy$P5&|ISRy9MNhUQ,:49QStDO}~0Bi9FAn,JiN[/nJjccipc*n`~$_c.%*$C<Gz');
define('NONCE_SALT',       '$ezuCKAOIJpl+~]Hy`/1J)>x+Bhj+QX[-a2GD+eH@*K0 5#pz?,QOepM.b:1+sy+');

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
