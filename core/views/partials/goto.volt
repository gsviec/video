{% if controller == 'channels' and action == 'view' %}
    <div class="container-fluid">
        <div class="row">
            <div class="img">
                {{ image('images/channel-banner.png', 'class' : 'c-banner') }}
                <div class="c-avatar">
                    <a href="">
                        {{ image(channel.getThumbnail(), 'class' : 'channel-view') }}
                    </a>
                </div>
                <div class="c-social">
                    Social
                    <a href="https://facebook.com/{{ channelsUser.getFacebook() }}" class="fb" target="_blank">
                        <i class="fa fa-facebook"></i>
                    </a>
                    <a href="https://twitter.com/{{ channelsUser.getTwitter() }}" class="tw" target="_blank">
                        <i class="fa fa-twitter"></i>
                    </a>
                    <a href="https://plus.google.com/{{ channelsUser.getGoogle() }}" class="gp" target="_blank">
                        <i class="fa fa-google-plus"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
{% endif %}
