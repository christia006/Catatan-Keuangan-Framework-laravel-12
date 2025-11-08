<form wire:submit.prevent="editTransaction" enctype="multipart/form-data">
    <div class="modal fade" id="editTodoModal" wire:ignore.self tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Catatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    
                    {{-- Judul --}}
                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text" class="form-control" wire:model.defer="editTitle">
                        @error('editTitle') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Cover --}}
                    <div class="mb-3">
                        <label>Cover</label>
                        <input type="file" class="form-control" wire:model="editCover">
                        
                        {{-- Blok Preview File BARU (Dilindungi dengan @isset) --}}
                        @isset($editCover)
                            @if ($editCover)
                                <img src="{{ $editCover->temporaryUrl() }}" width="100" class="mt-2 rounded">
                            @endif
                        @endisset

                        {{-- Blok Preview Cover LAMA (Hanya tampil jika TIDAK ADA file baru & file lama ADA) --}}
                        @empty($editCover)
                            @isset($editOldCover)
                                @if($editOldCover)
                                    <img src="{{ asset('storage/' . $editOldCover) }}" width="100" class="mt-2 rounded">
                                @endif
                            @endisset
                        @endempty
                    </div>
                    
                    {{-- Status/Tipe (Saya ganti model dari editTodoIsFinished ke editType sesuai Livewire Class) --}}
                    {{-- CATATAN: Karena ini adalah komponen 'Todo', saya ganti ke editTodoIsFinished, tetapi jika ini 'Transaction', gunakan editType --}}
                    <div class="mb-3">
                        <label>Status</label>
                        {{-- Catatan: Ganti wire:model ini sesuai properti yang benar. Saya asumsikan ini adalah 'editTodoIsFinished' --}}
                        <select class="form-select" wire:model="editTodoIsFinished"> 
                             <option value="1">Selesai</option>
                             <option value="0">Belum</option>
                        </select>
                    </div>
                    
                    {{-- Deskripsi --}}
                    <div class="mb-3" wire:ignore>
                        <label>Deskripsi</label>
                        <input id="editEditor" type="hidden" wire:model.lazy="editDescription">
                        <trix-editor input="editEditor"></trix-editor>
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

@push('scripts')
    <script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
@endpush