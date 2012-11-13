MPGAT
=====

/**
 *   Multiple Profile Google Analytics Tool - MPGAT
 * 
 * - no warranty for anything, usage at own risk
 * - licenced under GPL http://www.gnu.org/licenses/gpl.html
 * 
 * - provides an overview of all your different google analytics profiles
 * - no more need to click around in google analytics just to check today's visitors of all projects
 * - provides a useful grid of your profiles
 * - highly customizeable
 * - well defined default values  
 * - metrics and dimensions can be found here: http://ga-dev-tools.appspot.com/explorer/
 * 
 *  USAGE
 *  1) rename config.default.php to config.php
 *  2) change the $profiles array to your profile data 
 *  3) call index.php 
 *  curl must be enabled 
 * 
 *  CAUTION
 *  if you use this program for a lot of profiles with a lot of dimensions, a lot of
 *  requests to google analytics are fired: you can get an error message for that and you will have
 *  to wait some time in order to use this program again
 *  i did not have any problems for about 20 profiles with 5 dimensions (average) => 100 requests, fired max 5 times a day
 *  that's enough to keep track of what's going on on your sites
 *  for detailed information use google anayltics web interface found on http://www.google.com/analytics  
 *
 * requires gapi.class.php (http://code.google.com/p/gapi-google-analytics-php-interface/)
*/

Mario Rothauer <office@rothauerwebsites.com>