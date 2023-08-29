<?php

include_once './calculate.php';

$helpText = "Usage: run.calculate.php with these arguments:\n 
-d: or --date: The date when the ticket is registered. It must bee a working day (Mon-Fri) \n 
-t: or --time: The Time when the ticket is registeres, in HH-MM format. It cannot be outside of working hours (09:00-17:00) \n
the estimated time of the ticket, in working hours \n 
-h or --help or ?: print this help message \n ";

$errorText = "The arguments cannot be empty. Use run.calculate.php -h or --help for more information";

$short_options = 'd:t:e:-h';

$long_options = ['date:', 'time:', 'estimated:', 'help'];

$options = getopt($short_options, $long_options);

if (isset($options['-h']) || isset($options['?']) || isset($options['help'])) {
    echo $helpText;
    exit;
}

if (empty($options) 
    || (empty($options['d']) && empty($options['t']) 
    && empty($options['date']) && empty($options['time'])
    && empty($options['e']) && empty($options['estimated']))) {
    echo $errorText;
    exit;
}

$date = empty($options['d']) ? $options['date'] : $options['d'];
$time = empty($options['t']) ?  $options['time'] : $options['t'];
$time = explode("-", $time);
$dateTime = $date. " ". $time[0] .":". $time[1];
$estimated = empty($options['e']) ?  $options['estimated'] : $options['e'];

try {
    $dueDate = new Calculate($dateTime, $estimated);
    echo $dueDate->getDueDate();
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}