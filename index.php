<?php
/** Get the API URL **/
define("URL_API", "http://krillo22.caupo.se");
/** Get the API URL **/
/** Get the Page URL **/
define("URL", "http://prov.em4.se/magento/");
/** Get the Page URL **/
/** **/
define('UTF8_ENABLED', TRUE);
/** **/
require_once('header.php');
require_once('footer.php');
require_once('magento.php');
require_once('functions.php');
/** Get Header and print it out **/
$header = new header();
echo $header->get();
/** Get Header and print it out **/
/** Get the Magneto API  **/
$magento = new magento();
/** Get the Magneto API  **/
/** Get the functions **/
$functions = new functions();
//$functions->error();
/** Get the functions **/
/** Check the Pages **/
$page = (isset($_GET['page'])) ? $_GET['page'] : 0;
$page = $functions->html($page);
/** Check the Pages **/ 
switch ($page) {
    case "edit":
    
    	if(isset($_GET['sku'])){
		    $product_sku = $functions->html($_GET['sku']);
			$result = $magento->getproducts($product_sku);
		}else{
			header("Location: ".URL."index.php");
			die();
		}
		
		if (isset($_POST['submit'])) {
		 		
		 	   $product_name = $functions->html($_POST['product_name']);
		 	   $product_sku = $functions->html($_POST['product_sku']);
		 	   $product_price = $functions->html($_POST['product_price']);
		 		
		 	   if(!empty($product_name) && !empty($product_sku) && !empty($product_price)){
		        	if ($functions->check_product_name($product_name)) {
						$errors = "";
		                $errors.= $functions->check_product_name($product_name);
		            } elseif ($functions->check_product_sku($product_sku)) {
			            $errors = "";
		                $errors.= $functions->check_product_sku($product_sku);
		            }elseif ($functions->check_product_price($product_price)) {
			            $errors = "";
		                $errors.= $functions->check_product_price($product_price);
		            } else {
		                echo $magento->edit($product_name,$product_sku,$product_price);
		               	header("Location: ".URL."index.php?mess=success");	
		            }
		        } else {
			        $errors = "";
		            $errors .=  "All fields must be filled in!";
		        }
		 	   
		 	
		}

?>	
	<main role="main" class="container">	
	<?php 
		$errors = (isset($errors)) ? $errors : 0;
		if ($errors) { 
	?>	<div class="alert alert-danger" role="alert"><?php echo $errors; ?></div>
	<?php } ?>
      <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded box-shadow">
        <div class="lh-100">
          <h6 class="mb-0 text-white lh-100">Magento system </h6>
          <small></small>
        </div>
      </div> 
      	<div class="form-group">
	      	<form method="post" action="index.php?page=edit&sku="<?php echo $product_sku; ?>"" class="task_form">
		      	 <div class="row">
			  	 	<div class="col">
			  	 		<input class="form-control" type="text" name="product_name" value="<?php echo $result->name; ?>" placeholder="Name">
			  	 	</div>
			  	  	<div class="col">
			  	  		<input class="form-control" type="text" name="product_sku" value="<?php echo $result->sku; ?>" placeholder="Sku">
			  	  	</div>
			  	 	<div class="col">
			  	 		<input class="form-control" type="text" name="product_price" value="<?php echo $result->price; ?>" placeholder="Price">
			  	 	</div>
		      	 </div>
			<button type="submit" name="submit" class="btn btn-warning mb-2 submit-button-e">Save</button>
		</div> 
    </main>
<?
    break;
    case "remove":
	    if(isset($_GET['sku'])){
		    $product_sku = $functions->html($_GET['sku']);
			$result = $magento->remove($product_sku);
			header("Location: ".URL."index.php?mess=delete");
			die();
		}else{
			header("Location: ".URL."index.php");
			die();
		}
    break;
    default:
		/** Get data from Class Getlist **/		
		$result = $magento->getlist();		
	
	 	if (isset($_POST['submit'])) {
		 		
		 	   $product_name = $functions->html($_POST['product_name']);
		 	   $product_sku = $functions->html($_POST['product_sku']);
		 	   $product_price = $functions->html($_POST['product_price']);
		 		
		 	   if(!empty($product_name) && !empty($product_sku) && !empty($product_price)){
			 	   
				if ($functions->check_product_name($product_name)) {
						$errors = "";
		                $errors.= $functions->check_product_name($product_name);
		            } elseif ($functions->check_product_sku($product_sku)) {
			            $errors = "";
		                $errors.= $functions->check_product_sku($product_sku);
		            }elseif ($functions->check_product_price($product_price)) {
			            $errors = "";
		                $errors.= $functions->check_product_price($product_price);
		            } else {
		                echo $magento->add($product_name,$product_sku,$product_price);
		               	header("Location: ".URL."index.php?mess=success");	
		            }
		        } else {
			        $errors = "";
		            $errors .=  "All fields must be filled in!";
		        }
		 	 
		 	 
 		}
 			
			?>
    <main role="main" class="container">
	<?php 
		$errors = (isset($errors)) ? $errors : 0;
		if ($errors) { 
	?>
		<div class="alert alert-danger" role="alert"><?php echo $errors; ?></div>
	<?php } ?>
	<?php 
	$mess = (isset($_GET['mess'])) ? $_GET['mess'] : 0;
	$mess = $functions->html($mess);
	
	switch ($mess){
    case "delete":?>
	   	<div class="alert alert-info" role="alert">The product has been deleted</div>
	    <?php 
		break;
	case "success": 
	?>
    <div class="alert alert-info" role="alert">The product has been updated</div>
    <?php 
		break;
    
	}
	?>
      <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded box-shadow">
        <div class="lh-100">
          <h6 class="mb-0 text-white lh-100">Magento system </h6>
          <small></small>
        </div>
      </div> 
      	<div class="form-group">
	      	<form method="post" action="index.php" class="task_form">
		      	 <div class="row">
			  	 	<div class="col">
			  	 		<input class="form-control" type="text" name="product_name" value="" placeholder="Name">
			  	 	</div>
			  	  	<div class="col">
			  	  		<input class="form-control" type="text" name="product_sku" value="" placeholder="Sku">
			  	  	</div>
			  	 	<div class="col">
			  	 		<input class="form-control" type="text" name="product_price" value="" placeholder="Price">
			  	 	</div>
		      	 </div>
						<button type="submit" name="submit" class="btn btn-warning mb-2 submit-button-e">Save</button>
		</div> 
      <div class="my-3 p-3 bg-white rounded box-shadow">
              <div class="table-responsive">
            
	    <?php
		echo "<table class='table table-striped table-sm'>
			<tr>
			<td>ID</td>
			<td>Name</td>
			<td>Sku</td>
			<td>Price</td>
			<td>Action</td>
			</tr>";
				 
		foreach ($result->items as $item) {
	        echo "<tr>";
	        echo "<td>".$item->id."</td>";
	        echo "<td>".$item->name."</td>";
	        echo "<td>".$item->sku."</td>";
	        echo "<td>".$item->price."</td>";
	        echo "<td><a href=".URL."?page=edit&sku=".$item->sku."><i class='fa fa-pencil' aria-hidden='true'></i></a> <a href=".URL."?page=remove&sku=".$item->sku."><i class='fa fa-trash' aria-hidden='true'></i></a></td>";
	        echo "</tr>";
    	}
			
		echo "</table>     </div>
           </div>
         </main>";
 }
/** Get Footer and print it out **/
$footer = new footer();
echo $footer->get();
/** Get Footer and print it out **/
?>