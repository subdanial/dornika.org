@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div id="flex-tree-container"></div>

    <div class="buttons clearfix">
        <h2 class="float-left mb-0">مشتریان</h2>
    </div>
    <hr>
    <table class="table table-bordered table-hover" id="data-table">
        <thead class="thead-light">
            <tr>
                <th scope="col">کد</th>
                <th scope="col">عنوان</th>
                <th scope="col">سازنده</th>
                <th scope="col">تاریخ ایجاد</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr>
                <th>کد</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>
<div class="modal fade" id="editClient" tabindex="-1" role="dialog" aria-labelledby="editClientId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ویرایش مشتری</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="editClientForm">
                    <input type="hidden" name="id" class="dyno-id">
                    <div class="form-group">
                    <label for="name">نام</label>
                    <input type="text"
                        class="form-control dyno-name" name="name" id="name" placeholder="نام مشتری">
                    </div>
                    <div class="form-group">
                    <label for="phone">تلفن</label>
                    <input type="text"
                        class="form-control dyno-phone" name="phone" id="phone" placeholder="تلفن مشتری">
                    </div>
                    <div class="form-group">
                        <label for="address">آدرس مشتری</label>
                        <textarea class="form-control dyno-address" name="address" id="address" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                <button type="button" id="editClientSubmit" class="btn btn-primary">ذخیره مشتری</button>
            </div>
        </div>
    </div>
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
    $('#editClientSubmit').on('click', function () {
        $('#editClientForm').submit();
    });
    $('#createClientSubmit').on('click', function () {
        $('#createClientForm').submit();
    });

    $('body').on('click', '.deleteClient', function () {
        if ( confirm('آیا از تصمیم خود مطمئن هستید؟') ) {
            axios.post('{{ route('clientDestroy') }}', {
                'id': $(this).data('client-id')
            })
            .then(res => {
                $('#data-table').DataTable().ajax.reload();
            })
            .catch(err => {
                $('#data-table').DataTable().ajax.reload();
            })
        }
    });

    $('body').on('click', '.editClient', function () {
        var name = $(this).data('client-name'),
            id = $(this).data('client-id'),
            phone = $(this).data('client-phone'),
            address = $(this).data('client-address');

        $('.dyno-name').val(name);
        $('.dyno-phone').val(phone);
        $('.dyno-id').val(id);
        $('.dyno-address').val(address);
        $('#editClient').modal('show');
    });

    $('#editClientForm').on('submit', function (e) {
        e.preventDefault();
        axios.post('{{ route('clientUpdate') }}', new FormData( $('#editClientForm')[0] ) )
        .then(res => {
            $('#data-table').DataTable().ajax.reload();
            $('#editClient').modal('hide');
            $('#editClientForm').trigger('reset');
            alert('با موفقیت انجام شد.');
        })
        .catch(err => {
            $('#editClient').modal('hide');
            $('#editClientForm').trigger('reset')
            alert('خطا.');
        })    
    });

    $('#data-table tfoot th').each( function () {
        var title = $(this).text();
        if ( title != '' ) {
            $(this).html( '<input type="text" style="width: 100px" class="border p-1 form-control form-control-sm search-id" placeholder="جستجو '+title+'" />' );
        }
    } );

    var table = $('#data-table').DataTable( {
        "ajax": '{{route('clientIndex')}}',
        "processing": true,
        "serverSide": true,
        "order": [[ 3, "desc" ]],
        "language": {
            "url": "{{ asset('js/persian.json') }}"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name', render: function(data, type, row) {
                return data;
            } },
            { data: 'user', name: 'user', render: function(data, type, row) {
                return data;
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
</script>
@endsection