<?php

namespace Report\Controller;

use Exception;
use Zend\Mvc\Controller\AbstractActionController;
//use Report\Service\ReportService;
use Access\Service\AccessService;
//use Report\Form\ReportForm;
//use Report\Filter\ReportFilter;
//use Report\Model\Report;

class ReportController extends AbstractActionController
{
	private $accessService;

	public function __construct(AccessService $accessService)
	{
		//$this->resourceService = $resourceService;
		$this->accessService = $accessService;
	}

	public function indexAction()
	{
		return [
			//'resources' => $this->resourceService->getReports(),
		];
	}

	public function orphansAction()
	{
		return [
			'accesses' => $this->accessService->getOrphans(),
		];
	}
}
