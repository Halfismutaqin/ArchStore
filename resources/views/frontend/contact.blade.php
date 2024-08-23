@extends('layouts.frontend.app')

@section('content')
<div class="container mt-5">
    <div class="text-center mb-4">
        <h3>Contact Us</h3>
        <p class="lead">We'd love to hear from you! Reach out to us via any of the following platforms.</p>
    </div>

    <div class="row justify-content-center">
        <!-- Contact Info -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm p-4">
                <h4 class="text-center mb-3">Get in Touch</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-phone"></i> <strong>No HP:</strong> <a href="tel:+6281320720250">0813 20720250</a></li>
                    <li class="mb-2"><i class="fas fa-envelope"></i> <strong>Email:</strong> <a href="mailto:zedarchery@gmail.com">zedarchery@gmail.com</a></li>
                    <li class="mb-2"><i class="fab fa-instagram"></i> <strong>Instagram:</strong> <a href="https://www.instagram.com/Zed_Archery" target="_blank">@Zed_Archery</a></li>
                    <li class="mb-2"><i class="fab fa-facebook"></i> <strong>Facebook:</strong> <a href="https://www.facebook.com/ZedArchery" target="_blank">Zed Archery</a></li>
                    <li class="mb-2"><i class="fab fa-tiktok"></i> <strong>TikTok:</strong> <a href="https://www.tiktok.com/@ZedArchery" target="_blank">@ZedArchery</a></li>
                </ul>
            </div>
        </div>

        <!-- Google Maps -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15820.117477529797!2d110.8106749!3d-7.5717769!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a17dcd2518773%3A0x7f6aa41dd9fc1135!2sZED%20ARCHERY!5e0!3m2!1sid!2sid!4v1724040134204!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
