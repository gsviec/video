{% extends 'layouts/layout.volt' %}
{% block title %}{{ t('Dịch vụ') }}{% endblock %}
{% block content %}
    <div class="row">
        <div class="col-sm-3 col-md-2"></div>
        <div class="col-sm-10 col-md-8">
            <h3>Dịch vụ</h3>
            <p>Hiện tại gsviec cung cấp các dịch vụ dưới đây.</p>

            <h3>Nhận xây dựng website mới</h3>

            <p>
            Hiện tại chúng tôi chuyên về công nghệ PHP và GoLang, Microservice ngoài ra đội ngũ của chúng tôi chuyên về mobile app.
            </p>

            <h3>Tư vấn giải pháp công nghệ AWS</h3>
            <p>
                Nếu bạn cần tư vấn các giải pháp về nền tảng đám mây AWS và Google Cloud, đặt biệt là các công nghệ như Docker, Kubernetes, Scale Database thì hãy liên hệ với chúng tôi.
            </p>
            <h3> Xậy dựng ứng dụng IOT</h3>
            <p>Chuyên về các sản phẩm và giải pháp raspberry, arduino, công nghệ in 3D</p>

            <h3>Liên hệ </h3>
            <small>Bạn có thể gửi qua email của chúng tôi <a href="mail:hello@gsviec.com">hello@gsviec.com</a>, hoặc điền thông tin bên dưới.

            </small>

                    <p></p>
            <form id="contact-form" method="post" action="" role="form" novalidate="true">

                    <div class="messages"></div>

                    <div class="controls">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_name">Firstname *</label>
                                    <input id="form_name" type="text" name="name" placeholder="Please enter your firstname *" required="required">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_lastname">Lastname *</label>
                                    <input id="form_lastname" type="text" name="surname" placeholder="Please enter your lastname *" required="required">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_email">Email *</label>
                                    <input id="form_email" type="email" name="email" placeholder="Please enter your email *" required="required">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_need">Chọn yêu cầu *</label>
                                    <select id="form_need" name="need" class="form-control" required="required">
                                        <option value="Request quotation">Xây dựng website</option>
                                        <option value="Request order status">Tư vấn công nghệ</option>
                                        <option value="Request copy of an invoice">Xây dựng mobile</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_message">Message *</label>
                                    <textarea id="form_message" name="content" placeholder="Message for me *" rows="4" required="required" data-error="Please, leave us a message."></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-success btn-send" value="Send message">
                            </div>
                        </div>

                    </div>

            </form>
        </div>
    </div>
{% endblock %}

{% block scripts %}
<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/5693130.js"></script> <!-- End of HubSpot Embed Code -->

{% endblock %}


