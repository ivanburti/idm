<?php

namespace Organization\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class OrganizationTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getOrganizationById($organization_id)
    {
        $organization_id = (int) $organization_id;
        $rowset = $this->tableGateway->select(['organization_id' => $organization_id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find organization with organization_id'));
        }

        return $row;
    }

    public function getInternalById($organization_id)
    {
        $organization_id = (int) $organization_id;
        $rowset = $this->tableGateway->select(['organization_id' => $organization_id, 'type' => 1]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find organization with organization_id'));
        }

        return $row;
    }

    public function getExternalById($organization_id)
    {
        $organization_id = (int) $organization_id;
        $rowset = $this->tableGateway->select(['organization_id' => $organization_id, 'type' => 2]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find organization with organization_id'));
        }

        return $row;
    }

    public function getOrganizationByEmployerNumber($employer_number)
    {
        $rowset = $this->tableGateway->select(['employer_number' => $employer_number]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find organization with employer_number'));
        }

        return $row;
    }

    public function getInternalByEmployerNumber($employer_number)
    {
        $rowset = $this->tableGateway->select(['employer_number' => $employer_number, 'type' => 1]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find organization with employer_number'));
        }

        return $row;
    }

    public function getExternalByEmployerNumber($employer_number)
    {
        $rowset = $this->tableGateway->select(['employer_number' => $employer_number, 'type' => 2]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find organization with employer_number'));
        }

        return $row;
    }

    public function getOrganizations()
    {
        return $this->tableGateway->select();
    }

    public function getInternals()
    {
        return $this->tableGateway->select(['type' => 1]);
    }

    public function getExternals()
    {
        return $this->tableGateway->select(['type' => 2]);
    }

    public function saveOrganization(Organization $organization)
    {
        $data = [
            'alias' => $organization->alias,
            'name'  => $organization->name,
            'type' => $organization->type,
            'employer_number'  => $organization->employer_number,
            'created_on' => $organization->created_on,
            'expires_on'  => $organization->expires_on,
            'status' => $organization->status,
            'owners' => json_encode($organization->owners),
        ];

        $organization_id = (int) $organization->organization_id;

        if ($organization_id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getOrganizationById($organization_id)) {
            throw new RuntimeException(sprintf('Cannot update organization with organization_id %d; does not exist', $organization_id));
        }

        $this->tableGateway->update($data, ['organization_id' => $organization_id]);
    }

    public function searchOrganizations($data)
    {
        $select = $this->tableGateway->getSql()->select();

        ($data['alias']) ? $select->where->like('alias', '%'.$data['alias'].'%') : null;
        ($data['name']) ? $select->where->like('alias', '%'.$data['alias'].'%') : null;
        ($data['type']) ? $select->where(['type' => $data['type']]) : null;
        ($data['status']) ? $select->where(['status' => $data['status']]) : null;

        return $this->tableGateway->selectWith($select);
    }

}
