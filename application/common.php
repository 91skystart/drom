<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * @description  模拟post请求
 * @author Lang
 * @param $url
 * @param $param
 * @return bool|mixed
 */
function requestPost($url,$param)
{
    if (empty($url) || empty($param))
    {
        return false;
    }

    $postUrl = $url;
    $curlPost = $param;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$postUrl);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}
function searchRelationIds($rsId, $arr, $pid = 'rs_pid', $id = 'rs_id', $attach = true, $tmp = []){
    if(!in_array($rsId, $tmp)) $tmp[] = $rsId;
    foreach($arr as $k=>$val){
        $attachId = $attach? $val[$pid]: $val[$id];
        $attachRefId = $attach? $val[$id]: $val[$pid];
        if($attachId== $rsId){
            if($val[$pid] != 0){
                $tmp[] = $attachRefId;
                $tmp = searchRelationIds($attachRefId, $arr, $pid, $id, $attach, $tmp);
            }
        }
    }
    return $tmp;
}