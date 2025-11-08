<div>
    <div class="modal fade" id="editTodoModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit.prevent="updateTransaction">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Judul</label>
                            <input type="text" class="form-control" wire:model.defer="title">
                            @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Jumlah (Rp)</label>
                            <input type="number" class="form-control" wire:model.defer="amount">
                            @error('amount') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Tipe</label>
                            <select class="form-select" wire:model.defer="type">
                                <option value="">Pilih tipe</option>
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                            </select>
                            @error('type') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" wire:model.defer="date">
                            @error('date') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Cover (opsional)</label>
                            <input type="file" class="form-control" wire:model="cover">
                            @error('cover') <span class="text-danger small">{{ $message }}</span> @enderror

                            @if ($coverPreview)
                                <img src="{{ $coverPreview }}" class="img-fluid mt-2" style="max-height: 120px;">
                            @elseif($currentCover)
                                <img src="{{ asset('storage/' . $currentCover) }}" class="img-fluid mt-2" style="max-height: 120px;">
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('editTodoModal');
    if (!modalEl) return;
    
    const bsModal = new bootstrap.Modal(modalEl);
    window.addEventListener('showEditModal', () => bsModal.show());
    window.addEventListener('closeEditModal', () => bsModal.hide());
});
</script>
@endpush
