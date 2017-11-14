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

{% if isGoto %}
<div class="container-fluid">
    <div class="row">
        <div class="navbar-container2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-1 col-sm-2 col-xs-12">
                        <div class="goto">
                            {{ t('Go to') }}:
                        </div>
                    </div>
                    <div class="col-lg-3  col-sm-10 col-xs-12">
                        <div class="h-icons">
                            <a href="#"><i class="cv cvicon-cv-liked" data-toggle="tooltip" data-placement="top" title="Liked Videos"></i></a>
                            <a href="/playlist?list=watch"><i class="cv cvicon-cv-watch-later" data-toggle="tooltip" data-placement="top" title="Watch Later"></i></a>
                            <a href="#"><i class="cv cvicon-cv-play-circle" data-toggle="tooltip" data-placement="top" title="Saved Playlist"></i></a>
                            <a href="#"><i class="cv cvicon-cv-purchased" data-toggle="tooltip" data-placement="top" title="Purchased Videos"></i></a>
                            <a href="/history"><i class="cv cvicon-cv-history" data-toggle="tooltip" data-placement="top" title="History"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-sm-10 col-xs-12">
                        <!-- <div class="h-resume">
                            <div class="play-icon">
                                <a href="#"><i class="cv cvicon-cv-play"></i></a>
                            </div>
                            Resume:  <span class="color-default">Daredevil Season 2 : Episode 6 </span>
                        </div> -->
                    </div>
                    <div class="col-lg-1 col-sm-2 hidden-xs">
                        <div class="h-grid">
                            <a href="#"><i class="cv cvicon-cv-grid-view"></i></a>
                            <a href="#"><i class="cv cvicon-cv-list-view"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endif %}

{% if isSeries is defined  %}
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h1>{{ playlist.title}}</h1>
                <div>
                    {{ this.markdown.text(playlist.content) }}
                </div>
            </div>
            <div class="col-md-3 series-thumbnail">
                <img class="pull-right" src="{{static_url(playlist.getThumbnail())}}"  width="170" height="196">
            </div>
        </div>
    </div>
{% endif %}
