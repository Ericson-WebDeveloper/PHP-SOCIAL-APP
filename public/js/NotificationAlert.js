

export default class Notification {

    constructor() {
        this.pusher = new Pusher('983513d8fdea2da8d62d', {
                cluster: 'ap3'
            });
        this.channel = this.pusher.subscribe('request-alert-channel');
        this.friendRequestChannel = this.pusher.subscribe('friend-request-alert-channel');
        this.acceptrequest = this.pusher.subscribe('accept-request-alert-channel');
    }

    bindRequestAlert = (userdata) => {
        this.channel.bind('request-alert-event', function(data) {
            let requestdata = JSON.parse(JSON.stringify(data));
            if(requestdata.user_request_id == userdata) {
                callback();
                alert('You Have new Friend Request coming from '+requestdata.first_name + ' ' + requestdata.last_name);
            }
        });
    }

    bindFriendRequestAlert = (userdata, callback) => {
       
        this.friendRequestChannel.bind('friend-request-alert-event', function(data) {
            let requestdata = JSON.parse(JSON.stringify(data)); 
            // console.log(window.location.pathname.split('/')[2], 'here notification js');
            if(requestdata.user_request_id == userdata) {
                callback(requestdata);
                // alert('You Have new Friend Request coming from '+requestdata.first_name + ' ' + requestdata.last_name);
            }
        });
    }

    bindAcceptFriendRequestAlert = (userdata, callback) => {
        this.friendRequestChannel.bind('acceptfriend-request-alert-event', async function(data) {
            let responsedata = JSON.parse(JSON.stringify(data)); 
            let r = await fetch(`./controller/UserController.php?fetch-data-user=${true}&userId=${responsedata.acceptUserId}`);
            r = await r.json();
            if(responsedata.userId == userdata) {
                callback(r.userfetch);
                // alert('You Have new Friend Request coming from '+requestdata.first_name + ' ' + requestdata.last_name);
            }
        });
    }

    unbindunsubcribe = () => {
        if(this.channel ) {
            this.pusher.unsubscribe('request-alert-channel');
        }
        if(this.friendRequestChannel) {
            this.pusher.unsubscribe('accept-request-alert-channel');
        }
        if(this.acceptrequest) {
            this.pusher.subscribe('friend-request-alert-channel');
        }
    }

    bindAcceptRequest = (userdata) => {
        this.acceptrequest.bind('accept-request-alert-event', function(data) {
            let requestdata = JSON.parse(JSON.stringify(data));
            if(requestdata.user_id == userdata) {
                alert('You Have new Friend Request coming from '+requestdata.first_name + ' ' + requestdata.last_name);
            }
        });
    }
}



// let pusher = new Pusher('c77d753570287883aa81', {
//     cluster: 'ap1'
// });

// export const bindRequestAlert = (userdata) => {
//     var channel = pusher.subscribe('request-alert-channel');
//     channel.bind('request-alert-event', function(data) {
//         let requestdata = JSON.parse(JSON.stringify(data));
//         if(requestdata.user_request_id == userdata) {
//             alert('You Have new Friend Request coming from '+requestdata.first_name + ' ' + requestdata.last_name);
//         }
//     });
// }

// export const unbindRequestAlert = () => {
//     channel.unbind('request-alert-event');
// }


