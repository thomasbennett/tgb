<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'tgb_wp');

/** MySQL database username */
define('DB_USER', 'tbennett');

/** MySQL database password */
define('DB_PASSWORD', 'fireBall123');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '6JBhe|Uhl-VaNy>jK[8wV:96C<?q5v$H4pg&k$ky{|b2VXW8+LrRo_mt*E9>b}Mh');
define('SECURE_AUTH_KEY',  'd ekafab:tdo^,-O_nK|O|80 }OJ|n;>6,q^w|Q]R87x./zMN0yB~=E#!3FtUdgS');
define('LOGGED_IN_KEY',    'Gl-W_zyY0^hTttB]EHdj@:k&xZM=P!J+YLZ6dZqt_#-!fHb>v-AVo5bd$|Fe9d:w');
define('NONCE_KEY',        '>B[z|?O`a+XeB}{w;vir=|BiMpC&l:XZy:{C>n6y-W-f_T#v,):9$[.eZ-ck/Uqw');
define('AUTH_SALT',        'A28F{d$Og%?Hs(,yO9BIdX5PCrP/IZ&FTot1$7MXMQrp*=syt=?%Q9vx^3hu|4U:');
define('SECURE_AUTH_SALT', 'NmfHf4B.T<k%gX4vMcAH:de{{_y2.-o@^ymH*CBXPx)hY[1!{YX]$+19Hx9u}9dE');
define('LOGGED_IN_SALT',   'oW<|@P<A#2=4G;+4Hs%Ar0Xpm+?:5itd9gy>bgVvDE+_gtq-);c!nDZl<79p1<S1');
define('NONCE_SALT',       'pDh6cLN$SN=q-tcONCj+g7xBH3CEex^J1tXc|I+(X||0D*}%^~#,=V-H)|9FbYSh');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'tgb_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
