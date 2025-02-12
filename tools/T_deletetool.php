<?php
include_once'connectdb.php';
$id=$_POST['tidd'];
$sql="delete from tbl_tools where barcode =$id";

$delete=$pdo->prepare($sql);

if($delete->execute()){
    header("Location:C_Check.php?status=".$status);
}else{

    echo"Error in deleting product";
}

?>