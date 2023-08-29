<?php

include_once './calculate.php';

// Test One: Expecting 2023-09-12 12:45
try {
    $test_one = new Calculate('2023-08-30T16:45', '68');
    echo $test_one->getDueDate();
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}

// Test Two: Expecting Error due the date is not working day
try {
    $test_two = new Calculate('2023-09-02T13:39', '6');
    echo $test_two->getDueDate();
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}