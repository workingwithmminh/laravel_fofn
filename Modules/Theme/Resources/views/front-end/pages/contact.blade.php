<div class="row">
    @section('slider')
        <img src="{{ asset('images-theme/footer2/contact.png') }}" width="100%" alt="contact">
    @endsection

    <div class="col-md-12 my-5">
        <div class="row">
            <div class="col-md-4 text-center">
                <img class="img-svg" src="{{ asset('images-theme/footer2/icon-dchi.svg') }}" width="40px" height="60px" alt="Địa chỉ">
                <p class="mt-2" style="color: #009f3c;">&nbsp;{{ $settings['company_address'] }}</p>
            </div>
            <div class="col-md-4 text-center">
                <img class="img-svg" src="{{ asset('images-theme/footer2/phone-icon.svg') }}" width="60px" alt="Điện thoại" style="filter: invert(.5) sepia(0.5) saturate(5) hue-rotate(95deg); height: 60px !important;">
                <p class="mt-2" style="color: #009f3c;">{{ $settings['company_phone'] }}</p>
            </div>
            <div class="col-md-4 text-center">
                <img class="img-svg" src="{{ asset('images-theme/footer2/icon-mail.svg') }}" width="105px" alt="Email" height="60px">
                <p class="mt-2" style="color: #009f3c;">&nbsp;{{ $settings['company_email'] }}</p>
            </div>
        </div>
    </div>

    <div class="col-lg-6 order-lg-2 order-md-1">
        <h5 class="text-uppercasemt-15">{{ trans('frontend.send_request') }}</h5>
        {!! Form::open(['method' => 'POST', 'url' => '', 'role' => 'contact', 'id' => 'contact'])  !!}
        <div class="form-success text-center" style="display: none">
            {{ trans('frontend.success_contact') }}
        </div>
        <div class="contact-form form-contact">
            <div class="form-group">
                {!! Form::text('fullname', null, ['required' => 'required', 'placeholder' => 'Họ & tên']) !!}
                <span class="highlight"></span><span class="bar"></span>
            </div>
            <div class="form-group">
                {!! Form::email('email', null, [ 'required' => 'required', 'placeholder' => 'Email']) !!}
                <span class="highlight"></span><span class="bar"></span>
            </div>
            <div class="form-group">
                {!! Form::text('phone', null, [ 'placeholder' => 'Điện thoại']) !!}
                <span class="highlight"></span><span class="bar"></span>
            </div>
            <div class="form-group">
                {!! Form::text('address', null, [ 'placeholder' => 'Chủ đề']) !!}
                <span class="highlight"></span><span class="bar"></span>
            </div>
            <div class="form-group">
                {!! Form::textarea('message', null, ['class' => 'highlight', 'required' => 'required', 'rows' => 3, 'placeholder' => 'Nội dung']) !!}
                <span class="highlight"></span><span class="bar"></span>
            </div>
            <div class="d-flex justify-content-center mt-2">
                {!! Form::submit(__('message.send'), ['class' => 'btn btn-contact ']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>