@extends('layouts.app')

@section('title', 'Contact')
@section('page-title', 'Contact Us')
@section('page-subtitle', 'Get in touch with our support team')

@section('content')
<div class="row fade-in">
    <div class="col-md-5 mb-4">
        <div class="contact-info-card">
            <div class="contact-icon">
                <i class="fas fa-headset"></i>
            </div>
            <h4>We're Here to Help</h4>
            <p>Have questions or need assistance? Reach out to our team.</p>
            <hr>
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <div>
                    <strong>Email</strong><br>
                    <span>support@zentask.com</span>
                </div>
            </div>
            <div class="info-item">
                <i class="fas fa-phone-alt"></i>
                <div>
                    <strong>Phone</strong><br>
                    <span>(123) 456-7890</span>
                </div>
            </div>
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <strong>Address</strong><br>
                    <span>123 Main Street, City, Country</span>
                </div>
            </div>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-7 mb-4">
        <div class="contact-form-card">
            <h4><i class="fas fa-paper-plane"></i> Send us a Message</h4>
            <form>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control-custom" placeholder="Your Name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="email" class="form-control-custom" placeholder="Your Email" required>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control-custom" placeholder="Subject">
                </div>
                <div class="mb-3">
                    <textarea class="form-control-custom" rows="5" placeholder="Your Message"></textarea>
                </div>
                <button type="submit" class="btn-primary-custom w-100">Send Message →</button>
            </form>
        </div>
    </div>
</div>

<style>
    .contact-info-card, .contact-form-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        height: 100%;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #E0E0E0;
    }
    .contact-icon {
        width: 60px;
        height: 60px;
        background: #FFD700;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }
    .contact-icon i {
        font-size: 28px;
        color: #1A1A1A;
    }
    .contact-info-card h4 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 12px;
    }
    .contact-info-card p {
        color: #666;
        font-size: 14px;
        margin-bottom: 20px;
    }
    .info-item {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        align-items: center;
    }
    .info-item i {
        width: 40px;
        height: 40px;
        background: #F5F5F5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8B4513;
        font-size: 16px;
    }
    .info-item strong {
        font-size: 14px;
        display: block;
        margin-bottom: 4px;
    }
    .info-item span {
        font-size: 13px;
        color: #666;
    }
    .social-links {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }
    .social-links a {
        width: 36px;
        height: 36px;
        background: #F5F5F5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        transition: all 0.2s;
    }
    .social-links a:hover {
        background: #FFD700;
        color: #1A1A1A;
    }
    .contact-form-card h4 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #1A1A1A;
    }
    .contact-form-card h4 i {
        color: #8B4513;
        margin-right: 8px;
    }
    .w-100 {
        width: 100%;
    }
</style>
@endsection