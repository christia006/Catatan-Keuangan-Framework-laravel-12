<div>
    <div class="mt-3">
        <div class="card shadow-lg">
            <div class="card-body">

                {{-- HEADER --}}
                <div class="d-flex mb-3 align-items-center">
                    <h3 class="flex-fill">Daftar Catatan Keuangan</h3>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTodoModal">
                        Tambah Data
                    </button>
                </div>

                {{-- FILTER --}}
                <div class="row mb-3 g-2 align-items-end">
                    <div class="col-md-5">
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               class="form-control"
                               placeholder="Cari berdasarkan judul atau deskripsi...">
                    </div>
                    <div class="col-md-3">
                        <select wire:model.live="filterType" class="form-select">
                            <option value="">Semua Tipe</option>
                            <option value="income">Pemasukan</option>
                            <option value="expense">Pengeluaran</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" wire:model.live="filterDate" class="form-control">
                    </div>
                    <div class="col-md-1">
                        <select wire:model.live="perPage" class="form-select">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="button" wire:click="resetFilters" class="btn btn-secondary w-100 h-100">
                            <i class="fas fa-undo"></i>
                        </button>
                    </div>
                </div>

                {{-- STATISTIC & CHART --}}
                @include('components.cards.statistics')

                <div class="row mb-4 g-3">
                    <div class="col-md-8">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4" wire:ignore>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title mb-0">Tren Keuangan</h5>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-primary active" id="viewTrendLine"
                                            onclick="changeTrendChart('area')">
                                            <i class="fas fa-chart-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="viewTrendBar"
                                            onclick="changeTrendChart('bar')">
                                            <i class="fas fa-chart-bar"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="chartTrend" style="height: 340px; background: #fff;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4" wire:ignore>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title mb-0">Distribusi</h5>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="changeDistributionChart('donut'); return false;">Donut</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="changeDistributionChart('pie'); return false;">Pie</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="chartTransaction"
                                    data-income="{{ $totalIncome ?? 0 }}"
                                    data-expense="{{ $totalExpense ?? 0 }}"
                                    data-chart="{{ json_encode($chartData ?? []) }}"
                                    style="height: 340px; background: #fff;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABLE TANPA KOLOM GAMBAR --}}
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Tipe</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $key => $trx)
                                <tr>
                                    <td>{{ ($transactions->firstItem() ?? 0) + $key }}</td>
                                    <td>{{ $trx->title }}</td>
                                    <td>{{ date('d M Y', strtotime($trx->date)) }}</td>
                                    <td>Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($trx->type === 'income')
                                            <span class="badge bg-success">Pemasukan</span>
                                        @else
                                            <span class="badge bg-danger">Pengeluaran</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        <button wire:click="$dispatch('viewTransaction', [{{ $trx->id }}])"
                                            class="btn btn-sm btn-info text-white">
                                            <i class="fas fa-eye"></i> Lihat
                                        </button>

                                        <button wire:click="$dispatch('editTransaction', [{{ $trx->id }}])"
                                            class="btn btn-sm btn-warning text-white">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        <button wire:click="deleteTransaction({{ $trx->id }})"
                                            onclick="if(!confirm('Yakin ingin menghapus transaksi ini?')) { event.stopImmediatePropagation(); }"
                                            class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center py-4">Belum ada data transaksi</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $transactions->links() }}
                </div>

                {{-- MODALS --}}
                @livewire('add-todo-modal')
                @livewire('modals.edit-todo-modal')
                @livewire('modals.view-todo-modal')
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let trendChart = null;
let distributionChart = null;

function initCharts() {
    try {
        const trendEl = document.getElementById('chartTrend');
        const distEl = document.getElementById('chartTransaction');
        if (!trendEl || !distEl || typeof ApexCharts === 'undefined') return;

        const income = parseInt(distEl.dataset.income || 0);
        const expense = parseInt(distEl.dataset.expense || 0);
        const chartData = JSON.parse(distEl.dataset.chart || '{}');

        const trendOptions = {
            series: [
                { name: 'Pemasukan', data: chartData.incomeData || [] },
                { name: 'Pengeluaran', data: chartData.expenseData || [] }
            ],
            chart: {
                type: trendChart ? trendChart.opts.chart.type : 'area',
                height: 340,
                toolbar: { show: true },
                background: '#fff'
            },
            colors: ['#28a745', '#dc3545'],
            stroke: { curve: 'smooth', width: 2 },
            xaxis: { categories: chartData.labels || [] },
            yaxis: { labels: { formatter: v => 'Rp ' + v.toLocaleString('id-ID') } },
        };

        const distOptions = {
            series: [income, expense],
            chart: {
                type: distributionChart ? distributionChart.opts.chart.type : 'donut',
                height: 340
            },
            labels: ['Pemasukan', 'Pengeluaran'],
            colors: ['#28a745', '#dc3545'],
        };

        if (trendChart) trendChart.updateOptions(trendOptions);
        else { trendChart = new ApexCharts(trendEl, trendOptions); trendChart.render(); }

        if (distributionChart) distributionChart.updateOptions(distOptions);
        else { distributionChart = new ApexCharts(distEl, distOptions); distributionChart.render(); }

    } catch (err) {
        console.error('initCharts error:', err);
    }
}

function changeTrendChart(type) {
    if (!trendChart) return;
    trendChart.updateOptions({ chart: { type } });
    document.getElementById('viewTrendLine').classList.toggle('active', type === 'area');
    document.getElementById('viewTrendBar').classList.toggle('active', type === 'bar');
}

function changeDistributionChart(type) {
    if (!distributionChart) return;
    distributionChart.updateOptions({ chart: { type } });
}

if (typeof Livewire !== 'undefined') {
    Livewire.hook('morph.updated', () => setTimeout(initCharts, 200));
    Livewire.on('refreshTransactionList', () => setTimeout(initCharts, 200));
    Livewire.on('transactionAdded', () => setTimeout(initCharts, 200));
    Livewire.on('transactionUpdated', () => setTimeout(initCharts, 200));
    Livewire.on('transactionDeleted', () => setTimeout(initCharts, 200));
}

document.addEventListener('DOMContentLoaded', () => setTimeout(initCharts, 200));
</script>
@endpush
