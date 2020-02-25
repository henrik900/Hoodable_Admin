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
          <h1 class="m-0 text-dark">Spots</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Spots</li>
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
            <h3 class="card-title">Spot List</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Business Type</th>
                  <th>Category Type</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Phone</th>
                  <th>Website</th>
                  <th>Opening Date/Time</th>
                  <th>Location</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($spots as $spot)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$spot->businessType->name}}</td>
                  <td>{{$spot->category->name}}</td>
                  <td>{{$spot->spot_name}}</td>
                  <td>{{$spot->spot_description}}</td>
                  <td>{{$spot->spot_phone}}</td>
                  <td>{{$spot->spot_website}}</td>
                  <td>{{$spot->spot_opening_time}}</td>
                  <td>{{$spot->location}}</td>
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