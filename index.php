<?php
    session_start();
    require_once("config.php");
    require_once("lib.php");
    $db = connect_db();
    if(empty($_GET) || empty($_GET['page'])){
        $_GET['page'] = 'home';
    }
    if(isset($_POST["reg_submit"])){
       register($db);
    }
    if(isset($_POST['login_submit'])){
        login($db);
    }
    if(isset($_POST['upload_submit'])){
        upload_file($db);
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <title>W2FileShare</title>
  </head>
  <body>
    <!-- Navbar -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">W2FileShare</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link <?php if($_GET['page']=='home'){echo 'active';} ?>" aria-current="page" href="/?page=home">Home</a>
                    <?php if(!$_SESSION['login']){ ?>
                    <a class="nav-link <?php if($_GET['page']=='register'){echo 'active';} ?>" href="/?page=register">Register</a>
                    <?php } ?>
                    <a class="nav-link <?php if(!$_SESSION['login']){echo 'disabled';}  if($_GET['page']=='upload'){echo 'active';}  ?>" href="/?page=upload">Upload File</a>
                    <?php if($_SESSION['login']){ ?>
                        <a class="nav-link" href="/?page=logout">Logout(<?php echo $_SESSION['user']['USER_NAME'];?>)</a>
                    <?php }else{ ?>
                        <a class="nav-link <?php if($_GET['page']=='login'){echo 'active';} ?>" href="/?page=login">Login</a>
                    <?php } ?>
                </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- Navbar -->

    <main>
    <?php
    if(isset($errorMessage)){ ?>
        <div class="alert alert-danger alert-dismissible fade show mx-5" role="alert">
            <strong class="ps-5"> <?php echo $errorMessage; ?> </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php 
    }
    if(isset($successMessage)){ ?>
         <div class="alert alert-success alert-dismissible fade show mx-5" role="alert">
            <strong class="ps-5"> <?php echo $successMessage; ?> </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php 
    } 
    if((isset($_GET['page'])&&$_GET['page']=='logout')){
        logout();
    }
    elseif((isset($_GET['page'])&&$_GET['page']=='register')){ ?>

    <!-- Section Register -->
    <section class="bg-primary" id="register">
        <div class="container py-5">
            <div class="text-center">
                <h1>Register</h1>
                <p>You need to register to use our services</p>
            </div>
            <div class="row">
                <div class="col-8 offset-2">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                        <div class="mb-3">
                            <label for="user_name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="user_name" id="user_name" aria-describedby="nameHelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_surname" class="form-label">SurName</label>
                            <input type="text" class="form-control" name="user_surname" id="user_surname" aria-describedby="surnameHelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_email" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="user_email" id="user_email" aria-describedby="emailHelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="user_password" id="user_password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="user_check" id="user_check" value="remember_me">
                            <label class="form-check-label" for="user_check">Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-secondary" name="reg_submit" value="reg_submit">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Section Register -->

    <?php }elseif((isset($_GET['page'])&&$_GET['page']=='login')){ ?>

    <!-- Section Login -->
    <section class="bg-warning" id="login">
        <div class="container py-5">
            <div class="text-center">
                <h1>Login</h1>
                <p>Log in to use our services</p>
            </div>
            <div class="row">
                <div class="col-8 offset-2">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                        <div class="mb-3">
                            <label for="login_email" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="login_email" id="login_email" aria-describedby="emailHelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="login_password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="login_password" id="login_password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="login_check" id="login_check" value="remember_me">
                            <label class="form-check-label" for="login_check">Remember me</label>
                        </div>
                        <button type="submit" name="login_submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Section Login -->

    <?php }elseif((isset($_GET['page'])&&$_GET['page']=='upload')){
        if(!$_SESSION['login']){
            header('Location: /index.php?page=login');
        } ?>

    <!-- Section File upload -->
    <section class="bg-success" id="login">
        <div class="container py-5">
            <div class="text-center">
                <h1>File Load</h1>
                <p>Lorem ipsum door sit amet</p>
            </div>
            <div class="row">
                <div class="col-8 offset-2">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="upload_file" class="form-label">File</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                            <input type="file" class="form-control" name="upload_file" id="upload_file" aria-describedby="emailHelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="upload_password" class="form-label">User Password</label>
                            <input type="password" class="form-control" name="upload_password" id="upload_password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="upload_check">
                            <label class="form-check-label" for="upload_check">Private</label>
                        </div>
                        <button type="submit" name="upload_submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Section File upload -->

    <?php }elseif((isset($_GET['page'])&&$_GET['page']=='home')){ 
        if(!$_SESSION['login']){
            header('Location: /index.php?page=login');
        } ?>

    <!-- Section User Home -->
    <section class="bg-info" id="login">
        <div class="container py-5">
            <div class="text-center">
                <h1>Home Page</h1>
                <p>Lorem ipsum door sit amet</p>
            </div>
            <div class="row m-0">
                <div class="col-5">
                    <div class="text-center">
                        <h2>User Info</h2>
                        <p>Lorem ipsum door sit amet</p>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            Name:
                        </div>
                        <div class="col-6">
                            <?php echo $_SESSION['user']["USER_NAME"]; ?>
                        </div>
                        <div class="col-6">
                            SurName:
                        </div>
                        <div class="col-6">
                        <?php echo $_SESSION['user']["USER_SURNAME"]; ?>
                        </div>
                        <div class="col-6">
                            Used Disk Space:
                        </div>
                        <div class="col-6">
                        <?php echo $_SESSION['user']["DISK_AREA"]; ?> KB
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <div class="text-center">
                        <h2>User Files</h2>
                        <p>Lorem ipsum door sit amet</p>
                    </div>
                    <div class="row">
                        <div class="col-7">MyFileName.ext  (0000 KB)</div>
                        <div class="col-5">
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-trash"></i></button>
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ...
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-warning"><i class="bi bi-pencil"></i></button>
                                <button type="button" class="btn btn-success"><i class="bi bi-link"></i></button>
                                <button type="button" class="btn btn-primary"><i class="bi bi-share"></i></button>
                            </div>
                        </div>
                        <div class="col-7">MyFileName.ext  (0000 KB)</div>
                        <div class="col-5">
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-trash"></i></button>
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ...
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-warning"><i class="bi bi-pencil"></i></button>
                                <button type="button" class="btn btn-success"><i class="bi bi-link"></i></button>
                                <button type="button" class="btn btn-primary"><i class="bi bi-share"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section User Home -->
    <?php } ?>
    <!-- Section Footer -->
        <footer class="footer mt-auto py-3 bg-light">
            <div class="container">
                <span class="text-muted">&copy; 2021 Copyright: Metleb Rustemov.</span>
            </div>
        </footer>
    <!-- Section Footer -->
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>

<?php
    $db = null;
?>