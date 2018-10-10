<?php

namespace Organization\Model;

use DomainException;

class Organization
{
	const ORGANIZATION_STATUS_ENABLE = 1;
	const ORGANIZATION_STATUS_DISABLE = 2;

	const ORGANIZATION_TYPE_INTERNAL = 1;
	const ORGANIZATION_TYPE_EXTERNAL = 2;

	public $organization_id;
	public $alias;
	public $name;
	public $type;
	public $employer_number;
	public $created_on;
	public $expires_on;
	public $status;
	public $owners;

	public function exchangeArray($data)
	{
		$this->organization_id = !empty($data['organization_id']) ? $data['organization_id'] : null;
		$this->alias = !empty($data['alias']) ? $data['alias'] : null;
		$this->name = !empty($data['name']) ? $data['name'] : null;
		$this->type = !empty($data['type']) ? $data['type'] : null;
		$this->employer_number = !empty($data['employer_number']) ? $data['employer_number'] : null;
		$this->created_on = !empty($data['created_on']) ? $data['created_on'] : null;
		$this->expires_on = !empty($data['expires_on']) ? $data['expires_on'] : null;
		$this->status = !empty($data['status']) ? $data['status'] : null;
		$this->owners = !empty($data['owners']) ? $data['owners'] : null;
		$this->owners = $this->isJson($data['owners']) ? json_decode($data['owners']) : $data['owners'];
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
			'type' => $this->type,
			'employer_number' => $this->employer_number,
			'created_on' => $this->created_on,
			'expires_on' => $this->expires_on,
			'status' => $this->status,
			'owners' => $this->owners,
		];
	}

	public function getOrganizationId()
	{
		return $this->organization_id;
	}

	public function setAlias($alias)
	{
		$this->alias = $alias;
	}

	public function getAlias()
	{
		return $this->alias;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setType(int $type)
	{
		$this->type = $type;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getEmployerNumber()
	{
		return $this->employer_number;
	}

	public function setCreatedOn($created_on)
	{
		$this->created_on = $created_on;
	}

	public function getCreatedOn()
	{
		return $this->created_on;
	}

	public function setExpiresOn($expires_on)
	{
		$this->expires_on = $expires_on;
	}

	public function getExpiresOn()
	{
		return $this->expires_on;
	}

	public function setStatus(int $status)
	{
		$this->status = $status;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function setOwners($owners)
	{
		$this->owners = $owners;
	}

	public function getOwners()
	{
		return $this->owners;
	}

	public static function getStatusList()
	{
		return [
			self::ORGANIZATION_STATUS_ENABLE => 'Enable',
			self::ORGANIZATION_STATUS_DISABLE => 'Disable',
		];
	}

	public function getStatusAsString()
	{
		$list = self::getStatusList();
		if (isset($list[$this->status]))
		return $list[$this->status];

		return 'Unknown';
	}

	public static function getTypesList()
	{
		return [
			self::ORGANIZATION_TYPE_INTERNAL => 'Internal',
			self::ORGANIZATION_TYPE_EXTERNAL => 'External',
		];
	}

	public function getTypeAsString()
	{
		$list = self::getTypesList();
		if (isset($list[$this->type]))
		return $list[$this->type];

		return 'Unknown';
	}

	public function isInternal()
	{
		if ($this->type == self::ORGANIZATION_TYPE_INTERNAL){
			return true;
		}
		return false;
	}

	public function isExternal()
	{
		if ($this->type == self::ORGANIZATION_TYPE_EXTERNAL){
			return true;
		}
		return false;
	}
}
