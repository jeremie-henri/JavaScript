
<?php
/**
 * Created by PhpStorm.
 * User: h17004901
 * Date: 27/02/19
 * Time: 15:13
 */

include "PDO.php";

$username =  htmlspecialchars($_POST['username']);
$password =  htmlspecialchars($_POST['password']);

if (!empty($_POST['username']) && !empty($_POST['password'])) {

    try{
        $statement = 'SELECT username,password FROM user WHERE username = \''. $username . '\'AND password = \''. $password . '\'';
        foreach  ($bd->query($statement) as $row) {
            $login_valide = $row['username'];
            $pwd_valide = $row['password'];
        }

    }catch ( PDOException $e){
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
    if ($username == $login_valide && $password == $pwd_valide) {
        session_start();

        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;

        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode('login');
    } else {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode(false);
    }
}else{

    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');
    echo json_encode('vide');
}
?>
