<?php

include_once './calculate.php';

try {
    $test_one = new Calculate('2023-08-30T16:45', '68');
} catch (Exception $e) {
    echo $e->getMessage();
}
echo $test_one->getDueDate();