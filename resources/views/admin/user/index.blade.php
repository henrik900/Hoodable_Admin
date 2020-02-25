@extends('admin.layouts.app')

@section('styles')
  <link rel="stylesheet" href="{{asset('public/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Users</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- Info boxes -->
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">User List</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>User Type</th>
                  <th>Upgraded</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>DOB</th>
                  <th>Verified</th>
                  <th>Active</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($users as $user)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td><span class="badge badge-{{$user->user_type == 0 ? 'light' : 'dark'}}">{{$user->user_type == 0 ? 'USER' : 'AGENT'}}</span></td>
                  <td><span class="badge badge-{{$user->upgrade == 0 ? 'warning' : 'primary'}}">{{$user->upgrade == 0 ? 'BASIC' : 'PRO'}}</span></td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->phone}}</td>
                  <td>{{$user->date_of_birth}}</td>
                  <td>
                    <span class="badge badge-{{$user->verified == 0 ? 'danger' : 'primary'}}">{{$user->verified == 0 ? 'Not-Verified' : 'Verified'}}</span>
                  </td>
                  <td>
                    @php
                    $btnColor = ($user->active == 1) ? 'btn-success' : 'btn-danger';
                    $status = ($user->active == 1) ? 'Active' : 'Inactive';
                    @endphp
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm {{$btnColor}}">
                        {{$status}}
                      </button>
                      <button type="button" class="btn btn-sm {{$btnColor}} dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <div class="dropdown-menu" role="menu" x-placement="bottom-start"
                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(68px, 38px, 0px);">
                        <a class="dropdown-item" href="#">Active</a>
                        <a class="dropdown-item" href="#">Inactive</a>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="btn-group btn-group-sm">
                      <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                      {{-- <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a> --}}
                    </div>
                  </td>
                </tr>
                @empty
                @endforelse
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.row -->
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('scripts')
<script src="{{asset('public/admin/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('public/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script>
  $(function () {
    $('#dataTable').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
@endsection