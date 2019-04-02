<?php
/**
 * Created by PhpStorm.
 * User: h17004901
 * Date: 01/03/19
 * Time: 11:03
 */

include "PDO.php";

$username =  htmlspecialchars($_POST['username']);
$password =  htmlspecialchars($_POST['password']);
$quot = "'";

if (!empty($_POST['username']) && !empty($_POST['password'])) {

    try {
        $statement = 'SELECT username,password FROM user WHERE username = \'' . $username . '\'AND password = \'' . $password . '\'';
        foreach ($bd->query($statement) as $row) {
            $login_valide = $row['username'];
            $pwd_valide = $row['password'];
        }

    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }

    if (!is_null($login_valide)) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode(false);
        die;
    } else {
        $statement = $bd->query('INSERT INTO user (username,password) VALUE  (' . $quot . $username . $quot . ',' . $quot . $password . $quot . ')');

        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode('register');
        die;
    }
}
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode('empty');
die;
?>
