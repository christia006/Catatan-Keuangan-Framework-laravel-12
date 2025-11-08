<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionList extends Component
{
    use WithPagination;

    public $search = '';
    public $filterType = '';
    public $filterDate = '';
    public $selectedTransaction = null;
    public $perPage = 10; 

    // Listeners yang memicu refresh data
    protected $listeners = [
        'refreshTransactionList' => '$refresh',
        'transactionAdded' => 'refreshListAndResetPage',
        'transactionUpdated' => 'refreshListAndResetPage',
        'transactionDeleted' => 'refreshListAndResetPage',
    ];

    /**
     * Livewire Hooks: Dipanggil saat properti $search, $filterType, atau $filterDate diperbarui.
     * Fungsinya untuk mereset paginasi ke halaman 1 setiap kali filter berubah.
     */
    public function updated($propertyName)
    {
        // Pastikan paginasi direset saat salah satu filter utama berubah
        if (in_array($propertyName, ['search', 'filterType', 'filterDate', 'perPage'])) {
            $this->resetPage();
        }
    }
    
    // Method untuk me-refresh list dan mereset halaman
    public function refreshListAndResetPage()
    {
        $this->resetPage();
        $this->dispatch('$refresh');
    }

    // Reset semua filter
    public function resetFilters()
    {
        $this->search = '';
        $this->filterType = '';
        $this->filterDate = '';
        $this->resetPage();
    }

    // Method untuk membuka detail transaksi
    public function viewTransaction($id)
    {
        $trx = Transaction::where('id', $id)
             ->where('user_id', Auth::id())
             ->first();
        if ($trx) {
            $this->selectedTransaction = $trx;
            $this->dispatch('showTransactionModal');
        }
    }

    // Hapus transaksi
    public function deleteTransaction($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$transaction) {
            $this->dispatch('alertError', 'Transaksi tidak ditemukan.');
            return;
        }

        $transaction->delete();
        $this->dispatch('alertSuccess', 'Transaksi berhasil dihapus.');
        $this->refreshListAndResetPage(); 
    }

    /**
     * Logic untuk membuat data chart (Tren dan Distribusi)
     */
    protected function prepareChartData()
    {
        $userTransactions = Transaction::where('user_id', Auth::id())->orderBy('date', 'asc')->get();

        $totalIncome = $userTransactions->where('type', 'income')->sum('amount');
        $totalExpense = $userTransactions->where('type', 'expense')->sum('amount');
        
        $chartData = [
            'labels' => [],
            'incomeData' => [],
            'expenseData' => [],
        ];

        // Kelompokkan data per bulan selama 6 bulan terakhir
        $monthlyData = $userTransactions
            ->groupBy(function ($date) {
                return Carbon::parse($date->date)->format('Y-m'); // Grouping by Year-Month
            })
            ->map(function ($row) {
                return [
                    'income' => $row->where('type', 'income')->sum('amount'),
                    'expense' => $row->where('type', 'expense')->sum('amount'),
                    'month' => Carbon::parse($row->first()->date)->translatedFormat('M Y'), // Label bulan
                ];
            })
            ->take(6); // Ambil 6 bulan terakhir

        foreach ($monthlyData as $data) {
            $chartData['labels'][] = $data['month'];
            $chartData['incomeData'][] = $data['income'];
            $chartData['expenseData'][] = $data['expense'];
        }

        return compact('totalIncome', 'totalExpense', 'chartData');
    }

    public function render()
    {
        $query = Transaction::where('user_id', Auth::id());

        // Logika Filter/Search
        if ($this->search) {
            $query->where('title', 'like', "%{$this->search}%");
        }

        if ($this->filterType) {
            $query->where('type', $this->filterType);
        }

        if ($this->filterDate) {
            $query->whereDate('date', $this->filterDate);
        }

        $transactions = $query->orderBy('date', 'desc')->paginate($this->perPage);
        
        $chartData = $this->prepareChartData();

        return view('livewire.transaction-list', array_merge([
            'transactions' => $transactions,
        ], $chartData));
    }
}