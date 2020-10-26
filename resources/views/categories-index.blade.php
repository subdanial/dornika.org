@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="bg-light rounded p-3 shadow-sm my-3">
        <h3 class="mb-0">دسته بندی ها</h3>
        <small>یک دسته بندی انتخاب کنید</small>
    </div>
    <div class="row">
        @foreach ($categories as $cat)
            <a href="{{ route('categories', [$cat]) }}" class="col-6 col-sm-3 col-md-2" title="{{ $cat->title }}">
                <figure class="figure">
                <img src="{{ asset($cat->image) }}" alt="{{ $cat->title }}" alt="{{ $cat->title }}" class="figure-img img-fluid w-100 my-2 shadow rounded">
                <figcaption class="figure-caption text-center">{{ $cat->title }}</figcaption>
                </figure>
            </a>
        @endforeach
    </div>
</div>
@endsection