<div class="box-body">
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <p><i class="fa fa-fw fa-check"></i> {{ $error }}</p>
        @endforeach
    </div>
    @endif
    <table class="table table-bordered table-condensed">
        <tr class="row {{ $errors->has('title') ? 'has-error' : ''}}">
            <td class="col-md-4 col-lg-3">
                {!! Form::label('title', trans('theme::categories.meta_title'), ['class' => 'control-label label-required']) !!}
            </td>
            <td class="col-md-8 col-lg-9">
                {!! Form::text('title', null, ['class' => 'form-control input-sm', 'required' => 'required']) !!}
                {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
            </td>
        </tr>
        @if(isset($news))
        <tr class="row {{ $errors->has('slug') ? 'has-error' : ''}}">
            <td class="col-md-4 col-lg-3">
                {!! Form::label('slug', trans('theme::categories.slug'), ['class' => 'control-label']) !!}
            </td>
            <td class="col-md-8 col-lg-9">
                {!! Form::text('slug', null, ['class' => 'form-control input-sm']) !!}
                {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
            </td>
        </tr>
        @endif
        <tr class="row {{ $errors->has('parent_id') ? 'has-error' : ''}}">
            <td class="col-md-4 col-lg-3">
                {!! Form::label('parent_id', trans('theme::categories.parent'), ['class' => 'control-label']) !!}
            </td>
            <td class="col-md-8 col-lg-9">
                {!! Form::select('parent_id', $categories, null, ['class' => 'form-control input-sm select2']) !!}
            </td>
        </tr>
        <tr class="row {{ $errors->has('avatar') ? 'has-error' : ''}}">
            <td class="col-md-4 col-lg-3">
                {!! Form::label('avatar', trans('theme::categories.avatar'), ['class' => 'control-label']) !!}
            </td>
            <td class="col-md-8 col-lg-9">
                <div>
                    <div class="input-group inputfile-wrap ">
                        <input type="text" class="form-control input-sm" readonly>
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-danger btn-sm">
                                <i class=" fa fa-upload"></i>
                                {{ __('message.upload') }}
                            </button>
                            {!! Form::file('avatar', array_merge(['id'=>'image', 'class' => 'form-control input-sm', "accept" => "image/*"])) !!}
                        </div>
                        {!! $errors->first('avatar', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="clearfix"></div>
                    <div class="imgprev-wrap" style="display:{{ !empty($category->avatar)?'block':'none' }}">
                        <input type="hidden" value="" name="img-hidden" />
                        <img class="img-preview" src="{{ !empty($category->avatar)?asset($category->avatar):'' }}" alt="{{ trans('theme::categories.avatar') }}" />
                        <i class="fa fa-trash text-danger"></i>
                    </div>
                </div>
            </td>
        </tr>
        <tr class="row {{ $errors->has('keywords') ? 'has-error' : ''}}">
            <td class="col-md-4 col-lg-3">
                {!! Form::label('keywords', trans('theme::news.keywords'), ['class' => 'control-label']) !!}
            </td>
            <td class="col-md-8 col-lg-9">
                {!! Form::text('keywords', null, ['class' => 'form-control input-sm', 'required' => 'required']) !!}
            </td>
        </tr>
        <tr class="row {{ $errors->has('description') ? 'has-error' : ''}}">
            <td class="col-md-4 col-lg-3">
                {!! Form::label('description', trans('theme::categories.meta_description'), ['class' => 'control-label']) !!}
            </td>
            <td class="col-md-8 col-lg-9">
                {!! Form::textarea('description', null, ['class' => 'form-control input-sm ','rows' => 5]) !!}
            </td>
        </tr>
        <tr class="row {{ $errors->has('active') ? 'has-error' : ''}}">
            <td class="col-md-4 col-lg-3">
                {!! Form::label('active', trans('theme::news.active'), ['class' => 'control-label']) !!}
            </td>
            <td class="col-md-8 col-lg-9">
                {!! Form::checkbox('active', 1, (isset($category) && $category->active===1)?true:false, ['class' => 'flat-blue', 'id' => 'active']) !!}
            </td>
        </tr>
    </table>
</div>
<div class="box-footer">
    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : __('message.save'), ['class' => 'btn btn-md btn-info']) !!}
    <a href="{{ url('/admin/categories') }}" class="btn btn-default">{{ __('message.close') }}</a>
</div>
@section('scripts-footer')
<script type="text/javascript" src="{{ asset('plugins/ckeditor_full/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/ckfinder/ckfinder.js') }}"></script>
<script type="text/javascript">
    $(function() {
        CKEDITOR.replace('description');
        $('#image').change(function() {
            var preview = document.querySelector('img.img-preview');
            var file = document.querySelector('#image').files[0];
            var reader = new FileReader();

            if (/\.(jpe?g|png|gif)$/i.test(file.name)) {

                reader.addEventListener("load", function() {
                    preview.src = reader.result;
                    $('.imgprev-wrap').css('display', 'block');
                    $('.inputfile-wrap').find('input[type=text]').val(file.name);
                }, false);

                if (file) {
                    reader.readAsDataURL(file);
                }
            } else {
                document.querySelector('#image').value = '';
                $('.imgprev-wrap').find('input[type=hidden]').val('');
            }
        });

        $('.imgprev-wrap .fa-trash').click(function() {
            var preview = document.querySelector('img.img-preview');

            if (confirm('Bạn muốn xóa hình ảnh này không?')) {
                preview.src = '';
                $('.imgprev-wrap').css('display', 'none');
                $('.inputfile-wrap').find('input[type=text]').val('');
            }
        })
    });
</script>
@endsection