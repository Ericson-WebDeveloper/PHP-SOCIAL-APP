<!-- Modal -->
<div class="modal fade" id="profile_avatar_modal" 
data-bs-backdrop="static" data-bs-keyboard="false" 
tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Update Profile Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form_profile_picture_update">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">New Profile Picture</label>
                <input type="file" class="form-control" id="avatar_pic" aria-describedby="emailHelp">
            </div>
            <div class="mb-3 visually-hidden" id="image_preview">
                <img src="" class="rounded mx-auto d-block" data-key-reference  id="profile_pic" style="width: 300px; height: 250px;" alt="">
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
import {imageToBase64} from './public/js/ImageHelper.js';
    document.getElementById("image_preview").classList.add("visually-hidden");
    document.getElementById("form_profile_picture_update").addEventListener("submit", async (e) => {
        e.preventDefault();
        let form = new FormData();
        form.append('picture', document.getElementById("profile_pic").dataset.keyReference);
        form.append('update-profilepic-user', true);
        // try {
          let response = await fetch(`./controller/UserController.php`, {method:'POST', body: form});
          response = await response.json();
    ;
          if(response.status == 200) {
                successAlert(response.message || 'Request Success.');
                document.getElementById("image_preview").classList.add("visually-hidden");
                document.getElementById("profile_pic").src = '';
                window.location.reload();
           } else {
                if (response.status == 400) {
                    errorAlert(response.error || response.errors);
                } else if (response.status == 500) {
                    errorAlert(response.error || response.errors);
                } else if (response.status == 422) {
                    // let keys = Object.keys(response.errors);
                    // keys.forEach((key) => {
                    //     errorAlert(response.errors[key], "center")
                    // });
                } else {
                    errorAlert('Sorry An error occurred while processing your request. please try again later.');
                }
           }
        // } catch (error) {
        //   errorAlert('Sorry An error occurred while processing your request. please try again later.');
        // }
    });

    document.getElementById("avatar_pic").addEventListener("change", (e) => {
        e.preventDefault();
        if(!['jpeg','jpg', 'png'].includes(e.target.files[0].type.split('/')[1])) {
            errorAlert('File was Invalid');
            return false;
        }
        imageToBase64(e.target, (image) => {
            document.getElementById("image_preview").classList.remove("visually-hidden");
            document.getElementById("profile_pic").src = image;
            document.getElementById("profile_pic").dataset.keyReference = image;
        });
    });

</script>