<?php

namespace Organization\Controller;

use Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Organization\Service\OrganizationService;
use Organization\Filter\OrganizationFilter;

class InternalController extends AbstractActionController
{
	private $organizationService;

	public function __construct(OrganizationService $organizationService)
	{
		$this->organizationService = $organizationService;
	}

	public function addAction()
	{
		$form = new OrganizationForm();

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return ['form' => $form];
		}

		$filter = new OrganizationFilter();
		$filter->setNewInternalForm();
		$form->setInputFilter($filter->getInputFilter());

		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return ['form' => $form];
		}

		$this->organizationService->createInternal($form->getData());

		return $this->redirect()->toRoute('organization/service-provider');
	}

	public function editAction()
	{
		$organization_id = (int) $this->params()->fromRoute('id', 0);
		$organization = $this->organizationService->getInternalById($organization_id);
		var_dump($organization);
		exit();

		$form = new OrganizationForm();
		$form->bind($organization);
		$viewData = ['organization' => $organization, 'form' => $form];

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return $viewData;
		}

		$filter = new OrganizationFilter();
		$form->setInputFilter($filter->getInputFilter());
		$filter->setNewInternalForm();

		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return $viewData;
		}

		$this->organizationService->updateInternal($form->getData());

		return $this->redirect()->toRoute('organization/service-provider');
	}
}
