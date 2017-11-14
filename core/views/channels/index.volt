{% extends 'layouts/layout.volt' %}
{% block title %}Channel{% endblock %}
{% block content %}
        <div class="row">
            <div class="col-lg-12 channels">
                <!-- Popular Channels -->
                <div class="content-block">
                    <div class="cb-header">
                        <div class="row">
                            <div class="col-lg-8">
                                <ul class="list-inline">
                                    <li><a href="#" class="color-active">Browse All Channels</a></li>
                                    <li><a href="#">Most Popular</a></li>
                                    <li><a href="#">Trending</a></li>
                                    <li><a href="#">Most Recent</a></li>
                                    <li><a href="#">A - Z</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="channels-content">
                        <h4>Most Popular</h4>
                        <a href="#" class="btn-view-more">View more</a>
                        <div class="clearfix"></div>
                        <div class="theme-section">
                            <div class="row">
                                {% if channels | length > 0 %}
                                {% for channel in channels %}
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="cns-block">
                                        <a href="/channels/{{ channel.slug }}" class="cns-image">
                                            {{ image(channel.getThumbnail()) }}
                                        </a>
                                        <div class="cns-img-small">
                                            <div class="cns-small-wrapp">
                                                {% if is_object(channel.user) %}
                                                {{ image(channel.user.getAvatar()) }}
                                                {% endif %}
                                            </div>
                                        </div>
                                        <div class="cns-info">
                                            <h5>{{ channel.name }}<I class="arrow"></I></h5>
                                            <span>{{ channel.getSubscribe() }} Subscribers</span>
                                            <span>{{ channel.getHumanNumberVideo() }} Videos</span>
                                            <span>10 Million Views</span>
                                            <span class="cv-percent">
                                                <span class="cv-circle"></span>
                                            78%</span>
                                        </div>
                                    </div>
                                </div>
                                {% endfor %}
                                {% endif %}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Popular Channels -->
                <!-- pagination -->
                <div class="v-pagination">
                    {{ partial('partials/pagination', ['currentPage':  currentPage, 'totalPages' : totalPages]) }}
                </div>
            </div>
        </div>

{% endblock %}
