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


<!-- Piwik -->
<script type="text/javascript">
      jwplayer.key="ABCdeFG123456SeVenABCdeFG123456SeVen==";

  var _paq = _paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(["setDocumentTitle", document.domain + "/" + document.title]);
  _paq.push(["setCookieDomain", "*.gsviec.com"]);
  _paq.push(["setDomains", ["*.gsviec.com"]]);
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="https://piwik.gsviec.com/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '2']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="https://piwik.gsviec.com/piwik.php?idsite=2&rec=1" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->

{% block scripts%}{% endblock %}

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : facebookApp,
      cookie     : true,
      xfbml      : true,
      version    : 'v2.11'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
</body>
</html>
