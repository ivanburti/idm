<?php

namespace User\Model;

use RuntimeException;
use Zend\Db\Sql\Expression;
use Zend\Db\TableGateway\TableGatewayInterface;

class PopulatorTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getPopulators($onlyEnabled = true)
    {
        return $this->tableGateway->select();
    }

    public function getPopulatorById($populator_id)
    {
        $populator_id = (int) $populator_id;

        $rowset = $this->tableGateway->select(['populator_id' => $populator_id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find populator with identifier %d', $populator_id));
        }
        return $row;
    }

    public function savePopulator(Populator $populator)
    {
        $data = [
            'description' => $populator->description,
            'config'  => $populator->config,
            'field_map'  => $populator->field_map,
            'date_format'  => $populator->date_format,
            'date_format_null'  => $populator->date_format_null,
            'encoding'  => $populator->encoding,
        ];

        $populator_id = (int) $populator->populator_id;

        if ($populator_id === 0) {
            $this->tableGateway->insert($data);
            return $this->tableGateway->getLastInsertValue();
        }

        if (! $this->getPopulatorById($populator_id)) {
            throw new RuntimeException(sprintf('Cannot update populator with identifier %d; does not exist', $populator_id));
        }

        $data['last_update'] = new Expression("NOW()");
        $this->tableGateway->update($data, ['populator_id' => $populator_id]);
    }
}
