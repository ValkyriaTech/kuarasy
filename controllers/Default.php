<?php

require_once(dirname(__DIR__, 1) . '/config.php');
require_once('Helper.php');

require_once(dirname(__DIR__, 1) . '/models/Default.php');

class DefaultController {

	private $helper;
	private $model;

	public function __construct() {
		$this->helper = new Helper();
		$this->model = new DefaultModel();
	}

	public function checkStatus() {
		$content = (object) [
			'kuarasy' => [
				'version' => KUARASY_VERSION
			],
			'php' => [
				'version' => phpversion()
			],
			'mysql' => [
				'connected' => (bool) $this->model->checkConnection(),
				'version' => $this->model->getMySqlVersion()['Value']
			]
		];

		return $this->helper->createMessage(!empty($content), $content);
	}
}
