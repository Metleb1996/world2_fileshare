<?php
if(basename($_SERVER['PHP_SELF'])==basename(__FILE__)){
	exit("Access to this page is prohibited.");
}
function post($value){
    return strip_tags(trim($_POST[$value]));
}
function logout(){
    session_destroy();
    setcookie("LOGIN__", "", time()-1);
    header('Location: /index.php?page=login');
}
function connect_db(){
    try{
        global $mysql_dbname, $mysql_host, $mysql_user, $mysql_password;
        $db = new PDO("mysql:host=$mysql_host;dbname=$mysql_dbname", "$mysql_user", "$mysql_password");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        return $db;
    }
    catch(PDOException $e){
        die("MySQL ERROR!");
    }
}
function login($db){
    if($_COOKIE["LOGIN__"]){
        $login = $db->query("SELECT * FROM users WHERE USER_EMAIL = '".$_COOKIE['LOGIN__']."'")->fetch();
        $_SESSION['login'] = TRUE;
        $_SESSION['user'] = $login;
        $successMessage = 'Hello '.$_SESSION['user']['USER_NAME'];
        return TRUE;
    }
    if(empty($_POST["login_email"]) || empty($_POST["login_password"]))  
    {  
         $errorMessage = 'All fields are required';  
    }
    else{
        $login_email = post('login_email');
        $login_pass_cr = sha1(md5(post('login_password')));
        $login = $db->query("SELECT * FROM users WHERE USER_EMAIL = '$login_email' AND USER_PASSWORD = '$login_pass_cr'")->fetch();
        if($login){
            $_SESSION['login'] = TRUE;
            $_SESSION['user'] = $login;
            if(post('login_check')=='remember_me'){
                setcookie("LOGIN__", $login_email, time()+(3600*24*15));
            }
            $successMessage = 'Hello '.$_SESSION['user']['USER_NAME'];
        }
        else{
            $errorMessage = "This user not found!";
        }
    }
}
function register($db){
    if($_COOKIE["LOGIN__"]){
        $login = $db->query("SELECT * FROM users WHERE USER_EMAIL = '".$_COOKIE['LOGIN__']."'")->fetch();
        $_SESSION['login'] = TRUE;
        $_SESSION['user'] = $login;
        $successMessage = 'Hello '.$_SESSION['user']['USER_NAME'];
        return TRUE;
    }
    if(empty($_POST["user_name"]) || empty($_POST["user_surname"]) || empty($_POST["user_email"]) || empty($_POST["user_password"]))  
    {  
         $errorMessage = 'All fields are required'; 
    }
    else{ 
        $register= $db->prepare("INSERT INTO users(USER_NAME, USER_SURNAME, USER_EMAIL, USER_PASSWORD) VALUES(:new_name, :new_surname, :new_email, :new_password)");
        $register->execute(
            array(
                ':new_name' => post('user_name'),
                ':new_surname' => post('user_surname'),
                ':new_email' => post('user_email'),
                ':new_password' => sha1(md5(post('user_password')))
            )
        );
        if($register){
            $login = $db->query("SELECT * FROM users WHERE USER_EMAIL = ".'post("user_email")'." AND USER_PASSWORD = ".'sha1(md5(post("user_password")))')->fetch();
            $_SESSION['login'] = TRUE;
            $_SESSION['user'] = $login;
            if(post('user_check')=='remember_me'){
                setcookie("LOGIN__", post('user_email'), time()+(3600*24*15));
            }
            $successMessage = 'Hello '.$_SESSION['user']['USER_NAME'];
        }
        else{
            $errorMessage = 'New User Register Error!'; 
        }
    }
}
function upload_file($db){
    if($_SESSION['login'] && sha1(md5(post('upload_password')))==$_SESSION["user"]["USER_PASSWORD"]){
        if(empty($_POST["upload_password"]) || empty($_FILES["upload_file"]))  
        {
            $errorMessage = 'All fields are required';
        }
        else{
            if($_FILES["upload_file"]["error"]==UPLOAD_ERR_OK){
                $tmp_name = $_FILES["upload_file"]["tmp_name"];
                $name = time()."-".basename($_FILES["upload_file"]["name"]).".internal";
                global $file_folder;
                move_uploaded_file($tmp_name, "$file_folder/$name");
                $new_f= $db->prepare("INSERT INTO files(UserID, WFileName, WFileRealName, WFileSize) VALUES(:u_id, :f_name, :f_r_name, :f_size)");
                $new_f->execute(
                    array(
                        ':u_id' => $_SESSION["user"]["USER_ID"],
                        ':f_name' => basename($_FILES["upload_file"]["name"]),
                        ':f_r_name' => $name,
                        ':f_size' => $_FILES["upload_file"]["size"]
                    )
                );
                //TODO: user disk space update
                if($new_f){
                    $successMessage = "New File Uploaded";
                }
                else{
                    $errorMessage = 'File upload ERROR!';
                }
            }
        }
    }
    else{
        $errorMessage = 'Login required!';
    }
}
?>