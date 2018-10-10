<?php

namespace User\Form;

use Zend\Form\Form;

class UserForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('user-form');

        $this->add([
            'type'  => 'text',
            'name' => 'email',
            'options' => [
                'label' => 'E-mail',
            ],
            'attributes' => [
                'placeholder' => 'Ex: nome@exemplo.com.br',
            ],
        ]);

        $this->add([
            'type'  => 'text',
            'name' => 'full_name',
            'options' => [
                'label' => 'Nome Completo',
            ],
            'attributes' => [
                'placeholder' => 'Ex: João da Silva',
            ],
        ]);

        $this->add([
            'type'  => 'password',
            'name' => 'password',
            'options' => [
                'label' => 'Senha',
            ],
        ]);

        $this->add([
            'type'  => 'password',
            'name' => 'confirm_password',
            'options' => [
                'label' => 'Confirme a senha',
            ],
        ]);

        $this->add([
            'type'  => 'select',
            'name' => 'status',
            'options' => [
                'label' => 'Status',
                'value_options' => [
                    1 => 'Ativo',
                    2 => 'Inativo',
                ]
            ],
        ]);

        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Salvar'
            ],
        ]);
    }
}
