
<?php // include('./components/Spinner.php'); ?>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #42def8;">
        <a class="navbar-brand" href="<?= ROUTES_PATH ?>newsfeed.php">
            <!-- <img src="https://codingyaar.com/wp-content/uploads/logo.png"> -->
            <!-- https://www.iconfinder.com/search?q=social+media -->
            <svg enable-background="new 0 0 100 100" height="80px" version="1.1" viewBox="0 0 100 100" width="80px" xml:space="preserve" 
            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="color_x5F_fill">
                <path d="M84.418,69.921c-2.527,1.583-12.807,2.054-15.295,0.246c-1.365-0.991-2.613-2.232-3.799-3.412   
                c-0.828-0.826-1.77-1.227-2.482-2.123c-0.58-0.734-0.979-1.599-1.592-2.321c-1.033-1.215-2.625-2.248-3.885-0.764   
                c-1.895,2.231,0.299,6.617-2.229,8.285c-0.848,0.56-1.703,0.722-2.762,0.642l-2.346,0.107c-1.379,0.027-3.562,0.039-5.129-0.244   
                c-1.75-0.315-3.193-1.271-4.773-1.973c-3.002-1.331-5.863-3.145-8.039-5.658c-5.922-6.843-13.877-16.255-16.967-24.859   
                c-0.637-1.768-2.314-5.267-0.723-6.784c2.164-1.572,12.789-2.017,14.445,0.416c0.674,0.987,1.098,2.436,1.574,3.555   
                c0.592,1.396,0.914,2.713,1.84,3.949c0.82,1.097,1.426,2.199,2.061,3.402c0.713,1.349,1.385,2.643,2.252,3.886   
                c0.588,0.845,2.143,2.524,3.125,2.65c2.398,0.307,2.248-5.521,2.07-6.945c-0.17-1.371-0.215-2.825-0.17-4.216   
                c0.039-1.186,0.146-2.857-0.557-3.826c-1.145-1.58-3.695-0.397-3.895-2.52c0.422-0.603,0.332-1.138,3.146-2.064   
                c2.215-0.729,3.646-0.706,5.107-0.589c2.98,0.239,6.139-0.568,9.014,0.398c2.746,0.925,2.322,4.828,2.23,7.168   
                c-0.123,3.195,0.008,6.312,0,9.553c-0.004,1.477-0.062,2.912,1.736,2.793c1.688-0.113,1.859-1.532,2.664-2.704   
                c1.121-1.633,2.148-3.288,3.289-4.916c1.537-2.199,2-4.67,3.447-6.923c0.518-0.807,0.963-2.568,1.76-3.205   
                c0.604-0.481,1.75-0.275,2.48-0.275h1.736c1.33,0.016,2.686,0.035,4.051,0.083c1.967,0.068,4.17-0.359,6.121-0.084   
                c8.416,1.188-10.578,19.191-9.59,22.403c0.684,2.218,5.016,4.703,6.58,6.521C82.998,61.991,89.389,66.81,84.418,69.921z" 
                fill="#4C75A3"/></g><g id="offset_x5F_print_x5F_outline"/></svg>

                <!-- <svg enable-background="new 0 0 24 24" id="Layer_1" version="1.1" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M12,0C5.3833008,0,0,5.3828125,0,12c0,2.0429688,0.5302734,4.0644531,1.5336914,5.8544922   c0.0136719,0.0400391,0.0322266,0.0791016,0.0566406,0.1162109c0.3725586,0.5683594-0.7944336,1.6962891-1.3837891,2.1240234   c-0.1425781,0.1035156-0.2202148,0.2753906-0.2041016,0.4501953c0.015625,0.1757813,0.1230469,0.3300781,0.2822266,0.40625   c0.0805664,0.0380859,1.9023438,0.8867188,3.8540039,0.0986328C6.328125,22.9550781,9.1069336,24,12,24   c6.6166992,0,12-5.3828125,12-12S18.6166992,0,12,0z" fill="#0175BC"/><path d="M13.9052124,21.8225098c-3.300293,0.6135254-6.3643799-0.4083252-8.5637817-2.3765869   c-1.5664673,0.7545166-3.1488037,0.272644-3.1488037,0.272644l0.020813-0.0206299   c0.9769897-0.9802856,1.1698608-2.4580688,0.6160278-3.7263794c-0.7872314-1.8027344-1.0622559-3.8786011-0.6151123-6.0562134   c0.8193359-3.9901123,4.1095581-7.1381836,8.1315918-7.7825928c6.8303833-1.0942993,12.6414185,4.736145,11.5130615,11.5716553   C21.1879272,17.7700195,17.9564209,21.0693359,13.9052124,21.8225098z" fill="#FFFFFF"/><path d="M13.9052124,21.8225098c-3.300293,0.6135254-6.3643799-0.4083252-8.5637817-2.3765869   c-1.4277053,0.6050568-2.6531954,0.43643-3.1488037,0.272644c-0.0528564,0.0620728-0.0993042,0.1277466-0.1577759,0.1864014   l-0.020813,0.0206299c0,0,1.7609253,0.5248413,3.3273926-0.2296753c2.1994019,1.9682617,5.2634888,2.9901123,8.5637817,2.3765869   c4.0512085-0.7531738,7.2827148-4.0524902,7.9537964-8.118103c0.0827026-0.5008545,0.1173706-0.9937134,0.1278687-1.4814453   c-0.0186768,0.4060669-0.0593872,0.8166504-0.1278687,1.2314453   C21.1879272,17.7700195,17.9564209,21.0693359,13.9052124,21.8225098z" fill="#FFFFFF" opacity="0.2"/><path d="M12,0.25c6.5745239,0,11.9256592,5.3157959,11.9936523,11.875   C23.9940796,12.0828857,24,12.0421753,24,12c0-6.6171875-5.3833008-12-12-12S0,5.3828125,0,12   c0,0.0368042,0.0067139,0.0730591,0.0070801,0.1098633C0.0831909,5.5577393,5.430603,0.25,12,0.25z" fill="#FFFFFF" opacity="0.2"/><path d="M12,23.75c-2.8930664,0-5.671875-1.0449219-7.8613281-2.9501953   c-1.9516602,0.7880859-3.7734375-0.0605469-3.8540039-0.0986328c-0.1328735-0.0635986-0.2159424-0.1872559-0.253418-0.3268433   c-0.0149536,0.0559692-0.0342407,0.1113892-0.0288086,0.1705933c0.015625,0.1757813,0.1230469,0.3300781,0.2822266,0.40625   c0.0805664,0.0380859,1.9023438,0.8867188,3.8540039,0.0986328C6.328125,22.9550781,9.1069336,24,12,24   c6.6166992,0,12-5.3828125,12-12c0-0.0421753-0.0059204-0.0828857-0.0063477-0.125   C23.9256592,18.4342041,18.5745239,23.75,12,23.75z" fill="#010101" opacity="0.1"/><path d="M10.3459473,2.1171265c6.329895-1.0140991,11.7736206,3.9215088,11.6409302,10.09021   c0.2893066-6.2856445-5.2249756-11.368103-11.6409302-10.34021C6.3239136,2.5115356,3.0336914,5.6596069,2.2143555,9.6497192   c-0.1694946,0.8255615-0.234314,1.6362305-0.2077026,2.4231567c-0.0063477-0.7086792,0.0559692-1.4343262,0.2077026-2.1731567   C3.0336914,5.9096069,6.3239136,2.7615356,10.3459473,2.1171265z" fill="#010101" opacity="0.1"/><path d="M5.5,10C5.2236328,10,5,10.2236328,5,10.5v4C5,14.7763672,5.2236328,15,5.5,15S6,14.7763672,6,14.5v-4   C6,10.2236328,5.7763672,10,5.5,10z" fill="#0175BC"/><path d="M17,10c-1.1030273,0-2,0.8974609-2,2v1c0,1.1025391,0.8969727,2,2,2s2-0.8974609,2-2v-1   C19,10.8974609,18.1030273,10,17,10z M18,13c0,0.5517578-0.4487305,1-1,1s-1-0.4482422-1-1v-1c0-0.5517578,0.4487305-1,1-1   s1,0.4482422,1,1V13z" fill="#0175BC"/><path d="M12,10c-0.6002197,0-1.1331787,0.2712402-1.5,0.6912231C10.1331787,10.2712402,9.6002197,10,9,10   c-0.3823242,0-0.7397461,0.1074219-1.0439453,0.2949219C7.8774414,10.1210938,7.703125,10,7.5,10C7.2236328,10,7,10.2236328,7,10.5   v4C7,14.7763672,7.2236328,15,7.5,15S8,14.7763672,8,14.5V12c0-0.5517578,0.4487305-1,1-1s1,0.4482422,1,1v2.5   c0,0.2763672,0.2236328,0.5,0.5,0.5s0.5-0.2236328,0.5-0.5V12c0-0.5517578,0.4487305-1,1-1s1,0.4482422,1,1v2.5   c0,0.2763672,0.2236328,0.5,0.5,0.5s0.5-0.2236328,0.5-0.5V12C14,10.8974609,13.1030273,10,12,10z" fill="#0175BC"/><circle cx="5.5" cy="8.5" fill="#0175BC" r="0.5"/><linearGradient gradientUnits="userSpaceOnUse" id="SVGID_1_" x1="0.8999521" x2="22.6502762" y1="7.411097" y2="17.5534401"><stop offset="0" style="stop-color:#FFFFFF;stop-opacity:0.2"/><stop offset="1" style="stop-color:#FFFFFF;stop-opacity:0"/></linearGradient><path d="M12,0C5.3833008,0,0,5.3828125,0,12c0,2.0429688,0.5302734,4.0644531,1.5336914,5.8544922   c0.0136719,0.0400391,0.0322266,0.0791016,0.0566406,0.1162109c0.3725586,0.5683594-0.7944336,1.6962891-1.3837891,2.1240234   c-0.1425781,0.1035156-0.2202148,0.2753906-0.2041016,0.4501953c0.015625,0.1757813,0.1230469,0.3300781,0.2822266,0.40625   c0.0805664,0.0380859,1.9023438,0.8867188,3.8540039,0.0986328C6.328125,22.9550781,9.1069336,24,12,24   c6.6166992,0,12-5.3828125,12-12S18.6166992,0,12,0z" fill="url(#SVGID_1_)"/></g><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/></svg> -->
        </a>        

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#myNavbarToggler10" aria-controls="myNavbarToggler10" 
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="myNavbarToggler10">
        <ul class="navbar-nav ms-4">
            <li class="nav-item">
                <a class="nav-link" href="<?= ROUTES_PATH ?>newsfeed.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= ROUTES_PATH ?>profile.php">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= ROUTES_PATH ?>messages.php">Message</a>
            </li>
			<li class="nav-item">
                <a class="nav-link" href="<?= ROUTES_PATH ?>users.php">Suggested Friends</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= ROUTES_PATH ?>request.php">Friend's Request <span id="counts_request"></span></a>
            </li>
        </ul>
        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item dropdown ms-4 floating-end">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Profile
            </a>
                <ul class="dropdown-menu me-8" aria-labelledby="navbarDropdown">
                    <!-- <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><hr class="dropdown-divider"></li> -->
                    <div class="list-group">
                         <li><a class="dropdown-item" href="javascript:void(0);" id="btn-signout">Sign Out</a></li>
                    </div>
                   
                </ul>
            </li>
        </ul>
    </div>
</nav>


<div class="loading loader d-none" id="loader_loader">Loading&#8230;</div>
<script type="module">
    import {errorAlert, successAlert}  from '<?= ASSET ?>/js/Toast.js';
    import ChatNotif from '<?= ASSET ?>/js/ChatNotificationAlert.js';
    import Notifi from '<?= ASSET ?>/js/NotificationAlert.js';
    import Online from '<?= ASSET ?>/js/OnlineAlert.js';
    let loader = document.getElementById("loader_loader");
    let notific = new Notifi();
    let chatnotification = new ChatNotif();
    let onlineChannel = new Online();
    let userdata = "<?= $_SESSION['user']->id ?>";
    
    const getRequestCounts = async () => {
        try {
            loader.classList.remove('d-none');
            let count = parseInt(document.getElementById("counts_request").textContent || 0);
            let response = await fetch(`<?= CONTROLLER ?>/UserController.php?get-all-request=${true}`);
            response = await response.json();
            if(response.status == 200 && response.request.length > 0) {
                document.getElementById("counts_request").textContent = parseInt(response.request.length);
            } else {
                document.getElementById("counts_request").textContent = 0;
            }
        } catch (error) {
            document.getElementById("counts_request").textContent = 0;
        } finally {
            loader.classList.add('d-none');
        }
    }
    getRequestCounts();
    const frienRequestAllert = (data) => { 
        successAlert('You Have new Friend Request coming from '+data.first_name + ' ' + data.last_name);
        console.log(data);
        let count = parseInt(document.getElementById("counts_request").textContent || 0);
        document.getElementById("counts_request").textContent = count ? parseInt(count) + 1 : 1;
    }

    const acceptFriendRequestAlert = (data) => {
        successAlert('Your Friend Request Accepted by ' + data.first_name + ' ' + data.last_name);
    }

    notific.bindFriendRequestAlert(userdata, frienRequestAllert);
    notific.bindAcceptFriendRequestAlert(userdata, acceptFriendRequestAlert);
    // add other notification like comment like or message
    chatnotification.bindMessageAllPages(userdata);
    // if(window.location.pathname.split('/')[2] !== 'message.php') {

    // }
    
     document.getElementById("btn-signout").addEventListener("click", async (e) => {
        e.preventDefault();
        let form = new FormData();
        form.append('signout--user', true);
        try {
            loader.classList.remove('d-none');
            let response = await fetch('<?= CONTROLLER ?>/AuthController.php', {method: 'POST', body: form});
            response = await response.json();
            if(response.status == 200) {
               
                successAlert('Logout Success!');
                // window.location.reload();
                setTimeout(() => {
                    notific.unbindunsubcribe();
                    chatnotification.unbindunsubcribe();
                    onlineChannel.unbindunsubcribe();
                    window.location.reload();
                }, 2000);
            } else {
                if (response.status == 400) {
                    let error = response.error ? response.error : response.errors;
                    errorAlert(error);
                } else if (response.status == 500) {
                    let error = response.error ? response.error : response.errors;
                    errorAlert(error);
                } else if (response.status == 422) {
                    let keys = Object.keys(response.errors);
                    keys.forEach((key) => {
                        errorAlert(response.errors[key], "center")
                    });
                } else {
                    setTimeout(() => {
                        notific.unbindunsubcribe();
                        chatnotification.unbindunsubcribe();
                        onlineChannel.unbindunsubcribe();
                        window.location.reload();
                    }, 2000);
                }
            }
        } catch(error) {
            setTimeout(() => {
                    notific.unbindunsubcribe();
                    chatnotification.unbindunsubcribe();
                    onlineChannel.unbindunsubcribe();
                    window.location.reload();
            }, 2000);
        } finally {
            loader.classList.add('d-none');
        }
    });
</script>