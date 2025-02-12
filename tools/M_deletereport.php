<?php
include_once'connectdb.php';
$id=$_POST['mid'];


$sql="delete from tbl_maintenance where mid =$id";

$delete=$pdo->prepare($sql);

if($delete->execute()){

}else{

    echo"Error in deleting product";
}

?>