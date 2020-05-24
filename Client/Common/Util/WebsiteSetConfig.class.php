<?php

/**

 * 

 * @team SlipperClown (http://www.slippersclown.com/)

 * @developer Hacker丶Wand (578112964@qq.com)

 * @date    2017-06-05 17:58:26

 * @version $Id$

 */

namespace Common\Util;

class WebsiteSetConfig {

    

    public static $config=null;
	public static $modeset=null;


    public static function load(){
    	$result = API(array(),'WebsiteSet','load');
		S(array('type'=>'File','prefix'=>'WebSetting','expire'=>99999999));
    	S('WebsiteSetConfig',$result['webset']);
		self::$modeset = $result["modeWebSet"];
		
    	self::$config = S('WebsiteSetConfig');
		
    }

	public static function all(){

		if(!self::$config)
			self::load();

		return self::$config;

	}



	public static function setStatic(){
		if(!self::$config)

			self::load();

		$data=I('post.');

		
		
		foreach (self::$modeset["static"] as $key => $value) {

			if(!key_exists($key,$data))

				continue;

			self::$config['static'][$key]=$data[$key];

		}
		foreach (self::$config as $key => $value) {

			if(!key_exists($key, self::$modeset ))
				unset( self::$config[ $key ] );

		}

		self::save();

	}



	public static function del(){



		if(!self::$config)

			self::load();



		$groupId=I('get.groupId');

		$setId=I('get.setId');



		if(isset(self::$config['list'][$groupId]['child'][$setId])){

			unset(self::$config['list'][$groupId]['child'][$setId]);

			self::save();

		}

	}



	public static function setList(){

		if(!self::$config)

			self::load();

		$groupId=I('post.group-id');

		$setId=I('post.set-id');

		self::$config['list'][$groupId]['child'][$setId]['title']=I('post.title');

		self::$config['list'][$groupId]['child'][$setId]['value']=I('post.value');

		self::save();

	}



	public static function addList(){



		if(!self::$config)

			self::load();



		$title=I('post.title');

		$value=I('post.value');

		$groupId=I('get.groupId');



		self::$config['list'][$groupId]['child'][]=array('title'=>$title,'value'=>$value);

		self::save();

	}



	public static function addGroup(){

		if(!self::$config)

			self::load();



		$title=I('post.title');

		self::$config['list'][]=array('title'=>$title,'child'=>array());

		self::save();
	}



	public static function delGroup(){

		if(!self::$config)

			self::load();



		$groupId=I('get.groupId');

		if(isset(self::$config['list'][$groupId])){

			unset(self::$config['list'][$groupId]);

			self::save();

		}

	}



	public static function get($key){

		if(!self::$config)

			self::load();

		return isset(self::$config['static'][$key])?self::$config['static'][$key]:'';

	}



	public static function getList(){



		if(!self::$config)

			self::load();
		return self::$config['list'];

	}

	public static function save(){
		$checkWebUser = checkWebUser();
		
		if(!empty( $checkWebUser ))
			$res = API(array('set_data'=>serialize(self::$config)),'WebsiteSet','save');
	if( $res["code"]==0 ){
		S(array('type'=>'File','prefix'=>'WebSetting','expire'=>99999999));
    	S('WebsiteSetConfig', self::$config );
	}
		
	}



}