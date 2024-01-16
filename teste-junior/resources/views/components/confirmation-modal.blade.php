<div class="modal fade" id="{{ $id . 'Modal' }}" aria-labelledby="{{ $id . 'ModalLabel' }}" tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id . 'ModalLabel' }}"> {{ $title }}
                    @if(isset($showCount) && $showCount)
                        <em class="text-secondary fs-6">
                            (<span class="rows-count"></span> rows)
                        </em>
                    @endif
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if(isset($text))
                    {{ $text }}
                @else
                    <p>Are you sure you want to delete the selected rows??</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCloseModal">Close
                </button>

                {{ $button }}
            </div>
        </div>
    </div>
</div>
