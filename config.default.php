<?php

  require 'mpgat.class.php';
  
  // Change your google analytics login data here
  $mpgat = new MPGAT();

  $profiles = array(
      
        // account 1, profile 1
        // Quick example with default configuration
        // The ID number below ("12345678") is the ID of your GA project.
        // You can find it using http://ga-dev-tools.appspot.com/explorer/
        12345678 => array(
            'email' => 'user@gmail.com',
            'password' => 'password',
            'name' => 'yourdomain1.com', // This is simply the name that will appear on your dashboard
            'predefinedRequests' => array('keywords', 'pages', 'referer', 'cities') // see mpgat.class.php for all available parameters
        ),

        // account 1, profile 2
        // Example with event tracking
        87654321 => array(
            'email' => 'user@gmail.com',
            'password' => 'password',
            'name' => 'yourdomain2.com',
            'predefinedRequests' => array('keywords', 'pages', 'referer', 'cities'),
            'customEventRequests' => array(
                 array(
                     'name' => 'your-event-name',
                     'filter' => 'eventAction==navigation', //just a filter example
                     'dimensions' => array('eventLabel') // dimensions to show
                 )
              )
        ),
      
        // account 2, profile 3
        53846354 => array(
                'email' => 'user@gmail.com',
                'password' => 'password',
                'name' => 'yourdomain3.com',
                'predefinedRequests' => array('keywords', 'pages', 'referer', 'cities')
        )
            
  );
  
  $mpgat->setProfiles($profiles);
  
?>