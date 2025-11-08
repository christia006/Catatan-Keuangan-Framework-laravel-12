<form wire:submit.prevent="addTodo" enctype="multipart/form-data">
    <div class="modal fade" id="addTodoModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {{-- HEADER --}}
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Catatan Keuangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- BODY --}}
                <div class="modal-body">
                    {{-- JUDUL --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul</label>
                        <input type="text" class="form-control" wire:model.defer="addTodoTitle"
                               placeholder="Masukkan judul catatan...">
                        @error('addTodoTitle')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control" rows="4" wire:model.defer="addTodoDescription"
                                  placeholder="Tuliskan deskripsi pemasukan/pengeluaran..."></textarea>
                        @error('addTodoDescription')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- JUMLAH (DITAMBAHKAN) --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah</label>
                        <input type="number" step="0.01" class="form-control" wire:model.defer="addTodoAmount"
                               placeholder="Masukkan jumlah (contoh: 250000)">
                        @error('addTodoAmount')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- TIPE (Diubah menjadi Radio Button yang lebih menarik) --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold d-block">Tipe</label>
                        <div class="d-flex gap-4">
                            {{-- Radio Pemasukan --}}
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="addTodoTypeOptions" id="incomeRadioPlain"
                                    value="income" wire:model.defer="addTodoType">
                                <label class="form-check-label fw-medium" for="incomeRadioPlain">
                                    💰 Pemasukan
                                </label>
                            </div>
                            {{-- Radio Pengeluaran --}}
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="addTodoTypeOptions" id="expenseRadioPlain"
                                    value="expense" wire:model.defer="addTodoType">
                                <label class="form-check-label fw-medium" for="expenseRadioPlain">
                                    💸 Pengeluaran
                                </label>
                            </div>
                        </div>
                        @error('addTodoType')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- TANGGAL (DITAMBAHKAN) --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date" class="form-control" wire:model.defer="addTodoDate">
                        @error('addTodoDate')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- COVER --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload Cover</label>
                        <input type="file" class="form-control" wire:model="addTodoCover" accept="image/*">
                        @error('addTodoCover')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror

                        {{-- PREVIEW COVER --}}
                        @if ($addTodoCover)
                            <div class="mt-3">
                                <p class="mb-1 fw-semibold">Preview:</p>
                                <img src="{{ $addTodoCover->temporaryUrl() }}" class="rounded shadow-sm" width="120">
                            </div>
                        @endif

                        {{-- Loading Indicator --}}
                        <div wire:loading wire:target="addTodoCover" class="text-muted small mt-2">
                            Mengunggah gambar...
                        </div>
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