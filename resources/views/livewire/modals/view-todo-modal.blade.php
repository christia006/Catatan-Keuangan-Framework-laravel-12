<div wire:ignore.self class="modal fade" id="viewTodoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header">
                <h5 class="modal-title">Detail Catatan Keuangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">
                @if($transaction)
                    {{-- Tampilkan Gambar --}}
                    @if($transaction->image_url)
                        <div class="text-center mb-3">
                            <img src="{{ $transaction->image_url }}" 
                                 alt="Gambar Transaksi" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-height: 250px;">
                        </div>
                    @else
                        <p class="text-muted text-center">Tidak ada gambar untuk transaksi ini.</p>
                    @endif

                    {{-- Info Detail --}}
                    <h5>{{ $transaction->title }}</h5>
                    <p>{{ $transaction->description }}</p>
                    <p><strong>Jumlah:</strong> Rp {{ number_format($transaction->amount, 2, ',', '.') }}</p>
                    <p><strong>Tipe:</strong> {{ ucfirst($transaction->type) }}</p>
                    <p><strong>Tanggal:</strong> {{ $transaction->date->format('d M Y') }}</p>

                    {{-- Upload Gambar Baru --}}
                    <div class="mt-3">
                        <label for="newImage" class="form-label">Ganti Gambar</label>
                        <input type="file" wire:model="newImage" class="form-control">
                        @error('newImage') <span class="text-danger">{{ $message }}</span> @enderror
                        <button wire:click="updateImage" class="btn btn-primary mt-2">Perbarui Gambar</button>
                    </div>
                @else
                    <p class="text-center text-muted">Tidak ada data transaksi.</p>
                @endif
            </div>

        </div>
    </div>
</div>
