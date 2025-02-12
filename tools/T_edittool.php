<?php
include_once 'connectdb.php';
session_start();
if($_SESSION['useremail']==""  OR $_SESSION['role']=="User"){

  header('location:../index.php');
  
  }

if($_SESSION['role']=="Admin"){
    include_once'header.php';
}


$id = $_GET['id'];

$select = $pdo->prepare("select * from tbl_tools where barcode=$id");
$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);

$barcode_db=$row['barcode'];
$toolsname_db=$row['tools_name'];
$location_db=$row['location'];
$description_db=$row['description'];
$price_db=$row['price'];
$status_db=$row['status'];
$aq_db=$row['available_quantity'];
$image_db=$row['image'];


if(isset($_POST['btneditproduct'])){

  // $barcode_txt       =$_POST['txtbarcode'];
  $tools_name=$_POST['txttooltname'];
  $location=$_POST['txtlocation'];
  $description=$_POST['txtdescription'];
  $price=$_POST['txtprice'];
  $status=$_POST['txtstatus'];
  $available_quantity=$_POST['txtavail_qty'];
  
  //Image Code or File Code Start Here..
  $f_name        =$_FILES['myfile']['name'];

 if(!empty($f_name)){

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
    
            $f_newfile;

            $update = $pdo->prepare("update tbl_tools set tools_name=:tn , location=:location , description=:description , price=:price , 
            status=:status,available_quantity=:aq, image=:image where barcode=$id");

            $update->bindParam(':tn',$tools_name);
            $update->bindParam(':location',$location);
            $update->bindParam(':description',$description);
            $update->bindParam(':price',$price);
            $update->bindParam(':status',$status);
            $update->bindParam(':aq',$available_quantity);
            $update->bindParam(':image',$f_newfile);
            
            
            if($update->execute()){
            

                $_SESSION['status']="Product Updated Successfully With New Image";
                $_SESSION['status_code']="success";
            }else{
                $_SESSION['status']="Product Update Failed";
                $_SESSION['status_code']="error";
            
            }

        } 

    } 
}

}

else{

    $update = $pdo->prepare("update tbl_tools set tools_name=:tn , location=:location , description=:description , price=:price , 
    status=:status,available_quantity=:aq, image=:image where barcode=$id");
  
    $update->bindParam(':tn',$tools_name);
    $update->bindParam(':location',$location);
    $update->bindParam(':description',$description);
    $update->bindParam(':price',$price);
    $update->bindParam(':status',$status);
    $update->bindParam(':aq',$available_quantity);
    $update->bindParam(':image',$image_db);


if($update->execute()){
  $_SESSION['status']="Product Updated Successfully";
  $_SESSION['status_code']="success";

}
else{
  $_SESSION['status']="Product Update Failed";
  $_SESSION['status_code']="error";

}

}

}

$select = $pdo->prepare("select * from tbl_tools where barcode=$id");
$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);


$barcode_db=$row['barcode'];
$toolsname_db=$row['tools_name'];
$location_db=$row['location'];
$description_db=$row['description'];
$price_db=$row['price'];
$status_db=$row['status'];
$aq_db=$row['available_quantity'];
$image_db=$row['image'];

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0">Admin Dashboard</h1> -->
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Starter Page</li> -->
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
        

        <div class="card card-success card-outline">
            <div class="card-header">
              <h5 class="m-0">Edit Product</h5>
            </div>

            <form action="" method="post" name="formeditproduct" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label >Barcode</label>
                            <input type="text" class="form-control" value="<?php echo $barcode_db;?>" placeholder="Enter Barcode" name="txtbarcode" autocomplete="off" disabled>
                        </div>

                        <div class="form-group">
                            <label >Tool Name</label>
                            <input type="text" class="form-control" value="<?php echo $toolsname_db;?>" placeholder="Enter Name" name="txttooltname" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label >Location</label>
                            <input type="text" class="form-control" value="<?php echo $location_db;?>" placeholder="Enter Location" name="txtlocation" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" placeholder="Enter Description" name="txtdescription" rows="4" required><?php echo $description_db;?> </textarea>
                        </div>

                    </div>

                        <div class="col-md-6">
                            
                            <div class="form-group">
                                <label >Available Quantity</label>
                                <input type="number" max="1" min="0" step="any" class="form-control" value="<?php echo $aq_db;?>" placeholder="Available Quantity" name="txtavail_qty" autocomplete="off" required>
                            </div>
                            
                            <div class="form-group">
                                <label >Tool Price</label>
                                <input type="number" min="1" step="any" class="form-control" value="<?php echo $price_db;?>" placeholder="Enter Stock" name="txtprice" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="txtstatus" required>
                                    <option value="" disabled selected>Select Category</option>
                         
                                        <?php
                                        $select=$pdo->prepare("select * from tbl_status order by sid desc");
                                        $select->execute();

                                        while($row=$select->fetch(PDO::FETCH_ASSOC))
                                        {
                                        extract($row);

                                        ?>
                                        <option <?php if($row['status']==$status_db ){ ?>
                                            
                                            selected="selected"
                                            
                                            
                                            <?php }?>  ><?php echo $row['status'];?></option>

                                        <?php

                                        }

                                        ?>
                
                                </select>
                            </div>

                            <div class="form-group">
                                <label >Tool Image</label><br />
                                <image src="tool_images/<?php echo $image_db;?>" class="img-rounded" width="50px" height="50px/">
                                <input type="file" class="input-group"  name="myfile">
                                <p>Upload image</p>
                            </div>

                        </div>
                                    
                    </div>

                </div>

                <div class="card-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success" name="btneditproduct">Update Product</button>
                    </div>
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
  if(isset($_SESSION['status']) && $_SESSION['status']!=''){
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