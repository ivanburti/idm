<?php

namespace Organization\Model;

use DomainException;

class Organization
{
	const ORGANIZATION_TYPE_INTERNAL = 1;
	const ORGANIZATION_TYPE_EXTERNAL = 2;

	public $organization_id;
	public $alias;
	public $name;
	public $employer_number;
	public $expires_on;
	public $is_external;
	public $is_enabled;
	public $owners;
	public $created_on;
	public $updated_on;

	public function exchangeArray($data)
	{
		$this->organization_id = !empty($data['organization_id']) ? $data['organization_id'] : null;
		$this->alias = !empty($data['alias']) ? $data['alias'] : null;
		$this->name = !empty($data['name']) ? $data['name'] : null;
		$this->employer_number = !empty($data['employer_number']) ? $data['employer_number'] : null;
		$this->expires_on = !empty($data['expires_on']) ? $data['expires_on'] : null;
		$this->is_external = !empty($data['is_external']) ? $data['is_external'] : null;
		$this->is_enabled = !empty($data['is_enabled']) ? $data['is_enabled'] : null;
		$this->owners = !empty($data['owners']) ? $data['owners'] : null;
		$this->owners = $this->isJson($data['owners']) ? json_decode($data['owners']) : $data['owners'];
		$this->created_on = !empty($data['created_on']) ? $data['created_on'] : null;
		$this->updated_on = !empty($data['updated_on']) ? $data['updated_on'] : null;
	}

	public function isJson($string){
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}

	public function getArrayCopy()
	{
		return [
			'organization_id' => $this->organization_id,
			'alias' => $this->alias,
			'name' => $this->name,
			'employer_number' => $this->employer_number,
			'expires_on' => $this->expires_on,
			'is_external' => $this->is_external,
			'is_enabled' => $this->is_enabled,
			'owners' => $this->owners,
			'created_on' => $this->created_on,
			'updated_on' => $this->updated_on,
		];
	}

	public function getOrganizationId()
	{
		return $this->organization_id;
	}

	public function getAlias()
	{
		return $this->alias;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getEmployerNumber()
	{
		return $this->employer_number;
	}

	public function setExpiresOn($expires_on)
	{
		$this->expires_on = $expires_on;
	}

	public function getExpiresOn()
	{
		return $this->expires_on;
	}

	public function setExternal()
	{
		$this->is_external = (int) 1;
	}

	public function isExternal()
	{
		if ($this->is_external) {
			return true;
		}
		return false;
	}

	public function setEnabled()
	{
		$this->is_enabled = (int) 1;
	}

	public function isEnabled()
	{
		if ($this->is_enabled) {
			return true;
		}
		return false;
	}

	public function setOwners($owners)
	{
		$this->owners = $owners;
	}

	public function getOwners()
	{
		return $this->owners;
	}

	public function getCreatedOn()
	{
		return $this->created_on;
	}

	public function getUpdatedOn()
	{
		return $this->updated_on;
	}
}
