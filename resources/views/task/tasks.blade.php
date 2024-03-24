@extends('layouts.app',['user' => $user])

@section('tasks')
    @php
        $incharges = \DB::table('users')->get();
    @endphp
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
@if($user->role == 'admin')
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Tasks List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tasks</a></li>
                                <li class="breadcrumb-item active">Tasks List</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
@endif
            <!-- end page title -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="tasksList">
                        <div class="card-header border-0">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title mb-0 flex-grow-1">All Tasks</h5>
@if($user->role == 'admin')
                                <div class="flex-shrink-0">
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('add-tasks') }}" class="btn btn-secondary add-btn"><i class="ri-add-line align-bottom me-1"></i> Add Tasks</a>
                                        <!-- Default Modals -->
                                        <button class="btn btn-soft-danger" id="remove-actions" onclick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                    </div>
                                </div>
@endif
                            </div>
                        </div>
                        <div class="card-body border border-dashed border-end-0 border-start-0">
                            <form>
                                <div class="row g-3">
                                    <div class="col-xxl-5 col-sm-12">
                                        <div class="search-box">
                                            <input type="text" class="form-control search bg-light border-light" placeholder="Search for tasks or something..." />
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-xxl-3 col-sm-4">
                                        <input type="text" class="form-control bg-light border-light" id="demo-datepicker" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" placeholder="Select date range" />
                                    </div>
                                    <!--end col-->

                                    <div class="col-xxl-3 col-sm-4">
                                        <div class="input-light">
                                            <select class="form-control" data-choices data-choices-search-false name="choices-single-default" id="idStatus">
                                                <option value="">Status</option>
                                                <option value="all" selected>All</option>
                                                <option value="New">New</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Inprogress">Inprogress</option>
                                                <option value="Completed">Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-1 col-sm-4">
                                        <button type="button" class="btn btn-primary w-100" onclick="SearchData();">
                                            <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                            Filters
                                        </button>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
@if($user->role == 'admin')
                            <div class="dt-buttons" style="padding-top: 15px">
                                <button class="dt-button buttons-copy buttons-html5" tabindex="0" aria-controls="buttons-datatables" type="button">
                                    <span>Copy</span>
                                </button>
                                <button class="dt-button buttons-csv buttons-html5" tabindex="0" aria-controls="buttons-datatables" type="button">
                                    <span>CSV</span>
                                </button>
                                <button class="dt-button buttons-excel buttons-html5" tabindex="0" aria-controls="buttons-datatables" type="button">
                                    <span>Excel</span>
                                </button> <button class="dt-button buttons-print" tabindex="0" aria-controls="buttons-datatables" type="button">
                                    <span>Print</span>
                                </button> <button class="dt-button buttons-pdf buttons-html5" tabindex="0" aria-controls="buttons-datatables" type="button">
                                    <span>PDF</span>
                                </button>
                            </div>
@endif
                        </div>
                        <!--end card-body-->
                        <div class="card-body">
                            <div class="table-responsive" style="height: 500px;">
                                <div id="buttons-datatables_wrapper" class="dataTables_wrapper dt-bootstrap5">

                                    <table id="taskTable" class="table-bordered align-middle table-nowrap mb-0" style="width:100%">

                                        <thead>
                                        <tr>
                                            @if($user->role == 'admin')
                                                <th scope="col" style="width: 40px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll" value="option" />
                                                    </div>
                                                </th>
                                            @endif
                                            <th class="sort" data-sort="date">Date</th>
                                            <th class="sort" data-sort="number">RFI NO</th>
                                            <th class="sort" data-sort="status">Status</th>
                                            <th class="sort" data-sort="type">Type</th>
                                            <th class="sort" data-sort="description">Description</th>
                                            <th class="sort" data-sort="location">Location</th>
                                            <th class="sort" data-sort="side">Road Type</th>
                                            <th class="sort" data-sort="qty_layer">Quantity/Layer No.</th>
                                            <th class="sort" data-sort="planned_time">Planned Time</th>
                                            @if($user->role == 'admin')
                                                <th class="sort" data-sort="incharge">In-charge</th>
                                            @endif
                                            <th class="sort" data-sort="completion_time">Completion Date/Time</th>
                                            <th class="sort" data-sort="tasks_name">Comments</th>
                                            <th class="sort" data-sort="tasks_name">Resubmitted</th>
                                            <th class="sort" data-sort="tasks_name">RFI Submission Date</th>
                                        </tr>
                                        </thead>
                                        <tbody id="task-list" class="list form-check-all">
                                        </tbody>
                                    </table>
                                    <div class="dataTables_info" id="buttons-datatables_info" role="status" aria-live="polite">Showing 1 to 10 of 27 entries</div>
                                    <div class="dataTables_paginate paging_simple_numbers" id="buttons-datatables_paginate">
                                        <ul class="pagination">
                                            <li class="paginate_button page-item previous disabled" id="buttons-datatables_previous">
                                                <a href="#" aria-controls="buttons-datatables" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                                            </li>
                                            <li class="paginate_button page-item active">
                                                <a href="#" aria-controls="buttons-datatables" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                                            </li>
                                            <li class="paginate_button page-item "><a href="#" aria-controls="buttons-datatables" data-dt-idx="2" tabindex="0" class="page-link">2</a>
                                            </li>
                                            <li class="paginate_button page-item "><a href="#" aria-controls="buttons-datatables" data-dt-idx="3" tabindex="0" class="page-link">3</a>
                                            </li>
                                            <li class="paginate_button page-item next" id="buttons-datatables_next">
                                                <a href="#" aria-controls="buttons-datatables" data-dt-idx="4" tabindex="0" class="page-link">Next</a>
                                            </li>
                                        </ul>
                                    </div>
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
function updateTaskList() {
    var tasks = {!! json_encode($tasks->toArray()) !!};
    var user = {!! json_encode($user->toArray()) !!};
    var incharges = {!! json_encode($incharges->toArray()) !!};
    var taskList = document.getElementById('task-list');

    // Sort tasks by date descending order
    tasks.sort(function(a, b) {
        return new Date(b.date) - new Date(a.date);
    });

    // Clear existing table rows
    taskList.innerHTML = '';
    // Loop through tasks and create table rows
    tasks.forEach(function (task) {
        var row = document.createElement('tr');

        if(user.role === "admin") {
            row.innerHTML = `
            <th scope="row">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="chk_child" value="option1" />
                </div>
            </th>
            `;
        }

        row.innerHTML += `
        <td style="text-align: center" class="due_date">${task.date}</td>
        <td style="text-align: center" class="id">${task.number}</td>
        <td style="text-align: center" class="status" >
            <span icon-task-id="${ task.id }">
            <i  style="${ task.status === 'pending' ? 'color: blue' :
                        task.status === 'completed' ? 'color: green' :
                            task.status === 'cancelled' ? 'color: red' : ''}" class="${ task.status === 'pending' ? 'ri-refresh-line fs-17 align-middle' :
                        task.status === 'completed' ? 'ri-checkbox-circle-line fs-17 align-middle' :
                            task.status === 'cancelled' ? 'ri-close-circle-line fs-17 align-middle' : ''}"></i>
            </span>
            <select id="status-dropdown" style="margin-bottom: 0rem !important; border: none; outline: none; background-color: transparent; text-align: center" data-task-id="${ task.id }">
                <option value="pending" ${task.status === "pending" ? 'selected' : ''}>Pending</option>
                <option value="completed" ${task.status === "completed" ? 'selected' : ''}>Completed</option>
                <option value="cancelled" ${task.status === "cancelled" ? 'selected' : ''}>Cancelled</option>
            </select>
        </td>
        <td style="text-align: center" class="client_name">${task.type}</td>
        <td>
            <div class="d-flex">
                <div style="cursor: pointer; width: 200px; ${ user.role === 'staff' ? 'overflow: auto;' : 'overflow: hidden; text-overflow: ellipsis'}" } title="${task.description}" class="flex-grow-1 tasks_name">${task.description}</div>
            </div>
        </td>
        <td style="text-align: center" class="client_name">${task.location}</td>
        <td style="text-align: center" class="client_name">${task.side}</td>
        <td style="text-align: center" class="client_name">${task.qty_layer ? task.qty_layer : ''}</td>
        <td style="text-align: center" class="client_name">${task.planned_time}</td>
        `;

        if(user.role === "admin") {
            // Find the incharge object that matches the task's incharge property
            var matchingIncharge = incharges.find(function(incharges) {
                return incharges.user_name === task.incharge;
            });
            var imagePath = "{{ asset("assets/images/users") }}" +"/"+ matchingIncharge.user_name + ".jpg";
            row.innerHTML += `
            <td style="text-align: center" class="incharge">
                <div class="avatar-group">
                    <a href="#" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" id="inchargeTooltip" title="${matchingIncharge.first_name}">
                    <img id="inchargeImage" src="${imagePath}" alt="" class="rounded-circle avatar-xxs" />
                    <span id="inchargeFirstName">${matchingIncharge.first_name}</span>
                    </a>
                </div>
            </td>
                `;
        }

        row.innerHTML += `
        <td style="text-align: center" class="client_name">
            <input data-task-id="${ task.id }" value="${task.completion_time}" style="border: none; outline: none; background-color: transparent;" type="datetime-local" id="completionDateTime" name="completion_time">
        </td>
        <td ${task.inspection_details ? `title="${task.inspection_details}"` : ''} class="client_name">
            <div style="cursor: pointer; width: 200px; ${task.inspection_details ? '' : 'text-align: center;'}" class="inspection-details" id= "inspectionDetails" onclick="editInspectionDetails(this)" data-task-id="${task.id}">
                <span class="inspection-text" style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; -webkit-line-clamp: 2; line-clamp: 2; " >${task.inspection_details ? task.inspection_details : 'N/A'}</span>
                <textarea class="inspection-input" style="display: none;"></textarea>
                <button class="save-btn" style="display: none;">Save</button>
            </div>
        </td>
        <td style="text-align: center" class="client_name" title="${task.resubmission_date}">${task.resubmission_count ? (task.resubmission_count > 1 ? task.resubmission_count + " times" : task.resubmission_count + " time") : ''}</td>
        <td style="text-align: center" class="client_name">
            <input value="${task.rfi_submission_date}" data-task-id="${ task.id }" style="border: none; outline: none; background-color: transparent;" type="date" id="rfiSubmissionDate" name="rfi_submission_date">
        </td>
        `;

        taskList.appendChild(row);
    });
}

// Call the function when the page loads
window.onload = function () {
    updateTaskList();
};
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
// Event listener for dropdown change
$(document).on('input', '#status-dropdown', function(e) {
    var taskId = e.target.getAttribute('data-task-id');
    var status = e.target.value;
    console.log(taskId, status);
    updateTaskStatus(taskId, status);
});
// Function to handle status update
function updateTaskStatus(taskId, status) {
    $.ajax({
        url:"{{ route('updateTaskStatus') }}",
        type:"POST",
        data: {
            id: taskId,
            status: status
        },
        success:function (data) {
            var icon = document.querySelector(`[icon-task-id="${taskId}"]`);
            console.log(icon);
            icon.innerHTML = '';
            var newIcon = (status) => {
                return status === 'pending' ? '<i icon-task-id="${ taskId }" style="color: blue" class="ri-refresh-line fs-17 align-middle"></i>' :
                    status === 'completed' ? '<i icon-task-id="${ taskId }" style="color: green" class="ri-checkbox-circle-line fs-17 align-middle"></i>' :
                        status === 'cancelled' ? '<i icon-task-id="${ taskId }" style="color: red" class="ri-close-circle-line fs-17 align-middle"></i>' : ''
            };
            toastr.success(data.message+status);
            icon.innerHTML = newIcon(status);
        }
    })
}

$(document).on('input', '#rfiSubmissionDate', function(e) {
    var taskId = e.target.getAttribute('data-task-id');
    var date = e.target.value;
    console.log(taskId, date);
    updateRfiSubmissionDate(taskId, date)
});
// Function to handle status update
function updateRfiSubmissionDate(taskId, date) {
    $.ajax({
        url:"{{ route('updateRfiSubmissionDate') }}",
        type:"POST",
        data: {
            id: taskId,
            date: date
        },
        success:function (data) {
            toastr.success(data.message+date);
        }
    })
}

$(document).on('input', '#completionDateTime', function(e) {
    var taskId = e.target.getAttribute('data-task-id');
    var dateTime = e.target.value;
    console.log(taskId, dateTime);
    updateCompletionDateTime(taskId, dateTime)
});

function updateCompletionDateTime(taskId, dateTime) {
    $.ajax({
        url:"{{ route('updateCompletionDateTime') }}",
        type:"POST",
        data: {
            id: taskId,
            dateTime: dateTime
        },
        success:function (data) {
            toastr.success(data.message+dateTime);
        }
    })
}

function editInspectionDetails(element) {
    element.removeAttribute('onclick');
    var taskId = element.getAttribute('data-task-id');
    var inspectionText = element.querySelector('.inspection-text');
    var inspectionInput = element.querySelector('.inspection-input');
    var saveBtn = element.querySelector('.save-btn');

    inspectionText.style.display = 'none';
    inspectionInput.value = inspectionText.textContent === 'N/A' ? '' : inspectionText.textContent;
    inspectionInput.style.display = 'block';
    saveBtn.style.display = 'block';
    $(saveBtn).on('click', function () {
        updateInspectionDetails(element, taskId, inspectionText, inspectionInput, saveBtn);
    })
}

function updateInspectionDetails(element, taskId, inspectionText, inspectionInput, saveBtn) {
    console.log('selcted: ',taskId);
    console.log('selcted: ',inspectionText);
    console.log('selcted: ',inspectionInput.value);
    console.log('selcted: ',saveBtn);

    $.ajax({
        url:"{{ route('updateInspectionDetails') }}",
        type:"POST",
        data: {
            id: taskId,
            inspection_details: inspectionInput.value
        },
        success:function (data) {
            element.setAttribute('onclick', 'editInspectionDetails(this)');
            inspectionText.textContent = inspectionInput.value;
            inspectionText.style.display = 'block';
            inspectionText.style.textOverflow = 'ellipsis';
            inspectionInput.style.display = 'none';
            saveBtn.style.display = 'none';
            toastr.success(data.message);
        }
    })
}

toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-bottom-center",
    "showDuration": "300",
    "hideDuration": "300",
    "timeOut": "300",
    "extendedTimeOut": "300",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

</script>

<style>
    #taskTable {

        overflow-x: auto;
    }
    #taskTable td:nth-of-type(6) {
        table-layout:fixed;
        width:60px;
        overflow: hidden;
    }
    #taskTable thead th {
        overflow: hidden;
        text-align: center;
    }
</style>
@endsection


