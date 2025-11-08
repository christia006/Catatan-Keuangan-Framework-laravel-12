<div class="row mb-4 g-3">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-gradient" style="background: linear-gradient(45deg, #00b09b, #96c93d);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-white p-2 me-3">
                        <i class="fas fa-arrow-up text-success"></i>
                    </div>
                    <h5 class="card-title text-white mb-0">Total Pemasukan</h5>
                </div>
                <h3 class="mb-0 text-white">Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}</h3>
                <div class="mt-3 text-white-50">
                    <small>Periode: {{ now()->format('F Y') }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-gradient" style="background: linear-gradient(45deg, #FF416C, #FF4B2B);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-white p-2 me-3">
                        <i class="fas fa-arrow-down text-danger"></i>
                    </div>
                    <h5 class="card-title text-white mb-0">Total Pengeluaran</h5>
                </div>
                <h3 class="mb-0 text-white">Rp {{ number_format($totalExpense ?? 0, 0, ',', '.') }}</h3>
                <div class="mt-3 text-white-50">
                    <small>Periode: {{ now()->format('F Y') }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-gradient" style="background: linear-gradient(45deg, #2193b0, #6dd5ed);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-white p-2 me-3">
                        <i class="fas fa-wallet text-primary"></i>
                    </div>
                    <h5 class="card-title text-white mb-0">Saldo</h5>
                </div>
                <h3 class="mb-0 text-white">Rp {{ number_format(($totalIncome ?? 0) - ($totalExpense ?? 0), 0, ',', '.') }}</h3>
                <div class="mt-3 text-white-50">
                    <small>Update Terakhir: {{ now()->format('d M Y H:i') }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
