<?php

namespace Api\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Organization\Service\OrganizationService;

class OrganizationInternalController extends AbstractRestfulController
{
	private $organizationService;

	public function __construct(OrganizationService $organizationService)
	{
		$this->organizationService = $organizationService;
	}

	public function getList()
	{
		return new JsonModel($this->organizationService->getInternals());
	}

	public function get($id)
	{
		return new JsonModel(['function' => __FUNCTION__]);
	}

	public function create($data)
	{
		return new JsonModel(['function' => __FUNCTION__]);
	}

	public function update($id, $data)
	{
		return new JsonModel(['function' => __FUNCTION__]);
	}

	public function delete($id)
	{
		return new JsonModel(['function' => __FUNCTION__]);
	}
}
