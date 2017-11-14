{% extends 'layouts/layout.volt' %}
{% block title %}{{ t('Edit Avatar') }}{% endblock %}
{% block content %}
    <section class="page-width container" id="channel">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ t('Edit Avatar') }}</div>
                    <div class="panel-body" style="height: 50%">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>{{ t('Currently your avatar') }}</label>
                                {{ image(avatar) }}
                            </div>
                            <div class="form-group">
                                <label>Chose a avatar from your computer</label>
                                <label class="btn btn-default btn-file">
                                    <input type="file" name="image" id="image">

                                    {#Browse <input class="form-control" type="file" name="file" style="display: none;">#}
                                </label>
                            </div>
                            <button class="btn btn-default" type="submit">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
{% endblock %}