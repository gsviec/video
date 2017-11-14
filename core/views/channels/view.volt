{% extends 'layouts/layout.volt' %}
{% block title %}Home{% endblock %}
{% block content %}
    <div class="row">
        <div class="col-lg-12">
            <div class="channel-details">
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-2 col-xs-12">
                        <div class="c-details">
                            <div class="c-name">
                                {{ t(channel.getName()) }}
                                <div class="c-checkbox">
                                    <img src="/images/verified-profile-icon.png" alt="">
                                </div>
                            </div>
                            <div class="c-nav">
                                <ul class="list-inline">
                                    <li><a href="#">Videos</a></li>
                                    <li><a href="#">Playlist</a></li>
                                    <li><a href="#">Channels</a></li>
                                    <li><a href="#">Discussion</a></li>
                                    <li><a href="#">About</a></li>
                                    <li><a href="#">Donate</a></li>
                                </ul>
                            </div>
                            <div class="c-sub pull-right">
                                <div class="c-sub-wrap">
                                    <div class="c-f">
                                        {{ t('Subscribe') }}
                                    </div>
                                    <div class="c-s">
                                        {{ channel.getSubscribe() }}
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Featured Videos -->
            <div class="content-block">
                <div class="cb-header">
                    <div class="row">
                        <div class="col-lg-8 col-xs-12 col-sm-6">
                            <div class="btn-group bg-clean">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Uploads <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#"><i class="cv cvicon-cv-relevant"></i> Relevant</a></li>
                                    <li><a href="#"><i class="cv cvicon-cv-calender"></i> Recent</a></li>
                                    <li><a href="#"><i class="cv cvicon-cv-view-stats"></i> Viewed</a></li>
                                    <li><a href="#"><i class="cv cvicon-cv-star"></i> Top Rated</a></li>
                                    <li><a href="#"><i class="cv cvicon-cv-watch-later"></i> Longest</a></li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-lg-4 col-xs-12 col-sm-6">
                            <div class="h-grid pull-right">
                                <a href="#"><i class="cv cvicon-cv-grid-view"></i></a>
                                <a href="#"><i class="cv cvicon-cv-list-view"></i></a>
                            </div>
                            <div class="btn-group pull-right bg-clean">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Date Added ( Newest ) <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#"><i class="cv cvicon-cv-relevant"></i> Relevant</a></li>
                                    <li><a href="#"><i class="cv cvicon-cv-calender"></i> Recent</a></li>
                                    <li><a href="#"><i class="cv cvicon-cv-view-stats"></i> Viewed</a></li>
                                    <li><a href="#"><i class="cv cvicon-cv-star"></i> Top Rated</a></li>
                                    <li><a href="#"><i class="cv cvicon-cv-watch-later"></i> Longest</a></li>
                                </ul>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                {% if videos | length > 0%}
                <div class="cb-content videolist">
                    {{ partial('partials/list-video',['videos' : videos ]) }}
                </div>
                <div class="v-pagination">
                    {{ partial('partials/pagination', ['currentPage':  currentPage, 'totalPages' : totalPages]) }}
                </div>
                {% else %}
                    <p>This channel have not video</p>
                {% endif %}
            </div>
            <!-- /Featured Videos -->

        </div>
    </div>
{% endblock %}
