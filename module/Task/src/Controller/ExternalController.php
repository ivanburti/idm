<?php

namespace Organization\Controller;

use Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Organization\Form\OrganizationForm;
use Organization\Filter\OrganizationFilter;
use Organization\Service\OrganizationService;
use User\Service\UserService;
use Organization\Model\Organization;

class ExternalController extends AbstractActionController
{
	private $serviceProviderForm;
	private $serviceProviderFilter;
	private $organizationService;
	private $userService;

	public function __construct(OrganizationForm $organizationForm, OrganizationFilter $organizationFilter, OrganizationService $organizationService, UserService $userService)
	{
		$this->organizationForm = $organizationForm;
		$this->organizationFilter = $organizationFilter;
		$this->organizationService = $organizationService;
		$this->userService = $userService;
	}

	public function addAction()
	{
		$form = $this->organizationForm;

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return ['form' => $form];
		}

		$filter->setNewServiceProviderForm();
		$form->setInputFilter($filter->getInputFilter());

		$form->setData($request->getData());
		if (! $form->isValid()) {
			return ['form' => $form];
		}

		$this->organizationService->createServiceProvider($form->getData());

		return $this->redirect()->toRoute('organization/service-provider');
	}

	public function editAction()
	{
		$organization_id = (int) $this->params()->fromRoute('id', 0);
		$organization = $this->organizationService->getInternalById($organization_id);

		$form = $this->organizationForm;
		$form->bind($organization);

		$viewData = ['organization' => $organization, 'form' => $form];

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return $viewData;
		}

		$filter = $this->organizationFilter;
		$form->setInputFilter($filter->getExternalFilter());

		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return $viewData;
		}

		$this->organizationService->updateExternal($organization_id, $request->getPost());

		return $this->redirect()->toRoute('organization/organization', ['action' => 'detail', 'id' => $organization_id]);
	}
}
