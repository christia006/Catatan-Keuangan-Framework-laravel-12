<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeLivewire extends Component
{
    use WithPagination;

    public $auth;
    public $search = '';
    public $filterType = '';
    public $filterDate = '';
    public $perPage = 10;
    public $selectedTransaction = null;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'refreshTransactions' => 'refreshListAndResetPage',
        'transactionAdded' => 'refreshListAndResetPage',
        'transactionUpdated' => 'refreshListAndResetPage',
        'transactionDeleted' => 'refreshListAndResetPage',
        'viewTransaction' => 'viewTransaction',
    ];

    public function mount()
    {
        $this->auth = Auth::user();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'filterType', 'filterDate', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function refreshListAndResetPage()
    {
        $this->resetPage();
        $this->dispatch('$refresh');
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterType = '';
        $this->filterDate = '';
        $this->resetPage();
    }

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

    public function deleteTransaction($id)
    {
        $trx = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$trx) {
            $this->dispatch('alertError', ['message' => 'Data tidak ditemukan!']);
            return;
        }

        // Hapus file gambar jika ada
        // Storage::delete($trx->image);

        $trx->delete();

        $this->dispatch('transactionDeleted');
        $this->dispatch('alertSuccess', ['message' => 'Transaksi berhasil dihapus!']);
    }

    private function getChartData()
    {
        $startDate = Carbon::now()->subMonths(5)->startOfMonth();

        $monthlyData = Transaction::where('user_id', $this->auth->id)
            ->where('date', '>=', $startDate)
            ->selectRaw("to_char(date, 'YYYY-MM') as month, type, SUM(amount) as total")
            ->groupBy('month', 'type')
            ->orderBy('month')
            ->get();

        $labels = [];
        $incomeData = [];
        $expenseData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            $labels[] = $date->format('M Y');

            $income = $monthlyData->where('type', 'income')->where('month', $monthKey)->first()->total ?? 0;
            $expense = $monthlyData->where('type', 'expense')->where('month', $monthKey)->first()->total ?? 0;

            $incomeData[] = (int) $income;
            $expenseData[] = (int) $expense;
        }

        return [
            'labels' => $labels,
            'incomeData' => $incomeData,
            'expenseData' => $expenseData,
        ];
    }

    public function render()
    {
        $query = Transaction::where('user_id', $this->auth->id);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterType) {
            $query->where('type', $this->filterType);
        }

        if ($this->filterDate) {
            $query->whereDate('date', $this->filterDate);
        }

        $transactions = $query->orderBy('date', 'desc')->paginate($this->perPage);
        $totalIncome = (clone $query)->where('type', 'income')->sum('amount');
        $totalExpense = (clone $query)->where('type', 'expense')->sum('amount');
        $chartData = $this->getChartData();

        return view('livewire.home-livewire', [
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'chartData' => $chartData,
        ]);
    }
}
