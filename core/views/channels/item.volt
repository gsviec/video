{% extends 'layouts/layout.volt' %}
{% block title %}Channel Edit{% endblock %}
{% block content %}
    <section class="page-width container" id="channel">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Channel settings</div>

                    <div class="panel-body">
                        <form action="/channels/save" method="post" enctype="multipart/form-data">
                            {% if object is defined %}
                                {{form.render('id')}}
                            {% endif %}
                            <div class="form-group">
                                <label for="name">Name</label>
                                {{ form.render('name')}}
                            </div>

                            <div class="form-group">
                                <label for="slug">Unique URL</label>

                                <div class="input-group">
                                    <div class="input-group-addon">{{publicUrl}}channels/</div>
                                    {{ form.render('slug')}}
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                {{ form.render('description')}}
                            </div>

                            <div class="form-group">
                                <label for="image">Channel image</label>
                                <input type="file" name="image" id="image">
                            </div>

                            <button class="btn btn-default" type="submit">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
{% endblock %}
