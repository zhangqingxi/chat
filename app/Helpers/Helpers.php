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


if (!function_exists('getFirstCharter')) {

    /**
     * 提取字符首字母
     * @param $str
     * @return string
     */
    function getFirstCharter($str)
    {

        if (empty($str)) {

            return '';

        }

        //去除字符串第一个字符的ASCII值
        $firstChar = ord($str[0]);

        //如果ASCII处于A-Z|a-z 表示第一个字符是英文字母 则直接返回
        if ($firstChar >= ord('A') && $firstChar <= ord('Z') || $firstChar >= ord('a') && $firstChar <= ord('z')) {

            return strtoupper($str[0]);

        }

        try {

            $s1 = iconv('UTF-8', 'gb2312', $str);

            $s2 = iconv('gb2312', 'UTF-8', $s1);

        } catch (\Exception $e) {

            $s1 = iconv('UTF-8', 'GBK', $str);

            $s2 = iconv('GBK', 'UTF-8', $s1);

        }

        $s = $s2 === $str ? $s1 : $str;

        $asc = ord($s[0]) * 256 + ord($s[1]) - 65536;

        if ($asc >= -20319 && $asc <= -20284) return 'A';

        if ($asc >= -20283 && $asc <= -19776) return 'B';

        if ($asc >= -19775 && $asc <= -19219) return 'C';

        if ($asc >= -19218 && $asc <= -18711) return 'D';

        if ($asc >= -18710 && $asc <= -18527) return 'E';

        if ($asc >= -18526 && $asc <= -18240) return 'F';

        if ($asc >= -18239 && $asc <= -17923) return 'G';

        if ($asc >= -17922 && $asc <= -17418) return 'H';

        if ($asc >= -17417 && $asc <= -16475) return 'J';

        if ($asc >= -16474 && $asc <= -16213) return 'K';

        if ($asc >= -16212 && $asc <= -15641) return 'L';

        if ($asc >= -15640 && $asc <= -15166) return 'M';

        if ($asc >= -15165 && $asc <= -14923) return 'N';

        if ($asc >= -14922 && $asc <= -14915) return 'O';

        if ($asc >= -14914 && $asc <= -14631) return 'P';

        if ($asc >= -14630 && $asc <= -14150) return 'Q';

        if ($asc >= -14149 && $asc <= -14091) return 'R';

        if ($asc >= -14090 && $asc <= -13319) return 'S';

        if ($asc >= -13318 && $asc <= -12839) return 'T';

        if ($asc >= -12838 && $asc <= -12557) return 'W';

        if ($asc >= -12556 && $asc <= -11848) return 'X';

        if ($asc >= -11847 && $asc <= -11056) return 'Y';

        if ($asc >= -11055 && $asc <= -10247) return 'Z';

        return '*';

    }

}


if (!function_exists('arraySortByKey')) {

    /**
     * 二维数组根据某个值排序
     * @param $array
     * @param $key
     * @param string $sort
     * @return array
     */
    function arraySortByKey($array, $key, $sort = 'asc')
    {

        $newArr = $valArr = array();

        foreach ($array as $k => $value) {

            $valArr[$k] = $value[$key];

        }

        //先利用key对数组排序，目的是把目标数组的key排好序
        ($sort == 'asc') ? asort($valArr) : arsort($valArr);

        //指针指向数组第一个值
        reset($valArr);

        foreach ($valArr as $key => $value) {

            $newArr[$key] = $array[$key];

        }

        return $newArr;

    }

}
