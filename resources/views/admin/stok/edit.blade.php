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
                    <div class="form-group">
                        <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                        <small class="invalid-feedback" id="errortanggal"></small>
                    </div>
                    <div class="form-group">
                        <label for="jenis" class="form-label">Jenis <span class="text-danger">*</span></label>
                        <select name="jenis" id="jenis" class="form-control">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Masuk">Masuk</option>
                            <option value="Keluar">Keluar</option>
                        </select>
                        <small class="invalid-feedback" id="errorjenis"></small>
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
