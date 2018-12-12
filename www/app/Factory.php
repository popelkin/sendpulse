<?php

namespace App;

use Delight\Auth\Auth;
use Philo\Blade\Blade;
use App\Services\TaskService;
use App\Services\AuthService;
use App\Services\UserService;
use App\Controllers\TaskController;
use App\Controllers\AuthController;

class Factory
{
    private static $cache = [];

    /**
     * @return Blade
     */
    public static function BladeVendor()
    {
        return self::$cache[__METHOD__] ?? self::$cache[__METHOD__] = new Blade(__DIR__ . '/../views', __DIR__ . '/../cache');
    }

    /**
     * @return Auth
     */
    public static function AuthVendor()
    {
        return self::$cache[__METHOD__] ?? self::$cache[__METHOD__] = new Auth(new \Delight\Db\PdoDsn('mysql:dbname=' . $_ENV['DB_DATABASE'] . ';host=' . $_ENV['DB_HOST'] . ';charset=utf8mb4', $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']));
    }

    /**
     * @return TaskService
     */
    public static function TaskService()
    {
        return self::$cache[__METHOD__] ?? self::$cache[__METHOD__] = new TaskService();
    }

    /**
     * @return AuthService
     */
    public static function AuthService()
    {
        return self::$cache[__METHOD__] ?? self::$cache[__METHOD__] = new AuthService();
    }

    /**
     * @return UserService
     */
    public static function UserService()
    {
        return self::$cache[__METHOD__] ?? self::$cache[__METHOD__] = new UserService();
    }
    
    /**
     * @return AuthController
     */
    public static function AuthController()
    {
        return self::$cache[__METHOD__] ?? self::$cache[__METHOD__] = new AuthController();
    }

    /**
     * @return TaskController
     */
    public static function TaskController()
    {
        return self::$cache[__METHOD__] ?? self::$cache[__METHOD__] = new TaskController();
    }

}