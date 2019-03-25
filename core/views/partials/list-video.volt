<div class="row">
    {% for i, video in videos %}
    {% if i == 3 %}
        {% continue %}
    {% endif  %}
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
    <div class="col-lg-3 col-sm-6 videoitem">
        <div class="b-video">
            <div class="v-img">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-format="fluid"
                     data-ad-layout-key="-83+ex-1g-2r+as"
                     data-ad-client="ca-pub-6958863237897587"
                     data-ad-slot="6061213724"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <div class="vcontent">
                <div class="v-desc google-ads-text">
                <a href="#"> Supporter gsviec</a>
                </div>
            </div>
        </div>
    </div>
</div>
