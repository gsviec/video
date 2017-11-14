{% extends 'layouts/layout.volt' %}
{% block title %}{{ page is defined ? page.getTitle() : name }}{% endblock %}
{% block content %}
    <div class="upload-page edit-page" id="upload">
        {{ partial('posts/item-detail') }}
    </div>
{% endblock %}
