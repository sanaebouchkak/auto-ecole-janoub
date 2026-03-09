@extends('layouts.public')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800;900&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
  :root {
    --orange:  #E8500A;
    --orange2: #FF6B2B;
    --navy:    #0D1B2E;
    --navy2:   #162336;
    --navy3:   #1E2F45;
    --white:   #FFFFFF;
    --off:     #F4F6F8;
    --muted:   #8A96A3;
    --line:    rgba(255,255,255,0.08);
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  html { scroll-behavior: smooth; }

  body {
    font-family: 'Barlow', sans-serif;
    background: var(--off);
    color: var(--navy);
    overflow-x: hidden;
  }

  /* ══════════════════════════════════════
     HERO — fullscreen photo + bold title
  ══════════════════════════════════════ */
  .hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: flex-end;
    overflow: hidden;
  }

  .hero-bg {
    position: absolute;
    inset: 0;
    background:
      linear-gradient(105deg, rgba(13,27,46,0.92) 0%, rgba(13,27,46,0.6) 45%, rgba(13,27,46,0.2) 100%);
    z-index: 1;
  }

  .hero-bg-img {
    position: absolute;
    inset: 0;
    background: url('{{ asset("Learning.webp") }}') center/cover no-repeat;
    transform: scale(1.04);
    animation: heroZoom 12s ease-in-out infinite alternate;
  }

  @keyframes heroZoom {
    from { transform: scale(1.04); }
    to   { transform: scale(1.12); }
  }

  /* Diagonal cut at bottom */
  .hero::after {
    content: '';
    position: absolute;
    bottom: -2px; left: 0; right: 0;
    height: 120px;
    background: var(--off);
    clip-path: polygon(0 60%, 100% 0, 100% 100%, 0 100%);
    z-index: 3;
  }

  .hero-content {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 60px 140px;
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: flex-end;
    gap: 60px;
  }

  .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--orange);
    color: #fff;
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    padding: 7px 16px;
    margin-bottom: 24px;
    clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 50%, calc(100% - 10px) 100%, 0 100%);
    padding-right: 24px;
  }

  .hero-badge-dot {
    width: 6px; height: 6px;
    background: rgba(255,255,255,0.7);
    border-radius: 50%;
    animation: blink 1.8s infinite;
  }

  @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }

  .hero-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(72px, 9vw, 130px);
    font-weight: 900;
    line-height: 0.92;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: -0.01em;
    margin-bottom: 28px;
  }

  .hero-title .accent { color: var(--orange); }
  .hero-title .outline {
    -webkit-text-stroke: 2px rgba(255,255,255,0.4);
    color: transparent;
  }

  .hero-sub {
    font-size: 16px;
    color: rgba(255,255,255,0.55);
    line-height: 1.7;
    max-width: 480px;
    margin-bottom: 40px;
    font-weight: 400;
  }

  .hero-cta-row {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
  }

  .btn-orange {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--orange);
    color: #fff;
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 15px;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    padding: 16px 32px;
    text-decoration: none;
    clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 50%, calc(100% - 12px) 100%, 0 100%);
    padding-right: 40px;
    transition: background 0.25s, transform 0.2s;
    position: relative;
    overflow: hidden;
  }

  .btn-orange::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,0.12);
    transform: translateX(-100%) skew(-10deg);
    transition: transform 0.4s ease;
  }

  .btn-orange:hover::before { transform: translateX(100%) skew(-10deg); }
  .btn-orange:hover { background: var(--orange2); transform: translateY(-2px); }

  .btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: 1.5px solid rgba(255,255,255,0.3);
    color: rgba(255,255,255,0.7);
    font-size: 14px;
    font-weight: 500;
    padding: 15px 28px;
    text-decoration: none;
    transition: all 0.25s;
    letter-spacing: 0.02em;
  }

  .btn-ghost:hover {
    border-color: #fff;
    color: #fff;
    background: rgba(255,255,255,0.06);
  }

  /* Social proof row */
  .hero-social {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-top: 32px;
  }

  .hero-social-label {
    font-size: 11px;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.3);
    font-weight: 500;
  }

  .social-icons {
    display: flex;
    gap: 10px;
  }

  .social-icon {
    width: 32px; height: 32px;
    border: 1px solid rgba(255,255,255,0.15);
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.4);
    text-decoration: none;
    font-size: 12px;
    transition: all 0.2s;
  }

  .social-icon:hover { border-color: var(--orange); color: var(--orange); }

  /* Right side stat card */
  .hero-stat-card {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    backdrop-filter: blur(20px);
    padding: 32px 28px;
    min-width: 180px;
    display: flex;
    flex-direction: column;
    gap: 28px;
    margin-bottom: 4px;
  }

  .hsc-item {}
  .hsc-num {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 44px;
    font-weight: 900;
    color: #fff;
    line-height: 1;
    letter-spacing: -0.02em;
  }
  .hsc-num sup { font-size: 22px; color: var(--orange); }
  .hsc-label {
    font-size: 10px;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.35);
    font-weight: 500;
    margin-top: 4px;
  }
  .hsc-divider { height: 1px; background: rgba(255,255,255,0.07); }

  /* ══════════════════════════════════════
     FEATURES — dark navy section
  ══════════════════════════════════════ */
  .features {
    background: var(--navy);
    padding: 100px 60px;
    position: relative;
    z-index: 2;
  }

  .features-inner {
    max-width: 1300px;
    margin: 0 auto;
  }

  .features-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 40px;
    margin-bottom: 60px;
  }

  .section-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--orange);
    margin-bottom: 16px;
  }

  .section-tag::before {
    content: '';
    width: 20px; height: 2px;
    background: var(--orange);
  }

  .features-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(36px, 4vw, 56px);
    font-weight: 800;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: -0.01em;
    line-height: 1.05;
  }

  .features-title span { color: var(--orange); }

  .features-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    color: rgba(255,255,255,0.4);
    text-decoration: none;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    transition: color 0.2s;
    white-space: nowrap;
    padding-bottom: 4px;
  }

  .features-link:hover { color: var(--orange); }

  .features-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.05);
  }

  .feature-card {
    background: var(--navy2);
    padding: 40px 32px;
    position: relative;
    overflow: hidden;
    transition: background 0.3s;
  }

  .feature-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 3px; height: 0;
    background: var(--orange);
    transition: height 0.35s ease;
  }

  .feature-card:hover { background: var(--navy3); }
  .feature-card:hover::before { height: 100%; }

  .fc-num {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 64px;
    font-weight: 900;
    color: rgba(255,255,255,0.04);
    line-height: 1;
    margin-bottom: -10px;
    letter-spacing: -0.03em;
  }

  .fc-icon-wrap {
    width: 52px; height: 52px;
    border: 1px solid rgba(255,255,255,0.1);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 20px;
    color: var(--orange);
    transition: background 0.25s, border-color 0.25s;
  }

  .feature-card:hover .fc-icon-wrap {
    background: rgba(232,80,10,0.1);
    border-color: rgba(232,80,10,0.3);
  }

  .fc-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 20px;
    font-weight: 700;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    margin-bottom: 12px;
  }

  .fc-desc {
    font-size: 14px;
    color: rgba(255,255,255,0.35);
    line-height: 1.65;
    font-weight: 400;
  }

  /* ══════════════════════════════════════
     ABOUT — split layout
  ══════════════════════════════════════ */
  .about {
    padding: 120px 60px;
    max-width: 1300px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
  }

  .about-img-wrap {
    position: relative;
  }

  .about-img-wrap img {
    width: 100%;
    display: block;
    filter: grayscale(10%);
  }

  /* Orange corner accent */
  .about-img-wrap::before {
    content: '';
    position: absolute;
    top: -16px; left: -16px;
    width: 80px; height: 80px;
    border-top: 3px solid var(--orange);
    border-left: 3px solid var(--orange);
  }

  .about-img-wrap::after {
    content: '';
    position: absolute;
    bottom: -16px; right: -16px;
    width: 80px; height: 80px;
    border-bottom: 3px solid var(--orange);
    border-right: 3px solid var(--orange);
  }

  .about-badge {
    position: absolute;
    bottom: 24px; left: -24px;
    background: var(--navy);
    border-left: 4px solid var(--orange);
    padding: 20px 24px;
    min-width: 180px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
  }

  .ab-num {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 40px;
    font-weight: 900;
    color: var(--orange);
    line-height: 1;
  }

  .ab-label {
    font-size: 11px;
    color: rgba(255,255,255,0.5);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    font-weight: 500;
    margin-top: 4px;
  }

  .about-content {}

  .about-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(36px, 4vw, 52px);
    font-weight: 800;
    color: var(--navy);
    text-transform: uppercase;
    line-height: 1.05;
    letter-spacing: -0.01em;
    margin-bottom: 24px;
  }

  .about-title span { color: var(--orange); }

  .about-text {
    font-size: 15px;
    color: #5A6878;
    line-height: 1.75;
    margin-bottom: 36px;
    font-weight: 400;
  }

  .about-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 40px;
  }

  .about-list li {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    font-weight: 500;
    color: var(--navy);
  }

  .about-list li::before {
    content: '';
    width: 20px; height: 20px;
    background: var(--orange);
    clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
    flex-shrink: 0;
  }

  /* ══════════════════════════════════════
     FAQ
  ══════════════════════════════════════ */
  .faq-section {
    background: var(--navy);
    padding: 100px 60px;
    position: relative;
  }

  .faq-section::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(to right, var(--orange), transparent);
  }

  .faq-inner {
    max-width: 1300px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1.4fr;
    gap: 80px;
    align-items: start;
  }

  .faq-left { position: sticky; top: 100px; }

  .faq-big-text {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(40px, 5vw, 64px);
    font-weight: 900;
    color: #fff;
    text-transform: uppercase;
    line-height: 1.0;
    letter-spacing: -0.01em;
    margin-bottom: 20px;
  }

  .faq-big-text span { color: var(--orange); }

  .faq-sub {
    font-size: 14px;
    color: rgba(255,255,255,0.35);
    line-height: 1.7;
    margin-bottom: 36px;
  }

  .faq-cta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--orange);
    text-decoration: none;
    border-bottom: 1px solid rgba(232,80,10,0.3);
    padding-bottom: 4px;
    transition: border-color 0.2s, gap 0.2s;
  }

  .faq-cta:hover { border-color: var(--orange); gap: 12px; }

  .faq-list { display: flex; flex-direction: column; }

  .faq-item {
    border-bottom: 1px solid rgba(255,255,255,0.06);
  }

  .faq-q {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px 0;
    cursor: pointer;
    gap: 20px;
    user-select: none;
  }

  .faq-q-text {
    font-size: 16px;
    font-weight: 500;
    color: rgba(255,255,255,0.7);
    line-height: 1.4;
    transition: color 0.2s;
  }

  .faq-item.open .faq-q-text { color: #fff; }

  .faq-icon {
    width: 28px; height: 28px;
    border: 1px solid rgba(255,255,255,0.12);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    color: rgba(255,255,255,0.4);
    transition: all 0.3s;
  }

  .faq-item.open .faq-icon {
    background: var(--orange);
    border-color: var(--orange);
    color: #fff;
    transform: rotate(45deg);
  }

  .faq-a {
    font-size: 14px;
    color: rgba(255,255,255,0.4);
    line-height: 1.75;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s ease, padding 0.4s ease;
  }

  .faq-item.open .faq-a {
    max-height: 200px;
    padding-bottom: 24px;
  }

  /* ══════════════════════════════════════
     CONTACT
  ══════════════════════════════════════ */
  .contact-section {
    padding: 100px 60px;
    max-width: 1300px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: start;
  }

  .contact-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(36px, 4vw, 56px);
    font-weight: 800;
    color: var(--navy);
    text-transform: uppercase;
    line-height: 1.0;
    letter-spacing: -0.01em;
    margin-bottom: 16px;
  }

  .contact-title span { color: var(--orange); }

  .contact-sub {
    font-size: 15px;
    color: #5A6878;
    line-height: 1.7;
    margin-bottom: 36px;
  }

  .contact-links { display: flex; flex-direction: column; gap: 12px; }

  .contact-link {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 18px 20px;
    background: #fff;
    border: 1px solid rgba(13,27,46,0.08);
    text-decoration: none;
    color: var(--navy);
    transition: all 0.25s;
    position: relative;
    overflow: hidden;
  }

  .contact-link::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: var(--orange);
    transform: scaleY(0);
    transition: transform 0.3s;
  }

  .contact-link:hover::before { transform: scaleY(1); }
  .contact-link:hover { border-color: rgba(232,80,10,0.2); box-shadow: 0 4px 20px rgba(0,0,0,0.06); }

  .cl-icon {
    width: 42px; height: 42px;
    background: var(--navy);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: background 0.2s;
  }

  .contact-link:hover .cl-icon { background: var(--orange); }

  .cl-text { font-size: 15px; font-weight: 600; letter-spacing: -0.01em; }

  .agency-card {
    background: var(--navy);
    padding: 48px 40px;
    position: relative;
    overflow: hidden;
  }

  .agency-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 4px;
    background: linear-gradient(to right, var(--orange), transparent);
  }

  .agency-card::after {
    content: '';
    position: absolute;
    bottom: -40px; right: -40px;
    width: 150px; height: 150px;
    border: 1px solid rgba(255,255,255,0.04);
    border-radius: 50%;
  }

  .agency-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 28px;
    font-weight: 800;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.02em;
    margin-bottom: 8px;
  }

  .agency-sub {
    font-size: 13px;
    color: rgba(255,255,255,0.3);
    line-height: 1.65;
    margin-bottom: 32px;
  }

  .agency-divider {
    width: 40px; height: 2px;
    background: var(--orange);
    margin-bottom: 28px;
  }

  .agency-info { list-style: none; display: flex; flex-direction: column; gap: 16px; }

  .ai-item {
    display: flex;
    align-items: center;
    gap: 14px;
    font-size: 14px;
    color: rgba(255,255,255,0.6);
    font-weight: 400;
  }

  .ai-icon { color: var(--orange); flex-shrink: 0; }

  /* ══════════════════════════════════════
     RESPONSIVE
  ══════════════════════════════════════ */
  @media (max-width: 1024px) {
    .hero-content { grid-template-columns: 1fr; padding: 0 40px 120px; }
    .hero-stat-card { display: none; }
    .features-grid { grid-template-columns: repeat(2, 1fr); }
    .about { grid-template-columns: 1fr; padding: 80px 40px; }
    .about-img-wrap { max-width: 600px; }
    .faq-inner { grid-template-columns: 1fr; }
    .faq-left { position: static; }
    .contact-section { grid-template-columns: 1fr; padding: 80px 40px; }
    .features { padding: 80px 40px; }
    .faq-section { padding: 80px 40px; }
  }

  @media (max-width: 640px) {
    .hero-content { padding: 0 24px 100px; }
    .features { padding: 60px 24px; }
    .features-grid { grid-template-columns: 1fr; }
    .features-header { flex-direction: column; align-items: flex-start; }
    .about { padding: 60px 24px; }
    .faq-section { padding: 60px 24px; }
    .contact-section { padding: 60px 24px; }
    .hero-social { display: none; }
  }
</style>

<div>

  {{-- ─── HERO ─────────────────────────────────── --}}
  <section class="hero">
    <div class="hero-bg-img"></div>
    <div class="hero-bg"></div>

    <div class="hero-content">
      <div>
        <div class="hero-badge">
          <span class="hero-badge-dot"></span>
          N°1 de la conduite à Safi
        </div>

        <h1 class="hero-title">
          Auto<span class="accent">École</span><br>
          <span class="outline">Janoub</span>
        </h1>

        <p class="hero-sub">
          Apprenez à conduire avec les meilleurs moniteurs, sur des véhicules haute technologie. Une plateforme intelligente pour gérer votre planning en un clic.
        </p>

        <div class="hero-cta-row">
          <a href="{{ route('register') }}" class="btn-orange">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            S'inscrire maintenant
          </a>
          <a href="{{ route('formations.public') }}" class="btn-ghost">
            Nos formations
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
          </a>
        </div>

        <div class="hero-social">
          <span class="hero-social-label">Suivez-nous</span>
          <div class="social-icons">
            <a href="#" class="social-icon">f</a>
            <a href="#" class="social-icon">in</a>
            <a href="#" class="social-icon">
              <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/></svg>
            </a>
          </div>
        </div>
      </div>

      <div class="hero-stat-card">
        <div class="hsc-item">
          <div class="hsc-num">98<sup>%</sup></div>
          <div class="hsc-label">Taux de réussite</div>
        </div>
        <div class="hsc-divider"></div>
        <div class="hsc-item">
          <div class="hsc-num">1.2<sup>k</sup></div>
          <div class="hsc-label">Diplômés 2026</div>
        </div>
        <div class="hsc-divider"></div>
        <div class="hsc-item">
          <div class="hsc-num">4.9<sup>/5</sup></div>
          <div class="hsc-label">Avis candidats</div>
        </div>
      </div>
    </div>
  </section>

  {{-- ─── FEATURES ─────────────────────────────── --}}
  <section class="features">
    <div class="features-inner">
      <div class="features-header">
        <div>
          <div class="section-tag">Nos avantages</div>
          <h2 class="features-title">Votre <span>permis</span><br>notre priorité</h2>
        </div>
        <a href="{{ route('formations.public') }}" class="features-link">
          Voir toutes nos formations
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        </a>
      </div>

      <div class="features-grid">
        <div class="feature-card">
          <div class="fc-num">01</div>
          <div class="fc-icon-wrap">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
          </div>
          <div class="fc-title">Code en ligne illimité</div>
          <div class="fc-desc">Plateforme d'entraînement accessible 24h/24, depuis n'importe quel appareil.</div>
        </div>

        <div class="feature-card">
          <div class="fc-num">02</div>
          <div class="fc-icon-wrap">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
          </div>
          <div class="fc-title">Véhicules premium</div>
          <div class="fc-desc">Mercedes & Volkswagen dernière génération, équipés de double commandes.</div>
        </div>

        <div class="feature-card">
          <div class="fc-num">03</div>
          <div class="fc-icon-wrap">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
          </div>
          <div class="fc-title">Suivi personnalisé</div>
          <div class="fc-desc">Tableau de bord candidat pour visualiser vos progrès et vos points à améliorer.</div>
        </div>

        <div class="feature-card">
          <div class="fc-num">04</div>
          <div class="fc-icon-wrap">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          </div>
          <div class="fc-title">Planning flexible</div>
          <div class="fc-desc">Réservez vos séances en ligne et organisez votre apprentissage à votre rythme.</div>
        </div>
      </div>
    </div>
  </section>

  {{-- ─── ABOUT ─────────────────────────────────── --}}
  <section style="background: var(--off);">
    <div class="about">
      <div class="about-img-wrap">
        <img src="{{ asset('Learning.webp') }}" alt="Formation auto-école Janoub">
        <div class="about-badge">
          <div class="ab-num">+15</div>
          <div class="ab-label">Ans d'expérience</div>
        </div>
      </div>

      <div class="about-content">
        <div class="section-tag">À propos de nous</div>
        <h2 class="about-title">Pourquoi choisir <span>Janoub</span> ?</h2>
        <p class="about-text">
          Depuis 2010, l'Auto-École Janoub forme les conducteurs de demain à Safi. Notre équipe de moniteurs certifiés vous accompagne à chaque étape, du code à l'examen pratique.
        </p>
        <ul class="about-list">
          <li>Moniteurs certifiés avec + de 15 ans d'expérience</li>
          <li>98% de taux de réussite en 2026</li>
          <li>Paiement en 3 ou 4 fois sans frais</li>
          <li>Formations accélérées disponibles en 30 jours</li>
        </ul>
        <a href="{{ route('register') }}" class="btn-orange" style="display:inline-flex;">
          Démarrer ma formation
          <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        </a>
      </div>
    </div>
  </section>

  {{-- ─── FAQ ──────────────────────────────────── --}}
  <section class="faq-section">
    <div class="faq-inner">
      <div class="faq-left">
        <div class="section-tag">FAQ</div>
        <h2 class="faq-big-text">Des questions ?<br>On a les<br><span>réponses.</span></h2>
        <p class="faq-sub">Retrouvez les questions les plus fréquentes. Notre équipe reste disponible pour tout autre renseignement.</p>
        <a href="#contact" class="faq-cta">
          Nous contacter
          <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        </a>
      </div>

      <div class="faq-list" id="faqList">
        <div class="faq-item">
          <div class="faq-q">
            <span class="faq-q-text">Comment s'inscrire à l'auto-école ?</span>
            <div class="faq-icon">
              <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
          </div>
          <div class="faq-a">L'inscription se fait directement en ligne. Créez un compte candidat, choisissez votre formation et téléchargez vos pièces justificatives. Une fois validé, planifiez vos séances.</div>
        </div>
        <div class="faq-item">
          <div class="faq-q">
            <span class="faq-q-text">Combien de temps dure la formation complète ?</span>
            <div class="faq-icon">
              <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
          </div>
          <div class="faq-a">En moyenne 2 à 4 mois selon votre rythme. Des formations accélérées sont disponibles pour obtenir le permis en moins de 30 jours.</div>
        </div>
        <div class="faq-item">
          <div class="faq-q">
            <span class="faq-q-text">Quels sont les moyens de paiement acceptés ?</span>
            <div class="faq-icon">
              <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
          </div>
          <div class="faq-a">Carte bancaire, virement et espèces en agence. Possibilité de payer en 3 ou 4 fois sans frais.</div>
        </div>
        <div class="faq-item">
          <div class="faq-q">
            <span class="faq-q-text">Proposez-vous des formations pour la moto ?</span>
            <div class="faq-icon">
              <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
          </div>
          <div class="faq-a">Oui, nous proposons les catégories A1, A2 et A. Contactez-nous pour en savoir plus sur les modalités et les tarifs.</div>
        </div>
      </div>
    </div>
  </section>

  {{-- ─── CONTACT ─────────────────────────────── --}}
  <section style="background: var(--off);" id="contact">
    <div class="contact-section">
      <div>
        <div class="section-tag">Contact</div>
        <h2 class="contact-title">Un projet de <span>permis</span> ?</h2>
        <p class="contact-sub">Nos conseillers sont disponibles du lundi au samedi pour vous guider dans vos démarches et le choix de votre pack.</p>
        <div class="contact-links">
          <a href="tel:+212500000000" class="contact-link">
            <div class="cl-icon">
              <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            </div>
            <span class="cl-text">+212 5 00 00 00 00</span>
          </a>
          <a href="mailto:contact@janoub.ma" class="contact-link">
            <div class="cl-icon">
              <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <span class="cl-text">contact@janoub.ma</span>
          </a>
        </div>
      </div>

      <div class="agency-card">
        <div class="agency-title">Notre Agence</div>
        <div class="agency-sub">Retrouvez-nous au cœur de Safi pour vos cours de code théoriques et pour rencontrer vos moniteurs.</div>
        <div class="agency-divider"></div>
        <ul class="agency-info">
          <li class="ai-item">
            <svg class="ai-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Angle Avenue Mohammed V, Safi
          </li>
          <li class="ai-item">
            <svg class="ai-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Lun – Sam : 09h00 – 19h00
          </li>
        </ul>
      </div>
    </div>
  </section>

</div>

<script>
  document.querySelectorAll('.faq-q').forEach(btn => {
    btn.addEventListener('click', () => {
      const item = btn.parentElement;
      const isOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
      if (!isOpen) item.classList.add('open');
    });
  });
</script>

@endsection