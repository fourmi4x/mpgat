Multiple Profile Google Analytics Tool - MPGAT
==============================================

/**
 * 
 * Copyright (c) 2012 Mario Rothauer
 * www.rothauerwebsites.com
 * http://github.com/mrothauer/mpgat
 *
 * @author Mario Rothauer <office@rothauerwebsites.com>
 * @version 1.0
 * @license MIT
 * 
 * - no warranty for anything, usage at own risk
 * 
 * - provides an overview of all your different google analytics profiles
 * - no more need to click around in google analytics just to check today's visitors of all projects
 * - provides a useful grid of your profiles
 * - highly customizeable
 * - well defined default values  
 * - metrics and dimensions can be found here: http://ga-dev-tools.appspot.com/explorer/
 * 
 * USAGE
 * 1) download gapi.class.php from http://code.google.com/p/gapi-google-analytics-php-interface and copy it in same folder
 * 2) rename config.default.php to config.php
 * 3) change the $profiles array to your profile data
 * 4) enable curl (if not already enabled) 
 * 5) call index.php 
 * 6) click on a link on the top left corner
 * 
 * CAUTION
 * if you use this program for a lot of profiles with a lot of dimensions, a lot of
 * requests to google analytics are fired: you can get an error message for that and you will have
 * to wait some time in order to use this program again
 * i did not have any problems for about 20 profiles with 5 dimensions (average) => 100 requests, fired max 5 times a day
 * that's enough to keep track of what's going on on your sites
 * for detailed information use google anayltics web interface found on http://www.google.com/analytics  
 * 
 */