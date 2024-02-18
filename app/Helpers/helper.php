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
