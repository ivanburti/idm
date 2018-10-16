<?php

namespace Resource\Model;

class Resource
{
	const RESOURCE_STATUS_ACTIVE = 1;
	const RESOURCE_STATUS_DISABLED = 2;

	public $resource_id;
	public $name;
	public $description;
	public $resource_auth;
	public $resource_email;
	public $status;
	public $owners;
	public $approvers;
	public $created_on;
	public $updated_on;

	public function exchangeArray($data)
	{
		$this->resource_id = !empty($data['resource_id']) ? $data['resource_id'] : null;
		$this->name = !empty($data['name']) ? $data['name'] : null;
		$this->description = !empty($data['description']) ? $data['description'] : null;
		$this->resource_auth = !empty($data['resource_auth']) ? $data['resource_auth'] : null;
		$this->resource_email = !empty($data['resource_email']) ? $data['resource_email'] : null;
		$this->status = !empty($data['status']) ? $data['status'] : null;
		$this->owners = !empty($data['owners']) ? $data['owners'] : null;
		$this->owners = $this->isJson($data['owners']) ? json_decode($data['owners']) : $data['owners'];
		$this->approvers = !empty($data['approvers']) ? $data['approvers'] : null;
		$this->approvers = $this->isJson($data['approvers']) ? json_decode($data['approvers']) : $data['approvers'];
		$this->created_on = !empty($data['created_on']) ? $data['created_on'] : null;
		$this->updated_on = !empty($data['updated_on']) ? $data['updated_on'] : null;
	}

	public function isJson($string){
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}

	public function getArrayCopy()
	{
		return [
			'resource_id' => $this->resource_id,
			'name' => $this->name,
			'description' => $this->description,
			'resource_auth' => $this->resource_auth,
			'resource_email' => $this->resource_email,
			'status' => $this->status,
			'owners' => $this->owners,
			'approvers' => $this->approvers,
			'created_on' => $this->created_on,
			'updated_on' => $this->updated_on,
		];
	}

	public static function getStatusList()
	{
		return [
			self::RESOURCE_STATUS_ACTIVE => 'Active',
			self::RESOURCE_STATUS_DISABLED => 'Disabled',
		];
	}

	public function getId() {
		return $this->resource_id;
	}

	public function getName() {
		return $this->name;
	}

	public function getDescription() {
		return $this->description;
	}

	public function getResourceAuth() {
		return $this->resource_auth;
	}

	public function getResourceEmail() {
		return $this->resource_email;
	}

	public function isActive()
	{
		if ($this->status == self::RESOURCE_STATUS_ACTIVE) {
			return true;
		}
	}

	public function getStatus() {
		return $this->status;
	}

	public function getStatusAsString()
	{
		$list = self::getStatusList();
		if (isset($list[$this->status]))
		return $list[$this->status];

		return 'Unknown';
	}

	public function getOwners() {
		return $this->owners;
	}

	public function getApprovers() {
		return $this->approvers;
	}

	public function getCreatedOn()
	{
		return $this->created_on;
	}

	public function getUpdateOn()
	{
		return $this->updated_on;
	}
}
