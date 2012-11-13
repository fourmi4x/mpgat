<?php

  require 'gapi.wrapper.class.php';
  
  //change your google analytics login data here
  $gaw = new GapiWrapper('user@gmail.com', 'password');

  $profiles = array(
  	
  	// quick example with default configuration	
  	12345678 => array(
  				'name' => 'yourdomain1.com'
  				,'predefinedRequests' => array('keywords', 'pages', 'referer', 'cities')
  	)

  	// example with event tracking
  	,87654321 => array(
	    'name' => 'yourdomain2.com'
	   ,'predefinedRequests' => array('keywords', 'pages', 'referer', 'cities')
	   ,'customEventRequests' => array(
	   		array(
	   				'name' => 'your-event-name'
	   			 ,'filter' => 'eventAction==navigation' //just a filter example
	   			 ,'dimensions' => array('eventLabel') // dimensions to show
	   		)
	  	)
  	
  	)
  	
  );
  
  $gaw->setProfiles($profiles);
  
?>