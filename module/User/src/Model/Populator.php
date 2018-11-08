<?php

namespace User\Model;

use DomainException;
use Zend\Filter;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator;

class Populator implements InputFilterAwareInterface
{
    public $populator_id;
    public $description;
    public $config;
    public $field_map;
    public $date_format;
    public $date_format_null;
    public $encoding;
    public $last_pull;
    public $last_push;
    public $last_update;
    public $is_enabled;

    private $inputFilter;

    public function exchangeArray($data)
    {
        $this->populator_id = !empty($data['populator_id']) ? $data['populator_id'] : null;
        $this->description = !empty($data['description']) ? $data['description'] : null;
        $this->config = !empty($data['config']) ? $data['config'] : null;
        $this->field_map = !empty($data['field_map']) ? $data['field_map'] : null;
        $this->date_format = !empty($data['date_format']) ? $data['date_format'] : null;
        $this->date_format_null = !empty($data['date_format_null']) ? $data['date_format_null'] : null;
        $this->encoding = !empty($data['encoding']) ? $data['encoding'] : null;
        $this->last_pull = !empty($data['last_pull']) ? $data['last_pull'] : null;
        $this->last_push = !empty($data['last_push']) ? $data['last_push'] : null;
        $this->last_update = !empty($data['last_update']) ? $data['last_update'] : null;
        $this->is_enabled = !empty($data['is_enabled']) ? $data['is_enabled'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'populator_id' => $this->populator_id,
            'description' => $this->description,
            'config' => $this->config,
            'field_map' => $this->field_map,
            'date_format' => $this->date_format,
            'date_format_null' => $this->date_format_null,
            'encoding' => $this->encoding,
            'last_pull' => $this->last_pull,
            'last_push' => $this->last_push,
            'last_update' => $this->last_update,
            'is_enabled' => $this->is_enabled,
        ];
    }

    public function getPopulatorId()
    {
        return $this->populator_id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getConfigDecoded()
    {
        return json_decode($this->config, true);
    }

    public function getFieldMapDecoded()
    {
        return json_decode($this->field_map, true);
    }

    public function getDateFormat()
    {
        return $this->date_format;
    }

    public function getDateFormatNull()
    {
        return $this->date_format_null;
    }

    public function getEncoding()
    {
        return $this->encoding;
    }

    public function getLastPush()
    {
        return $this->last_push;
    }

    public function getLastUpdate()
    {
        return $this->last_update;
    }

    public function isEnabled()
    {
        return ($this->is_enabled) ? true : false;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf('%s does not allow injection of an alternate input filter', __CLASS__));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'populator_id',
            'required' => true,
            'filters' => [
                ['name' => Filter\ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'description',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'config',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'field_map',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'date_format',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'date_format_null',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'encoding',
            'required' => true,
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}
