<?php
namespace li3_phinx\extensions\command;

use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\ArgvInput;

/**
 * The `phinx` command is a wrapper around the *Phinx* migrations library. It
 * automatically configures *Phinx* to use the `default` database connection of
 * your app.
 *
 * For details, see:
 * `li3 phinx help`
 */
class Phinx extends \lithium\core\Object {

	protected $_classes = [
		'response' => 'lithium\console\Response'
	];

	protected $_autoConfig = ['classes' => 'merge'];

	public function __construct(array $config = []) {
		$defaults = ['classes' => $this->_classes, 'response'];
		parent::__construct($config + $defaults);
	}

	protected function _init() {
		parent::_init();

		$this->response = $this->_instance('response', []);
	}

	/**
	 * @param string $command
	 */
	public function run($command = '') {
		$request = $this->_config['request'];
		$params  = $request->argv;

		if ($command === 'init') {
			$this->response->error('{:red}Can\'t use `init` with the `Li3` wrapper');
			return $this->response;
		}

		$request = $this->_config['request'];
		$params  = $request->argv;

		if ($command !== 'list') {
			$params[] = '--configuration=' . __DIR__ . '/../../config/phinx.php';
		}

		if ($command === 'create') {
			$params[] = '--template=' . __DIR__ . '/../../resources/MigrationsTemplate.php';
		}

		$this->_run($params);
	}

	protected function _help() {
		$this->_run(['phinx', 'help']);
	}

	protected function _run($params) {
		$args = new ArgvInput($params);
		$app  = new PhinxApplication();

		$app->run($args);
	}

	public function __invoke($action, $args = []) {
		return $this->invokeMethod($action, $args);
	}
}

?>