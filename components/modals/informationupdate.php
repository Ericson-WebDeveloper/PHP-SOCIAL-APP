

<!-- Modal -->
<div class="modal fade" id="profile_information_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" 
aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Update Profile Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="updateinfo_form" method="post">
            <div class="mb-3">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fname" placeholder="First Name" value="<?php echo $_SESSION['user']->first_name ?>">
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lname" placeholder="Last Name" value="<?php echo $_SESSION['user']->last_name ?>">
            </div>
            <!-- <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $_SESSION['user']->email ?>">
            </div> -->
            <div class="row">
                <h6>Birthday</h6>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="month" class="form-label">Month</label>
                        <select name="month" id="month" class="form-control">
                            <option value="1" 
                            <?php echo explode("-", $_SESSION['user']->bday)[1] == '1' ? 'selected' : '' ?>>January</option>
                            <option value="2" 
                            <?php echo explode("-", $_SESSION['user']->bday)[1] == '2' ? 'selected' : '' ?>>February</option>
                            <option value="3"
                            <?php echo explode("-", $_SESSION['user']->bday)[1] == '3' ? 'selected' : '' ?>>March</option>
                            <option value="4"
                            <?php echo explode("-", $_SESSION['user']->bday)[1] == '4' ? 'selected' : '' ?>>April</option>
                            <option value="5"
                            <?php echo explode("-", $_SESSION['user']->bday)[1] == '5' ? 'selected' : '' ?>>May</option>
                            <option value="6"
                            <?php echo explode("-", $_SESSION['user']->bday)[1] == '6' ? 'selected' : '' ?>>June</option>
                            <option value="7"
                            <?php echo explode("-", $_SESSION['user']->bday)[1] == '7' ? 'selected' : '' ?>>July</option>
                            <option value="8"
                            <?php echo explode("-", $_SESSION['user']->bday)[1] == '8' ? 'selected' : '' ?>>August</option>
                            <option value="9"
                            <?php echo explode("-", $_SESSION['user']->bday)[1] == '9' ? 'selected' : '' ?>>September</option>
                            <option value="10"
                            <?php echo explode("-", $_SESSION['user']->bday)[1] == '10' ? 'selected' : '' ?>>October</option>
                            <option value="11"
                            <?php echo explode("-", $_SESSION['user']->bday)[1] == '11' ? 'selected' : '' ?>>November</option>
                            <option value="12"
                            <?php echo explode("-", $_SESSION['user']->bday)[1] == '12' ? 'selected' : '' ?>>December</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="day" class="form-label">Day</label>
                        <select name="day" id="day" class="form-control">
                            <?php for($i = 1; $i < 32; $i++): ?>
                                <?php if(explode("-", $_SESSION['user']->bday)[2] == $i) { ?>
                                    <option value="<?= $i ?>" selected><?= $i ?></option>
                                <?php  } else {?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php } ?>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" class="form-control" id="year" value="<?php echo explode("-", $_SESSION['user']->bday)[0]; ?>">
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <input class="form-check-input" type="radio" name="gender-user" id="gender" value="Male" 
                        <?php if($_SESSION['user']->gender == 'Male') {?> 
                            checked 
                        <?php } ?>>
                        <label class="form-check-label" for="gender">
                            Male
                        </label>
                    </div>
                </div>
                                
                <div class="col-4">
                    <div class="mb-3">
                        <input class="form-check-input" type="radio" name="gender-user" id="gender" value="Female"
                        <?php if($_SESSION['user']->gender == 'Female') {?> 
                            checked 
                        <?php } ?>>
                        <label class="form-check-label" for="gender">
                            Female
                        </label>
                    </div>
                </div>
                <!-- <div class="col-4">
                    <div class="mb-3">
                        <input class="form-check-input" type="radio" name="gender-user" id="gender" value="Custom">
                        <label class="form-check-label" for="gender">
                            Custom
                        </label>
                    </div>
                </div>       -->
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
document.getElementById("updateinfo_form").addEventListener("submit", async (e) => {
        e.preventDefault();
        let fname = document.getElementById("fname").value;
        let lname = document.getElementById("lname").value;
        // let email = document.getElementById("email").value;
        let month = document.getElementById("month").value;
        let year = document.getElementById("year").value;
        let gender = document.querySelector('input[id="gender"]:checked').value;
        let day = document.getElementById("day").value;

        let form = new FormData();
        form.append('first_name', fname);
        form.append('last_name', lname);
        // form.append('email', email);
        form.append('month', month);
        form.append('year', year);
        form.append('day', day);
        form.append('gender', gender);
        form.append('update-profile-datas', true);
        try {
            loader.classList.remove('d-none');
           let response = await fetch('./controller/UserController.php', {method: 'POST', body: form});
           response = await response.json();
           if(response.status == 200) {
                successAlert('Updating Information Complete!.');
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