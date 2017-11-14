{% extends 'layouts/layout.volt' %}
{% block title %}Profile Edit{% endblock %}
{% block content %}
    <section class="page-width container" id="channel">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ t('Profile Edit') }}</div>

                    <div class="panel-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            {% if object is defined %}
                                {{form.render('id')}}
                            {% endif %}
                            <div class="form-group col-md-8">
                                <label for="name">Full Name</label>
                                {{ form.render('name')}}
                            </div>

                            <div class="form-group col-md-4">
                                <label for="description">Username</label>
                                {{ form.render('username')}}
                            </div>

                            <div class="form-group col-md-12">
                                <label for="description">Short bio</label>
                                {{ form.render('bio')}}
                            </div>

                            <div class="form-group col-md-12">
                                <label for="description">Facebook Account</label>
                                <div class="input-group">
                                    <div class="input-group-addon">http://facebook.com/</div>
                                    {{ form.render('facebook')}}
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="description">Twitter Account</label>
                                <div class="input-group">
                                    <div class="input-group-addon">http://twitter.com/</div>
                                    {{ form.render('twitter')}}
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="description">Google Account</label>
                                <div class="input-group">
                                    <div class="input-group-addon">http://plus.google.com/</div>
                                    {{ form.render('google')}}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-default col-md-12" type="submit">Update</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
{% endblock %}
