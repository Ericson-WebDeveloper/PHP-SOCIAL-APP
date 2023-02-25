export default class CommentAlert {
    constructor() {
        this.pusher = new Pusher('983513d8fdea2da8d62d', {
            cluster: 'ap3'
        });
        // this.channel = null;
        this.channel = this.pusher.subscribe(`new-comment-alert-channel`);
    }

    bindCommentEvent = (callback) => {
        this.channel.bind(`new-comment-alert-event`, async function(data) {
            let response = JSON.parse(JSON.stringify(data));
            // console.log(response.total_comment.total_comments, ' in pusher');
            callback(response.ref, response.total_comment.total_comments, response.commentId);
        });
    }

    unbindunsubcribe = () => {
        if(this.channel) {
          this.pusher.unsubscribe('new-comment-alert-channel');  
        }
    }

}
