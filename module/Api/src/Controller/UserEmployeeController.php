<?php

namespace Api\Controller;

use Exception;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use User\Filter\EmployeeFilter;
use User\Service\EmployeeService;
use Organization\Service\InternalService;
use User\Model\User;

class UserEmployeeController extends AbstractRestfulController
{
	private $employeeFilter;
	private $employeeService;
	private $internalService;

	public function __construct(EmployeeFilter $employeeFilter, EmployeeService $employeeService, InternalService $internalService)
	{
		$this->employeeFilter = $employeeFilter;
		$this->employeeService = $employeeService;
		$this->internalService = $internalService;
	}

	public function getList()
	{
		return new JsonModel($this->employeeService->getEmployees());
	}

	public function get($user_id)
	{
		$user_id = (int) $user_id;
		$user = $this->employeeService->getEmployee($user_id);

		return new JsonModel($user->getArrayCopy());
	}

	public function create($data)
	{
		$filter = $this->employeeFilter->getNewEmployeeFilter();

		$filter->setData($data);
		if (! $filter->isValid()) {
			$this->getResponse()->setStatusCode(500);
			return new JsonModel($filter->getMessages());
		}
		$data = $filter->getValues();

		$user = $this->employeeService->checkEmployeeByWorkIdAndEmployeerNumber($data['employer_number'], $data['work_id']);
		if (! $user) {
			$internal = $this->internalService->getInternalByEmployerNumber($data['employer_number']);
			$data['organizations_organization_id'] = $internal->getOrganizationId();

			$user = $this->employeeService->addEmployee($data);
			$this->employeeService->enableEmployee($user->getUserId());

			$this->employeeService->enableEmployee($user->getUserId());
		}

		return $this->update($user->getUserId(), $data);
	}

	public function update($user_id, $data)
	{
		$user_id = (int) $user_id;
		$user = $this->employeeService->getEmployee($user_id);

		$filter = $this->employeeFilter->getUpdateEmployeeFilter();
		$filter->setData($data);
		if (! $filter->isValid()) {
			$this->getResponse()->setStatusCode(500);
			return new JsonModel($filter->getMessages());
		}
		$data = $filter->getValues();

		$this->employeeService->updateEmployee($user_id, $data);

		if ($user->getResignationDate() && $user->isEnabled()) {
            if (date_create($user->getResignationDate()) < date_create()) {
                return $this->delete($user_id);
            }
        }

		return new JsonModel(['User updated']);
	}

	public function delete($user_id)
	{
		$user_id = (int) $user_id;
		$user = $this->employeeService->getEmployee($user_id);

		$this->employeeService->disableEmployee($user_id);

		return new JsonModel(['User disabled']);
	}
}
