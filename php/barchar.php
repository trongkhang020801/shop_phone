<?php
require_once ("../BackEnd/ConnectionDB/DB_driver.php");

function soluong(){
    $db = new DB_driver();
    $db -> connect();
    $sql = "SELECT lsp.TenLSP, SUM(cthd.SoLuong) as TongSP FROM chitiethoadon as cthd , sanpham as sp, loaisanpham as lsp WHERE cthd.MaSP = sp.MaSP AND sp.MaLSP = lsp.MaLSP GROUP BY lsp.TenLSP";
    $list = mysqli_query($db->__conn,$sql);
    $list = array();
    json_encode($list);
}
?>