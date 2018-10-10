<?php

namespace User\Model;

class User
{
	const USER_STATUS_ACTIVE = 1;
	const USER_STATUS_DISABLED = 2;

	public $user_id;
	public $email;
	public $full_name;
	public $birthday_date;
	public $personal_id;
	public $work_id;
	public $hiring_date;
	public $resignation_date;
	public $position;
	public $supervisor_name;
	public $status;
	public $created_on;
	public $updated_on;
	public $organizations_organization_id;
	public $organizations_type;
	public $organizations_status;

	public function exchangeArray($data)
	{
		$this->user_id = !empty($data['user_id']) ? $data['user_id'] : null;
		$this->email = !empty($data['email']) ? $data['email'] : null;
		$this->full_name = !empty($data['full_name']) ? $data['full_name'] : null;
		$this->birthday_date = !empty($data['birthday_date']) ? $data['birthday_date'] : null;
		$this->personal_id = !empty($data['personal_id']) ? $data['personal_id'] : null;
		$this->work_id = !empty($data['work_id']) ? $data['work_id'] : null;
		$this->hiring_date = !empty($data['hiring_date']) ? $data['hiring_date'] : null;
		$this->resignation_date = !empty($data['resignation_date']) ? $data['resignation_date'] : null;
		$this->position = !empty($data['position']) ? $data['position'] : null;
		$this->supervisor_name = !empty($data['supervisor_name']) ? $data['supervisor_name'] : null;
		$this->status = !empty($data['status']) ? $data['status'] : null;
		$this->created_on = !empty($data['created_on']) ? $data['created_on'] : null;
		$this->updated_on = !empty($data['updated_on']) ? $data['updated_on'] : null;
		$this->organizations_organization_id = !empty($data['organizations_organization_id']) ? $data['organizations_organization_id'] : null;
		$this->organizations_type = !empty($data['organizations_type']) ? $data['organizations_type'] : null;
		$this->organizations_status = !empty($data['organizations_status']) ? $data['organizations_status'] : null;
	}

	public function getArrayCopy()
	{
		return [
			'user_id' => $this->user_id,
			'email' => $this->email,
			'full_name' => $this->full_name,
			'birthday_date' => $this->birthday_date,
			'personal_id' => $this->personal_id,
			'work_id' => $this->work_id,
			'hiring_date' => $this->hiring_date,
			'resignation_date' => $this->resignation_date,
			'position' => $this->position,
			'supervisor_name' => $this->supervisor_name,
			'status' => $this->status,
			'created_on' => $this->created_on,
			'updated_on' => $this->updated_on,
			'organizations_organization_id' => $this->organizations_organization_id,
			'organizations_type' => $this->organizations_type,
			'organizations_status' => $this->organizations_status,
		];
	}

	public function isEnabled()
	{
		if ($this->status == 1) {
			return true;
		}
	}

	public function getId() {
		return $this->user_id;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getFullName() {
		return $this->full_name;
	}

	public function getWorkId() {
		return $this->work_id;
	}

	public function getHiringDate() {
		return $this->hiring_date;
	}

	public function getResignationDate() {
		return $this->resignation_date;
	}

	public function getPosition() {
		return $this->position;
	}

	public function getSupervisor() {
		return $this->supervisor_name;
	}

	public function getStatus() {
		return $this->status;
	}

	public function getStatusAsString() {
		$list = self::getStatusList();
		if (isset($list[$this->status]))
		return $list[$this->status];

		return 'Unknown';
	}

	public static function getStatusList()
	{
		return [
			self::USER_STATUS_ACTIVE => 'Active',
			self::USER_STATUS_DISABLED => 'Disabled',
		];
	}

	public function getOrganizationId() {
		return $this->organizations_organization_id;
	}
}
