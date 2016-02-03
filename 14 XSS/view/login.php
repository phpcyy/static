<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <!-- 就是什么版本 IE 就用什么版本的标准模式渲染 ,如果检测到 IE 并未安装 Google Frame，则弹出对话框提示安装-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!-- 如果使用双核浏览器，强制使用webkit来进行页面渲染 -->
    <meta name="renderer" content="webkit" />
    <!-- 网站描述 -->
    <title>登录-百度后台</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>

<body>
    <!-- 这一页比较简单，就是一个登录页面 -->
    <div class="main">
        <span class="title">登录</span>
        <div class="left">
            <p>请输入你的用户名和密码。</p>
        </div>
        <div class="box">
            <label>您的用户名</label>
            <form method="post">
                <input type="text" id="email" name="name"  required autofocus><br >
                <label>您的密码</label>
                <input type="password" id="email" name="password"  required >
                <button class="ok" type="submit">登录</button>
            </form>
        </div>
    </div>
    <!-- 提示框 -->
    <div class="warn">
    </div>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript">
        $(".ok").on("click",function(){
            $.ajax({
                url:"../controller/account.php",
                data:$("form").serialize(),
                type:"post",
                dataType:"json",
                success:function(data){
                    if(data.status==1){
                        $(".warn").text(data.msg).css("background","#44B549").show();
                        setTimeout(function(){
                            location.href="manage.php";
                        }, 1000);
                    }else{
                        $(".warn").text(data.msg).css("background","orange").show().delay(1000).hide(0);
                    }
                }
            });
            return false;
        });
    </script>
</body>

</html>
