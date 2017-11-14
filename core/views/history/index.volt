{% extends 'layouts/layout.volt' %}
{% block title %}History{% endblock %}
{% block content %}
    <div class="row">
        <div class="col-lg-12 v-history">
            <!-- History -->
            <div class="content-block">
                <div class="cb-header">
                    <div class="row">
                        <div class="col-lg-8 col-xs-12 col-sm-6">
                            <ul class="list-inline">
                                <li><a href="#" class="color-active active">Watch history</a></li>
                                <li><a href="#">Search history</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-4 col-xs-12 col-sm-6 h-clear">
                            <a href="#"><i class="cvicon-cv-cancel"></i> Clear all Search History</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="cb-content">

                    <!-- history video row -->
                    {% for video in videos %}
                    <div class="row">
                        <div class="h-video">
                            <div class="col-lg-2 col-xs-12 col-sm-5">
                                <div class="v-img">
                                    <a href="/watch?v={{video.getShortId() }}">
                                        {{ image(video.getThumbnail()) }}
                                    </a>
                                    <div class="time">{{video.duration}}</div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-xs-10 col-sm-5">
                                <div class="v-desc">
                                    <a href="/watch?v={{video.getShortId() }}"> {{ video.title }}</a>
                                </div>
                                <div class="v-views">
                                    {{video.getHumanNumberViews()}} views. <span class="v-percent">&nbsp;{{ video.getHumanEditedAt()}}
                                </div>
                                <div class="v-percent"><span class="v-circle"></span> 84%</div>

                            </div>
                            <div class="col-lg-2 col-xs-2 col-sm-2 h-clear-list">
                                <a href="#"><i class="cvicon-cv-cancel"></i>    </a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="h-divider"></div>
                        </div>
                    </div>
                    {% endfor %}
                    <!-- ///history video row -->
                </div>
            </div>
            <!-- /History -->
            <div class="v-pagination">
                {{ partial('partials/pagination', ['currentPage':  currentPage, 'totalPages' : totalPages]) }}
            </div>
        </div>
    </div>
{% endblock %}
