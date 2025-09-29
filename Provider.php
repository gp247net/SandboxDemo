<?php
/**
 * Provides everything needed for the Extension
 */

 $config = file_get_contents(__DIR__.'/gp247.json');
 $config = json_decode($config, true);
 $extensionPath = $config['configGroup'].'/'.$config['configKey'];
 
 $this->loadTranslationsFrom(__DIR__.'/Lang', $extensionPath);
 
 if (gp247_extension_check_active($config['configGroup'], $config['configKey'])) {
     
     $this->loadViewsFrom(__DIR__.'/Views', $extensionPath);
     
     if (file_exists(__DIR__.'/config.php')) {
         $this->mergeConfigFrom(__DIR__.'/config.php', $extensionPath);
     }
 
     if (file_exists(__DIR__.'/function.php')) {
         require_once __DIR__.'/function.php';
     }


     app('router')->aliasMiddleware('sandbox-demo', \App\GP247\Plugins\SandboxDemo\Middleware\SandBoxMiddleware::class);

     // Ensure runtime Router groups receive middleware even if groups were already registered
     app('router')->pushMiddlewareToGroup('admin', 'sandbox-demo');
     app('router')->pushMiddlewareToGroup('api.extend', 'sandbox-demo');
     app('router')->pushMiddlewareToGroup('partner', 'sandbox-demo');
     app('router')->pushMiddlewareToGroup('pmo', 'sandbox-demo');
     // For front, group may be registered later by FrontServiceProvider; we keep config above

 }