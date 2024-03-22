@extends('layouts.app',['user' => $user])

@section('tasks',)
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
                                <div class="flex-shrink-0">
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('add-tasks') }}" class="btn btn-secondary add-btn"><i class="ri-add-line align-bottom me-1"></i> Add Tasks</a>
                                        <!-- Default Modals -->
                                        <button class="btn btn-soft-danger" id="remove-actions" onclick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                    </div>
                                </div>
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
                        </div>
                        <!--end card-body-->
                        <div class="card-body">
                            <div class="table-responsive table-card mb-4" style="height: 500px;">
                                <table class="table align-middle table-nowrap mb-0" id="tasksTable">
                                    <thead class="table-light text-muted">
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
                                            <th class="sort" data-sort="type">Type</th>
                                            <th class="sort" data-sort="description">Description</th>
                                            <th class="sort" data-sort="location">Location</th>
                                            <th class="sort" data-sort="side">Side</th>
                                            <th class="sort" data-sort="qty_layer">Quantity/Layer No.</th>
                                            <th class="sort" data-sort="planned_time">Planed Time</th>
                                            <th class="sort" data-sort="incharge">In-charge</th>
                                            <th class="sort" data-sort="status">Status</th>
                                            <th class="sort" data-sort="completion_time">Completion Date/Time</th>
                                            <th class="sort" data-sort="tasks_name">Inspection Details</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                    @foreach($tasks as $task)

                                        <tr>
@if($user->role == 'admin')
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child" value="option1" />
                                                </div>
                                            </th>
@endif
                                            <td class="due_date">{{ $task->date }}</td>
                                            <td class="id">{{ $task->number }}</td>
                                            <td class="client_name">{{ $task->type }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 tasks_name">{{ $task->description }}</div>
                                                </div>
                                            </td>
                                            <td class="client_name">{{ $task->location }}</td>
                                            <td class="client_name">{{ $task->side }}</td>
                                            <td class="client_name">{{ $task->qty_layer }}</td>
                                            <td class="client_name">{{ $task->planned_time }}</td>
@if($user->role == 'admin')
                                            <td class="incharge">
                                                <div class="avatar-group">
 @if ($user->role == 'staff')
                                                    <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Frank">
                                                        <img src="{{ asset('assets/images/users/' . $user->user_name . '.jpg') }}" alt="" class="rounded-circle avatar-xxs" />
                                                       
                                                        <span>{{ $user->first_name }}</span>
                                                       
                                        


                                           </a>
 @endif 
          @if($user->role == 'admin')
                                                            @php
                                                                $incharge = \DB::table('users')->where('user_name',$task->incharge)->first();
                                                            @endphp
                                                        <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Frank">
                                                        <img src="{{ asset('assets/images/users/' . $incharge->user_name . '.jpg') }}" alt="" class="rounded-circle avatar-xxs" />
                                                       
                                                        <span>{{ $incharge->first_name }}</span>

                                                        @endif 
                                     </div>
                                            </td>
@endif
                                            <td class="status">
                                                <div class="btn-group">
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" style="text-transform: uppercase" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        {{ $task->status }}
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item update-status" data-status="pending" href="{{ route('updateTaskStatus',['taskNumber' => $task->id,'status' => 'pending']) }}">Pending</a>
                                                        <a class="dropdown-item update-status" data-status="completed" href="{{ route('updateTaskStatus',['taskNumber' => $task->id,'status' => 'completed']) }}">Completed</a>
                                                        <a class="dropdown-item update-status" data-status="cancelled" href="{{ route('updateTaskStatus',['taskNumber' => $task->id,'status' => 'cancelled']) }}">Cancelled</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="client_name">{{ $task->completion_time }}</td>
                                            <td class="client_name">{{ $task->inspection_details }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!--end table-->
                                <div class="noresult" style="display: none">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                        <p class="text-muted mb-0">We've searched more than 200k+ tasks We did not find any tasks for you search.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-2">
                                <div class="pagination-wrap hstack gap-2">
                                    <a class="page-item pagination-prev disabled" href="#"> Previous
                                    </a>
                                    <ul class="pagination listjs-pagination mb-0"></ul>
                                    <a class="page-item pagination-next" href="#"> Next
                                    </a>
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
@endsection

