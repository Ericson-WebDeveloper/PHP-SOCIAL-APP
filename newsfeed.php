<?php require_once('./components/header.php'); ?>
<?php require_once('./components/navbar.php'); ?>

<div class="container mt-5 mb-5">
    <div class="row d-flex align-items-center justify-content-center">
        
        <div class="col-md-6">
            <!--  -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#post_new_modal">
                New Post
            </button>
            <br><br>
            <div id="posts_container_div">
            </div>
        </div>
    </div>
</div>
<?php include('./components/modals/newpost.php'); ?>
</body>
</html>
<script type="module">
import {errorAlert, successAlert}  from '<?= ASSET ?>/js/Toast.js';
import CommentAlert from '<?= ASSET ?>/js/CommentAlert.js';
    let commentalert = new CommentAlert();
    let loader = document.getElementById("loader_loader");
    let offset = 0;
    let scroll = true;
    let postdiv = document.getElementById("posts_container_div");
    

    const displayComments = (ref, datas) => {
        let div = document.getElementById(`comments_container_div_${ref}`);
        div.innerHTML = '';
            datas.forEach((comment) => {
                let commentElement = '';
                // <small>Like</small> 
                // <small>Reply</small> 
                // <small>Translate</small> 
                commentElement = ` <div class="d-flex flex-row mb-2"> <img src="${comment.profile == 'default-profile.png' ? './public/images/default-profile.png' : comment.profile}" 
                width="40" class="rounded-image me-2">
                                    <div class="d-flex flex-column ml-2"> <span class="name">${comment.first_name + ' ' + comment.last_name}</span> 
                                    <small class="comment-text">${comment.comment}</small>
                                        <div class="d-flex flex-row align-items-center status"> 

                                        <small>${moment(comment.created_at).calendar() }</small> </div>
                                    </div>
                                </div>`;
                let span = document.createElement("span");
                span.innerHTML = commentElement;
                div.appendChild(span);
            });
    }

    // const displayNewComment = (ref, comment) => {
    //     let div = document.getElementById(`comments_container_div_${ref}`);
    //     const span = document.createElement("span");

    //     let newC = `<div class="d-flex flex-row mb-2"> <img src="${comment.profile == 'default-profile.png' ? './public/images/default-profile.png' : comment.profile}" 
    //         width="40" class="rounded-image me-2">
    //         <div class="d-flex flex-column ml-2"> <span class="name">${comment.first_name + ' ' + comment.last_name}</span> 
    //         <small class="comment-text">${comment.comment}</small>
    //             <div class="d-flex flex-row align-items-center status"> 

    //             <small>${moment(comment.created_at).calendar() }</small> </div>
    //         </div>
    //     </div>`;
    // }

    const putOpenComment = (ref) => {
        document.getElementById(`comment_btn_${ref}`).addEventListener("click", async (e) => {
            e.preventDefault();
            let offfset;
            let post_id;
            let shoudlRun = true;
            offfset = e.target.dataset.keyPostOffset;
            post_id = e.target.dataset.keyPostReference;
            // get comments  
            if(offfset == 0) {
                try {
                    let response = await fetch(`<?= CONTROLLER ?>/PostController.php?fetch-all-news-comments=${true}&postId=${post_id}&offset=${offfset}`);
                    response = await response.json();
                    if(response.comments.length > 0) {
                        displayComments(post_id, response.comments);
                        e.target.dataset.keyPostOffset = 5 + parseInt(offfset);
                    } else {
                        successAlert(offfset > 0 ? 'No More Comments' : 'No Comments');
                    }
                } catch (error) {
                    errorAlert(`Cannot fetch comments.`);
                } finally {
                    
                }   
            }
        });
        // document.querySelectorAll(".post_comment_open").forEach((btn) => {
        // });
    }

    const callBackAfterComment = async (ref, total_comments, commentId) => {
        // document.getElementById(`comment_btn_${ref}`).click();
        let response;
        let offset = document.getElementById(`comment_btn_${ref}`) 
        // typeof(element) != 'undefined' && element != null;
        // check if div or element is exist
        if(typeof(offset) != 'undefined' && offset != null && offset.dataset.keyPostOffset != 0) {
            try {
                response = await fetch(`<?= CONTROLLER ?>/PostController.php?fetch-comment=${true}&commentId=${commentId}`);
                response = await response.json();
            } catch (error) {
                response = null;
            }
            if(response) {
                let {comment} = response;
                let newcommentEle = ` <div class="d-flex flex-row mb-2"> <img src="${comment.profile == 'default-profile.png' ? './public/images/default-profile.png' : comment.profile}" 
                    width="40" class="rounded-image me-2">
                                        <div class="d-flex flex-column ml-2"> <span class="name">${comment.first_name + ' ' + comment.last_name}</span> 
                                        <small class="comment-text">${comment.comment}</small>
                                            <div class="d-flex flex-row align-items-center status"> 

                                            <small>${moment(comment.created_at).calendar() }</small> </div>
                                        </div>
                                    </div>`;
                let span = document.createElement("span");
                span.innerHTML = newcommentEle;
                let commentsDiv = document.getElementById(`comments_container_div_${ref}`);
                if(typeof(commentsDiv) != 'undefined' && commentsDiv != null) {
                    commentsDiv.insertBefore(span, commentsDiv.firstChild);
                }
                
            }
        }
        if(typeof(offset) != 'undefined' && offset != null) {
            document.getElementById(`comment_btn_${ref}`).textContent = `${total_comments} comments`;
        }
        
        // fix comment add new comment to fisrt element
    }

    commentalert.bindCommentEvent(callBackAfterComment);

    const commentUploadListener = (ref) => {
        document.getElementById(`comment_input_field_${ref}`).addEventListener("keypress", async (e) => {
            if (e.key === "Enter") {
                let post_id = ref;
                let comment = document.getElementById(`comment_input_field_${ref}`).value;
                if(comment == '') {
                    return false;
                }
                let form = new FormData();
                form.append('postId', post_id);
                form.append('comment', comment);
                form.append('post-new-comments', true);
                try {
                    loader.classList.remove('d-none');
                    let response = await fetch(`<?= CONTROLLER ?>/PostController.php`, {method:'POST', body: form});
                    response = await response.json();
                    if(response.status == 200) {
                        document.getElementById(`comment_btn_${ref}`).click();
                        successAlert(response.message || 'Request Success.');
                        document.getElementById(`comment_input_field_${ref}`).value = '';
                        // display or mount new comment\
                        // pusher broadcast;
                        // console.log(response.total_comments.total_comments);
                        // console.log(response.comment); // comment id
                        // callBackAfterComment(post_id, total_comments);
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
                    // console.log(error);
                    errorAlert('Sorry An Server error encounter while processing your request. please try again later.');
                } finally {
                    loader.classList.add('d-none');
                }
            }
        });
    }

    const renderNewsFeed = (datas) => {
        datas?.forEach((post) => {
            let postscontent = '';
            postscontent = `<div class="card" id="post_main_div_${post.post_id}">
                        <div class="d-flex justify-content-between p-2 px-3">
                            <div class="d-flex flex-row align-items-center"> 
                                <img src="${post.profile == 'default-profile.png' ? './public/images/default-profile.png' : post.profile}" width="50" 
                                class="rounded-circle">
                                <div class="d-flex flex-column ms-2"> <span class="font-weight-bold">
                                ${post.first_name+ ' ' + post.last_name}</span> 
                                    <small class="text-primary">Collegues</small> 
                                </div>
                            </div>
                            <div class="d-flex flex-row mt-1 ellipsis"> <small class="mr-2">${moment(post.created_at).calendar() } </small> 
                            <i class="fa fa-ellipsis-h ms-2"></i> </div>
                        </div> <img src="${post.image}" class="img-fluid">
                        <div class="p-2">
                            <p class="text-justify">${post.details}</p>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-row icons d-flex align-items-center"> 
                                <i class="fa fa-heart"></i> <i class="fa fa-smile-o ml-2"></i> </div>
                                <div class="d-flex flex-row muted-color"> 
                                <span data-key-post-reference="${post.post_id}" data-key-post-offset="0" 
                                    class="post_comment_open" id="comment_btn_${post.post_id}" style="cursor:pointer;">
                                        ${post.comments_count == 0 ? '' : post.comments_count} comments
                                    </span> 
                                </div>
                            </div>
                            <hr>
                            <div class="comments">
                                <div id="comments_container_div_${post.post_id}">
                                   
                                </div>
                                <div class="comment-input"> 
                                    <input type="text" id="comment_input_field_${post.post_id}" class="form-control comment_input" 
                                    data-key-post-reference="${post.post_id}">
                                    <div class="fonts"> 
                                        <i class="fa fa-camera"></i> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>`;
                
                let span = document.createElement("span");
                span.innerHTML = postscontent;
                postdiv.appendChild(span);
                putOpenComment(post.post_id);
                commentUploadListener(post.post_id);
        });
        // putOpenComment();
        // document.getElementById("posts_container_div").innerHTML = postscontent;
    }

    const fetchNewFeed = async () => {
        try {
            loader.classList.remove('d-none');
            let response = await fetch(`<?= CONTROLLER ?>/PostController.php?fetch-all-newsfeed=${true}&offset=${offset}`);
            response = await response.json();
            renderNewsFeed(response.posts);
            offset += 5;
        } catch (error) {
            errorAlert('Sorry An error occurred while processing your request. please try again later.');
            console.log(error)
        } finally {
            loader.classList.add('d-none');
        }
    }

    window.addEventListener("scroll", (e) => {
        e.preventDefault();
        if(scroll) {
            if(window.innerHeight + e.target.documentElement.scrollTop + 1 > e.target.documentElement.scrollHeight) {
                fetchNewFeed();
                scroll = false;
            }
        }
        setTimeout(() => {
            scroll = true;
        }, 5000);
    });

    fetchNewFeed();
</script>



<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap");
    body{background-color: #eee;font-family: "Poppins", sans-serif;font-weight: 300}
    .card{border:none}
    .ellipsis{color: #a09c9c}
    hr{color: #a09c9c;margin-top: 4px;margin-bottom: 8px}
    .muted-color{color: #a09c9c;font-size: 13px}
    .ellipsis i{margin-top: 3px;cursor: pointer}
    .icons i{font-size: 25px}
    .icons .fa-heart{color: red}
    .icons .fa-smile-o{color: yellow;font-size: 29px}
    .rounded-image{border-radius: 50%!important;display: flex;justify-content: center;align-items: center;height: 50px;width: 50px}
    .name{font-weight: 600}
    .comment-text{font-size: 12px}
    .status small{margin-right: 10px;color: blue}
    .form-control{border-radius: 26px}
    .comment-input{position: relative}
    .fonts{position: absolute;right: 13px;top:8px;color: #a09c9c}
    .form-control:focus{color: #495057;background-color: #fff;border-color: #8bbafe;outline: 0;box-shadow: none}
</style>