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

function is_mobile( $text ) {
      if(preg_match("/^1[34578]{1}\d{9}$/",$text)){
          return TRUE;
      }else{
          return FALSE;
      }
  }

function is_idcard( $id )
{
  $id = strtoupper($id);
  $regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/";
  $arr_split = array();
  if(!preg_match($regx, $id))
  {
    return FALSE;
  }
  if(15==strlen($id)) //检查15位
  {
    $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/";
    @preg_match($regx, $id, $arr_split);
    //检查生日日期是否正确
    $dtm_birth = "19".$arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];
    if(!strtotime($dtm_birth))
    {
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }
  else //检查18位
  {
    $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";
    @preg_match($regx, $id, $arr_split);
    $dtm_birth = $arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];
    if(!strtotime($dtm_birth)) //检查生日日期是否正确
    {
      return FALSE;
    }
    else
    {
      //检验18位身份证的校验码是否正确。
      //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
      $arr_int = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
      $arr_ch = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
      $sign = 0;
      for ( $i = 0; $i < 17; $i++ )
      {
        $b = (int) $id{$i};
        $w = $arr_int[$i];
        $sign += $b * $w;
      }
      $n = $sign % 11;
      $val_num = $arr_ch[$n];
      if ($val_num != substr($id,17, 1))
      {
        return FALSE;
      }
      else
      {
        return TRUE;
      }
    }
  }
}