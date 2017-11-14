{% extends 'layouts/layout.volt' %}
{% block title %}Search{% endblock %}
{% block content %}
    <div class="row">
        <div class="col-lg-12">
            {% if posts | length > 0 %}
                <div class="content-block head-div">
                    <div class="cb-header">
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-xs-8">
                                <ul class="list-inline">
                                    <li><a href="#" class="active">Search Videos</a>: {{ q }}</li>
                                </ul>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-xs-4">
                                {{ partial('partials/sortby') }}
                            </div>
                        </div>
                    </div>
                    <div class="cb-content videolist">
                        {{ partial('partials/list-video', ['videos' : posts])}}
                    </div>
                </div>
            {% endif %}
            <!-- /Featured Videos -->

            <!-- pagination -->
            <div class="v-pagination">
                {{ partial('partials/pagination', ['currentPage':  currentPage, 'totalPages' : totalPages]) }}
            </div>
            <!-- /pagination -->

        </div>
        </div>
    </div>
{% endblock %}
