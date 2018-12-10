<?php

namespace User\Form;

use Zend\Form\Form;

class PasswordChangeForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('user-changepasswd-form');

        $this->add([
            'type'  => 'password',
            'name' => 'old_password',
            'options' => [
                'label' => 'Senha Atual',
            ],
        ]);

        $this->add([
            'type'  => 'password',
            'name' => 'new_password',
            'options' => [
                'label' => 'Nova Senha',
            ],
        ]);

        $this->add([
            'type'  => 'password',
            'name' => 'confirm_new_password',
            'options' => [
                'label' => 'Confirmação da Senha',
            ],
        ]);

        $this->add([
            'type' => 'csrf',
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                'timeout' => 600
                ]
            ],
        ]);

        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Change Password'
            ],
        ]);
    }
}
