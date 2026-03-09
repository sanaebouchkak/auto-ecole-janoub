{{-- ════════════════════════════════════════════════════════
     layouts/public.blade.php — Navbar style image référence
     Logo gauche · Liens centre · Connexion + bouton orange
════════════════════════════════════════════════════════ --}}
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Auto-École Janoub</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800;900&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ─── RESET ─────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body { font-family: 'Barlow', sans-serif; background: #f5f6f8; color: #0D1B2E; }

/* ─── NAVBAR ─────────────────────────── */
:root {
  --orange: #E8500A;
  --navy:   #0D1B2E;
  --nav-h:  70px;
}

.site-nav {
  position: sticky;
  top: 0;
  z-index: 999;
  background: #fff;
  height: var(--nav-h);
  border-bottom: 2px solid #eee;
  transition: box-shadow 0.3s;
}

.site-nav.scrolled {
  border-bottom-color: #e0e0e0;
  box-shadow: 0 4px 30px rgba(13,27,46,0.1);
}

.nav-inner {
  height: 100%;
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 32px;
  display: grid;
  grid-template-columns: auto 1fr auto;
  align-items: center;
  gap: 24px;
}

/* ── Logo ─────────────────── */
.nav-logo {
  display: flex;
  align-items: center;
  gap: 13px;
  text-decoration: none;
  flex-shrink: 0;
}

.nav-logo-mark {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.nav-logo-top {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 9px;
  font-weight: 700;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  color: #aaa;
  line-height: 1;
  margin-bottom: 1px;
}

.nav-logo-name {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 22px;
  font-weight: 900;
  color: var(--navy);
  text-transform: uppercase;
  letter-spacing: 0.05em;
  line-height: 1;
}

.nav-logo-name em {
  font-style: normal;
  color: var(--orange);
}

/* small icon before name */
.nav-logo-icon {
  width: 36px;
  height: 36px;
  background: var(--navy);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  position: relative;
  overflow: hidden;
  transition: background 0.3s;
}

.nav-logo-icon::after {
  content: '';
  position: absolute;
  inset: 0;
  background: var(--orange);
  transform: translateY(100%);
  transition: transform 0.3s ease;
}

.nav-logo:hover .nav-logo-icon::after { transform: translateY(0); }
.nav-logo-icon svg { position: relative; z-index: 1; color: #fff; }

/* ── Centre links ─────────────── */
.nav-links {
  list-style: none;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.nav-links li a {
  display: block;
  font-size: 17px;
  font-weight: 600;
  color: #2C3E50;
  text-decoration: none;
  padding: 6px 16px;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  position: relative;
  transition: color 0.2s;
}

/* underline animation */
.nav-links li a::after {
  content: '';
  position: absolute;
  bottom: 0; left: 16px; right: 16px;
  height: 2px;
  background: var(--orange);
  transform: scaleX(0);
  transition: transform 0.25s ease;
  transform-origin: center;
}

.nav-links li a:hover { color: var(--orange); }
.nav-links li a:hover::after { transform: scaleX(1); }
.nav-links li a.active { color: var(--orange); }
.nav-links li a.active::after { transform: scaleX(1); }

/* separator between last nav link and buttons */
.nav-sep {
  width: 1px;
  height: 22px;
  background: #e0e0e0;
  margin: 0 4px;
  flex-shrink: 0;
}

/* ── Right actions ────────────── */
.nav-actions {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-shrink: 0;
}

/* Connexion — text only, subtle */
.btn-connexion {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  font-weight: 600;
  color: #555;
  text-decoration: none;
  padding: 8px 16px;
  letter-spacing: 0.03em;
  border-radius: 4px;
  transition: color 0.2s, background 0.2s;
}

.btn-connexion:hover { color: var(--navy); background: #f2f3f5; }

/* S'inscrire — orange filled, arrow shape */
.btn-inscrire {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: var(--orange);
  color: #fff;
  font-family: 'Barlow', sans-serif;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: 0.04em;
  padding: 10px 22px;
  text-decoration: none;
  border-radius: 4px;
  white-space: nowrap;
  transition: background 0.25s, transform 0.2s, box-shadow 0.2s;
  position: relative;
  overflow: hidden;
}

.btn-inscrire::before {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(255,255,255,0.14);
  transform: translateX(-110%) skew(-8deg);
  transition: transform 0.35s ease;
}

.btn-inscrire:hover::before { transform: translateX(110%) skew(-8deg); }
.btn-inscrire:hover {
  background: #d04208;
  transform: translateY(-1px);
  box-shadow: 0 6px 20px rgba(232,80,10,0.35);
}

/* ── Mobile hamburger ─────────── */
.nav-toggle {
  display: none;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 5px;
  width: 40px; height: 40px;
  background: none;
  border: 1.5px solid #ddd;
  border-radius: 4px;
  cursor: pointer;
  flex-shrink: 0;
}

.nav-toggle span {
  display: block;
  width: 18px; height: 1.5px;
  background: var(--navy);
  border-radius: 2px;
  transition: all 0.3s;
}

.nav-toggle.open span:nth-child(1) { transform: translateY(6.5px) rotate(45deg); }
.nav-toggle.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.nav-toggle.open span:nth-child(3) { transform: translateY(-6.5px) rotate(-45deg); }

/* ── Mobile drawer ────────────── */
.nav-overlay {
  position: fixed; inset: 0;
  background: rgba(13,27,46,0.25);
  backdrop-filter: blur(4px);
  z-index: 997;
  opacity: 0; pointer-events: none;
  transition: opacity 0.3s;
}

.nav-overlay.open { opacity: 1; pointer-events: all; }

.nav-mobile {
  position: fixed;
  top: 0; right: 0; bottom: 0;
  width: min(300px, 85vw);
  background: #fff;
  z-index: 998;
  padding: 80px 28px 40px;
  display: flex;
  flex-direction: column;
  gap: 0;
  border-left: 3px solid var(--orange);
  box-shadow: -12px 0 40px rgba(0,0,0,0.12);
  transform: translateX(100%);
  transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
  overflow-y: auto;
}

.nav-mobile.open { transform: translateX(0); }

.nm-close {
  position: absolute;
  top: 18px; right: 18px;
  width: 32px; height: 32px;
  background: none;
  border: 1px solid #eee;
  border-radius: 4px;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  color: #999;
  font-size: 18px;
  line-height: 1;
}

.nm-group-label {
  font-size: 9px;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: #bbb;
  font-weight: 700;
  margin: 20px 0 8px;
}

.nm-link {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 15px;
  font-weight: 600;
  color: var(--navy);
  text-decoration: none;
  padding: 13px 0;
  border-bottom: 1px solid #f0f0f0;
  letter-spacing: 0.03em;
  transition: color 0.2s;
}

.nm-link:hover { color: var(--orange); }

.nm-actions {
  margin-top: 28px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.nm-btn-login {
  padding: 13px;
  border: 1.5px solid #ddd;
  border-radius: 4px;
  text-align: center;
  font-size: 14px;
  font-weight: 600;
  color: var(--navy);
  text-decoration: none;
}

.nm-btn-register {
  padding: 13px;
  background: var(--orange);
  border-radius: 4px;
  text-align: center;
  font-size: 14px;
  font-weight: 700;
  color: #fff;
  text-decoration: none;
}

/* ─── RESPONSIVE ─────────────── */
@media (max-width: 900px) {
  .nav-inner { grid-template-columns: auto 1fr auto; }
  .nav-links { display: none; }
  .nav-sep { display: none; }
  .btn-connexion { display: none; }
  .btn-inscrire { display: none; }
  .nav-toggle { display: flex; }
  .nav-actions { gap: 0; }
}

/* ─── DEMO BODY ──────────────── */
.demo-hero {
  min-height: 88vh;
  background: linear-gradient(135deg, #0D1B2E 0%, #1A3050 50%, #0D1B2E 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 12px;
}

.demo-sup {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: 11px;
  letter-spacing: 0.25em;
  text-transform: uppercase;
  color: rgba(255,255,255,0.25);
}

.demo-title {
  font-family: 'Barlow Condensed', sans-serif;
  font-size: clamp(60px, 10vw, 120px);
  font-weight: 900;
  text-transform: uppercase;
  color: rgba(255,255,255,0.05);
  letter-spacing: -0.02em;
}

.demo-title span { color: rgba(232,80,10,0.12); }
</style>
</head>
<body>

{{-- ═══ NAVBAR ═══ --}}
<header class="site-nav" id="siteNav">
  <div class="nav-inner">

    {{-- Logo --}}
    <a href="{{ route('home') }}" class="nav-logo">
            @vite(['resources/css/app.css', 'resources/js/app.js'])
      <div class="nav-logo-icon">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
        </svg>
      </div>
      <div class="nav-logo-mark">
        <span class="nav-logo-top">Auto-École · Safi</span>
        <span class="nav-logo-name">Jan<em>oub</em></span>
      </div>
    </a>

    {{-- Centre links --}}
    <ul class="nav-links">
      <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a></li>
      <li><a href="{{ route('formations.public') }}" class="{{ request()->routeIs('formations.*') ? 'active' : '' }}">Formations</a></li>
  <li>
<a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
Contact
</a>
</li>
<li>
<a href="{{ route('apropos') }}"
class="{{ request()->routeIs('apropos') ? 'active' : '' }}">
À propos
</a>
</li>
    </ul>

    {{-- Actions --}}
    <div class="nav-actions">
      @auth
        <a href="{{ url('/dashboard') }}" class="btn-connexion">
          Mon Espace
        </a>
      @else
        {{-- Separator --}}
        <span class="nav-sep"></span>

        <a href="{{ route('login') }}" class="btn-connexion">
          Connexion
        </a>

        <a href="{{ route('register') }}" class="btn-inscrire">
          <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
          S'inscrire
        </a>
      @endauth

      {{-- Mobile toggle --}}
      <button class="nav-toggle" id="navToggle" aria-label="Ouvrir le menu">
        <span></span><span></span><span></span>
      </button>
    </div>

  </div>
</header>

{{-- Overlay + Mobile drawer --}}
<div class="nav-overlay" id="navOverlay"></div>

<nav class="nav-mobile" id="navMobile" aria-hidden="true">
  <button class="nm-close" id="navClose" aria-label="Fermer">✕</button>

  <div class="nm-group-label">Navigation</div>
  <a href="{{ route('home') }}" class="nm-link">
    Accueil
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
  </a>
  <a href="{{ route('formations.public') }}" class="nm-link">
    Formations
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
  </a>
  <a href="#contact" class="nm-link">
    Contact
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
  </a>

  <div class="nm-actions">
    @auth
      <a href="{{ url('/dashboard') }}" class="nm-btn-login">Mon Espace →</a>
    @else
      <a href="{{ route('login') }}" class="nm-btn-login">Connexion</a>
      <a href="{{ route('register') }}" class="nm-btn-register">S'inscrire →</a>
    @endauth
  </div>
</nav>

{{-- ─── CONTENT ─────────────────────────────── --}}
    <main>
        @yield('content')
    </main>

<script>
  // Scroll shadow
  const nav = document.getElementById('siteNav');
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 8);
  }, { passive: true });

  // Mobile menu
  const toggle   = document.getElementById('navToggle');
  const mobile   = document.getElementById('navMobile');
  const overlay  = document.getElementById('navOverlay');
  const closeBtn = document.getElementById('navClose');

  function openMenu()  {
    mobile.classList.add('open'); overlay.classList.add('open');
    toggle.classList.add('open');
    mobile.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeMenu() {
    mobile.classList.remove('open'); overlay.classList.remove('open');
    toggle.classList.remove('open');
    mobile.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  toggle.addEventListener('click', () =>
    mobile.classList.contains('open') ? closeMenu() : openMenu()
  );

  overlay.addEventListener('click', closeMenu);
  closeBtn.addEventListener('click', closeMenu);

  mobile.querySelectorAll('a').forEach(a =>
    a.addEventListener('click', closeMenu)
  );

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeMenu();
  });
</script>

</body>
</html>
