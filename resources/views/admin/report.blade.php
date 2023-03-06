@extends('admin.layouts.admin')

@section('content')
<div class="">
    Report Page
</div>
<input type="text" name="daterange" value="01/01/2023 - 01/15/2023" />
<select class="js-example-basic-single" name="state[]" multiple="multiple">
    @foreach ($products as $product)
    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
    @endforeach
</select>
<br><br>
<div id="product_price_range">
    <canvas class="canvasChart"></canvas>
</div>
<div id="output"></div>
@endsection

@section('scripts')
@parent
{{ Html::script(mix('assets/admin/js/dashboard.js')) }}
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://pivottable.js.org/dist/pivot.js"></script>
<script>
    $('input[name="daterange"]').daterangepicker({
        opens: 'left'
    }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
    $('.js-example-basic-single').select2();
    $.ajax({
                url: 'report/all-data-product',
                success: function (response) {
                    $("#output").pivot(
                        response,
                        {
                            rows: ["created_range"],
                            cols: ["price_range"]
                        }
                    );
                }
    });

    const data = {
        labels: [
            "< 50000",
            "50000 - 99999",
            "100000 - 999999",
            "> 1000000"
        ],
        datasets: [
            {
            label: 'Dataset 1',
            data: [],
            backgroundColor: [
                        "#3498DB",
                        "#3498DB",
                        "#9B59B6",
                        "#E74C3C",
                    ],
            }
        ]
    };

    var productPriceRange = {
        _defaults: {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Chart.js Doughnut Chart'
                }
                }
            },
        },
        init: function ($el) {
            var self = this;
            $el = $($el);

            $.ajax({
                url: 'report/chart-price',
                success: function (response) {
                    // console.log(response, "++++++++")
                    self._defaults.data.datasets[0].data = [
                        response.less_50000,
                        response._50000_99999,
                        response._100000_999999,
                        response.more_1000000
                    ];
                    new Chart($el.find('.canvasChart'), self._defaults);
                }
            });
        }
    };
    productPriceRange.init($('#product_price_range'));

    
</script>
@endsection

@section('styles')
@parent
{{ Html::style(mix('assets/admin/css/dashboard.css')) }}
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://pivottable.js.org/dist/pivot.css">
@endsection