<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="de-DE">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>Analytics | Rothauer Websites</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>

<?php

	require 'config.php';

	// first period has to be chosen
	if (!isset($_GET['period'])) {
		echo $gaw->getPeriodLinks();
		echo '</body></html>';
		return;
	}
  
  $gaw->connect();
  
  $today = $gaw->getToday();
  $endDate = $today;
  $startDate = $gaw->getStartDate($_GET['period']);
  
  $outputNavi = '<div class="header">';
  	$outputNavi .= '<a href="javascript:void(0);">'.$startDate .' - '. $endDate.'</a>';
  	$outputNavi .= $gaw->getPeriodLinks();
  $outputNavi .= '</div>';
  echo $outputNavi;
  
?>

<div id="wrapper" style="width:<?php echo $gaw->getWrapperWidth();?>">
  
<?php

	$output = '';

  foreach($gaw->getProfiles() as $profileId => $profile) {
  
    $outputRequests = '';
    $outputRequestData = '';
    
    foreach($gaw->getRequests($profileId) as $key => $request) {
    	
      $results = $gaw->getReportData($profileId, $request['dimensions'], $request['metrics'], $request['sort'], $request['filter'], $startDate, $endDate);
      
      //collect total data
      if ($key == 'pages') {
      	$totalData = $gaw->getGa()->getMetrics();
      	$totalVisits = $totalData['visits'];
      	$totalPageviews = $totalData['pageviews'];
      	$totalUniquePageviews = $totalData['uniquePageviews'];
      }
      
      $outputRequestHead = '<table>';
        $outputRequestHead .= '<tr>';
          foreach($request['metrics'] as $metric) {
          	$outputRequestHead .= '<th title="'.$metric.'">'.substr($metric, 0, 2).'</th>';
          }
          $outputRequestHead .= '<th>'.$request['name'].'</th>';
        $outputRequestHead .= '</tr>';
        
        $outputRequestData = '';
        foreach($results as $result) {
            
          if (isset($request['viewFilter']) && preg_match('/'.$request['viewFilter'].'/', $result)) continue;
        
          $outputRequestData .= '<tr>';
            
            foreach($request['metrics'] as $metric) {
            	$getMethod = 'get'.ucfirst($metric);
            	$outputRequestData .= '<td>'.$gaw->formatMetric($metric, $result->$getMethod()).'</td>';
            }
            
            $outputRequestData .= '<td>'.$gaw->getRequestOutput($key, $result).'</td>';
            
          $outputRequestData .= '</tr>';
        
        }
        
        $outputRequestHead .= $outputRequestData;
        $outputRequestHead .= '</table>';
        
        //if no data available (viewFilter), do not show head
        if ($outputRequestData == '') {
          $outputRequestHead = '';
        }
        
        $outputRequests .= $outputRequestHead;
      
    }
    
    $outputHeader = '<div class="profile-box">';
    $outputHeader .= '<h1>'.$profile['name'].'<span>'.$totalVisits . ' / '. $totalPageviews . ' / ' . $totalUniquePageviews.'</span></h1>';
    $outputFooter = '</div>';
    
    $output .= $outputHeader . $outputRequests . $outputFooter;
      
  }
  
  echo $output;
  
  ?>  

  </div>

</body>
</html>