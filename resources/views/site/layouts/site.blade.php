@extends('site.layouts.base')

@php
    $navigation = ['' => 'Accueil', 'formations' => 'Formations', 'calendrier' => 'Calendrier', 'menu' => 'Menu', 'traiteur' => 'Traiteur', 'atelier' => 'L’atelier', 'contact' => 'Contact'];
@endphp

@push('styles')
    .header { position: sticky; top: 0; z-index: 50; background: rgb(255 255 255 / .82); -webkit-backdrop-filter: saturate(180%) blur(16px); backdrop-filter: saturate(180%) blur(16px); border-bottom: 1px solid transparent; transition: border-color .3s, box-shadow .3s; }
    .header.is-scrolled { border-bottom-color: var(--line); box-shadow: 0 8px 30px -12px rgb(2 23 50 / .12); }
    .header .wrap { display: flex; align-items: center; justify-content: space-between; height: 78px; gap: 20px; }
    .logo { display: flex; align-items: center; gap: 12px; font-family: var(--heading); font-weight: 700; color: var(--navy); line-height: 1.1; text-transform: uppercase; letter-spacing: .02em; font-size: .95rem; }
    .logo-mark { position: relative; width: 46px; height: 46px; border-radius: 14px; display: grid; place-items: center; background: var(--navy); color: #fff; font-size: .95rem; overflow: hidden; flex: none; transition: transform .4s var(--ease); }
    .logo:hover .logo-mark { transform: rotate(-6deg) scale(1.04); }
    .logo-mark::after { content: ''; position: absolute; right: 0; bottom: 0; border-left: 16px solid transparent; border-bottom: 16px solid var(--gold); }
    .logo small { display: block; font-weight: 600; color: var(--orange); font-size: .78rem; text-transform: none; letter-spacing: 0; }
    .nav { display: flex; gap: 2px; font-weight: 600; font-size: .92rem; color: var(--ink); }
    .nav a { padding: 9px 14px; border-radius: var(--pill); transition: background .2s, color .2s; }
    .nav a:hover { background: var(--navy-50); color: var(--navy); }
    .nav a[aria-current="page"] { color: var(--orange-text); background: var(--orange-50); }
    .menu-toggle { display: none; }
    @media (max-width: 1080px) {
        .header .nav { display: none; }
        .menu-toggle { display: block; position: relative; }
        .menu-toggle summary { list-style: none; cursor: pointer; width: 46px; height: 46px; border: 1px solid var(--line); border-radius: 50%; display: grid; place-items: center; font-size: 1.2rem; color: var(--navy); background: #fff; }
        .menu-toggle summary::-webkit-details-marker { display: none; }
        .menu-toggle[open] summary { background: var(--navy); color: #fff; border-color: var(--navy); }
        .menu-toggle .nav { display: grid; gap: 2px; position: absolute; right: 0; top: 58px; width: 260px; background: #fff; border: 1px solid var(--line); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); padding: 10px; animation: drop .25s var(--ease); }
        .menu-toggle .nav a { padding: 11px 14px; border-radius: var(--radius-sm); }
        .header .cta-wa span { display: none; }
        .header .cta-wa { padding: 12px; }
    }
    @keyframes drop { from { opacity: 0; transform: translateY(-8px) scale(.98); } }
    .header-actions { display: flex; gap: 10px; align-items: center; }

    .page-head { position: relative; background: #fff; padding: 64px 0 56px; overflow: hidden; }
    .page-head h1 { font-size: clamp(2rem, 4.6vw, 3.3rem); }
    .page-head.has-photo .wrap { position: relative; display: grid; grid-template-columns: 1.1fr .9fr; gap: 56px; align-items: center; }
    .page-photo { position: relative; margin: 0; aspect-ratio: 5 / 4; border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow-lg); }
    .page-photo img { width: 100%; height: 100%; object-fit: cover; display: block; animation: settle 1.4s var(--ease) both; }
    .page-photo::after { content: ''; position: absolute; left: 24px; right: 24px; bottom: 0; height: 4px; border-radius: 4px 4px 0 0; background: var(--gold); }
    @keyframes settle { from { transform: scale(1.08); } }
    @media (prefers-reduced-motion: reduce) { .page-photo img { animation: none; } }
    @media (max-width: 860px) {
        .page-head.has-photo .wrap { grid-template-columns: 1fr; gap: 28px; }
        .page-head.has-photo .page-photo { order: -1; aspect-ratio: 16 / 9; border-radius: var(--radius-lg); }
        .page-head { padding: 24px 0 40px; }
    }
    .crumbs { display: inline-flex; align-items: center; gap: 6px; font-size: .82rem; font-weight: 500; color: var(--muted); margin-bottom: 18px; padding: 6px 14px; border: 1px solid var(--line); border-radius: var(--pill); }
    .crumbs a:hover { color: var(--orange-text); }
    .head-stats { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 28px; }
    .head-stats div { display: flex; align-items: center; gap: 12px; padding: 10px 18px 10px 10px; border: 1px solid var(--line); border-radius: var(--pill); background: #fff; font-size: .85rem; color: var(--muted); line-height: 1.25; }
    .head-stats span { width: 38px; height: 38px; border-radius: 50%; display: grid; place-items: center; background: var(--orange-50); font-size: 1.05rem; flex: none; }
    .head-stats p { margin: 0; }
    .head-stats b { display: block; color: var(--navy); font-family: var(--heading); font-size: .98rem; }

    .section-head { display: flex; justify-content: space-between; align-items: end; gap: 24px; flex-wrap: wrap; margin-bottom: 44px; }
    .section-head h2 { margin-bottom: 10px; }
    .more { display: inline-flex; align-items: center; gap: 10px; font-weight: 600; color: var(--navy); padding: 11px 20px; border: 1px solid var(--line-strong); border-radius: var(--pill); transition: background .2s, color .2s, border-color .2s; }
    .more::after { content: '→'; transition: transform .25s var(--ease); }
    .more:hover { background: var(--navy); border-color: var(--navy); color: #fff; }
    .more:hover::after { transform: translateX(4px); }

    .help { display: grid; grid-template-columns: 1fr auto; gap: 28px; align-items: center; padding: 40px 44px; border: 1px solid var(--line); border-radius: var(--radius-xl); box-shadow: var(--shadow); position: relative; overflow: hidden; }
    .help::before { content: ''; position: absolute; left: 0; top: 32px; bottom: 32px; width: 4px; border-radius: 0 4px 4px 0; background: var(--orange); }
    .help h2 { font-size: clamp(1.4rem, 2.6vw, 1.9rem); margin-bottom: 8px; }
    .help p { margin: 0; color: var(--muted); }
    .help-actions { display: flex; flex-wrap: wrap; gap: 10px; }
    @media (max-width: 700px) { .help { grid-template-columns: 1fr; padding: 32px 26px; border-radius: var(--radius-lg); } }

    .tiles { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(220px, 100%), 1fr)); gap: 16px; }
    .tile { padding: 24px; border: 1px solid var(--line); border-radius: var(--radius-lg); background: #fff; transition: transform .35s var(--ease), box-shadow .35s var(--ease), border-color .35s; }
    .tile:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--orange-100); }
    .tile .icon-box { width: 48px; height: 48px; font-size: 1.4rem; }
    .tile h3 { font-size: 1rem; margin-bottom: 4px; }
    .tile p { margin: 0; font-size: .9rem; color: var(--muted); }

    .footer { background: var(--navy); color: #9fb0c8; font-size: .92rem; padding: 80px 0 32px; margin-top: 40px; border-radius: var(--radius-xl) var(--radius-xl) 0 0; position: relative; }
    .footer::before { content: ''; position: absolute; top: 0; left: 50%; translate: -50% 0; width: 120px; height: 4px; border-radius: 0 0 4px 4px; background: var(--gold); }
    .footer h4 { color: #fff; font-size: .82rem; text-transform: uppercase; letter-spacing: .1em; margin-bottom: 18px; }
    .footer-grid { display: grid; grid-template-columns: 1.4fr 1fr 1fr 1fr; gap: 40px; }
    .footer ul { list-style: none; padding: 0; margin: 0; display: grid; gap: 10px; }
    .footer a { transition: color .2s; }
    .footer a:hover { color: var(--orange-on-dark); }
    .footer .logo, .footer .logo small { color: #fff; }
    .footer .logo small { color: var(--orange-on-dark); }
    .footer .logo-mark { background: var(--navy-800); box-shadow: inset 0 0 0 1px var(--navy-700); }
    .footer-bottom { margin-top: 56px; padding-top: 24px; border-top: 1px solid var(--navy-700); display: flex; flex-wrap: wrap; justify-content: space-between; gap: 10px; font-size: .82rem; }
    .pay-badges { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 18px; }
    .pay-badges span { background: var(--navy-800); border: 1px solid var(--navy-700); color: #e8edf5; font-size: .72rem; font-weight: 600; padding: 6px 11px; border-radius: var(--pill); }
    @media (max-width: 900px) { .footer-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 520px) { .footer-grid { grid-template-columns: 1fr; } .footer { border-radius: var(--radius-lg) var(--radius-lg) 0 0; padding-top: 60px; } }

    .wa-float { position: fixed; right: 22px; bottom: 22px; z-index: 60; width: 60px; height: 60px; border-radius: 50%; background: var(--wa); color: #fff; display: grid; place-items: center; box-shadow: 0 12px 28px -6px rgba(37, 211, 102, .6); transition: transform .3s var(--ease); }
    .wa-float:hover { transform: scale(1.08) rotate(-6deg); }
    .wa-float::before { content: ''; position: absolute; inset: 0; border-radius: 50%; border: 2px solid var(--wa); animation: ping 2.4s var(--ease) infinite; }
    @keyframes ping { 70%, 100% { transform: scale(1.5); opacity: 0; } }
    @media (prefers-reduced-motion: reduce) { .wa-float::before { display: none; } }
    .wa-float svg { width: 30px; height: 30px; }
    .mobile-bar { display: none; }
    @media (max-width: 700px) {
        .section { padding: 72px 0; }
        .wa-float { display: none; }
        body { padding-bottom: 96px; }
        .mobile-bar { display: grid; grid-template-columns: repeat(4, 1fr); gap: 4px; position: fixed; left: 12px; right: 12px; bottom: calc(12px + env(safe-area-inset-bottom)); z-index: 60; background: rgb(255 255 255 / .88); -webkit-backdrop-filter: saturate(180%) blur(16px); backdrop-filter: saturate(180%) blur(16px); border: 1px solid var(--line); border-radius: 22px; padding: 6px; box-shadow: var(--shadow-lg); }
        .mobile-bar a { text-align: center; font-size: .7rem; font-weight: 600; color: var(--navy); display: grid; gap: 2px; justify-items: center; padding: 7px 4px; border-radius: 16px; }
        .mobile-bar a span { font-size: 1.2rem; }
        .mobile-bar a[aria-current="page"] { background: var(--orange-50); color: var(--orange-text); }
        .mobile-bar a.wa { background: var(--orange); color: #fff; }
    }
@endpush

@section('body')
    <header class="header" data-header>
        <div class="wrap">
            <a href="{{ $site->url() }}" class="logo">
                <span class="logo-mark">{{ $business['short'] }}</span>
                <span>Atelier Ivoirien<small>des Cuisiniers · Cocody</small></span>
            </a>
            <nav class="nav" aria-label="Navigation principale">
                @foreach ($navigation as $slug => $label)
                    <a href="{{ $site->url($slug) }}" @if ($currentPage === $slug) aria-current="page" @endif>{{ $label }}</a>
                @endforeach
            </nav>
            <div class="header-actions">
                <a class="btn btn-primary btn-sm cta-wa" href="{{ $site->url('inscription') }}">🎓<span>S’inscrire</span></a>
                <details class="menu-toggle">
                    <summary aria-label="Ouvrir le menu">☰</summary>
                    <nav class="nav" aria-label="Navigation mobile">
                        @foreach ($navigation + ['reussites' => 'Réussites', 'galerie' => 'Galerie', 'avis' => 'Avis', 'faq' => 'FAQ'] as $slug => $label)
                            <a href="{{ $site->url($slug) }}" @if ($currentPage === $slug) aria-current="page" @endif>{{ $label }}</a>
                        @endforeach
                    </nav>
                </details>
            </div>
        </div>
    </header>

    <main>
        @hasSection('page_head')
            <section @class(['page-head', 'has-photo' => $pagePhoto])>
                <div class="wrap">
                    <div>
                        <div class="crumbs"><a href="{{ $site->url() }}">Accueil</a> › @yield('crumbs', $pageTitle)</div>
                        @yield('page_head')
                    </div>
                    @if ($pagePhoto)
                        <figure class="page-photo"><img src="{{ $site->photo($pagePhoto) }}" alt="" fetchpriority="high"></figure>
                    @endif
                </div>
            </section>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        <div class="wrap">
            <div class="footer-grid">
                <div>
                    <a href="{{ $site->url() }}" class="logo"><span class="logo-mark">{{ $business['short'] }}</span><span>Atelier Ivoirien<small>des Cuisiniers</small></span></a>
                    <p class="mt-1">École de cuisine, menu du jour et service traiteur à {{ $business['city'] }}.</p>
                    <div class="pay-badges"><span>Wave</span><span>Orange Money</span><span>MTN MoMo</span><span>Moov</span><span>Espèces</span></div>
                </div>
                <div>
                    <h4>Formations</h4>
                    <ul>
                        @foreach (array_slice($site->trainings(), 0, 4) as $training)
                            <li><a href="{{ route('training', $training['slug']) }}">{{ $training['title'] }}</a></li>
                        @endforeach
                        <li><a href="{{ $site->url('calendrier') }}">Calendrier des sessions</a></li>
                    </ul>
                </div>
                <div>
                    <h4>L’atelier</h4>
                    <ul>
                        <li><a href="{{ $site->url('atelier') }}">L’atelier & les chefs</a></li>
                        <li><a href="{{ $site->url('reussites') }}">Réussites d’élèves</a></li>
                        <li><a href="{{ $site->url('galerie') }}">Galerie</a></li>
                        <li><a href="{{ $site->url('avis') }}">Avis clients</a></li>
                        <li><a href="{{ $site->url('faq') }}">Questions fréquentes</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Nous joindre</h4>
                    <ul>
                        <li>📍 {{ $business['address'] }}</li>
                        <li>🕗 {{ $business['hours'] }}</li>
                        <li>📞 <a href="tel:{{ str_replace(' ', '', $business['phone']) }}">{{ $business['phone'] }}</a></li>
                        <li><a href="{{ $site->url('contact') }}">Plan d’accès →</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>© {{ now()->year }} {{ $business['name'] }}</span>
                <span><a href="{{ $site->url('mentions-legales') }}">Mentions légales</a> · <a href="{{ $site->url('mentions-legales') }}#credits">Crédits photos</a> · <a href="{{ $site->url('gerant') }}">Espace gérant</a></span>
            </div>
        </div>
    </footer>

    <a class="wa-float" href="{{ $site->whatsappLink('Bonjour, j’ai une question.') }}" target="_blank" rel="noopener" aria-label="Écrire sur WhatsApp"><svg><use href="#wa"/></svg></a>

    <nav class="mobile-bar" aria-label="Accès rapide">
        <a href="{{ $site->url('formations') }}" @if ($currentPage === 'formations') aria-current="page" @endif><span>🎓</span>Formations</a>
        <a href="{{ $site->url('menu') }}" @if ($currentPage === 'menu') aria-current="page" @endif><span>🍲</span>Menu</a>
        <a href="{{ $site->url('calendrier') }}" @if ($currentPage === 'calendrier') aria-current="page" @endif><span>📅</span>Sessions</a>
        <a class="wa" href="{{ $site->whatsappLink('Bonjour, j’ai une question.') }}" target="_blank" rel="noopener"><span>💬</span>WhatsApp</a>
    </nav>
@endsection

@push('scripts')
    <script>
        (() => {
            const header = document.querySelector('[data-header]');
            const update = () => header.classList.toggle('is-scrolled', window.scrollY > 8);
            window.addEventListener('scroll', update, { passive: true });
            update();
        })();
    </script>
@endpush
