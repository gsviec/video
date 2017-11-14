{% extends 'mail/layoutEmail.volt' %}
{% block content %}
    Xin chào {{fullName}},

    <p class="h5">Cảm ơn bạn đã đăng ký nhận bản tin trên {{ name }} ({{ link }})</p>
    <p>
    Từ giờ trở đi, {{name}} sẽ thỉnh thoảng gửi email thông báo những bài viết và video cho bạn. Nhớ check mail thường xuyên để không bỏ lỡ bất kỳ bài viết và video nào nhé.
    </p>
    <strong>Để chắc chắn email của chúng tôi không bị báo là spam bạn hãy thêm vào contact trong email của bạn.</strong>
{% endblock %}
