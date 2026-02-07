@extends('layouts.boomerang')

@section('content')
<!-- Hero -->
<section class="module-cover parallax text-center" data-background="{{ asset('frontend/images/module-6.jpg') }}" data-overlay="0.5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ __('common.contact_us') }}</h2>
                <p>
                    @if(app()->getLocale() === 'th')
                        ติดต่อเราเพื่อรับคำปรึกษาฟรี
                    @else
                        Contact us for a free consultation
                    @endif
                </p>
            </div>
        </div>
    </div>
</section>
<!-- Hero end-->

<!-- Contact -->
<section class="module">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="text-center m-b-60">
                    <h2>{{ __('common.contact_form.title') }}</h2>
                    <p class="lead">
                        @if(app()->getLocale() === 'th')
                            กรอกข้อมูลด้านล่างและเราจะติดต่อกลับโดยเร็วที่สุด
                        @else
                            Fill in the form below and we will get back to you as soon as possible
                        @endif
                    </p>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <form id="contact-form" action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control" type="text" name="name" placeholder="{{ __('common.contact_form.name') }}" value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control" type="tel" name="phone" placeholder="{{ __('common.contact_form.phone') }}" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" placeholder="{{ __('common.contact_form.email') }} (@if(app()->getLocale() === 'th')ถ้ามี@else Optional@endif)" value="{{ old('email') }}">
                                @error('email')
                                    <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control" type="text" name="subject" placeholder="{{ __('common.contact_form.subject') }}" value="{{ old('subject') }}" required>
                                @error('subject')
                                    <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea class="form-control" name="details" placeholder="{{ __('common.contact_form.details') }}" rows="6" required>{{ old('details') }}</textarea>
                                @error('details')
                                    <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-dark btn-block btn-round" type="submit">{{ __('common.contact_form.send') }}</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Contact Info Sidebar -->
            <div class="col-md-4">
                <div class="widget">
                    <h5 class="widget-title">{{ __('common.footer.contact_info') }}</h5>
                    <ul class="list-unstyled">
                        <li class="m-b-20">
                            <div class="icon-box icon-box-left">
                                <div class="icon-box-icon"><i class="fas fa-phone"></i></div>
                                <div class="icon-box-content">
                                    <h6>
                                        @if(app()->getLocale() === 'th')
                                            โทรศัพท์
                                        @else
                                            Phone
                                        @endif
                                    </h6>
                                    <a href="tel:{{ __('common.company_info.phone') }}">{{ __('common.company_info.phone') }}</a>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-20">
                            <div class="icon-box icon-box-left">
                                <div class="icon-box-icon"><i class="fas fa-envelope"></i></div>
                                <div class="icon-box-content">
                                    <h6>
                                        @if(app()->getLocale() === 'th')
                                            อีเมล
                                        @else
                                            Email
                                        @endif
                                    </h6>
                                    <a href="mailto:{{ __('common.company_info.email') }}">{{ __('common.company_info.email') }}</a>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-20">
                            <div class="icon-box icon-box-left">
                                <div class="icon-box-icon"><i class="fas fa-map-marker-alt"></i></div>
                                <div class="icon-box-content">
                                    <h6>
                                        @if(app()->getLocale() === 'th')
                                            ที่อยู่
                                        @else
                                            Address
                                        @endif
                                    </h6>
                                    <p>{{ __('common.company_info.address') }}</p>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-20">
                            <div class="icon-box icon-box-left">
                                <div class="icon-box-icon"><i class="fab fa-line"></i></div>
                                <div class="icon-box-content">
                                    <h6>LINE</h6>
                                    <p>{{ __('common.company_info.line') }}</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact end-->
@endsection
