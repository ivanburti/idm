<?php

namespace Organization\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Organization\Service\OrganizationService;
use User\Service\UserService;

class OrganizationController extends AbstractActionController
{
	private $organizationService;
	private $userService;

	public function __construct(OrganizationService $organizationService, UserService $userService)
	{
		$this->organizationService = $organizationService;
		$this->userService = $userService;
	}

	public function indexAction()
	{
		return [
			'organizations' => $this->organizationService->getOrganizations()
		];
	}

	public function detailsAction()
	{
		$organization_id = (int) $this->params()->fromRoute('id', 0);

		$organization = $this->organizationService->getOrganizationById($organization_id);

		return [
			'organization' => $organization,
			'owners' => $this->userService->getUsersById($organization->getOwners()),
		];
	}

	public function editAction()
	{
		$organization_id = (int) $this->params()->fromRoute('id', 0);

		$organization = $this->organizationService->getOrganizationById($organization_id);

		if ($organization->isExternal()) {
			$route = 'organization/external';
		} else {
			$route = 'organization/internal';
		}

		return $this->redirect()->toRoute($route, ['action' => 'edit', 'id' => $organization_id]);
	}
}
