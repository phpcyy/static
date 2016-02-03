<?php
    session_start();
    if($_SESSION['name']){
        $token = md5(sha1($_SESSION['name']."wechat")."youchat");
?>
<html>
<meta charset="utf8">
<title>添加-百度新闻</title>
<link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <!-- 头部开始 -->
    <div class="header">
        <div class="head">
            <div class="usrbar">
                <div class="usrstatus">
                    <div class="info">
                        <span class="nm" style="line-height:38px">管理员</span>
                        <span class="logout"><a href="../controller/logout.php" style="line-height:38px" class="fuc">退出</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 头部结束 -->
    <div class="body">
        <!-- 导航 -->
        <div class="table">
            <div class="nav">
                <a href="manage.php">
                    <label>新闻列表</label>
                </a>
                <label class="active">添加新闻</label>
            </div>
        </div>
        <!-- 导航结束 -->
        <!-- 表单 -->
        <div class="publish">
            <form action="../controller/add.php" method="post" enctype="multipart/form-data">
                <div class="item">标题：
                    <div class="input">
                        <input name="title">
                        <input type="hidden" name="guess" value="<?php echo $token;?>">
                    </div>
                </div>
                <div class="item">内容：
                    <div class="content">
                        <textarea name="content"></textarea>
                    </div>
                </div>
                <div class="item">图片：<img src="../img/add.png" id="pre"></div>
                <input id="img" hidden type="file" onchange="previewImage(this)" name="file">
                <div class="button">提交</div>
        </div>
        <!-- 表单结束 -->
    </div>
    <!-- 提示框，默认隐藏 -->
    <div class="warn">
    </div>
    <!-- 提示框结束 -->
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.form.min.js"></script>
    <script type="text/javascript">
    //点击图片时触发文件框
    $(".item img").on("click", function() {
        $("#img").click();
    });
    //点击提交时提交内容并根据结果进行不同提示
    $(".button").on("click", function() {
        $("form").ajaxSubmit({
            resetForm: true,
            dataType: "json",
            success: function(data) {
                if (data.status == 1) {
                    $(".warn").text(data.msg).show();
                    setTimeout(function(){
                        location.href = "manage.php";
                    },2000);
                } else {
                    $(".warn").css("background-color", "brown").text(data.msg).show().delay(2000).hide(0);
                }
            }
        });
    });
    //预览图片，IE下可能不兼容，但应该不影响新闻的提交
    function previewImage(file) {
        var MAXWIDTH = 260;
        var MAXHEIGHT = 180;
        if (file.files && file.files[0]) {
            var img = document.getElementById('pre');
            var reader = new FileReader();
            reader.onload = function(evt) {
                img.src = evt.target.result;
            }
            reader.readAsDataURL(file.files[0]);
        }
    }
    </script>
</body>

</html>
<?php }else{
    echo "请先登录";
}?>
