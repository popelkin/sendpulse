<?php

namespace App\Controllers;

use App\Factory;

class MainController {

    /**
     * @param $url
     */
    public function redirect($url)
    {
        header("Location: $url");
        exit();
    }

    /**
     * @param $template
     * @param array $data
     */
    public function display($template, $data = [])
    {
        echo Factory::BladeVendor()->view()->make($template, $data)->render();
    }
    
}