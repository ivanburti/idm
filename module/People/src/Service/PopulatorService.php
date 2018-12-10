<?php

namespace People\Service;

use RuntimeException;
use User\Model\Populator;
use User\Model\PopulatorTable;

class PopulatorService
{
    private $populator;
    private $populatorTable;

    public function __construct($config, PopulatorTable $populatorTable)
    {
        $this->populatorTable = $populatorTable;
    }

    public function getPopulators()
    {
        return $this->populatorTable->getPopulators();
    }

    public function getPullPopulators()
    {
        return $this->populatorTable->getPullPopulators();
    }

    public function getPushPopulators()
    {
        return $this->populatorTable->getPushPopulators();
    }

    public function getPopulatorById($populator_id)
    {
        return $this->populatorTable->getPopulatorById($populator_id);
    }

    public function getPullPopulatorById($populator_id)
    {
        return $this->getPopulatorById($populator_id);
    }

    public function getPushPopulatorById($populator_id)
    {
        return $this->getPopulatorById($populator_id);
    }

    public function addPopulator(Populator $populator)
    {
        return $this->populatorTable->savePopulator($populator);
    }

    public function editPopulator(Populator $populator)
    {
        return $this->populatorTable->savePopulator($populator);
    }

    public function pullPopulator($populator_id)
    {
        $populator_id = (int) $populator_id;
        $this->populator = $this->getPullPopulatorById($populator_id);

        $model = new \User\Model\FileCSV();
        $model->exchangeArray($this->populator->getConfigDecoded());

        $data = $model->pull();
        array_walk($data, [$this, 'map_fields']);

        return $data;
    }

    private function map_fields(&$value, $key)
    {
        $field_map = $this->populator->getFieldMapDecoded();
        $old_value = $value;
        $value = [];
        foreach ($field_map as $field_name => $field_position)
        {
            $value[$field_name] = $old_value[$field_position];
        }

        array_walk($value, [$this, 'map_fields2']);
    }

    private function map_fields2(&$value, $key)
    {
        $value = $this->convertEncoding($value);

        $dates = ['birthday_date', 'hiring_date', 'resignation_date'];
        if (in_array($key, $dates)) {
            $value = $this->convertDate($value);
        }
    }

    private function convertEncoding($value)
    {
        if ($this->populator->getEncoding() != 'UTF-8') {
            return mb_convert_encoding($value, "UTF-8", $this->populator->getEncoding());
        }
        return $value;
    }

    private function convertDate($date)
    {
        if ($date == $this->populator->getDateFormatNull()) {
            return null;
        }

        $datetime = \DateTime::createFromFormat($this->populator->getDateFormat(), $date);
        return date_format($datetime, 'Y-m-d');
    }
}
