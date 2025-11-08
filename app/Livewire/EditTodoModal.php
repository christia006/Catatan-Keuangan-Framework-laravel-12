<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Transaction;
use Illuminate\Support\Facades\Storage;

class EditTodoModal extends Component
{
    use WithFileUploads;

    public $editId;
    public $editTodoTitle = '';
    public $editTodoDescription = '';
    public $editTodoCover = null;
    public $editTodoAmount = '';
    public $editTodoType = '';
    public $editTodoDate = '';
    public $oldCover;

    protected $rules = [
        'editTodoTitle' => 'required|string|max:255',
        'editTodoDescription' => 'nullable|string',
        'editTodoAmount' => 'required|numeric|min:0.01',
        'editTodoType' => 'required|in:income,expense',
        'editTodoDate' => 'required|date',
        'editTodoCover' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'editTodoTitle.required' => 'Judul harus diisi.',
        'editTodoAmount.required' => 'Jumlah harus diisi.',
        'editTodoAmount.numeric' => 'Jumlah harus berupa angka.',
        'editTodoAmount.min' => 'Jumlah minimal 0.01.',
        'editTodoType.required' => 'Tipe harus dipilih.',
        'editTodoType.in' => 'Tipe tidak valid.',
        'editTodoDate.required' => 'Tanggal harus diisi.',
        'editTodoCover.image' => 'File harus berupa gambar.',
        'editTodoCover.max' => 'Ukuran maksimal 2MB.',
    ];

    protected $listeners = [
        'prepareEditTransaction' => 'loadTransaction',
    ];

    /** 
     * 🔹 Ambil data dari database lalu isi form edit
     */
    public function loadTransaction($id)
    {
        $trx = Transaction::find($id);

        if (!$trx) {
            $this->dispatch('alertError', 'Data tidak ditemukan.');
            return;
        }

        $this->editId = $trx->id;
        $this->editTodoTitle = $trx->title;
        $this->editTodoDescription = $trx->description;
        $this->editTodoAmount = $trx->amount;
        $this->editTodoType = $trx->type;
        $this->editTodoDate = $trx->date;
        $this->oldCover = $trx->cover;

        $this->dispatch('showEditModal');
    }

    /** 
     * 🔹 Proses update data
     */
    public function updateTodo()
    {
        $this->validate();

        $trx = Transaction::find($this->editId);

        if (!$trx) {
            $this->dispatch('alertError', 'Data tidak ditemukan.');
            return;
        }

        // Jika upload cover baru
        if ($this->editTodoCover) {
            if ($trx->cover && Storage::exists('public/' . $trx->cover)) {
                Storage::delete('public/' . $trx->cover);
            }
            $path = $this->editTodoCover->store('covers', 'public');
            $trx->cover = $path;
        }

        $trx->update([
            'title' => $this->editTodoTitle,
            'description' => $this->editTodoDescription,
            'amount' => $this->editTodoAmount,
            'type' => $this->editTodoType,
            'date' => $this->editTodoDate,
            'cover' => $trx->cover,
        ]);

        $this->dispatch('closeModal', ['id' => 'editTodoModal']);
        $this->dispatch('alertSuccess', 'Data berhasil diperbarui.');
        $this->dispatch('refreshTransactionList')->to('home-livewire');
    }

    public function render()
    {
        return view('livewire.edit-todo-modal');
    }
}
