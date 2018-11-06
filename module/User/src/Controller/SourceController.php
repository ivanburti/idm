<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class SourceController extends AbstractActionController
{
	public function __construct()
	{
	}

	public function indexAction()
	{
		return [
			'sources' => []
		];
	}

	public function addAction()
	{
	}

	public function editAction()
	{
	}
}
