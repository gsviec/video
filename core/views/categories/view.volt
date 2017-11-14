{% extends 'layouts/layout.volt' %}
{% block title %}{{ t('Categories') }}{% endblock %}
{% block content %}
    <div class="row">
        <div class="col-lg-12">
            <div class="content-block">
                <div class="cb-header">
                    <div class="row">
                        <div class="col-lg-8 col-xs-12 col-sm-6">
                            <ul class="list-inline">
                                <li><a href="#" class="color-active active">{{ t('Categories') }}:</a></li>
                                <li><a href="#">{{ name }}</a></li>
                            </ul>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="cb-content videolist">
                    {{ partial('partials/list-video',['videos' : videos ]) }}
                </div>
            </div>
            <!-- /Featured Videos -->

            <!-- pagination -->
            <div class="v-pagination">
                {{ partial('partials/pagination', ['currentPage':  currentPage, 'totalPages' : totalPages]) }}
            </div>
            <!-- /pagination -->

        </div>
    </div>
{% endblock %}
