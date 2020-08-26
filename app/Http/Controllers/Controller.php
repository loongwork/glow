<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * 响应成功信息
     *
     * @param array|object|null $data 数据
     * @return JsonResponse
     */
    public function success($data = null)
    {
        return response()->json([
            'code' => 'OK',
            'message' => 'success',
            'data' => $data,
        ]);
    }

    /**
     * 响应失败/错误信息
     *
     * @param string $code 错误码
     * @param string $message 错误信息
     * @param array|object|null $data 数据
     * @return JsonResponse
     */
    public function failed($code, $message, $data = null)
    {
        $r = [
            'code' => $code,
            'message' => $message,
        ];
        if (!is_null($data)) {
            $r['data'] = $data;
        }
        return response()->json($r);
    }
}
