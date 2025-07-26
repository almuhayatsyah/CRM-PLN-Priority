<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'CRM PLN UID ACEH') }}</title>

  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    :root {
      --primary: #0066cc;
      --secondary: #00aaff;
      --dark: #003366;
      --light: #f8f9fa;
      --accent: #ff6b00;
    }

    body {
      font-family: 'Figtree', sans-serif;
      background: linear-gradient(135deg, var(--primary), var(--dark));
      min-height: 100vh;
      color: white;
      overflow-x: hidden;
      position: relative;
    }

    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      z-index: -1;
    }

    .hero-section {
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 2rem 0;
      position: relative;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
      text-align: center;
    }

    .logo-container {
      margin-bottom: 2rem;
      animation: fadeInDown 1s ease;
    }

    .logo-container img {
      height: 100px;
      width: auto;
      filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
    }

    .main-heading {
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
      animation: fadeIn 1s ease 0.3s both;
    }

    .lead-text {
      font-size: 1.5rem;
      margin-bottom: 2rem;
      line-height: 1.6;
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
      animation: fadeIn 1s ease 0.6s both;
    }

    .divider {
      width: 100px;
      height: 4px;
      background: var(--accent);
      margin: 2rem auto;
      border-radius: 2px;
      animation: scaleIn 0.8s ease 0.9s both;
    }

    .sub-text {
      font-size: 1.1rem;
      margin-bottom: 3rem;
      opacity: 0.9;
      animation: fadeIn 1s ease 1.2s both;
    }

    .btn-primary-custom {
      background-color: var(--accent);
      border: none;
      padding: 0.8rem 2rem;
      font-size: 1.1rem;
      font-weight: 600;
      border-radius: 50px;
      color: white;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
      position: relative;
      overflow: hidden;
      animation: fadeInUp 1s ease 1.5s both;
    }

    .btn-primary-custom:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(255, 107, 0, 0.4);
      color: white;
    }

    .btn-primary-custom:active {
      transform: translateY(1px);
    }

    .btn-primary-custom::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: 0.5s;
    }

    .btn-primary-custom:hover::before {
      left: 100%;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      margin-top: 4rem;
      animation: fadeIn 1s ease 1.8s both;
    }

    .feature-card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-radius: 10px;
      padding: 2rem;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
      background: rgba(255, 255, 255, 0.15);
    }

    .feature-icon {
      font-size: 2.5rem;
      color: var(--accent);
      margin-bottom: 1rem;
    }

    .feature-title {
      font-size: 1.3rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }

    .feature-desc {
      opacity: 0.8;
      font-size: 0.95rem;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes scaleIn {
      from {
        transform: scaleX(0);
      }

      to {
        transform: scaleX(1);
      }
    }

    @media (max-width: 768px) {
      .main-heading {
        font-size: 2.2rem;
      }

      .lead-text {
        font-size: 1.2rem;
      }

      .features-grid {
        grid-template-columns: 1fr;
      }
    }

    /* footer style */
    /* Add these styles to your existing CSS */

    .footer {
      background: rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(10px);
      color: white;
      padding: 3rem 0;
      width: 100%;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .footer-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 2rem;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 2rem;
    }

    .footer-logo img {
      height: 60px;
      margin-bottom: 1rem;
      filter: brightness(0) invert(1);
    }

    .footer-about p {
      opacity: 0.8;
      line-height: 1.6;
      font-size: 0.9rem;
    }

    .footer-links h3,
    .footer-contact h3 {
      font-size: 1.2rem;
      margin-bottom: 1.5rem;
      position: relative;
      padding-bottom: 0.5rem;
    }

    .footer-links h3::after,
    .footer-contact h3::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: 0;
      width: 40px;
      height: 2px;
      background: var(--accent);
    }

    .footer-links ul {
      list-style: none;
      padding: 0;
    }

    .footer-links li {
      margin-bottom: 0.8rem;
    }

    .footer-links a {
      color: white;
      opacity: 0.8;
      text-decoration: none;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
    }

    .footer-links a:hover {
      opacity: 1;
      color: var(--accent);
      transform: translateX(5px);
    }

    .footer-links i {
      margin-right: 0.5rem;
      font-size: 0.8rem;
    }

    .footer-contact p {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
      opacity: 0.8;
      font-size: 0.9rem;
    }

    .footer-contact i {
      margin-right: 0.8rem;
      color: var(--accent);
      min-width: 20px;
    }

    .footer-bottom {
      text-align: center;
      padding-top: 2rem;
      margin-top: 2rem;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      font-size: 0.8rem;
      opacity: 0.7;
    }

    .social-links {
      display: flex;
      gap: 1rem;
      margin-top: 1.5rem;
    }

    .social-links a {
      color: white;
      background: rgba(255, 255, 255, 0.1);
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }

    .social-links a:hover {
      background: var(--accent);
      transform: translateY(-3px);
    }

    @media (max-width: 768px) {
      .footer-container {
        grid-template-columns: 1fr;
      }

      .footer-links,
      .footer-contact {
        margin-top: 2rem;
      }
    }

    /* footer style end */
  </style>
</head>

<body>
  <section class="hero-section">
    <div class="hero-content">
      <div class="logo-container animate__animated animate__fadeIn">
        <img src="{{ asset('images/pln_logo.png') }}" alt="PLN Logo">
      </div>

      <h1 class="main-heading">Sistem CRM PLN UID Aceh Sub Divisi Priority Account Executive</h1>
      <p class="lead-text">Transformasi Layanan Pelanggan dengan Solusi Digital Terintegrasi</p>

      <div class="divider"></div>

      <p class="sub-text">Optimalkan manajemen pelanggan prioritas dengan sistem yang efisien, akurat, dan real-time</p>

      <a href="{{ route('login') }}" class="btn btn-primary-custom">
        <i class="fas fa-sign-in-alt me-2"></i> Login ke Sistem
      </a>

      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-users-cog"></i>
          </div>
          <h3 class="feature-title">Manajemen Pelanggan</h3>
          <p class="feature-desc">Kelola data pelanggan prioritas secara terpusat dan terstruktur</p>
        </div>

        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-calendar-check"></i>
          </div>
          <h3 class="feature-title">Jadwal Kunjungan</h3>
          <p class="feature-desc">Pantau dan atur jadwal kunjungan lapangan dengan mudah</p>
        </div>

        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-chart-line"></i>
          </div>
          <h3 class="feature-title">Analitik & Laporan</h3>
          <p class="feature-desc">Dapatkan insight dari data interaksi pelanggan</p>
        </div>
      </div>
    </div>
  </section>
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-about">
        <div class="footer-logo">
          <img src="{{ asset('images/pln_logo.png') }}" alt="PLN Logo">
        </div>
        <p>Sistem CRM untuk manajemen pelanggan prioritas PLN Unit Induk Distribusi Aceh. Memberikan solusi terintegrasi untuk meningkatkan kualitas layanan pelanggan.</p>
        <div class="social-links">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>

      <div class="footer-links">
        <h3>Quick Links</h3>
        <ul>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Beranda</a></li>
          <li><a href="{{ route('login') }}"><i class="fas fa-chevron-right"></i> Login</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Tentang Kami</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Fitur</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Kontak</a></li>
        </ul>
      </div>

      <div class="footer-contact">
        <h3>Kontak Kami</h3>
        <p><i class="fas fa-map-marker-alt"></i> Jl. Tgk. H. M. Daud Beureueh No. 12, Banda Aceh</p>
        <p><i class="fas fa-phone-alt"></i> (0651) 7555777</p>
        <p><i class="fas fa-envelope"></i> plnuidaceh@pln.co.id</p>
        <p><i class="fas fa-clock"></i> Senin-Jumat: 08:00 - 16:00 WIB</p>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; 2023 CRM PLN UID Aceh. All Rights Reserved. | Developed by Tim IT PLN UID Aceh</p>
    </div>
  </footer>

  <script>
    // Simple animation trigger on scroll
    document.addEventListener('DOMContentLoaded', function() {
      const featureCards = document.querySelectorAll('.feature-card');

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.opacity = 1;
            entry.target.style.transform = 'translateY(0)';
          }
        });
      }, {
        threshold: 0.1
      });

      featureCards.forEach(card => {
        card.style.opacity = 0;
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
      });
    });
  </script>

</body>

</html>