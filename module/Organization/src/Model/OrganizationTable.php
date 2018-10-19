<?php

namespace Organization\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Expression;

class OrganizationTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    private function getSelect()
    {
        $select = $this->tableGateway->getSql()->select();

        return $select;
    }

    public function getOrganizations()
    {
        $select = $this->getSelect();

        $select->order('is_external ASC');

        return $this->tableGateway->selectWith($select);
    }

    public function getInternals()
    {
        $select = $this->getSelect();

        $select->where->isNull('is_external');

        return $this->tableGateway->selectWith($select);
    }

    public function getExternals()
    {
        $select = $this->getSelect();

        $select->where->isNotNull('is_external');

        return $this->tableGateway->selectWith($select);
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

        $select = $this->getSelect();
        $select->where->isNull('is_external');
        $select->where(['organization_id' => $organization_id]);

        $rowset = $this->tableGateway->selectWith($select);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find organization with organization_id'));
        }

        return $row;
    }

    public function getExternalById($organization_id)
    {
        $organization_id = (int) $organization_id;

        $select = $this->getSelect();
        $select->where->isNotNull('is_external');
        $select->where(['organization_id' => $organization_id]);

        $rowset = $this->tableGateway->selectWith($select);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find organization with organization_id'));
        }

        return $row;
    }

    public function saveInternal(Organization $organization)
    {
        return $this->saveOrganization($organization);
    }

    public function saveExternal(Organization $organization)
    {
        $organization->setExternal();
        return $this->saveOrganization($organization);
    }

    private function saveOrganization(Organization $organization)
    {
        $data = [
            'alias' => $organization->alias,
            'name'  => $organization->name,
            'employer_number' => $organization->employer_number,
            'expires_on'  => $organization->expires_on,
            'is_external' => $organization->is_external,
            'is_enabled'  => $organization->is_enabled,
            'owners' => !empty($organization->owners) ? json_encode($organization->owners) : null,
        ];

        $organization_id = (int) $organization->organization_id;

        if ($organization_id === 0) {
            $data['created_on'] = new Expression("NOW()");
            $this->tableGateway->insert($data);
            return $this->tableGateway->getLastInsertValue();
        }

        if (! $this->getOrganizationById($organization_id)) {
            throw new RuntimeException(sprintf('Cannot update organization with identifier %d; does not exist', $organization_id));
        }

        $data['updated_on'] = new Expression("NOW()");

        $this->tableGateway->update($data, ['organization_id' => $organization_id]);
    }

}
