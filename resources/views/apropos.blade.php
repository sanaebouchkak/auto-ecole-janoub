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
    --text:   #5a6a7a;
    --border: #e2e8f0;
  }

  .ap * { box-sizing: border-box; margin: 0; padding: 0; }

  .ap {
    font-family: 'Barlow', sans-serif;
    background: var(--gray);
    color: var(--navy);
  }

  /* ── HEADER ── */
  .ap-header {
    background: var(--navy);
    padding: 80px 0 64px;
    text-align: center;
    position: relative;
  }

  .ap-header::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 4px;
    background: var(--orange);
  }

  .ap-tag {
    display: inline-block;
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 0.25em;
    text-transform: uppercase;
    color: var(--orange);
    margin-bottom: 14px;
  }

  .ap-header h1 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 3.8rem;
    color: var(--white);
    letter-spacing: 3px;
    line-height: 1;
  }

  .ap-header p {
    color: rgba(255,255,255,0.5);
    font-size: 0.95rem;
    font-weight: 300;
    margin-top: 12px;
  }

  /* ── STATS ── */
  .ap-stats {
    background: var(--orange);
  }

  .ap-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    max-width: 960px;
    margin: 0 auto;
  }

  .ap-stat {
    padding: 32px 20px;
    text-align: center;
    border-right: 1px solid rgba(255,255,255,0.22);
  }

  .ap-stat:last-child { border-right: none; }

  .ap-stat-num {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 2.8rem;
    color: var(--white);
    line-height: 1;
    letter-spacing: 1px;
  }

  .ap-stat-lbl {
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.8);
    margin-top: 6px;
  }

  /* ── SECTIONS ── */
  .ap-section {
    padding: 80px 0;
  }

  .ap-section.dark {
    background: var(--navy);
  }

  .ap-section.light {
    background: var(--white);
  }

  .ap-section.gray {
    background: var(--gray);
  }

  .ap-wrap {
    max-width: 960px;
    margin: 0 auto;
    padding: 0 24px;
  }

  /* eyebrow */
  .ap-eyebrow {
    font-size: 0.68rem;
    font-weight: 600;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--orange);
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
  }

  .ap-eyebrow::before {
    content: '';
    width: 22px; height: 2px;
    background: var(--orange);
    flex-shrink: 0;
  }

  .ap-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(2.2rem, 4vw, 3.2rem);
    letter-spacing: 2px;
    line-height: 1;
    margin-bottom: 20px;
  }

  .ap-title.light-text { color: var(--white); }
  .ap-title.dark-text  { color: var(--navy); }

  .ap-body {
    font-size: 0.92rem;
    font-weight: 300;
    line-height: 1.8;
    color: var(--text);
    margin-bottom: 14px;
  }

  .ap-body.light-text { color: rgba(255,255,255,0.6); }

  /* ── WHO GRID ── */
  .ap-who-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    align-items: center;
  }

  /* image placeholder */
  .ap-img-box {
    background: var(--navy2);
    aspect-ratio: 4/3;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
  }

  .ap-img-box::before {
    content: '';
    position: absolute;
    inset: 16px;
    border: 1px solid rgba(232,82,10,0.3);
    pointer-events: none;
  }

  .ap-img-label {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 0.9rem;
    letter-spacing: 4px;
    color: rgba(255,255,255,0.12);
  }

  .ap-badge {
    position: absolute;
    bottom: 0; right: 0;
    background: var(--orange);
    padding: 18px 22px;
    text-align: center;
  }

  .ap-badge strong {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 2.2rem;
    color: white;
    display: block;
    line-height: 1;
  }

  .ap-badge span {
    font-size: 0.62rem;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.85);
  }

  /* ── VALUES ── */
  .ap-values-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2px;
    margin-top: 48px;
  }

  .ap-val-card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    padding: 40px 30px;
    position: relative;
    transition: background 0.2s;
  }

  .ap-val-card:hover { background: rgba(255,255,255,0.09); }

  .ap-val-card::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 0; height: 3px;
    background: var(--orange);
    transition: width 0.3s;
  }

  .ap-val-card:hover::after { width: 100%; }

  .ap-val-num {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 3rem;
    color: rgba(232,82,10,0.15);
    line-height: 1;
    margin-bottom: 12px;
  }

  .ap-val-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.4rem;
    color: var(--white);
    letter-spacing: 1px;
    margin-bottom: 12px;
  }

  .ap-val-body {
    font-size: 0.85rem;
    font-weight: 300;
    color: rgba(255,255,255,0.5);
    line-height: 1.7;
  }

  /* ── TEAM ── */
  .ap-team-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
    margin-top: 48px;
  }

  .ap-team-card {
    background: var(--white);
    overflow: hidden;
    border-bottom: 3px solid var(--border);
    transition: border-color 0.2s, transform 0.2s, box-shadow 0.2s;
  }

  .ap-team-card:hover {
    border-bottom-color: var(--orange);
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.1);
  }

  .ap-team-photo {
    height: 220px;
    background: linear-gradient(135deg, var(--navy2), var(--navy));
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 0.8rem;
    letter-spacing: 4px;
    color: rgba(255,255,255,0.1);
  }

  .ap-team-info {
    padding: 22px 24px 26px;
  }

  .ap-team-name {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.3rem;
    color: var(--navy);
    letter-spacing: 1px;
    margin-bottom: 4px;
  }

  .ap-team-role {
    font-size: 0.68rem;
    font-weight: 600;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--orange);
    margin-bottom: 10px;
  }

  .ap-team-bio {
    font-size: 0.83rem;
    font-weight: 300;
    color: var(--text);
    line-height: 1.65;
  }

  /* ── CTA ── */
  .ap-cta {
    background: var(--navy);
    padding: 72px 0;
    text-align: center;
    border-top: 4px solid var(--orange);
  }

  .ap-cta h2 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(2rem, 5vw, 3.5rem);
    color: var(--white);
    letter-spacing: 3px;
    margin-bottom: 28px;
  }

  .ap-cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: var(--orange);
    color: var(--white);
    text-decoration: none;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.05rem;
    letter-spacing: 2px;
    padding: 15px 42px;
    border-radius: 2px;
    transition: background 0.2s, transform 0.15s;
  }

  .ap-cta-btn:hover {
    background: #c4420a;
    transform: translateY(-2px);
    color: var(--white);
    text-decoration: none;
  }

  .ap-cta-btn svg { transition: transform 0.2s; }
  .ap-cta-btn:hover svg { transform: translateX(4px); }

  /* ── RESPONSIVE ── */
  @media (max-width: 760px) {
    .ap-stats-grid      { grid-template-columns: repeat(2, 1fr); }
    .ap-who-grid        { grid-template-columns: 1fr; gap: 36px; }
    .ap-values-grid     { grid-template-columns: 1fr; gap: 12px; }
    .ap-team-grid       { grid-template-columns: 1fr 1fr; }
    .ap-header h1       { font-size: 2.8rem; }
  }

  @media (max-width: 520px) {
    .ap-team-grid { grid-template-columns: 1fr; }
    .ap-stat { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.2); }
  }
</style>

<div class="ap">

  {{-- ── HEADER ── --}}
  <div class="ap-header">
    <span class="ap-tag">Notre école</span>
    <h1>À PROPOS DE NOUS</h1>
    <p>Votre partenaire de confiance pour l'apprentissage de la conduite.</p>
  </div>

  {{-- ── STATS ── --}}
  <div class="ap-stats">
    <div class="ap-stats-grid">
      <div class="ap-stat">
        <div class="ap-stat-num">15+</div>
        <div class="ap-stat-lbl">Années d'expérience</div>
      </div>
      <div class="ap-stat">
        <div class="ap-stat-num">4 200</div>
        <div class="ap-stat-lbl">Élèves formés</div>
      </div>
      <div class="ap-stat">
        <div class="ap-stat-num">92%</div>
        <div class="ap-stat-lbl">Taux de réussite</div>
      </div>
      <div class="ap-stat">
        <div class="ap-stat-num">8</div>
        <div class="ap-stat-lbl">Moniteurs diplômés</div>
      </div>
    </div>
  </div>

  {{-- ── QUI SOMMES-NOUS ── --}}
  <section class="ap-section light">
    <div class="ap-wrap">
      <div class="ap-who-grid">

        <div>
          <div class="ap-eyebrow">Notre histoire</div>
          <h2 class="ap-title dark-text">UNE ÉCOLE À VOTRE SERVICE</h2>
          <p class="ap-body">
            Fondée en 2009, notre auto-école repose sur une conviction simple :
            apprendre à conduire doit être une expérience positive, encadrée
            par des professionnels passionnés et disponibles.
          </p>
          <p class="ap-body">
            Nous proposons des formations adaptées à chaque profil : permis B classique,
            conduite accompagnée, permis moto — avec du matériel pédagogique moderne
            et un accompagnement personnalisé.
          </p>
          <p class="ap-body">
            Notre priorité : votre réussite et votre sécurité sur la route.
          </p>
        </div>

        <div class="ap-img-box">
          <span class="ap-img-label">DRIVER SCHOOL</span>
          {{-- Remplacez par : <img src="{{ asset('images/about.jpg') }}" alt="École de conduite" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;"> --}}
          <div class="ap-badge">
            <strong>15</strong>
            <span>ans<br>d'excellence</span>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ── VALEURS ── --}}
  <section class="ap-section dark">
    <div class="ap-wrap">
      <div class="ap-eyebrow">Ce qui nous guide</div>
      <h2 class="ap-title light-text">NOS VALEURS</h2>
      <div class="ap-values-grid">
        <div class="ap-val-card">
          <div class="ap-val-num">01</div>
          <div class="ap-val-title">Sécurité</div>
          <p class="ap-val-body">
            La sécurité routière est au cœur de chaque leçon.
            Nous inculquons les bons réflexes dès le premier cours
            pour former des conducteurs responsables à vie.
          </p>
        </div>
        <div class="ap-val-card">
          <div class="ap-val-num">02</div>
          <div class="ap-val-title">Pédagogie</div>
          <p class="ap-val-body">
            Chaque élève est unique. Nos moniteurs adaptent
            leur approche à votre rythme et vos axes de progression
            pour un apprentissage efficace.
          </p>
        </div>
        <div class="ap-val-card">
          <div class="ap-val-num">03</div>
          <div class="ap-val-title">Confiance</div>
          <p class="ap-val-body">
            Un environnement bienveillant où vous progressez sans stress,
            développez votre confiance au volant et abordez l'examen
            en toute sérénité.
          </p>
        </div>
      </div>
    </div>
  </section>

  {{-- ── ÉQUIPE ── --}}
  <section class="ap-section gray">
    <div class="ap-wrap">
      <div class="ap-eyebrow">Les professionnels</div>
      <h2 class="ap-title dark-text">NOTRE ÉQUIPE</h2>
      <div class="ap-team-grid">

        <div class="ap-team-card">
          <div class="ap-team-photo">PHOTO</div>
          <div class="ap-team-info">
            <div class="ap-team-name">Marc Lefebvre</div>
            <div class="ap-team-role">Directeur & Moniteur</div>
            <p class="ap-team-bio">
              Moniteur agréé depuis 18 ans, Marc a fondé l'école avec la volonté
              d'offrir une formation de qualité accessible à tous.
            </p>
          </div>
        </div>

        <div class="ap-team-card">
          <div class="ap-team-photo">PHOTO</div>
          <div class="ap-team-info">
            <div class="ap-team-name">Sophie Martin</div>
            <div class="ap-team-role">Monitrice & Formatrice</div>
            <p class="ap-team-bio">
              Spécialiste de la conduite accompagnée, Sophie accompagne
              les jeunes conducteurs avec patience et bienveillance.
            </p>
          </div>
        </div>

        <div class="ap-team-card">
          <div class="ap-team-photo">PHOTO</div>
          <div class="ap-team-info">
            <div class="ap-team-name">Karim Benali</div>
            <div class="ap-team-role">Moniteur Moto & Code</div>
            <p class="ap-team-bio">
              Expert en permis moto et formation au code, Karim rend
              chaque session rigoureuse et motivante.
            </p>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ── CTA ── --}}
  <div class="ap-cta">
    <div class="ap-wrap">
      <h2>PRÊT À DÉMARRER VOTRE FORMATION ?</h2>
      <a href="{{ route('register') }}" class="ap-cta-btn">
      inscrire maintenant
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5">
          <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
      </a>
    </div>
  </div>

</div>

@endsection