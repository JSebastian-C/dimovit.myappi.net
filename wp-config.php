<?php

//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL
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
define('DB_NAME', "dimovit_database");
/** MySQL database username */
define('DB_USER', "root");
/** MySQL database password */
define('DB_PASSWORD', "");
/** MySQL hostname */
define('DB_HOST', "localhost");
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
define('AUTH_KEY',         'TQ(s>BS1C^n}=GrYIT); g/E+X>(EFSlA__^TI|:}!zmu!~S6?fQnEH1y-|Zk(o6');
define('SECURE_AUTH_KEY',  'P~=07,`(gGp)X&ztNHK^RUc#=Y]09WImm]60@O&x@.SX`y]<!sCs?4>gz@bAce@$');
define('LOGGED_IN_KEY',    '3]$J_1+r3$nPaa3+l$$j*T<u*U ?6(z-jX$]zZW|DPE7+:2lg|xK>v:l 0x8Hz}{');
define('NONCE_KEY',        'H.0#1w}A`E@W>&JPLbS>qyo~qx1al4.<j$NQj;Va-5+|?aD`yYoOsO /a*b-&7FZ');
define('AUTH_SALT',        ';XsAE.:ak6L=FsGyeQ;6|GgI,_psgAzj(z@rO6` ;#s>:_y}K2u$!{v*C)[8ML0f');
define('SECURE_AUTH_SALT', 'oeretx7t7mA`w6k9?:Ry7uCx_iAO_?G0e@G%4F6 C^QQH6MF|6}YuDhUpW4qZNYK');
define('LOGGED_IN_SALT',   'o`r&|:J9-Zv27J}ZF7|q^h4J{g :lj06.?$ZL)pm #c[S2kz;cE$JvnhP GC?Ckr');
define('NONCE_SALT',       'i:92:Fi#[vLj:0G2Qtu7}kprJ`9S4$GNJ4ZUJn[>S8*z~?iAu<7FY|[j@G(q`|3y');
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';
define('WP_ALLOW_REPAIR', true);
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
// Enable WP_DEBUG mode
define( 'WP_DEBUG', true );
 
// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', true );
 
// Disable display of errors and warnings
define( 'WP_DEBUG_DISPLAY', true );
@ini_set( 'display_errors', 1 );
 
// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
define( 'SCRIPT_DEBUG', true );
define( 'WPMS_ON', true );
define( 'WPMS_SMTP_PASS', '_jBjZb&9.C[w' );
/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
