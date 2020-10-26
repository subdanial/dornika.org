@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div id="flex-tree-container"></div>

    <div class="buttons clearfix">
        <h2 class="float-left mb-0">مشتریان ثبت شده</h2>
        <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#createClient"><i class="fa fa-plus mr-2"></i>افزودن مشتری</button>
    </div>
    <hr>
    <table class="table table-bordered table-hover" id="data-table">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">عنوان</th>
                <th scope="col"></th>
            </tr>
        </thead>
    </table>
</div>
<div class="modal fade" id="createClient" tabindex="-1" role="dialog" aria-labelledby="createClientId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ایجاد مشتری جدید</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="createClientForm">
                    <div class="form-group">
                        <label for="name">نام</label>
                        <input type="text"
                        class="form-control" name="name" id="name" placeholder="نام مشتری">
                    </div>
                    <div class="form-group">
                        <label for="phone">تلفن</label>
                        <input type="text"
                        class="form-control" name="phone" id="phone" placeholder="تلفن مشتری">
                    </div>
                    <div class="form-group">
                        <label for="address">آدرس مشتری</label>
                        <textarea class="form-control" name="address" id="address" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                <button type="button" id="createClientSubmit" class="btn btn-primary">ایجاد مشتری</button>
            </div>
        </div>
    </div>
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
$(document).ready(function() {
    $('#editClientSubmit').on('click', function () {
        $('#editClientForm').submit();
    });
    $('#createClientSubmit').on('click', function () {
        $('#createClientForm').submit();
    });

    $('#createClientForm').on('submit', function (e) {
        e.preventDefault();
        axios.post('{{ route('userClientsStore') }}', new FormData( $('#createClientForm')[0] ) )
        .then(res => {
            $('#data-table').DataTable().ajax.reload();
            $('#createClient').modal('hide');
            $('#createClientForm').trigger('reset');
            alert('با موفقیت انجام شد.');
        })
        .catch(err => {
            $('#createClient').modal('hide');
            $('#createClientForm').trigger('reset')
            alert('خطا.');
        })    
    });

    $('body').on('click', '.deleteClient', function () {
        if ( confirm('آیا از تصمیم خود مطمئن هستید؟') ) {
            axios.post('{{ route('userClientsDestroy') }}', {
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
        $('.dyno-id').val(id);
        $('.dyno-phone').val(phone);
        $('.dyno-address').val(address);
        $('#editClient').modal('show');
    });

    $('#editClientForm').on('submit', function (e) {
        e.preventDefault();
        axios.post('{{ route('userClientsUpdate') }}', new FormData( $('#editClientForm')[0] ) )
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
        "ajax": '{{route('userClientsIndex')}}',
        "processing": true,
        "serverSide": true,
        "language": {
            "url": "{{ asset('js/persian.json') }}"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name', render: function(data, type, row) {
                return data;
            } },
            { data: 'action', name: 'action', sortable: false },
        ]
    } );
} );
</script>
@endsection