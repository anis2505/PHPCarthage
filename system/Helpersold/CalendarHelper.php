<?php
namespace System\Helpers;


/* * File: SimpleImage.php 
 * Author: Simon Jarvis 
 * Copyright: 2006 Simon Jarvis 
 * Date: 08/11/06 
 * Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php 
 * This program is free software; you can redistribute it and/or 
 * modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation; either version 2 
 * of the License, or (at your option) any later version. 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 * See the 
 * GNU General Public License for more details: 
 * http://www.gnu.org/licenses/gpl.html * */

class CalendarHelper {

    /* table headings */
    public static $headings = array('Dim','Lun','Mar','Mer','Jeu','Ven','Sam');

    /* draws a calendar */
    public static function draw_calendar($month,$year){

	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar1 table" style="min-height:500px">';

	$calendar.= '<thead class="calendar-row1"><th class="calendar-day-head">'.implode('</th><th class="calendar-day-head">',self::$headings).'</th></thead>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="calendar-day">';
			/* add in the day number */
			$calendar.= '<div class="day-number">'.$list_day.'</div>';

			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			$calendar.= str_repeat('<p> </p>',2);
			
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';
	
	/* all done, return result */
	return $calendar;
    }

/* sample usages
        echo '<h2>July 2009</h2>';
        echo draw_calendar(7,2009);
        
        echo '<h2>August 2009</h2>';
        echo draw_calendar(8,2009);
*/
}

?>