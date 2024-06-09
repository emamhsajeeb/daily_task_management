
@extends('layouts.app',['user' => $user])

@section('members')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid" style="max-width: 100% !important;">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">All Members</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Team</a></li>
                                <li class="breadcrumb-item active">All Members</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-sm-4">
                            <div class="search-box">
                                <input type="text" class="form-control" id="searchMemberList" placeholder="Search for name or designation...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-sm-auto ms-auto">
                            <div class="list-grid-nav hstack gap-1">
                                <button class="btn btn-secondary addMembers-modal" data-bs-toggle="modal" data-bs-target="#addmemberModal"><i class="ri-add-fill me-1 align-bottom"></i> Add Members</button>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div>
                        <div id="teamlist">
                            <div class="team-list list-view-filter row" id="team-member-list">
                            </div>
                        </div>
                        <div class="py-4 mt-4 text-center" id="noresult" style="display: none;">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:72px;height:72px"></lord-icon>
                            <h5 class="mt-4">Sorry! No Result Found</h5>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="showAddEditModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0">

                                    <div class="modal-body">
                                        <form autocomplete="off" id="memberlist-form" class="needs-validation" novalidate>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <input type="hidden" id="memberid-input" class="form-control" value="">
                                                    <div class="px-1 pt-1">
                                                        <div class="modal-team-cover position-relative mb-0 mt-n4 mx-n4 rounded-top overflow-hidden">
                                                            <img src="assets/images/small/img-9.jpg" alt="" id="cover-img" class="img-fluid">

                                                            <div class="d-flex position-absolute start-0 end-0 top-0 p-3">
                                                                <div class="flex-grow-1">
                                                                    <h5 class="modal-title text-white" id="createMemberLabel">Add New Members</h5>
                                                                </div>
                                                                <div class="flex-shrink-0">
                                                                    <div class="d-flex gap-3 align-items-center">
                                                                        <div>
                                                                            <label for="cover-image-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Select Cover Image">
                                                                                <div class="avatar-xs">
                                                                                    <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                                                        <i class="ri-image-fill"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </label>
                                                                            <input class="form-control d-none" value="" id="cover-image-input" type="file" accept="image/png, image/gif, image/jpeg">
                                                                        </div>
                                                                        <button type="button" class="btn-close btn-close-white"  id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center mb-4 mt-n5 pt-2">
                                                        <div class="position-relative d-inline-block">
                                                            <div class="position-absolute bottom-0 end-0">
                                                                <label for="member-image-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select Member Image">
                                                                    <div class="avatar-xs">
                                                                        <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                                            <i class="ri-image-fill"></i>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                                <input class="form-control d-none" value="" id="member-image-input" type="file" accept="image/png, image/gif, image/jpeg">
                                                            </div>
                                                            <div class="avatar-lg">
                                                                <div class="avatar-title bg-light rounded-circle">
                                                                    <img src="assets/images/users/user-dummy-img.jpg" id="member-img" class="avatar-md rounded-circle h-auto" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="teammembersName" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="teammembersName" placeholder="Enter name"  required>
                                                        <div class="invalid-feedback">Please Enter a member name.</div>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="designation" class="form-label">Designation</label>
                                                        <input type="text" class="form-control" id="designation" placeholder="Enter designation" required>
                                                        <div class="invalid-feedback">Please Enter a designation.</div>
                                                    </div>
                                                    <input type="hidden" id="project-input" class="form-control" value="">
                                                    <input type="hidden" id="task-input" class="form-control" value="">

                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success" id="addNewMember">Add Member</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!--end modal-content-->
                            </div>
                            <!--end modal-dialog-->
                        </div>
                        <!--end modal-->

                        <!-- Modal -->
                        <div class="modal fade" id="showAddEditModals" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0">
                                    <div class="modal-body">
                                        <form autocomplete="off" id="memberlist-form" class="needs-validation" novalidate>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <input type="hidden" id="memberid-input" class="form-control" value="">
                                                    <div class="mb-3">
                                                        <label for="username" class="form-label">Username</label>
                                                        <input type="text" class="form-control" id="username" placeholder="Enter username" required>
                                                        <div class="invalid-feedback">Please enter a username.</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="deviceToken" class="form-label">Device Token</label>
                                                        <textarea class="form-control" id="deviceToken" placeholder="Enter device token" rows="3"></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="firstName" class="form-label">First Name</label>
                                                        <input type="text" class="form-control" id="firstName" placeholder="Enter first name">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="lastName" class="form-label">Last Name</label>
                                                        <input type="text" class="form-control" id="lastName" placeholder="Enter last name">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="phone" class="form-label">Phone</label>
                                                        <input type="tel" class="form-control" id="phone" placeholder="Enter phone" required>
                                                        <div class="invalid-feedback">Please enter a phone number.</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="email" placeholder="Enter email" required>
                                                        <div class="invalid-feedback">Please enter a valid email address.</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="joiningDate" class="form-label">Joining Date</label>
                                                        <input type="date" class="form-control" id="joiningDate">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Date of Birth</label>
                                                        <input type="date" class="form-control" id="dob">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="address" class="form-label">Address</label>
                                                        <textarea class="form-control" id="address" placeholder="Enter address" rows="3"></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="about" class="form-label">About</label>
                                                        <textarea class="form-control" id="about" placeholder="Enter about" rows="3"></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="password" class="form-label">Password</label>
                                                        <input type="password" class="form-control" id="password" placeholder="Enter password" required>
                                                        <div class="invalid-feedback">Please enter a password.</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="position" class="form-label">Position</label>
                                                        <input type="text" class="form-control" id="position" placeholder="Enter position">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="passport" class="form-label">Passport</label>
                                                        <input type="text" class="form-control" id="passport" placeholder="Enter passport">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nid" class="form-label">NID</label>
                                                        <input type="text" class="form-control" id="nid" placeholder="Enter NID">
                                                    </div>
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success" id="addNewMember">Add Member</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div><!-- end col -->
            </div>
            <!--end row-->
        </div><!-- container-fluid -->
    </div><!-- End Page-content -->

</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- removeFileItemModal -->
<div id="removeMemberModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-removeMemberModal"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this member ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="remove-item">Yes, Delete It!</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--end delete modal -->
<script>
const admin = {{$user->hasRole('admin') ? 'true' : 'false'}};

async function loadTeamData() {
    $.ajax({
        url: '{{ route('members') }}',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            let users = response.users;
            let incharges = response.incharges;
            let roles = response.roles;
            let teamMemberList = $('#team-member-list');

            teamMemberList.empty();

            users.forEach(function(user) {
                let roleOptions = '<option disabled selected>Select role</option>';
                let inchargeOptions = '<option disabled selected>Select Incharge</option>';

                roles.forEach(role => {
                    roleOptions += `<option data-role="${role}" ${user.role === role ? 'selected' : ''}>
                                    ${role === 'manager' ? 'Manager' :
                        role === 'admin' ? 'Admin' :
                            role === 'visitor' ? 'Visitor' :
                                role === 'se' ? 'Supervision Engineer' :
                                    role === 'qci' ? 'QC Inspector' :
                                        role === 'aqci' ? 'Assistant QCI' :
                                            ''}
                                </option>`;
                });

                incharges.forEach(incharge => {
                    inchargeOptions += `<option data-incharge="${incharge.user_name}" ${user.incharge === incharge.user_name ? 'selected' : ''}>${incharge.first_name}</option>`;
                });

                let memberImage = user.userImg ? `<img src="${user.userImg}" alt="" class="member-img img-fluid d-block rounded-circle" />` :
                    `<div class="avatar-title border bg-light text-primary rounded-circle text-uppercase">${user.firstName}</div>`;

                const teamMember = `
                <div class="col">
                    <div class="card team-box">
                        <div class="card-body p-4">
                            <div class="row align-items-center team-row">

                                <div class="col-lg-3 col">
                                    <div class="team-profile-img">
                                        <div class="avatar-lg img-thumbnail rounded-circle flex-shrink-0">${memberImage}</div>
                                        <div class="team-content">
                                            <h5 class="fs-16 mb-1">${user.firstName} ${user.lastName}</h5>
                                            <p class="text-muted member-designation mb-0">${user.position}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col">
                                    <div class="row text-muted text-center">
                                        ${admin ? `
                                        <div class="col-12">
                                            <select class="form-select user-role rounded-pill mb-3" aria-label="Default select example" data-user-id="${user.id}">
                                                ${roleOptions}
                                            </select>
                                        </div>
                                          ` : ''}
                                    </div>
                                </div>
                                <div class="col-lg-2 col">
                                    <div class="row text-muted text-center">
                                        ${admin ? `
                                        <div class="col-12">
                                            <select class="form-select user-incharge rounded-pill mb-3" aria-label="Default select example" data-user-id="${user.id}">
                                                ${inchargeOptions}
                                            </select>
                                        </div>
                                          ` : ''}
                                    </div>
                                </div>
                                <div class="col-lg-3 col">
                                    <div class="row text-muted text-center">
                                        ${user.role === 'admin' || user.role === 'manager' ? '' : `
                                        <div class="col-6">
                                            <h5 class="mb-1 tasks-num">${user.tasksCount}</h5>
                                            <p class="text-muted mb-0">Tasks</p>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="mb-1 tasks-num">${user.completedCount}</h5>
                                            <p class="text-muted mb-0">Completed</p>
                                        </div> `}
                                    </div>
                                </div>
                                <div class="col-lg-2 col">
                                    <div class="text-end dropdown">
                                        <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill fs-17"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button class="dropdown-item remove-list" data-remove-id="${user.id}">
                                                <i class="ri-delete-bin-5-line me-2 align-bottom text-muted"></i>View
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item edit-list" id="addEditModal" data-bs-toggle="modal" data-edit-id="${user.id}">
                                                <i class="ri-pencil-line me-2 align-bottom text-muted"></i>Edit
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item remove-list" data-remove-id="${user.id}">
                                                <i class="ri-delete-bin-5-line me-2 align-bottom text-muted"></i>Remove
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
                $(teamMember).hide().appendTo(teamMemberList).fadeIn();
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
    preloader.style.opacity = '0'; // Set opacity to 1 to make it visible
    preloader.style.visibility = 'hidden'; // Set visibility to visible
}




var editlist = !1;

function editMemberList() {
    var r;
    Array.from(document.querySelectorAll(".edit-list")).forEach(function (t) {
        t.addEventListener("click", function (e) {
            (r = t.getAttribute("data-edit-id")),
                (allmemberlist = allmemberlist.map(function (e) {
                    return (
                        e.id == r &&
                        ((editlist = !0),
                            (document.getElementById("createMemberLabel").innerHTML = "Edit Member"),
                            (document.getElementById("addNewMember").innerHTML = "Save"),
                            "" == e.memberImg ? (document.getElementById("member-img").src = "assets/images/users/team-dummy-img.jpg") : (document.getElementById("member-img").src = e.memberImg),
                            (document.getElementById("cover-img").src = e.coverImg),
                            (document.getElementById("memberid-input").value = e.id),
                            (document.getElementById("teammembersName").value = e.memberName),
                            (document.getElementById("designation").value = e.position),
                            (document.getElementById("project-input").value = e.projects),
                            (document.getElementById("task-input").value = e.tasks),
                            document.getElementById("memberlist-form").classList.remove("was-validated")),
                            e
                    );
                }));
        });
    });
}

function fetchIdFromObj(e) {
    return parseInt(e.id);
}

function findNextId() {
    var e, t;
    return 0 === allmemberlist.length ? 0 : (e = fetchIdFromObj(allmemberlist[allmemberlist.length - 1])) <= (t = fetchIdFromObj(allmemberlist[0])) ? t + 1 : e + 1;
}

function sortElementsById() {
    loadTeamData(
        allmemberlist.sort(function (e, t) {
            (e = fetchIdFromObj(e)), (t = fetchIdFromObj(t));
            return t < e ? -1 : e < t ? 1 : 0;
        })
    );
}
function removeItem() {
    var r;
    Array.from(document.querySelectorAll(".remove-list")).forEach(function (t) {
        t.addEventListener("click", function (e) {
            (r = t.getAttribute("data-remove-id")),
                document.getElementById("remove-item").addEventListener("click", function () {
                    var t;
                    (t = r),
                        loadTeamData(
                            (allmemberlist = allmemberlist.filter(function (e) {
                                return e.id != t;
                            }))
                        ),
                        document.getElementById("close-removeMemberModal").click();
                });
        });
    });
}

function memberDetailShow() {
    Array.from(document.querySelectorAll(".team-box")).forEach(function (a) {
        a.querySelector(".member-name").addEventListener("click", function () {
            var e = a.querySelector(".member-name h5").innerHTML,
                t = a.querySelector(".member-designation").innerHTML,
                r = a.querySelector(".member-img") ? a.querySelector(".member-img").src : "assets/images/users/team-dummy-img.jpg",
                m = a.querySelector(".team-cover img").src,
                i = a.querySelector(".projects-num").innerHTML,
                n = a.querySelector(".tasks-num").innerHTML;
            (document.querySelector("#member-overview .profile-img").src = r),
                (document.querySelector("#member-overview .team-cover img").src = m),
                (document.querySelector("#member-overview .profile-name").innerHTML = e),
                (document.querySelector("#member-overview .profile-designation").innerHTML = t),
                (document.querySelector("#member-overview .profile-project").innerHTML = i),
                (document.querySelector("#member-overview .profile-task").innerHTML = n);
        });
    });
}

document.querySelector("#member-image-input").addEventListener("change", function () {
    var e = document.querySelector("#member-img"),
        t = document.querySelector("#member-image-input").files[0],
        r = new FileReader();
    r.addEventListener(
        "load",
        function () {
            e.src = r.result;
        },
        !1
    ),
    t && r.readAsDataURL(t);
}),
    document.querySelector("#cover-image-input").addEventListener("change", function () {
        var e = document.querySelector("#cover-img"),
            t = document.querySelector("#cover-image-input").files[0],
            r = new FileReader();
        r.addEventListener(
            "load",
            function () {
                e.src = r.result;
            },
            !1
        ),
        t && r.readAsDataURL(t);
    }),
    Array.from(document.querySelectorAll(".addMembers-modal")).forEach(function (e) {
        e.addEventListener("click", function (e) {
            (document.getElementById("createMemberLabel").innerHTML = "Add New Members"),
                (document.getElementById("addNewMember").innerHTML = "Add Member"),
                (document.getElementById("teammembersName").value = ""),
                (document.getElementById("designation").value = ""),
                (document.getElementById("cover-img").src = "assets/images/small/img-9.jpg"),
                (document.getElementById("member-img").src = "assets/images/users/team-dummy-img.jpg"),
                document.getElementById("memberlist-form").classList.remove("was-validated");
        });
    }),
    (function () {
        "use strict";
        var e = document.querySelectorAll(".needs-validation");
        Array.prototype.slice.call(e).forEach(function (s) {
            s.addEventListener(
                "submit",
                function (e) {
                    var t, r, m, i, n, a, o, l;
                    s.checkValidity()
                        ? (e.preventDefault(),
                            (t = document.getElementById("teammembersName").value),
                            (r = document.getElementById("designation").value),
                            (m = document.getElementById("member-img").src),
                            (i = document.getElementById("cover-img").src),
                            (n = "assets/images/users/team-dummy-img.jpg" == m.substring(m.indexOf("/as") + 1) ? "" : m),
                            (a = t
                                .match(/\b(\w)/g)
                                .join("")
                                .substring(0, 2)),
                            "" === t || "" === r || editlist
                                ? "" !== t &&
                                "" !== r &&
                                editlist &&
                                ((o = 0),
                                    (o = document.getElementById("memberid-input").value),
                                    (allmemberlist = allmemberlist.map(function (e) {
                                        return e.id == o
                                            ? {
                                                id: o,
                                                coverImg: i,
                                                bookmark: e.bookmark,
                                                memberImg: m,
                                                nickname: a,
                                                memberName: t,
                                                position: r,
                                                projects: document.getElementById("project-input").value,
                                                tasks: document.getElementById("task-input").value,
                                            }
                                            : e;
                                    })),
                                    (editlist = !1))
                                : ((l = findNextId()), allmemberlist.push({ id: l, coverImg: i, bookmark: !1, memberImg: n, nickname: a, memberName: t, position: r, projects: "0", tasks: "0" }), sortElementsById()),
                            loadTeamData(allmemberlist),
                            document.getElementById("createMemberBtn-close").click())
                        : (e.preventDefault(), e.stopPropagation()),
                        s.classList.add("was-validated");
                },
                !1
            );
        });
    })();

var searchMemberList = document.getElementById("searchMemberList");
searchMemberList.addEventListener("keyup", function () {
    var e = searchMemberList.value.toLowerCase();
    t = e;
    var t,
        e = allmemberlist.filter(function (e) {
            return -1 !== e.memberName.toLowerCase().indexOf(t.toLowerCase()) || -1 !== e.position.toLowerCase().indexOf(t.toLowerCase());
        });
    0 == e.length
        ? ((document.getElementById("noresult").style.display = "block"), (document.getElementById("teamlist").style.display = "none"))
        : ((document.getElementById("noresult").style.display = "none"), (document.getElementById("teamlist").style.display = "block")),
        loadTeamData(e);
});

async function updateUserRole(userId, selectedRole) {
    $.ajax({
        url: '{{ route('updateUserRole') }}',
        method: 'POST',
        data: { userId: userId, selectedRole: selectedRole },
        success: function(response) {
            toastr.success(response.message);
        },
        error: function(xhr, status, error) {
            console.error('Error updating user role:', xhr.responseText);
        }
    });
}

async function updateUserIncharge(userId, selectedIncharge) {
    $.ajax({
        url: '{{ route('updateUserIncharge') }}',
        method: 'POST',
        data: { userId: userId, selectedIncharge: selectedIncharge },
        success: function(response) {
            toastr.success(response.message);
        },
        error: function(xhr, status, error) {
            console.error('Error updating user incharge:', xhr.responseText);
        }
    });
}

$(document).ready(async function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    await loadTeamData();

    $(document).on('change', '.user-role', async function () {
        var selectedRole = $(this).find(':selected').data('role'); // Get the selected role
        var userId = $(this).data('user-id'); // Get the user id from data attribute
        await updateUserRole(userId, selectedRole);
    });

    $(document).on('change', '.user-incharge', async function () {
        var selectedIncharge = $(this).find(':selected').data('incharge'); // Get the selected role
        var userId = $(this).data('user-id'); // Get the user id from data attribute
        await updateUserIncharge(userId, selectedIncharge);
    });

    $("#addEditModal").click(function () {
        $("#showAddEditModal").modal('show');
        // Extract user ID from data-edit-id attribute
        var userId = $(this).data('edit-id');

        console.log(userId);
    });
    // Add event listener to edit link
    // $('.edit-list').click(function(event) {
    //     event.preventDefault(); // Prevent default link behavior
    //
    //
    //
    //     // // Fetch user data corresponding to the userId (you need to implement this AJAX call)
    //     // $.ajax({
    //     //     url: '/getUserData', // Endpoint to fetch user data
    //     //     method: 'GET',
    //     //     data: { id: userId }, // Send user ID as parameter
    //     //     success: function(response) {
    //     //         // Populate modal fields with retrieved user data
    //     //         $('#teammembersName').val(response.first_name + ' ' + response.last_name);
    //     //         $('#designation').val(response.position);
    //     //         // Populate other fields similarly
    //     //     },
    //     //     error: function(xhr, status, error) {
    //     //         console.error(error);
    //     //     }
    //     // });
    // });
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

@endsection
