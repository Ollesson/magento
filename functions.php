<?php
 /**
 * Functions
 */
 class functions  {
 
 	public function __construct(){
	}
	
	public function random_id($digits){
			return rand(pow(10, $digits-1), pow(10, $digits)-1);	
	}
	
	public function error(){
		// Turn off all error reporting
		error_reporting(1);
		// Report simple running errors
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		
		// Reporting E_NOTICE can be good too (to report uninitialized
		// variables or catch variable name misspellings ...)
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		
		// Report all errors except E_NOTICE
		error_reporting(E_ALL & ~E_NOTICE);
		
		// Report all PHP errors (see changelog)
		error_reporting(E_ALL);
		
		// Report all PHP errors
		error_reporting(-1);
		
		// Same as error_reporting(E_ALL);
		ini_set('error_reporting', E_ALL);
	 
		
	}

	public function html($html){
		
		return htmlentities($html);
		
	}
	
	public function generateSeoURL($string, $wordLimit = 0){
	    $separator = '-';
	    
	    if($wordLimit != 0){
	        $wordArr = explode(' ', $string);
	        $string = implode(' ', array_slice($wordArr, 0, $wordLimit));
	    }
	
	    $quoteSeparator = preg_quote($separator, '#');
	
	    $trans = array(
	        '&.+?;'                    => '',
	        '[^\w\d _-]'            => '',
	        '\s+'                    => $separator,
	        '('.$quoteSeparator.')+'=> $separator
	    );
	
	    $string = strip_tags($string);
	    foreach ($trans as $key => $val){
	        $string = preg_replace('#'.$key.'#i'.(UTF8_ENABLED ? 'u' : ''), $val, $string);
	    }
	
	    $string = strtolower($string);
	
	    return trim(trim($string, $separator));
	}

	public static function check_product_name($product_name){
	
        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $product_name))
        {
            return $product_namn_error = "Enter correct product name, only letters, numbers and spaces are allowed";
        }
        
    }
    
    public static function check_product_price($product_price) {
	    
        if (!preg_match("/^[1-9][0-9]*$/", $product_price))
        {
            return $product_price_error = "Enter correct price, only numbers are allowed";
        }
    }
    
    public static function check_product_sku($product_sku){
	    
        if (!preg_match("/^[a-z0-9]+$/i", $product_sku))
        {
            return $product_sku_error = "Enter a correct sku value. Only numbers and letters are allowed, no spaces";
        }
    }
	
 
 }
 