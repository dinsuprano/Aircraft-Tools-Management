<?php 

include_once 'connectdb.php';
session_start();

$id = $_GET['id'];
$num=1;

$query="SELECT * FROM tbl_borrow_tools where check_id='$id'";
$statement = $pdo->prepare($query);
$statement->execute();
$count=$statement->rowCount();
$result=$statement->fetchAll();

if($count>0){
    foreach($result as $row){
        $barcode=$row['barcode'];
    }
    
    try{
        $query="UPDATE tbl_tools  SET available_quantity=1 where barcode='$barcode'";
        $statement = $pdo->prepare($query);
        $statement->execute();

        $sql="delete from tbl_borrow_tools where check_id =$id";
        $delete=$pdo->prepare($sql);
        $delete->execute();

        $status = urlencode("Removed");
        header("Location:C_Check.php?status3=".$status);
    }
    
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

}
else{
    $status = urlencode("Failed");
    header("Location:C_Check.php?status4=".$status);
    die();
}

?>