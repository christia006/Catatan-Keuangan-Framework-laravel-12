<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AddTodoModal extends Component
{
    use WithFileUploads;

    public $addTodoTitle = '';
    public $addTodoDescription = '';
    public $addTodoAmount = '';
    public $addTodoType = '';
    public $addTodoDate = '';
    public $addTodoCover = null; // Cover optional

    protected $rules = [
        'addTodoTitle' => 'required|string|max:255',
        'addTodoDescription' => 'nullable|string',
        'addTodoAmount' => 'required|numeric|min:0.01',
        'addTodoType' => 'required|in:income,expense',
        'addTodoDate' => 'required|date',
        'addTodoCover' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'addTodoTitle.required' => 'Judul harus diisi.',
        'addTodoAmount.required' => 'Jumlah harus diisi.',
        'addTodoType.required' => 'Tipe harus dipilih.',
        'addTodoDate.required' => 'Tanggal harus dipilih.',
    ];

    public function addTodo()
    {
        $this->validate();

        if (!Auth::check()) {
            $this->dispatch('alertError', 'Anda harus login terlebih dahulu.');
            return;
        }

        $coverPath = null;
        if ($this->addTodoCover) {
            $coverPath = $this->addTodoCover->store('transactions', 'public');
        }

        Transaction::create([
            'user_id' => Auth::id(),
            'title' => $this->addTodoTitle,
            'description' => $this->addTodoDescription,
            'amount' => $this->addTodoAmount,
            'type' => $this->addTodoType,
            'date' => $this->addTodoDate,
            'image' => $coverPath, // simpan cover jika ada
        ]);

        $this->resetForm();

        $this->dispatch('closeModal', ['id' => 'addTodoModal']);
        $this->dispatch('alertSuccess', 'Transaksi berhasil ditambahkan.');
        $this->dispatch('refreshTransactionList')->to('home-livewire');
    }

    public function resetForm()
    {
        $this->reset([
            'addTodoTitle',
            'addTodoDescription',
            'addTodoAmount',
            'addTodoType',
            'addTodoDate',
            'addTodoCover', // reset cover
        ]);
    }

    protected $listeners = ['resetAddTodoForm' => 'resetForm'];

    public function render()
    {
        return view('livewire.add-todo-modal');
    }
}
