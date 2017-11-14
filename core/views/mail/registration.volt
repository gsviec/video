{% extends 'mail/layoutEmail.volt' %}
{% block content %}
    <p class="h5">Bên dưới là đường dẫn để đăng ký mật khẩu cho tài khoản của bạn.</p>
    <br />
    <p class="h5"><a href="{{ link }}">Nhấp vào đây để thiết lập mật khẩu của bạn.</a></p>
{% endblock %}
