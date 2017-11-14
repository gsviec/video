{% extends 'layouts/layout.volt' %}
{% block title %}Categories{% endblock %}
{% block content %}
    <div class="row">
        <div class="col-lg-12 v-categories">
            <!-- Popular Channels -->
            <div class="content-block">
                <div class="cb-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <ul class="list-inline">
                                <li><a href="#" class="color-active">{{ t('All Categories') }}</a></li>
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
                        {% if categories | length > 0 %}
                        {% for cat in categories %}
                        <div class="col-lg-2 col-xs-6 col-sm-3">
                            <div class="b-category">
                                <a href="/categories/{{cat.slug}}">
                                    {{ image(cat.getThumbnail())}}
                                </a>
                                <a href="/categories/{{cat.slug}}" class="name">{{ cat.name }}</a>
                                <p class="desc">{{ cat.getHumanNumberVideo() }} Videos</p>
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
