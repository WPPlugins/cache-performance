
<?php 
	$plugin_array = array(                          
	  array(
	    'slug' => 'wp-image-compression',
	  ),
	  array(
	    'slug' => 'wp-disable',
	  ),
	  array(
	    'slug' => 'autoptimize'
	  )
	);
	                       
	if(class_exists('Optimisationio_ConnectInstaller')){
	  Optimisationio_ConnectInstaller::init($plugin_array);
	}
 ?>
