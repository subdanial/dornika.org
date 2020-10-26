@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <table class="table table-bordered" id="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>عنوان</th>
                <th>دسته بندی</th>
                <th>موجودی</th>
                <th>تاریخ ایجاد</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#data-table').DataTable( {
        "ajax": '{{route('productIndex')}}',
        "processing": true,
        "serverSide": true,
        "order": [[ 5, "desc" ]],
        "language": {
            "url": "{{ asset('js/persian.json') }}"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
            { data: 'category', name: 'category' },
            { data: 'available', name: 'available' },
            { data: 'created_at', name: 'created_at' }
        ]
    } );
} );
</script>
@endsection