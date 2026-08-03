@php
    $classes = [
        'pending' => 'badge-warning',
        'terkirim' => 'badge-warning',
        'diverifikasi' => 'badge-primary',
        'observasi' => 'badge-primary',
        'diterima' => 'badge-success',
        'ditolak' => 'badge-danger',
        'daftar_ulang' => 'badge-success',
    ][$status] ?? 'badge-primary';
@endphp

<span class="{{ $classes }}">{{ str_replace('_', ' ', ucfirst($status)) }}</span>
