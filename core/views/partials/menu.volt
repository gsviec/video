<div class="page-width ctn-one">
    <nav class="box-menu">
        <ul>
            <li class="logo"><a href="/">
                    <img src="/images/logo.png"></a>
            </li>
            <li class="home-bg active">
                <a href="/" class="current">Popular</a>
            </li>
            <li class="home-bg"><a href="/categories" class="">Categories</a></li>
            <li class="home-bg"><a href="/channels" class="">Channels</a></li>
        </ul>
    </nav>
    <div class="search-ctn">
        <form method="GET" action="/search">
            <input type="text" name="q" class="txt-keyword" placeholder="Search">
            <span class="fa btn-search"></span>
            <img src="/images/video-icon.png" class="video_icon">
            <span class="fa fa-angle-down"></span>
        </form>
    </div>
    {% if isLogin() %}
        <div class="user-header">
            <a href=""><img src="/images/demo.jpg" class="avatar-user"></a>
            <div class="dropdown">
                <div class="dropdown-toggle" data-toggle="dropdown">
                    <h3>Bailey</h3>
                    <span class="fa fa-sort-desc"></span>
                </div>
                <ul class="dropdown-menu">
                    <li><a href="#"><img src="/images/relevant.png">Your channel</a></li>
                    <li><a href="/channels/edit/{{ user.channel.id }}"><img src="/images/relevant.png">Channel settings</a></li>

                    <li><a href="#"><img src="/images/recent.png">Recent</a></li>
                    <li><a href="#"><img src="/images/viewed.png">Viewed</a></li>
                    <li><a href="#"><span class="fa fa-star-o">Top Rated</a></li>
                    <li><a href="#"><img src="/images/watch-later.png"></span>Longest</a></li>
                </ul>
            </div>
        </div>
    {% else %}
        <div class="user-header user-login">
            <a href="/login">Login.</a>
            <a href="/signup">Signup</a>
        </div>
    {% endif %}
</div>
