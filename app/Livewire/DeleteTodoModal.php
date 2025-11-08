<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Storage;

class DeleteTodoModal extends Component
{
    public $deleteId;
    public $showModal = false;

    protected $listeners = [
        'prepareDelete' => 'loadDelete',
    ];

    public function loadDelete($id)
    {
        $this->deleteId = $id;
        $this->showModal = true;
    }

    public function deleteConfirmed()
    {
        $trx = Transaction::find($this->deleteId);
        if (!$trx) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Gagal!',
                'text' => 'Data tidak ditemukan.',
                'icon' => 'error'
            ]);
            $this->showModal = false;
            return;
        }

        // Hapus cover jika ada
        if ($trx->cover && Storage::disk('public')->exists($trx->cover)) {
            Storage::disk('public')->delete($trx->cover);
        }

        // Hapus data di database
        $trx->delete();

        // Refresh tabel
        $this->emitTo('transaction-list', '$refresh');

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil!',
            'text' => 'Data berhasil dihapus.',
            'icon' => 'success'
        ]);

        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.delete-todo-modal');
    }
}
