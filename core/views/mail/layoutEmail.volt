<!DOCTYPE html>
<html lang="en" class="app">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body class="container">
        <section class="vbox">
            <section class="scrollable wrapper w-f">
                <section class="panel panel-default">
                    <section class="panel-body">
                    {% block content %}{% endblock %}
                    </section>
                    <section class="panel-footer">
                        <p>Thanks</p>
                        <p>&copy; {{name}} - {{ date('Y') }}</p>
                    {% if unLink is defined %}
                    <small><a href="{{ unLink }}"> Để hủy đăng ký ngay lập tức, hãy nhấn unsubscribe.</a></small>
                    {% endif %}
                    </section>
                </section>
            </section>
        </section>
    </body>
</html>
