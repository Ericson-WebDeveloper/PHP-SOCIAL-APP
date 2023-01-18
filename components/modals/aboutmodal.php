

<!-- Modal -->
<div class="modal fade" id="about_user_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" 
aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Post New Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="about_add_form" method="post">
            <div class="mb-3">
                <label for="about_category" class="form-label">Select Category</label>
                <select name="about_category" id="about_category" class="form-control">
                    <option value="Status">Status</option>
                    <option value="Job">Job</option>
                    <option value="Place of Birth">Place of Birth</option>
                    <option value="School">School</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="about_data" class="form-label">About</label>
                <input type="text" class="form-control" id="about_data">
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
  document.getElementById("about_add_form").addEventListener("submit", async (e) => {
    e.preventDefault();
    try {
      let form = new FormData();
        form.append('category', document.getElementById("about_category").value);
        form.append('about', document.getElementById("about_data").value);
        form.append('add-new-about', true);
          loader.classList.remove('d-none');
          let response = await fetch('./controller/UserController.php', {method: 'POST', body: form});
          response = await response.json();
          if(response.status == 200) {
              successAlert('Added new About Data Success!.');
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