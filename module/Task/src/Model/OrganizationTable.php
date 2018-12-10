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

    public function getOrganizations()
    {
        return $this->tableGateway->select();
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

    public function getOrganization($organization_id)
    {
        $organization_id = (int) $organization_id;
        $rowset = $this->tableGateway->select(['organization_id' => $organization_id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find organization with organization_id'));
        }

        return $row;
    }

    public function getOrganizationWithCondition($where = [])
    {
        $rowset = $this->tableGateway->select($where);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find organization with condition'));
        }

        return $row;
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

        if (! $this->getOrganization($organization_id)) {
            throw new RuntimeException(sprintf('Cannot update organization with organization_id %d; does not exist', $organization_id));
        }

        $this->tableGateway->update($data, ['organization_id' => $organization_id]);
    }
}
