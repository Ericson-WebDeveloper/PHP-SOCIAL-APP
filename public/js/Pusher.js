export default class PusherClass {
    constructor() {
        this.pusher = new Pusher('c77d753570287883aa81', {
            cluster: 'ap1'
        });
    }
}