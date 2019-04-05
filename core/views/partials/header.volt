<div id="header" class="container-fluid">
        <nav class="navbar navbar-default">
            <div class="container">
                <button id="m-navbar-button" type="button" class="navbar-toggle collapsed pull-right" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                    <a class="navbar-brand" href="/">
                        <img src="/images/logo.png?v1" alt="Gsviec" class="logo"/>
                    </a>
                    <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav list-inline menu">
                                <li><a href="/blog">{{ t('Blog') }}</a></li>
                                <li><a href="/service">{{ t('Dịch vụ') }}</a></li>
                                <li><a href="/playlist">{{ t('Series') }}</a></li>
                                <li class="hidden-lg hidden-md hidden-sm"><a href="/login">{{ t('Login') }}</a></li>
                                <li class="hidden-lg hidden-md hidden-sm"><a href="/signup">{{ t('Sign up') }}</a></li>
                            </ul>
                            <div>
                                <form  class="form-inline my-2 my-lg-0" action="/search" method="GET">
                                <div class="topsearch">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-search"></i></span>
                                        <input type="text" class="form-control" placeholder="{{t('Search')}}" aria-describedby="sizing-addon2" name="q">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="cv cvicon-cv-video-file"></i>&nbsp;&nbsp;&nbsp;<span class="caret"></span></button>/
                                            <ul class="dropdown-menu">
                                                <li><a href="#"><i class="cv cvicon-cv-relevant"></i> Relevant</a></li>
                                                <li><a href="#"><i class="cv cvicon-cv-calender"></i> Recent</a></li>
                                                <li><a href="#"><i class="cv cvicon-cv-view-stats"></i> Viewed</a></li>
                                                <li><a href="#"><i class="cv cvicon-cv-star"></i> Top Rated</a></li>
                                                <li><a href="#"><i class="cv cvicon-cv-watch-later"></i> Longest</a></li>
                                            </ul>
                                        </div><!-- /btn-group -->
                                    </div>
                                </div>
                            </form>
                            </div>
                            {% set user = this.auth.getUser() %}
                            {% if user == true %}
                                <div class="avatar pull-left">
                                    <img src="{{ user.getAvatar() }}" alt="avatar" class="avatar-user"/>
                                    <span class="status"></span>
                                </div>
                                <div class="selectuser pull-left">
                                    <div class="btn-group pull-right dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">{{ user.getFullname() }}<span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            {% if user.channel %}
                                            <li><a href="/channels/edit/{{ user.channel.uniqid }}">{{ t('Edit channel') }}</a></li>
                                            {% endif %}
                                            <li><a href="/users/profile">{{ t('Edit Profile') }}</a></li>
                                            <li><a href="/users/avatar">{{ t('Edit avatar') }}</a></li>
                                            <li><a href="/channels/{{ user.channel.slug }}">{{ t('Your channel') }}</a></li>
                                            <li><a href="/users/changepassword">{{ t('Change password') }}</a></li>
                                            <li><a href="/logout">{{ t('Logout') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            {% else %}
                                <div class="avatar sub-header pull-right hidden-xs">
                                    <img class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" src="/images/avatar.png" alt="avatar" width="100" height="100" />
                                    <span  class="status dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ></span>
                                        
                                        <ul class="dropdown-menu">
                                            <li><a href="/login">{{ t('Login') }}</a></li>
                                            <li><a href="/signup">{{ t('Sign up') }}</a></li>
                                        </ul>
                                </div>
                                
                            {% endif %}
                    </div>
            </div>
        </nav>
</div>
