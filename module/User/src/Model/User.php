<?php

namespace User\Model;

class User
{
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
	public $is_enabled;
	public $created_on;
	public $updated_on;
	public $organization_organization_id;
	public $organization_name;
	public $organization_is_enabled;
	public $organization_is_external;

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
		$this->is_enabled = !empty($data['is_enabled']) ? $data['is_enabled'] : null;
		$this->created_on = !empty($data['created_on']) ? $data['created_on'] : null;
		$this->updated_on = !empty($data['updated_on']) ? $data['updated_on'] : null;
		$this->organization_organization_id = !empty($data['organization_organization_id']) ? $data['organization_organization_id'] : null;
		$this->organization_name = !empty($data['organization_name']) ? $data['organization_name'] : null;
		$this->organization_is_enabled = !empty($data['organization_is_enabled']) ? $data['organization_is_enabled'] : null;
		$this->organization_is_external = !empty($data['organization_is_external']) ? $data['organization_is_external'] : null;
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
			'is_enabled' => $this->is_enabled,
			'created_on' => $this->created_on,
			'updated_on' => $this->updated_on,
			'organization_organization_id' => $this->organization_organization_id,
		];
	}

	public function setUserId(int $user_id)
	{
		$this->user_id = $user_id;
	}

	public function getUserId() {
		return $this->user_id;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setFullName($full_name)
	{
		$this->full_name = $full_name;
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

	public function setResignationDate($resignation_date)
	{
		$this->resignation_date = !empty($resignation_date) ? $resignation_date : null;
	}

	public function getResignationDate() {
		return $this->resignation_date;
	}

	public function setPosition($position)
	{
		$this->position = $position;
	}

	public function getPosition() {
		return $this->position;
	}

	public function setSupervisorName($supervisor_name)
	{
		$this->supervisor_name = $supervisor_name;
	}

	public function getSupervisorName() {
		return $this->supervisor_name;
	}

	public function setIsEnabled()
	{
		$this->is_enabled = 1;
	}

	public function setIsNotEnabled()
	{
		$this->is_enabled = null;
	}

	public function getIsEnabled()
	{
		return $this->is_enabled;
	}

	public function isEnabled()
	{
		if ($this->getIsEnabled()) {
			return true;
		}
	}

	public function getOrganizationId() {
		return $this->organization_organization_id;
	}

	public function setOrganizationId(int $organization_id) {
		$this->organization_organization_id = $organization_id;
	}
}
