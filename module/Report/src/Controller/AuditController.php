<?php

namespace Report\Controller;

use Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Audit\Service\AuditService;
use Access\Service\AccessService;
use Audit\Form\AuditForm;
use Audit\Filter\AuditFilter;
use Audit\Model\Audit;

class AuditController extends AbstractActionController
{
	private $resourceService;
	private $accessService;

	public function __construct()
	//public function __construct(AuditService $resourceService, AccessService $accessService)
	{
		//$this->resourceService = $resourceService;
		//$this->accessService = $accessService;
	}

	public function indexAction()
	{
		return [
			//'resources' => $this->resourceService->getAudits(),
		];
	}
}
