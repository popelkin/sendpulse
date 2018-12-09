<?php

namespace App\Services;

use app\Factory;

class AuthService
{

    /**
     * @param $data
     * @return array|bool
     */
    public function authorizeUser($data)
    {
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $passwordConfirm = $data['password_confirm'] ?? '';
        $signup = $data['signup'] ?? '';
        $errors = [];

        try {
            if ($signup) {
                // trying to signup
                if ($password != $passwordConfirm) {
                    throw new \Delight\Auth\InvalidPasswordException();
                }
                Factory::AuthVendor()->register($email, $password);
            }
            Factory::AuthVendor()->login($email, $password);
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $errors['incorrect_email'] = 'Некорректный e-mail';
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $errors['password'] = 'Некорректный пароль или пароли не совпадают';
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            $errors['requests'] = 'Превышено кол-во попыток авторизации';
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $errors['email_exists'] = 'Пользователь с таким e-mail уже существует';
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        if (count($errors)) {
            return $errors;
        }

        return true;
    }

}