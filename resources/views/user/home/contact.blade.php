@extends('user.layouts.master')

@section('content')
    <style>
        .contact-section {
            background: url('{{ asset('user/img/Contact.jpg') }}') no-repeat center center;
            background-size: cover;
            padding: 100px 0;
            color: #fff;
        }
    </style>

    <div class="container-fluid contact-section mt-3">
        <div class="container">
            <div class="row justify-content-start">
                <div class="col-md-6 contact-form shadow-sm rounded">
                    <h2 class="section-title fw-bold text-center text-success">Contact Us</h2>
                    <form action="{{ route('user.message') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-success fw-bold">Your Name</label>
                            <input type="text" name="name"
                                class="form-control @error('name')
                                is-invalid
                            @enderror"
                                value="{{ old('name', Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname) }}"
                                placeholder="Enter your name" required>
                            @error('name')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-success fw-bold">Your Email</label>
                            <input type="email" name="email"
                                class="form-control @error('email')
                                is-invalid
                            @enderror"
                                value="{{ old('email', Auth::user()->email) }}" placeholder="Enter your email" required>
                            @error('email')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-success fw-bold">Subject</label>
                            <input type="text" name="subject" value="{{ old('subject') }}"
                                class="form-control @error('subject')
                                is-invalid
                            @enderror"
                                placeholder="Subject" required>
                            @error('subject')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-success fw-bold">Your Message</label>
                            <textarea name="message" rows="5"
                                class="form-control @error('message')
                                is-invalid
                            @enderror"
                                placeholder="Enter your message" required>{{ old('message') }}</textarea>
                            @error('message')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success px-5 mb-3">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
