@extends('layouts.pdf')

@section('title', 'Laporan Pendapatan ' . ($kategori ? $kategori->nama : '') . ' ' . $bulanTahun)

@push('style')
@endpush

@section('main')
    <div>
        <table width="100%" border="1" cellpadding="2.5" cellspacing="0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Tanggal</th>
                    <th>Pesanan</th>
                    <th>Menu</th>
                    <th>Kategori</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody valign="top">
                @foreach ($transaksis as $transaksi)
                    <tr>
                        <td align ="center">{{ $loop->iteration }}</td>
                        <td align ="center">{{ formatTanggal($transaksi->created_at) }}</td>
                        <td>{{ $transaksi->transaksi->pesanan }} </td>
                        <td>{{ $transaksi->menu->nama }}</td>
                        <td>{{ $transaksi->menu->kategori->nama }}</td>
                        <td align ="center">{{ $transaksi->qty }}</td>
                        <td>{{ formatRupiah($transaksi->total_harga) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" align="center">Total Pendapatan</td>
                    <td>{{ formatRupiah($transaksis->sum('total_harga')) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection

@push('scripts')
@endpush
