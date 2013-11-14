<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="de-DE">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>MPGAT - Multiple Profile Google Analytics Tool | Mario Rothauer</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
</head>
  

<body>
      
    <div class="topbar">
        <div class="maintitle">Multiple profile google analytics tool</div>
        <div class="switch"><a href="index.php">Switch to table dashboard</div>
    </div>       
    
    
<?php

require 'config.php';

/* -------- Period choice -------- */
// first period has to be chosen
if (!isset($_GET['period'])) {
    $outputNavi = '<div class="nav">';
        $outputNavi .= $mpgat->getPeriodLinks();
    $outputNavi .= '</div>';
    echo $outputNavi;
    return;
}

$today = $mpgat->getToday();
$endDate = $today;
$startDate = $mpgat->getStartDate($_GET['period']);

$outputNavi = '<div class="nav">';
    $outputNavi .= '<a href="javascript:void(0);">Current: '.$startDate .' - '. $endDate.'</a> --------- Change period: ';
    $outputNavi .= $mpgat->getPeriodLinks();
$outputNavi .= '</div>';
echo $outputNavi;


/* -------- Graphs generation -------- */
foreach($mpgat->getProfiles() as $profileId => $profile) {
    
    $mpgat->connect($profile['email'], $profile['password']);
    
    //https://code.google.com/p/gapi-google-analytics-php-interface/wiki/GAPIDocumentation
    //$ga->requestReportData(59999293,array('date','month'),array('visitors'), array('date'), null, '2013-09-01', '2013-10-01', 1, 32);
    //cf. http://stackoverflow.com/questions/4835959/hourly-visits-data-from-google-analytics-api-and-gapi-class-php
    $mpgat->getGa()->requestReportData($profileId,array('date','month'),array('visitors'), array('date'), null, $startDate, $endDate, 1, 32);

    print "
        <!--Load the AJAX API-->

        <script type='text/javascript'>

          // Load the Visualization API and the piechart package.
          google.load('visualization', '1.0', {'packages':['corechart']});

          // Set a callback to run when the Google Visualization API is loaded.
          google.setOnLoadCallback(drawChart);

          // Callback that creates and populates a data table,
          // instantiates the pie chart, passes in the data and
          // draws it.
          function drawChart() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Unique Visitors');
            data.addRows([";
                //cf. http://stackoverflow.com/questions/5846879/google-analytics-api-get-specific-data-using-php
                foreach($mpgat->getGa()->getResults() as $result){
                     print "['" . $result->getDate() . "', " . $result->getVisitors() . "],";
                }
            print "]);
            
                           
            // Nice dates : can't get it to work...              
            var formatter_short = new google.visualization.DateFormat({pattern: 'dd/MM/yyyy'});
            formatter_short.format(data, 0);
            
            // Set chart options
            var options = {'title':'" . $profile['name'] . "',
                           'width':960,
                           'height':300,
                           // can't get nice dates to work here either
                           'hAxis': {
                                'format': 'dd/MM/yyyy'
                           }
                        };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.ColumnChart(document.getElementById('" . $profileId . "'));
            chart.draw(data, options);
          }
        </script>";
  };
  ?>
   
      
    <!-- Divs that will hold the pie charts -->
    <?php
    foreach($mpgat->getProfiles() as $profileId => $profile) {  
        print "<div class='chart' id='" . $profileId . "'></div>";
    }
    ?>
  </body>";