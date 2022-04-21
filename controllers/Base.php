<?php

require_once(dirname(__DIR__, 1) . '/models/Base.php');

class BaseController {

	private $helper;
	private $model;

	public function __construct() {
		$this->helper = new Helper();
		$this->model = new BaseModel();
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
				'connected' => $this->model->checkDbConnection(),
				'version' => $this->model->getMySqlVersion()['Value']
			]
		];

		return $this->helper->createMessage(!empty($content), $content);
	}
}
