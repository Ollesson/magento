<?php
	/**
	* Header
	*/
	class Header {

		public function __construct(){
			
		
		}

		public function get(){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<title>My first styled page</title>
</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css?ver=4.6.3">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo URL; ?>css/style.css" rel="stylesheet"> 
<body class="bg-light">
<?
		
		
		}
	
	}

?>