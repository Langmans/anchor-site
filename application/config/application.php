<?php

/**
 * PeachyPhp
 *
 * Just another PHP Framework
 *
 * @package		peachy-php
 * @author		k. wilson
 * @link		http://peachy-php.co.uk
 */

return array(
	/*
	 * Base url
	 * ----------------------------
	 * Root url of your installation. e.g. http://example.com/
	 */
	'base_url' => '/',

	/*
	 * Index page
	 * ----------------------------
	 * Typically this will be your index.php file, unless you've renamed it to
	 * something else. If you are using mod_rewrite to remove the page set this
	 * variable so that it is blank.
	 */
	'index_page' => '',

	/*
	 * Character set
	 * ----------------------------
	 * This determines which character set is used by default in various methods
	 * that require a character set to be provided.
	 */
	'charset' => 'UTF-8',

	/*
	 * Timezone
	 * ----------------------------
	 * Use either local server time or a specified time zone.
	 * Full list of time zones can be found here http://www.php.net/manual/en/timezones.php
	 */
	'timezone' => 'UTC',

	/*
	 * Session encryption
	 * ----------------------------
	 * If you use the Sessions class you MUST set an encryption key.
	 */
	'encryption_key' => 'secret',

	/*
	 * Error reporting
	 * ----------------------------
	 * Show details of the error, when set to
	 * false a 500 page is show instead
	 */
	'error' => array(
		'detail' => true
	)
);
