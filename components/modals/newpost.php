<!-- Modal -->
<div class="modal fade" id="post_new_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" 
aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Post New Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="post_form" method="post">
            <div class="mb-3">
                <label for="text_post" class="form-label">Text</label>
                <textarea class="form-control" id="text_post" placeholder="Post Contet"></textarea>
            </div>
            <div class="mb-3">
                <label for="post_iamge" class="form-label">images *Optional</label>
                <input type="file" class="form-control" id="post_iamge">
                <img src="" id="post_image_upload" class="rounded mx-auto d-block visually-hidden"  data-key-reference style="width: 300px; height: 250px;" alt="">
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
  import {errorAlert, successAlert}  from '<?= ASSET ?>/js/Toast.js';
  import {imageToBase64} from '<?= ASSET ?>/js/ImageHelper.js';
  let loader = document.getElementById("loader_loader");
  CKEDITOR.replace('text_post');
  document.getElementById("post_form").addEventListener("submit", async (e) => {
    e.preventDefault();
      
        try {
          let form = new FormData();
        //   let details = document.getElementById("text_post").value;
          let details = CKEDITOR.instances['text_post'].getData();
          
          form.append('image', document.getElementById("post_image_upload").dataset.keyReference);
          form.append('details', details);
          form.append('post-new-post-data', true);
            loader.classList.remove('d-none');
            let response = await fetch(`<?= CONTROLLER ?>/PostController.php`, {method:'POST', body: form});
            response = await response.json();
            console.log(response);
            if(response.status == 200) {
                  successAlert(response.message || 'Request Success.');
                  window.location.reload();
            } else {
                if (response.status == 400) {
                    errorAlert(response.error || response.errors);
                } else if (response.status == 500) {
                    errorAlert(response.error || response.errors);
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

  document.getElementById("post_iamge").addEventListener("change", (e) => {
        e.preventDefault();
        console.log()
        if(!['jpeg','jpg', 'png'].includes(e.target.files[0].type.split('/')[1])) {
            errorAlert('File was Invalid');
            return false;
        }
        imageToBase64(e.target, (image) => {
            document.getElementById("post_image_upload").classList.remove("visually-hidden");
            document.getElementById("post_image_upload").src = image;
            document.getElementById("post_image_upload").dataset.keyReference = image;
        });
    });
</script>