<?php 

/**
* VoipTransDateHelper
*/
class VoipTransDateHelper
{
	
	// public static function timeAgo($rawDate)
	// {
 //       $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
 //       $lengths = array("60","60","24","7","4.35","12","10");
 //       $now = time();
 //       $difference     = $now - $rawDate;
 //       $tense         = "ago";

 //       for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
 //           $difference /= $lengths[$j];
 //       }

 //       $difference = round($difference);

 //       if($difference != 1) {
 //           $periods[$j].= "s";
 //       }
 //       return "$difference $periods[$j] ago";
	// }
  public static function timeAgo($time)
  {
      $etime = time() - $time;
      if ($etime < 1)
      {
          return '0 seconds';
      }

      $a = array( 365 * 24 * 60 * 60  =>  'year',
                   30 * 24 * 60 * 60  =>  'month',
                        24 * 60 * 60  =>  'day',
                             60 * 60  =>  'hour',
                                  60  =>  'minute',
                                   1  =>  'second'
                  );
      $a_plural = array( 'year'   => 'years',
                         'month'  => 'months',
                         'day'    => 'days',
                         'hour'   => 'hours',
                         'minute' => 'minutes',
                         'second' => 'seconds'
                  );

      foreach ($a as $secs => $str)
      {
          $d = $etime / $secs;
          if ($d >= 1)
          {
              $r = round($d);
              return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
          }
      }  
  }

}