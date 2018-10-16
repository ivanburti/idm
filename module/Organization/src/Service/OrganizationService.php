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

    public function getOrganizationByEmployerNumber($employer_number)
    {
        return $this->organizationTable->getOrganizationByEmployerNumber($employer_number);
    }

    public function getInternalByEmployerNumber($employer_number)
    {
        return $this->organizationTable->getInternalByEmployerNumber($employer_number);
    }

    public function getExternalByEmployerNumber($employer_number)
    {
        return $this->organizationTable->getExternalByEmployerNumber($employer_number);
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

    public function getExternals()
    {
        return $this->organizationTable->getExternals();
    }

    public function getExternalList()
    {
        return array_column($this->getExternals()->toArray(), 'alias', 'organization_id');
    }
























    public function searchOrganizations($data)
    {
        return $this->organizationTable->searchOrganizations($data);
    }

    public function getOrganizationStatusList()
    {
        $organization = new Organization();
        return $organization->getStatusList();
    }

    //OK
    public function getOrganizationTypeList()
    {
        $organization = new Organization();
        return $organization->getTypesList();
    }

    //OK
    public function getOrganizationById($organization_id)
    {
        $organization_id = (int) $organization_id;
        return $this->organizationTable->getOrganization($organization_id);
    }

    //OK
    public function getInternalById($organization_id)
    {
        $organization = $this->getOrganizationById($organization_id);

        if (1 == 2) {
            throw new Exception("Organization exist but is not internal");
        }

        return $organization;
    }

    //OK
    public function getExternalById($organization_id)
    {
        $organization = $this->getOrganizationById($organization_id);

        if (1 == 2) {
            throw new Exception("Organization exist but is not external");
        }

        return $organization;
    }

    //OK
    public function updateExternal($organization_id, $data)
    {
        $organization_id = (int) $organization_id;
        $organization = $this->getExternalById($organization_id);

        $organization->setAlias($data['alias']);
        $organization->setExpiresOn($data['expires_on']);
        $organization->setOwners($data['owners']);

        $this->organizationTable->saveOrganization($organization);

        return true;
    }

}
