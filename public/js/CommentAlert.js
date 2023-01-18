export default class CommentAlert {
    constructor() {
        this.pusher = new Pusher('c77d753570287883aa81', {
            cluster: 'ap1'
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