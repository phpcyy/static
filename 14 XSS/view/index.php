<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>百度新闻</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0">
    <meta name="MobileOptimized" content="320">
    <meta name="format-detection" content="telephone=no" />
    <!-- 就是什么版本 IE 就用什么版本的标准模式渲染 ,如果检测到 IE 并未安装 Google Frame，则弹出对话框提示安装-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!-- 如果使用双核浏览器，强制使用webkit来进行页面渲染 -->
    <meta name="renderer" content="webkit" />
    <!-- 网站描述 -->
    <meta name="description" content="百度新闻，提供最优新闻资讯搜索，展现即时消息动态" />
    <!-- 网站搜索关键词 -->
    <meta name="keywords" content="新闻，资讯，即时消息，动态，时事">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../font-awesome-4.4.0/css/font-awesome.min.css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
</head>

<body>
    <!-- 顶部导航栏开始 -->
    <nav>
        <table>
            <tr>
                <td class="cur">推荐</td>
                <td>百家</td>
                <td>本地</td>
                <td>图片</td>
                <td>娱乐</td>
                <td>社会</td>
            </tr>
            <tr>
                <td>军事</td>
                <td>科技</td>
                <td colspan="2">互联网</td>
                <td>女人</td>
                <td hidden>搞笑</td>
                <td class="more">更多<i class="fa fa-caret-down"></i></td>
            </tr>
            <tr hidden>
                <td>生活</td>
                <td>国际</td>
                <td>国内</td>
                <td>体育</td>
                <td>汽车</td>
                <td>财经</td>
            </tr>
            <tr hidden>
                <td>房产</td>
                <td>时尚</td>
                <td>体育</td>
                <td>游戏</td>
                <td>旅游</td>
                <td>人文</td>
            </tr>
            <tr hidden>
                <td colspan="2">创意</td>
                <td colspan="2">互联网+</td>
            </tr>
        </table>
        <div class="slide">
            <div>记者榜</div>
            <div>媒体榜</div>
            <div>删除及排序</div>
            <label class="pack">收起<i class="fa fa-caret-up"></i></label>
        </div>
    </nav>
    <!-- 顶部导航栏结束 -->
    <!-- 轮播开始 -->
    <div class="carousel">
        <div class="imgs">
            <img src="../img/a686c9177f3e6709de17d0143dc79f3df9dc55c1.jpg" alt="">
            <img src="../img/timg (1).jpg" alt="">
            <img src="../img/timg.jpg" alt="">
        </div>
        <ul>
            <li class="on"></li>
            <li></li>
            <li></li>
        </ul>
    </div>
    <!-- 轮播结束 -->
    <!-- 新闻列表开始，列表内容以ajax方式载入-->
    <div class="newslist">
    </div>
    <!-- 新闻列表结束 -->
    <!-- 加载更多按钮 -->
    <div class="btn">
        点击加载更多
    </div>
    <!-- 加载更多按钮 -->
    <script type="text/javascript">
    //当页面载入时加载数据
    $.getJSON("../controller/news.php", null, function(data) {
        $.each(data, function(index, val) {
            //console.trace(val);
            $(".newslist").append($('<div class="news"><img src="../img/' + val.img + '"><section><h4>' + val.title.substr(0, 12) + '</h4><p>' + val.content.substr(0, 15) + '</p><time>' + val.time + '</time></section></div>'));
        });
    }, "json");
    $(document).ready(function() {
        //点击更多时展开导航栏
        $(".more").on("click", function() {
            $(this).hide().prev().show();
            $(".slide").show();
            $("nav table tr").show();
        });
        //点击收起时折叠导航栏
        $(".pack").on("click", function() {
            $(".more").show().prev().hide().closest("tr").nextAll("tr").hide();
            $(".slide").hide();
        });
        //轮播事件
        var n = 1;
        setInterval(function() {
            $(".imgs").css({
                transform: "translateX(" + -n % 3 / 3 * $(".imgs").width() + "px)"
            });
            $(".on").removeClass("on");
            $(".carousel ul li").eq(n % 3).addClass("on");
            n++;
        }, 2000);
        //点击加载更多时载入新的数据
        $(".btn").on("click", function() {
            $(this).text("加载中");
            $.getJSON("../controller/news.php", {
                "first": $(".news").length
            }, function(data) {
                $.each(data, function(index, val) {
                    //console.trace(val);
                    $(".newslist").append($('<div class="news"><img src="../img/' + val.img + '"><section><h4>' + val.title.substr(0, 12) + '</h4><p>' + val.content.substr(0, 15) + '</p><time>' + val.time + '</time></section></div>'));
                });
                $(".btn").text("加载更多");
            }, "json");
        });
    });
    </script>
</body>

</html>
