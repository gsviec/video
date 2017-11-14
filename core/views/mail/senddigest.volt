{% extends 'mail/layoutEmail.volt' %}
{% block content %}
    Xin chào {{fullName}},

 <p>Trong video này chúng tôi sẽ hướng dẫn bạn cách cấu hình Route 53 trên godady.com cũng như giới thiệu sơ qua trang quản trị Route 53</p>

 <p>Tại sao nên dùng Route 53</p>

<ul>
<li>
<p>Chi phí cực kỳ rẻ: $0.400 per million queries – first 1 Billion queries / month</p>
</li>
<li>
<p>Cung cấp healthy để kiểm tra service của bạn còn hoạt động hay không rất là tiện lợi cho việc cấu hình load balancer(Healthy and Weighted Routing Policy)</p>
</li>
<li>
<p>Cung cấp các policy(chính sách) điều hướng lượng trafic đến các service của bạn</p>
</li>
<li>
<p>Sự phản hồi cực kỳ nhanh chóng(Latency based Routing Policy)</p>
</li>
</ul>
<p>Để xem chi tiết các bạn có thể xem qua link sau <a href="https://gsviec.com/watch?v=wkx">https://gsviec.com/watch?v=wkx</a></p>

<strong>Để chắc chắn email của chúng tôi không bị báo là spam bạn hãy thêm vào contact trong email của bạn.</strong>
{% endblock %}
