{% extends 'layouts/layout.volt' %}
{% block title %}{{ t('About') }}{% endblock %}
{% block content %}
    <div class="row">
        <div class="col-lg-12">
            <h3> Về chúng tôi</h3>
            <p> Gsviec.com được thành lập vào năm 2017, là một trong những website tiên phong trong việc giảng dạy
                và đào tạo trong lĩnh vực thiết kế và lập trình web miễn phí tại Việt Nam. </p>

            <h3>Mục tiêu hoạt động</h3>

            <p>Trước tiên, {{ name }}  hoạt động như một website cung cấp các kiến thức sử dụng mã nguồn mở
                Framework PHP cũng như các CMS  để tự làm website với nhiều nhu cầu khác nhau như webblog, tin tức,
                trang bán hàng, giới thiệu doanh nghiệp. Nếu bạn đang ở đây nhưng chưa hiểu PHP là gì
                thì hãy xem các video PHP của {{ name  }} để thấy tại sao sử dụng PHP.
            </p>

            <p>
            Ngoài PHP, {{ name }} cũng cung cấp các thông tin, các bài hướng dẫn liên quan đến lĩnh vực làm website như
                sử dụng máy chủ, giới thiệu các công cụ có ích, đánh giá dịch vụ host, SEO. Đặc biệt là các dịch vụ Devops như Docker,
                Amazon Web Service
            </p>
            <h3>Bình luận</h3>
            <p>
                {{ name }} cho phép các độc giả bình luận tự do như một diễn đàn nhỏ. Ở khu vực bình luận,
                độc giả có thể hỏi hoặc nêu ý kiến/cảm nghĩ về nội dung bài viết. Nhưng,
                để tránh gây phiền nhiễu và ảnh hưởng đến người khác, chúng tôi có quyền xóa
                các bình luận trên trường hợp bất khả kháng.
            </p>

            <h3>Liên hệ</h3>
            <p>Bạn có thể gửi qua email của chúng tôi <a href="mail:hello@gsviec.com">hello@gsviec.com</a>
            hoặc chat trực tiếp với chúng tôi bên góc trái màn hình có biểu tượng chat!!!
            </p>
        </div>
    </div>
{% endblock %}
