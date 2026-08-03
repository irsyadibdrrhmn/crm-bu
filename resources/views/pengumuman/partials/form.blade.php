<form method="POST" action="{{ $action }}" class="panel max-w-3xl p-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="space-y-5">
        <div>
            <label for="judul" class="label-modern">Judul</label>
            <input id="judul" name="judul" value="{{ old('judul', $pengumuman?->judul) }}" class="input-modern" required>
            <x-input-error :messages="$errors->get('judul')" class="mt-2" />
        </div>

        <div>
            <label for="tanggal_publish" class="label-modern">Tanggal Publish</label>
            <input id="tanggal_publish" type="date" name="tanggal_publish" value="{{ old('tanggal_publish', $pengumuman?->tanggal_publish?->format('Y-m-d')) }}" class="input-modern" required>
            <x-input-error :messages="$errors->get('tanggal_publish')" class="mt-2" />
        </div>

        <div>
            <label for="konten" class="label-modern">Konten</label>
            <textarea id="konten" name="konten" rows="8" class="input-modern" required>{{ old('konten', $pengumuman?->konten) }}</textarea>
            <x-input-error :messages="$errors->get('konten')" class="mt-2" />
        </div>
    </div>

    <div class="mt-6 flex justify-end gap-3">
        <a href="{{ route('pengumuman.index') }}" class="btn-light">Batal</a>
        <button class="btn-primary">{{ $submit }}</button>
    </div>
</form>
