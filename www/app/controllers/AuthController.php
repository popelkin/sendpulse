<?php

namespace App\Controllers;

use App\Factory;

class AuthController extends MainController
{

    /**
     * 
     */
    public function checkAuthorization()
    {
        if (!Factory::AuthVendor()->isLoggedIn()
            && strpos($_SERVER['REQUEST_URI'], '/login/') === false
        ) {
            Factory::AuthController()->redirect('/login/');
        }
    }

    /**
     * 
     */
    public function loginPage()
    {
        if (!Factory::AuthVendor()->isLoggedIn()) {
            $this->display('login');
        } else {
            Factory::AuthController()->redirect('/tasks/');
        }
    }

    /**
     * 
     */
    public function doLogin()
    {
        $result = Factory::AuthService()->authorizeUser($_POST);
        if ($result === true) {
            Factory::AuthController()->redirect('/tasks/');
        }
        $this->display('login', ['errors' => $result]);
    }

    /**
     * 
     */
    public function doLogout()
    {
        try {
            Factory::AuthVendor()->logOut();
        } catch (\Exception $e) {
            
        }
        Factory::AuthController()->redirect('/login/');
    }

    /**
     * 
     */
    public function errorPage()
    {
        header("HTTP/1.0 404 Not Found");
        $this->display('404');
        die();
    }
    
}