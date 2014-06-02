<?php
/**
 *	Definições gerais
 */

$sid = session_id();

if(isset($sid) ) { //checa se a sessão foi criada.
 session_start();
} 


function sh_date_interval($_date1,$_date2, $format){

    //Make sure $date1 is ealier
    $date1 = ($_date1 <= $_date2 ? $_date1 : $_date2);
    $date2 = ($_date1 <= $_date2 ? $_date2 : $_date1);

    //Calculate R values
    $R = ($_date1 <= $_date2 ? '+' : '-');
    $r = ($_date1 <= $_date2 ? '' : '-');

    //Calculate total days
    $total_days = round(abs($date1->format('U') - $date2->format('U'))/86400);

    //A leap year work around - consistent with DateInterval
    $leap_year = ( $date1->format('m-d') == '02-29' ? true : false);
    if( $leap_year ){
        $date1->modify('-1 day');
    }

    $periods = array( 'years'=>-1,'months'=>-1,'days'=>-1,'hours'=>-1);

    foreach ($periods as $period => &$i ){

        if($period == 'days' && $leap_year )
            $date1->modify('+1 day');

        while( $date1 <= $date2 ){
            $date1->modify('+1 '.$period);
            $i++;
        }

        //Reset date and record increments
        $date1->modify('-1 '.$period);
    }
    extract($periods);

    //Minutes, seconds
    $seconds = round(abs($date1->format('U') - $date2->format('U')));
    $minutes = floor($seconds/60);
    $seconds = $seconds - $minutes*60;

    $replace = array(
        '/%y/' => $years,
        '/%Y/' => zeroise($years,2),
        '/%m/' => $months,
        '/%M/' => zeroise($months,2),
        '/%d/' => $days,
        '/%D/' => zeroise($days,2),
        '/%a/' => zeroise($total_days,2),
        '/%h/' => $hours,
        '/%H/' => zeroise($hours,2),
        '/%i/' => $minutes,
        '/%I/' => zeroise($minutes,2),
        '/%s/' => $seconds,
        '/%S/' => zeroise($seconds,2),
        '/%r/' => $r,
        '/%R/' => $R
    );

    return preg_replace(array_keys($replace), array_values($replace), $format);
}

function zeroise($number, $threshold) {
	return sprintf('%0'.$threshold.'s', $number);
}
?>