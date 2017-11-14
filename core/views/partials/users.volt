<div class="question row">
    <div class="col-md-2">
        <a href="/@{{user.username}}" class="tooltip-n">
            {{ image(getUrlAvatar(user.email, '200'), false) }}
        </a>
    </div>
    <div class="col-md-7">
        <h2>
            <a href="/@{{user.username}}" class="tooltip-n">{{user.getFullname()}}</a>
        </h2>
        <div class="users-detail">
                <div class="user-bio">
                    {{truncate(user.bio, 300, '...')}}
                </div>
                <div class="user-tags">
                    <ul>
                        <li><a href="">Math</a></li>
                        <li><a href="">Physics</a></li>
                        <li><a href="">History</a></li>
                        <li><a href="">Technology</a></li>
                        <li><a href="">English</a></li>
                    </ul>
                </div>
        </div>

    </div>
    <div class="col-md-3">
        <div id="stars-existing" class="starrr" data-rating='4'></div>
        <span class="text-muted text-xs" translate="PB023">Hourly Rate</span>
        <span class="">100000</span>&nbsp;VND</strong>
        <div>
            <span class="question-date">
                <i class="fa fa-time"></i>{{user.getHumanCreatedAt()}}
            </span>
            <span class="question-comment">
                <a href="#"><i class="fa fa-comment"></i>20 {{t('Student')}}</a>
            </span>
            <span class="question-view"><i class="fa fa-heart"></i>{{user.getHumanKarma()}} Point</span>
        </div>
    </div>
</div>
