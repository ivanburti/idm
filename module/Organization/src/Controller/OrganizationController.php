<?php

namespace Organization\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Organization\Form\OrganizationForm;
use Organization\Service\OrganizationService;
use User\Service\UserService;

class OrganizationController extends AbstractActionController
{
	private $organizationForm;
	private $organizationService;
	private $userService;

	public function __construct(OrganizationForm $organizationForm, OrganizationService $organizationService, UserService $userService)
	{
		$this->organizationForm = $organizationForm;
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
			'users' => $this->userService->getUsersByOrganizationId($organization_id),
		];
	}

	public function addAction()
	{
		$form = $this->organizationForm->getInternalForm();

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return ['form' => $form];
		}

		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return ['form' => $form];
		}

		$organization = new Organization();
		$organization->exchangeArray($form->getData());

		$organization_id = $this->organizationService->addInternal($organization);

		return $this->redirect()->toRoute('organization', ['action' => 'details', 'id' => $organization_id]);
	}

	public function addExternalAction()
	{
		$form = $this->organizationForm->getExternalForm();

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return ['form' => $form];
		}

		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return ['form' => $form];
		}

		$organization = new Organization();
		$organization->exchangeArray($form->getData());

		$organization_id = $this->organizationService->addExternal($organization);

		return $this->redirect()->toRoute('organization', ['action' => 'details', 'id' => $organization_id]);
	}

	public function editAction()
	{
		$organization_id = (int) $this->params()->fromRoute('id', 0);
		$organization = $this->organizationService->getOrganizationById($organization_id);

		if ($organization->isExternal()) {
			return $this->redirect()->toRoute('organization', ['action' => 'edit-external', 'id' => $organization_id]);
		}

		$form = $this->organizationForm->getInternalForm();
		$form->bind($organization);

		$request = $this->getRequest();
		$viewData = ['organization' => $organization, 'form' => $form];

		if (! $request->isPost()) {
			return $viewData;
		}

		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return $viewData;
		}

		$this->organizationService->updateInternal($organization);

		return $this->redirect()->toRoute('organization', ['action' => 'details', 'id' => $organization_id]);

	}

	public function editExternalAction()
	{
		$organization_id = (int) $this->params()->fromRoute('id', 0);
		$organization = $this->organizationService->getExternalById($organization_id);

		$form = $this->organizationForm->getExternalForm();
		$form->bind($organization);

		$request = $this->getRequest();
		$viewData = ['organization' => $organization, 'form' => $form];

		if (! $request->isPost()) {
			return $viewData;
		}

		$form->setData($request->getPost());
		if (! $form->isValid()) {
			return $viewData;
		}

		$this->organizationService->updateExternal($organization);

		return $this->redirect()->toRoute('organization', ['action' => 'details', 'id' => $organization_id]);

	}
}
