<!-- up next -->
<div class="caption playlist">
    <div class="left">
        <a href="#">PLaylist: {{ listName }}</a>
    </div>
    <div class="right">
        <i class="cv cvicon-cv-liked" data-toggle="tooltip" data-placement="top" title="" data-original-title="Liked"></i>
        <i class="cv cvicon-cv-plus" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add to"></i>
    </div>
    <div class="clearfix"></div>
</div>
<!-- END up next -->
<div class="list">
    {% for i, video in listVideo %}
        <div class="h-video playlist row">
            <div class="col-lg-5 col-sm-5 col-xs-6">
                <div class="v-number">
                    {% if video.id == id %}
                        <span><i class="cv cvicon-cv-play"></i></span>
                    {% else %}
                        <span>{{ i + 1 }}</span>
                    {% endif %}
                </div>
                <div class="v-img">
                    <a href="/watch?v={{video.getShortId()}}&list={{listName}}">
                        <img src="{{video.getThumbnail()}}" alt=""></a>
                    <div class="time">{{video.duration}}</div>
                </div>
            </div>
            <div class="col-lg-7 col-sm-7 col-xs-6">
                <div class="v-desc">
                    <a href="/watch?v={{video.getShortId()}}&list={{listName}}">Part {{i+1}}: {{video.title}}</a>
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
