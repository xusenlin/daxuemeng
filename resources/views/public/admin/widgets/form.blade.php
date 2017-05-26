<div class="modal modal-primary" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                @yield('modal_content')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-right" id="btn-submit" style="display: none">提交</button>
            </div>
        </div>
    </div>
</div>

