<?php
error_reporting(E_ERROR);
session_start();
if (!$_SESSION['name']||!$_POST['guess'] || $_POST['guess'] !== md5(sha1($_SESSION['name']."wechat")."youchat")) {
    echo "不合法的来路！";
    die;
}
//获取提交数据
$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$img = upload();
require("../model/model.php");
$news = new model("news");

//更新并返回结果
if ($news->update($id, $title, $content, $img)) {
    $data['status'] = 1;
    $data['msg'] = "更新成功";
} else {
    $data['status'] = 0;
    $data['msg'] = "更新失败";
}
echo json_encode($data);


//上传文件
function upload()
{
    if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 2000000)
    ) {
        if ($_FILES["file"]["error"] > 0) {
            //"Return Code: " . $_FILES["file"]["error"] . "<br />";
            return false;
        } else {
            if (file_exists("../img/" . $_FILES["file"]["name"])) {
                echo $_FILES["file"]["name"] . " already exists. ";
            } else {
                $oldname = $_FILES["file"]["name"];
                $ext = array_pop(explode(".", $oldname));
                $name = time() . rand(0, 10000) . "." . $ext;
                move_uploaded_file($_FILES["file"]["tmp_name"], "../img/" . $name);
                return $name;
            }
        }
    } else {
        //echo "Invalid file";
        return false;
    }
}

?>