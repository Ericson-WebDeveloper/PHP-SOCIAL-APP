<?php require_once('./components/header.php'); ?>

<?php require_once('./components/navbar.php'); ?>


<div class="container-fluid h-100">
	<div class="row justify-content-center h-100">
		<div class="col-md-4 col-xl-3 chat">
			<div class="card mb-sm-3 mb-md-0 contacts_card">
				<div class="card-header">
					<div class="input-group">
						<input type="text" placeholder="Search..." name="" class="form-control search">
						<div class="input-group-prepend">
							<span class="input-group-text search_btn" style="height: 40px;"><i class="fas fa-search"></i></span>
						</div>
					</div>
				</div>


				<div class="card-body contacts_body">
					<ui class="contacts" id="contacts_container">


					</ui>
				</div>
				<div class="card-footer"></div>
			</div>
		</div>


		<div class="col-md-8 col-xl-6 chat">
			<!-- chat if have active select chatmate -->
			<div class="card" id="message_head_container" style="display: none; position:relative; overflow:hidden;">
				<div class="card-header msg_head" style="position:absolute; overflow:hidden; width: 100%;">
					<div class="d-flex bd-highlight" id="message__head__profile">
						<div class="img_cont">
							<img src="" id="" class="rounded-circle user_img">
							<span class="online_icon"></span>
						</div>
						<div class="user_info">
							<span></span>
							<p>1767 Messages</p>
						</div>
						<div class="video_cam">
							<span><i class="fas fa-video"></i></span>
							<span><i class="fas fa-phone"></i></span>
						</div>
					</div>
					<span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
					<div class="action_menu">
						<ul>
							<li><i class="fas fa-user-circle"></i> View profile</li>
							<li><i class="fas fa-users"></i> Add to close friends</li>
							<li><i class="fas fa-plus"></i> Add to group</li>
							<li><i class="fas fa-ban"></i> Block</li>
						</ul>
					</div>
				</div>
				<div class="card-body msg_card_body" style="position:absolute; top:80px; bottom:70px; overflow:auto; width:100%;">

				</div>



				<div class="card-footer" style="position:absolute; bottom:0px; overflow:hidden; width: 100%;">
					<div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">
						<!-- <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
								alt="avatar 3" class="user_input_chat_avatar" style="width: 40px; height: 100%;"> -->
						<input type="text" class="form-control form-control-lg type_msg" id="message__message" placeholder="Type message">
						<span class="ms-1 text-muted">
							<i class="fas fa-paperclip"></i>
						</span>
						<span class="ms-3 text-muted">
							<i class="fas fa-smile"></i>
						</span>
						<span class="ms-3" id="submit__message" style="cursor: pointer; color: blue;">
							<i class="fas fa-paper-plane" class="height: 150px;"></i>
						</span>
					</div>

				</div>
			</div>

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
	import OnlineAlert from './public/js/OnlineAlert.js';
	import ChatNotificationAlert from './public/js/ChatNotificationAlert.js';
	import PusherClass from './public/js/Pusher.js';
	let onlineAlrt = new OnlineAlert();
	let newChat = new ChatNotificationAlert();
	let pucherclass = new PusherClass();
	//   Pusher.logToConsole = true;
	let user_reference1 = '<?= $_SESSION['user']->id ?>';
	let ctdata = '';
	window.addEventListener("resize", function(event) {
		console.log(document.body.clientWidth + ' wide by ' + document.body.clientHeight + ' high');
	});

	newChat.bindMessageDirectChanell();

	const changeOnlineStatus = (data) => {
		document.querySelectorAll(".user_chats_profile").forEach((chat) => {
			if (chat.dataset.reference1 == data.id || chat.dataset.reference2 == data.id) {
				chat.querySelector('.img_cont').querySelector(".online_icon").classList.remove('offline');
				chat.querySelector('.user_info').querySelector(".online_name").textContent = `${data.first_name} is online`;
			}
		});
	}

	const changeOfflinelineStatus = (data) => {
		document.querySelectorAll(".user_chats_profile").forEach((chat) => {
			if (chat.dataset.reference1 == data.id || chat.dataset.reference2 == data.id) {
				chat.querySelector('.img_cont').querySelector(".online_icon").classList.add('offline');
				chat.querySelector('.user_info').querySelector(".online_name").textContent = `${data.first_name} is offline`;
			}
		});
	}

	onlineAlrt.bindOnlineAlert(changeOnlineStatus);
	onlineAlrt.bindOfflineAlert(changeOfflinelineStatus);

	document.getElementById("btn-signout").addEventListener("click", async (e) => {
		e.preventDefault();
		let form = new FormData();
		form.append('signout--user', true);
		try {
			let response = await fetch('./controller/AuthController.php', {
				method: 'POST',
				body: form
			});
			response = await response.json();
			if (response.status == 200) {
				successAlert('Logout Success!');
				setTimeout(() => {
					window.location.replace('./login.php')
				}, 1000);
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
					errorAlert('Sorry An error occurred while processing your request. please try again later.');
				}
			}
		} catch {
			errorAlert('Sorry An error occurred while processing your request. please try again later.');
		}
	});

	const fetchMessagesFromChatmate = async (chat, userref) => {
		// try {
		let form = new FormData();
		form.append('chatmate', chat);
		form.append('user_reference', userref);
		form.append('fetch--message-chatmate', true);
		let response = await fetch(`./controller/ChatController.php`, {
			method: 'POST',
			body: form
		});
		return await response.json();
		// } catch (error) {
		// 	errorAlert('Sorry An error occurred while processing your request. please try again later.');
		// }
	}
	const setupProfileHeadMessage = (user) => {
		let div = document.getElementById("message__head__profile");
		user.status == 0 ? div.childNodes[0].nextSibling.querySelector("span").classList.add("offline") :
			div.childNodes[0].nextSibling.querySelector("span").classList.remove("offline");
		div.childNodes[1].querySelector("img").setAttribute('src', user.profile == 'default-profile.png' ? './public/images/default-profile.png' : user.profile);
		div.childNodes[3].querySelector("span").textContent = `${user.first_name} ${user.last_name}`;
		div.childNodes[3].querySelector("p").textContent = `${1} Messages`;
	}

	const scrollingBottom = () => {
		let msgdivbottom = document.getElementById("chat_bottom__div");
		msgdivbottom.scrollIntoView({
			behavior: "smooth",
			block: "start",
			inline: "nearest"
		});
	}

	const setUpMessageBody = (messages, chatmate, me) => {
		let msgdiv = document.querySelector(".msg_card_body");
		let user_reference = '<?= $_SESSION['user']->id ?>';
		let mss = messages.map((message) => {

			if (message.m_id) {
				let img = '';
				if (message.m_sender == user_reference) {
					img = me.profile == 'default-profile.png' ? './public/images/default-profile.png' : me.profile;
				} else {
					img = chatmate.profile == 'default-profile.png' ? './public/images/default-profile.png' : chatmate.profile;
				}
				return `<div class="d-flex ${message.m_sender == user_reference ? 'justify-content-end' : 'justify-content-start'} mb-4">
						<div class="${message.m_sender == user_reference ? 'msg_cotainer_send' : 'msg_cotainer'}" style="min-width: 70px;">
							${message.m_message}
							<span class="${message.m_sender == user_reference ? 'msg_time_send' : 'msg_time'}">
							${moment(message.m_send_date).startOf('hour').fromNow()}
							</span>
						</div>
					<div class="img_cont_msg ${message.m_sender != user_reference ? 'ms-2' : ''}">
						<img src="${img}" class="rounded-circle user_img_msg">
					</div>
			</div>`;
			}
		}).join('');
		mss += '<div id="chat_bottom__div" style="padding-bottom: 16px;" ></div>';
		msgdiv.innerHTML = mss;
		//   msgdiv.scrollTo(0,msgdiv.scrollHeight);
		scrollingBottom()
	}

	const setUpdaMessageSide = async (chat, userref) => {
		var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?ct=' + chat;
		window.history.pushState({
			path: newurl
		}, '', newurl);
		try {
			let response = await fetchMessagesFromChatmate(chat, userref);
			// console.log(response);
			if (response.status == 200) {
				let messageCont = document.getElementById("message_head_container");
				messageCont.setAttribute('data-messref', chat);
				messageCont.style.display = 'block';
				// console.log(response.user)
				setupProfileHeadMessage(response.user);
				setUpMessageBody(response.messages, response.user, response.user2);
			}
		} catch (error) {
			errorAlert('Sorry An error occurred while fetching meesages. please try again later.');
		}
	}

	const sortingChatHeads = (chatmate) => {
		document.querySelectorAll(".user_chats_profile").forEach((profile) => {
			if (profile.dataset.reference1 == chatmate || profile.dataset.reference2 == chatmate) {
				document.querySelector("#contacts_container").prepend(profile);
			}
		});
		// sortingChatHeads(ct);
	}

	const sortingMessages = (newMessage, sender) => {
		let messageCont = document.getElementById("message_head_container");
		if (messageCont.dataset.messref && messageCont.dataset.messref == sender) {
			document.querySelector(".msg_card_body").innerHTML += newMessage;
			scrollingBottom();
		}
	}

	newChat.bindMessageDirectEvent(sortingChatHeads, sortingMessages, user_reference1, moment);

	document.getElementById("submit__message").addEventListener("click", async (e) => {
		e.preventDefault();
		let user_reference = '<?= $_SESSION['user']->id ?>';
		const urlParams = new URLSearchParams(window.location.search);
		const ct = urlParams.get('ct');
		let message = document.getElementById("message__message");
		try {
			if (message.value == '' || message.value.trim() == '') {
				errorAlert('Message is missing');
				return false;
			}
			if (ct == '' || ct == undefined) {
				errorAlert('Select user');
				return false;
			}
			let form = new FormData();
			form.append('chatmate', ct);
			form.append('sender', user_reference);
			form.append('message', message.value);
			form.append('send--message--chatmate', true);
			let response = await fetch(`./controller/ChatController.php`, {
				method: 'POST',
				body: form
			});
			response = await response.json();
			message.value = '';
			let img = '';
			if (response.message.m_sender == user_reference) {
				img = response.sender.profile == 'default-profile.png' ? './public/images/default-profile.png' : response.sender.profile;
			} else {
				img = response.chatmate.profile == 'default-profile.png' ? './public/images/default-profile.png' : response.chatmate.profile;
			}
			let newMessage = `<div class="d-flex ${response.message.m_sender == user_reference ? 'justify-content-end' : 'justify-content-start'} mb-4">
							<div class="${response.message.m_sender == user_reference ? 'msg_cotainer_send' : 'msg_cotainer'}" style="min-width: 70px;">
								${response.message.m_message}
								<span class="${response.message.m_sender == user_reference ? 'msg_time_send' : 'msg_time'}">
								${moment(response.message.m_send_date).format('LT')}</span>
							</div>
								<div class="img_cont_msg">
									<img src="${img}" class="rounded-circle user_img_msg">
								</div>
							</div>`;
			sortingChatHeads(ct);
			sortingMessages(newMessage, ct);
			// console.log('send message', ctdata);
		} catch (error) {
			console.log(error);
			errorAlert('Sorry An error occurred while fetching meesages. please try again later.');
		}
	});

	const selectActiveChatmate = () => {
		let user_reference = '<?= $_SESSION['user']->id ?>';
		let chatmate = null;
		document.querySelectorAll(".user_chats_profile").forEach((btn) => {
			btn.addEventListener("click", (e) => {
				let element = e.target;
				document.querySelectorAll(".user_chats_profile").forEach((profile) => {
					profile.style.backgroundColor = "";
				});
				if (element.classList.contains('user_chats_profile')) {
					chatmate = element.dataset.reference1 != user_reference ? element.dataset.reference1 : element.dataset.reference2;
					element.style.backgroundColor = "rgba(0,0,0,0.4)";
				} else {
					if (element.parentNode.classList.contains('user_chats_profile')) {
						// console.log(element.parentNode.dataset.reference1, element.parentNode.dataset.reference2);
						chatmate = element.parentNode.dataset.reference1 != user_reference ? element.parentNode.dataset.reference1 : element.parentNode.dataset.reference2;
						element.parentNode.style.backgroundColor = "rgba(0,0,0,0.4)";
					} else {
						if (element.parentNode.parentNode.parentNode) {
							chatmate = element.parentNode.parentNode.parentNode.dataset.reference1 != user_reference ?
								element.parentNode.parentNode.parentNode.dataset.reference1 : element.parentNode.parentNode.parentNode.dataset.reference2;
							element.parentNode.parentNode.parentNode.style.backgroundColor = "rgba(0,0,0,0.4)";
							// console.log(element.parentNode.parentNode.parentNode.dataset.reference1, 
							// element.parentNode.parentNode.parentNode.dataset.reference2);
						} else {
							return false;
							// remove query string
							// hide message body
						}
					}
				}
				if (chatmate) {
					ctdata = chatmate;
					// console.log('click', ctdata);
					setUpdaMessageSide(chatmate, user_reference);
				}
			});
		});
	}



	const fetchAllChats = async () => {
		let contacdiv = document.getElementById("contacts_container");
		try {
			let response = await fetch(`./controller/UserController.php?get-all-chat-friends=${true}`);
			response = await response.json();
			let chatList = response.chats.map((chat) => {
				return `<li class="user_chats_profile" data-reference1=${chat.user_id} data-reference2=${chat.friend_id} 
						style='cursor:pointer;'>
						<div class="d-flex bd-highlight">
							<div class="img_cont">
								<img src="${chat?.profile == 'default-profile.png' ? './public/images/default-profile.png' : 
									chat.profile}" class="rounded-circle user_img">
								<span class="online_icon ${chat.status == "0" ? 'offline' : ''}"></span>
							</div>
							<div class="user_info">
								<span>${chat.first_name} ${chat.last_name}</span>
								<p class="online_name">${chat.first_name} ${chat.status == "0" ? 'is offline' : 'is online'} </p>
							</div>
						</div>
					</li>`;
			}).join(" ");
			contacdiv.innerHTML = chatList;
			selectActiveChatmate();
		} catch {
			errorAlert('Sorry An error occurred while processing your request. please try again later.');
		}
	}

	fetchAllChats();

	const checkCahtMakeCurrent = () => {
		const urlParams = new URLSearchParams(window.location.search);
		const ct = urlParams.get('ct');

		let user_reference = '<?= $_SESSION['user']->id ?>';
		if (ct) {
			ctdata = ct;
			// console.log('refresh', ctdata);
			setUpdaMessageSide(ct, user_reference);
			setTimeout(() => {
				document.querySelectorAll(".user_chats_profile").forEach((profile) => {
					if (profile.dataset.reference1 == ct || profile.dataset.reference2 == ct) {
						profile.style.backgroundColor = "rgba(0,0,0,0.4)";
					}
				});
			}, 1000)

		}
	}


	checkCahtMakeCurrent();
</script>

<style>

/* animate conatct head */
	#contacts_container {
		animation: append-animate .3s linear;
	}

	*/ .dot-offline {
		height: 15px;
		width: 15px;
		background-color: #bbb;
		border-radius: 50%;
		display: inline-block;

	}

	.dot-online {
		height: 15px;
		width: 15px;
		background-color: green;
		border-radius: 50%;
		display: inline-block;
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


	body,
	html {
		height: 100%;
		margin: 0;
		background: #7F7FD5;
		background: -webkit-linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
		background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
	}

	.chat {
		margin-top: auto;
		margin-bottom: auto;
	}

	.card {
		height: 90vh;
		margin-top: 10px;
		margin-bottom: 10px;
		border-radius: 15px !important;
		background-color: rgba(0, 0, 0, 0.4) !important;
	}

	.contacts_body {
		padding: 0.75rem 0 !important;
		overflow-y: auto;
		white-space: nowrap;
	}

	.msg_card_body {
		overflow-y: auto;
	}

	.card-header {
		border-radius: 15px 15px 0 0 !important;
		border-bottom: 0 !important;
	}

	.card-footer {
		border-radius: 0 0 15px 15px !important;
		border-top: 0 !important;
	}

	.container {
		align-content: center;
	}

	.search {
		border-radius: 15px 0 0 15px !important;
		background-color: rgba(0, 0, 0, 0.3) !important;
		border: 0 !important;
		color: white !important;
	}

	.search:focus {
		box-shadow: none !important;
		outline: 0px !important;
	}

	.type_msg {
		background-color: rgba(0, 0, 0, 0.3) !important;
		border: 0 !important;
		color: white !important;
		height: 60px !important;
		overflow-y: auto;
	}

	.type_msg:focus {
		box-shadow: none !important;
		outline: 0px !important;
	}

	.attach_btn {
		border-radius: 15px 0 0 15px !important;
		background-color: rgba(0, 0, 0, 0.3) !important;
		border: 0 !important;
		color: white !important;
		cursor: pointer;
		margin-top: 32px;
	}

	.send_btn {
		border-radius: 0 15px 15px 0 !important;
		background-color: rgba(0, 0, 0, 0.3) !important;
		border: 0 !important;
		color: white !important;
		cursor: pointer;
		margin-top: 32px;
	}

	.search_btn {
		border-radius: 0 15px 15px 0 !important;
		background-color: rgba(0, 0, 0, 0.3) !important;
		border: 0 !important;
		color: white !important;
		cursor: pointer;
	}

	.contacts {
		list-style: none;
		padding: 0;
	}

	.contacts li {
		width: 100% !important;
		padding: 5px 10px;
		margin-bottom: 15px !important;
	}

	.active {
		background-color: rgba(0, 0, 0, 0.3);
	}

	.user_img {
		height: 70px;
		width: 70px;
		border: 1.5px solid #f5f6fa;

	}

	.user_img_msg {
		height: 40px;
		width: 40px;
		border: 1.5px solid #f5f6fa;

	}

	.img_cont {
		position: relative;
		height: 70px;
		width: 70px;
	}

	.img_cont_msg {
		height: 40px;
		width: 40px;
	}

	.online_icon {
		position: absolute;
		height: 15px;
		width: 15px;
		background-color: #4cd137;
		border-radius: 50%;
		bottom: 0.2em;
		right: 0.4em;
		border: 1.5px solid white;
	}

	.offline {
		background-color: #c23616 !important;
	}

	.user_info {
		margin-top: auto;
		margin-bottom: auto;
		margin-left: 15px;
	}

	.user_info span {
		font-size: 20px;
		color: white;
	}

	.user_info p {
		font-size: 10px;
		color: rgba(255, 255, 255, 0.6);
	}

	.video_cam {
		margin-left: 50px;
		margin-top: 5px;
	}

	.video_cam span {
		color: white;
		font-size: 20px;
		cursor: pointer;
		margin-right: 20px;
	}

	.msg_cotainer {
		margin-top: auto;
		margin-bottom: auto;
		margin-left: 20px;
		border-radius: 25px;
		background-color: #82ccdd;
		padding: 10px;
		position: relative;
	}

	.msg_cotainer_send {
		margin-top: auto;
		margin-bottom: auto;
		margin-right: 10px;
		border-radius: 25px;
		background-color: #78e08f;
		padding: 10px;
		position: relative;
	}

	.msg_time {
		position: absolute;
		left: 0;
		bottom: -15px;
		color: rgba(255, 255, 255, 0.5);
		font-size: 10px;
	}

	.msg_time_send {
		position: absolute;
		right: 0;
		bottom: -15px;
		color: rgba(255, 255, 255, 0.5);
		font-size: 10px;
	}

	.msg_head {
		position: relative;
	}

	#action_menu_btn {
		position: absolute;
		right: 10px;
		top: 10px;
		color: white;
		cursor: pointer;
		font-size: 20px;
	}

	.action_menu {
		z-index: 1;
		position: absolute;
		padding: 15px 0;
		background-color: rgba(0, 0, 0, 0.5);
		color: white;
		border-radius: 15px;
		top: 30px;
		right: 15px;
		display: none;
	}

	.action_menu ul {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.action_menu ul li {
		width: 100%;
		padding: 10px 15px;
		margin-bottom: 5px;
	}

	.action_menu ul li i {
		padding-right: 10px;

	}

	.action_menu ul li:hover {
		cursor: pointer;
		background-color: rgba(0, 0, 0, 0.2);
	}

	@media(max-width: 576px) {
		.contacts_card {
			margin-bottom: 15px !important;
		}
	}
</style>
