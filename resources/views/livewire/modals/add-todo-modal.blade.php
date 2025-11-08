<form wire:submit.prevent="addTodo" enctype="multipart/form-data">
    <div class="modal fade" id="addTodoModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                {{-- HEADER --}}
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Catatan Keuangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                {{-- BODY --}}
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul</label>
                        <input type="text" class="form-control" wire:model.defer="addTodoTitle" placeholder="Masukkan judul...">
                        @error('addTodoTitle') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <input id="addTodoDescription" type="hidden" wire:model.defer="addTodoDescription">
                        <trix-editor input="addTodoDescription"></trix-editor>
                        @error('addTodoDescription') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah</label>
                        <input type="number" class="form-control" wire:model.defer="addTodoAmount" step="0.01">
                        @error('addTodoAmount') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tipe</label>
                        <div class="d-flex gap-4">
                            <label class="form-check-label">
                                <input type="radio" value="income" wire:model.defer="addTodoType"> 💰 Pemasukan
                            </label>
                            <label class="form-check-label">
                                <input type="radio" value="expense" wire:model.defer="addTodoType"> 💸 Pengeluaran
                            </label>
                        </div>
                        @error('addTodoType') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date" class="form-control" wire:model.defer="addTodoDate">
                        @error('addTodoDate') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    {{-- Upload Cover --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Cover (opsional)</label>
                        <input type="file" wire:model="addTodoCover" class="form-control">
                        @error('addTodoCover') <span class="text-danger small">{{ $message }}</span> @enderror

                        {{-- Preview --}}
                        @if ($addTodoCover)
                            <div class="mt-2 text-center">
                                <img src="{{ $addTodoCover->temporaryUrl() }}" alt="Preview Cover" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                            </div>
                        @endif
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading.remove wire:target="addTodo">Simpan</span>
                        <span wire:loading wire:target="addTodo">Menyimpan...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('livewire:load', () => {

    // 1. Reset form saat modal ditutup
    const modal = document.getElementById('addTodoModal');
    modal.addEventListener('hidden.bs.modal', () => {
        Livewire.emit('resetAddTodoForm');
    });

    // 2. Tutup modal otomatis saat event closeModal diterima
    Livewire.on('closeModal', data => {
        if(data.id) {
            const modalEl = document.getElementById(data.id);

            // Cek apakah instance Bootstrap sudah ada
            let modalInstance = bootstrap.Modal.getInstance(modalEl);
            if(!modalInstance){
                // jika belum, buat instance baru
                modalInstance = new bootstrap.Modal(modalEl);
            }

            // Tutup modal
            modalInstance.hide();
        }
    });
});
</script>

