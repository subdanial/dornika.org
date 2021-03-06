@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div id="flex-tree-container"></div>

    <div class="buttons clearfix">
        <h2 class="float-left mb-0">محصولات ها</h2>
        <a href="{{ route('products.create') }}" class="btn btn-info float-right"><i class="fa fa-plus mr-2"></i>افزودن محصول</a>
    </div>
    <hr>
    <table class="table table-bordered table-hover" id="data-table">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">عنوان</th>
                <th scope="col">دسته بندی</th>
                <th scope="col">موجودی</th>
                <th scope="col">تاریخ ایجاد</th>
                <th scope="col"></th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('body').on('click', '.deleteProduct', function () {
        
        axios.post('{{ route('productDestroy') }}', {
            'id': $(this).data('product-id')
        })
        .then(res => {
            $('#data-table').DataTable().ajax.reload();
        })
        .catch(err => {
            $('#data-table').DataTable().ajax.reload();
        })
    });

    $('#data-table').DataTable( {
        "ajax": '{{route('productIndex')}}',
        "processing": true,
        "serverSide": true,
        "order": [[ 4, "desc" ]],
        "language": {
            "url": "{{ asset('js/persian.json') }}"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title', render: function(data, type, row) {
                if ( row.image ) {
                    return '<img class="rounded-circle mr-2" hegiht="48" src="' + row.image + '" width="48"><span>' + data + ' </span>';
                }

                return data;
            } },
            { data: 'category', name: 'category' },
            { data: 'available', name: 'available' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', sortable: false },
        ]
    } );
} );
</script>
@endsection