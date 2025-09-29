<?php
#App\GP247\Plugins\SandboxDemo\Admin\AdminController.php

namespace App\GP247\Plugins\SandboxDemo\Admin;

use GP247\Core\Controllers\RootAdminController;
use App\GP247\Plugins\SandboxDemo\AppConfig;

class AdminController extends RootAdminController
{
    public $plugin;

    public function __construct()
    {
        parent::__construct();
        $this->plugin = new AppConfig;
    }
    public function index()
    {
        return view($this->plugin->appPath.'::Admin',
            [
                
            ]
        );
    }
}
