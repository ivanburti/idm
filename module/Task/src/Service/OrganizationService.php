<?php

namespace Organization\Service;

use Exception;
use Organization\Model\Organization;
use Organization\Model\OrganizationTable;

class OrganizationService
{
    private $organizationTable;

    public function __construct(OrganizationTable $organizationTable)
    {
        $this->organizationTable = $organizationTable;
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

















    /*
    public function getInternals()
    {
        return $this->getOrganizations->getOrganizations(['type' => 1]);
    }

    //OK
    public function getOrganizations()
    {
        return $this->organizationTable->getOrganizations();
    }

    public function getServiceProviders()
    {
        return $this->organizationTable->getOrganizations(['type' => 2]);
    }

    public function getInternalsList()
    {
        return array_column($this->getInternals()->toArray(), 'alias', 'organization_id');
    }

    public function getServiceProvidersList()
    {
        return array_column($this->getServiceProviders()->toArray(), 'alias', 'organization_id');
    }

    public function getInternalsListByEmployerNumber()
    {
        return array_column($this->getInternals()->toArray(), 'alias', 'employer_number');
    }

    public function getServiceProvidersListByEmployerNumber()
    {
        return array_column($this->getServiceProviders()->toArray(), 'alias', 'organization_id');
    }

    public function getServiceProvider($organization_id)
    {
        $organization = $this->getOrganization($organization_id);

        if (1 == 2) {
            throw new Exception("Organization exist but is not a service provider");
        }
        return $organization;
    }

    public function getInternalByEmployerNumber($employer_number)
    {
        $where = [
            'employer_number' => $employer_number
        ];

        if (1 == 2) {
            throw new Exception("Organization exist but is not internal");
        }
        return $this->organizationTable->getOrganizationWithCondition($where);
    }

    public function getServiceProviderByEmployerNumber($employer_number)
    {
        $where = [
            'employer_number' => $employer_number
        ];

        if (1 == 2) {
            throw new Exception("Organization exist but is not internal");
        }
        return $this->organizationTable->getOrganizationWithCondition($where);
    }
    */
}
