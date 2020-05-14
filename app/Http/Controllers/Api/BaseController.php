<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class BaseController extends Controller
{

    /**
     * 生成唯一随机数
     * @param string $prefix
     * @return string
     */
    public function generateRandom(string $prefix = "PN")
    {

        return $prefix . (strtotime(date('YmdHis', time()))) . substr(microtime(), 2, 6) . sprintf('%03d', rand(0, 999));

    }

}
