<?php

use App\Exceptions\ApiException;

if (!function_exists('prettyPrint')) {

    /**
     * 漂亮的数据打印
     * @param array $data
     * @return string
     */
    function prettyPrint(array $data = [])
    {

        return highlight_string("\n<?php\n" . var_export($data, true) . ";\n?>\n", true);

    }

}

if (!function_exists('curl')) {

    /**
     * curl请求
     * @param string $url 请求地址
     * @param array $params 请求参数
     * @param string $method 请求方式
     * @return array
     */
    function curl(string $url = '', array $params = [], string $method = 'post')
    {

        if(!in_array($method, ['get', 'post'])){

            return ['status' => 0, 'message' => '错误的请求方式'];

        }

        $ch = curl_init();

        //请求地址
        curl_setopt($ch, CURLOPT_URL, $url);

        //http协议版本 1.1
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        //连接超时时间
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);

        //执行超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        //返回获取的输出的文本流
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //设置这个选项为一个非零值(象 'Location: ')的头，服务器会把它当做HTTP头的一部分发送
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        if ($method === 'post') {

            //设置 post请求
            curl_setopt($ch, CURLOPT_POST, true);

            //数据
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        } elseif ($method === 'get'){

            curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));

        }

        $response = curl_exec($ch);

        if ($response === FALSE) {

            return ['status' => 0, 'message' => curl_error($ch)];

        }

        if(curl_getinfo( $ch , CURLINFO_HTTP_CODE ) === 200){

            curl_close($ch);

            return ['status' => 1, 'message' => '请求成功', 'data' => json_decode($response, true)];

        }

        curl_close($ch);

        return ['status' => 0, 'message' => '请求失败'];

    }

}

if (!function_exists('slogs')) {

    /**
     * 日志打印
     * @param array $content
     */
    function slogs(array $content = []){

        $path = request()->getPathInfo() ?: '/api/jobs';

        $filename = $path . '/' . date('Ymd') . '/' . date('H'). '.log';

        $time = date('Y-m-d H:i:s');

        $url = request()->getUri();

        $method = request()->method();

        Storage::append($filename, "[{$time}] [{$url}] [{$method}]\r\n".var_export(['parameters' => request()->post(), 'server_ip' => request()->ip(), 'client_ip' => request()->getClientIp(), 'user_agent' => request()->userAgent(), 'response' => $content], 1)."\r\n");

    }

}

if (!function_exists('json')) {

    /**
     * 数据返回
     * @param int $code
     * @param string $message
     * @param array $data
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    function json(int $code = 0, string $message = '成功', $data = [])
    {

        $exception_message = '';

        //跟踪日志
        if (isset($data['exception_message'])) {

            $exception_message = $data['exception_message'];

            unset($data['exception_message']);

        }

        slogs(compact('code', 'message', 'data', 'exception_message'));

        return response(compact('code', 'message', 'data'));

    }

}


if (!function_exists('generateRandom')) {

    /**
     * 随机数
     * @param  string $prefix
     * @return string
     */
    function generateRandom(string $prefix = "PN")
    {

        return $prefix . (strtotime(date('YmdHis', time()))) . substr(microtime(), 2, 6) . sprintf('%03d', rand(0, 999));

    }

}
