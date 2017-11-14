<div class="row">
    {% for video in videos %}
    <div class="col-lg-3 col-sm-6 videoitem">
        <div class="b-video" data-id="{{video.id}}">
            <div class="v-img">
                <a href="/watch?v={{video.getShortId()}}">
                    <img src="{{video.getThumbnailUrl()}}" height="169" width="270" alt="">
                </a>
                <div class="time">{{video.duration}}</div>
            </div>
            <div class="vcontent">
                <div class="v-desc">
                <a href="/watch?v={{video.getShortId() }}"> {{ truncate(video.title, 69) }}</a>
                </div>
                <div class="v-views">
                    {{video.getHumanNumberViews()}} views. <span class="v-percent"><span class="v-circle"></span> 78%</span>&nbsp;{{ video.getHumanCreatedAt()}}
                </div>
            </div>
        </div>
    </div>
    {% endfor %}
</div>
