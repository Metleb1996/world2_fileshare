<?php
    include_once("config.php");
    try{
        $db = new PDO("mysql:host=$mysql_host;dbname=$mysql_dbname", "$mysql_user", "$mysql_password");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        die("MySQL ERROR!");
    }
    if(isset($_POST["reg_submit"])){
        $register= $db->prepare("INSERT INTO users(USER_NAME, USER_SURNAME, USER_EMAIL, USER_PASSWORD) VALUES(:new_name, :new_surname, :new_email, :new_password)");

        $sorgu->execute(
            array(
                ':new_name' => $_POST['user_name'],
                ':new_surname' => $_POST['user_surname'],
                ':new_email' => $_POST['user_email'],
                ':new_password' => $_POST['user_pasword']
            )
        );
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
                    <a class="nav-link active" aria-current="page" href="/?home">Home</a>
                    <a class="nav-link" href="/?register">Register</a>
                    <a class="nav-link" href="/?login">Login</a>
                    <a class="nav-link" href="/?upload">Upload File</a>
                </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- Navbar -->

    <main>
    <?php if(isset($_GET['register'])){ ?>
    <!-- Section Register -->
    <section class="bg-primary" id="register">
        <div class="container py-5">
            <div class="text-center">
                <h1>Register</h1>
                <p>Lorem ipsum door sit amet</p>
            </div>
            <div class="row">
                <div class="col-8 offset-2">
                    <form action="/index.php" method="POST">
                        <div class="mb-3">
                            <label for="user_name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="user_name" id="user_name" aria-describedby="nameHelp">
                        </div>
                        <div class="mb-3">
                            <label for="user_surname" class="form-label">SurName</label>
                            <input type="text" class="form-control" name="user_surname" id="user_surname" aria-describedby="surnameHelp">
                        </div>
                        <div class="mb-3">
                            <label for="user_email" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="user_email" id="user_email" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="user_password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="user_password" id="user_password">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="user_check" id="user_check">
                            <label class="form-check-label" for="user_check">Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="reg_submit" value="reg_submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Section Register -->

    <?php }elseif(isset($_GET['register'])){ ?>

    <!-- Section Login -->
    <section class="bg-warning" id="login">
        <div class="container py-5">
            <div class="text-center">
                <h1>Login</h1>
                <p>Lorem ipsum door sit amet</p>
            </div>
            <div class="row">
                <div class="col-8 offset-2">
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Section Login -->

    <?php }elseif(isset($_GET['upload'])){ ?>

    <!-- Section File upload -->
    <section class="bg-success" id="login">
        <div class="container py-5">
            <div class="text-center">
                <h1>File Load</h1>
                <p>Lorem ipsum door sit amet</p>
            </div>
            <div class="row">
                <div class="col-8 offset-2">
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">File</label>
                            <input type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">File Name (optional)</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">User Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Private</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Section File upload -->

    <?php }elseif(isset($_GET['home'])){ ?>

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
                            MyName
                        </div>
                        <div class="col-6">
                            SurName:
                        </div>
                        <div class="col-6">
                            MySurName
                        </div>
                        <div class="col-6">
                            Used Disk Space:
                        </div>
                        <div class="col-6">
                            0000 KB
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