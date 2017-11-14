{% extends 'layouts/login.volt' %}
{% block title %}Signup{% endblock %}
{% block content %}
    <div class="row">
        <div class="login-wraper">
            {{ partial('partials/banner-login') }}
            <div class="login-window">
                <div class="l-head">
                    Forgot your password
                </div>
                <div class="l-form">
                    {{ this.flashSession.output() }}
                    {{ form('') }}
                    <div class="form-group">
                        <label for="exampleInputPassword2">Email</label>
                        {{ form.render('email') }}
                    </div>

                    <div class="row">
                        <div class="col-lg-7"><button type="submit" class="btn btn-cv1">Reset password</button></div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
{% endblock %}
