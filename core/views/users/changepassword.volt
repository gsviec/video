{% extends 'layouts/layout.volt' %}
{% block title %}Profile Edit{% endblock %}
{% block content %}
    <section class="page-width container" id="channel">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ t('Change password') }}</div>

                    <div class="panel-body">

                        {{ form( this.view.getControllerName() | lower ~ '/changepassword', 'class' : 'form-horizontal') }}

                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ t('New password') }}:</label>
                            <div class="col-sm-10">
                                {{ form.render('passwd_new') }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ t('Confirm new password') }}:</label>
                            <div class="col-sm-10">
                                {{ form.render('passwd_new_confirm') }}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                {{ form.render('save') }}
                            </div>
                        </div>
                        {{ endform() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
{% endblock %}
