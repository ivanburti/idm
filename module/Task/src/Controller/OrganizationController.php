<?php

namespace Organization\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Organization\Form\OrganizationForm;
use Organization\Filter\OrganizationFilter;
use Organization\Service\OrganizationService;
use User\Service\UserService;

class OrganizationController extends AbstractActionController
{
	private $organizationForm;
	private $organizationFilter;
	private $organizationService;
	private $userService;

	public function __construct(OrganizationForm $organizationForm, OrganizationFilter $organizationFilter, OrganizationService $organizationService, UserService $userService)
	{
		$this->organizationForm = $organizationForm;
		$this->organizationFilter = $organizationFilter;
		$this->organizationService = $organizationService;
		$this->userService = $userService;
	}

	public function searchAction()
	{
		$form = $this->organizationForm;

		$viewData = [
			'form' => $form,
			'organizations' => [],
		];

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return $viewData;
		}

		$form->setInputFilter($this->organizationFilter->getOrganizationSearchFilter());
		$form->setData($request->getPost());

		$viewData['form'] = $form;

		if (! $form->isValid()) {
			return $viewData;
		}

		$viewData['organizations'] = $this->organizationService->searchOrganizations($request->getPost());
		return $viewData;
	}

	public function detailAction()
	{
		$organization_id = (int) $this->params()->fromRoute('id', 0);

		$organization = $this->organizationService->getOrganizationById($organization_id);

		return [
			'organization' => $organization,
			'owners' => $this->userService->getUsersById($organization->getOwners()),
			'users' => $this->userService->getUsersByOrganizationId($organization_id),
		];
	}

	public function disableAction()
	{

	}

	public function editAction()
	{
		$organization_id = (int) $this->params()->fromRoute('id', 0);

		$organization = $this->organizationService->getOrganizationById($organization_id);

		if ($organization->isInternal()) {
			$route = 'organization/internal';
		}

		if ($organization->isExternal()) {
			$route = 'organization/external';
		}

		return $this->redirect()->toRoute($route, ['action' => 'edit', 'id' => $organization_id]);
	}
}
