{% extends 'layouts/layout.volt' %}
{% block title %}{{ t('Home') }}{% endblock %}
{% block content %}
    <div class="row">
        <div class="col-lg-12">
            <!-- Featured Videos -->
            {% if featureVideos | length > 0 %}
            <div class="content-block head-div">
                <div class="cb-header">
                    <div class="row">
                        <div class="col-lg-10 col-sm-10 col-xs-8">
                            <ul class="list-inline">
                                <li><a href="#" class="active">Featured Videos</a></li>
                                <li><a href="#">New Videos</a></li>
                                <li><a href="#">Recommended For You</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-xs-4">
                            {{ partial('partials/sortby') }}
                        </div>
                    </div>
                </div>
                <div class="cb-content videolist">
                    {{ partial('partials/list-video', ['videos' : featureVideos])}}
                </div>
            </div>
            {% endif %}
            <!-- /Featured Videos -->

            <!-- New Videos in India -->
            {% if newVideos | length > 0  %}
            <div class="content-block head-div">
                <div class="cb-header">
                    <div class="row">
                        <div class="col-lg-10 col-sm-10 col-xs-8">
                            <ul class="list-inline">
                                <li><a href="#" class="color-active">{{t('New Videos')}}</a></li>
                                <li><a href="#">{{t('Most Viewed')}}</a></li>
                                <li><a href="#">{{t('Featured This Week')}}</a></li>
                            </ul>
                        </div>
                        {{ partial('partials/sortby') }}
                    </div>
                </div>
                <div class="cb-content videolist">
                    {{partial('partials/list-video', ['videos' : newVideos])}}
                </div>
            </div>
            {% endif %}
            <!-- /New Videos in India -->

            {% if phpVideos | length > 0  %}
                <div class="content-block head-div">
                    <div class="cb-header">
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-xs-8">
                                <ul class="list-inline">
                                    <li><a href="/categories/php" class="color-active">{{t('PHP Videos')}}</a></li>
                                </ul>
                            </div>
                            {{ partial('partials/sortby') }}
                        </div>
                    </div>
                    <div class="cb-content videolist">
                        {{partial('partials/list-video', ['videos' : phpVideos])}}
                    </div>
                </div>
            {% endif %}

            <!-- cats video -->

            {% if wpVideos | length > 0  %}
            <div class="content-block head-div">
                <div class="cb-header">
                    <div class="row">
                        <div class="col-lg-10 col-sm-10 col-xs-8">
                            <ul class="list-inline">
                                <li><a href="/categories/wordpress" class="color-active">{{t('Wordpress Videos')}}</a></li>

                            </ul>
                        </div>
                        {{ partial('partials/sortby') }}
                    </div>
                </div>
                <div class="cb-content videolist">
                    {{partial('partials/list-video', ['videos' : wpVideos])}}
                </div>
            </div>
            {% endif %}

            {% if phalconVideos | length > 0  %}
                <div class="content-block head-div">
                    <div class="cb-header">
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-xs-8">
                                <ul class="list-inline">
                                    <li><a href="/categories/phalcon" class="color-active">{{t('Phalcon Videos')}}</a></li>
                                </ul>
                            </div>
                            {{ partial('partials/sortby') }}
                        </div>
                    </div>
                    <div class="cb-content videolist">
                        {{partial('partials/list-video', ['videos' : phalconVideos])}}
                    </div>
                </div>
            {% endif %}
            {% if toolVideos | length > 0  %}
                <div class="content-block head-div">
                    <div class="cb-header">
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-xs-8">
                                <ul class="list-inline">
                                    <li><a href="/categories/tool" class="color-active">{{t('Tool Videos')}}</a></li>
                                </ul>
                            </div>
                            {{ partial('partials/sortby') }}
                        </div>
                    </div>
                    <div class="cb-content videolist">
                        {{partial('partials/list-video', ['videos' : toolVideos])}}
                    </div>
                </div>
            {% endif %}

            {% if gitVideos | length > 0  %}
                <div class="content-block head-div">
                    <div class="cb-header">
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-xs-8">
                                <ul class="list-inline">
                                    <li><a href="/categories/git" class="color-active">{{t('Git Videos')}}</a></li>
                                </ul>
                            </div>
                            {{ partial('partials/sortby') }}
                        </div>
                    </div>
                    <div class="cb-content videolist">
                        {{partial('partials/list-video', ['videos' : gitVideos])}}
                    </div>
                </div>
            {% endif %}

            {% if jsVideos | length > 0  %}
                <div class="content-block head-div">
                    <div class="cb-header">
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-xs-8">
                                <ul class="list-inline">
                                    <li><a href="/categories/javascript" class="color-active">{{t('JavaScript Videos')}}</a></li>
                                </ul>
                            </div>
                            {{ partial('partials/sortby') }}
                        </div>
                    </div>
                    <div class="cb-content videolist">
                        {{partial('partials/list-video', ['videos' : jsVideos])}}
                    </div>
                </div>
            {% endif %}

             <!-- Comedy videos -->
            {% if devopsVideos | length > 0  %}
            <div class="content-block head-div">
                <div class="cb-header">
                    <div class="row">
                        <div class="col-lg-10 col-sm-10 col-xs-8">
                            <ul class="list-inline">
                                <li><a href="/categories/devops" class="color-active">{{t('DevOps Videos')}}</a></li>

                            </ul>
                        </div>
                        {{ partial('partials/sortby') }}
                    </div>
                </div>
                <div class="cb-content videolist">
                    {{partial('partials/list-video', ['videos' : devopsVideos])}}
                </div>
            </div>
            {% endif %}
            <!-- /end comedy video -->

            <!-- Popular Channels -->
            <div class="content-block head-div">
                <div class="cb-header">
                    <div class="row">
                        <div class="col-lg-10 col-sm-10 col-xs-8">
                            <ul class="list-inline">
                                <li><a href="#">{{t('Popular Series')}}</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-xs-4">
                            <div class="btn-group pull-right bg-clean">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                   More <span class="caret"></span>
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
                <div class="cb-content">
                    <div class="row">
                        {% for p in playlist %}
                        <div class="col-lg-2 col-sm-4 col-xs-6">
                            <div class="b-chanel">
                                <a href="/playlist/{{ p.slug }}">
                                <img src="{{static_url(p.getThumbnail())}}"  width="170" height="196">
                                <div class="hover">{{ p.title }}<br><i class="cv cvicon-cv-liked"></i> 5K</div>
                                </a>
                            </div>
                        </div>
                        {% endfor %}
                    </div>
                </div>
            </div>
            <!-- /Popular Channels -->

            <!-- pagination -->
            <div class="v-pagination">
                {{ partial('partials/pagination', ['currentPage':  page, 'totalPages' : 10]) }}
            </div>
            <!-- /pagination -->

        </div>
    </div>
{% endblock %}
