@forelse ($menus as $menu)
    <div class="col-lg-3 col-6 col-md-3">
        <div class="card shadow-sm rounded-3">
            <div style="background-image: url('/storage/image/menu/{{ $menu->image }}');" class="bg-menu rounded-top-3">
            </div>
            <div class="card-body text-center">
                <p class="card-title fw-bold">{{ $menu->nama }}</p>
                <small class="d-block text-center small">{{ formatRupiah($menu->harga) }}</small>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="text-center my-5 py-5">
            <div class="mb-3">
                <i class="bi bi-x-octagon-fill fs-1 text-lg"></i>
            </div>
            <div class="fw-semibold">Menu Tidak Ditemukan</div>
        </div>
    </div>
@endforelse
<div class="col-12">
    <div class="d-flex justify-content-center">
        {!! $menus->links() !!}
    </div>
</div>
