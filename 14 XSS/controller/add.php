<?php
	error_reporting(E_ERROR);
	session_start();
	if(!$_SESSION['name']||!$_POST['guess']||$_POST['guess']!=md5(sha1($_SESSION['name']."wechat")."youchat")){
		echo "不合法的来路！";
		die;
	}
	//var_dump($_POST);
	$title = $_POST['title'];
	$content = $_POST['content'];
	$img = upload();
	if(!$img){
		$data['status'] = 0;
		$data['msg'] = "上传的图片不合法";
	}else{
		require("../model/model.php");
		$news = new model("news");
		//var_dump($news->add($title,$content,$img));
		if($news->add($title,$content,$img))
		{
			$data['status'] = 1;
			$data['msg'] = "添加成功";
		}else{
			$data['status'] = 0;
			$data['msg'] = "添加失败";
		}
	}
	echo json_encode($data);

	function upload(){
		if ((($_FILES["file"]["type"] == "image/gif")|| ($_FILES["file"]["type"] == "image/jpeg")|| ($_FILES["file"]["type"] == "image/png"))
		&& ($_FILES["file"]["size"] < 2000000))
		{
			if ($_FILES["file"]["error"] > 0)
			{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
			}
			else
			{
				if (file_exists("../img/" . $_FILES["file"]["name"]))
				{
					echo $_FILES["file"]["name"] . " already exists. ";
				}
				else
				{
					$name = $_FILES["file"]["name"];
					$ext = array_pop(explode(".",$name));
					$name = time(). rand(0,10000) . "." . $ext;
					move_uploaded_file($_FILES["file"]["tmp_name"],"../img/" . $name);
					return $name;
				}
			}
		}
		else
		{

		}
	}
?>