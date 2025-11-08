<?php

namespace App\Livewire\Modals;

use Livewire\Component;
use App\Models\Transaction;

class EditTodoModal extends Component
{
    public $transactionId;
    public $title;
    public $amount;
    public $type;
    public $date;

    #[\Livewire\Attributes\On('editTransaction')]
    public function editTransaction($id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            session()->flash('error', 'Transaksi tidak ditemukan.');
            return;
        }

        $this->transactionId = $transaction->id;
        $this->title = $transaction->title;
        $this->amount = $transaction->amount;
        $this->type = $transaction->type;
        $this->date = $transaction->date instanceof \Carbon\Carbon
            ? $transaction->date->format('Y-m-d')
            : $transaction->date;

        $this->dispatch('showEditModal');
    }

    public function updateTransaction()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
        ]);

        $transaction = Transaction::find($this->transactionId);
        if (!$transaction) {
            session()->flash('error', 'Transaksi tidak ditemukan.');
            return;
        }

        $transaction->title = $this->title;
        $transaction->amount = $this->amount;
        $transaction->type = $this->type;
        $transaction->date = $this->date;

        $transaction->save();

        $this->dispatch('closeEditModal');
        $this->dispatch('transactionUpdated');

        session()->flash('success', 'Transaksi berhasil diperbarui.');

        $this->reset(['title', 'amount', 'type', 'date', 'transactionId']);
    }

    public function render()
    {
        return view('livewire.modals.edit-todo-modal');
    }
}
