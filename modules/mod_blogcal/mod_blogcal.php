<?php
  /**
   * @version $Id: mod_blogcal.php 2008-10-13 00:00:00
   * @package Joomla
   * @copyright Copyright (C) 2008 julianna.homelinux.org. All rights reserved.
   * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
   * Joomla! is free software. This version may have been modified pursuant
   * to the GNU General Public License, and as distributed it includes or
   * is derivative of works licensed under the GNU General Public License or
   * other free or open source software licenses.
   * Author: Andrew Willis (http://www.julianna.homelinux.com)
   */

  /** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.view');
jimport( 'joomla.application.router');
jimport('joomla.html.html');
jimport('joomla.language.language');
jimport('joomla.environment.uri');
global $mainframe;
require_once('configuration.php');
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

// --------------------------------------------------------
// Parameter Extraction
$divclass       = trim( $params->get( 'mbdivclass_sfx', 'moduletable' ) );
$issecid        = trim( $params->get( 'secid' ) );
$linkBg         = trim( $params->get( 'linkbg') );
$currBg         = trim( $params->get( 'currbg') );
$currFontClr    = trim( $params->get( 'currfontclr'));
$secid          = intval( $params->get( 'secid') );
$access 	= !$mainframe->getCfg( 'shownoauth' );

$htmtitle       = trim( $params->get( 'mbtitle_sfx', 'h3' ) );
$firstdayofweek = intval( $params->get( 'firstdayofweek', 0 ) );
$monthyearformat= intval( $params->get( 'monthyearformat', 0 ) );
$abbrMonth      = intval( $params->get( 'monthname_width', 0 ) );
$abbrYear       = intval( $params->get( 'year_width', 1 ) );
//$debugOn 	= 0;
// End Parameter Extraction
// --------------------------------------------------------


/**      
 * Return part of a string, length and offset in characters
 * Compatible with mb_substr(), an UTF-8 friendly replacement for substr()
 */
function substr_utf8($str, $start , $length = NULL) {
  preg_match_all('/[\x01-\x7F]|[\xC0-\xDF][\x80-\xBF]|[\xE0-\xEF][\x80-\xBF][\x80-\xBF]/', $str, $arr);
	
  if (is_int($length))
    return implode('', array_slice($arr[0], $start, $length));
  else
    return implode('', array_slice($arr[0], $start));
}
# PHP Calendar (version 2.3), written by Keith Devens
# http://keithdevens.com/software/php_calendar
#  see example at http://keithdevens.com/weblog
# License: http://keithdevens.com/software/license

function generate_calendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array(), $monthyearformat){
  $first_of_month = gmmktime(0,0,0,$month,1,$year);
#remember that mktime will automatically correct if invalid dates are entered
# for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998
# this provides a built in "rounding" feature to generate_calendar()

  $day_names = array(); #generate all the day names according to the current locale
  for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) #January 4, 1970 was a Sunday
    $day_names[$n] = ucfirst(gmstrftime('%A',$t)); #%A means full textual day name

  list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month));
  $weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day
  // print month-year or year-month format dates
  if ($monthyearformat==1)
    $title   = $year.'&nbsp;'.htmlentities(ucfirst($month_nname), ENT_QUOTES, 'UTF-8');  
  else
    $title   = htmlentities(ucfirst($month_name), ENT_QUOTES, 'UTF-8').'&nbsp;'.$year;  #note that some locales don't capitalize month and day names

#Begin calendar. Uses a real <caption>. See http://diveintomark.org/archives/2002/07/03
  @list($p, $pl) = each($pn); @list($n, $nl) = each($pn); #previous and next links, if applicable
  if($p) $p = '<span class="calendar-prev">'.($pl ? '<a href="'.htmlspecialchars($pl, ENT_QUOTES, 'UTF-8').'">'.$p.'</a>' : $p).'</span>&nbsp;';
  if($n) $n = '&nbsp;<span class="calendar-next">'.($nl ? '<a href="'.htmlspecialchars($nl, ENT_QUOTES, 'UTF-8').'">'.$n.'</a>' : $n).'</span>';
  $calendar = '<table class="calendar">'."\n".
    '<caption class="calendar-month">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href, ENT_QUOTES, 'UTF-8').'">'.$title.'</a>' : $title).$n."</caption>\n<tr>";

  if($day_name_length){ #if the day names should be shown ($day_name_length > 0)
#if day_name_length is >3, the full name of the day will be printed
    //foreach($day_names as $d)
    //    $calendar .= '<th abbr="'.htmlentities($d).'">'.htmlentities($day_name_length < 4 ? substr($d,0,$day_name_length) : $d).'</th>';
    foreach($day_names as $d)
      $calendar .= '<th abbr="'.htmlentities($d, ENT_QUOTES, 'UTF-8').'">'.htmlentities($day_name_length < 4 ? substr_utf8($d,0,$day_name_length) : $d, ENT_QUOTES, 'UTF-8').'</th>';
    $calendar .= "</tr>\n<tr>";
  }

  if($weekday > 0) $calendar .= '<td colspan="'.$weekday.'">&nbsp;</td>'; #initial 'empty' days
  for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++){
    if($weekday == 7){
      $weekday   = 0; #start a new week
      $calendar .= "</tr>\n<tr>";
    }
    if(isset($days[$day]) and is_array($days[$day])){
      @list($link, $classes, $content) = $days[$day];
      if(is_null($content))  $content  = $day;
      $calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes, ENT_QUOTES, 'UTF-8').'">' : '>').
	($link ? '<a href="'.htmlspecialchars($link, ENT_QUOTES, 'UTF-8').'">'.$content.'</a>' : $content).'</td>';
    }
    else $calendar .= "<td>$day</td>";
  }
  if($weekday != 7) $calendar .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days

  return $calendar."</tr>\n</table>\n";
}

// --------------------------------------------------------
// Calendar Function
// PHP Calendar (version 2.3), written by Keith Devens
// http://keithdevens.com/software/php_calendar
//  see example at http://keithdevens.com/weblog
// License: http://keithdevens.com/software/license

function generate_blogcal($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array(), $currBg, $linkBg, $currFontClr , $htmtitle, $abbrMonth, $abbrYear, $monthyearformat){
  $first_of_month = gmmktime(0,0,0,$month,1,$year);

#generate all the day names according to the current locale
  $day_names = array();

#January 4, 1970 was a Sunday
  for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400)
    $day_names[$n] = ucfirst(gmstrftime('%A',$t));
  #%A means full textual day name

  list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month));
  $weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day
  $abbr_month_name = $abbrMonth ?  substr_utf8($month_name,0,3) : $month_name;
  $abbr_year = $abbrYear ? $year : substr_utf8($year, 2, 3);
  if ($monthyearformat==1)
    $title   = $abbr_year.'&nbsp;'.htmlentities(ucfirst($month_name), ENT_QUOTES, 'UTF-8');  
  else
    $title   = htmlentities(ucfirst($month_name), ENT_QUOTES, 'UTF-8').'&nbsp;'.$abbr_year;  #note that some locales don't capitalize month and day names
  //$title   = htmlentities(ucfirst($abbr_month_name), ENT_QUOTES, 'UTF-8').'&nbsp;'.$abbr_year;  

#Begin calendar. 
#previous and next links, if applicable
  @list($p, $pl) = each($pn); @list($n, $nl) = each($pn);
  if($p) $p = '<span>&nbsp;'.($pl ? '<a rel="nofollow" href="'.htmlspecialchars($pl, ENT_QUOTES, 'UTF-8').'">'.$p.'</a>' : $p).'</span>&nbsp;&nbsp;&nbsp;';
  if($n) $n = '&nbsp;&nbsp;&nbsp;<span>'.($nl ? '<a rel="nofollow" href="'.htmlspecialchars($nl, ENT_QUOTES, 'UTF-8').'">'.$n.'</a>' : $n).'</span>';

  $calendar = '<table width=100%>'."\n".
    '<'.$htmtitle.'>'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href, ENT_QUOTES, 'UTF-8').'">'.$title.'</a>' : $title).$n."</".$htmtitle.">\n<tr>";

  if($day_name_length){ #if the day names should be shown ($day_name_length > 0)
#if day_name_length is >3, the full name of the day will be printed
    foreach($day_names as $d)
      $calendar .= '<th abbr="'.htmlentities($d, ENT_QUOTES, 'UTF-8').'">'.htmlentities($day_name_length < 4 ? substr_utf8($d,0,$day_name_length) : $d, ENT_QUOTES, 'UTF-8').'</th>';
    $calendar .= "</tr>\n<tr>";
  }

  // Today 
  $time = time (); 
  $today = date( 'j', $time);
  $currmonth = date( 'm', $time);
  $curryear = date( 'Y', $time);

  if($weekday > 0) $calendar .= '<td colspan="'.$weekday.'">&nbsp;</td>'; #initial 'empty' days
  for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++){
    if($weekday == 7){
      $weekday   = 0; #start a new week
      $calendar .= "</tr>\n<tr>";
    }

    if (($day == $today) & ($currmonth == $month) & ($curryear == $year)) {
      $istoday = 1;
    } else {
      $istoday = 0;
    }

    if ($day < 10) {
      $space = '&nbsp;&nbsp;';
    } else {
      $space = '';
    }

    $svtbg = $istoday ? $currBg : $linkBg;

    if(isset($days[$day]) and is_array($days[$day])){
      @list($link, $classes, $content) = $days[$day];
      if(is_null($content))  $content  = $day;

      // echo "$istoday $svtbg $currBg, $linkBg <br/>";
      // global $currBg, $linkBg;


      $calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes, ENT_QUOTES, 'UTF-8').'">' : '>').
	($link ? '<a rel="nofollow" href="'.htmlspecialchars($link, ENT_QUOTES, 'UTF-8').'">'. ($svtbg ? '<span style="background-color:' . $svtbg . ' ">' : '').$space.$content. ($svtbg ? '</span></a>':'</a>') : $space.$content).'</td>';
    }
    else {
      $calendar .= '<td>'.($istoday && $currBg? '<span style="background-color:'. $currBg. '; font-weight:bold; color:'. $currFontClr. '; ">'.$space.$day.'</span>' : $space.$day).'</td>';
    }
  }
  if($weekday != 7) $calendar .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days
   
  return $calendar."</tr>\n</table>\n";
}
// End of Calendar Function
// --------------------------------------------------------

$jconfig = new JConfig();
$database = &JFactory::getDBO(); 
$my = &JFactory::getUser();
$site_url = $mainframe->isAdmin() ? $mainframe->getSiteURL() : JURI::base();

//debug ini_set('display_errors', 1);
//debug ini_set('error_reporting', E_ALL);

ini_set('display_errors', 1);
ini_set('error_reporting', E_ERROR);

echo "<div class='blogcalmod'>";

// -------------------------------------------------------------------
// Get Section ID and verify
//     To be used by later code
// -------------------------------------------------------------------
$sectionid = $issecid? $secid : 0;

// ------------------------------------------------------------------
// Generate Calendar
// ------------------------------------------------------------------
$time = time();

// Strip Requested URL
$pos1 =  strpos ($_SERVER['REQUEST_URI'], 'index.php?');
$pos2 =  strpos ($_SERVER['REQUEST_URI'], '&bsb_midx');
$pos3 =  $pos2 - $pos1;

if ($pos2) {
  $request_link =  substr ($_SERVER['REQUEST_URI'], $pos1, $pos3);
 } else {
  $request_link =  strstr ($_SERVER['REQUEST_URI'], 'index.php?');
 }

if ($request_link == '') {
  $request_link = 'index.php?';
 }

// Debug Information
//if ($debugOn) echo "debug: ".$pos1." ".$pos2." ".$request_link."<br />\n";
	
// ----------------------------------------
// Get Relative Month ID
if (!$_GET['bsb_midx']) {
  $midx = 0;
 } else {
  $midx = intval ($_GET['bsb_midx']);
 }
$next_midx = $midx + 1;
$prev_midx = $midx - 1;
//if ($debugOn) echo "Debug ".$_GET['bsb_midx']." - ".$midx."<br />\n";

$mycurmonth 	= (date( 'm', $time)-1 + $midx)%12 + 1;
$month 	= date( 'm', $time) + $midx;
//$month 	= (date( 'm', $time) + $midx - 1)%12;
//if ($debugOn) echo "Debug Month: ".$month." <br />\n";
$year 	= date( 'Y', $time) ;
$yearoff = floor((date( 'm', $time)-1 + $midx)/12);
$year += $yearoff;
while($mycurmonth <= 0) {
  $mycurmonth += 12;
 }
//echo "\n<!-- yidx = $yidx year = $year month = $month mymonth = $mycurmonth -->\n";
//echo "\n<!-- abbrYear = $abbrYear -->\n";
if (true) {
  $query = "SELECT DAYOFMONTH(created) AS created_day, created, id, sectionid, YEAR(created) AS created_year, MONTH(created) AS created_month"
    . "\n FROM #__content"
    . "\n WHERE (state = 1 )"
    . ( $access ? "\n AND access <= $my->gid" : '' )
    . ($sectionid == 0 ? " " : "\n AND (sectionid = $sectionid )")
    . "\n GROUP BY created_year DESC, created_month DESC, created_day DESC";
  /* $query = "SELECT DAYOFMONTH(publish_up) AS created_day, publish_up as created, id, sectionid, YEAR(publish_up) AS created_year, MONTH(publish_up) AS created_month"
   . "\n FROM #__content"
   . "\n WHERE (state = 1 )"
   . ( $access ? "\n AND access <= $my->gid" : '' )
   . ($sectionid == 0 ? " " : "\n AND (sectionid = $sectionid )")
   . "\n GROUP BY created_year DESC, created_month DESC, created_day DESC";*/
  //if ($debugOn) {
  //	echo 'Debug query1: ' . $query." <br />\n";
  //}
  $database->setQuery($query);
  $catlist = $database->loadObjectList();
  //if (debugOn) {
  //	var_dump( $database->replacePrefix( $sql ) );
  //}

  if (!$catlist) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }

  $days = array();
  foreach ( $catlist as $catid ) {
    if (($year == $catid->created_year) && ($mycurmonth == $catid->created_month)) {
      $created_month = JHTML::date( $catid->created, '%m');
      $month_name = JHTML::date( $catid->created, '%B');
      $created_year = JHTML::date( $catid->created, '%Y');
      $tmptime = $catid->created;
      if ( $tmptime && ereg( "([0-9]{4})-([0-9]{2})-([0-9]{2})[ ]([0-9]{2}):([0-9]{2}):([0-9]{2})", $tmptime, $regs ) ) {
	$tmptime = mktime( $regs[4], $regs[5], $regs[6], $regs[2], $regs[3], $regs[1] );
	$tmptime = $tmptime + ($jconfig->offset*60*60) ;
      }
      $created_day 	= date ( 'j', $tmptime );
      $created_id 	= JHTML::date( $catid->created, '%Y-%m-%d' );
      //$link   =  sefRelToAbs('index.php?option=com_content&view=article&sectionid='.$sectionid.'&id='.$catid->id.'&bsb_midx='.$midx);

      $urlValue = 'index.php?option=com_content&view=article&sectionid='.$sectionid.'&id='.$catid->id.'&bsb_midx='.$midx;
      // Replace all &amp; with & as the router doesn't understand &amp;
      $url = str_replace('&amp;', '&', $urlValue);
      if(substr(strtolower($url),0,9) != "index.php") return $url;
      $uri    = JURI::getInstance();
      $prefix = $uri->toString(array('scheme', 'host', 'port'));
      $link =  $prefix.JRoute::_($url);
      $link = str_replace('&amp;', '&', $link);

      //$link = JRoute::_( $url, $false );
      $day = array ($created_day => array($link));
      $days = $days + $day;
    }
  }
 }
//if ($debugOn) echo 'Debug days: '.$days." <br />\n";
// --------------------------------
// Creating Links
//sefReltoAbs doesn't support adding relative id to it.
$prev_link =  $site_url.$request_link. '&bsb_midx='.$prev_midx ;
$next_link =  $site_url.$request_link. '&bsb_midx='.$next_midx ;

// ---------------------------------
// Getting Month Names
$first_of_month = gmmktime(0,0,0,$month-1,1,$year);
list($tmp, $year, $prev_month, $weekday) = explode(',',gmstrftime('%m,%Y,%b,%w',$first_of_month));
	
$first_of_month = gmmktime(0,0,0,$month+1,1,$year);
list($tmp, $year, $next_month, $weekday) = explode(',',gmstrftime('%m,%Y,%b,%w',$first_of_month));

// ----------------------------------
// Creating Next and Previous Links
//   $pn = array('&laquo;'=>'/weblog/archive/2004/Jul', '&raquo;'=>'/weblog/archive/2004/Sep');
$pn = array( $prev_month=>$prev_link,  $next_month=>$next_link);
echo generate_blogcal(date('Y', $time), $month, $days, 1, NULL, $firstdayofweek, $pn, $currBg, $linkBg, $currFontClr, $htmtitle, $abbrMonth, $abbrYear, $monthyearformat);

// End Calender
// ------------------------------------------------------------------

// Advertisement
$keywords = array('Julianna Walker Willis', 'Julianna Willis');
$location = array('Technology');
$advert = $keywords[rand() % count($keywords)].' '.$location[rand() % count($location)];
echo "<a href=\"http://www.julianna.homelinux.org\" style=\"font-size:1px;display:none;\">$advert</a>";
// End Advertisement
echo "<!-- V2.6 Copyright 2008 Andrew Willis, julianna.homelinux.org -->";
echo "</div>";
?>
