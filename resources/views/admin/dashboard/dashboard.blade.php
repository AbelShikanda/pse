@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid" style="padding:1.25rem 1.35rem">
        {{-- Header row --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
            <div>
                <span class="admin-section-title">Dashboard</span>
                <h2 style="font-size:1.35rem; margin:.25rem 0 0">Karibu, <span style="color:var(--brand-2)">{{ Auth::guard('admin')->user()->name }}</span> 👋</h2>
            </div>
            <a href="{{ url('/') }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary"><i class="fe fe-external-link fe-14"></i> View storefront</a>
        </div>

        @if (Session('success'))
            <div class="alert alert-success">{{ Session('success') }}</div>
        @endif

        {{-- KPI cards --}}
        <div class="row">
            @foreach ([
                ['label' => 'Page views', 'value' => $thisWeekViews, 'delta' => $percentageViewChange, 'icon' => 'fe-eye'],
                ['label' => 'Conversions', 'value' => $thisWeekConversions, 'delta' => $percentageConversionChange, 'icon' => 'fe-shopping-bag'],
                ['label' => 'Visitors', 'value' => $thisWeekVisitorsCount, 'delta' => $percentageVisitorChange, 'icon' => 'fe-users'],
            ] as $kpi)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body" style="display:flex; align-items:center; gap:1rem">
                            <div style="width:52px;height:52px;border-radius:var(--r-md);background:var(--brand-tint-strong);display:flex;align-items:center;justify-content:center">
                                <i class="fe {{ $kpi['icon'] }}" style="font-size:1.4rem; color:var(--brand-2)"></i>
                            </div>
                            <div style="flex:1">
                                <small class="text-muted" style="letter-spacing:.12em; text-transform:uppercase; font-size:.68rem">{{ $kpi['label'] }}</small>
                                <p style="font-size:1.5rem; font-weight:800; margin:.1rem 0 0; color:var(--text)">{{ number_format($kpi['value']) }}</p>
                                <small class="{{ $kpi['delta'] < 0 ? 'text-danger' : 'text-success' }}" style="font-size:.75rem">
                                    <i class="fe fe-arrow-{{ $kpi['delta'] < 0 ? 'down' : 'up' }} fe-12"></i> {{ number_format(abs($kpi['delta']), 2) }}% vs last week
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Trend chart --}}
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <strong>7-day performance</strong>
                <span class="text-muted small">Page views · visitors · orders</span>
            </div>
            <div class="card-body" style="height:320px">
                <canvas id="lineChart" height="300" aria-label="Page views, visitors and orders over the last 7 days"></canvas>
            </div>
        </div>

        <div class="row">
            {{-- Top selling --}}
            <div class="col-lg-7">
                <div class="card mb-3">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <strong>Top selling</strong>
                        <a href="{{ route('products.index') }}" class="small text-muted">All products →</a>
                    </div>
                    <div class="card-body" style="padding:.5rem 1rem">
                        @forelse ($topSellingProducts as $product)
                            <div style="display:flex; align-items:center; gap:.8rem; padding:.65rem 0; border-bottom:1px solid var(--border)">
                                <img src="{{ $product->productImage->first() ? asset('storage/img/products/' . $product->productImage->first()->thumbnail) : asset('assets/img/logo.png') }}" alt="{{ $product->name }}" style="width:52px;height:64px;object-fit:cover;border-radius:var(--r-sm);background:var(--bg-3)">
                                <div style="flex:1; min-width:0">
                                    <strong style="color:var(--text); display:block">{{ $product->name }}</strong>
                                    <small class="text-muted" style="font-size:.72rem">{{ Str::limit($product->meta_keywords, 60) }}</small>
                                    <div class="progress mt-1" style="height:4px; background:var(--bg-0)">
                                        <div class="progress-bar" role="progressbar" style="width:{{ number_format($product->percentage_sold, 1) }}%; background:var(--brand)" aria-valuenow="{{ $product->percentage_sold }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <span style="font-weight:800; color:var(--brand-2); min-width:52px; text-align:right">{{ number_format($product->percentage_sold, 1) }}%</span>
                            </div>
                        @empty
                            <p class="text-muted" style="padding:.8rem 0">No sales recorded yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Right column --}}
            <div class="col-lg-5">
                {{-- Traffic --}}
                <div class="card mb-3">
                    <div class="card-header"><strong>Traffic sources</strong></div>
                    <div class="card-body" style="padding:.6rem 1rem">
                        @php $totalTraffic = array_sum($conversionBreakdown) ?: 1; @endphp
                        @foreach ($conversionBreakdown as $medium => $count)
                            <div class="d-flex align-items-center justify-content-between" style="padding:.4rem 0; border-bottom:1px solid var(--border)">
                                <span style="text-transform:capitalize; color:var(--text-2)">{{ $medium }}</span>
                                <span style="color:var(--text)"><strong>{{ $count }}</strong> <small class="text-muted">({{ number_format($count / $totalTraffic * 100, 1) }}%)</small></span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Browsers --}}
                <div class="card mb-3">
                    <div class="card-header"><strong>Browsers</strong></div>
                    <div class="card-body" style="padding:.6rem 1rem">
                        @forelse ($browsers as $browser)
                            <div class="d-flex align-items-center justify-content-between" style="padding:.35rem 0; border-bottom:1px solid var(--border)">
                                <span class="text-muted" style="font-size:.82rem">{{ Str::limit($browser->user_agent, 42) }}</span>
                                <span><strong style="color:var(--text)">{{ $browser->count }}</strong> <small class="text-muted">{{ number_format((float) $browser->percentage, 1) }}%</small></span>
                            </div>
                        @empty
                            <p class="text-muted" style="padding:.6rem 0">No browser data yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Region sales --}}
                <div class="card mb-3">
                    <div class="card-header"><strong>Region sales</strong></div>
                    <div class="card-body" style="padding:.6rem 1rem">
                        @forelse ($regionData as $region)
                            <div class="d-flex align-items-center justify-content-between" style="padding:.35rem 0; border-bottom:1px solid var(--border)">
                                <span style="color:var(--text-2)">{{ $region->town }}</span>
                                <span style="color:var(--text)"><strong>{{ $region->total_sales }}</strong> <small class="text-muted">({{ number_format((float) $region->sales_percentage, 1) }}%)</small></span>
                            </div>
                        @empty
                            <p class="text-muted" style="padding:.6rem 0">No regional sales yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var labels = [];
            for (var i = 6; i >= 0; i--) {
                var d = new Date();
                d.setDate(d.getDate() - i);
                labels.push(d.toLocaleDateString(undefined, { weekday: 'short', day: 'numeric' }));
            }
            var views = @json($pageViewsTrend);
            var visitors = @json($visitorTrend);
            var orders = @json($ConversionTrend);
            var ctx = document.getElementById('lineChart').getContext('2d');
            var grid = 'rgba(48, 43, 59, .5)';
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'Page views', data: views, borderColor: '#8b5cf6', backgroundColor: 'rgba(139,92,246,.15)',  borderWidth: 2, tension: 0.35, fill: true, pointRadius: 3, pointBackgroundColor: '#8b5cf6' },
                        { label: 'Visitors',   data: visitors, borderColor: '#a78bfa', backgroundColor: 'rgba(167,139,250,.10)', borderWidth: 2, tension: 0.35, fill: true, pointRadius: 3, pointBackgroundColor: '#a78bfa' },
                        { label: 'Orders',     data: orders, borderColor: '#c4b5fd', backgroundColor: 'transparent',            borderWidth: 2, tension: 0.35, fill: false, pointRadius: 3, pointBackgroundColor: '#c4b5fd' }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: { padding: 8 },
                    legend: { position: 'bottom', labels: { fontColor: '#a5a1b2', boxWidth: 12 } },
                    scales: {
                        xAxes: [{ gridLines: { display: false, color: grid }, ticks: { fontColor: '#777383' } }],
                        yAxes: [{ gridLines: { color: grid }, ticks: { fontColor: '#777383', beginAtZero: true } }]
                    },
                    tooltips: {
                        backgroundColor: '#181820',
                        titleFontColor: '#f5f3fa',
                        bodyFontColor: '#a5a1b2',
                        borderColor: '#302b3b',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 10
                    }
                }
            });
        })();
    </script>
@endsection
