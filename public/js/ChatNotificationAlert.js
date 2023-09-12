import {successAlert} from './Toast.js'

export default class ChatNotificationAlert {
    constructor() {
        this.pusher = new Pusher('983513d8fdea2da8d62d', {
	      cluster: 'ap3'
	    });
        // this.channel = null;
        this.channel = this.pusher.subscribe(`message-active-alert-channel`);
    }

    bindMessageDirectChanell = () => {
        this.channel = this.pusher.subscribe(`message-active-alert-channel`);
    }


    bindMessageDirectEvent = (callback1, callback2, chatmate, moment) => {
        this.channel.bind(`message-active-alert-event.${chatmate}`, async function(data) {
            let response = JSON.parse(JSON.stringify(data));
            const urlParams = new URLSearchParams(window.location.search);
		    const ct = urlParams.get('ct');
            let r = await fetch(`./controller/UserController.php?fetch-data-user=${true}&userId=${response.sender}`);
            r = await r.json();
            if(response) {
                // un ng send ng message -> response.sender
                // un current user login of page -> chatmate
                // un reciever ng message = response.reciever
                // un active chatmate na nakaselect -> ct
                callback1(response.sender);

                let img = '';
                img = r.userfetch.profile == 'default-profile.png' ? './public/images/default-profile.png' : r.userfetch.profile;
                
                let newMessage = `<div class="d-flex ${response.message.m_sender == chatmate ? 'justify-content-end' : 'justify-content-start'} mb-4">
                                <div class="${response.message.m_sender == chatmate ? 'msg_cotainer_send' : 'msg_cotainer'}" style="min-width: 70px;">
                                    ${response.message.m_message}
                                    <span class="${response.message.m_sender == chatmate ? 'msg_time_send' : 'msg_time'}">
                                    ${moment(response.message.m_send_date).format('LT')}</span>
                                </div>
                                <div class="img_cont_msg ms-2">
                                    <img src="${img}" class="rounded-circle user_img_msg">
                                </div>
                            </div>`;
                callback2(newMessage, response.sender);
            }
        });
    }
















    // bindMessageAllPages = (userdata) => {
    //     this.channel.bind(`messages-alert-event`, function(data) {
    //         let response = JSON.parse(JSON.stringify(data));
    //         if(response.reciever == userdata) {
    //             let urlStr = window.location.pathname.split('/')[2];
    //             if(urlStr !== 'message.php' && !urlStr.includes('message.php')) {
    //                 successAlert('You Have New Message');
    //             } 
    //         }
    //     });
    // }
    bindMessageAllPages = (userdata) => {
        this.channel.bind(`messages-alert-event.${userdata}`, function(data) {
            let response = JSON.parse(JSON.stringify(data));
            // if(response.reciever == userdata) {
                let urlStr = window.location.pathname.split('/')[2];
                if(urlStr !== 'message.php' && !urlStr.includes('message.php')) {
                    successAlert('You Have New Message');
                } 
            // }
        });
    }

    unbindunsubcribe = () => {
        if(this.channel) {
          this.pusher.unsubscribe('message-active-alert-channel');  
        }
    }

    // unbindChannel = () => {
    //     this.channel1.unbind('message-active-alert-event');
    // }

    // bindOIndirectAlert = (callback) => {
    //     this.channel2.bind('offline-alert-event', function(data) {
    //         let response = JSON.parse(JSON.stringify(data));
    //         if(response) {
    //             callback(response)
    //         }
    //     });
    // }
}
