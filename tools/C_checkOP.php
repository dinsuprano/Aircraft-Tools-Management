<?php

include_once 'connectdb.php';
session_start();


if(isset($_POST['btncheck'])){

    
    $barcode=($_POST['txtbarcode']);
    $employee_id=$_POST['txt_employee_id'];
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $check_out_date=date('Y-m-d H:i:s');
    $check_in_date='0';
   
    try {
        $query = "SELECT * FROM tbl_tools WHERE barcode ='$barcode'";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $result=$statement->fetchAll();
        $available=0;
    }
    
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    foreach($result as $row){
        $available=$row['available_quantity'];
    }


    if($available<=0){

        $status = urlencode("Tool Already Checked Out");
        header("Location:C_Check.php?status=".$status);
        die();
    }

    try{

        $available = $available - 1;

        $query="UPDATE tbl_tools SET available_quantity = $available WHERE barcode ='$barcode'";
        $statement = $pdo->prepare($query);
        $statement->execute();


        $query="INSERT INTO tbl_borrow_tools(barcode,status_, employee_id,check_out_date,check_in_date)
                VALUEs('$barcode','Not Returned','$employee_id','$check_out_date','$check_in_date')";
        $statement = $pdo->prepare($query);
        $statement->execute();

        header("Location:C_Check.php");
    }
 
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }
}

?>
