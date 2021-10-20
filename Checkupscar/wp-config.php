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
define( 'DB_NAME', 'jhjm9512' );

/** MySQL database username */
define( 'DB_USER', 'jhjm9512' );

/** MySQL database password */
define( 'DB_PASSWORD', 'rjatkqkeck123!@' );

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
define( 'AUTH_KEY',         '$L+z]0rcj_cmB7su0Ys-h|(IQIV&QkHofDeg+V.R/VP6BI.pzXhTnCSzFe&@u# I' );
define( 'SECURE_AUTH_KEY',  '>.IXL2@7/B f+Y7EeMw#ct!UY[ZZU!NnN<}#nieo*iDLp!G&_YF80)wM].0Rwexs' );
define( 'LOGGED_IN_KEY',    'a5-50;NhrgEzV(>E12f]CiI%p[NwZ!$kMYs)-1gdXm[B?1La3fLkkVoUaTavvArx' );
define( 'NONCE_KEY',        't}_+,,J}gsrNafnK`n{(pm .fo(hmT,F;MZ`;`;$j-Hq.xV#~Iz_+ibp)*UjL-;s' );
define( 'AUTH_SALT',        '~bTtEEm9Ab_bX) Hyn~_vqgw_>1BS&JxfwGZ;%?FgxvfeA8 X!W.~/K`V ^v>6_3' );
define( 'SECURE_AUTH_SALT', 'eV9+1{6kiV7s3xyk?IXz)~_$X$T{w;F1w^5IF@$`:RwBx`U-qQT(JKU~?F*_q63B' );
define( 'LOGGED_IN_SALT',   'tUOmS+zQJ!S1EfxFfV8_v&6ytLi-mOgYRw`=UZ@KQAkrfW*1Aq^w{=tk7AQ[/)yz' );
define( 'NONCE_SALT',       '*bdW1!avN^`GpWsY!+<d!^ReTJovDnhMwutW8J_LcuHrzhD<>B]Sq^!P*3-MNfHH' );

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
/* custom security setting */
define('DISALLOW_FILE_EDIT',false);
define('WP_POST_REVISIONS',7);
define('IMAGE_EDIT_OVERWRITE',true);
define('DISABLE_WP_CRON',true);
define('EMPTY_TRASH_DAYS',7);
