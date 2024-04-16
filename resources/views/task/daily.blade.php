@extends('layouts.app',['user' => $user])

@section('daily')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid" style="max-width: 100% !important;">
            <!-- start page title -->
            @role('admin')
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $title }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tasks</a></li>
                                <li class="breadcrumb-item active">{{ $title }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            @endrole
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="tasksList">
                        <div class="card-header border-0" style="padding-bottom: 0 !important;">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title mb-0 flex-grow-1">{{ $title }}</h5>

                                <div class="flex-shrink-0">
                                    <div class="d-flex flex-wrap gap-2">
                                        @role('admin')
                                        <button id="exportToExcel" title="Export Summary" class="btn btn-outline-success btn-icon waves-effect waves-light"><i class="ri-download-2-line align-bottom me-1"></i></button>
                                        @endrole
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-body border border-dashed border-end-0 border-start-0">
                            <form id="filterTaskForm">
                                @csrf
                                <div class="row g-3">

                                    <div class="col-xxl-3 col-sm-8">
                                        <input  type="month" id="monthPicker" name="monthPicker" class="form-control bg-light border-light" placeholder="Select month..." />
                                    </div>
                                    <!--end col-->
                                    @role('admin')
                                    <div class="col-xxl-3 col-sm-4">
                                        <div class="input-light">
                                            <select name="incharge" class="form-control" id="taskIncharge">
                                                <option value="" disabled selected>Select Incharge</option>
                                                <option value="all">All</option>
                                                @foreach($incharges as $incharge)
                                                    <option value="{{$incharge->user_name}}">{{$incharge->first_name.' '.$incharge->last_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    @endrole
                                    <!--end col-->
                                    <div class="col-xxl-1 col-sm-4">
                                        <button type="button" class="btn btn-primary w-100" id="filterSummary">
                                            <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                            Filter
                                        </button>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <!--end card-body-->
                        <div class="card-body" style="{{ $user->hasRole('se') ? 'padding-top: 0 !important;' : '' }}">
                            <div class="table-responsive">
                                <div>
                                    <table id="dailySummaryTable" class="dataTables-center table-bordered column-order table-nowrap display compact align-middle">
                                        <thead id="dailySummaryHead" class="dataTables-center">
                                        </thead>
                                        <tbody id="dailySummaryBody" class="dataTables-center">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>

<script>

// Function to get the tasks dynamically
const admin = {{$user->hasRole('admin') ? 'true' : 'false'}};
var user = {!! json_encode($user) !!};

function updateDailySummaryBody(summaries) {
    var preloader = document.getElementById('preloader');

    preloader.style.opacity = '0'; // Set opacity to 1 to make it visible
    preloader.style.visibility = 'hidden'; // Set visibility to visible

    $('#dailySummaryTable').DataTable({
        processing: true,
        language: {
            processing: "<i class='fa fa-refresh fa-spin'></i>",
        },
        destroy: true,
        order: [[0,'desc']],
        scrollCollapse: true,
        scroller: true,
        scrollY: 500,
        deferRender: true,
        fixedHeader: {
            header: true,
            footer: true
        },
        data: summaries, // Pass tasks data to DataTable
        columnDefs: [
            {
                searchable: true, targets: [0]
            }
        ],
        columns: [
            { data: 'date', className: 'dataTables-center' },
            { data: 'totalTasks', className: 'dataTables-center' },
            { data: 'structureTasks', className: 'dataTables-center' },
            { data: 'embankmentTasks', className: 'dataTables-center' },
            { data: 'pavementTasks', className: 'dataTables-center' },
            { data: 'totalResubmission', className: 'dataTables-center' },
            { data: 'completed', className: 'dataTables-center' },
            {
                data: 'completionPercentage',
                className: 'dataTables-center',
                render: function(data, type, row) {
                    // Check if the data exists and if it's of the type 'display'
                    if (data && type === 'display') {
                        // Concatenate the data with '%' sign
                        return data + '%';
                    }
                    // Otherwise, just return the original data
                    return data;
                }
            },
            { data: 'pending', className: 'dataTables-center' },
            { data: 'rfiSubmissions', className: 'dataTables-center' },
            {
                data: 'rfiSubmissionPercentage',
                className: 'dataTables-center',
                render: function(data, type, row) {
                    // Check if the data exists and if it's of the type 'display'
                    if (data && type === 'display') {
                        // Concatenate the data with '%' sign
                        return data + '%';
                    }
                    // Otherwise, just return the original data
                    return data;
                }
            }
        ]

    });
}




async function filterDailySummary() {

    // Get selected month from month picker
    var selectedMonth = document.getElementById('monthPicker').value;
    var taskIncharge = admin ? document.getElementById('taskIncharge').value : null;

    try {
        // Send selected month to Laravel controller
        await $.ajax({
            url: admin ? "{{ route('filterSummary') }}" : "{{ route('filterSummarySE') }}" ,
            type: "POST",
            data: {
                month: selectedMonth,
                incharge: taskIncharge,
            },
            success: async function (response) {
                var preloader = document.getElementById('preloader');
                preloader.style.opacity = '1'; // Set opacity to 1 to make it visible
                preloader.style.visibility = 'visible'; // Set visibility to visible
                toastr.success(response.message);
                $('#dailySummaryTable').DataTable().clear().destroy();

                const summaries = response.summaries;

                await updateDailySummaryBody(summaries);
                preloader.style.opacity = '0'; // Set opacity to 1 to make it visible
                preloader.style.visibility = 'hidden'; // Set visibility to visible
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    } finally {
        // Once filtering is done, restore the button
        $('#filterSummary').html('<i class="ri-equalizer-fill me-1 align-bottom"></i>Filter');
        $('#filterSummary').prop('disabled', false);
    }
}


async function updateDailySummary(month = null) {
    var url = '{{ route("dailySummary") }}';
    var header = `
        <tr>
        <th>Date</th>
        <th>Total Tasks</th>
        <th>Structure</th>
        <th>Embankment</th>
        <th>Pavement</th>
        <th>Resubmission</th>
        <th>Completed</th>
        <th>% Completed</th>
        <th>Pending</th>
        <th>RFI Submission</th>
        <th>% RFI Submission</th>
        </tr>
        `;

    $('#dailySummaryHead').html(header);

    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: async function (response) {
            var summaries = response.data;

            console.log(summaries);

            await updateDailySummaryBody(summaries);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            return error;
        }
    });

}

async function exportToExcel() {
    try {
        // Get the HTML table element
        var table = document.getElementById("dailySummaryTable");

        // Create an empty Excel Workbook
        var excelData = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        excelData += '<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"></head>';
        excelData += '<body>';
        excelData += '<table>';

        // Add the table rows and cells to the Excel data
        for (var i = 0; i < table.rows.length; i++) {
            excelData += '<tr>';
            for (var j = 0; j < table.rows[i].cells.length; j++) {
                excelData += '<td>' + table.rows[i].cells[j].innerHTML + '</td>';
            }
            excelData += '</tr>';
        }

        excelData += '</table>';
        excelData += '</body>';
        excelData += '</html>';

        // Create a data URI
        var uri = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(excelData);

        // Create a new window and open the data URI
        var link = document.createElement('a');
        link.href = uri;
        link.style = "visibility:hidden";
        link.download = "Summary.xls";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } finally {
        $('#exportToExcel').html('<i class="ri-download-2-line align-bottom me-1"></i>');
        $('#exportToExcel').prop('disabled', false);
    }
}


// Call the function when the page loads
$( document ).ready(async function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    await updateDailySummary();

    // Event listener for dropdown change
    $('#filterSummary').click(async function (e) {
        e.preventDefault();
        $('#filterSummary').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Filtering...');
        $('#filterSummary').prop('disabled', true);
        await filterDailySummary();
    });

    await $('#exportToExcel').click(async function (e) {
        e.preventDefault();
        $('#exportToExcel').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $('#exportToExcel').prop('disabled', true);
        await exportToExcel();
    });
});



toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

</script>

<style>
    .dataTables-center {
        text-align: center;
    }
</style>
@endsection


