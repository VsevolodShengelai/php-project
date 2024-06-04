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
                        <img src="assets/images/sidenav.jpg" alt="login form" class="img-fluid" style="border-top-left-radius: 1rem; border-bottom-left-radius: 1rem; height: 100%" />
                      </div>
                      <div class="col-md-8 d-flex align-items-center">
                        <div class="card-body py-5 px-4 p-md-3">
      
                          <form action="server/signup.php" method="post">
                            <h4 class="fw-bold mb-3" style="color: #92aad0;">Register a new account</h4>
                            <p class="mb-3" style="color: #45526e;">To register a new account, please fill in these text fiels with your login, e-mail address, telephone number and password.</p>

                            <div class="form-outline mb-4 input-container">
                              <input id="login" name="login" class="input form-control" type="text" placeholder=" "
                              value = "<?php 
                                echo $_SESSION['POST']['login'];
                                unset($_SESSION['POST']['login']);?>"
                              />
                              <div class="cut cut-middle"></div>
                              <label for="login" class="placeholder">Name (Login)</label>
                              <small class="text-danger">
                                <?php 
                                  echo $_SESSION['errors']['login'];
                                  unset($_SESSION['errors']['login']);
                                ?>
                              </small>
                            </div>

                            <div class="form-outline mb-4 input-container">
                              <input id="password" name="password" class="input form-control" type="password" placeholder=" "
                                value = "<?php 
                                  echo $_SESSION['POST']['password'];
                                  unset($_SESSION['POST']['password']);?>"
                              />
                              <div class="cut cut-short"></div>
                              <label for="password" class="placeholder">Password</label>
                              <small class="text-danger">
                                <?php 
                                  echo $_SESSION['errors']['password'];
                                  unset($_SESSION['errors']['password']);
                                ?>
                              </small>
                            </div>

                            <div class="form-outline mb-4 input-container">
                              <input id="confirm_password" name="confirm_password" class="input form-control" type="password" placeholder=" "
                              value = "<?php 
                                echo $_SESSION['POST']['confirm_password'];
                                unset($_SESSION['POST']['confirm_password']);?>"
                              />
                              <div class="cut cut-middle-plus"></div>
                              <label for="confirm_password" class="placeholder">Confirm password</label>
                              <small class="text-danger">
                                <?php 
                                  echo $_SESSION['errors']['confirm_password'];
                                  unset($_SESSION['errors']['confirm_password']);
                                ?>
                              </small>
                            </div>
      
                            <div class="d-flex justify-content-end mb-3">
                              <button type="submit" class="btn btn-primary btn-rounded" style="background-color: #92aad0;">Register</button>
                            </div>
                            <hr>
                            <a class="link float-end" href="index.php">Do you already have an account? Login</a>
                            <div>
                              <span>
                                <?php 
                                  if($_SESSION['message']){
                                    echo $_SESSION['message'];
                                  }
                                  unset($_SESSION['message']);
                                ?>
                              </span>
                            </div>
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
      <script src="script.js"></script>
</body>
</html>