@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div id="flex-tree-container"></div>

    <div class="buttons clearfix">
        <h2 class="float-left mb-0">پیام ها</h2>
        <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#createMessage"><i class="fa fa-plus mr-2"></i>افزودن پیام</button>
    </div>
    <hr>
    <table class="table table-bordered table-hover" id="data-table">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">عنوان</th>
                <th scope="col">تاریخ ایجاد</th>
                <th scope="col"></th>
            </tr>
        </thead>
    </table>
</div>
<div class="modal fade" id="createMessage" tabindex="-1" role="dialog" aria-labelledby="createMessageId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ایجاد پیام جدید</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="createMessageForm">
                    <div class="form-group">
                      <label for="title">نام</label>
                      <input type="text"
                        class="form-control" name="title" id="title" placeholder="نام پیام">
                    </div>
                    <div class="form-group">
                      <label for="description">متن پیام</label>
                      <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                <button type="button" id="createMessageSubmit" class="btn btn-primary">ایجاد پیام</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editMessage" tabindex="-1" role="dialog" aria-labelledby="editMessageId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ویرایش پیام</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="editMessageForm">
                    <input type="hidden" name="id" class="dyno-id">
                    <div class="form-group">
                    <label for="title">نام</label>
                    <input type="text"
                        class="form-control dyno-title" name="title" id="title" placeholder="نام پیام">
                    </div>
                    <div class="form-group">
                        <label for="description">متن پیام</label>
                        <textarea class="form-control dyno-description" name="description" id="description" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                <button type="button" id="editMessageSubmit" class="btn btn-primary">ذخیره پیام</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#editMessageSubmit').on('click', function () {
        $('#editMessageForm').submit();
    });
    $('#createMessageSubmit').on('click', function () {
        $('#createMessageForm').submit();
    });

    $('body').on('click', '.deleteMessage', function () {
        if ( confirm('آیا از تصمیم خود مطمئن هستید؟') ) {
            axios.post('{{ route('messageDestroy') }}', {
                'id': $(this).data('message-id')
            })
            .then(res => {
                $('#data-table').DataTable().ajax.reload();
            })
            .catch(err => {
                $('#data-table').DataTable().ajax.reload();
            })
        }
    });

    $('body').on('click', '.editMessage', function () {
        var title = $(this).data('message-title'),
            id = $(this).data('message-id'),
            description = $(this).data('message-description');

        $('.dyno-title').val(title);
        $('.dyno-id').val(id);
        $('.dyno-description').val(description);
        $('#editMessage').modal('show');
    });

    $('#createMessageForm').on('submit', function (e) {
        e.preventDefault();
        axios.post('{{ route('messageCreate') }}', new FormData( $('#createMessageForm')[0] ) )
        .then(res => {
            $('#data-table').DataTable().ajax.reload();
            $('#createMessage').modal('hide');
            $('#createMessageForm').trigger('reset');
            alert('با موفقیت انجام شد.');
        })
        .catch(err => {
            $('#createMessage').modal('hide');
            $('#createMessageForm').trigger('reset')
            alert('خطا.');
        })    
    });

    $('#editMessageForm').on('submit', function (e) {
        e.preventDefault();
        axios.post('{{ route('messageUpdate') }}', new FormData( $('#editMessageForm')[0] ) )
        .then(res => {
            $('#data-table').DataTable().ajax.reload();
            $('#editMessage').modal('hide');
            $('#editMessageForm').trigger('reset');
            alert('با موفقیت انجام شد.');
        })
        .catch(err => {
            $('#editMessage').modal('hide');
            $('#editMessageForm').trigger('reset')
            alert('خطا.');
        })    
    });

    $('#data-table').DataTable( {
        "ajax": '{{route('messageIndex')}}',
        "processing": true,
        "serverSide": true,
        "order": [[ 2, "desc" ]],
        "language": {
            "url": "{{ asset('js/persian.json') }}"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title', render: function(data, type, row) {
                return data;
            } },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', sortable: false },
        ]
    } );
} );
</script>
@endsection