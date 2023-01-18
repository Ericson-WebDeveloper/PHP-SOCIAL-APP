
<!-- <div class="overlay_loader hide_loader" id="loader_div">
    <div class="overlay__inner__loader">
        <div class="loader"></div> 
        <div class="overlay__content__loader">-->
            <span class="loader"></span>
        <!-- </div>
    </div>
</div> -->

<style>
.hide_loader{
    display: none;
}
/* .overlay_loader{
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    position: fixed;
    background: rgba(0,0,0,.5);
}

.overlay__inner__loader {
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    position: absolute;
}
.overlay__content__loader {
    left: 50%;
    position: absolute;
    top: 35%;
    
} */

.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid blue;
  border-right: 16px solid green;
  border-bottom: 16px solid red;
  border-left: 16px solid pink;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
