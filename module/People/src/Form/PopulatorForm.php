<?php

namespace People\Form;

use Zend\Form\Form;

class PopulatorForm extends Form
{
    public function __construct()
    {
        parent::__construct('populator_form');

        $this->add([
            'name' => 'populator_id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'description',
            'type' => 'text',
            'options' => [
                'label' => 'Description',
            ],
            'attributes' => [
                'id' => 'description',
            ],
        ]);

        $this->add([
            'name' => 'config',
            'type' => 'textarea',
            'options' => [
                'label' => 'Config',
            ],
            'attributes' => [
                'id' => 'config',
            ],
        ]);

        $this->add([
            'name' => 'field_map',
            'type' => 'textarea',
            'options' => [
                'label' => 'Field Map',
            ],
            'attributes' => [
                'id' => 'field_map',
            ],
        ]);

        $this->add([
            'name' => 'date_format',
            'type' => 'text',
            'options' => [
                'label' => 'Date Format',
            ],
            'attributes' => [
                'id' => 'date_format',
            ],
        ]);

        $this->add([
            'name' => 'date_format_null',
            'type' => 'text',
            'options' => [
                'label' => 'Date Format Null',
            ],
            'attributes' => [
                'id' => 'date_format_null',
            ],
        ]);

        $this->add([
            'name' => 'encoding',
            'type' => 'text',
            'options' => [
                'label' => 'Encoding',
            ],
            'attributes' => [
                'id' => 'encoding',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Save',
            ],
        ]);
    }
}
