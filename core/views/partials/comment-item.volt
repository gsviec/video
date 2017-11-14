<div class="cl-comment{% if class is defined %}{{ class }}{% endif %}">
    <div class="cl-avatar">
        <a href="/channels/{{user.getChannelSlug()}}">
            <img src="{{user.getAvatar(70)}}" alt="" class="avatar-user">
        </a>
    </div>
    <div class="cl-comment-text">
        <div class="cl-name-date"><a href="#">{{user.getFullname() }}</a> . {{ comment.getHumanCreatedAt() }}</div>
        <div class="cl-text">{{ comment.getContent() }}.</div>
        <div class="cl-meta">
            {{ partial('partials/vote', ['vote' : comment, 'object' : 'comments', 'objectId' : comment.id]) }}
            <a href="#" class="js-replies">Reply</a>
            <div class="rc-replies" style="display: none">
                {{ partial('partials/comment-form', ['objectId' : comment.id, 'object' : 'postsReplies']) }}
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
