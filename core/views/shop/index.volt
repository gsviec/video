{% extends 'layouts/layout.volt' %}
{% block title %}Shop{% endblock %}
{% block content %}
    <div class="row">
        <div class="col-lg-6">  
            <img class="img-responsive" src="https://gallery.mailchimp.com/52f6fb7c2a20733fa246f405b/images/38c9d452-1bcf-43f1-8f6d-a64b1647ef80.jpg" width="550">
        </div>

        <!-- right column -->
        <div class="col-lg-6">

            <h3></h3>            
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero velit id eaque ex quae laboriosam nulla optio doloribus! Perspiciatis, libero, neque, perferendis at nisi optio dolor!</p>
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

    var url   = "{{post.getStreamUrl()}}";
    var type  = "{{post.techOrder}}";
    var title = "{{post.title}}";

    if (type != 'youtube') {
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
    }
</script>
{% endblock %}
