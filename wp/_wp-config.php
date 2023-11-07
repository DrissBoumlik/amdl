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
define( 'DB_NAME', 'amdl' );

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
define( 'AUTH_KEY',         'Pj-*q(h!!k}Py5Fz[=3Hdpk3tNU&y0!_T}~~y:pk5;`0@aM|1<3QsE ,%6p[rs6Q' );
define( 'SECURE_AUTH_KEY',  '`K1dXqNQkiRc1e3pAhYYJHFD<tuG}aNgV6Jy(<<Qrz+d>?q5mG+fJ#+uCL;1+!S#' );
define( 'LOGGED_IN_KEY',    '.YC6aTt8k9Kk:bHOP`D4L)exe:eZ}4rhZ7Q*FUu?F&<^:q9HKf8gh}uLXU>6yJLT' );
define( 'NONCE_KEY',        'qZWY9wbLPZbV|MOa?.2tm8BY$=cWr0,%6w}Z@%$E=vW$G($?Q{03GzY~Haj4.0[v' );
define( 'AUTH_SALT',        'Ag,}S1n|cu.L|}LQ2&hTLIdaLd:{pBUcKPGmN&%G6U+AqjUjg+x8~tuKYCU[2aGn' );
define( 'SECURE_AUTH_SALT', 'mkIOIw}gJ+ob^9wf31F?~i !z^Ms.~8M+,Ag%A 6m.0VW6<K;V%Zl8;&;|n{sY/L' );
define( 'LOGGED_IN_SALT',   'v70B*R~(^!yr6]Ute@gr6xvaHYDzXM$1%T?-1$?LMd[$c&agj+=npIbS1fW3qc0}' );
define( 'NONCE_SALT',       '*odnd_#3+%y#SzMI[uJ`p{JVwWotLgIW[}8AOJAb2&V(Y2nN8w8iM#V_l:Vw{7;x' );

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
define( 'WP_DEBUG', TRUE );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
