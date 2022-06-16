@extends('phonebooks.layout')
@section('content')
    <div class="container">
      <div class='row justify-content-between'>
        <div class='col-md-4'>
          <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Import CSV
          </button>
          <button type="button" onclick="clearFilter()" class="btn btn-primary mt-2">
            View All
          </button>
        </div>
        <div class="col-md-4 mt-2">
          <form action="{{ url('phonebook') }}" method="get">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search by Name or Mobile" aria-describedby="button-addon2" name="search" value="{{ $search }}">
              <button class="btn btn-outline-primary" type="submit" id="btnSearch">Search</button>
            </div>
          </form>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Import CSV</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{ url('phonebook') }}" method="post" enctype="multipart/form-data" id="formImport">
                {!! csrf_field() !!}
                <label for="">File Upload</label>
                <input type="file" class="form-control" name="file" id="file" accept=".csv, text/csv" required>
                <table class='table table-responsive mt-2'>
                  <thead>
                    <td>Column Headers</td>
                    <td>New Value</td>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Title</td>
                      <td>
                        <select name="header[]" class="form-control">
                          @foreach ($headers as $item)
                            <option value="{{ $item->id-1 }}" {{ $item->name == 'title' ? 'selected' : '' }}>{{ $item->name }}</option>
                          @endforeach
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>First Name</td>
                      <td>
                        <select name="header[]" class="form-control">
                          @foreach ($headers as $item)
                            <option value="{{ $item->id-1 }}" {{ $item->name == 'firstname' ? 'selected' : '' }}>{{ $item->name }}</option>
                          @endforeach
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>Last Name</td>
                      <td>
                        <select name="header[]" class="form-control">
                          @foreach ($headers as $item)
                            <option value="{{ $item->id-1 }}" {{ $item->name == 'lastname' ? 'selected' : '' }}>{{ $item->name }}</option>
                          @endforeach
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>Mobile Number</td>
                      <td>
                        <select name="header[]" class="form-control">
                          @foreach ($headers as $item)
                            <option value="{{ $item->id-1 }}" {{ $item->name == 'mobile' ? 'selected' : '' }}>{{ $item->name }}</option>
                          @endforeach
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>Company Name</td>
                      <td>
                        <select name="header[]"class="form-control">
                          @foreach ($headers as $item)
                            <option value="{{ $item->id-1 }}" {{ $item->name == 'company' ? 'selected' : '' }}>{{ $item->name }}</option>
                          @endforeach
                        </select>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class='text-right'>
                  <button type="submit" id='btnImport' class="btn btn-primary mt-2">Import</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-5">
          <div class="col-md-12">
              <div class="card">
                  <div class="card-header">
                      <h2>List of Phonebooks</h2>
                  </div>
                  <div class="card-body">
                      <div class="table-responsive">
                          <table class="table table-striped" id="phonebookTable">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Title</th>
                                      <th>Firstname</th>
                                      <th>Lastname</th>
                                      <th>Mobile</th>
                                      <th>Company</th>
                                      <th>Actions</th>
                                  </tr>
                              </thead>
                              <tbody>
                              @if ($phonebooks->count() == 0) 
                                <tr>
                                  <td colspan="7" class="text-center"> No record found!</td>
                                </tr>
                              @else
                                @foreach($phonebooks as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->firstname }}</td>
                                    <td>{{ $item->lastname }}</td>
                                    <td>{{ $item->mobile }}</td>
                                    <td>{{ $item->company }}</td>

                                    <td>
                                        <a href="{{ url('/phonebook/' . $item->id . '/edit') }}" title="Edit Phonebook"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                        <form method="POST" action="{{ url('/phonebook' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Phonebook" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                              @endif
                              </tbody>
                          </table>
                      </div>

                  </div>
              </div>
          </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
    <script>
      $('#btnImport').click(function(e) {
        e.preventDefault();
        var file = $('#file');
        /* getting file extenstion .csv */
        var extension = file.val().substr(file.val().lastIndexOf("."));
        if (extension != '.csv') {
          alert('File must be csv extension');
          return false;
        }
        $('#formImport').submit();
      })

      function clearFilter() {
        window.location.href = '/phonebook';
      }
    </script>
@endsection