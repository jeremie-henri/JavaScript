<?php
/**
 * Created by PhpStorm.
 * User: h17004901
 * Date: 01/03/19
 * Time: 11:37
 */

$user = 'elvex';
$pass = '123';

try{
    $bd = new PDO('mysql:host=mysql-elvex.alwaysdata.net;dbname=elvex_bd', $user, $pass);
}catch ( PDOException $e){
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
