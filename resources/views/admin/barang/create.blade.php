<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data @yield('title')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="saveData" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="image" class="form-label">Foto </label>
                        <input type="file" name="image" id="image" class="dropify" data-height="200">
                        <small class="invalid-feedback" id="errorimage"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama">
                        <small class="invalid-feedback" id="errornama"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_id" id="kategori_id" class="single-select"></select>
                        <small class="invalid-feedback" id="errorkategori_id"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="unit_id" class="form-label">Unit <span class="text-danger">*</span></label>
                        <select name="unit_id" id="unit_id" class="single-select"></select>
                        <small class="invalid-feedback" id="errorunit_id"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="qty" class="form-label">Qty <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="qty" name="qty">
                        <small class="invalid-feedback" id="errorqty"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea type="text" class="form-control" id="deskripsi" name="deskripsi"></textarea>
                        <small class="invalid-feedback" id="errordeskripsi"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
