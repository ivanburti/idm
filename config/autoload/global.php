<?php

use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Validator\RemoteAddr;
use Zend\Session\Validator\HttpUserAgent;

return [
	'translator' => [
		'locale' => 'en_US',
		'translation_file_patterns' => [
			[
				'type'     => 'gettext',
				'base_dir' => getcwd() .  '/language',
				'pattern'  => '%s.mo',
			],
		],
	],
	// Session configuration.
	'session_config' => [
		'cookie_lifetime' => 120*120*1, // Session cookie will expire in 1 hour.
		'gc_maxlifetime' => 60*60*24*30, // How long to store session data on server (for 1 month).
	],
	// Session manager configuration.
	'session_manager' => [
		// Session validators (used for security).
		'validators' => [
			RemoteAddr::class,
			HttpUserAgent::class,
		]
	],
	// Session storage configuration.
	'session_storage' => [
		'type' => SessionArrayStorage::class
	],
];
