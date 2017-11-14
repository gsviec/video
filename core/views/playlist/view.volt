{% extends 'layouts/layout.volt' %}
{% block title %}{{ playlist.title }}{% endblock %}
{% block content %}
    <div class="row">
        <div class="col-lg-12 v-history">
            <!-- History -->
            <div class="content-block">
                <div class="cb-header">
                    <div class="row">
                        <div class="col-lg-8 col-xs-12 col-sm-6">
                            <ul class="list-inline">
                                <li><a href="#" class="color-active active">Series</a></li>
                                <li><a href="#">{{ playlist.title }}</a></li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="cb-content">

                    <!-- history video row -->
                    {% for i,video in playlistVideo %}
                        <div class="row">
                            <div class="h-video">
                                <div class="col-lg-2 col-xs-12 col-sm-5">
                                    <div class="v-img">
                                        <a href="/watch?v={{video.getShortId()}}&list={{playlist.slug}}">
                                            {{ image(video.getThumbnail()) }}
                                        </a>
                                        <div class="time">{{video.duration}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-xs-10 col-sm-5">
                                    <div class="v-desc">
                                        <a href="/watch?v={{video.getShortId()}}&list={{playlist.slug}}" class="text-bold">
                                            {{ t('Part') }} {{ i+1 }}: {{ video.title }}
                                            <span class="label label-success">FREE</span>
                                        </a>
                                        <br/>
                                        <div class="play-list-excerpt content">
                                            {{ truncate(video.content, 300) }}
                                        </div>
                                    </div>
                                    <div class="v-views">
                                        {{video.getHumanNumberViews()}} views. <span class="v-percent">&nbsp;{{ video.getHumanEditedAt()}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-xs-2 col-sm-2 h-clear-list">
                                    <a href="#"><i class="cvicon-cv-liked"></i>    </a>
                                </div>
                                <div class="clearfix"></div>
                                <div class="h-divider"></div>
                            </div>
                        </div>
                    {% endfor %}
                    <!-- ///history video row -->
                </div>
            </div>
        </div>
    </div>
{% endblock %}
