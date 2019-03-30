{% extends 'mail/layoutEmail.volt' %}
{% block content %}
    Xin chào gsviec,

    <p>Bạn có một tin nhắn từ {{ name }} với địa chỉ email: {{ email }}</p>
    <p> {{ content }}</p>

{% endblock %}
