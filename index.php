<?php
    session_start();

    //Авторизированных пользователей перенаправляем на страницу профиля
    if($_SESSION['user']){
      if($_SESSION['user']['type'] === 'admin'){
        header('Location: admin_dashboard.php');
      }
      else{
        header('Location: player_dashboard.php');
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Document</title>
</head>
<body>
    <section class="intro">
        <div class="bg-image h-100">
          <div class="mask d-flex align-items-center h-100" style="background-color: #f3f2f2;">
            <div class="container">
              <div class="row d-flex justify-content-center align-items-center">
                <div class="col-12 col-lg-9 col-xl-8">
                  <div class="card" style="border-radius: 1rem;">
                    <div class="row g-0">
                      <div class="col-md-4 d-none d-md-block">
                        <img src="assets/images/sidenav.jpg" alt="login form" class="img-fluid" style="border-top-left-radius: 1rem; border-bottom-left-radius: 1rem;" />
                      </div>
                      <div class="col-md-8 d-flex align-items-center">
                        <div class="card-body py-5 px-4 p-md-3">
      
                          <form action="server/signin.php" method="post">
                            <h4 class="fw-bold mb-4" style="color: #92aad0;">Log in to your account</h4>
                            <p class="mb-4" style="color: #45526e;">To log in, please fill in these text fields with your e-mail address or telephone number and password.</p>

                            <div class="form-outline mb-4 input-container">
                                <input id="login" name="login" class="input form-control" type="text" placeholder=" "/>
                                <div class="cut cut-super-long"></div>
                                <label for="login" class="placeholder">Login</label>
                            </div>

                            <div class="form-outline mb-4 input-container">
                                <input id="password" name="password" class="input form-control" type="password" placeholder=" "/>
                                <div class="cut cut-short"></div>
                                <label for="password" class="placeholder">Password</label>
                            </div>

                            <div class="form-outline mb-4 input-container">
                                <input id="password" name="token" class="input form-control" type="hidden" placeholder=" "/>
                            </div>

                            <div>
                              <small  class="text-danger">
                                <?php 
                                  if($_SESSION['message']){
                                    echo $_SESSION['message'];
                                  }
                                  unset($_SESSION['message'])
                                ?>
                              </small>
                            </div>
      
                            <div class="d-flex justify-content-end mb-3">
                              <button type="submit" class="btn btn-primary btn-rounded" type="button" style="background-color: #92aad0;">Log in</button>
                            </div>
                            <hr>
                            <a class="link float-end" href="registration.php">Want to create a new account? Click here.</a>

                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      <script src="assets/script.js"></script>
</body>
</html>