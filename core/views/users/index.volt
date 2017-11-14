{% extends 'layouts/layout.volt' %}
{% block title %}{{ this.config.application.tagline }}{% endblock %}
{% block content %}
    <div class="row">
        <div class="col-md-9">
            <div class="tabs-warp question-tab">
                {{ partial('partials/form') }}
                <div class="tab-inner-warp">
                    <div class="question">
                        <ul class="content-tabs">
                            <li class="tab"><a href="">{{t('All')}}(1200)</a></li>
                            <li class="tab"><a href="">{{t('Professional Teacher')}}(800)</a></li>
                            <li class="tab"><a href="">{{t('Community Tutor')}}(400)</a></li>
                        </ul>
                    </div>
                    <div class="tab-inner">
                        {{ partial('partials/list-users')}}
                    </div>
                </div>
            </div><!-- End page-content -->
            {{ partial('partials/pagination')}}
        </div><!-- End main -->
        <aside class="col-md-3 sidebar">
            {{ partial('partials/right-side')}}
        </aside><!-- End sidebar -->
    </div><!-- End row -->
{% endblock %}
