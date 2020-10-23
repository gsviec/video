{% extends 'layouts/layout.volt' %}
{% block title %}{{ t('About') }}{% endblock %}
{% block content %}
    <div class="row">
        <div class="col-sm-3 col-md-2"></div>
        <div class="col-sm-10 col-md-8">
            <h3>Hướng dẫn thanh toán khóa học </h3>
            <p>Để mua khoá học trên gsviec thì trước tiên bạn cần chọn khoá học cần mua,
            sau đó bạn chuyển tiền tới tài khoản bên dưới với nội dung như sau</p>

            <p class="mark">Tên của bạn không dấu  + Số điện thoại của bạn + mã code khoá học </p>

            <p> Ví dụ tên tôi là trần duy thiện, số điện thoại là 0388397026 và khoá học tôi
            muốn mua là https://gsviec.com/playlist/khoa-hoc-phalcon-102, thì cú pháp nó sẽ là:
                <mark>Thien 0388397026 phalcon102</mark>
            </p>

            <p>Chú ý để có thể biết được mã code khoá học, thì bạn hãy nhìn bên phía phải màn hình
            của khoá học bạn sẽ thấy nó.</p>

            <h3>Thông tin ngân hàng</h3>
            <p>Tên ngân hàng : <mark>Ngân hàng Á Châu (ACB)</mark></p>
            <p>Chi nhánh: <mark>Thủ Đức</mark></p>
            <p>Chủ tài khoản : <mark>TRẦN DUY THIỆN</mark></p>
            <p>Số tài khoản :  <mark>189312909</mark></p>
        </div>
    </div>
{% endblock %}

