@extends('layouts.public')

@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@300;400;500;600&display=swap');

  :root {
    --navy:   #0d1b2a;
    --navy2:  #162537;
    --orange: #e8520a;
    --white:  #ffffff;
    --gray:   #f7f8fa;
    --text:   #4a5568;
    --border: #e2e8f0;
  }

  .cp * { box-sizing: border-box; margin: 0; padding: 0; }

  .cp {
    font-family: 'Barlow', sans-serif;
    background: var(--gray);
    min-height: 100vh;
  }

  /* ── HEADER ── */
  .cp-header {
    background: var(--navy);
    padding: 70px 0 60px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .cp-header::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 4px;
    background: var(--orange);
  }

  .cp-header-tag {
    display: inline-block;
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 0.25em;
    text-transform: uppercase;
    color: var(--orange);
    margin-bottom: 14px;
  }

  .cp-header h1 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 3.8rem;
    color: var(--white);
    letter-spacing: 3px;
    line-height: 1;
  }

  .cp-header p {
    color: rgba(255,255,255,0.55);
    font-size: 0.95rem;
    font-weight: 300;
    margin-top: 12px;
  }

  /* ── BODY ── */
  .cp-body {
    padding: 60px 0 80px;
  }

  .cp-wrap {
    max-width: 920px;
    margin: 0 auto;
    padding: 0 24px;
  }

  /* ── SUCCESS ── */
  .cp-success {
    background: #fff;
    border-left: 4px solid var(--orange);
    padding: 16px 22px;
    font-size: 0.9rem;
    color: var(--navy);
    margin-bottom: 32px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  /* ── CARD ── */
  .cp-card {
    background: var(--white);
    display: grid;
    grid-template-columns: 300px 1fr;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
  }

  /* ── SIDEBAR ── */
  .cp-side {
    background: var(--navy);
    padding: 48px 36px;
    display: flex;
    flex-direction: column;
    gap: 36px;
  }

  .cp-side-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.5rem;
    color: var(--white);
    letter-spacing: 2px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
  }

  .cp-info {
    display: flex;
    flex-direction: column;
    gap: 28px;
  }

  .cp-info-item {}

  .cp-info-label {
    font-size: 0.65rem;
    font-weight: 600;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--orange);
    display: block;
    margin-bottom: 6px;
  }

  .cp-info-val {
    font-size: 0.9rem;
    font-weight: 300;
    color: rgba(255,255,255,0.75);
    line-height: 1.6;
  }

  .cp-info-val a {
    color: rgba(255,255,255,0.75);
    text-decoration: none;
  }

  .cp-info-val a:hover { color: var(--orange); }

  .cp-online {
    margin-top: auto;
    display: flex;
    align-items: center;
    gap: 10px;
    padding-top: 28px;
    border-top: 1px solid rgba(255,255,255,0.08);
  }

  .cp-dot {
    width: 8px; height: 8px;
    background: #48bb78;
    border-radius: 50%;
    flex-shrink: 0;
    box-shadow: 0 0 0 3px rgba(72,187,120,0.25);
  }

  .cp-online-txt {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.45);
    font-weight: 300;
  }

  /* ── FORM AREA ── */
  .cp-form-area {
    padding: 48px 52px;
  }

  .cp-form-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 2rem;
    color: var(--navy);
    letter-spacing: 2px;
    margin-bottom: 4px;
  }

  .cp-form-sub {
    font-size: 0.85rem;
    color: var(--text);
    font-weight: 300;
    margin-bottom: 36px;
  }

  .cp-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
  }

  .cp-field {
    margin-bottom: 20px;
  }

  .cp-label {
    display: block;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--navy);
    margin-bottom: 8px;
  }

  .cp-input {
    width: 100%;
    border: 1.5px solid var(--border);
    background: var(--gray);
    padding: 12px 16px;
    font-family: 'Barlow', sans-serif;
    font-size: 0.92rem;
    font-weight: 300;
    color: var(--navy);
    outline: none;
    border-radius: 2px;
    transition: border-color 0.2s, background 0.2s;
  }

  .cp-input::placeholder { color: #b0bac8; }

  .cp-input:focus {
    border-color: var(--orange);
    background: var(--white);
  }

  .cp-input.is-invalid { border-color: #e53e3e; }

  textarea.cp-input {
    resize: vertical;
    min-height: 120px;
    line-height: 1.65;
  }

  .cp-error {
    font-size: 0.75rem;
    color: #e53e3e;
    margin-top: 5px;
    font-weight: 400;
  }

  /* ── FOOTER ── */
  .cp-form-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 32px;
    padding-top: 28px;
    border-top: 1.5px solid var(--border);
    gap: 20px;
    flex-wrap: wrap;
  }

  .cp-privacy {
    font-size: 0.78rem;
    color: #a0aec0;
    font-weight: 300;
    max-width: 260px;
    line-height: 1.6;
  }

  .cp-btn {
    background: var(--orange);
    color: var(--white);
    border: none;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.05rem;
    letter-spacing: 2px;
    padding: 14px 44px;
    cursor: pointer;
    border-radius: 2px;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    transition: background 0.2s, transform 0.15s;
    white-space: nowrap;
  }

  .cp-btn:hover {
    background: #c4420a;
    transform: translateY(-2px);
  }

  .cp-btn svg { transition: transform 0.2s; }
  .cp-btn:hover svg { transform: translateX(4px); }

  /* ── RESPONSIVE ── */
  @media (max-width: 760px) {
    .cp-card { grid-template-columns: 1fr; }
    .cp-side { padding: 36px 28px; }
    .cp-form-area { padding: 36px 28px; }
    .cp-row { grid-template-columns: 1fr; gap: 0; }
    .cp-form-footer { flex-direction: column; align-items: flex-start; }
    .cp-header h1 { font-size: 2.8rem; }
  }
</style>

<div class="cp">

  {{-- HEADER --}}
  <div class="cp-header">
    <span class="cp-header-tag">Contactez-nous</span>
    <h1>PARLONS-NOUS</h1>
    <p>Notre équipe vous répond sous 24h.</p>
  </div>

  {{-- BODY --}}
  <div class="cp-body">
    <div class="cp-wrap">

      @if(session('success'))
        <div class="cp-success">
          <span style="color:var(--orange); font-size:1.1rem;">✓</span>
          {{ session('success') }}
        </div>
      @endif

      <div class="cp-card">

        {{-- SIDEBAR --}}
        <aside class="cp-side">
          <div class="cp-side-title">NOS COORDONNÉES</div>

          <div class="cp-info">
            <div class="cp-info-item">
              <span class="cp-info-label">Adresse</span>
              <span class="cp-info-val">12 Rue de la Conduite<br>ASFI, MAROC</span>
            </div>
            <div class="cp-info-item">
              <span class="cp-info-label">Téléphone</span>
              <span class="cp-info-val">
                <a href="tel:+212522123456">+212 6 22 12 34 56</a>
              </span>
            </div>
            <div class="cp-info-item">
              <span class="cp-info-label">Email</span>
              <span class="cp-info-val">
                <a href="mailto:contact@driverschool.fr">contact@autoecoleJANOUB.Mc</a>
              </span>
            </div>
            <div class="cp-info-item">
              <span class="cp-info-label">Horaires</span>
              <span class="cp-info-val">
                Lun – Ven : 9h – 18h<br>
                Samedi : 9h – 13h
              </span>
            </div>
          </div>

          <div class="cp-online">
            <div class="cp-dot"></div>
            <span class="cp-online-txt">Réponse garantie sous 24h ouvrées</span>
          </div>
        </aside>

        {{-- FORM --}}
        <div class="cp-form-area">
          <div class="cp-form-title">VOTRE MESSAGE</div>
          <p class="cp-form-sub">Tous les champs marqués sont obligatoires.</p>

          <form action="{{ route('contact.send') }}" method="POST" novalidate>
            @csrf

            <div class="cp-row">
              <div class="cp-field">
                <label class="cp-label" for="name">Nom complet *</label>
                <input
                  type="text" id="name" name="name"
                  class="cp-input @error('name') is-invalid @enderror"
                  placeholder="Jean Dupont"
                  value="{{ old('name') }}" required
                >
                @error('name')<div class="cp-error">{{ $message }}</div>@enderror
              </div>

              <div class="cp-field">
                <label class="cp-label" for="email">Email *</label>
                <input
                  type="email" id="email" name="email"
                  class="cp-input @error('email') is-invalid @enderror"
                  placeholder="jean@exemple.maroc"
                  value="{{ old('email') }}" required
                >
                @error('email')<div class="cp-error">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="cp-row">
              <div class="cp-field">
                <label class="cp-label" for="phone">Téléphone</label>
                <input
                  type="tel" id="phone" name="phone"
                  class="cp-input"
                  placeholder="+212 6 00 00 00 00"
                  value="{{ old('phone') }}"
                >
              </div>

              <div class="cp-field">
                <label class="cp-label" for="subject">Sujet *</label>
                <input
                  type="text" id="subject" name="subject"
                  class="cp-input @error('subject') is-invalid @enderror"
                  placeholder="Permis B, AAC…"
                  value="{{ old('subject') }}"
                >
                @error('subject')<div class="cp-error">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="cp-field">
              <label class="cp-label" for="message">Message *</label>
              <textarea
                id="message" name="message"
                class="cp-input @error('message') is-invalid @enderror"
                placeholder="Écrivez votre message ici…"
                required
              >{{ old('message') }}</textarea>
              @error('message')<div class="cp-error">{{ $message }}</div>@enderror
            </div>

            <div class="cp-form-footer">
              <p class="cp-privacy">
                Vos données restent confidentielles et ne seront jamais partagées avec des tiers.
              </p>
              <button type="submit" class="cp-btn">
                Envoyer
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5">
                  <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
              </button>
            </div>

          </form>
        </div>

      </div>
    </div>
  </div>

</div>

@endsection