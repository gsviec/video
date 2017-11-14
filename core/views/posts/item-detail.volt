
<!--content body-->
{% if object is defined %}

    <div class="row">
        <div class="col-lg-12">
            <div class="u-details">
                <div class="row">
                    <div class="col-lg-12 ud-caption">Upload Details</div>
                    <div class="col-lg-2">
                        <img class="imgplace" src="{{object.getThumbnailUrl()}}">
                    </div>
                    <div class="col-lg-10">
                        <div class="u-title">{{object.title}}</div>
                        <div class="u-size">Your video will be live at: <a href="{{url}}" target="_blank"> {{url}}</a></div>
                        <div class="u-progress">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                    <span class="sr-only">100% Complete</span>
                                </div>
                            </div>
                            <!-- <div class="u-close">
                                <a href="#"><i class="cvicon-cv-cancel"></i></a>
                            </div> -->
                        </div>
                        <div class="u-desc">Your Video upload are success!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>



        <div class="row">
            <div class="col-lg-12 ">

            {{ form('posts/update')}}
                <div class="u-form">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="e1">Video Title</label>
                                {{ form.render('title')}}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="e2">About</label>
                                {{ form.render('content')}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="e3">Categories</label>
                                {{ form.render('categoryId')}}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="e4">Privacy Settings</label>
                                {{ form.render('status')}}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="e5">Monetize</label>
                                {{ form.render('monetize') }}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="e6">License</label>
                                <select class="form-control" id="e6">
                                    <option>Standard</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="e7">Tags (13 Tags Remaining)</label>
                                {{ form.render('tags')}}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="e8">Cast (Optional)</label>
                                <input type="text" class="form-control" id="e8" placeholder="Nathan Drake,">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="e9">Language in Video (Optional)</label>
                                <select class="form-control" id="e9">
                                    <option>English</option>
                                    <option>Vietnam</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="u-area">
                        <button class="btn btn-primary u-btn">Save</button>
                </div>
                <div class="u-terms">
                    <p>By submitting your videos to circle, you acknowledge that you agree to circle's <a href="#">Terms of Service</a> and <a href="#">Community Guidelines</a>.</p>
                    <p>Please be sure not to violate others' copyright or privacy rights. Learn more</p>
                </div>
            {{form.render('id')}}
            </form>
            </div>
        </div>


<!-- <div class="edit-upload">
    {{form('posts/update')}}
    <div class="upload-detail page-width">
        <h4>Upload Details</h4>
        <div class="show-video">
            <a href="">
            <img src="{{object.getThumbnail()}}">
            </a>
        </div>
        <div class="wait-upload">
            <h4>{{ object.title }}</h4>
            <p>Your video will be live at: <a href="{{url}}"> {{url}}</a></p>
            <div id="progress" class="progress">
                <div class="bar" style="width: 100%;"></div>
            </div>
            <p>Your Video upload are success!</p>
        </div>
    </div>
    <div style="clear: both" class="border-bottom"></div>
    <section class="page-width ctn-about">
        <div class="video-title">
            <div class="video-row1">
                <h4>Video Title</h4>
                {{ form.render('title')}}
            </div>
            <div class="video-row2">
                <h4 class="about-video">About</h4>
                {{ form.render('content')}}
            </div>
            <div class="video-row3">
                <div class="ctn-video">
                    <h4>Privacy Settings</h4>
                    {{ form.render('status')}}
                </div>
            </div>
            <div class="video-row4">
                <div class="ctn-tag1">
                    <h4>Categories</h4>
                    {{ form.render('categoryId')}}
                </div>
            </div>
            <div class="video-row2">
                <div class="ctn-tag1">
                    <h4>Tags</h4>
                    {{ form.render('tags')}}
                </div>
            </div>
            <div style="clear: both"></div>

            <div class="video-row6">
                <button class="btn btn-more btn-save" type="submit">Save</button>
            </div>
            <div class="stt-upload">
                <p>
                    By submitting your videos to circle, you acknowledge that you agree to circle's
                    <a href="">Terms of Service</a> and <a href="">Community Guidelines</a>.
                    Please be sure not to violate others' copyright or privacy rights. <a href="" style="color: #7e7e7e">Learn more</a>
                </p>
            </div>
        </div>
    </section>
    {{form.render('id')}}
    </form>
</div> -->
{% endif %}

