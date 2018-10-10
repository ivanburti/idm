<?php

namespace Access\Service;

use Access\Model\Access;
use Access\Model\AccessTable;

class AccessService
{
    private $accessTable;

    public function __construct(AccessTable $accessTable)
    {
        $this->accessTable = $accessTable;
    }

    public function getAccesses()
    {
        return $this->accessTable->getAccesses();
    }

    public function getAccessById($access_id)
    {
        $access_id = (int) $access_id;
        return $this->accessTable->getAccessById($access_id);
    }

    public function getAccessesByUserId($user_id)
    {
        $user_id = (int) $user_id;
        return $this->accessTable->getAccessesByUserId($user_id);
    }

    public function getAccessesByResourceId($resource_id)
    {
        $resource_id = (int) $resource_id;
        return $this->accessTable->getAccessesByResourceId($resource_id);
    }

















    public function updateAccess(Access $access)
    {
        $this->accessTable->saveAccess($access);
    }



    public function addAccess(Array $data)
    {
        $access = new Access();
        $access->exchangeArray($data);
        $this->accessTable->saveAccess($access);
    }
}
