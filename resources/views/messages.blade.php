@extends('layouts.app')

@section('content')
<div class="container mt-4">
<h3>پیام ها</h3>
<hr>
@if ( $messages->isNotEmpty() )
<div class="row">
@foreach ($messages as $message)
<div class="col-md-6">
<div class="bg-light shadow p-4 mb-4">
    <h4>{{ $message->title }}</h4>
    <p class="m-0">{{ $message->description }}</p>
</div>
</div>
@endforeach
</div>
{{ $messages->links() }}
@else
<div class="alert alert-info" role="alert">
    <p class="m-0">پیامی وجود ندارد.</p>
</div>
@endif
</div>
@endsection