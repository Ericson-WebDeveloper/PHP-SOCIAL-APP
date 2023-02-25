export default class OnlineNotification {
    constructor() {
        // super()
        this.pusher = new Pusher('983513d8fdea2da8d62d', {
            cluster: 'ap3'
        });
        
        this.channel = this.pusher.subscribe('online-alert-channel');
        this.channel2 = this.pusher.subscribe('offline-alert-channel');
    }

    bindOnlineAlert = (callback) => {
        this.channel.bind('online-alert-event', function(data) {
            let response = JSON.parse(JSON.stringify(data));
            if(response) {
                callback(response)
            }
        });
    }

    bindOfflineAlert = (callback) => {
        this.channel2.bind('offline-alert-event', function(data) {
            let response = JSON.parse(JSON.stringify(data));
            if(response) {
                callback(response)
            }
        });

        // alert('Sign out');
    }

    unbindunsubcribe = () => {
        if(this.channel) {
            this.pusher.unsubscribe('online-alert-channel');
        }
        if(this.channel2) {
             this.pusher.unsubscribe('offline-alert-channel');
        }
    }

    // unbindChannel = () => {
    //     this.channel1.unbind('online-alert-event');
    //     this.channel2.unbind('offline-alert-even');
    // }
}
