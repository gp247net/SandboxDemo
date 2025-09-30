<?php

namespace App\GP247\Plugins\SandboxDemo\Middleware;

use GP247\Core\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SandBoxMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param array                    $args
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next, ...$args)
    {
        if ($this->conditionMiddleware() && config('Plugins/SandboxDemo.SANDBOX_DEMO_ENABLED')
            && !collect($this->routeAlwaysAllow())->contains($request->route()->getName())
            && !collect($this->pathAlwaysAllow())->contains($request->path())
        ) {
            if ($request->method() == 'GET'
                && !collect($this->pathAlwaysBlock())->contains($request->path())
                && !collect($this->routeAlwaysBlock())->contains($request->route()->getName())
            ) {
                return $next($request);
            } else {
                if (request()->ajax()) {
                    $uriCurrent = request()->fullUrl();
                    $methodCurrent = request()->method();
                    return response()->json([
                        'error' => '1',
                        'msg' => 'Access denied for sandbox demo',
                        'detail' => [
                            'method' => $methodCurrent,
                            'url' => $uriCurrent
                            ]
                    ]);
                }
                abort(403, 'Access denied for sandbox demo');
            }
        }
        return $next($request);
    }


    private function routeAlwaysBlock()
    {
        return [
            // Array item in here
        ];
    }

    private function routeAlwaysAllow()
    {
        return [
            // Array item in here
        ];
    }

    /**
     * Path always block
     *
     * @return  [type]  [return description]
     */
    private function pathAlwaysBlock()
    {
        $paths = [];
        //MULTIVENDOR_ADMIN_PATH

        if (defined('GP247_ADMIN_PREFIX')) {
            $paths[] = GP247_ADMIN_PREFIX . '/uploads/delete';
            $paths[] = GP247_ADMIN_PREFIX . '/uploads/newfolder';
            $paths[] = GP247_ADMIN_PREFIX . '/uploads/domove';
            $paths[] = GP247_ADMIN_PREFIX . '/uploads/rename';
            $paths[] = GP247_ADMIN_PREFIX . '/uploads/resize';
            $paths[] = GP247_ADMIN_PREFIX . '/uploads/doresize';
            $paths[] = GP247_ADMIN_PREFIX . '/uploads/cropimage';
            $paths[] = GP247_ADMIN_PREFIX . '/uploads/crop';
            $paths[] = GP247_ADMIN_PREFIX . '/uploads/move';
        }
        if (config('Plugins/MultiVendorPro.route.MULTIVENDOR_ADMIN_PATH')) {
            $paths[] = config('Plugins/MultiVendorPro.route.MULTIVENDOR_ADMIN_PATH') . '/uploads/delete';
            $paths[] = config('Plugins/MultiVendorPro.route.MULTIVENDOR_ADMIN_PATH') . '/uploads/newfolder';
            $paths[] = config('Plugins/MultiVendorPro.route.MULTIVENDOR_ADMIN_PATH') . '/uploads/domove';
            $paths[] = config('Plugins/MultiVendorPro.route.MULTIVENDOR_ADMIN_PATH') . '/uploads/rename';
            $paths[] = config('Plugins/MultiVendorPro.route.MULTIVENDOR_ADMIN_PATH') . '/uploads/resize';
            $paths[] = config('Plugins/MultiVendorPro.route.MULTIVENDOR_ADMIN_PATH') . '/uploads/doresize';
            $paths[] = config('Plugins/MultiVendorPro.route.MULTIVENDOR_ADMIN_PATH') . '/uploads/cropimage';
            $paths[] = config('Plugins/MultiVendorPro.route.MULTIVENDOR_ADMIN_PATH') . '/uploads/crop';
            $paths[] = config('Plugins/MultiVendorPro.route.MULTIVENDOR_ADMIN_PATH') . '/uploads/move';
        }

        
        if (config('Plugins/PmoPartner.route.PARTNER_ADMIN_PATH')) {
            $paths[] = config('Plugins/PmoPartner.route.PARTNER_ADMIN_PATH') . '/uploads/delete';
            $paths[] = config('Plugins/PmoPartner.route.PARTNER_ADMIN_PATH') . '/uploads/newfolder';
            $paths[] = config('Plugins/PmoPartner.route.PARTNER_ADMIN_PATH') . '/uploads/domove';
            $paths[] = config('Plugins/PmoPartner.route.PARTNER_ADMIN_PATH') . '/uploads/rename';
            $paths[] = config('Plugins/PmoPartner.route.PARTNER_ADMIN_PATH') . '/uploads/resize';
            $paths[] = config('Plugins/PmoPartner.route.PARTNER_ADMIN_PATH') . '/uploads/doresize';
            $paths[] = config('Plugins/PmoPartner.route.PARTNER_ADMIN_PATH') . '/uploads/cropimage';
            $paths[] = config('Plugins/PmoPartner.route.PARTNER_ADMIN_PATH') . '/uploads/crop';
            $paths[] = config('Plugins/PmoPartner.route.PARTNER_ADMIN_PATH') . '/uploads/move';
        }
        return $paths;
    }

    private function pathAlwaysAllow()
    {
        return [
            // Array item in here
        ];
    }


    private function conditionMiddleware()
    {
        return 
        // Core admin login
        (function_exists('admin') && admin()->user())
        // Partner login
        || (function_exists('partner') && partner()->user())
        // Pmo login
        || (function_exists('pmo') && pmo()->user())
        // Vendor login
        || (function_exists('vendor') && vendor()->user());
    }
}
