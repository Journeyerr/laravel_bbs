<?php
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ErrorCode;


if (!function_exists('error_return')) {
    function error_return($errorCode, $result = [])
    {
        if (isset($result['msg']) && $result['msg']) {
            $msg = $result['msg'];
        } else {
            $msg = ErrorCode::errorMsg($errorCode);
        }
        return [
            'code' => $errorCode,
            'msg' => $msg,
            'result' => $result
        ];
    }
}


if (!function_exists('success_return')) {
    function success_return($result = [])
    {
        return ['code' => 0, 'result' => $result];
    }
}

if (!function_exists('pr')) {
    function pr($content)
    {
        echo '<pre>';
        print_r($content);
        echo '</pre>';
        die;
    }
}

if (!function_exists('is_json')) {
    function is_json($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
/**
 * 工作日|结帐日
 * @return [type] [description]
 */
if (!function_exists('busy_day')) {
    function busy_day()
    {
        $now = time();
        $nowH = date('H', time());
        // 判断当前时间是否是[[0-6]
        if (0 <= $nowH && 4 > $nowH) {
            // 减20小时是为了准确判断临界值
            $today['start'] = date('Y-m-d 04:00:00', strtotime('-20 hours', $now));
            $today['end'] =  date('Y-m-d 04:00:00', $now);
            $today['date'] = date('Y-m-d', strtotime('-20 hours', $now));
        } else {
            $today['start'] = date('Y-m-d 04:00:00', $now);
            $today['end'] = date('Y-m-d 04:00:00', strtotime('+20 hours', $now));
            $today['date'] = date('Y-m-d', $now);
        }
        return $today;
    }
}

/**
 * 一个月
 * @return [type] [description]
 */
if (!function_exists('month_day')) {
    function month_day()
    {
        $data['start'] = date('Y-m-d 00:00:00', strtotime('- 1 month', time()));
        $nowH = date('H', time());
        if (0 <= $nowH && 4 > $nowH) {
            $data['end'] = date('Y-m-d 04:00:00', strtotime('-20 hours', time()));
        } else {
            $data['end'] = date('Y-m-d 04:00:00', time());
        }
        return $data;
    }
}

/**
 * 一个星期
 * @return [type] [description]
 */
if (!function_exists('week_day')) {
    function week_day()
    {
        $data['start'] = date('Y-m-d 00:00:00', strtotime('- 7 days', time()));
        $nowH = date('H', time());
        if (0 <= $nowH && 4 > $nowH) {
            $data['end'] = date('Y-m-d 04:00:00', strtotime('-20 hours', time()));
        } else {
            $data['end'] = date('Y-m-d 04:00:00', time());
        }
        return $data;
    }
}

if (!function_exists('system_varable')) {
    function system_varable($key, $value = 'value')
    {
        return DB::table('system_variables')
            ->where('key', $key)
            ->value($value);
    }
}

/**
 * 将Object转换成array格式
 * @param  $array 需要转换的对象
 * @return array
 */
if (!function_exists('object_to_array')) {
    function object_to_array($array)
    {
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = object_array($value);
            }
        }
        return $array;
    }
}

/**
 * curl post 请求
 * @param  $array 需要转换的对象
 * @return array
 */
if (!function_exists('curl_post_request')) {
    function curl_post_request($url,$params,$header=[])
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
        $res = curl_exec($ch);
        if($sError=curl_error($ch)){
            return false;
        }
        curl_close($ch);
        return $res;
    }
}

/**
 * 返回当前时间处于一周中的星期几1-7表示
 */
if (!function_exists('day_of_week')) {
    function day_of_week()
    {
        $weekDay =  \Carbon\Carbon::now()->dayOfWeek;
        if ($weekDay == 0) { // 0为周末
            $weekDay = 7;
        }
        return $weekDay;
    }
}

if (!function_exists('encrypt_phone')) {
    function encrypt_phone($phone)
    {
        if (is_numeric($phone)) {
            $arr = str_split($phone);
            $last = $arr[count($arr) - 1];
            array_splice($arr, $last + 1, 0, [$last]);
            array_pop($arr);
            $str = str_replace('_', '', implode('_', $arr));
            return substr(md5($str), 8, 16);
        } else {
            return substr(md5($phone), 8, 16);
        }
    }
}

if (!function_exists('filter_value')) {
    function filter_value(Array $data)
    {
        return array_filter($data, function($value) {
            if (is_numeric($value)) {
                return true;
            } else {
                return $value != '';
            }
        });
    }
}
if (!function_exists('a_array_unique')) {
    function a_array_unique($array){
        $out = [];

        foreach ($array as $key=>$value) {
            if (!in_array($value, $out)){
                $out[$key] = $value;
            }
        }

        $out = array_values($out);
        return $out;
    }
}


if (!function_exists('setting')) {
    function setting($fileName,$arrayKey,$key)
    {
        return config($fileName.'.'.$arrayKey.'.'.$key);
    }
}
