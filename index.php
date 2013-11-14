<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="de-DE">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>MPGAT - Multiple Profile Google Analytics Tool | Mario Rothauer</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>

    <div class="topbar">
        <div class="maintitle">Multiple profile google analytics tool</div>
        <div class="switch"><a href="graphs.php">Switch to graphical dashboard</div>
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
  
?>

<div id="wrapper" style="width:<?php echo $mpgat->getWrapperWidth();?>">
  
    <?php
        /* -------- Tables generation -------- */
        $output = '';
    
        foreach($mpgat->getProfiles() as $profileId => $profile) {
            
            $mpgat->connect($profile['email'], $profile['password']);
            
            $outputRequests = '';
            $outputRequestData = '';
            
            foreach($mpgat->getRequests($profileId) as $key => $request) {
                
              $results = $mpgat->getReportData($profileId, $request['dimensions'], $request['metrics'], $request['sort'], $request['filter'], $startDate, $endDate);
              
              //collect total data
              if ($key == 'pages') {
                  $totalData = $mpgat->getGa()->getMetrics();
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
                          $outputRequestData .= '<td>'.$mpgat->formatMetric($metric, $result->$getMethod()).'</td>';
                      }
                    
                      $outputRequestData .= '<td>'.$mpgat->getRequestOutput($key, $result).'</td>';
                    
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