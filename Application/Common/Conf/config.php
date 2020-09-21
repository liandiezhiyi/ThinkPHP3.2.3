<?php
return array(
		    // 数据库配置信息
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'bysystemdb', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'root', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'yzx_', // 数据库表前缀 
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  false, // 数据库调试模式 开启后可以记录SQL日志
   
		//管理员帐号
		'ADMIN_NAME' => 'superadmin',
		
		
		
	'AUTH_CONFIG'=>array(
		'AUTH_ON' => true, //认证开关
		'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
		'AUTH_GROUP' => 'yzx_group', //用户组表
		'AUTH_GROUP_ACCESS' => 'yzx_access', //用户与用户组关系表
		'AUTH_RULE' => 'yzx_rule', //权限表
		'AUTH_USER' => 'yzx_master'//用户表
	),
		
	'SESSION_OPTIONS' =>array(
				//和其他运行在同一个服务器的session进行隔离，避免相互干扰
				//'path' => '/session/tmp_s/',
				'expire' => 7200,
		),
		
	
		
);