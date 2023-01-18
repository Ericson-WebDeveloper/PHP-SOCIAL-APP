<!-- Modal -->
<div class="modal fade" id="profile_login_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" 
aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Update Profile Login Credentials</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="profile_logincred_form" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $_SESSION['user']->email ?>">
            </div>
            <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="**********">
                </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" placeholder="**********">
            </div>  
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </div>
  </div>
</div>

<script type="module">
import {errorAlert, successAlert}  from './public/js/Toast.js';
let loader = document.getElementById("loader_loader");
document.getElementById("profile_logincred_form").addEventListener("submit", async (e) => {
    e.preventDefault();
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        let c_password = document.getElementById("confirm_password").value;
        if(password == '' || c_password == '') {
            errorAlert("Password are required");
            return false;
        }
        if(password !== c_password) {
            errorAlert("Password not matched");
            return false;
        }
        let form = new FormData();
        form.append('password', password);
        form.append('email', email);
        form.append('update-login_credential-datas', true);
        try {
            loader.classList.remove('d-none');
            let response = await fetch('./controller/UserController.php', {method: 'POST', body: form});
            response = await response.json();
            if(response.status == 200) {
                successAlert('Updating Login Credentials Success!.');
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
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
        } catch (error) {
            errorAlert('Sorry An error occurred while processing your request. please try again later.');
        } finally {
            loader.classList.add('d-none');
        }
});
</script>