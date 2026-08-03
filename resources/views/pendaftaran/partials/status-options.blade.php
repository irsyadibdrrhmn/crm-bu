@foreach ([
    'terkirim' => 'Terkirim',
    'diverifikasi' => 'Diverifikasi',
    'observasi' => 'Observasi',
    'diterima' => 'Diterima',
    'ditolak' => 'Ditolak',
    'daftar_ulang' => 'Daftar Ulang',
] as $value => $label)
    <option value="{{ $value }}" @selected(($selected ?? null) === $value)>{{ $label }}</option>
@endforeach
