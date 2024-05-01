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

if (!function_exists('bulan')) {
    function bulan()
    {
        return [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];
    }
}

function buatBaris1Kolom($kolom1, $posisi = 'kiri')
{
    $lebar_kolom_1 = 35;

    $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);

    $kolom1Array = explode("\n", $kolom1);

    $jmlBarisTerbanyak = count($kolom1Array);

    $hasilBaris = array();

    for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {
        if ($posisi === 'tengah') {
            $panjangTeks = strlen($kolom1Array[$i]);
            $paddingKiri = floor(($lebar_kolom_1 - $panjangTeks) / 2);
            $paddingKanan = $lebar_kolom_1 - $panjangTeks - $paddingKiri;
            $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $paddingKiri + $panjangTeks, " ", STR_PAD_LEFT);
            $hasilKolom1 = str_pad($hasilKolom1, $paddingKanan + strlen($hasilKolom1), " ", STR_PAD_RIGHT);
        } elseif ($posisi === 'kanan') {
            $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ", STR_PAD_LEFT);
        } else {
            $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
        }
        $hasilBaris[] = $hasilKolom1;
    }

    return implode("\n", $hasilBaris) . "\n";
}

function buatBaris3Kolom($kolom1, $kolom2, $kolom3)
{
    $lebar_kolom_1 = 11;
    $lebar_kolom_2 = 11;
    $lebar_kolom_3 = 11;

    $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
    $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
    $kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);

    $kolom1Array = explode("\n", $kolom1);
    $kolom2Array = explode("\n", $kolom2);
    $kolom3Array = explode("\n", $kolom3);

    $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array));

    $hasilBaris = array();

    for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {
        $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
        $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ", STR_PAD_LEFT);
        $hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);
        $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3;
    }

    return implode("\n", $hasilBaris) . "\n";
}