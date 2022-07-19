@extends('layout.pagelayout')
@section('content')
<div class="mx-auto col-md-10 p-3">
    <a href="/" class=" mb-2 btn btn-dark">Go Home</a>
    @if(session('error'))
    <p class="bg-danger p-2">{{ session('error')}} </p>
    @elseif(session('success'))
    <p class="bg-success p-2">{{ session('success')}}</p>
    @endif
    <table class="table table-dark table-stripped">
        <thead>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach($data as $key => $value)
            <tr>
                <td>{{ $value->name}}</td>
                <td>{{ $value->email }}</td>
                <td>{{ $value->phone }}</td>
                <td>
                    <a href="/accounts/{{ $value->id }}" class="btn btn-warning">Edit</a>
                    <form class="d-inline" action="/accounts/{{ $value->id }}" method="post">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection