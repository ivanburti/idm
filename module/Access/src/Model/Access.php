<?php

namespace Access\Model;

class Access
{
	public $access_id;
	public $username;
	public $is_enabled;
	public $is_generic;
	public $comment;
	public $created_on;
	public $resource_resource_id;
	public $user_user_id;
	public $resource_name;
	public $resource_is_enabled;
	public $user_full_name;
	public $user_is_enabled;

	public function exchangeArray($data)
	{
		$this->access_id = !empty($data['access_id']) ? $data['access_id'] : null;
		$this->username = !empty($data['username']) ? $data['username'] : null;
		$this->is_enabled = !empty($data['is_enabled']) ? $data['is_enabled'] : null;
		$this->is_generic = !empty($data['is_generic']) ? $data['is_generic'] : null;
		$this->comment = !empty($data['comment']) ? $data['comment'] : null;
		$this->created_on = !empty($data['created_on']) ? $data['created_on'] : null;
		$this->resource_resource_id = !empty($data['resource_resource_id']) ? $data['resource_resource_id'] : null;
		$this->user_user_id = !empty($data['user_user_id']) ? $data['user_user_id'] : null;
		$this->resource_name = !empty($data['resource_name']) ? $data['resource_name'] : null;
		$this->resource_is_enabled = !empty($data['resource_is_enabled']) ? $data['resource_is_enabled'] : null;
		$this->user_full_name = !empty($data['user_full_name']) ? $data['user_full_name'] : null;
		$this->user_is_enabled = !empty($data['user_is_enabled']) ? $data['user_is_enabled'] : null;
	}

	public function getArrayCopy()
	{
		return [
			'access_id' => $this->access_id,
			'username' => $this->username,
			'is_enabled' => $this->is_enabled,
			'is_generic' => $this->is_generic,
			'comment' => $this->comment,
			'created_on' => $this->created_on,
			'resource_resource_id' => $this->resource_resource_id,
			'user_user_id' => $this->user_user_id,
			'resource_name' => $this->resource_name,
			'resource_is_enabled' => $this->resource_is_enabled,
			'user_full_name' => $this->user_full_name,
			'user_is_enabled' => $this->user_is_enabled,
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

	public function isEnabled()
	{
		return ($this->is_enabled) ? true : false;
	}

	public function setIsEnabled()
	{
		$this->is_enabled = (int) 1;
	}

	public function isGeneric()
	{
		return ($this->is_generic) ? true : false;
	}

	public function setIsGeneric()
	{
		$this->is_generic = (int) 1;
	}

	public function getComment()
	{
		return $this->comment;
	}

	public function getCreatedOn()
	{
		return $this->created_on;
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
