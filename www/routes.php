<?php

use Zofe\Burp\Burp;
use App\Factory;

Factory::AuthController()->checkAuthorization();

Burp::get('^/$', null, function () {
    Factory::AuthController()->redirect('/tasks/');
});

Burp::get('^/login/$', null, function () {
    Factory::AuthController()->loginPage();
});

Burp::post('^/login', null, function () {
    Factory::AuthController()->doLogin();
});

Burp::get('^/logout', null, function () {
    Factory::AuthController()->doLogout();
});

Burp::get('^/tasks/$', null, function () {
    Factory::TaskController()->tasksPage();
});

Burp::delete('^/tasks/(\d+)/', null, function ($id) {
    Factory::TaskController()->deleteTaskByID($id);
});

Burp::get('^/tasks/create/$', null, function () {
    Factory::TaskController()->createTaskPage();
});

Burp::post('^/tasks', null, function () {
    Factory::TaskController()->addTask($_POST);
});

Burp::get('^/tasks/(\d+)/edit/', null, function ($id) {
    Factory::TaskController()->editTaskPage($id);
});

Burp::put('^/tasks/(\d+)', null, function ($id) {
    Factory::TaskController()->updateTask($id, $_POST);
});

Burp::missing(function () {
    Factory::AuthController()->errorPage();
});

Burp::dispatch();