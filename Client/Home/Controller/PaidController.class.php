<?php
/**
 * Created by PhpStorm.
 * User: coolce
 * Date: 2017/1/9
 * Time: 11:24
 */

namespace Home\Controller;
use Think\Controller;


class PaidController extends LoginController
{
    public function index()
    {
        
		
		
		$this->display();
    }

    public function lists()
    {
		
        $res=$this->ApiReturn();
        if (!$res['status'] == 404){
            $this->assign('lists',$res);
        }
        $this->display();
    }

    public function add()
    {
        $res=$this->ApiReturn();
		
		
		
        if ($res['status'] == 400){
            $this->success('申请提交成功！',U('Paid/lists'));
        }else if($res['status'] == 401){
			$this->assign('lists',$res);
			$this->display("info");
		}
		else{
            $this->error( $res["message"] );
        }
//        $this->assign('res',$res);
    }
function bind(){
	$res=$this->ApiReturn();
	if( IS_AJAX ){
        $this->ajaxreturn($res);
    }else{
	    $this->success('申请成功，请等待管理人员审核');
    }

	
}
    public function ali()
    {
        $this->display();
    }
public function dami(){
    $this->display();
}
    public function ty()
    {
        $this->display();
    }

    public function bd()
    {
        $this->display();
    }
}