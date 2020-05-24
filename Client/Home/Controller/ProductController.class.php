<?php
namespace Home\Controller;
use Think\Controller;
class ProductController extends LoginController {
	
	
    public function index(){

		$res=$this->ApiReturn();
		
		if( !empty( $res["excel"] ) ){
			redirect($res["excel"]);die;
		}
		
		$this->assign('res',$res);
		$show=I("get.show");
		$servers=ReadServersCache("*","*",array("servertype"=>$show));
		$this->assign('show',$show);
		$this->assign('servers',$servers);	
		$this->display();
		
       }

    public function order(){
		
		$res=$this->ApiReturn();
		$this->assign('res',$res);
		$servers=ReadServersCache("*","*");
		$this->assign('servers',$servers);	
		$this->display();
		
       }
    public function refun(){
		
		$res=$this->ApiReturn();
		$this->assign('res',$res);
		$servers=ReadServersCache("*","*");
		$this->assign('servers',$servers);	
		$this->display();
		
       }
	   public function order_refund(){
		   $res=$this->ApiReturn();
		   $this->ajaxreturn($res);
	   }

    public function batch_renew(){
        if(IS_POST){
            if($_POST['domain'] == ''){
                $this->error('数据不能为空');
                exit;
            }

            $res=$this->ApiReturn();
        //    print_r($res);exit;
            $this->assign('res', $res);
            $this->display('batch_renew_list');

        }else{
            $this->assign('buymode', C('buymode'));
            $this->display();
        }
    }
	   
}