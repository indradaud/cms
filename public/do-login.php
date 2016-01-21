<?php

session_start();

if(!empty($_POST['email']) && !empty($_POST['password']))
{
    require_once dirname(__DIR__) . '/classes/Dbase.php';
    require_once dirname(__DIR__) . '/classes/Config.php';

    $email = $_POST['email'];
    $pass = md5($_POST['password']);

    $db = new Landingo\Resources\Dbase();

    $db->where = "email = '{$email}' && password = '{$pass}'";
    $data = $db->get('users')->result();

    $db->close();

    $result = array('result' => 0);

    if($data)
    {
        if($data->level)
        $_SESSION['cms_login'] = true;
        $_SESSION['cms_login_as'] = $data->level;
        $_SESSION['cms_logged_username'] = $data->nama;
        $_SESSION['cms_logged_userid'] = $data->id;

        $result = array('result' => 1);
    }

    echo json_encode($result);
} else
{
    session_destroy();
    header('location:login.php');
}

?>