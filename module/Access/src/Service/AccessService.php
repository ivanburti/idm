<?php

namespace Access\Service;

use RuntimeException;
use Access\Model\AccessTable;
use Access\Model\Access;

class AccessService
{
    private $accessTable;

    public function __construct(AccessTable $accessTable)
    {
        $this->accessTable = $accessTable;
    }

    public function searchAccesses($data)
    {
        return $this->accessTable->searchAccesses($data);
    }

    public function getAccesses()
    {
        return $this->accessTable->getAccesses();
    }

    public function getOrphans()
    {
        return $this->accessTable->getOrphans();
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

    public function linkAccess($access_id, $user_id)
    {
        $access_id = (int) $access_id;
        $user_id = (int) $user_id;

        $access = $this->getAccessById($access_id);
        if (! $access->isOrphan()) {
            throw new RuntimeException(sprintf('Access %d is not orphan', $access_id));
        }

        $access->users_user_id = $user_id;

        return $this->accessTable->saveAccess($access);
    }

    public function setGeneric($access_id)
    {
        $access_id = (int) $access_id;

        $access = $this->getAccessById($access_id);
        if (! $access->isOrphan()) {
            throw new RuntimeException(sprintf('Access %d is not orphan', $access_id));
        }

        $access->is_generic = (int) 1;

        return $this->accessTable->saveAccess($access);
    }

    public function updateAccess(Access $access)
    {
        $this->accessTable->saveAccess($access);
        return true;
    }


}
