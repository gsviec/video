<div class="modal fade" id="modal-add-playlist" tabindex="-1" role="dialog"
     aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="playlist" action="/playlist/new" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="lineModalLabel">{{ t('Create New Playlist') }}</h3>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <label>{{ t('Name') }}</label>
                        <input type="text" class="form-control" name="title" placeholder="ex. Best profile screens">
                    </div>
                    <div class="form-group">
                        <label>{{ t('Description') }}</label>
                        <textarea name="content"  class="form-control empty" placeholder="ex. &quot;Android cooking apps&quot;"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                    </div>

                    <div class="btn-group" role="group">
                        <button type="submit" id="js-display-playlist" class="btn btn-success">Create Playlist</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
{#<div class="modal fade" id="modal-add-playlist" tabindex="-1" role="dialog"#}
     {#aria-labelledby="modalLabel" aria-hidden="true">#}
    {#<div class="modal-dialog">#}
        {#<div class="modal-content">#}
            {#<div class="modal-header">#}
                {#<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>#}
                {#<h3 class="modal-title" id="lineModalLabel">Save to your Collection</h3>#}
            {#</div>#}
            {#<div class="modal-body">#}
                {#{% if playlist | length >0 %}#}
                    {#<form id="playlist-add-item">#}
                        {#{% for p in playlist %}#}
                            {#<div class="block-list">#}
                                {#<div>#}
                                    {#<span>{{ p.title }}</span>#}
                                    {#<span class="pull-right">{{ t('SAVE') }}</span>#}
                                {#</div>#}
                            {#</div>#}
                        {#{% endfor %}#}
                    {#</form>#}
                {#{% endif %}#}
                {#<form id="playlist" action="/" method="POST" style="display: none">#}
                    {#<div class="form-group">#}
                        {#<label>{{ t('Name') }}</label>#}
                        {#<input type="text" class="form-control" name="title" placeholder="ex. Best profile screens">#}
                    {#</div>#}
                    {#<div class="form-group">#}
                        {#<label>{{ t('Description') }}</label>#}
                        {#<textarea name="content"  class="form-control empty" placeholder="ex. &quot;Android cooking apps&quot;"></textarea>#}
                    {#</div>#}
                    {#<button type="submit" class="btn btn-success js-create-playlist">{{ t('Create') }}</button>#}
                {#</form>#}
            {#</div>#}
            {#<div class="modal-footer">#}
                {#<div class="btn-group btn-group-justified" role="group" aria-label="group button">#}
                    {#<div class="btn-group" role="group">#}
                        {#<button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>#}
                    {#</div>#}

                    {#<div class="btn-group" role="group">#}
                        {#<button type="button" id="js-display-playlist" class="btn btn-success">Create Playlist</button>#}
                    {#</div>#}
                {#</div>#}
            {#</div>#}
        {#</div>#}
    {#</div>#}
{#</div>#}

{#<script>#}
    {#$(document).ready(function(){#}
        {#//Add new playlist#}
        {#$('#playlist').on('submit', function (e) {#}
            {#e.preventDefault();#}
            {#var current = $(this);#}
            {#$.ajax({#}
                {#'type' : 'POST',#}
                {#'url'  : '/playlist/new',#}
                {#'data' : $(this).serialize(),#}
                {#success: function (data) {#}
                    {#d(data);#}
                {#}#}
            {#});#}
        {#});#}
        {#//#}
        {#$('#js-display-playlist').on('click', function () {#}
            {#$('#playlist').toggle();#}
            {#$('#playlist-add-item').toggle();#}
        {#});#}
        {#//Add item to playlist#}

    {#});#}
{#</script>#}
