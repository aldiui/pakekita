<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Edit Data @yield('title')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateData" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" id="id">
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="image" class="form-label">Foto </label>
                        <input type="file" name="image" id="image" class="form-control">
                        <small class="invalid-feedback" id="errorimage"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama">
                        <small class="invalid-feedback" id="errornama"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_id" id="kategori_id" class="form-control editKategori"></select>
                        <small class="invalid-feedback" id="errorkategori_id"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="harga" name="harga">
                        <small class="invalid-feedback" id="errorharga"></small>
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
