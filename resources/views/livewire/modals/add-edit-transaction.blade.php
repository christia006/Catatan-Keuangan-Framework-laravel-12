{{-- resources/views/livewire/modals/add-edit-transaction.blade.php --}}

{{-- ADD TRANSACTION MODAL --}}
<form wire:submit.prevent="addTransaction">
    <div class="modal fade" tabindex="-1" id="addTodoModal" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control" wire:model="title">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" rows="3" wire:model="description"></textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jumlah (Rp)</label>
                            <input type="number" class="form-control" wire:model="amount" min="0">
                            @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tipe</label>
                            <select class="form-select" wire:model="type">
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                            </select>
                            @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" wire:model="date">
                            @error('date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Cover (opsional)</label>
                            <input type="file" class="form-control" wire:model="cover">
                            @error('cover') <span class="text-danger">{{ $message }}</span> @enderror
                            <div class="mt-2">
                                @if (isset($cover) && is_object($cover))
                                    <img src="{{ $cover->temporaryUrl() }}" alt="preview" class="img-fluid rounded" style="max-height:120px;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>


{{-- EDIT TRANSACTION MODAL --}}
<form wire:submit.prevent="updateTransaction">
    <div class="modal fade" tabindex="-1" id="editTransactionModal" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control" wire:model="editTitle">
                            @error('editTitle') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" rows="3" wire:model="editDescription"></textarea>
                            @error('editDescription') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jumlah (Rp)</label>
                            <input type="number" class="form-control" wire:model="editAmount" min="0">
                            @error('editAmount') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tipe</label>
                            <select class="form-select" wire:model="editType">
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                            </select>
                            @error('editType') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" wire:model="editDate">
                            @error('editDate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Cover (ganti)</label>
                            <input type="file" class="form-control" wire:model="editCover">
                            @error('editCover') <span class="text-danger">{{ $message }}</span> @enderror

                            <div class="mt-2 d-flex gap-2 align-items-center">
                                @if($editOldCoverPath)
                                    <div>
                                        <small class="text-muted d-block">Cover saat ini:</small>
                                        <img src="{{ asset('storage/' . $editOldCoverPath) }}" alt="cover" class="img-thumbnail" style="max-height:80px;">
                                    </div>
                                @endif

                                @if (isset($editCover) && is_object($editCover))
                                    <div>
                                        <small class="text-muted d-block">Preview baru:</small>
                                        <img src="{{ $editCover->temporaryUrl() }}" alt="preview" class="img-thumbnail" style="max-height:80px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Perbarui</button>
                </div>
            </div>
        </div>
    </div>
</form>
