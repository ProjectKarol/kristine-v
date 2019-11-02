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
// define('DB_NAME', 'krisinev_loc-en');

// /** MySQL database username */
// define('DB_USER', 'krisinev_loc-en');

// /** MySQL database password */
// define('DB_PASSWORD', 'd)@1942E5_sF@H_');

// /** MySQL hostname */
// define('DB_HOST', 's67.linuxpl.com');

// /** The name of the database for WordPress */
define('DB_NAME', 'kristine-v');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'Versacze13');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

// /** Database Charset to use in creating database tables. */
// define('DB_CHARSET', 'utf8mb4');

// /** The Database Collate type. Don't change this if in doubt. */
// define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define(
    'AUTH_KEY',
    ',SftK.anIUa0Z4Jkb -t`Ybml*@7PcX]BDC%by 5sAk~h0CFp51=du7B$}by%[/b'
);
define(
    'SECURE_AUTH_KEY',
    'NX eYjN[leRkhU6d 2zk$!^~=v(zD% 1L2Nl}OJn[&0~m4e/z44c[m/Yb/Cl;o^2'
);
define(
    'LOGGED_IN_KEY',
    'N~rOi~0=|W[^=.P|qAMcb@%yK4iIYo5@)QNV}%f6NI|c]=jg M,{m/6aQyy;7?w+'
);
define(
    'NONCE_KEY',
    '{^i]YR{Wq.pJS,y/wQ!R=rZ<%p$>K {s~_I}^bW*;mt`E y;+V7?T^|yePpwRZyM'
);
define(
    'AUTH_SALT',
    'BMRuqs.8_;FH`vPZf/Pj+s3YfqJWc~Z fP;1*Lvtn+ M~dYHO<beF _4%ImH8=N_'
);
define(
    'SECURE_AUTH_SALT',
    '-WdE-}/ p6f1>r K2@ x0Z(@E~NK,z5!4DDkjd2OlmX_~8JU/vhQUN(>~U]> RR?'
);
define(
    'LOGGED_IN_SALT',
    'K1}/n| CkFyUP@fNQ4yzhUma6DzztuJp8u}4>zhZg=M~.r>fVr8yb>W?<,-G^3u|'
);
define(
    'NONCE_SALT',
    'A}LhUU0mz9m.,0SG%2iWi2;fu4Hr)F;A)AyFh.wo-vj^<DBc(a)h4%~05*UF0L-+'
);

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
define('WP_DEBUG', false);

// defelopment envoroments
$envs = array(
    'development' => 'https://www.kristine-v.loc',
    'staging' => 'https://kristine.intellegro.pl/',
    'production' => 'https://www.kristine-v.com'
);
define('ENVIRONMENTS', serialize($envs));

define('WP_ENV', 'development');
define('WP_ALLOW_REPAIR', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
