<?php
namespace App\Interfaces;
interface AuthRepositoryInterface
{
    public function registerUser($userUid, $lastName, $firstName, $email, $phoneNumber, $password, $gender, $birthdate);
    public function authenticateUser($login, $password);
    public function send_reset_code($email);
    public function verify_reset_code($code, $email);
    public function reset_password($password, $email);
    public function verifyPin($verificationCode);
}
