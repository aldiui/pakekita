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
                        <label for="barang_id" class="form-label">Barang <span class="text-danger">*</span></label>
                        <select name="barang_id" id="barang_id" class="form-control editBarang"></select>
                        <small class="invalid-feedback" id="errorbarang_id"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="qty" class="form-label">Qty <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="qty" name="qty">
                        <small class="invalid-feedback" id="errorqty"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
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
