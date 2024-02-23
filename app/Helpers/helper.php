<?php

use Carbon\Carbon;

if (!function_exists('formatTanggal')) {
    function formatTanggal($tanggal = null, $format = 'l, j F Y')
    {
        $parsedDate = Carbon::parse($tanggal)->locale('id')->settings(['formatFunction' => 'translatedFormat']);
        return $parsedDate->format($format);
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('statusBadge')) {
    function statusBadge($status)
    {
        $statusIcon = ($status == '0') ? '<i class="bi bi-clock me-1"></i>' : (($status == '1') ? '<i class="bi bi-check-circle me-1"></i>' : '<i class="bi bi-x-circle me-1"></i>');
        $statusClass = ($status == '0') ? 'bg-warning' : (($status == '1') ? 'bg-success' : 'bg-danger');
        $statusText = ($status == '0') ? 'Menunggu' : (($status == '1') ? 'Disetujui' : 'Ditolak');

        return "<span class='badge d-inline-flex align-items-baseline $statusClass'>$statusIcon $statusText</span>";
    }
}

if (!function_exists('jenisBadge')) {
    function jenisBadge($jenis)
    {
        $jenisIcon = ($jenis == 'Masuk') ? '<i class="bi bi-plus me-1"></i>' : '<i class="bi bi-dash me-1"></i>';
        $jenisClass = ($jenis == 'Masuk') ? 'bg-success' : 'bg-danger';

        return "<span class='badge d-inline-flex align-items-baseline $jenisClass'>$jenisIcon $jenis</span>";
    }
}