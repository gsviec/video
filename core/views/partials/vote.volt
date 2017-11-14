{% if vote is defined %}
    <a href="#" class="voter circle" title="Like" data-way="positive" data-object-id="{{objectId}}" data-object="{{ object }}">
        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i><span class="positive">{{ vote.getPositive() }}</span>
    </a>
    <a href="#" class="voter circle" title="Dislike" data-way="negative" data-object-id="{{objectId}}" data-object="{{ object }}">
        <i class="fa fa-thumbs-o-down" aria-hidden="true"></i><span class="negative">{{ vote.negative }}</span>
    </a>
{% endif %}
