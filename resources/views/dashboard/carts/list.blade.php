@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div id="flex-tree-container"></div>

    <div class="buttons clearfix">
        <h2 class="float-left mb-0">سفارشات</h2>
    </div>
    <hr>
    <table class="table table-bordered table-hover" id="data-table">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">ویزیتور</th>
                <th scope="col">مشتری</th>
                <th scope="col">قیمت کل</th>
                <th scope="col">تکمیل</th>
                <th scope="col">تاریخ ایجاد</th>
                <th scope="col">عملیات</th>
            </tr>
        </thead>
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
$(document).ready(function() {
    $('#editClientSubmit').on('click', function () {
        $('#editClientForm').submit();
    });
    $('#createClientSubmit').on('click', function () {
        $('#createClientForm').submit();
    });

    $('body').on('click', '.deleteCart', function () {
        if ( confirm('آیا از تصمیم خود مطمئن هستید؟') ) {
            axios.post('{{ route('cartDestroy') }}', {
                'id': $(this).data('cart-id')
            })
            .then(res => {
                $('#data-table').DataTable().ajax.reload();
            })
            .catch(err => {
                $('#data-table').DataTable().ajax.reload();
            })
        }
    });

    $('body').on('click', '.changeDelivery', function () {
        if ( confirm('آیا از تصمیم خود مطمئن هستید؟') ) {
            axios.post('{{ route('changeDelivery') }}', {
                'id': $(this).data('cart-id')
            })
            .then(res => {
                $('#data-table').DataTable().ajax.reload();
            })
            .catch(err => {
                $('#data-table').DataTable().ajax.reload();
            })
        }
    });

    $('body').on('click', '.returnCart', function () {
        if ( confirm('اگر مایلید این سفارش به منظور ویرایش به سبد خرید ویزیتور بازگردد؛ روی ok کلیک کنید.') ) {
            axios.post('{{ route('cartReturn') }}', {
                'id': $(this).data('cart-id')
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
            address = $(this).data('client-address');

        $('.dyno-name').val(name);
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

    $('#data-table').DataTable( {
        "ajax": '{{route('cartIndex')}}',
        "processing": true,
        "serverSide": true,
        "order": [[ 4, "desc" ]],
        "language": {
            "url": "{{ asset('js/persian.json') }}"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'user', name: 'user', render: function(data, type, row) {
                return data;
            } },
            { data: 'client', name: 'client', render: function(data, type, row) {
                return data;
            } },
            { data: 'price', name: 'price', render: function(data, type, row) {
                return data + ' تومان';
            } },
            { data: 'delivery', name: 'delivery', render: function(data, type, row) {
                if ( data == 1 ) {
                    return '<span class="text-success"><i class="fa fa-check"></i> تکمیل شد</span>';
                } else {
                    return '<span class="text-danger"><i class="fa fa-times"></i> ارسال نشده</span>';
                }
            } },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', sortable: false },
        ]
    } );
} );
</script>
@endsection
