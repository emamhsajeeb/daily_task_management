@extends('layouts.app',['user' => $user])

@section('attendance')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">{{ $title }}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">QC Reports</a></li>
                                    <li class="breadcrumb-item active">{{ $title }}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">{{ $title }}</h4>

                                <div class="flex-shrink-0">
                                    <div class="d-flex flex-wrap gap-2">
                                        <button title="Add NCR" class="btn btn-outline-primary btn-icon waves-effect waves-light" id="showAddModalBtn"><i class="ri-add-box-line align-bottom me-1"></i></button>
                                    </div>
                                </div>

                            </div><!-- end card header -->
                            <div class="card-body border border-dashed border-end-0 border-start-0">
                                <form id="filterTaskForm">
                                    @csrf
                                    <div class="row g-3">

                                        <div class="col-xxl-3 col-sm-8">
                                            <input  type="month" id="monthPicker" name="monthPicker" class="form-control bg-light border-light" placeholder="Select month..." />
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div>
                                        <table  id="attendanceTable" class="table-bordered table-nowrap display compact align-middle">
                                            <thead id="attendanceTableHead" style="text-align: center">
                                            </thead>
                                            <tbody id="attendanceTableBody">
                                            <!-- Table body content will be populated dynamically -->
                                            </tbody>
                                            <tfoot id="attendanceTableBody">
                                            <tr>
                                                <!-- Remark footer -->
                                                <td id="remarkFooter" >Remark: Symbol description: “√” attendance, “§” personal leave, “×” sickness, “◎” maternity leave, “■” funeral leave, “△” annual holiday, “□” marital leave, “☆” late, “*” leave early, “○” business trip, “▼” absence, “/” weekend, “#” festival holiday.</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div><!-- end row -->

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
    <!-- end main content-->


<script>
const admin = {{$user->hasRole('admin') ? 'true' : 'false'}};
var user = {!! json_encode($user) !!};

async function updateAttendanceTable(month) {
    preloader.style.opacity = '1'; // Set opacity to 1 to make it visible
    preloader.style.visibility = 'visible'; // Set visibility to visible
    await $.ajax({
        url: '{{ route("allAttendance") }}',
        method: 'GET',
        data: { month: month }, // Pass the selected month to the server
        dataType: 'json',
        success: async function(response) {
            // Append the row to the table body
            $('#attendanceTableHead').html('');
            $('#attendanceTableBody').html('');
            const attendances = response.attendance;
            console.log(attendances);

            const [year, monthNumber] = month.split('-').map(Number);
            const numberOfDays = new Date(year, monthNumber, 0).getDate();
            var header = `
                <tr>
                    <th>Name</th>`;
                    for (var day = 1; day <= numberOfDays; day++) {
                        // Add a table header for each day (render only the day text)
                        header += `<td>${day}</td>`;
                    }
            header += `
                <th>Present</th>
                <th>Personal</th>
                <th>Sickness</th>
                <th>Maternity</th>
                <th>Funeral</th>
                <th>Annual</th>
                <th>Marital</th>
                <th>Late</th>
                <th>Leave Early</th>
                <th>Business Trip</th>
                <th>Absence</th>
                <th>Weekend</th>
                <th>Festival</th>
            </tr>`;

            $('#attendanceTableHead').html(header);



            // Render rows for each user attendance
            for (const userAttendance of attendances) {
                // Initialize a row with the user name
                let row = `<tr><td>${userAttendance.user_name}</td>`;

                // Loop through each date and symbol in the attendance object
                for (const [date, symbol] of Object.entries(userAttendance.attendance)) {
                    // Initialize the statusOptions variable
                    const symbols = [
                        "√", "§", "×", "◎", "■", "△", "□", "☆", "*", "○", "▼", "/", "#"
                    ];
                    var statusOptions = symbols.map(function(optSymbol) {
                        // Check if the symbol matches the current option value
                        const selected = symbol === optSymbol ? 'selected' : '';
                        // Return the option HTML with the selected attribute if necessary
                        return `<option value="${optSymbol}" ${selected}>${optSymbol}</option>`;
                    }).join('');

                    // Render a table cell for each date symbol with fixed width and dropdown
                    row += `<td><select
                                    style="width: 25px; height: 25px; padding: 0; appearance: none; margin-bottom: 0rem !important; border: none; outline: none; background-color: transparent; text-align: center"
                                    data-date="${date}"
                                    data-user-id="${userAttendance.user_id}"
                                    class="symbol-dropdown"
                            ><option disabled value="" ${!symbol ? 'selected' : ''}></option>${statusOptions}</select></td>`;

                }

                // Loop through each date and symbol in the attendance object
                for (const [symbol, count] of Object.entries(userAttendance.symbol_counts)) {

                    // Render a table cell for each date symbol with fixed width and dropdown
                    row += `<th style="text-align: center;">${count ? count : ''}</th>`;

                }

                // Close the row tag
                row += '</tr>';

                // Append the row to the table body
                $('#attendanceTableBody').append(row);
            }



            $('#remarkFooter').attr('colspan', 14+numberOfDays);

            $('#attendanceTable').DataTable({
                ordering: false,
                processing: true,
                scroller: true,
                scrollY: 500,
                language: {
                    processing: "<i class='fa fa-refresh fa-spin'></i>",
                },
                destroy: true,
                order: [[0,'desc']],
                scrollCollapse: true,
                deferRender: true,
                fixedHeader: {
                    header: true,
                    footer: true
                },
            });
            preloader.style.opacity = '0'; // Set opacity to 1 to make it visible
            preloader.style.visibility = 'hidden'; // Set visibility to visible



        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}


// Function to handle status update
async function updateAttendance(userId, date, symbol) {
    await $.ajax({
        url: "{{ route('updateAttendance') }}",
        type: "POST",
        data: {
            user_id: userId,
            date: date,
            symbol: symbol
        },
        success:function (data) {
            toastr.success(data.message);
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
        }
    })
}



$( document ).ready(async function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // Set default month to current month
    const currentDate = new Date();
    const currentMonth = currentDate.getMonth() + 1;
    const currentYear = currentDate.getFullYear();
    const defaultMonth = `${currentYear}-${currentMonth.toString().padStart(2, '0')}`;
    $('#monthPicker').val(defaultMonth);

    // Call updateAttendanceTable initially with default month
    await updateAttendanceTable(defaultMonth);

    $("#showAddModalBtn").click(function () {
        $("#showAddModal").modal('show');
    });

    // Attach change event listener to the month input field
    $('#monthPicker').change(function() {
        // Get the new selected month value
        const newMonth = $(this).val();
        console.log(newMonth);

        // Call the updateAttendanceTable function with the new month value
        updateAttendanceTable(newMonth);
    });

    await $('#exportToExcel').click(async function (e) {
        e.preventDefault();
        $('#exportToExcel').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $('#exportToExcel').prop('disabled', true);
        await exportToExcel();
    });
});



// Event listener for dropdown change
$(document).on('change', '.symbol-dropdown', async function (e) {
    var userId = e.target.getAttribute('data-user-id');
    var date = e.target.getAttribute('data-date');
    var symbol = e.target.value;

    console.log('user_id: ',userId, 'date: ', date, 'symbol: ',symbol);
    await updateAttendance(userId, date, symbol);
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





</style>


@endsection
