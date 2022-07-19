@extends('layout.pagelayout')
@section('content')
<div class="mx-auto col-md-5 p-3">
    <a href="/" class=" mb-2 btn btn-dark">Go Home</a>
    <div class="card">
        <div class="card-header">
            <h4 class="">Register account</h4>
        </div>
        <div class="card-body">
            @if(session('error'))
            <p class="bg-danger p-2">{{ session('error')}} </p>
            @elseif(session('success'))
            <p class="bg-success p-2">{{ session('success')}}</p>
            @endif
            <form class="" action="/register" method="post">
                @csrf
                <div class="form-group">
                    <label class="">Name</label>
                    <input type="text" class="form-control" value="{{ old('name') }}" name="name" />
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="">Email</label>
                    <input type="email" value="{{ old('email') }}" class="form-control" name="email" />
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="">Phone number</label>
                    <input type="text" class="form-control" value="{{ old('phone') }}" name="phone" />
                    @error('phone')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection