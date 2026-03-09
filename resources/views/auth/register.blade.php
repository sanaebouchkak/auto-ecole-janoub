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

* { box-sizing: border-box; margin:0; padding:0; }
body { font-family:'Barlow',sans-serif; overflow-x:hidden; }

/* PAGE WRAPPER */
.register-page { min-height:100vh; display:grid; grid-template-columns:1fr 1fr; }

/* LEFT VISUAL */
.register-visual { position:relative; overflow:hidden; background:var(--navy); }
.register-visual-bg { position:absolute; inset:0; background:url('{{ asset("Learning.webp") }}') center/cover no-repeat; transform:scale(1.06); animation:bgZoom 14s ease-in-out infinite alternate; }
@keyframes bgZoom { from{transform:scale(1.06);} to{transform:scale(1.13);} }
.register-visual::after { content:''; position:absolute; inset:0; background: linear-gradient(to right, rgba(13,27,46,0.75) 0%, rgba(13,27,46,0.3) 60%, rgba(13,27,46,0.1) 100%), linear-gradient(to bottom, rgba(13,27,46,0.2) 0%, rgba(13,27,46,0.65) 100%); z-index:1; }
.register-visual-content { position:relative; z-index:2; height:100%; display:flex; flex-direction:column; justify-content:space-between; padding:48px 48px 56px; }
.rv-logo { display:flex; align-items:center; gap:10px; text-decoration:none; }
.rv-logo-icon { width:40px; height:40px; background:var(--orange); display:flex; align-items:center; justify-content:center; }
.rv-logo-name { font-family:'Barlow Condensed',sans-serif; font-size:22px; font-weight:900; color:#fff; text-transform:uppercase; letter-spacing:.05em; }
.rv-logo-sub { font-size:9px; letter-spacing:.18em; text-transform:uppercase; color:rgba(255,255,255,.4); display:block; margin-top:1px; }
.rv-headline { font-family:'Barlow Condensed',sans-serif; font-size:clamp(36px,6vw,64px); font-weight:900; color:#fff; line-height:0.94; letter-spacing:-0.01em; margin-bottom:20px; }
.rv-headline span { color:var(--orange); }
.rv-desc { font-size:14px; color:rgba(255,255,255,0.45); line-height:1.7; max-width:320px; margin-bottom:28px; }
.register-form-panel { background:#F4F6F8; display:flex; align-items:center; justify-content:center; padding:60px 48px; }
.register-card { width:100%; max-width:440px; }
.lf-header { margin-bottom:36px; }
.lf-eyebrow { display:flex; align-items:center; gap:8px; font-size:10px; letter-spacing:.2em; text-transform:uppercase; font-weight:700; color:var(--orange); margin-bottom:12px; }
.lf-eyebrow::before { content:''; width:20px; height:2px; background:var(--orange); }
.lf-title { font-family:'Barlow Condensed',sans-serif; font-size:36px; font-weight:900; color:var(--navy); text-transform:uppercase; letter-spacing:-0.01em; line-height:1.05; margin-bottom:8px; }
.lf-title span { color:var(--orange); }
.lf-sub { font-size:14px; color:var(--muted); font-weight:400; line-height:1.6; }

/* Form */
.lf-form { display:flex; flex-direction:column; gap:16px; }
.form-group { display:flex; flex-direction:column; gap:6px; }
.form-label { font-size:11px; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:var(--navy); }
.form-input-wrap { position:relative; display:flex; align-items:center; }
.form-input-icon { position:absolute; left:14px; color:var(--muted); pointer-events:none; transition:color .2s; }
.form-input { width:100%; padding:13px 14px 13px 42px; background:#fff; border:1.5px solid #E0E4E8; font-family:'Barlow',sans-serif; font-size:14px; font-weight:500; color:var(--navy); outline:none; transition:border-color .25s, box-shadow .25s; }
.form-input::placeholder { color:#B0B8C1; font-weight:400; }
.form-input:focus { border-color:var(--orange); box-shadow:0 0 0 3px rgba(232,80,10,0.1); }
.form-error { font-size:12px; color:#D93025; margin-top:4px; display:flex; align-items:center; gap:5px; }

/* Submit button */
.btn-submit { display:flex; align-items:center; justify-content:center; gap:10px; width:100%; background:var(--navy); color:#fff; font-family:'Barlow Condensed',sans-serif; font-size:16px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; padding:16px 32px; border:none; cursor:pointer; transition:background .25s, transform .2s, box-shadow .2s; position:relative; overflow:hidden; margin-top:4px; }
.btn-submit::before { content:''; position:absolute; inset:0; background:var(--orange); transform:translateX(-101%); transition:transform .35s ease; }
.btn-submit span, .btn-submit svg { position:relative; z-index:1; }
.btn-submit:hover::before { transform:translateX(0); }
.btn-submit:hover { transform:translateY(-1px); box-shadow:0 8px 24px rgba(232,80,10,.3); }
.btn-submit:active { transform:translateY(0); }

@media(max-width:900px){.register-page{grid-template-columns:1fr;}.register-visual{min-height:280px;}.register-form-panel{padding:40px 24px;}}
@media(max-width:480px){.register-form-panel{padding:32px 20px;}.lf-title{font-size:32px;}}
</style>

<div class="register-page">

  {{-- LEFT VISUAL --}}
  <div class="register-visual">
    <div class="register-visual-bg"></div>
    <div class="register-visual-content">
      <a href="{{ route('home') }}" class="rv-logo">
        <div class="rv-logo-icon">
          <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <div>
          <span class="rv-logo-name">Janoub</span>
          <span class="rv-logo-sub">Auto-École · Safi</span>
        </div>
      </a>
      <h2 class="rv-headline">Inscrivez-vous<br><span>maintenant</span></h2>
      <p class="rv-desc">Créez votre compte candidat pour accéder aux cours, réserver vos séances et suivre vos progrès.</p>
    </div>
  </div>

  {{-- RIGHT FORM --}}
  <div class="register-form-panel">
    <div class="register-card">

      <div class="lf-header">
        <div class="lf-eyebrow">Créer un compte</div>
        <h1 class="lf-title">Bienvenue<br><span>parmi nous</span></h1>
        <p class="lf-sub">Remplissez vos informations pour commencer votre session.</p>
      </div>

      @if ($errors->any())
        <div class="alert-box">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}" class="lf-form">
        @csrf

        <div class="form-group">
          <label for="name" class="form-label">Nom complet</label>
          <div class="form-input-wrap">
            <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required placeholder="NOM COMPLET">
          </div>
          <x-input-error :messages="$errors->get('name')" class="form-error"/>
        </div>

        <div class="form-group">
          <label for="email" class="form-label">Adresse e-mail</label>
          <div class="form-input-wrap">
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required placeholder="vous@example.com">
          </div>
          <x-input-error :messages="$errors->get('email')" class="form-error"/>
        </div>

        <div class="form-group">
          <label for="phone" class="form-label">Téléphone</label>
          <div class="form-input-wrap">
            <input id="phone" class="form-input" type="tel" name="phone" value="{{ old('phone') }}" required placeholder="06 00 00 00 00">
          </div>
          <x-input-error :messages="$errors->get('phone')" class="form-error"/>
        </div>

        <div class="form-group">
          <label for="password" class="form-label">Mot de passe</label>
          <div class="form-input-wrap">
            <input id="password" class="form-input" type="password" name="password" required placeholder="••••••••">
          </div>
          <x-input-error :messages="$errors->get('password')" class="form-error"/>
        </div>

        <div class="form-group">
          <label for="password_confirmation" class="form-label">Confirmation</label>
          <div class="form-input-wrap">
            <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required placeholder="••••••••">
          </div>
        </div>

        <button type="submit" class="btn-submit"><span>Créer mon compte</span></button>
      </form>

      <p class="lf-register">Déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a></p>
    </div>
  </div>

</div>

@endsection