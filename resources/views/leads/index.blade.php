<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">Acquire</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900">Leads Orang Tua</h1>
            </div>
            <a href="{{ route('leads.export') }}" class="btn-primary">Export CSV</a>
        </div>
    </x-slot>

    <div class="panel overflow-hidden">
        @if (session('success'))
            <div class="border-b border-emerald-100 bg-emerald-50 px-5 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Orang Tua</th>
                        <th>No HP</th>
                        <th>Anak</th>
                        <th>Sumber</th>
                        <th>Status Follow Up</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leads as $lead)
                        <tr>
                            <td class="font-semibold text-slate-900">{{ $lead->nama_orang_tua }}</td>
                            <td>{{ $lead->no_hp }}</td>
                            <td>{{ $lead->nama_anak ?? '-' }}</td>
                            <td>{{ $lead->sumber_informasi ?? '-' }}</td>
                            <td>
                                <form method="POST" action="{{ route('leads.update', $lead) }}" class="grid min-w-72 gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="input-modern !py-2">
                                        @foreach (['baru' => 'Baru', 'dihubungi' => 'Dihubungi', 'berminat' => 'Berminat', 'daftar' => 'Daftar', 'tidak_berminat' => 'Tidak Berminat'] as $value => $label)
                                            <option value="{{ $value }}" @selected($lead->status === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <textarea name="catatan" rows="2" class="input-modern !py-2" placeholder="Catatan follow up">{{ $lead->catatan }}</textarea>
                                    <button class="btn-primary !py-2">Update</button>
                                </form>
                            </td>
                            <td class="max-w-xs text-slate-600">{{ $lead->catatan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-slate-500">Belum ada leads.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-emerald-100 p-5">
            {{ $leads->links() }}
        </div>
    </div>
</x-app-layout>
