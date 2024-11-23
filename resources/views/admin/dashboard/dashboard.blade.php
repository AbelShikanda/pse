@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                @if (Session('success'))
                    <div class="text-success text-center">
                        <strong>{{ Session('success') }}</strong>
                    </div>
                @endif
                <div class="row align-items-center mb-2">
                    <div class="col">
                        <h2 class="h5 page-title">Welcome!</h2>
                    </div>
                    <div class="col-auto">
                        <form class="form-inline">
                            <div class="form-group d-none d-lg-inline">
                                <label for="reportrange" class="sr-only">Date Ranges</label>
                                <div id="reportrange" class="px-2 py-2 text-muted">
                                    <span class="small"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-sm"><span
                                        class="fe fe-refresh-ccw fe-16 text-muted"></span></button>
                                <button type="button" class="btn btn-sm mr-2"><span
                                        class="fe fe-filter fe-16 text-muted"></span></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- widgets -->
                <div class="row my-4">
                    <div class="col-md-4">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <small class="text-muted mb-1">Page Views</small>
                                        <h3 class="card-title mb-0">{{ $thisWeekViews }}</h3>
                                        <p class="small text-muted mb-0"><span
                                                class="fe fe-arrow-{{ $percentageViewChange < 0 ? 'down' : 'up' }} fe-12 text-{{ $percentageViewChange < 0 ? 'danger' : 'success' }}"></span>
                                            <span>{{ number_format($percentageViewChange, 2) }}% Last week</span>
                                        </p>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="sparkline inlineline"></span>
                                    </div>
                                </div> <!-- /. row -->
                            </div> <!-- /. card-body -->
                        </div> <!-- /. card -->
                    </div> <!-- /. col -->
                    <div class="col-md-4">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <small class="text-muted mb-1">Conversion</small>
                                        <h3 class="card-title mb-0">{{ $thisWeekConversions }}</h3>
                                        <p class="small text-muted mb-0"><span
                                                class="fe fe-arrow-{{ $percentageConversionChange < 0 ? 'down' : 'up' }} fe-12 text-{{ $percentageConversionChange < 0 ? 'danger' : 'success' }}"></span>
                                            <span>{{ number_format($percentageConversionChange, 2) }}% Last week</span>
                                        </p>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="sparkline inlinepie"></span>
                                    </div>
                                </div> <!-- /. row -->
                            </div> <!-- /. card-body -->
                        </div> <!-- /. card -->
                    </div> <!-- /. col -->
                    <div class="col-md-4">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <small class="text-muted mb-1">Visitors</small>
                                        <h3 class="card-title mb-0">{{ $thisWeekVisitorsCount }}</h3>
                                        <p class="small text-muted mb-0"><span
                                                class="fe fe-arrow-{{ $percentageVisitorChange < 0 ? 'down' : 'up' }} fe-12 text-{{ $percentageVisitorChange < 0 ? 'danger' : 'success' }}"></span>
                                            <span>{{ number_format($percentageVisitorChange, 2) }}% Last week</span>
                                        </p>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="sparkline inlinebar"></span>
                                    </div>
                                </div> <!-- /. row -->
                            </div> <!-- /. card-body -->
                        </div> <!-- /. card -->
                    </div> <!-- /. col -->
                </div> <!-- end section -->
                <!-- linechart -->
                <div class="my-4">
                    <canvas id="lineChart"></canvas> <!-- Page Views Line Chart -->
                </div>
                <div class="row">
                    <div class="col-md-10 offset-1">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Top Selling</strong>
                                <a class="float-right small text-muted" href="#!">View all</a>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush my-n3">
                                    <div class="list-group-item">
                                        @foreach ($topSellingProducts as $products)
                                            <div class="row align-items-center">
                                                <div class="col-3 col-md-2">
                                                    <img src="{{ asset('storage/img/products/' . $products->productImage->first()->thumbnail) }}"
                                                        alt="..." class="thumbnail-sm">
                                                </div>
                                                <div class="col">
                                                    <strong>{{ $products->name }}</strong>
                                                    <div class="my-0 text-muted small">{{ $products->meta_keywords }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <strong>{{ number_format($products->percentage_sold, 1) }}%</strong>
                                                    <div class="progress mt-2" style="height: 4px;">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ number_format($products->percentage_sold, 1) }}%"
                                                            aria-valuenow="{{ $products->percentage_sold }}"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div> <!-- / .list-group -->
                            </div> <!-- / .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col -->
                </div> <!-- .row -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card shadow eq-card  mb-4">
                            <div class="card-header">
                                <strong>Region Sales</strong>
                            </div>
                            <div class="card-body">
                                @foreach ($regionData as $data)
                                    <div id="dataMap"
                                        style="position:relative; max-width: 320px; max-height: 200px; margin:0 auto;">
                                        {{-- <div id="dataMapUSA"></div> --}}
                                    </div>
                                    <div class="row align-items-bottom my-2">
                                        <div class="col">
                                            <p class="mb-0">{{ $data->town }}</p>
                                            <span class="my-0 text-muted small">{{ $data->sales_percentage }}%</span>
                                        </div>
                                        <div class="col-auto text-right">
                                            <p class="mb-0">{{ $data->total_sales }}</p>
                                            <div class="progress mt-2" style="height: 4px;">
                                                <div class="progress-bar" role="progressbar" style="width: 85%"
                                                    aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div> <!-- .col -->
                    <div class="col-md-4">
                        <div class="card shadow eq-card mb-4">
                            <div class="card-header">
                                <strong class="card-title">Traffic</strong>
                                <a class="float-right small text-muted" href="#!">View all</a>
                            </div>
                            <div class="card-body">
                                {{-- <div class="chart-box mb-3" style="min-height:180px;">
                                    <div id="customAngle" style="width: 100%; height: 180px;"></div>
                                </div> <!-- .col --> --}}
                                <div class="mx-auto">
                                    @foreach ($trafficData as $medium => $count)
                                        <div class="row align-items-center mb-2">
                                            <div class="col">
                                                <p class="mb-0">{{ $medium }}</p>
                                                <span class="my-0 text-muted small">
                                                    @php
                                                        $totalTraffic = array_sum($conversionBreakdown);
                                                        $percentage =
                                                            $totalTraffic > 0 ? ($count / $totalTraffic) * 100 : 0;
                                                    @endphp
                                                    +{{ number_format($percentage, 1) }}%
                                                </span>
                                            </div>
                                            <div class="col-auto text-right">
                                                <p class="mb-0">{{ $count }}</p>
                                                <span
                                                    class="dot dot-md {{ $medium == 'organic' ? 'bg-success' : ($medium == 'referral' ? 'bg-warning' : ($medium == 'paid' ? 'bg-primary' : 'bg-secondary')) }}"></span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col-md -->
                    <div class="col-md-4">
                        <div class="card shadow eq-card mb-4">
                            <div class="card-header">
                                <strong>Browsers</strong>
                            </div>
                            <div class="card-body">
                                {{-- <div class="chart-box mt-3 mb-5">
                                    <div id="radarChartWidget" width="400" height="400"></div>
                                </div> <!-- .col --> --}}
                                <div class="mx-auto">
                                    <div class="row align-items-center my-2">
                                        @foreach ($browsers as $browser)
                                            <div class="col-6 col-xl-3 my-3">
                                                <span class="mb-0">{{ $browser->user_agent }}</span>
                                                <div class="progress my-2" style="height: 4px;">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $browser->percentage }}%"
                                                        aria-valuenow="{{ $browser->percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-xl-3 my-3 text-right">
                                                <span>{{ $browser->count }}</span><br />
                                                <span class="my-0 text-muted small">{{ $browser->percentage }}%</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col -->
                </div>
            </div> <!-- /.col -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
    @include('admin.layouts.partials.modals')

    
    <script>
        $(document).ready(function() {
            // Page Views Data (Line Chart)
            var pageViewsData = @json($pageViewsTrend); // Example: [120, 150, 130, 140, 160, 170, 180]
            $('.sparkline.inlineline').sparkline(pageViewsData, {
                type: 'line',
                width: '100%',
                height: '50',
                lineColor: '#00c292',
                fillColor: '#e0f8f4',
                spotColor: '#00c292',
                minSpotColor: '#00c292',
                maxSpotColor: '#00c292',
            });

            // Conversion Data (Pie Chart)
            var conversionData = @json(array_values($conversionBreakdown)); // Example: [60, 30, 10]
            $('.sparkline.inlinepie').sparkline(conversionData, {
                type: 'pie',
                width: '50',
                height: '50',
                sliceColors: ['#00c292', '#03a9f3', '#f4c22b'],
            });

            // Visitors Data (Bar Chart)
            var visitorsData = @json($visitorTrend); // Example: [20, 30, 25, 35, 40, 50, 45]
            $('.sparkline.inlinebar').sparkline(visitorsData, {
                type: 'bar',
                barColor: '#03a9f3',
                negBarColor: '#f44336',
                zeroColor: '#e0f8f4',
                barWidth: 6,
                barSpacing: 3,
                height: '50',
            });

            // Labels for the last 7 days
            var labels = [];
            for (let i = 6; i >= 0; i--) {
                let date = new Date();
                date.setDate(date.getDate() - i); // Get each day
                labels.push(date.toLocaleDateString()); // Format date (you can customize this)
            }

            // Your data for Page Views, Visitors, and Orders (conversionData)
            var pageViewsData = @json($pageViewsTrend); // Example: [120, 150, 130, 140, 160, 170, 180]
            var visitorsData = @json($visitorTrend); // Example: [20, 30, 25, 35, 40, 50, 45]
            var conversionData = @json($ConversionTrend); // Example: [60, 30, 10]

            // Get the canvas element
            var ctx = document.getElementById('lineChart').getContext('2d');


            // Create the chart with multiple datasets (each line is a separate dataset)
            var lineChart = new Chart(ctx, {
                type: 'line', // Line chart type
                data: {
                    labels: labels, // Labels for each day
                    datasets: [{
                            label: 'Page Views', // Label for Page Views line
                            data: pageViewsData, // Page Views data
                            fill: false, // No fill under the line
                            borderColor: '#00c292', // Line color
                            tension: 0.1 // Smooth line
                        },
                        {
                            label: 'Visitors', // Label for Visitors line
                            data: visitorsData, // Visitors data
                            fill: false, // No fill under the line
                            borderColor: '#03a9f3', // Line color
                            tension: 0.1 // Smooth line
                        },
                        {
                            label: 'Orders', // Label for Orders (Conversion) line
                            data: conversionData, // Orders data
                            fill: false, // No fill under the line
                            borderColor: '#f4c22b', // Line color
                            tension: 0.1 // Smooth line
                        }
                    ]
                },
                options: {
                    responsive: true, // Responsive chart
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Days' // X-axis label
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Count' // Y-axis label (this can be changed as needed)
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            right: 10,
                            bottom: 10,
                            left: 10
                        }
                    }
                }
            });
        });
    </script>

    <script>
        var map = L.map('dataMap').setView([1.2921, 36.8219], 6); // Set the center to France coordinates

        // Use OpenStreetMap tiles for the map background
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Optionally, add markers or other features to the map
        L.marker([1.2921, 36.8219]).addTo(map) // Example: Marker for Paris
            .bindPopup('Nairobi, Kenya')
            .openPopup();
    </script>
    <script>
        // Convert PHP data to JavaScript
        var trafficData = @json($trafficData);

        // Extract labels and values
        var labels = Object.keys(trafficData).map(function(key) {
            return key.charAt(0).toUpperCase() + key.slice(1); // Capitalize labels
        });
        var data = Object.values(trafficData);

        // Define chart colors
        var backgroundColors = [
            'rgba(75, 192, 192, 0.6)', // Organic - Green
            'rgba(255, 206, 86, 0.6)', // Referral - Yellow
            'rgba(54, 162, 235, 0.6)', // Paid - Blue
            'rgba(153, 102, 255, 0.6)' // Direct - Purple
        ];

        // Render the chart
        var ctx = document.getElementById('customAngle').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut', // Use 'doughnut' or 'pie'
            data: {
                labels: labels, // Labels from traffic data
                datasets: [{
                    data: data, // Values from traffic data
                    backgroundColor: backgroundColors, // Chart colors
                    borderWidth: 1 // Border width
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    </script>

    <script>
        var browserLabels = {!! json_encode($browsers->pluck('user_agent')->toArray()) !!};
        var browserPercentages = {!! json_encode($browsers->pluck('percentage')->toArray()) !!};

        // Get the radar chart canvas
        var ctx = document.getElementById('radarChartWidget').getContext('2d');

        // Create the radar chart
        var radarChart = new Chart(ctx, {
            type: 'radar', // Set chart type to radar
            data: {
                labels: browserLabels, // Browser names
                datasets: [{
                    label: 'Browser Usage (%)',
                    data: browserPercentages, // Browser percentages
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Light blue fill
                    borderColor: 'rgba(54, 162, 235, 1)', // Blue border
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    r: {
                        angleLines: {
                            color: '#ddd'
                        }, // Style for grid lines
                        grid: {
                            color: '#ccc'
                        },
                        suggestedMin: 0, // Minimum value for percentage
                        suggestedMax: 100 // Maximum value for percentage
                    }
                }
            }
        });
    </script>
@endsection
