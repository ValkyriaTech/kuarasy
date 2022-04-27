<?php

require_once(dirname(__DIR__, 1) . '/models/Base.php');

class BaseController {

	protected $helper;
	private $model;

	public function __construct() {
		$this->helper = new Helper();
		$this->model = new BaseModel();
	}

	public function status() {
		$dbConnected = $this->model->checkDbConnection();

		$content = (object) [
			'kuarasy' => [
				'version' => KUARASY_VERSION
			],
			'php' => [
				'version' => phpversion()
			],
			'mysql' => [
				'connected' => $dbConnected,
				'version' => $dbConnected ? $this->model->getMySqlVersion()['Value'] : null
			]
		];

		return $this->helper->response(!empty($content), $content);
	}
}
