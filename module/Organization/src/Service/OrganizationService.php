<?php

namespace Organization\Service;

use RuntimeException;
use Organization\Model\Organization;
use Organization\Model\OrganizationTable;

class OrganizationService
{
    private $organizationTable;

    public function __construct(OrganizationTable $organizationTable)
    {
        $this->organizationTable = $organizationTable;
    }

    public function getOrganizations()
    {
        return $this->organizationTable->getOrganizations();
    }

    public function getOrganizationList()
    {
        return array_column($this->getOrganizations()->toArray(), 'alias', 'organization_id');
    }

    public function getInternals()
    {
        return $this->organizationTable->getInternals();
    }

    public function getInternalList()
    {
        return array_column($this->getInternals()->toArray(), 'alias', 'organization_id');
    }

    public function getInternalListByEmployerNumber()
    {
        return array_column($this->getInternals()->toArray(), 'employer_number', 'organization_id');
    }

    public function getExternals()
    {
        return $this->organizationTable->getExternals();
    }

    public function getExternalList()
    {
        return array_column($this->getExternals()->toArray(), 'alias', 'organization_id');
    }

    public function getOrganizationById($organization_id)
    {
        return $this->organizationTable->getOrganizationById($organization_id);
    }

    public function getInternalById($organization_id)
    {
        return $this->organizationTable->getInternalById($organization_id);
    }

    public function getExternalById($organization_id)
    {
        return $this->organizationTable->getExternalById($organization_id);
    }

    public function addInternal(Organization $organization)
    {
        return $this->organizationTable->saveInternal($organization);
    }

    public function addExternal(Organization $organization)
    {
        return $this->organizationTable->saveExternal($organization);
    }

    public function updateInternal(Organization $organization)
    {
        return $this->organizationTable->saveInternal($organization);
    }

    public function updateExternal(Organization $organization)
    {
        return $this->organizationTable->saveExternal($organization);
    }

    /*
    public function getInternalByEmployerNumber($employer_number)
    {
    return $this->organizationTable->getInternalByEmployerNumber($employer_number);
}
*/
}
