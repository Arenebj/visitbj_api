<?php
namespace App\Interfaces;
interface AuthRepositoryInterface
{
    public function registerUser($userUid, $lastName, $firstName, $email, $phoneNumber, $password);
    public function authenticateUser($login, $password);
}
