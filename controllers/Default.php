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

	public function checkConnection() {
		return $this->helper->createMessage((bool) $this->model->checkConnection());
	}
}
