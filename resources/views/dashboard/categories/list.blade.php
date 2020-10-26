@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div id="flex-tree-container"></div>

    <div class="buttons clearfix">
        <h2 class="float-left mb-0">دسته بندی ها</h2>
        <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#createCat"><i class="fa fa-plus mr-2"></i>افزودن دسته بندی</button>
    </div>
    <hr>
    <table class="table table-bordered table-hover" id="data-table">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">عنوان</th>
                <th scope="col">مادر</th>
                <th scope="col">تاریخ ایجاد</th>
                <th scope="col"></th>
            </tr>
        </thead>
    </table>
</div>
<div class="modal fade" id="createCat" tabindex="-1" role="dialog" aria-labelledby="createCatId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ایجاد دسته بندی جدید</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="createCatForm">
                    <div class="form-group">
                      <label for="title">نام</label>
                      <input type="text"
                        class="form-control" name="title" id="title" placeholder="نام دسته بندی">
                    </div>
                    <div class="form-group">
                    <label for="parent">مادر</label>
                      <select class="form-control" name="parent" id="parent">
                        <option value=""></option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                    <div class="imageupload upload-image card card-info">
                        <div class="card-header clearfix">
                            <h4 class="card-title float-left"><small>آپلود عکس</small></h4>
                        </div>
                        <div class="file-tab card-body">
                            <label class="btn btn-info btn-file m-0">
                                <span>انتخاب</span>
                                <input type="file" name="image">
                            </label>
                            <button type="button" class="btn btn-info">حذف</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                <button type="button" id="createCatSubmit" class="btn btn-primary">ایجاد دسته بندی</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editCat" tabindex="-1" role="dialog" aria-labelledby="editCatId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ویرایش دسته بندی</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="editCatForm">
                    <input type="hidden" name="id" class="dyno-id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="title">نام</label>
                            <input type="text"
                                class="form-control dyno-title" name="title" id="title" placeholder="نام دسته بندی">
                            </div>
                            <div class="form-group">
                            <label for="parent">مادر</label>
                            <select class="form-control dyno-parent" name="parent_id" id="parent">
                                <option value=""></option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="form-group">
                            <div class="imageupload upload-image card card-info">
                                <div class="card-header clearfix">
                                    <h4 class="card-title float-left"><small>آپلود عکس جدید</small></h4>
                                </div>
                                <div class="file-tab card-body">
                                    <label class="btn btn-info btn-file m-0">
                                        <span>انتخاب</span>
                                        <input type="file" name="image">
                                    </label>
                                    <button type="button" class="btn btn-info">حذف</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group dyno-image text-center">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                <button type="button" id="editCatSubmit" class="btn btn-primary">ذخیره دسته بندی</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#editCatSubmit').on('click', function () {
        $('#editCatForm').submit();
    });
    $('#createCatSubmit').on('click', function () {
        $('#createCatForm').submit();
    });

    $('body').on('click', '.deleteCat', function () {
        if ( confirm('آیا از تصمیم خود مطمئن هستید؟') ) {
            axios.post('{{ route('categoryDestroy') }}', {
                'id': $(this).data('cat-id')
            })
            .then(res => {
                $('#data-table').DataTable().ajax.reload();
                location.reload();
            })
            .catch(err => {
                $('#data-table').DataTable().ajax.reload();
                location.reload();
            })
        }
    });

    $('body').on('click', '.editCat', function () {
        var name = $(this).data('cat-name'),
            id = $(this).data('cat-id'),
            image = $(this).data('cat-image'),
            parent = $(this).data('cat-parent');

        $('.dyno-title').val(name);
        $('.dyno-id').val(id);
        if ( image ) {
            $('.dyno-image').html('<img src="/' + image + '" width="250" height="250" class="rounded m-2">');
        } else {
            $('.dyno-image').html('');
        }

        $('.dyno-parent').val(parent);

        $('#editCat').modal('show');
    });

    $('#createCatForm').on('submit', function (e) {
        e.preventDefault();
        axios.post('{{ route('categoryCreate') }}', new FormData( $('#createCatForm')[0] ) )
        .then(res => {
            $('#data-table').DataTable().ajax.reload();
            $('#createCat').modal('hide');
            $('#createCatForm').trigger('reset');
            alert('با موفقیت انجام شد.');
            $('#createCat').imageupload('reset');
            location.reload();
        })
        .catch(err => {
            $('#createCat').modal('hide');
            $('#createCatForm').trigger('reset')
            alert('دسته بندی قبلا ایجاد شده است.');
            $('#createCat').imageupload('reset');
        })    
    });

    $('#editCatForm').on('submit', function (e) {
        e.preventDefault();
        axios.post('{{ route('categoryUpdate') }}', new FormData( $('#editCatForm')[0] ) )
        .then(res => {
            $('#data-table').DataTable().ajax.reload();
            $('#editCat').modal('hide');
            $('#editCatForm').trigger('reset');
            alert('با موفقیت انجام شد.');
            $('#editCat').imageupload('reset');
            location.reload();
        })
        .catch(err => {
            $('#editCat').modal('hide');
            $('#editCatForm').trigger('reset')
            alert('دسته بندی قبلا ایجاد شده است.');
            $('#createCat').imageupload('reset');
        })    
    });

    $('#data-table').DataTable( {
        "ajax": '{{route('categoryIndex')}}',
        "processing": true,
        "serverSide": true,
        "order": [[ 3, "desc" ]],
        "language": {
            "url": "{{ asset('js/persian.json') }}"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title', render: function(data, type, row) {
                if ( row.image ) {
                    return '<img class="rounded-circle mr-2" hegiht="48" src="/' + row.image + '" width="48"><span>' + data + ' </span>';
                }

                return data;
            } },
            { data: 'parent', name: 'parent' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', sortable: false },
        ]
    } );
} );
</script>
@endsection