<?php require_once('./components/header.php'); ?>

<?php require_once('./components/navbar.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Friend's Request</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Image</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="request-table-body">


                </tbody>
            </table>
        </div>
    </div>
</div>
</body>

</html>
<script type="module">
    import {
        errorAlert,
        successAlert
    } from './public/js/Toast.js';
    (function() {
        const acceptingRequestFriend = (user, requestId) => {
            let form = new FormData();
            form.append("ref-key", user);
            form.append("ref-key-2", requestId);
            form.append("accept-friend-request", true);
            return fetch(`./controller/UserController.php`, {
                method: 'POST',
                body: form
            })
        }

        const addingListener = () => {
            document.querySelectorAll(".btn-accept-request").forEach((btn) => {
                btn.addEventListener("click", async (e) => {
                    e.preventDefault();
                    let targetUser = e.target.dataset.keyReference;
                    let requestId = e.target.dataset.keyReference2;
                    try {
                        let response = await acceptingRequestFriend(targetUser, requestId);
                        if (response.status == 200) {
                            successAlert("Friend Request Send!");
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else if (response.status == 400) {
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
                    } catch (error) {
                        errorAlert('Sorry An error occurred while processing your request. please try again later.');
                    }
                })
            });
        }

        const fetchAllRequest = async (callback) => {
            try {
                let div_table = document.getElementById("request-table-body");
                let response = await fetch(`<?= CONTROLLER ?>/UserController.php?get-all-request=${true}`);
                response = await response.json();
                if (response.status == 400 || response.status == 500) {
                    errorAlert('Sorry An error occurred while processing your request. please try again later.');
                }
                if (response.request.length > 0) {
                    let list = response.request.map((request) => {
                        return `<tr style='vertical-align: middle;'>
                                <td>${request.first_name} ${request.last_name}</td>
                                <td>
                                    <img src='${request.profile == 'default-profile.png' ? './public/images/default-profile.png' : request.profile}' 
                                    width='100' height='100'>
                                </td>
                                <td>${moment(request.date).format('MMMM Do YYYY, h:mm:ss a')}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-accept-request" data-key-reference=${request.user_id} 
                                    data-key-reference2=${request.id}>Accept</button>
                                    <button type="button" class="btn btn-danger" data-key-reference=${request.user_id}>Cancel</button>
                                </td>
                            </tr>`;
                    }).join(" ");
                    div_table.innerHTML = list;
                } else {
                    div_table.innerHTML = '';
                }
                callback();
            } catch {
                errorAlert('Sorry An error occurred while processing your request. please try again later.');
            }
        }
        fetchAllRequest(addingListener);

    })();
</script>