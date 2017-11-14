<!-- up next -->
<div class="caption">
    <div class="left">
        <a href="#">Up Next</a>
    </div>
    <div class="right">
        <a href="#">Autoplay <i class="cv cvicon-cv-btn-off"></i></a>
    </div>
    <div class="clearfix"></div>
</div>
<!-- END up next -->
<div class="list">
    {% for video in nextVideo %}
        <div class="h-video row">
            <div class="col-lg-6 col-sm-6">
                <div class="v-img">
                    <a href="/watch?v={{video.getShortId()}}">
                        <img src="{{video.getThumbnail()}}" alt=""></a>
                    <div class="time">{{video.duration}}</div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="v-desc">
                    <a href="/watch?v={{video.getShortId()}}">{{video.title}}</a>
                </div>
                <div class="v-views">
                    {{video.getHumanNumberViews()}} views
                </div>
                <div class="v-percent"><span class="v-circle"></span> {{video.getHumanEditedAt()}}</div>
            </div>
            <div class="clearfix"></div>
        </div>
    {% endfor %}
</div>