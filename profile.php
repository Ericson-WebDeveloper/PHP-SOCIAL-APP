<?php require_once('./components/header.php'); ?>
<?php require_once('./components/navbar.php'); ?>
<?php
// echo $_SESSION['user']->id;
?>
<div class="row py-5 px-4">
    <div class="col-md-6 mx-auto">
        <!-- Profile widget -->
        <div class="bg-white shadow rounded overflow-hidden">
            <div class="px-4 pt-0 pb-4 cover">
                <div class="media align-items-end profile-head">
                    <div class="profile mr-3">
                        <img src="<?php echo $_SESSION['user']->profile == 'default-profile.png' ? './public/images/default-profile.png' : $_SESSION['user']->profile; ?>" alt="..." width="130" height="100" class="rounded mb-2 img-thumbnail">
                    </div>
                    <div class="media-body mb-5 text-white">
                        <div class="btn-group align-middle">
                            <h4 class="mt-0 mb-0"><?php echo $_SESSION['user']->first_name . ' ' . $_SESSION['user']->last_name ?></h4>
                            <i class="fas fa-ellipsis-v dropdown-toggle-split mt-1" style="cursor: pointer;" data-bs-toggle="dropdown" style="color: white;"></i>

                            <ul class="dropdown-menu list_action_dropdown_click">
                                <!-- list-group-item 
                                list-group-item-action -->
                                <li class="list_action_dropdown list-group-item 
                                list-group-item-action" data-bs-toggle="modal" data-bs-target="#profile_information_modal">
                                    <span class="ml-3">Edit Information</span>
                                </li>
                                <span class="list_action_dropdown list-group-item 
                                list-group-item-action" data-bs-toggle="modal" data-bs-target="#profile_avatar_modal">
                                    <span>Edit Picture</span>
                                </span>
                                <span class="list_action_dropdown list-group-item 
                                list-group-item-action" data-bs-toggle="modal" data-bs-target="#profile_login_modal">
                                    <span>Edit Login Credentials</span>
                                </span>

                            </ul>
                        </div>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
            <div class="bg-light p-4 d-flex justify-content-end text-center">
                <ul class="list-inline mb-0">

                    <li class="list-inline-item">
                        <h5 class="font-weight-bold mb-0 d-block" id="friends_count">745</h5><small class="text-muted"> <i class="fas fa-user mr-1"></i> friends</small>
                    </li>

                </ul>
            </div>
            <div class="px-4 py-3">
                <h5 class="mb-0">About
                    <i class="fas fa-ellipsis-v dropdown-toggle-split mt-1" data-bs-toggle="dropdown" style="cursor: pointer; color: black;"></i>
                    <ul class="dropdown-menu list_action_dropdown_click">
                        <li class="list_action_dropdown list-group-item 
                        list-group-item-action" data-bs-toggle="modal" data-bs-target="#about_user_modal">
                            <span class="ml-3">Add New</span>
                        </li>
                    </ul>
                </h5>

                <div class="p-4 rounded shadow-sm bg-light" id="about_details_user">
                    <p class="font-italic mb-0"><b>BirthDay:</b> <?= date("Y F d", strtotime($_SESSION['user']->bday)); ?></p>
                    <p class="font-italic mb-0"><b>Gender:</b> <?= $_SESSION['user']->gender; ?></p>
                </div>
            </div>
            <div class="py-4 px-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0">Recent photos</h5><span id="btn_show_all_photos" class="btn btn-link text-muted">Show all</span>
                </div>
                <div class="row" id="recent_photos_div">

                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
<?php include('./components/modals/aboutmodal.php'); ?>
<?php include('./components/modals/profileupdate.php'); ?>
<?php include('./components/modals/informationupdate.php'); ?>
<?php include('./components/modals/logincredupdate.php'); ?>
<?php include('./components/modals/photos.php'); ?>

<script type="module">
    import {
        errorAlert,
        successAlert
    } from '<?= ASSET ?>/js/Toast.js';
    let loader = document.getElementById("loader_loader");

    let userdata = "<?php echo $_SESSION['user']->id ?>";
    let photosGalleryModal = new bootstrap.Modal(document.getElementById("photos_gallery_modal"), {});
    const renderImagesRecent = (datas) => {
        let containerImages = document.getElementById("recent_photos_div");
        containerImages.innerHTML = '';

        datas?.forEach((post) => {
            let newimages = ''
            newimages = `<img src="${post.image}" alt="" class="img-fluid rounded shadow-sm">`;
            let div = document.createElement("div");
            div.classList.add("col-lg-6");
            div.classList.add("mb-2")
            div.classList.add("pr-lg-1")
            div.innerHTML = newimages;
            containerImages.appendChild(div);
        });
    }

    const renderAbouts = (datas) => {
        let containerAbouts = document.getElementById("about_details_user");
        // containerAbouts.innerHTML = '';
        let abouts = datas?.map((about) => {
            return `<p class="font-italic mb-0"><b>${about.category}:</b> ${about.text}</p>`;
        }).join(" ");
        let span = document.createElement("span");
        span.innerHTML = abouts;
        containerAbouts.appendChild(span);
    }

    const fetchAbouts = async () => {
        try {
            loader.classList.remove('d-none');
            let response = await fetch(`<?= CONTROLLER ?>/UserController.php?fetch-all-about=${true}`);
            response = await response.json();
            if (response.abouts.length > 0) renderAbouts(response.abouts);
        } catch (error) {
            console.log(error);
        } finally {
            loader.classList.add('d-none');
        }
    }

    const renderImagesRecentAll = (datas) => {
        let containerImages = document.getElementById("gallery_photos_recent");
        // containerImages.innerHTML = '';
        datas.forEach((post) => {
            let newimages = ''
            newimages = `<img src="${post.image}" alt="" class="img-fluid rounded shadow-sm">`;
            let div = document.createElement("div");
            div.classList.add("col-12");
            div.classList.add("col-sm-6");
            div.classList.add("col-lg-3");
            div.classList.add("mb-4");
            div.innerHTML = newimages;
            console.log(div);
            containerImages.appendChild(div);
        });

    }

    const getRecentPhotos = async (showall) => {
        try {
            loader.classList.remove('d-none');
            let response = await fetch(`<?= CONTROLLER ?>/PostController.php?fetch-recent-photos-post=${true}&getall=${showall}`);
            response = await response.json();
            if (response.photospost.length > 0) {
                if (showall) {
                    renderImagesRecentAll(response.photospost);
                    photosGalleryModal.show();
                } else {
                    renderImagesRecent(response.photospost);
                }
            }
        } catch (error) {
            console.log(error);
        } finally {
            loader.classList.add('d-none');
        }
    }

    const getFirendsCount = async () => {
        try {
            loader.classList.remove('d-none');
            let response = await fetch(`<?= CONTROLLER ?>/UserController.php?get-all-counts-friend=${true}`);
            response = await response.json();
            document.getElementById("friends_count").textContent = response.counts[0].total_friend;
        } catch (error) {
            errorAlert('Unable to connect in Server.')
        } finally {
            loader.classList.add('d-none');
        }
    }

    document.getElementById("btn_show_all_photos").addEventListener("click", async (e) => {
        e.preventDefault();
        await getRecentPhotos(true);
    })

    getFirendsCount();
    getRecentPhotos(false);
    fetchAbouts();
</script>
<style>
    .list_action_dropdown_click {
        padding: 0;
        width: 250px;
    }

    .list_action_dropdown {
        padding: 5px;
        width: auto;
        cursor: pointer;
    }

    .list_action_dropdown:hover {
        background-color: lightgray;
    }


    .profile-head {
        transform: translateY(5rem)
    }

    .cover {
        background-image: url(https://images.unsplash.com/photo-1530305408560-82d13781b33a?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1352&q=80);
        background-size: cover;
        background-repeat: no-repeat
    }

    .navbar .navbar-nav .nav-link {
        color: #000000;
        font-size: 1.1em;
    }

    .navbar .navbar-nav .nav-link:hover {
        color: #808080;
    }

    .sm-icons {
        flex-direction: row;
    }

    @media only screen and (max-width: 960px) {
        .sm-icons .nav-item {
            padding-right: 1em;
        }

        .navbar-nav .nav-item {
            margin-left: 20px;
        }
    }
</style>
