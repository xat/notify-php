<?php
/*
 * notify-php
 * https://github.com/xat/notify-php
 *
 * Simple Class for sending JSON-RPC
 * Notifications as POST-Request
 *
 * Copyright (c) 2012 Simon Kusterer
 * Licensed under the MIT license.
 */

/**
 * Class Notify
 *
 * JSON-RPC Notification made easy
 */
class Notify
{
	/**
	 * Default Config
	 * @var array
	 */
	protected $cfg = array
	(
		'url' => 'http://127.0.0.1:4440', // Send the Notifications to this URL
		'auth' => false, // Use Basic Authentification
		'username' => 'admin', // Username for Basic Authentification
		'password' => 'admin', // Password for Basic Authentification
		'fieldName' => 'rpc' // Name of the Form Fieldname
	);

	/**
	 * Create a new instance
	 * @param array
	 */
	function __construct($cfg = array())
	{
		$this->cfg = array_merge($this->cfg, $cfg);
	}

	/**
	 * Emit a notification
	 * @param string
	 * @param mixed
	 * @return mixed
	 */
	public function emit($method, $params = false)
	{
		$rpc = new stdClass();
		$rpc->jsonrpc = '2.0';
		$rpc->method = $method;

		if ($params) {
			$rpc->params = $params;
		}

		$post = http_build_query(array(
			$this->cfg['fieldName'] => json_encode($rpc)
		));

		if ($this->cfg['auth']) {
			$authHeader  = "Authorization: Basic " . base64_encode($this->cfg['username'].':'.$this->cfg['password'])."\r\n";
		} else {
			$authHeader = '';
		}

		$context = stream_context_create(array('http'=>array(
			'method' => 'POST',
			'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
				$authHeader .
				'Content-Length: '. strlen($post) . "\r\n",
			'content' => $post,
		)));

		return file_get_contents($this->cfg['url'], false, $context);
	}
}
