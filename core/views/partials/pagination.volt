{% if totalPages > 1 %}
    {% set startIndex = 1 %} <!-- start index 1..5 -->
    {% if totalPages > 5 %}
        {% if currentPage > 3 %}
            {% set startIndex = startIndex + currentPage - 3 %}
        {% endif %}
        {% if totalPages - currentPage < 5 %}
            {% set startIndex = totalPages - 4 %}
        {% endif %}
    {% endif %}
    <ul class="list-inline">
        {% if currentPage > 1 %}
            <li><a href="/{{ currentUri }}page={{ currentPage - 1 }}"><div class="pages"><i class="cv cvicon-cv-previous"></i></div></a></li>
        {% endif %}

        {% for pageIndex in startIndex..totalPages %}
            {% if pageIndex is startIndex + 5 %}
                {% break %}
            {% endif %}
            {% if pageIndex is currentPage %}
                <li><a href="/{{ currentUri }}page={{currentPage}}">
                        <div class="pages active">{{ currentPage }}</div>
                    </a>
                </li>
            {% else %}
                <li><a href="/{{ currentUri }}page={{pageIndex}}">
                        <div class="pages">{{ pageIndex }}</div>
                    </a>
                </li>
            {% endif %}

        {% endfor %}
        {% if currentPage < totalPages %}
            <li><a href="/{{ currentUri }}page={{ currentPage + 1 }}">
                    <div class="pages"><i class="cv cvicon-cv-next"></i></div>
                </a></li>
        {% endif %}
    </ul>
{% endif %}
