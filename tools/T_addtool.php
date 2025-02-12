<?php

include_once 'connectdb.php';
session_start();



if($_SESSION['useremail']==""){

  header('location:../index.php');
  
}

if($_SESSION['role']=="Admin"){
    include_once'header.php';
}

if(isset($_POST['btnsave'])){

    $barcode=$_POST['txtbarcode'];
    $tools_name=$_POST['txttooltname'];
    $location=$_POST['txtlocation'];
    $description=$_POST['txtdescription'];
    $price=$_POST['txtprice'];
    $status=$_POST['txtstatus'];
    $available_quantity=$_POST['txtavail_qty'];

    //Image Code or File Code Start Here..
    $f_name        =$_FILES['myfile']['name'];
    $f_tmp         =$_FILES['myfile']['tmp_name'];
    $f_size        =$_FILES['myfile']['size'];
    $f_extension   =explode('.',$f_name);
    $f_extension   =strtolower(end($f_extension));
    $f_newfile     =uniqid().'.'. $f_extension;   
    
    $store = "tool_images/".$f_newfile;
        
    if($f_extension=='jpg' || $f_extension=='jpeg' ||   $f_extension=='png' || $f_extension=='gif'){
        
        if($f_size>=1000000 ){
                
            $_SESSION['status']="Max file should be 1MB";
            $_SESSION['status_code']="warning";
            
        }
        else{
                
            if(move_uploaded_file($f_tmp,$store)){

                $tool_image=$f_newfile;

                if(empty($barcode)){

                    $insert=$pdo->prepare("insert into tbl_tools (tools_name,location,description,price,status,available_quantity,image) 
                    values(:name,:location,:description,:price,:status,:aq,:img)");

                    // $insert->bindParam(':barcode',$barcode);
                    $insert->bindParam(':name',$tools_name);
                    $insert->bindParam(':location',$location);
                    $insert->bindParam(':description',$description);
                    $insert->bindParam(':price',$price);
                    $insert->bindParam(':status',$status);
                    $insert->bindParam(':aq',$available_quantity);
                    $insert->bindParam(':img',$tool_image);
                    
                    $insert->execute();

                    $newbarcode = rand(1000000000000, 9999999999999);

                    $update=$pdo->prepare("update tbl_tools SET barcode='$newbarcode' where barcode='".$barcode."'");

                    if($update->execute()){

                        $_SESSION['status']="Tool Inserted Successfully";
                        $_SESSION['status_code']="success";
                    }else{
                        $_SESSION['status']="Tool Inserted Failed";
                        $_SESSION['status_code']="error";

                    }

                }
                else{
                    
                    if(isset($_POST['txtbarcode'])){

                        $select=$pdo->prepare("select barcode from tbl_tools where barcode='$barcode'");

                        $select->execute();
                
                        if($select->rowCount()>0){
                
                        $_SESSION['status']="Barocde Already Exists";
                        $_SESSION['status_code']="warning";
                
                        }
                        else{

                        $insert=$pdo->prepare("insert into tbl_tools (barcode,tools_name,location,description,price,status,available_quantity,image) 
                        values(:barcode,:name,:location,:description,:price,:status,:qty,:aq,:img)");

                        $insert->bindParam(':barcode',$barcode);
                        $insert->bindParam(':name',$tools_name);
                        $insert->bindParam(':location',$location);
                        $insert->bindParam(':description',$description);
                        $insert->bindParam(':price',$price);
                        $insert->bindParam(':status',$status);
                        $insert->bindParam(':aq',$available_quantity);
                        $insert->bindParam(':img',$tool_image);
                        
                        if($insert->execute()){
                            $_SESSION['status']="Tool Inserted Successfully";
                            $_SESSION['status_code']="success";
                        }else{
                            $_SESSION['status']="Tool Inserted Failed";
                            $_SESSION['status_code']="error";

                        }
                    }

                    }
                  
                }  
            } 
                
        }   
        
    }else
    {
        $_SESSION['status']="only jpg, jpeg, png and gif can be upload";
        $_SESSION['status_code']="warning";

    } 
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Add Tool</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active"><a href="T_listoftool.php">List of Inventory</a></li> 
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
            

            <div class="card card-primary card-outline">
                <div class="card-header">
                <h5 class="m-0">Tools Inventory</h5>
                </div>
            
                
                <form action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label >Barcode</label>
                                <input type="number" class="form-control" placeholder="Enter Barcode" name="txtbarcode" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label >Tool Name</label>
                                <input type="text" class="form-control" placeholder="Enter Name" name="txttooltname" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                 <label>Location</label>
                                 <select class="form-control" name="txtlocation" required>
                                    <option value="" disabled selected>Select Location</option>
                                    <option>A1</option> 
                                    <option>A2</option>     
                                    <option>B1</option>     
                                    <option>B2</option>          
                                 </select>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" placeholder="Enter Description" name="txtdescription" rows="4" required></textarea>
                            </div>

                        </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label >Tool Price</label>
                            <input type="number" min="1" step="any" class="form-control" placeholder="Tool Price" name="txtprice" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                                 <label>Status</label>
                                 <select class="form-control" name="txtstatus" required>
                                    <option value="" disabled selected>Status</option>
                                    <option>Available</option> 
                                    <option>Maintenance</option>           
                                 </select>
                        </div>
                        
                        <div class="form-group">
                            <label >Available Quantity</label>
                            <input type="number" min="1" step="any" class="form-control" placeholder="Available Quantity" name="txtavail_qty" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label >Tool image</label>
                            <input type="file" class="input-group"  name="myfile" required>
                            <p>Upload image</p>
                        </div>
                        
                    </div>
                </div>

                </div>
                    <div class="card-footer">
                        <div class="text-center">
                        <button type="submit" class="btn btn-primary" name="btnsave">Save Product</button></div>
                    </div>
                    
                </form>

            </div>
        
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php

include_once "footer.php";

?>

<?php
  if(isset($_SESSION['status']) && $_SESSION['status']!='')
 
  {
?>
<script>
     Swal.fire({
        icon: '<?php echo $_SESSION['status_code'];?>',
        title: '<?php echo $_SESSION['status'];?>'
      });

</script>
<?php
unset($_SESSION['status']);
  }
?>