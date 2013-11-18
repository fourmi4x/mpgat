<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="de-DE">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>MPGAT - Multiple Profile Google Analytics Tool | Mario Rothauer</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>
    <script type="text/javascript">google.load("visualization", "1", {packages:["corechart"]});</script>

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
    
    //Divs that will hold the pie charts
    print "<div class='chart' id='" . $profileId . "'></div>";
    
    $mpgat->connect($profile['email'], $profile['password']);

    // cf. https://code.google.com/p/gapi-google-analytics-php-interface/wiki/GAPIDocumentation
    $mpgat->getGa()->requestReportData($profileId, array('date','month'), array('visitors'), array('date'), null, $startDate, $endDate, 1, 100);

?>

        <script type='text/javascript'>

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Date');
            data.addColumn('number', 'Unique Visitors');
            
            <?php
            foreach($mpgat->getGa()->getResults() as $result){ ?>
                
                var thedate = "<?php print $result->getDate(); ?>";
                var year = thedate.substring(0, 4);
                var month = thedate.substring(4, 6) - 1; // subtract 1 since javascript months are zero-indexed
                var day = thedate.substring(6, 8);
                
                data.addRow([new Date(year, month, day), <?php print $result->getVisitors(); ?>]);
                
            <?php } ?>
                
            // Set chart options
            var options = {'title':'<?php print $profile['name']; ?>',
                            'titleTextStyle': {
                                'fontSize': 22,
                            },
                           'width':775,
                           'height':350,
                           'hAxis': {
                                'format': 'd/M/yy'
                           },
                           'strictFirstColumnType': false,
                           'trendlines': {
                            0: {
                              //type: 'exponential',
                              color: 'darkred',
                              visibleInLegend: false,
                              lineWidth: 2,
                              opacity: 0.8
                            }
                          },
                          'legend': {
                                'position': 'bottom',
                          }
                        };
                        
            // Nice dates         
            var mydateformatter = new google.visualization.DateFormat({pattern: 'd/M/yy'});
            mydateformatter.format(data, 0);
            
            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.ColumnChart(document.getElementById("<?php print $profileId; ?>"));
            chart.draw(data, options);

            </script>

         <?php }; ?>

    
</body>