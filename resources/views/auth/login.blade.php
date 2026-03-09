@extends('layouts.public')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800;900&family=Barlow:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
  :root {
    --orange:  #E8500A;
    --orange2: #FF6B2B;
    --navy:    #0D1B2E;
    --navy2:   #162336;
    --white:   #FFFFFF;
    --muted:   #8A96A3;
    --line:    rgba(255,255,255,0.1);
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'Barlow', sans-serif;
    overflow-x: hidden;
  }

  /* ══ PAGE WRAPPER ══════════════════════════ */
  .login-page {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 1fr 1fr;
  }

  /* ══ LEFT — Photo panel ════════════════════ */
  .login-visual {
    position: relative;
    overflow: hidden;
    background: var(--navy);
  }

  .login-visual-bg {
    position: absolute;
    inset: 0;
    background: url('{{ asset("Learning.webp") }}') center/cover no-repeat;
    transform: scale(1.06);
    animation: bgZoom 14s ease-in-out infinite alternate;
  }

  @keyframes bgZoom {
    from { transform: scale(1.06); }
    to   { transform: scale(1.13); }
  }

  /* jagged/torn bottom edge like the reference image */
  .login-visual::after {
    content: '';
    position: absolute;
    inset: 0;
    background:
      linear-gradient(to right, rgba(13,27,46,0.75) 0%, rgba(13,27,46,0.3) 60%, rgba(13,27,46,0.1) 100%),
      linear-gradient(to bottom, rgba(13,27,46,0.2) 0%, rgba(13,27,46,0.65) 100%);
    z-index: 1;
  }

  .login-visual-content {
    position: relative;
    z-index: 2;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 48px 48px 56px;
  }

  /* Logo inside visual */
  .lv-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
  }

  .lv-logo-icon {
    width: 40px; height: 40px;
    background: var(--orange);
    display: flex; align-items: center; justify-content: center;
  }

  .lv-logo-name {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 22px;
    font-weight: 900;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    line-height: 1;
  }

  .lv-logo-sub {
    font-size: 9px;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.4);
    display: block;
    margin-top: 1px;
  }

  /* Big text bottom-left of visual */
  .lv-bottom {}

  .lv-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--orange);
    color: #fff;
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    padding: 6px 14px 6px 10px;
    margin-bottom: 20px;
    clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 50%, calc(100% - 8px) 100%, 0 100%);
    padding-right: 20px;
  }

  .lv-tag-dot {
    width: 5px; height: 5px;
    background: rgba(255,255,255,0.7);
    border-radius: 50%;
    animation: blink 2s infinite;
  }

  @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.25} }

  .lv-headline {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: clamp(52px, 6vw, 80px);
    font-weight: 900;
    color: #fff;
    text-transform: uppercase;
    line-height: 0.94;
    letter-spacing: -0.01em;
    margin-bottom: 20px;
  }

  .lv-headline span { color: var(--orange); }

  .lv-desc {
    font-size: 14px;
    color: rgba(255,255,255,0.45);
    line-height: 1.7;
    max-width: 320px;
    font-weight: 400;
    margin-bottom: 28px;
  }

  /* Stats row */
  .lv-stats {
    display: flex;
    gap: 28px;
  }

  .lv-stat-num {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 28px;
    font-weight: 900;
    color: #fff;
    line-height: 1;
  }

  .lv-stat-num sup { font-size: 14px; color: var(--orange); }

  .lv-stat-label {
    font-size: 9px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.3);
    font-weight: 600;
    margin-top: 3px;
  }

  .lv-stat-divider {
    width: 1px;
    background: rgba(255,255,255,0.1);
    align-self: stretch;
  }

  /* ══ RIGHT — Form panel ════════════════════ */
  .login-form-panel {
    background: #F4F6F8;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 48px;
  }

  .login-card {
    width: 100%;
    max-width: 440px;
  }

  /* Header */
  .lf-header {
    margin-bottom: 36px;
  }

  .lf-eyebrow {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 10px;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    font-weight: 700;
    color: var(--orange);
    margin-bottom: 12px;
  }

  .lf-eyebrow::before {
    content: '';
    width: 20px; height: 2px;
    background: var(--orange);
  }

  .lf-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 40px;
    font-weight: 900;
    color: var(--navy);
    text-transform: uppercase;
    letter-spacing: -0.01em;
    line-height: 1.05;
    margin-bottom: 8px;
  }

  .lf-title span { color: var(--orange); }

  .lf-sub {
    font-size: 14px;
    color: var(--muted);
    font-weight: 400;
    line-height: 1.6;
  }

  /* Form */
  .lf-form { display: flex; flex-direction: column; gap: 16px; }

  .form-group { display: flex; flex-direction: column; gap: 6px; }

  .form-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--navy);
  }

  .form-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
  }

  .form-input-icon {
    position: absolute;
    left: 14px;
    color: var(--muted);
    pointer-events: none;
    transition: color 0.2s;
  }

  .form-input {
    width: 100%;
    padding: 13px 14px 13px 42px;
    background: #fff;
    border: 1.5px solid #E0E4E8;
    border-radius: 0;
    font-family: 'Barlow', sans-serif;
    font-size: 14px;
    font-weight: 500;
    color: var(--navy);
    outline: none;
    transition: border-color 0.25s, box-shadow 0.25s;
  }

  .form-input::placeholder { color: #B0B8C1; font-weight: 400; }

  .form-input:focus {
    border-color: var(--orange);
    box-shadow: 0 0 0 3px rgba(232,80,10,0.1);
  }

  .form-input:focus + .form-input-icon,
  .form-input-wrap:focus-within .form-input-icon { color: var(--orange); }

  /* Password toggle */
  .pw-toggle {
    position: absolute;
    right: 14px;
    background: none;
    border: none;
    cursor: pointer;
    color: var(--muted);
    padding: 4px;
    transition: color 0.2s;
  }

  .pw-toggle:hover { color: var(--navy); }

  /* Remember + forgot row */
  .form-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-top: 2px;
  }

  .form-check {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    user-select: none;
  }

  .form-check input[type="checkbox"] {
    width: 16px; height: 16px;
    border: 1.5px solid #C8D0D8;
    border-radius: 0;
    accent-color: var(--orange);
    cursor: pointer;
    flex-shrink: 0;
  }

  .form-check-label {
    font-size: 13px;
    color: #6A7480;
    font-weight: 500;
  }

  .form-forgot {
    font-size: 13px;
    color: var(--orange);
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s;
  }

  .form-forgot:hover { color: var(--navy); }

  /* Submit button */
  .btn-submit {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    background: var(--navy);
    color: #fff;
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 16px;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    padding: 16px 32px;
    border: none;
    cursor: pointer;
    transition: background 0.25s, transform 0.2s, box-shadow 0.2s;
    position: relative;
    overflow: hidden;
    margin-top: 4px;
  }

  .btn-submit::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--orange);
    transform: translateX(-101%);
    transition: transform 0.35s ease;
  }

  .btn-submit span, .btn-submit svg { position: relative; z-index: 1; }

  .btn-submit:hover::before { transform: translateX(0); }
  .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(232,80,10,0.3); }
  .btn-submit:active { transform: translateY(0); }

  /* Divider */
  .lf-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 4px 0;
  }

  .lf-divider::before, .lf-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #E0E4E8;
  }

  .lf-divider span {
    font-size: 11px;
    color: #B0B8C1;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
  }

  /* Register link */
  .lf-register {
    text-align: center;
    font-size: 13px;
    color: var(--muted);
  }

  .lf-register a {
    color: var(--orange);
    font-weight: 700;
    text-decoration: none;
    margin-left: 4px;
    transition: color 0.2s;
  }

  .lf-register a:hover { color: var(--navy); }

  /* Error messages */
  .form-error {
    font-size: 12px;
    color: #D93025;
    font-weight: 500;
    margin-top: 4px;
    display: flex;
    align-items: center;
    gap: 5px;
  }

  /* Alert box */
  .alert-box {
    background: rgba(217,48,37,0.06);
    border-left: 3px solid #D93025;
    padding: 12px 16px;
    border-radius: 2px;
    font-size: 13px;
    color: #C0392B;
    font-weight: 500;
    line-height: 1.5;
    margin-bottom: 4px;
  }

  /* ══ RESPONSIVE ════════════════════════════ */
  @media (max-width: 900px) {
    .login-page { grid-template-columns: 1fr; }
    .login-visual { min-height: 280px; }
    .login-visual-content { padding: 32px 28px 36px; }
    .lv-headline { font-size: clamp(36px, 8vw, 56px); }
    .login-form-panel { padding: 40px 24px; }
  }

  @media (max-width: 480px) {
    .login-form-panel { padding: 32px 20px; }
    .lf-title { font-size: 32px; }
  }
</style>

{{-- ═══════════════════════════════════════════════
     PAGE
═══════════════════════════════════════════════ --}}
<div class="login-page">

  {{-- ── LEFT : Visual ─────────────────────── --}}
  <div class="login-visual">
    <div class="login-visual-bg"></div>
    <div class="login-visual-content">

      {{-- Logo --}}
      <a href="{{ route('home') }}" class="lv-logo">
        <div class="lv-logo-icon">
          <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
        </div>
        <div>
          <span class="lv-logo-name">Janoub</span>
          <span class="lv-logo-sub">Auto-École · Safi</span>
        </div>
      </a>

      {{-- Bottom headline --}}
      <div class="lv-bottom">
        <div class="lv-tag">
          <span class="lv-tag-dot"></span>
          Session 2026 ouverte
        </div>
        <h2 class="lv-headline">
          La route<br>
          du <span>succès</span><br>
          commence ici.
        </h2>
        <p class="lv-desc">
          Connectez-vous à votre espace candidat pour suivre vos progrès, réserver vos séances et préparer votre examen.
        </p>
        <div class="lv-stats">
          <div>
            <div class="lv-stat-num">98<sup>%</sup></div>
            <div class="lv-stat-label">Réussite</div>
          </div>
          <div class="lv-stat-divider"></div>
          <div>
            <div class="lv-stat-num">1.2<sup>k</sup></div>
            <div class="lv-stat-label">Diplômés</div>
          </div>
          <div class="lv-stat-divider"></div>
          <div>
            <div class="lv-stat-num">4.9<sup>/5</sup></div>
            <div class="lv-stat-label">Avis</div>
          </div>
        </div>
      </div>

    </div>
  </div>

  {{-- ── RIGHT : Form ───────────────────────── --}}
  <div class="login-form-panel">
    <div class="login-card">

      <div class="lf-header">
        <div class="lf-eyebrow">Espace candidat</div>
        <h1 class="lf-title">Bon retour<br><span>parmi nous</span></h1>
        <p class="lf-sub">Entrez vos identifiants pour accéder à votre tableau de bord.</p>
      </div>

      {{-- Session errors --}}
      @if ($errors->any())
        <div class="alert-box">
          {{ $errors->first() }}
        </div>
      @endif

      <form class="lf-form" method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="form-group">
          <label class="form-label" for="email">Adresse e-mail</label>
          <div class="form-input-wrap">
            <input
              class="form-input"
              type="email"
              id="email"
              name="email"
              value="{{ old('email') }}"
              placeholder="vous@example.com"
              autocomplete="email"
              autofocus
              required
            >
            <svg class="form-input-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
          </div>
          @error('email')
            <span class="form-error">
              <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
              {{ $message }}
            </span>
          @enderror
        </div>

        {{-- Password --}}
        <div class="form-group">
          <label class="form-label" for="password">Mot de passe</label>
          <div class="form-input-wrap">
            <input
              class="form-input"
              type="password"
              id="password"
              name="password"
              placeholder="••••••••"
              autocomplete="current-password"
              required
            >
            <svg class="form-input-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <button type="button" class="pw-toggle" id="pwToggle" aria-label="Afficher le mot de passe">
              <svg id="eyeIcon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
            </button>
          </div>
          @error('password')
            <span class="form-error">
              <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
              {{ $message }}
            </span>
          @enderror
        </div>

        {{-- Remember + Forgot --}}
        <div class="form-meta">
          <label class="form-check">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <span class="form-check-label">Se souvenir de moi</span>
          </label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="form-forgot">Mot de passe oublié ?</a>
          @endif
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-submit">
          <span>Se connecter</span>
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
          </svg>
        </button>

        <div class="lf-divider"><span>ou</span></div>

        <div class="lf-register">
          Pas encore de compte ?
          <a href="{{ route('register') }}">Créer un compte →</a>
        </div>

      </form>
    </div>
  </div>

</div>

<script>
  // Password show/hide
  const pwToggle = document.getElementById('pwToggle');
  const pwInput  = document.getElementById('password');
  const eyeIcon  = document.getElementById('eyeIcon');

  pwToggle.addEventListener('click', () => {
    const isPassword = pwInput.type === 'password';
    pwInput.type = isPassword ? 'text' : 'password';
    eyeIcon.innerHTML = isPassword
      ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`
      : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
  });
</script>

@endsection