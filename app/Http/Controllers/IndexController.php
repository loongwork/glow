<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * 应用自检接口
     *
     * @return JsonResponse
     */
    public function status()
    {
        global $app;

        return $this->success([
            'framework' => $app->version(),
            'maintenance' => $app->isDownForMaintenance(),
            'database' => 'online',
        ]);
    }
}
