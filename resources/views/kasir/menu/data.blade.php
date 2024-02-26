@foreach ($menus as $menu)
    <div class="col-lg-3 col-6 col-md-3">
        <div class="card">
            <img src="/storage/image/menu/{{ $menu->image }}" class="card-img-top" alt="...">
            <div class="card-body text-center">
                <p class="card-title fw-bold">{{ $menu->nama }}</p>
                <small class="d-block text-center small">{{ formatRupiah($menu->harga) }}</small>
            </div>
        </div>
    </div>
@endforeach
<div class="col-12">
    <div class="d-flex justify-content-center">
        {!! $menus->links() !!}
    </div>
</div>
