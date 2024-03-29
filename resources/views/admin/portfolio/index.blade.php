@extends('admin/app')

@section('head-content')
<link rel="stylesheet" href="{{asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">

@endsection

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Portfolio</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Portfolio</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-header">
            <a class="btn btn-primary " href="{{route('portfolio.create') }}">
              Add new Portfolio
            </a>
          </div>

          <div class="card-body">
            <table id="portfolio" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Image</th>
                <th>Category</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
                @foreach($portfolios as $portfolio)

                <tr>
                  <td>{{ $loop->index +1 }}</td>
                  <td>{{$portfolio->name}}</td>

                  <td>
                    <img src="{{ URL::to('/')}}/images/{{ $portfolio->image}}" class="img-thumbnail" width="75"/>
                  </td>

                  <td>{{$portfolio->category['name'] }}</td>

                  <td id="stats" class="project-state">
                    @if($portfolio->status =='0')
                  <span class="badge badge-danger"> Unpost</span>
                    @else
                  <span class="badge badge-success">Post</span>
                    @endif
                  </td>

                  <td class="project-actions text-right">
                    <a class="btn-primary btn-sm" name="show" href="{{route('portfolio.show', $portfolio->id) }}" >
                        <i class="fas fa-folder">
                        </i>
                    </a>
                    <a class="btn-info btn-sm" name="edit" href="{{route('portfolio.edit', $portfolio->id) }}" >
                        <i class="fas fa-pencil-alt">
                        </i>
                      </a>


                      <form id="delete-form-{{ $portfolio->id }}" method="post" action="{{ route('portfolio.destroy',$portfolio->id) }}" style="display: none">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                      </form>
                      <a class="btn-danger btn-sm" href="" onclick="
                        if(confirm('Are you sure, You Want to delete this?'))
                          {
                            event.preventDefault();
                            document.getElementById('delete-form-{{ $portfolio->id }}').submit();
                          }
                          else{
                            event.preventDefault();
                          }">
                          <i class="fas fa-trash">
                          </i>
                      </a>
                  </td>
                </tr>
                @endforeach

              </tbody>

            </table>

          </div>
        <!-- /.card-body -->

        </div>
      </div>
    </div>
  </section>
</div>

@endsection

@section('footer-content')


      <script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
      <!-- Bootstrap 4 -->
      <script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
      <!-- DataTables -->

      <script src="{{asset('admin/plugins/datatables/jquery.dataTables.js')}}"></script>
      <script src="{{asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>

      <!-- AdminLTE App -->
      <script src="{{asset('admin/dist/js/adminlte.min.js')}}"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="{{asset('admin/dist/js/demo.js')}}"></script>

      <!-- page script -->
  <script>
    $(document).ready(function() {
      $('#portfolio').DataTable( {
        initComplete: function () {
          this.api().columns().every( function () {
            var column = this;
            var select = $('<select><option value=""></option></select>')
            .appendTo( $(column.footer()).empty() )
            .on( 'change', function () {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
              );

              column
              .search( val ? '^'+val+'$' : '', true, false )
              .draw();
            });

            column.data().unique().sort().each( function ( d, j ) {
             select.append( '<option value="'+d+'">'+d+'</option>' )
            } );
          } );
        }
      });
    });
  </script>
@endsection
