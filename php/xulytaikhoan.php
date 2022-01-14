<?php
	require_once ("../BackEnd/ConnectionDB/DB_classes.php");
	require_once ("../BackEnd/ConnectionDB/DB_driver.php");
	
	if(!isset($_POST['request']) && !isset($_GET['request'])) die();

	session_start();

	switch ($_POST['request']) {
		case 'dangnhap':
			dangNhap();
			break;

		case 'dangxuat':
			dangXuat();
			break;

		case 'dangky':
			dangKy();
			break;

		case 'getCurrentUser':
			if(isset($_SESSION['currentUser'])) {
				die (json_encode($_SESSION['currentUser']));
			}
			die (json_encode(null));
			break;
		
		default:
			# code...
			break;
	}

	function dangXuat() {
		if(isset($_SESSION['currentUser'])) {
			unset($_SESSION['currentUser']);
			die ("ok");
		}
		die ("no_ok");
	}

	function dangNhap() {
		$taikhoan=$_POST['data_username'];
		$matkhau=$_POST['data_pass'];
		$matkhau=$matkhau;

		$sql = "SELECT * FROM nguoidung WHERE TaiKhoan='$taikhoan' AND MatKhau='$matkhau' AND MaQuyen=1 AND TrangThai=1";
		$result = (new DB_driver())->get_row($sql);

		if($result != false){
		    $_SESSION['currentUser']=$result;
		    die (json_encode($result)); 
		}  
		die (json_encode(null));
	}

	function dangKy() {
		$gt = "";
		$xuli_ho=$_POST['data_ho'];
		$xuli_ten=$_POST['data_ten'];
		$xuli_sdt=$_POST['data_sdt'];
		$xuli_email=$_POST['data_email'];
		$xuli_diachi=$_POST['data_diachi'];
		$xuli_newUser=$_POST['data_newUser'];
		$xuli_newPass=$_POST['data_newPass'];

		$db = new DB_driver();
		$sql1 = "INSERT INTO nguoidung VALUES ('','$xuli_ho','$xuli_ten','$gt','$xuli_sdt','$xuli_email','$xuli_diachi','$xuli_newUser','$xuli_newPass')";
		$db -> connect();
		mysqli_query($db->__conn, $sql1);
			

		// đăng nhập vào ngay
		$sql = "SELECT * FROM nguoidung WHERE TaiKhoan='$xuli_newUser' AND MatKhau='$xuli_newPass' AND MaQuyen=1 AND TrangThai=1";
		$result = (new DB_driver())->get_row($sql);

		if($result != false){
		    $_SESSION['currentUser']=$result;
		    die (json_encode($result)); 
		}  

		die (json_encode(null));
	}
?>