@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div id="flex-tree-container"></div>

    <div class="buttons clearfix">
        <h2 class="float-left mb-0">ویزیتور ها</h2>
        <a href="{{ route('visitors.create') }}" class="btn btn-info float-right"><i class="fa fa-plus mr-2"></i>افزودن ویزیتور</a>
    </div>
    <hr>
    <table class="table table-bordered table-hover" id="data-table">
        <thead class="thead-light">
            <tr>
                <th scope="col">کد</th>
                <th scope="col">نام</th>
                <th scope="col">نام کاربری</th>
                <th scope="col">ایمیل</th>
                <th scope="col">شماره موبایل</th>
                <th scope="col">تاریخ ایجاد</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot style="display: table-header-group;">
            <tr>
                <th>کد</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection

@section('js')
<script>
function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
};
$(document).ready(function() {
    $('#data-table tfoot th').each( function () {
        var title = $(this).text();
        if ( title != '' ) {
            $(this).html( '<input type="text" style="width: 100px" class="border p-1 form-control form-control-sm search-id" placeholder="جستجو '+title+'" />' );
        }
    } );

    var table = $('#data-table').DataTable( {
        "ajax": '{{route('userIndex')}}',
        "processing": true,
        "serverSide": true,
        "order": [[ 5, "desc" ]],
        "language": {
            "url": "{{ asset('js/persian.json') }}"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name', render: function(data, type, row) {
                if ( row.avatar ) {
                    return '<img class="rounded-circle mr-2" hegiht="48" src="' + row.avatar + '" width="48"><span>' + data + ' </span>';
                }

                return data;
            } },
            { data: 'username', name: 'username' },
            { data: 'email', name: 'email', render: function(data, type, row) {
                return data ? data : 'ثبت نشده';
            } },
            { data: 'mobile', name: 'mobile', render: function(data, type, row) {
                return data ? data : 'ثبت نشده';
            } },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', sortable: false },
        ]
    } );

    $( '.search-id' ).on( 'keyup change', debounce(function () {
        table
            .columns( 0 )
            .search( this.value )
            .draw();
    }, 300) );
} );



$(document).ready(function() {
    $('body').on('click', '.deleteUser', function () {
        
        axios.post('{{ route('userDestroy') }}', {
            'id': $(this).data('user-id')
        })
        .then(res => {
            $('#data-table').DataTable().ajax.reload();
        })
        .catch(err => {
            $('#data-table').DataTable().ajax.reload();
        })
    });
});
</script>
@endsection