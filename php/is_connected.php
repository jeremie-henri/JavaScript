<?php
/**
 * Created by PhpStorm.
 * User: h17004901
 * Date: 27/02/19
 * Time: 13:53
 */

include 'PDO.php';
session_start();

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');


if (isset($_SESSION['username'])){
    echo json_encode(true);
} else {
    echo json_encode(false);
}
