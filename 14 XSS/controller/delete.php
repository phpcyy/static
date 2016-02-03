<?php
	session_start();
	if(!$_SESSION['name']||!$_POST['guess']||$_POST['guess']!==md5(sha1($_SESSION['name']."wechat")."youchat")){
		echo "不合法的来路！";
		die;
	}
include("../model/model.php");
	//调用model删除置顶数据
	$news = new model("news");
	$id = $_POST['id'];
	if($news->delete($id)){
		$data['status'] = 1;
		$data['msg'] =  "删除成功";
	}else{
		$data['status'] = 0;
		$data['msg'] = "删除失败";
	}
	echo json_encode($data);