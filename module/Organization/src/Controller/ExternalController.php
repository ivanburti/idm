<?php

namespace Organization\Controller;

use Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Organization\Form\OrganizationForm;
use Organization\Service\OrganizationService;
use User\Service\UserService;
use Organization\Model\Organization;

class ExternalController extends AbstractActionController
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
		return $this->redirect()->toRoute('organization');
	}

	public function addAction()
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

		return $this->redirect()->toRoute('organization/organization', ['action' => 'details', 'id' => $organization_id]);
	}

	public function editAction()
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

        return $this->redirect()->toRoute('organization/organization', ['action' => 'details', 'id' => $organization_id]);
	}
}
