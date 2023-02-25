<?php
session_start();
if (isset($_SESSION['user'])) {
  header("Location: profile.php");
}

var_dump(scandir("vendor"));

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/loader.css">
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <title>PHP PUSHER - CHAT</title>
</head>

<body>
  <section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
          <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
              <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                  <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign In</p>

                  <form class="mx-1 mx-md-4">

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="email" id="email" class="form-control" />
                        <label class="form-label" for="email">Your Email</label>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="password" id="password" class="form-control" />
                        <label class="form-label" for="password">Password</label>
                      </div>
                    </div>

                    <div class="form-check d-flex justify-content-center mb-5">
                      <!-- <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" /> -->
                      <label class="form-check-label" for="form2Example3">
                        Don't Have Account? <a href="./register.php">Register</a>
                      </label>
                    </div>

                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      <button type="button" class="btn btn-primary btn-lg" id="btn-login-submit">Login</button>
                    </div>
                  </form>
                </div>
                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                  <img src="./assets/images/social-media-bg.jpg" class="img-fluid" alt="Sample image">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="loading loader d-none" id="loader_loader">Loading&#8230;</div>
</body>

</html>

<script type="module">
  import {
    errorAlert,
    successAlert
  } from './public/js/Toast.js';
  let loader = document.getElementById("loader_loader");

  document.getElementById("btn-login-submit").addEventListener("click", async (e) => {
    e.preventDefault();
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    let form = new FormData();
    form.append('email', email);
    form.append('password', password);
    form.append('login--user', true);

    try {
      loader.classList.remove('d-none');
      let response = await fetch('./controller/AuthController.php', {
        method: 'POST',
        body: form
      });
      response = await response.json();
      if (response.status == 200) {
        successAlert('Login Success!');
        setTimeout(() => {
          window.location.replace('./profile.php')
        }, 1000);
      } else {
        if (response.status == 400) {
          let error = response.error ? response.error : response.errors;
          errorAlert(error);
        } else if (response.status == 500) {
          let error = response.error ? response.error : response.errors;
          errorAlert(error);
        } else if (response.status == 422) {
          let keys = Object.keys(response.errors);
          keys.forEach((key) => {
            errorAlert(response.errors[key], "center")
          });
        } else {
          errorAlert('Sorry An error occurred while processing your request. please try again later.');
        }
      }
    } catch (error) {
      errorAlert('Sorry An error occurred while processing your request. please try again later.');
    } finally {
      loader.classList.add('d-none');
    }
  });
</script>

<style>
  .navbar-light .navbar-nav .nav-link {
    color: #fafafa !important;
  }

  .navbar-light .navbar-brand {
    color: #fafafa;
  }

  .navbar-light .navbar-nav .nav-link:hover {
    color: #d1c4e9;
  }
</style>
