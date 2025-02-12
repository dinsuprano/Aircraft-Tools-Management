<?php 

include_once 'connectdb.php';
session_start();

$id = $_GET['id'];
$num=1;

$query="SELECT * FROM tbl_borrow_tools where check_id='$id' and status_='not returned'";
$statement = $pdo->prepare($query);
$statement->execute();
$count=$statement->rowCount();
$result=$statement->fetchAll();

if($count>0){
    foreach($result as $row){
        $barcode=$row['barcode'];
    }
    try{
        $query="UPDATE tbl_borrow_tools SET status_='Returned' where check_id='$id'";
        $statement = $pdo->prepare($query);
        $statement->execute();
        
        $query="UPDATE tbl_tools  SET available_quantity=$num where barcode='$barcode'";
        $statement = $pdo->prepare($query);
        $statement->execute();
        
        $delayed = date('Y-m-d 18:00:00');

        date_default_timezone_set("Asia/Kuala_Lumpur");
        $start_date=date('Y-m-d H:i:s');
        $query="UPDATE tbl_borrow_tools SET check_in_date='$start_date' where check_id='$id'";
        $statement = $pdo->prepare($query);
        $statement->execute();
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }
    if($start_date>$delayed){
        try{
            $query="UPDATE tbl_borrow_tools SET actual_date_returned='Late Return' where check_id='$id'";
            $statement = $pdo->prepare($query);
            $statement->execute();
        }   
        catch(PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
    }else{
        try{
            $query="UPDATE tbl_borrow_tools SET actual_date_returned='Not Late' where check_id='$id'";
            $statement = $pdo->prepare($query);
            $statement->execute();
        }
        catch(PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
    }

    $status = urlencode("Returned Success");
    header("Location:C_Check.php?status1=".$status);

}else{
    $status = urlencode("Return Failed");
    header("Location:C_Check.php?status2=".$status);
    die();
}
?>