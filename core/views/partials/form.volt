{% if form is defined %}
<div class="question question-type-normal">
    <div class="search">
        <form class="form-inline">
            <div class="form-group">
                <input type="text" class="form-control" id="title" name="title"
                placeholder="Keyword skill (Math, Physics...), Mon hoc, Company...">
            </div>
            <div class="form-group">
                {{ form.renderCity()}}
            </div>

            <div class="form-group">
               {{ form.renderCityandDistrict()}}
            </div>


            <button type="submit" class="btn btn-default">Search</button>
        </form>
    </div>

    <ul class="tabs">
        {% set menu = ['hot': 'Hot Jobs', 'week' : 'Week',
            'month' : 'Month', 'interesting': 'Interesting'
        ]%}
        {% for key, item in menu %}
            <li class="tab">
            {% if tab == key %}
                <a href="/posts?tab={{key}}" class="current">
            {% else %}
                <a href="/posts?tab={{key}}">
            {% endif %}
            {{ item }}
            </a></li>
        {% endfor %}
    </ul>
</div>

{% endif %}
