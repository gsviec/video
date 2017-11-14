{% extends 'layouts/layout.volt' %}
{% block title %}{{t('Play list')}}{% endblock %}
{% block content %}
    <div class="row">
        <div class="col-lg-12 v-categories">
            <!-- Popular Channels -->
            <div class="content-block">
                <div class="cb-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <ul class="list-inline">
                                <li><a href="#" class="color-active">{{ t('All Series') }}</a></li>
                                <li><a href="#">Most Popular</a></li>
                                <li><a href="#">Trending</a></li>
                                <li><a href="#">Most Recent</a></li>
                                <li><a href="#">A - Z</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="cb-content">
                    <div class="row">
                        <!-- 1-6 -->
                        {% if playlist | length > 0 %}
                        {% for p in playlist %}
                        <div class="col-lg-2 col-xs-6 col-sm-3">
                            <div class="b-category">
                                <a href="/playlist/{{p.slug}}">
                                <img src="{{static_url(p.getThumbnail())}}"  width="170" height="196">
                                </a>
                                <a href="/playlist/{{p.slug}}" class="name">{{ p.title }}</a>
                                <p class="desc">{{ postsPlaylist.getNumberPostByPlaylist(p.id) }} Videos</p>

                            </div>
                        </div>
                        {% endfor %}
                        {% endif %}
                    </div>
                </div>
            </div>
            <!-- /Popular Channels -->
            <div class="v-pagination">
                {{ partial('partials/pagination', ['currentPage':  currentPage, 'totalPages' : totalPages]) }}
            </div>
        </div>
    </div>
{% endblock %}
