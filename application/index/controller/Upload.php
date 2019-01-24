<?php
namespace app\index\controller;

use think\Request;
use think\Controller;

class Upload extends Controller{

    //上传根目录文件夹
    protected $root_path = '';
    protected $req = NULL;

    public function _initialize() {
        $this->req = Request::instance();
        $this->root_path = ROOT_PATH . 'public';
    }

     //上传图片文件
    /**
     * @description  上传图片
     * @author Lang
     * @return \think\response\Json
     */
    public function uploadImg()
    {
        $savepath = DS . 'upload' . DS . 'img';
        $file = request()->file('file');

        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['size'=> 102400 * 100 , 'ext' => 'jpg,png,gif,bmp,jpeg'])->move($this->root_path . $savepath);
        if($info)
        {
            // 成功上传后 获取上传信息
            return json(['status' => 1, 'data' => $savepath . DS . $info->getSaveName(), 'msg' => 'ok']);
        }
        // 上传失败获取错误信息
        return json(['status' => 0, 'msg' => $file->getError()]); 
    }



     //上传音频
   /* public function uploadaudio(){
        $savepath = DS . 'uploads' . DS . 'audio';
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['size'=> 102400 * 100 , 'ext' => 'amr,mp3'])->move($this->root_path . $savepath);
        if($info){
            // 成功上传后 获取上传信息
            return json(['status' => 1, 'url' => $savepath . DS . $info->getSaveName(), 'msg' => 'ok']); 
        }
        // 上传失败获取错误信息
        return json(['status' => 0, 'msg' => $file->getError()]); 
    }

     //上传视频
    public function uploadvideo(){
        $savepath = DS . 'uploads' . DS . 'video';
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['size'=> 102400 * 10000, 'ext' => 'mp4,rmvb,flv'])->move($this->root_path . $savepath);
        if($info){
            // 成功上传后 获取上传信息
            return json(['status' => 1, 'url' => $savepath . DS . $info->getSaveName(), 'msg' => 'ok']); 
        }
        // 上传失败获取错误信息
        return json(['status' => 0, 'msg' => $file->getError()]); 
    }*/

     //上传文件
    public function uploadFile(){
        $savepath = DS . 'upload' . DS . 'file';
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['size'=> 102400 * 100 , 'ext' => 'rar,zip,txt,docx,doc,excel,csv'])->move($this->root_path . $savepath);
        if($info){
            // 成功上传后 获取上传信息
            return json(['status' => 1, 'url' => $savepath . DS . $info->getSaveName(), 'msg' => 'ok']); 
        }
        // 上传失败获取错误信息
        return json(['status' => 0, 'msg' => $file->getError()]); 
    }

    /**
    * 上传base64的图片
    * @static
    * @param $data
    * @param $savepath
    * @return path | bool:false
    */
    public function upavatar() {
        if($this->req->isPost()) {
            $data = $this->req->post();
            $savepath = '.' . DS . 'upload' . DS . 'avatar';
            $avatar = $data['avatar'];
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $avatar, $result)){
                $type = $result[2];
                // /uploads/joke/5/
                //$savepath = '.' . DS . 'uploads' . DS . 'joke' . DS . $data['user_id'];
                $time = time();
                if(!is_dir($savepath)) {
                    mkdir($savepath,0777,true);
                }
                $file = $savepath . DS . $time .".{$type}";
                if (file_put_contents($file, base64_decode(str_replace($result[1], '', $avatar)))){
                    return json(['status' => 1, 'msg' => '上传成功！','url' => substr($file,1)]);
                }
            }
        }
        return json(['status' => 0, 'msg' => '上传失败！']);
    }

//    public function demo(){
//
//        $res = './uploads/static/20171008/57a8c3fbd8ff4d87c331ef4116cfce17.jpg';
//
//        $image = \think\Image::open($res);
//
//
//        // 返回图片的宽度
//        $width = $image->width();
//        // 返回图片的高度
//        $height = $image->height();
//        // 返回图片的类型
//        $type = $image->type();
//
////        echo '宽度:'.$width.'<br>';
////        echo '高度:'.$height.'<br>';
////        echo '类型:'.$type.'<br>';
////        die();
//
//        // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
//        $image->thumb(260,120,\think\Image::THUMB_CENTER)->save('./uploads/static/20171008/thumb3.'.$type);
//    }

}
