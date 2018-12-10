<?php

namespace Auth\Model;

use DomainException;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Filter;
use Zend\Validator;

class User implements InputFilterAwareInterface
{
    const STATUS_ACTIVE = 1;
    const STATUS_RETIRED = 2;

    public $id;
    public $email;
    public $full_name;
    public $password;
    public $status;
    public $date_created;
    public $passwordResetToken;
    public $passwordResetTokenCreationDate;

    private $inputFilter;

    public function exchangeArray($data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
        $this->full_name = !empty($data['full_name']) ? $data['full_name'] : null;
        $this->password = !empty($data['password']) ? $data['password'] : null;
        $this->status = !empty($data['status']) ? $data['status'] : null;
        $this->date_created = !empty($data['date_created']) ? $data['date_created'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name'     => 'email',
            'required' => true,
            'filters'  => [
                ['name' => Filter\StringTrim::class],
            ],
            'validators' => [
                [
                    'name'    => Validator\StringLength::class,
                    'options' => [
                        'min' => 1,
                        'max' => 128
                    ],
                ],
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'allow' => Validator\Hostname::ALLOW_DNS,
                        'useMxCheck'    => false,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'full_name',
            'required' => true,
            'filters'  => [
                ['name' => Filter\StringTrim::class],
            ],
            'validators' => [
                [
                    'name'    => Validator\StringLength::class,
                    'options' => [
                        'min' => 1,
                        'max' => 512
                    ],
                ],
            ],
        ]);


        $inputFilter->add([
            'name'     => 'password',
            'required' => true,
            'filters'  => [],
            'validators' => [
                [
                    'name'    => Validator\StringLength::class,
                    'options' => [
                        'min' => 6,
                        'max' => 64
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'confirm_password',
            'required' => true,
            'filters'  => [],
            'validators' => [
                [
                    'name'    => Validator\Identical::class,
                    'options' => [
                        'token' => 'password',
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'status',
            'required' => true,
            'filters'  => [
                ['name' => Filter\ToInt::class],
            ],
            'validators' => [
                [
                    'name' => Validator\InArray::class,
                    'options' => [
                        'haystack' => [1, 2]
                    ]
                ]
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }

    public function getInputFilterChangePasswd()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name'     => 'old_password',
            'required' => true,
            'filters'  => [],
            'validators' => [
                [
                    'name'    => Validator\StringLength::class,
                    'options' => [
                        'min' => 6,
                        'max' => 64
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'new_password',
            'required' => true,
            'filters'  => [],
            'validators' => [
                [
                    'name'    => Validator\StringLength::class,
                    'options' => [
                        'min' => 6,
                        'max' => 64
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'confirm_new_password',
            'required' => true,
            'filters'  => [
            ],
            'validators' => [
                [
                    'name'    => Validator\Identical::class,
                    'options' => [
                        'token' => 'new_password',
                    ],
                ],
            ],
        ]);


        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getFullName()
    {
        return $this->full_name;
    }

    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Ativo',
            self::STATUS_RETIRED => 'Inativo',
        ];
    }

    public function getStatusAsString()
    {
        $list = self::getStatusList();
        if (isset($list[$this->status]))
        return $list[$this->status];

        return 'Unknown';
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getDateCreated()
    {
        return $this->date_created;
    }

    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;
    }

    public function getResetPasswordToken()
    {
        return $this->passwordResetToken;
    }

    public function setPasswordResetToken($token)
    {
        $this->passwordResetToken = $token;
    }

    public function getPasswordResetTokenCreationDate()
    {
        return $this->passwordResetTokenCreationDate;
    }

    public function setPasswordResetTokenCreationDate($date)
    {
        $this->passwordResetTokenCreationDate = $date;
    }
}
