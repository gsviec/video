<!DOCTYPE html>
<html lang="en">
<head>
   <!-- Basic Page Needs -->
    {% set controller = this.view.getControllerName(), action =  this.view.getActionName()%}
    {% set name = this.config.application.name, publicUrl = this.config.application.publicUrl %}
    <!-- Add meta tags to refactor-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="{{name}}, Phanbook, Phalcon,QA">
    <meta name="author" content="Phanbook Team">
    <meta property="og:title" content="{{ name }}">
    <meta property="og:type"  content="website">
    <meta property="og:image" content=" {{ name }}">
    <meta property="og:url" content="{{publicUrl}}">
    <link rel="shortcut icon" href="{{ getImageSrc('favicon.png') }}">
    <title>{% block title%}{% endblock %} - {{name}}</title>

    {{ this.assets.outputCss() }}
    <script type="text/javascript">
        var baseUri     = '{{ this.config.application.baseUri }}';
        var controller  = '{{ controller }}';
        var action      = '{{ action }}';
        var googleAnalytic = 'xx';
    </script>
</head>

<body>


<!-- logo, menu, search, avatar -->
{{ partial('partials/header')}}
<!-- /logo -->


<div class="container-fluid bg-image">
    {% block content%}{% endblock %}
</div>

{{ partial('partials/footer')}}
<!-- Add a back to top-->
<div id="back_top" class="back-top"><span class="fa fa-4x fa-angle-up"></span></div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
{{this.assets.outputJs()}}

{% block scripts%}{% endblock %}

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1315048085240441',
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
