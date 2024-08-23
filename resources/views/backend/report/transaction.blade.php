@extends('layouts.backend.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @component('components.backend.card.card-table')
                @slot('header')
                    <h4 class="card-title">{{ __('menu.report_transaction') }}</h4>
                @endslot
                @slot('content_header')
                    <div class="row justify-content-between mt-1 pt-0">
                        <div class="col-lg-8 col-md-8 col-sm-12 m-auto">
                            <div class="row mx-1">
                                <form action="{{ route('report.transaction.filter') }}" method="post" class="d-flex align-items-center">
                                    @csrf
                                    <div class="form-group mb-0 mr-2">
                                        <label for="start_date">Tanggal Awal</label>
                                        <input type="date" name="start_date" id="start_date" value="{{ isset($data['startDate']) ? $data['startDate'] : '' }}" class="form-control">
                                    </div>
                                    <div class="form-group mb-0 mr-2">
                                        <label for="end_date">Tanggal Akhir</label>
                                        <input type="date" name="end_date" id="end_date" value="{{ isset($data['endDate']) ? $data['endDate'] : '' }}" class="form-control">
                                    </div>
                                    <div class="form-group mb-0 mr-2">
                                        <button type="submit" class="btn btn-primary mt-4">Search</button>
                                    </div>
                                    <div class="form-group mb-0">
                                        <a href="{{ route('report.transaction') }}" class="btn btn-warning mt-4">Reset</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 m-auto">
                            <button class="btn btn-primary float-right" id="print-btn">Cetak Laporan</button>
                        </div>
                    </div>
                    <hr>

                @endslot
                <table class="table table-bordered table-striped table-hover">
                    @slot('thead')
                        <tr>
                            <th>{{ __('field.no') }}</th>
                            <th>{{ __('field.date_report') }}</th>
                            <th>{{ __('field.total_sales') }}</th>
                            <th>{{ __('field.total_revenue') }}</th>
                        </tr>
                    @endslot
                    @slot('tbody')
                        @php
                            $i = 1;
                            $total_revenue = 0;
                        @endphp
                        @foreach ($report as $date => $data)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $data['date'] }}</td>
                                <td>{{ $data['total_sales'] }}</td>
                                <td>Rp {{ number_format($data['total_revenue'], 2, ',', '.') }}</td>
                            </tr>
                            @php $total_revenue += $data['total_revenue']; @endphp
                        @endforeach
                        <tbody>
                            <tr>
                                <td style="border: none"></td>
                                <td style="border: none"></td>
                                <td class="text-right" style="text-align: right"><strong> Total : </strong>&nbsp;</td>
                                <td><strong> Rp {{ number_format($total_revenue, 2, ',', '.') }} </strong></td>
                            </tr>
                        </tbody>
                    @endslot
                </table>
            @endcomponent
        </div>
    </div>


@endsection


@push('js')
    <script>
        document.getElementById('print-btn').addEventListener('click', function() {
            var table = document.getElementById('table-1'); // Replace with the actual ID of the table
            if (table) {
                printTable(table);
            } else {
                console.log('Table not found');
            }
        });

        function printTable(table) {
            var printWindow = window.open('', '_blank', 'width=800,height=600');

            printWindow.document.write('<html><head><title>Print Report</title><style>');
            printWindow.document.write('table { border-collapse: collapse; width:90% }');
            printWindow.document.write('th, td { border: 1px solid #ddd; padding: 5px; }');
            printWindow.document.write('</style></head><body>');
            printWindow.document.write('<center><h3> Laporan transaksi </h3></center'); // add a title
            printWindow.document.write('<center><table>');
            for (var i = 0; i < table.rows.length; i++) {
                var row = table.rows[i];
                printWindow.document.write('<tr>');
                for (var j = 0; j < row.cells.length; j++) {
                    var cell = row.cells[j];
                    printWindow.document.write('<td>' + cell.innerHTML + '</td>');
                }
                printWindow.document.write('</tr>');
            }
            printWindow.document.write('</table></center>');
            printWindow.document.write('</body></html>');

            printWindow.document.close();
            printWindow.print();
            // printWindow.close(); // uncomment to close the print window after printing
        }
    </script>
@endpush
