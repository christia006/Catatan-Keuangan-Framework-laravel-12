<?php

namespace App\Livewire\Modals;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ViewTodoModal extends Component
{
    use WithFileUploads;

    public $transaction;
    public $newImage; // ❌ sebelumnya tertulis "public $newIm age;" → ada spasi!

    protected $rules = [
        'newImage' => 'nullable|image|max:2048',
    ];

    protected $listeners = ['viewTransaction' => 'show'];

    public function show($id)
    {
        // Ambil data transaksi sesuai user
        $this->transaction = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$this->transaction) {
            $this->dispatch('alertError', 'Transaksi tidak ditemukan.');
            return;
        }

        // Tampilkan modal via JS
        $this->dispatch('show-view-modal');
    }

   public function updateImage()
{
    $this->validate();

    if (!$this->transaction || !Auth::check()) {
        $this->dispatch('alertError', 'Transaksi tidak valid atau Anda belum login.');
        return;
    }

    // Pastikan ada gambar yang diupload
    if (!$this->newImage) {
        $this->dispatch('alertError', 'Silakan pilih gambar terlebih dahulu sebelum memperbarui.');
        return;
    }

    // Hapus gambar lama jika ada
    if ($this->transaction->image) {
        Storage::disk('public')->delete($this->transaction->image);
    }

    // Simpan gambar baru
    $path = $this->newImage->store('transactions', 'public');
    $this->transaction->update(['image' => $path]);

    // Reset state
    $this->newImage = null;

    // Kirim notifikasi
    $this->dispatch('alertSuccess', 'Gambar berhasil diperbarui.');

    // 🔁 Refresh data agar gambar baru langsung tampil tanpa reload
    $this->transaction->refresh();
}


    public function render()
    {
        return view('livewire.modals.view-todo-modal');
    }
}
