{% extends 'layouts/login.volt' %}
{% block title %} {{ this.config.application.name ~ t('Login')}}{% endblock %}
{% block content %}
    <div class="row">
        <div class="login-wraper">
            <img src="/images/login.jpg" alt="">
            <div class="banner-text">
                <div class="line"></div>
                <div class="b-text">
                    Watch <span class="color-active">millions<br> of</span> <span class="color-b1">v</span><span class="color-b2">i</span><span class="color-b3">de</span><span class="color-active">os</span> for free.
                </div>
                <div class="overtext">
                    Over 6000 videos uploaded Daily.
                </div>
            </div>
            <div class="login-window">
                <div class="l-head">
                    Log Into Your {{name}} Account
                </div>
                <div class="l-form">
                    {{ this.flashSession.output() }}
                    {{ form('')}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            {{ form.render('email')}}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            {{ form.render('password')}}
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1" checked="1"> <span>Remember me on this computer</span>
                                <span class="text2">(not recomended on public or shared computers)</span>
                            </label>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-7"><button type="submit" class="btn btn-success">Login</button></div>
                            <div class="col-lg-1 ortext">or</div>
                            <div class="col-lg-4 signuptext"><a href="/signup">Sign Up</a></div>
                        </div>
                        <br>
                        <div class="google-login form-group">
                            <a href="/oauth/google" class="btn btn-cv1"><span class="fa fa-google-plus"></span>Login with google</a>
                        </div>

                        <div class="google-login form-group">
                            <a href="/oauth/facebook" class="btn btn-cv1"><span class="fa fa-facebook"></span>Login with facebook</a>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 forgottext">
                                <a href="/forgotpassword">Forgot Username or Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

{% endblock %}
