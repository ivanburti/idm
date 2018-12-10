<?php

namespace Auth\Service;

use Zend\Authentication\AuthenticationService;
use Zend\Crypt\Password\Bcrypt;
use Zend\Math\Rand;
use Auth\Model\User;
use Auth\Model\UserTable;

class UserManager
{
	private $userTable;
	private $authService;

	public function __construct(UserTable $userTable, AuthenticationService $authService)
	{
		$this->userTable = $userTable;
		$this->authService = $authService;
	}

	public function identifyUser()
	{
		$email = $this->authService->getIdentity();
		return $this->userTable->getUserByEmail($email);
	}

    public function addUser($data)
    {
        if($this->checkUserExists($data['email'])) {
            throw new \Exception("User with email address " . $data['$email'] . " already exists");
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setFullName($data['full_name']);
        $user->setPassword(md5($data['password']));
        $user->setStatus($data['status']);
        $user->setDateCreated(date('Y-m-d H:i:s'));

		$this->userTable->saveUser($user);

        return $user;
    }

    public function updateUser($user, $data)
    {
		exit();
        // Do not allow to change user email if another user with such email already exits.
        if($user->getEmail()!=$data['email'] && $this->checkUserExists($data['email'])) {
            throw new \Exception("Another user with email address " . $data['email'] . " already exists");
        }

        $user->setEmail($data['email']);
        $user->setFullName($data['full_name']);
        $user->setStatus($data['status']);

        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }

    public function createAdminUserIfNotExists()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy([]);
        if ($user==null) {
            $user = new User();
            $user->setEmail('webadmin@celectra.com.br');
            $user->setFullName('Administrador');
            $bcrypt = new Bcrypt();
            $passwordHash = $bcrypt->create('Celectr@');
            $user->setPassword($passwordHash);
            $user->setStatus(User::STATUS_ACTIVE);
            $user->setDateCreated(date('Y-m-d H:i:s'));

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
    }

    public function checkUserExists($email) {
        $user = $this->userTable->checkIfEmailExists($email);

		return ($user->count() < 1) ? null : true;
    }


    public function generatePasswordResetToken($user)
    {
        // Generate a token.
        $token = Rand::getString(32, '0123456789abcdefghijklmnopqrstuvwxyz', true);
        $user->setPasswordResetToken($token);

        $currentDate = date('Y-m-d H:i:s');
        $user->setPasswordResetTokenCreationDate($currentDate);

        $this->entityManager->flush();

        $subject = 'Password Reset';

        $httpHost = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'localhost';
        $passwordResetUrl = 'http://' . $httpHost . '/set-password?token=' . $token;

        $body = 'Please follow the link below to reset your password:\n';
        $body .= "$passwordResetUrl\n";
        $body .= "If you haven't asked to reset your password, please ignore this message.\n";

        // Send email to user.
        mail($user->getEmail(), $subject, $body);
    }

    /**
     * Checks whether the given password reset token is a valid one.
     */
    public function validatePasswordResetToken($passwordResetToken)
    {
        $user = $this->entityManager->getRepository(User::class)
                ->findOneByPasswordResetToken($passwordResetToken);

        if($user==null) {
            return false;
        }

        $tokenCreationDate = $user->getPasswordResetTokenCreationDate();
        $tokenCreationDate = strtotime($tokenCreationDate);

        $currentDate = strtotime('now');

        if ($currentDate - $tokenCreationDate > 24*60*60) {
            return false; // expired
        }

        return true;
    }

    /**
     * This method sets new password by password reset token.
     */
    public function setNewPasswordByToken($passwordResetToken, $newPassword)
    {
        if (!$this->validatePasswordResetToken($passwordResetToken)) {
           return false;
        }

        $user = $this->entityManager->getRepository(User::class)
                ->findOneByPasswordResetToken($passwordResetToken);

        if ($user==null) {
            return false;
        }

        // Set new password for user
        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($newPassword);
        $user->setPassword($passwordHash);

        // Remove password reset token
        $user->setPasswordResetToken(null);
        $user->setPasswordResetTokenCreationDate(null);

        $this->entityManager->flush();

        return true;
    }

	public function validatePassword($user, $password)
	{
		$bcrypt = new Bcrypt();
		$passwordHash = $user->getPassword();

		if ($bcrypt->verify($password, $passwordHash)) {
			return true;
		}

		return false;
	}

    public function changePassword($data)
    {
		$user = $this->identifyUser();

    	$oldPassword = md5($data['old_password']);
		$newPassword = md5($data['new_password']);

		if($user->getPassword() != $oldPassword) {
			throw new \Exception("Senha informada não corresponde com a cadastrada", 1);
		}

		$user->setPassword($newPassword);

		$this->userTable->saveUser($user);
    }
}
