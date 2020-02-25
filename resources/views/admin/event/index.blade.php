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
          <h1 class="m-0 text-dark">Events</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Events</li>
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
            <h3 class="card-title">Event List</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Spot</th>
                  <th>Created By</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Start Date/Time</th>
                  <th>End Date/Time</th>
                  <th>Location</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($events as $event)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$event->spot->spot_name}}</td>
                  <td>{{$event->user->name}}</td>
                  <td>{{$event->name}}</td>
                  <td>{{$event->description}}</td>
                  <td>{{$event->start_date}}</td>
                  <td>{{$event->end_date}}</td>
                  <td>{{$event->location}}</td>
                  {{-- <td>
                    <div class="btn-group btn-group-sm">
                      <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                      <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                    </div>
                  </td> --}}
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