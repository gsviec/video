{#comment/indexAction#}
{% if comment is defined %}
        {% set user = comment.user  %}
        {{ partial('partials/comment-item', ['comment' : comment, 'user' : comment.user, 'object' : 'posts']) }}
        {#Comment replies#}
        {% if comment.getRepliesComment() | length > 0 %}
            {% for reply in comment.getRepliesComment() %}
               {% set userReply = reply.user  %}
                <div class="cl-comment-reply">
                <div class="cl-avatar">
                    <a href="/channels/{{userReply.getChannelSlug()}}">
                        <img src="{{userReply.getAvatar(50)}}" alt="" class="avatar-user">
                    </a>
                </div>
                <div class="cl-comment-text" data-comment-id="{{ reply.id }}" data-object="{{ reply.object }}">
                    <div class="cl-name-date"><a href="#">{{userReply.getFullname() }}</a> . {{ reply.getHumanCreatedAt() }}</div>
                    <div class="cl-text">{{ reply.getContent() }}.</div>
                    <div class="cl-meta">
                        {{ partial('partials/vote', ['vote' : reply, 'object' : 'postReplies', 'objectId' : reply.id]) }}
                        <a href="#" class="js-replies">Reply</a>
                        <div class="rc-replies" style="display: none">
                            {{ partial('partials/comment-form', ['objectId' : reply.id, 'object' : 'postsReplies']) }}
                        </div>
                    </div>
                </div>
                    {#{% if reply.getRepliesComment() | length > 0 %}#}
                        {#{% for reply in reply.getRepliesComment()%}#}
                            {#{{ partial('partials/comment-item', ['comment' : reply, 'class' : true]) }}#}
                        {#{% endfor %}#}
                    {#{% endif %}#}
                </div>
            {% endfor %}
        {% endif  %}
{% endif %}
