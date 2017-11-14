{% extends 'layouts/layout.volt' %}
{% block title %}{{post.title}}{% endblock %}
{% block content %}
    <div class="row">
        <div class="col-lg-8 col-xs-12 col-sm-12">
            <div class="sv-video video-single-play">
                    <video id="my-video"></video>
            </div>
            <h1><a href="#">{{post.title}}</a></h1>
            {% set user = post.user %}
            <div class="author">
                <a href="/channels/{{user.getChannelSlug()}}">
                    {{image(user.getChannelImage(), 'class':'sv-avatar')}}
                </a>
                <div class="sv-name">
                    <div><a href="/channels/{{user.getChannelSlug()}}">{{user.getChannelName()}}</a> . {{user.getNumberVideo()}} Videos</div>
                    <div class="c-sub">
                        <div class="c-f">
                            <a href="#">Subscribe</a>
                        </div>
                        <div class="c-s">
                            {{ user.getNumberChannelSubscribe() }}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="sv-views">
                    <div class="sv-views-count">
                        {{post.getHumanNumberViews()}} views
                    </div>
                    <div class="sv-views-progress">
                        <div class="sv-views-progress-bar"></div>
                    </div>
                    <div class="sv-views-stats">
                        <span class="percent">95%</span>
                        {{ partial('partials/vote', ['vote' : vote, 'object' : 'posts', 'objectId' : post.id]) }}
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="info">
                    <div class="custom-tabs">
                        <div class="tabs-panel">
                            <a href="#" class="active" data-tab="tab-1">
                                <i class="cv cvicon-cv-about" data-toggle="tooltip" data-placement="top" title="About"></i>
                                <span>About</span>
                            </a>
                            <a href="#" data-tab="tab-2">
                                <i class="cv cvicon-cv-share" data-toggle="tooltip" data-placement="top" title="Share"></i>
                                <span>Share</span>
                            </a>
                            <a href="#" data-tab="tab-3">
                                <i class="cv cvicon-cv-download" data-toggle="tooltip" data-placement="top" title="Download"></i>
                                <span>Download</span>
                            </a>
                            <a href="#" data-tab="tab-4">
                                <i class="cv cv cvicon-cv-goto" data-toggle="tooltip" data-placement="top" title="Jump to"></i>
                                <span>Jump to</span>
                            </a>
                            <a href="#" data-tab="tab-5">
                                <i class="cv cvicon-cv-plus" data-toggle="tooltip" data-placement="top" title="Add to"></i>
                                <span>Add to</span>
                            </a>
                            <div class="acide-panel">
                                 <a href="#"><i class="cv cvicon-cv-watch-later" data-toggle="tooltip" data-placement="top" title="Watch Later"></i></a>
                                 <a href="#"><i class="cv cvicon-cv-liked" data-toggle="tooltip" data-placement="top" title="Liked"></i></a>
                                 <a href="#"><i class="cv cvicon-cv-flag" data-toggle="tooltip" data-placement="top" title="Flag"></i></a>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <!-- BEGIN tabs-content -->
                        <div class="tabs-content">
                            <!-- BEGIN tab-1 -->
                            <div class="tab-1">
                                <div>
                                    <h4>{{ t('Category')}} :</h4>
                                    <a href="/categories/{{post.category.slug}}">{{ post.category.name }}</a>

                                    <h4>{{t('Content')}} :</h4>
                                    <p>{{ this.markdown.text(post.content) }}</p>

                                    <div class="row date-lic">
                                        <div class="col-lg-6">
                                            <h4>{{ t('Release Date')}}:</h4>
                                            <p>{{ post.getHumanCreatedAt() }}</p>
                                        </div>
                                        <div class="col-lg-6 ta-r">
                                            <h4>License:</h4>
                                            <p>Standard</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="subscribe">
                                    <form action="/subscribe/weekly" method="post">
                                        <div id="subscribe-text">
                                            <h4>Nhập địa chỉ email của bạn để đăng ký vào
                                                blog này và nhận được thông báo bài viết mới qua email.
                                            </h4>
                                        </div>
                                        <p id="subscribe-email">
                                            <input name="email" required="required" class="required" placeholder="Địa chỉ email" type="email">
                                        </p>
                                        <input value="Theo dõi" name="submit" class="btn" type="submit">
                                    </form>
                                </div>
                            </div>
                            <!-- END tab-1 -->

                            <!-- BEGIN tab-2 -->
                            <div class="tab-2">
                                <h4>{{t('Share')}}:</h4>
                                <div class="social">
                                    <a href="#" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    <a href="#" class="twitter"><i class="fa fa fa-twitter" aria-hidden="true"></i></a>
                                    <a href="#" class="google"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                                    <a href="#" class="pinterest"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                                    <a href="#" class="btc"><i class="fa fa-btc" aria-hidden="true"></i></a>
                                    <a href="#" class="tumblr"><i class="fa fa-tumblr" aria-hidden="true"></i></a>
                                    <a href="#" class="vk"><i class="fa fa-vk" aria-hidden="true"></i></a>
                                    <a href="#" class="reddit"><i class="fa fa-reddit" aria-hidden="true"></i></a>
                                    <a href="#" class="stumbleupon"><i class="fa fa-stumbleupon" aria-hidden="true"></i></a>
                                    <a href="#" class="odnoklassniki"><i class="fa fa-odnoklassniki" aria-hidden="true"></i></a>
                                    <a href="#" class="pinterest"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                                    <a href="#" class="btc"><i class="fa fa-btc" aria-hidden="true"></i></a>
                                    <a href="#" class="tumblr"><i class="fa fa-tumblr" aria-hidden="true"></i></a>
                                    <a href="#" class="vk"><i class="fa fa-vk" aria-hidden="true"></i></a>
                                    <a href="#" class="reddit"><i class="fa fa-reddit" aria-hidden="true"></i></a>
                                    <a href="#" class="stumbleupon"><i class="fa fa-stumbleupon" aria-hidden="true"></i></a>
                                    <a href="#" class="odnoklassniki"><i class="fa fa-odnoklassniki" aria-hidden="true"></i></a>
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <h4>{{t('Link')}}:</h4>
                                        <label class="clipboard">
                                            <input type="text" name="#" class="share-link" value="{{url}}" readonly>
                                            <div class="btn-copy" data-clipboard-target=".share-link">Copy</div>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <h4>Start at:</h4>
                                        <label class="checkbox">
                                            <input type="checkbox" name="#">
                                            <span class="arrow"></span>
                                        </label>
                                        <input type="text" name="#" value="3:20" readonly>
                                    </div>
                                    <div class="col-md-12">
                                        <h4>Embed:</h4>
                                        <textarea type="text" name="#" readonly><iframe width="560" height="315" src="{{url}}" frameborder="0" allowfullscreen></iframe></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <h4>Video Size:</h4>
                                        <div class="tags-type1">
                                            <a href="#">360P</a>
                                            <a href="#">480P</a>
                                            <a href="#">720P</a>
                                            <a href="#">1080P</a>
                                            <a href="#">Custom</a>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="checkbox-text">
                                            <label class="checkbox">
                                                <input type="checkbox" name="#">
                                                <span class="arrow"></span>
                                            </label>
                                            <p>Show suggested videos when the video finishes</p>
                                        </label>
                                        <label class="checkbox-text">
                                            <label class="checkbox">
                                                <input type="checkbox" name="#">
                                                <span class="arrow"></span>
                                            </label>
                                            <p>Show player controls</p>
                                        </label>
                                        <label class="checkbox-text">
                                            <label class="checkbox">
                                                <input type="checkbox" name="#">
                                                <span class="arrow"></span>
                                            </label>
                                            <p>Show video title and player actions</p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- END tab-2 -->

                            <!-- BEGIN tab-3 -->
                            <div class="tab-3">
                                <h4>Download:</h4>
                                <div class="tags-type2">
                                    <a href="#"><i class="fa fa-long-arrow-down" aria-hidden="true"></i>360P</a>
                                    <a href="#"><i class="fa fa-long-arrow-down" aria-hidden="true"></i>480P</a>
                                    <a href="#"><i class="fa fa-long-arrow-down" aria-hidden="true"></i>720P</a>
                                    <a href="#"><i class="fa fa-long-arrow-down" aria-hidden="true"></i>1080P</a>
                                    <a href="#"><i class="fa fa-long-arrow-down" aria-hidden="true"></i>UHD4K</a>
                                    <a href="#"><i class="fa fa-long-arrow-down" aria-hidden="true"></i>Mobile</a>
                                </div>
                                <label class="checkbox-text">
                                    <label class="checkbox">
                                        <input type="checkbox" name="#">
                                        <span class="arrow"></span>
                                    </label>
                                    <p>By Downloading this video I agree that I will not upload this video anywhere else without proper permission from the creator.</p>
                                </label>
                            </div>
                            <!-- END tab-3 -->

                            <!-- BEGIN tab-4 -->
                            <div class="tab-4">
                                <h4>Jump to:</h4>
                                <div class="block-list">
                                    <div>
                                        <span class="name">Introduction</span>
                                        <span class="time">0:00 - 2:16</span>
                                    </div>
                                    <div>
                                        <span class="name">Gameplay</span>
                                        <span class="time">2:17 - 3:19</span>
                                    </div>
                                    <div class="active">
                                        <span class="name">Cut Scene</span>
                                        <span class="time">3:20 - 8:33</span>
                                    </div>
                                    <div>
                                        <span class="name">Review</span>
                                        <span class="time">8:34 - 9:27</span>
                                    </div>
                                    <div>
                                        <span class="name">Overall Rating</span>
                                        <span class="time">9:28 - 11:06</span>
                                    </div>
                                </div>
                            </div>
                            <!-- END tab-4 -->

                            <!-- BEGIN tab-5 -->
                            <div class="tab-5">
                                <h4>Add to Playlist:</h4>
                                <div class="block-list">
                                    {% if playlist | length > 0%}{% for p in playlist %}
                                    <div class="active">
                                        <a href="/playlist/{{ p.slug }}">
                                            <i class="cv cvicon-cv-playlist" data-toggle="tooltip"
                                           data-placement="top" title="Playlist"></i>
                                        <span class="name">{{ p.title }}</span>
                                        </a>
                                        <i class="cv cvicon-cv-plus js-item-playlist"
                                           data-toggle="tooltip"
                                           data-post-id="{{id}}"
                                           data-playlist-id="{{p.id}}"
                                           data-placement="top" title="Add to Playlist"></i>
                                    </div>
                                    {% endfor %}{% endif %}
                                    <div class="add-playlist" data-toggle="modal"
                                         data-target="#modal-add-playlist">
                                        <i class="cv cvicon-cv-add-to-playlist" data-toggle="tooltip"
                                           data-placement="top" title="Add to Playlist"></i>
                                        <span class="name">Create New Playlist</span>

                                    </div>
                                </div>
                            </div>
                            <!-- END tab-5 -->
                        </div>
                        <!-- END tabs-content -->
                    </div>

                    {#<div class="adblock2">#}
                        {#<div class="imgv">#}
                            {#Google AdSense<br>#}
                            {#728 x 90#}
                        {#</div>#}
                    {#</div>#}

                    <!-- similar videos -->

                    <!-- END similar videos -->
                    {% if isAdmin() %}
                    <div>
                        <a href="/posts/edit/{{post.id}}">Edit post</a>
                    </div>
                    {% endif %}
                    <!-- comments -->
                    <div class="comments">
                        <div id="disqus_thread"></div>
                        <script>
                            var disqus_config = function () {
                                // The generated payload which authenticates users with Disqus
                                this.page.remote_auth_s3 = '{{ disqus['remoteAuthS3'] }}';
                                this.page.api_key = '{{ disqus['keyId'] }}';
                            };

                            (function() { // DON'T EDIT BELOW THIS LINE
                                var d = document, s = d.createElement('script');
                                s.src = '//{{ disqus['id'] }}.disqus.com/embed.js';
                                s.setAttribute('data-timestamp', +new Date());
                                (d.head || d.body).appendChild(s);
                            })();

                        </script>
                        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                    </div>
                    <!-- END comments -->
                </div>

        </div>

        <!-- right column -->
        <div class="col-lg-4 col-xs-12 col-sm-12">

            {% if listName is defined %}
                {{ partial('posts/view-playlist', ['listVideo' : listVideo, 'listName' : listName]) }}
            {% else %}
                {{ partial('posts/view-rightbar', ['nextVideo' : nextVideo]) }}
            {% endif %}

            {#<div class="adblock">#}
                {#<div class="img">#}
                    {#Google AdSense<br>#}
                    {#336 x 280#}
                {#</div>#}
            {#</div>#}
            <!-- load more -->
            <div class="loadmore">
                <a href="#">{{ t('Show more videos') }}</a>
            </div>
        </div>
    </div>

    {#Modal form created a playlist#}
    {{ partial('partials/modal-add-playlist') }}
{% endblock %}


{% block scripts%}

<script type="text/javascript">

    $('.js-comment').on('click', function (e) {
        e.preventDefault();
        var $that = $(this);
        $.ajax({
            type: "POST",
            url: baseUri + 'comment',
            dataType: 'html',
            data: {
                'id': $(this).data('objectId'),
                'content': $(this).prev().val(),
                'object' : $(this).data('object')
            },

            success: function (result) {
                if (isJson(result)) {
                    obj = $.parseJSON(result);
                    $that.prev().before('<div class="alert alert-danger">' + obj.error.message + '</div>');
                    setTimeout(removeAlert, 4000);
                } else {
                    if ('posts' == $that.data('object')) {
                        $('.comments-list .cl-header').after(result);
                    } else {
                        $that.parent().parent().parent().parent().parent().after(result)
                    }
                    $that.prev().val(null);
                }
            }
        });

    });

    $('.js-replies').on('click', function (e) {
        e.preventDefault();
        $(this).next().toggle();
    });

    //Vote
    $('body').on('click', '.voter', function (event) {
        event.preventDefault();
        currentElement = $(this);
        $.ajax({
            type: "POST",
            url: baseUri + controller + '/' + 'vote',
            dataType: 'json',
            data: {
                'way': $(this).data('way'),
                'objectId': $(this).data('objectId'),
                'object' : $(this).data('object')
            },
            success: function (data) {
                if (data.error) {
                    currentElement.before('<div class="alert alert-danger">' + data.error.message + '</div>');
                } else {
                    currentElement.children("span.positive").html(data['positive']);
                    currentElement.children("span.negative").html(data['negative']);
                }
            }
        });
    });

    var url = "{{post.getStreamUrl()}}";
    var title = "{{post.title}}";


    var player = jwplayer('my-video');

    player.setup({
      file: url,
      sharing: {
            link: url,
            heading: title
      }
    });
    jwplayer().on('levels', function() {
        var index = jwplayer().getQualityLevels();
        jwplayer().setCurrentQuality(index.lenght);
    });
    //Add
    $('.js-item-playlist').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url : '/playlist/save',
            dataType: 'json',
            data: {
                'postId': $(this).data('post-id'),
                'playlistId' : $(this).data('playlist-id')
            },
            success: function (data) {

                if (data.hasOwnProperty('error')) {
                    var $m = data.error.message,
                        $class = 'alert-danger';

                } else {

                    var $m = data.success.message,
                        $class = 'alert-success';
                }
                var $item = '<div class="alert ' + $class + '">';
                    $item = $item + '<span class="name">' + $m + '</span></div>';

                $('.add-playlist').after($item);
            }
        });

    });
</script>
{% endblock %}
