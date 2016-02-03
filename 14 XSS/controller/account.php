<?php
	//获取用户名、密码
	$name = trim($_POST['name']);
	$password = trim($_POST['password']);
	//检查是否为空
	if(!$name||!$password){
		$data['status'] = 0;
		$data['msg'] = "用户名或密码不可为空";
	}else{
		//调用model，判断用户名、密码是否正确
		require_once("../model/model.php");
		$user = new model("user");
		if($user->checklogin($name,$password)){
			session_start();
			$_SESSION['name'] = $name;
			$data['status'] = 1;
			$data['msg'] = "登录成功，正在跳转中！";
		}
		else{
			$data['status'] = 0;
			$data['msg'] = "用户名或密码不正确";
		}
	}
	//返回数据
	echo json_encode($data);