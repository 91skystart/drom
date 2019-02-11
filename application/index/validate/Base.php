<?php
namespace app\index\validate;
use think\Validate;

class Base extends Validate{
	protected $param;
	public function __construct(){
		parent::__construct();
		$this->param = \think\Request::instance()->param();
	}
}