<?php

namespace People\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use People\Service\PopulatorService;
use Organization\Service\OrganizationService;
use People\Filter\UserFilter;
use People\Service\UserService;
use People\Model\Populator;
use People\Model\User;
use People\Form\PopulatorForm;

class PopulatorController extends AbstractActionController
{
	private $populatorService;
	private $organizationService;
	private $userFilter;
	private $userService;

	public function __construct(PopulatorService $populatorService, OrganizationService $organizationService, UserFilter $userFilter, UserService $userService)
	{
		$this->populatorService = $populatorService;
		$this->organizationService = $organizationService;
		$this->userFilter = $userFilter;
		$this->userService = $userService;
	}

	public function indexAction()
	{
		return [
			'populators' => $this->populatorService->getPopulators()
		];
	}

	public function addAction()
	{
		$form = new PopulatorForm();

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return ['form' => $form];
		}

		$populator = new Populator();
		$form->setInputFilter($populator->getInputFilter());
		$form->setData($request->getPost());

		if (! $form->isValid()) {
			return ['form' => $form];
		}

		$populator->exchangeArray($form->getData());
		$populator_id = $this->populatorService->addPopulator($populator);

		return $this->redirect()->toRoute('populator', ['action' => 'details', 'id' => $populator_id]);
	}

	public function editAction()
	{
		$populator_id = (int) $this->params()->fromRoute('id', 0);
		$populator = $this->populatorService->getPopulatorById($populator_id);

		$form = new PopulatorForm();
		$form->bind($populator);

		$viewData = ['populator' => $populator, 'form' => $form];

		$request = $this->getRequest();
		if (! $request->isPost()) {
			return $viewData;
		}

		$form->setInputFilter($populator->getInputFilter());
		$form->setData($request->getPost());

		if (! $form->isValid()) {
			return $viewData;
		}

		$this->populatorService->editPopulator($populator);

		return $this->redirect()->toRoute('populator', ['action' => 'details', 'id' => $populator_id]);
	}

	public function detailsAction()
	{
		$populator_id = (int) $this->params()->fromRoute('id', 0);
		$populator = $this->populatorService->getPopulatorById($populator_id);

		return ['populator' => $populator];
	}

	public function pullAction()
	{
		$populator_id = (int) $this->params()->fromRoute('id', 0);

		$organizations = $this->organizationService->getInternalListByEmployerNumber();
		$filter = $this->userFilter->getEmployeeFilter();

		foreach ($this->populatorService->pullPopulator($populator_id) as $row)
		{
			$user = new User();
			$user->exchangeArray($row);
			$user->setOrganizationId(array_search($row['employer_number'], $organizations));

			$filter->setData($user->getArrayCopy());
			if (! $filter->isValid()) {
				var_dump($user);
				var_dump($filter->getMessages());
			}

			try {
				$user = $this->userService->getEmployeeByWorkIdOrganizationId($user->getWorkId(), $user->getOrganizationId());
			} catch (\RuntimeException $e) {
				$user = $this->userService->addEmployee($user);
			}

			$this->userService->updateEmployee($user, $row);
		}

		return $this->redirect()->toRoute('populator', ['action' => 'details', 'id' => $populator_id]);
	}
}
