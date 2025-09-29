<?php
use Illuminate\Support\Facades\Route;

$config = file_get_contents(__DIR__.'/gp247.json');
$config = json_decode($config, true);

if(gp247_extension_check_active($config['configGroup'], $config['configKey'])) {


    

    Route::group(
        [
            'prefix' => GP247_ADMIN_PREFIX.'/sandboxdemo',
            'middleware' => GP247_ADMIN_MIDDLEWARE,
            'namespace' => '\App\GP247\Plugins\SandboxDemo\Admin',
        ], 
        function () {
            Route::get('/', 'AdminController@index')
            ->name('admin_sandboxdemo.index');
        }
    );
}