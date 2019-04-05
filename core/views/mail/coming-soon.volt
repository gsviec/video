{% extends 'mail/layoutEmail.volt' %}
{% block content %}
    Xin chào,
    <p>
        Cảm ơn bạn đã đăng ký dùng thử dịch vụ {{ domain }}. Chúng tôi sẽ thông báo cho bạn khi sản phẩm ra mắt.
    </p>
    <p> {{ describe }} </p>
    <strong>Để chắc chắn email của chúng tôi không bị báo là spam bạn hãy thêm vào contact trong email của bạn.</strong>
{% endblock %}

