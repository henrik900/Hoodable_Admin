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
          <h1 class="m-0 text-dark">Requests</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Requests</li>
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
            <h3 class="card-title">Upgrade Requests</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Status</th>
                  <th>Upgrade Code</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($requests as $request)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$request->user->name}}</td>
                  <td>{{$request->user->email}}</td>
                  <td>{{$request->user->phone}}</td>
                  <td><span class="badge badge-{{$request->request_status == 'pending' ? 'info' : $request->request_status == 'processed' ? 'warning' : 'primary'}}">{{($request->request_status == 'pending') ? 'Pending' : ($request->request_status == 'processed') ? 'Processed' : 'finished'}}</span></td>
                  <td>{{$request->upgrade_code}}</td>
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