@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="clearfix">
        <h5 class="mb-3 float-left">افزودن کالا جدید</h5>
        <a class="btn btn-info float-right" href="{{ url()->previous() }}" role="button">بازگشت</a>
    </div>
    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <table class="table table-striped mt-4">
        <tr>
            <td>نام کالا</td>
            <td>
            <div class="form-group">
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="نام" value="{{ old('title') }}">
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>توضیح کالا</td>
            <td>
            <div class="form-group">
                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="توضیح" value="{{ old('description') }}">
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>قیمت پایه</td>
            <td>
            <div class="form-group">
                <input type="text" name="price_1" class="form-control @error('price_1') is-invalid @enderror" placeholder="قیمت" value="{{ old('price_1') }}">
                @error('price_1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>قیمت یک (بین 1 تا 5 کارتن)</td>
            <td>
            <div class="form-group">
                <input type="text" name="price_2" class="form-control @error('price_2') is-invalid @enderror" placeholder="قیمت" value="{{ old('price_2') }}">
                @error('price_2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>قیمت دو (بین 6 تا 10 کارتن)</td>
            <td>
            <div class="form-group">
                <input type="text" name="price_3" class="form-control @error('price_3') is-invalid @enderror" placeholder="قیمت" value="{{ old('price_3') }}">
                @error('price_3')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>قیمت سه (بیشتر از 10 کارتن)</td>
            <td>
            <div class="form-group">
                <input type="text" name="price_4" class="form-control @error('price_4') is-invalid @enderror" placeholder="قیمت" value="{{ old('price_4') }}">
                @error('price_4')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>قیمت مصرف کننده</td>
            <td>
            <div class="form-group">
                <input type="text" name="consumer" class="form-control @error('consumer') is-invalid @enderror" placeholder="قیمت مصرف کننده" value="{{ old('consumer') }}">
                @error('consumer')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>تعداد در کارتن</td>
            <td>
            <div class="form-group">
                <input type="text" name="number_in_box" class="form-control @error('number_in_box') is-invalid @enderror" placeholder="تعداد در جعبه" value="{{ old('number_in_box') }}">
                @error('number_in_box')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>موجودی انبار</td>
            <td>
            <div class="form-group">
                <input type="text" name="available" class="form-control @error('available') is-invalid @enderror" placeholder="موجودی" value="{{ old('available') }}">
                @error('available')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>کمیسیون</td>
            <td>
            <div class="form-group">
                <input type="text" name="commission" class="form-control @error('commission') is-invalid @enderror" placeholder="کمیسیون" value="{{ old('commission') }}">
                @error('commission')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>تصویر</td>
            <td>
            <div class="form-group">
            <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror">
            @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>دسته بندی</td>
            <td> 
                <div class="form-group">
                <div id="cat-container"></div>
                @error('category_id')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </td>
        </tr>
    </table>
    <button class="btn btn-orange mb-4">ثبت کالا</button>    
    </form>    
</div>

@endsection
@section('js')
<script>
$(function() {
    $('#cat-container').flexTree({
        // items: myData,
        items: jQuery.parseJSON('{!! $categories !!}'),
        type: 'radio',
        debug: true,
        name: 'category_id',
        collapsed: true,
    });
});
</script>
@endsection