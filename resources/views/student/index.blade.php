@extends('student.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h2>INFORMATION TECHNOLOGY-STATE POLYTECHNIC OF MALANG</h2>
            </div>
            <div class="float-right my-2">
                <a class="btn btn-success" href="{{ route('student.create') }}"> Input Student Data</a>
            </div>
            <div class="float-left my-2">
                <form action="{{ route('student.index') }}" method="GET" role="search">
                    <div class="input-group">
                        <span class="input-group-btn mr-5 mt-1">
                            <button class="btn btn-info" type="submit" title="Search student">
                                <span class="fas fa-search"></span>
                            </button>
                        </span>
                        <input type="text" class="form-control mr-2" name="term" placeholder="Search student" id="term">
                        <a href="{{ route('student.index') }}" class=" mt-1">
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="button" title="Refresh page">
                                    <span class="fas fa-sync-alt"></span>
                                </button>
                            </span>
                        </a>
                    </div>
                </form> 
            </div>
        </div>
    </div>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif
  <table class="table table-bordered">
    <tr>
    <th>Nim</th>
    <th>Name</th>
    <th>Date Of Birth</th>
    <th>Class</th>
    <th>Major</th>
    <th>Address</th>
    <th width="280px">Action</th>
    </tr>
    @foreach ($student as $mhs)
    <tr>

    <td>{{ $mhs ->nim }}</td>
    <td>{{ $mhs ->name }}</td>
    <td>{{ $mhs ->date_of_birth }}</td>
    <td>{{ $mhs ->class }}</td>
    <td>{{ $mhs ->major }}</td>
    <td>{{ $mhs ->address }}</td>
    <td>
    <form action="{{ route('student.destroy',['student'=>$mhs->nim]) }}" method="POST">

        <a class="btn btn-info" href="{{ route('student.show',$mhs->nim) }}">Show</a>

        <a class="btn btn-primary" href="{{ route('student.edit',$mhs->nim) }}">Edit</a>
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    </td>
    </tr>
    @endforeach
  </table>
  <div class="pagination">
    {!! $student->links() !!}

@endsection
