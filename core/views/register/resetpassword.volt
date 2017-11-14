{% extends 'layouts/login.volt' %}
{% block title %}Signup{% endblock %}
{% block content %}
    <div class="row">
        <div class="login-wraper">
            {{ partial('partials/banner-login') }}
            <div class="login-window">
                <div class="l-head">
                    Created your password
                </div>
                <div class="l-form">
                    {{ this.flashSession.output() }}
                    {{ form('') }}
                    <div class="form-group">
                        <label for="exampleInputPassword2">Password</label>
                        {{ form.render('password_new') }}
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword2">Confirm new password</label>
                        {{ form.render('password_new_confirm') }}
                    </div>
                    <div class="row">
                        <div class="col-lg-7"><button type="submit" class="btn btn-cv1">Change password</button></div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
{% endblock %}
