<?php

namespace Access\Model;

class Access
{
	const ACCESS_STATUS_DISABLED = 2;
	const ACCESS_STATUS_ACTIVE = 1;

	public $access_id;
	public $username;
	public $status;
	public $resources_resource_id;
	public $users_user_id;
	public $is_generic;
	public $comment;

	public $resource_name;
	public $user_full_name;

	public function exchangeArray($data)
	{
		$this->access_id = !empty($data['access_id']) ? $data['access_id'] : null;
		$this->username = !empty($data['username']) ? $data['username'] : null;
		$this->status = !empty($data['status']) ? $data['status'] : null;
		$this->resources_resource_id = !empty($data['resources_resource_id']) ? $data['resources_resource_id'] : null;
		$this->users_user_id = !empty($data['users_user_id']) ? $data['users_user_id'] : null;
		$this->resource_name = !empty($data['resource_name']) ? $data['resource_name'] : null;
		$this->user_full_name = !empty($data['user_full_name']) ? $data['user_full_name'] : null;
		$this->is_generic = !empty($data['is_generic']) ? $data['is_generic'] : null;
		$this->comment = !empty($data['comment']) ? $data['comment'] : null;
	}

	public function getArrayCopy()
	{
		return [
			'access_id' => $this->access_id,
			'username' => $this->username,
			'status' => $this->status,
			'resources_resource_id' => $this->resources_resource_id,
			'users_user_id' => $this->users_user_id,
			'is_generic' => $this->is_generic,
			'comment' => $this->comment,
		];
	}

	public function isOrphan()
	{
		$user_id = $this->getUserId();
		if (! $user_id) {
			return true;
		}
		return;
	}

	public function getAccessId()
	{
		return $this->access_id;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getStatus() {
		return $this->status;
	}

	public function isActive()
	{
		if ($this->status == self::ACCESS_STATUS_ACTIVE) {
			return true;
		}
	}

	public function getStatusAsString() {
		$list = self::getStatusList();
		if (isset($list[$this->status]))
		return $list[$this->status];

		return false;
	}

	public function getStatusList()
	{
		return [
			self::ACCESS_STATUS_ACTIVE => 'Active',
			self::ACCESS_STATUS_DISABLED => 'Disabled',
		];
	}

	public function getResourceId()
	{
		return $this->resources_resource_id;
	}

	public function getUserId()
	{
		return $this->users_user_id;
	}

	public function getResourceName()
	{
		return $this->resource_name;
	}

	public function getUserFullName()
	{
		return $this->user_full_name;
	}
}
