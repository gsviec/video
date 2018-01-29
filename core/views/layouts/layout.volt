<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add meta tags to refactor-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta property="og:site_name" content="{{ name }}" />
    <meta name="keywords" content="{{name}}, Video, Pets">
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="article" />
    {% if post is defined %}
    <meta property="og:title" content="{{ post.title}} - {{name}}" />
    <meta property="og:description" content="{{ truncate(post.content, 300) }}" />
    <meta property="description" content="{{ truncate(post.content, 300) }}" />
    <meta property="og:url" content="{{ url }}" />
    <meta property="article:author" content="{{author}}" />
    <meta property="article:tag" content="phalcon" />
    <meta property="article:tag" content="phalconphp" />
    <meta property="article:tag" content="php-can-ban" />
    <meta property="article:tag" content="startup" />
    <meta property="article:tag" content="docker" />
    <meta property="og:image" content="{{ post.getThumbnail() }}" />
    <meta property="og:image:width" content="736" />
    <meta property="og:image:height" content="552" />
    {% else %}
    <meta name="description" content="Gsviec.com được thành lập vào năm 2017, là một trong những website tiên phong trong việc giảng dạy và đào tạo trong lĩnh vực thiết kế và lập trình web miễn phí tại Việt Nam."/>
    <meta property="og:description" content="sviec.com được thành lập vào năm 2017, là một trong những website tiên phong trong việc giảng dạy và đào tạo trong lĩnh vực thiết kế và lập trình web miễn phí tại Việt Nam." />
    <meta name="author" content="{{name}} Team" />
    <meta property="og:title" content="{{ name }}">
    <link rel="canonical" href="{{ canonical }}" />
    <meta property="og:image" content="{{ canonical }}/images/landing.png" />
    {% endif %}
    <link rel="shortcut icon" href="/images/favicon.png">
    <title>{% block title%}{% endblock %} - {{name}}</title>

    {{ this.assets.outputCss() }}
    <script type="text/javascript">
        var baseUri     = '{{ baseUri }}';
        var controller  = '{{ controller }}';
        var action      = '{{ action }}';
        var gAnalytic   = '{{ gAnalytic }}';
        var facebookApp   = '{{ facebookApp }}';

    </script>
</head>

<body class="{{ class }} {{controller}} {{action}} light">

<!-- logo, menu, search, avatar -->
{{ partial('partials/header')}}
<!-- /logo -->

{{ partial('partials/goto')}}
<div class="m-d-md"> {{ this.flashSession.output()}}</div>
<div class="content-wrapper">
    <div class="container">
        {% block content%}{% endblock %}
    </div>
</div>

{{ partial('partials/footer')}}
<!-- Add a back to top-->
{#<div id="back_top" class="back-top pull-right"><span class="fa fa-4x fa-angle-up"></span></div>#}
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
{% if !isLogin() %}
{{partial('partials/modal-subscribe')}}
{% endif %}
{{this.assets.outputJs()}}

{% block scripts%}{% endblock %}

</body>
</html>
