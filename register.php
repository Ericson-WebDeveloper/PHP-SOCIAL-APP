<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <title>PHP SOCIAL APP</title>
</head>

<body>

    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-1">
                                    <img src="./assets/images/social-media-bg.jpg" class="img-fluid" alt="Sample image">
                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-2">
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-2">Sign up</p>
                                    <form class="mx-1 mx-md-4">
                                        <div class="d-flex flex-row align-items-center mb-1">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" id="fname" class="form-control" />
                                                <label class="form-label" for="fname">First Name</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-1">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" class="form-control" id="lname" />
                                                <label class="form-label" for="fname">Last Name</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-1">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="email" id="email" class="form-control" />
                                                <label class="form-label" for="email">Your Email</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-1">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" id="password" class="form-control" />
                                                <label class="form-label" for="password">Password</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-1">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="row">
                                                <h6>Birthday</h6>
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="month" class="form-label">Month</label>
                                                        <select name="month" id="month" class="form-control">
                                                            <option value="1">January</option>
                                                            <option value="2">February</option>
                                                            <option value="3">March</option>
                                                            <option value="4">April</option>
                                                            <option value="5">May</option>
                                                            <option value="6">June</option>
                                                            <option value="7">July</option>
                                                            <option value="8">August</option>
                                                            <option value="9">September</option>
                                                            <option value="10">October</option>
                                                            <option value="11">November</option>
                                                            <option value="12">December</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="day" class="form-label">Day</label>
                                                        <select name="day" id="day" class="form-control">
                                                            <?php for ($i = 1; $i < 32; $i++) : ?>
                                                                <option value="<?= $i ?>"><?= $i ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="year" class="form-label">Year</label>
                                                        <input type="number" class="form-control" id="year" placeholder="2001">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <input class="form-check-input" type="radio" name="gender-user" id="gender" value="Male" checked>
                                                        <label class="form-check-label" for="gender">
                                                            Male
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <input class="form-check-input" type="radio" name="gender-user" id="gender" value="Female">
                                                        <label class="form-check-label" for="gender">
                                                            Female
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <input class="form-check-input" type="radio" name="gender-user" id="gender" value="Custom">
                                                        <label class="form-check-label" for="gender">
                                                            Custom
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-check d-flex justify-content-center mb-5">

                                            <label class="form-check-label" for="form2Example3">
                                                Already hav an Account? <a href="./login.php">Login</a>
                                            </label>
                                        </div>
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="button" class="btn btn-primary btn-lg" id="submit-reg">Register</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>

<script type="module">
    import {
        errorAlert,
        successAlert
    } from './public/js/Toast.js';

    document.getElementById("submit-reg").addEventListener("click", async (e) => {
        e.preventDefault();
        let fname = document.getElementById("fname").value;
        let lname = document.getElementById("lname").value;
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        let month = document.getElementById("month").value;
        let year = document.getElementById("year").value;
        let gender = document.querySelector('input[id="gender"]:checked').value;
        let day = document.getElementById("day").value;

        let form = new FormData();
        form.append('fname', fname);
        form.append('lname', lname);
        form.append('email', email);
        form.append('password', password);
        form.append('month', month);
        form.append('year', year);
        form.append('day', day);
        form.append('gender', gender);
        form.append('register-new-user', true);

        try {
            // loader.classList.remove("hide_loader");
            let response = await fetch('./controller/AuthController.php', {
                method: 'POST',
                body: form
            });
            response = await response.json();
            if (response.status == 200) {
                successAlert('Register Complete! you can login now!');
                setTimeout(() => {
                    window.location.replace('./login.php')
                }, 2000);
            } else {
                if (response.status == 400) {
                    errorAlert(response.error && response.errors);
                } else if (response.status == 500) {
                    errorAlert(response.error && response.errors);
                } else if (response.status == 422) {
                    let keys = Object.keys(response.errors);
                    keys.forEach((key) => {
                        errorAlert(response.errors[key], "center")
                    });
                } else {
                    errorAlert('Sorry An error occurred while processing your request. please try again later.');
                }
            }
        } catch {
            errorAlert('Sorry An error occurred while processing your request. please try again later.');
        }
    });
</script>

<style>
    .navbar-light .navbar-nav .nav-link {
        color: #fafafa !important;
    }

    .navbar-light .navbar-brand {
        color: #fafafa !important;
    }

    .navbar-light .navbar-nav .nav-link:hover {
        color: #d1c4e9 !important;
    }
</style>
