<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="label-modal"></span> Data @yield('title')
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="saveData" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" id="id">
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
                        <label for="atas_nama" class="form-label">Atas Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="atas_nama" name="atas_nama">
                        <small class="invalid-feedback" id="erroratas_nama"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="jenis" class="form-label">Jenis <span class="text-danger">*</span></label>
                        <select name="jenis" id="jenis" class="form-control">
                            <option value="">Pilih Jenis</option>
                            <option value="Bank">Bank</option>
                            <option value="Qris">Qris</option>
                            <option value="E-Wallet">E-Wallet</option>
                        </select>
                        <small class="invalid-feedback" id="errorjenis"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="no_rekening" class="form-label">No Rekening <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="no_rekening" name="no_rekening">
                        <small class="invalid-feedback" id="errorno_rekening"></small>
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
