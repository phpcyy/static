<?php
	require_once("../model/model.php");
	$first = $_GET['first']?$_GET['first']:0;
	$news = new model("news");
	echo $news->select($first);