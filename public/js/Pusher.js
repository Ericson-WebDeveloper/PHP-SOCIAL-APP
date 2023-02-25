export default class PusherClass {
    constructor() {
        this.pusher = new Pusher('983513d8fdea2da8d62d', {
            cluster: 'ap3'
        });
    }
}
