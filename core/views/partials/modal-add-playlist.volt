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
