{% for user in users %}
    {{ partial('partials/users', ['listUsers': true, 'user' : user])}}
{% endfor %}
