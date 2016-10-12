<?php

use lithium\core\Libraries;
use lithium\data\Connections;

return (function() {
	$defaults = [
		'migrations' => LITHIUM_APP_PATH . '/resources/db/migrations',
		'seeds'      => LITHIUM_APP_PATH . '/resources/db/seeds',
		'connection' => 'default',
		'logTable'   => '__migrations'
	];

	$config  = Libraries::get('li3_phinx', 'config') ?: [];
	$config += $defaults;
	$params  = Connections::get($config['connection'], ['config' => TRUE]);
	$source  = Connections::get($config['connection']);
	$options = [
		'paths' => $config,
		'environments' => [
			'default_migration_table' => $config['logTable'],
			'default_database' => 'production',
			'production' => [
				'name' => $params['database'],
				'connection' => $source->connection,
			]
		]
	];

	return $options;
})();

?>