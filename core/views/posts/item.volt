{% extends 'layouts/layout.volt' %}
{% block title %}{{ t('Upload') }}{% endblock %}
{% block content %}
<div class="upload-page edit-page" id="upload">
    <div class="row upload-detail" style="display: none">
        <div class="col-lg-12">
            <div class="u-details">
                <div class="row">
                    <div class="col-lg-12 ud-caption">Upload Details</div>
                    <div class="col-lg-2">
                        <img class="imgplace" src="/images/video-1.png">
                    </div>
                    <div class="col-lg-10">
                        <div class="u-title"></div>
                        <div class="u-size" id="filesize"></div>
                        <div class="u-progress">
                            <div class="progress" id="progress">
                                <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                    <span class="sr-only">0% Complete</span>
                                </div>
                            </div>
                            <div class="u-close">
                                <a href="#"><i class="cvicon-cv-cancel"></i></a>
                            </div>
                        </div>
                        <div class="u-desc">Your Video is still uploading, please keep this page open until it's done.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 upload-page">
            <form action="/posts/save" method="POST" enctype="multipart/form-data">

            <div class="u-area">
                <i class="cv cvicon-cv-upload-video"></i>

                <p class="u-text1">Select Video files to upload</p>
                <p class="u-text2">or drag and drop video files</p>
                <input type="file" name="files" id="fileupload" accept="video/mp4">
                <button class="btn btn-primary u-btn btn btn-more btn-upload" data-toggle="modal" data-target="#myModal" type="button">or Add link youtube</button>
            </div>
            </form>


            <div class="u-terms">
                <p>By submitting your videos to circle, you acknowledge that you agree to circle's <a href="#">Terms of Service</a> and <a href="#">Community Guidelines</a>.</p>
                <p>Please be sure not to violate others' copyright or privacy rights. Learn more</p>
            </div>
        </div>
    </div>
    <!-- End row -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            {{form('/posts/saveLink') }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="link" placeholder="Your link youtube" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary js-link-upload">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div><!--End Modal -->
</div><!-- End upload-->
{% endblock %}
{% block scripts%}
<script type="text/javascript">
    $(document).ready(function(){
        $('.js-link-upload').on('click', function (e) {
            var current = $(this);
            d(current);

        });

        $('#fileupload').fileupload({
            dataType: 'html',
            //maxChunkSize: 1000000, // 10 MB
            add: function (e, data) {
                if ($('.m-d-md div').hasClass('alert-danger')) {
                    $('.m-d-md div').remove();
                }
                $.each(data.files, function (index, file) {
                    filename = file.name;
                    filesize = bytesToSize(file.size);
                });
                data.submit();
                $('.u-title').text('Your filename is: ' + filename);
                $('#filesize').text('Your filesize is: ' + filesize);
                $('.upload-detail').show();

            },
            done: function (e, data) {
                result = data.result;
                if (isJson(result)) {
                    obj = $.parseJSON(result);
                    $('.upload-detail').hide();
                    $('.m-d-md').append('<div class="alert alert-danger">' + obj.error.message + '</div>');
                } else {
                    $('#upload').html(data.result);
                }
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        });
        // On file upload submit - assigning the file name value to the form data
        $('#fileupload').bind('fileuploadsubmit', function (e, data) {
            data.formData = {"filename" : filename, "filesize" : filesize};
        });
    });

</script>
{% endblock %}
