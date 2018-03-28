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
define('DB_NAME', 'sql12229338');

/** MySQL database username */
define('DB_USER', 'sql12229338');

/** MySQL database password */
define('DB_PASSWORD', '9dLg4YbYZR');

/** MySQL hostname */
define('DB_HOST', 'sql12.freemysqlhosting.net');

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
define('AUTH_KEY',         ',uwbx-g9U 0q&ulY`]?@vXfPhj.vz$lJ0Zu/}]EoHY:&2+vX.f:j)t0A=rf-S:6G');
define('SECURE_AUTH_KEY',  'JO!5-] Ts?%R1V?7mi9B:*pIav1rj[A&Ssm}hK{x`+3O>7p!.BP&JdXl){k%`!qj');
define('LOGGED_IN_KEY',    'LL6[QR!adByC4K=!Rn>Hc3o(r{$@<k1M?PdGw8<yweTa?XHziuW?voqfv}Y1n^*V');
define('NONCE_KEY',        '?w8wjktO0s`]+)!ztqH,z;5YsT(CCANDin1M:Vg ]dGro~#ZF`>/{&Vd-2i[0[ch');
define('AUTH_SALT',        'BRA}=AN`=fE@_o mf_.1D&G=!Q<p~#DGvoth+lC};8ZL<|E?:3GSk(Pd8QY3`Pb_');
define('SECURE_AUTH_SALT', '8(R9uETBwYJunhf]lY@ETJSFW%)ql]j`gc^a3{O}>vgc/,Zxu$OPl~E.xHzlAVoh');
define('LOGGED_IN_SALT',   'mxv&~k3`>RIF}1c.}5r2Kdrs9!q_MW~jEaF Ov:c0akN $Yh3 ^L=TcWihsEx w*');
define('NONCE_SALT',       '~S#{8J<TPtBaA;oBAe3D%W(Uz9f9$|C;.k^eVd&A@@#2^SzdBplH3R*|;UJCZg2w');

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
