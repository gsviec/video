<div class="modal fade" id="modal-subscribe" tabindex="-1" role="dialog"
     aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="js-subscribe" action="#" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="lineModalLabel">{{ t('Đăng ký nhận bản tin mới nhất từ') }} {{ name}} </h3>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <label>{{ t('Name') }}</label>
                        <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <label>{{ t('Email') }}</label>
                        <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary js-hide-modal-subscribe" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">{{t('Subscribe')}}</button>
            </div>
        </div>
        </form>
    </div>
</div>
