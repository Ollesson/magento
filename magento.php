<?php
	/**
	* A link to Magento does the following
	* Get a Token
	* ADD a new products
	* Edit a products
	* Remove a products
	* By: Emil Ohlsson
	* URL: http://prov.em4.se/magento/
	*/

	
	class magento {

		protected $token;
		/* Make a Token */
		public function __construct(){
			
			try{

					/** Url to the customer admin page **/
					$apiURL = "".URL_API."/rest/V1/integration/admin/token";
						 
					/** The API KEY Username and Password **/
					$data = array("username" => "demo", "password" => "demo1234!");
					$data_string = json_encode($data);
					 
					$ch = curl_init($apiURL);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Content-Length: ".strlen($data_string)));
					$token = curl_exec($ch);
					$token =  json_decode($token);
					
					/** Check token **/
					if(!$token){
						throw new Exception('Check your login details your token is wrong');
					}
				
					/** Get the token from the Magento Page **/
					$this->token = array("Authorization: Bearer ".$token, "Content-Type: application/json");
					
			} catch (Exception $e) {
				echo 'Error: ',  $e->getMessage(), "\n";
			}
			
		}
		/* Make a Token */
		/*Get all products from the shop */
		public function getlist(){
			try{
					$requestUrl = "".URL_API."/rest/V1/products/?searchCriteria";
					$ch = curl_init($requestUrl);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $this->token);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$result = curl_exec($ch);
			 	    curl_close($ch);
					$result =  json_decode($result);
					
					return $result;
			
			} catch (Exception $e) {
				 echo 'Error: ',  $e->getMessage(), "\n";
			}
		}
		/* Get all products from the shop  */
		/* Load a products by SKU  */
		public function getproducts($product_sku){
			try{
					$requestUrl = "".URL_API."/rest/V1/products/".$product_sku."";
					$ch = curl_init($requestUrl);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $this->token);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$result = curl_exec($ch);
			 	    curl_close($ch);
					$result =  json_decode($result);
					
					if(!$result){
				                throw new Exception("Could not load the product");
				    }
					
					return $result;
			
			} catch (Exception $e) {
				 echo 'Error: ',  $e->getMessage(), "\n";
			}
		}
				/* Load a products by SKU  */
		/* Remove a products With a SKU */
		public function remove($product_sku){
			try{
					$requestUrl = "".URL_API."/rest/V1/products/".$product_sku."";
				    $ch = curl_init($requestUrl);
				    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
				    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->token);
				    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$result = curl_exec($ch);
					curl_close($ch);
					$result =  json_decode($result);
					
					return $result;
			
			} catch (Exception $e) {
				 echo 'Error: ',  $e->getMessage(), "\n";
			}

		}
		/* Remove a products With a SKU */
		/* Add a products $name, $sku, $price */
		public function add($product_name,$product_sku,$product_price){
			try{
				
				/** Get functions **/
				$functions = new functions();
				/** Get functions **/
		
				/**** MÅSTE ÄNDRA I KODEN SÅ DET BLIR BÄTTRE ****/
		
					$products_data = json_encode(array(
			                'product' => array(
			                    'id' => $functions->random_id(4),
			                'sku' => $product_sku,
			                'name' => $product_name,
			                'attribute_set_id' => 4,
			                'price' => $product_price,
			                'status' => 1,
			                'visibility' => 4,
			                'type_id' => 'simple',
			                    'custom_attributes' => array(
			                        array(
			                            'attribute_code' => 'description',
			                            'value' => 'en text om produkten',
			                        ),
			                        array(
			                            'attribute_code' => 'las',
			                            'value' => '49',
			                        ),
			                        array(
			                            'attribute_code' => 'options_container',
			                            'value' => 'container2',
			                        ),
			                        array(
			                            'attribute_code' => 'required_options',
			                            'value' => '0',
			                        ),
			                        array(
			                            'attribute_code' => 'has_options',
			                            'value' => '0',
			                        ),
			                        array(
			                            //url /test.html är redan upptagen
			                            'attribute_code' => 'url_key',
			                            'value' => $functions->generateSeoURL($product_name),
			                        ),
			                        array(
			                            'attribute_code' => 'tax_class_id',
			                            'value' => '2',
			                        ),
			                    )
			                )
			            ));
			            
			            print_r($products_data);
			            $requestUrl = "".URL_API."/rest/V1/products/";
			            $ch = curl_init($requestUrl);
			            curl_setopt($ch, CURLOPT_POST, true);
			            curl_setopt($ch, CURLOPT_POSTFIELDS, $products_data);
			            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->token);
			            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$result = curl_exec($ch);
						curl_close($ch);
						$result =  json_decode($result);
						
					    if(!$result){
				                throw new Exception("There was something wrong checking the code");
				        }
						
						return $result;
					
			} catch (Exception $e) {
				echo 'Error: ',  $e->getMessage(), "\n";
			}
			
		}
		/* Add a products */
		/* Edit a products */
		public function edit($product_name,$product_sku,$product_price){
			try {
			            $product_data = json_encode(array(
			                'product' => array(
			                    'name' => $product_name,
			                    'price' => $product_price,
			                )
			            ));
			            //
			            $requestUrl = "".URL_API."/rest/V1/products/".$product_sku."";
			            $ch = curl_init($requestUrl);
			            //PUT vid update
			            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			            curl_setopt($ch, CURLOPT_POSTFIELDS, $product_data);
			            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->token);
			            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			            $response_json = curl_exec($ch);
			            curl_close($ch);
			           
			            $result = json_decode($response_json, true);
			           
			            if(!$result)
			            {
			                throw new Exception("There was something wrong checking the code");
			            }
			            
			            return $result;
	            
	        } catch(Exception $e) {
	            echo "Error: " . $e->getMessage() . "\n";
	        }
		}	

	
	}
	