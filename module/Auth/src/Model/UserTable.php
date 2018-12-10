<?php

namespace Auth\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class UserTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getUser($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find row with identifier %d', $id));
        }

        return $row;
    }

    public function getUserByEmail($email)
    {
        $rowset = $this->tableGateway->select(['email' => $email]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find row with identifier %d', $email));
        }

        return $row;
    }

    public function checkIfEmailExists($email)
    {
        return $this->tableGateway->select(['email' => $email]);
    }

    public function saveUser(User $user)
    {
        $data = [
            'email' => $user->email,
            'full_name' => $user->full_name,
            'password' => $user->password,
            'status' => $user->status,
            'date_created' => $user->date_created,
            'pwd_reset_token' => $user->pwdResetToken,
            'pwd_reset_token_creation_date' => $user->passwordResetTokenCreationDate,
        ];

        $user_id = (int) $user->id;

        if ($user_id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getUser($user_id)) {
            throw new RuntimeException(sprintf('Cannot update user with identifier %d; does not exist', $user_id));
        }

        $this->tableGateway->update($data, ['id' => $user_id]);
    }
}
