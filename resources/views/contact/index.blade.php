@extends('layouts.boomerang')

@section('title', 'ติดต่อเรา')

@section('content')
<!-- Hero -->
<section class="module-cover parallax text-center" data-background="{{ asset('frontend/images/Banner.png') }}" data-overlay="0.5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-white">ติดต่อเรา</h2>
                <p class="text-white-50">ติดต่อเราเพื่อรับคำปรึกษาฟรี</p>
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
                    <h2>ส่งข้อความถึงเรา</h2>
                    <p class="lead">กรอกข้อมูลด้านล่างและเราจะติดต่อกลับโดยเร็วที่สุด</p>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
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
                            <div class="form-group mb-3">
                                <input class="form-control" type="text" name="name" placeholder="ชื่อ-นามสกุล" value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <input class="form-control" type="tel" name="phone" placeholder="เบอร์โทรศัพท์" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <input class="form-control" type="email" name="email" placeholder="อีเมล (ถ้ามี)" value="{{ old('email') }}">
                                @error('email')
                                    <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <input class="form-control" type="text" name="subject" placeholder="หัวข้อ" value="{{ old('subject') }}" required>
                                @error('subject')
                                    <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <textarea class="form-control" name="details" placeholder="รายละเอียด" rows="10" required>{{ old('details') }}</textarea>
                                @error('details')
                                    <p class="help-block text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-dark btn-block btn-round" type="submit">ส่งข้อความ</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Contact Info Sidebar -->
            <div class="col-md-4">
                <div class="widget">
                    <h5 class="widget-title">ข้อมูลติดต่อ</h5>
                    <ul class="list-unstyled">
                        <li>
                            <div class="icon-box icon-box-left">
                                <div class="icon-box-icon"><i class="bi bi-telephone"></i></div>
                                <div class="icon-box-content">
                                    <h6>โทรศัพท์</h6>
                                    <a href="tel:0922569828">092-256-9828</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="icon-box icon-box-left">
                                <div class="icon-box-icon"><i class="bi bi-envelope"></i></div>
                                <div class="icon-box-content">
                                    <h6>อีเมล</h6>
                                    <a href="mailto:pjs.legal2025@gmail.com">pjs.legal2025@gmail.com</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="icon-box icon-box-left">
                                <div class="icon-box-icon"><i class="bi bi-geo-alt"></i></div>
                                <div class="icon-box-content">
                                    <h6>ที่อยู่</h6>
                                    <p>27/20 Soi Bang Bon 4, Soi 4, Bang Son Nua, Bang Bon, Bangkok 10150</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="icon-box icon-box-left">
                                <div class="icon-box-icon"><i class="bi bi-line"></i></div>
                                <div class="icon-box-content">
                                    <h6>LINE</h6>
                                    <p>LINE Official</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="module p-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="map-responsive">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3876.8!2d100.4!3d13.65!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTPCsDM5JzAwLjAiTiAxMDDCsDI0JzAwLjAiRQ!5e0!3m2!1sen!2sth!4v1234567890" 
                            width="600" height="450" style="border:0; width: 100%;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact end-->
@endsection