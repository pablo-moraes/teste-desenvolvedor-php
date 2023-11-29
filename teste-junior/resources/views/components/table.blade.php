<div class="table-responsive d-grid main-table">
    <div class="d-flex align-items-end justify-content-between me-1">
        <label class="d-inline-flex align-items-baseline gap-1">
            Show
            <select id="showEntriesBtn" name="" class="form-select custom-select-sm d-inline">
                <option value="20">20</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select> entries
        </label>
        <div class="d-flex flex-nowrap align-items-end gap-3">
            <div class="mt-3 d-none delete-container">
                <button class="btn btn-outline-danger fw-semibold">
                    Delete all selected
                    <i class="fa-solid fa-trash ms-2"></i>
                </button>
            </div>
            <div>
                <label for="searchBar">Search:</label>
                <input type="search" name="" id="searchBar" class="form-control">
            </div>
        </div>
    </div>
    <table
        {{ $attributes->merge(['id' => $id]) }} class="table table-bordered table-hover table-striped align-middle w-100 pt-3">
        <thead class="table-light">
        {{ $header }}
        </thead>
    </table>
</div>
