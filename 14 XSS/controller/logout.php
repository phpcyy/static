<?php
	header("Contenttype:text/html;charset=utf-8");
	//清除session
	session_start();
	session_unset();
	session_destroy();
	echo "退出成功...";
	?>
	<script type="text/javascript">
	setTimeout(function(){
		location.href="../view/login.php";
	}, 2000);
	</script>