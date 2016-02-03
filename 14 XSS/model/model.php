<?php
/*
	2015-11-29 15:29:35 Sunday
*/
class model{
		public $con;
		private $table;
		//构造函数传递表名参数
		public function __construct($table){
			//将连接方式由废弃的mysql改为仍然支持的mysqli
			$this->con = mysqli_connect("localhost","root","123456","baidu");
			//$this->con = mysqli_connect("localhost","root","123456");
			//mysqli_select_db("baidu");
			//mysqli_select_db(\$this->con, "baidu");
			mysqli_set_charset($this->con,"utf-8");
			$this->table = $table;
		}

		//选择方法
		public function select($first){
			//增加的语句, 进行字符串过滤
			$first = htmlspecialchars($first);
			//$query = mysql_query("select * from " . $this->table . " limit $first,10",$this->con);
			//更改为：
			$stmt = mysqli_prepare($this->con, "select * from " . $this->table ." limit ?,10");
			$stmt->bind_param("i",$first);
			$stmt->execute();
			$results = $stmt->get_result();
			$res = [];
			for($n=1;$n<=10;$n++){
				$result = $results->fetch_assoc();
			  	array_push($res, $result);
			}
			return json_encode($res);
		}

		//全部选择
		public function selectAll(){
			//此处为展示数据，全部由后端完成，没有数据的交互，无需进行过滤,也无需进行预处理
			$query = mysqli_query($this->con,"select * from " . $this->table . " order by id desc");
			$res = [];
			while($result=mysqli_fetch_object($query)){
			  	array_push($res, $result);
			}
			return $res;
		}

		//找到相应id的记录
		public function find($id){
			//进行输入过滤
			$id = htmlspecialchars($id);
			//$query = mysqli_query("select * from " . $this->table . " where id = '{$id}'",$this->con);
			//进行预处理
			$stmt = mysqli_prepare($this->con, "select * from " . $this->table . " where id = ?");
			$stmt->bind_param("i",$id);
			$stmt->execute();
			$result = $stmt->get_result();
			return $result->fetch_object();
		}

		//增加方法
		public function add($title,$content,$img){
			$title = htmlspecialchars($title);
			$content = htmlspecialchars($content);
			$img = htmlspecialchars($img);
			$stmt = mysqli_prepare($this->con,"insert into " . $this->table . "(title,content,img) values(?,?,?)");
			/*if(mysqli_query("insert into " . $this->table . "(title,content,img) values ('$title','$content','$img')")){
				return true;
			}*/
			$stmt->bind_param("sss",$title,$content,$img);
			if($stmt->execute()){
				return true;
			}
			return false;
		}

		//删除方法
		public function delete($id){
			//数据进行过滤
			$id = htmlspecialchars($id);
			$stmt = mysqli_prepare($this->con, "delete from ".$this->table. " where id = ?");
			//用整型再次进行过滤
			$stmt->bind_param("i",$id);
			if($stmt->execute()){
				return true;
			}
			return false;
			/*if(mysql_query("delete from " . $this->table . " where id = $id"))
			{
				return true;
			}
			return false;*/
		}

		//更新操作
		public function update($id,$title,$content,$img){
			//如果img存在更新则更新img，否则不更新
			/*if($img&&mysqli_query("update " . $this->table . " set title = '{$title}',content='{$content}',img='{$img}' where id = '{$id}'")){
				return true;
			}elseif(mysqli_query("update " . $this->table . " set title = '{$title}',content='{$content}' where id = '{$id}'")){
				return true;
			}*/
			$id = htmlspecialchars($id);
			$title = htmlspecialchars($title);
			$content = htmlspecialchars($content);
			if($img){
				$img = htmlspecialchars($img);
				$stmt = mysqli_prepare($this->con,"update " . $this->table . " set title = ?,content=?,img=? where id=?");
				$stmt->bind_param("sssi",$title,$content,$img,$id);
			}else{
				$stmt = mysqli_prepare($this->con,"update " . $this->table . " set title = ?,content=? where id=?");
				$stmt->bind_param("ssi",$title,$content,$id);
			}
			if($stmt->execute()){
				return true;
			}
			return false;
		}

		//检查用户名密码是否正确
		public function checklogin($name,$password){
			$name = htmlspecialchars($name);
			$password = htmlspecialchars($password);
			$stmt = mysqli_prepare($this->con, "select count(*) from " . $this->table . " where name = ? and password = ?");
			$stmt->bind_param("ss",$name, $password);
			$stmt->execute();
			$results = $stmt->get_result();
			//$sql = "select count(*) from " . $this->table . " where name = '{$name}' and password = '{$password}'";
			//$query = mysqli_query($this->con,$sql);
			//$result = mysqli_fetch_row($query);
			if($results->fetch_row()[0]){
				return true;
			}
			return false;
		}

	}

