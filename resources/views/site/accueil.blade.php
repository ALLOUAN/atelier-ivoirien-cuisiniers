@extends('site.layouts.site')

@push('styles')
    .hero-shell { padding: 8px 0 0; }
    .banner { position: relative; width: min(1440px, 100% - 24px); margin-inline: auto; min-height: clamp(580px, 84vh, 760px); overflow: hidden; border-radius: var(--radius-xl); background: var(--navy); color: #fff; isolation: isolate; }
    .slide { position: absolute; inset: 0; display: flex; align-items: center; opacity: 0; visibility: hidden; transition: opacity 1s var(--ease), visibility 1s; }
    .slide.is-active { opacity: 1; visibility: visible; }
    .slide img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; transform: scale(1.1); transition: transform 8s ease-out; }
    .slide.is-active img { transform: scale(1); }
    .slide::before { content: ''; position: absolute; inset: 0; background: rgb(2 23 50 / .6); z-index: 1; }
    .slide .wrap { position: relative; z-index: 2; padding-bottom: 60px; }
    .slide-content { max-width: 700px; }
    .slide-content > * { opacity: 0; transform: translateY(18px); transition: opacity .7s var(--ease), transform .7s var(--ease); }
    .slide.is-active .slide-content > * { opacity: 1; transform: none; }
    .slide.is-active .slide-content > :nth-child(2) { transition-delay: .1s; }
    .slide.is-active .slide-content > :nth-child(3) { transition-delay: .2s; }
    .slide.is-active .slide-content > :nth-child(4) { transition-delay: .3s; }
    .slide.is-active .slide-content > :nth-child(5) { transition-delay: .4s; }
    .slide .eyebrow { color: #fff; background: rgb(255 255 255 / .1); border-color: rgb(255 255 255 / .22); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); }
    .slide .eyebrow::before { background: var(--orange-on-dark); }
    .slide h1, .slide .h1 { font-family: var(--heading); font-weight: 700; font-size: clamp(2.4rem, 6vw, 4.4rem); letter-spacing: -.035em; line-height: 1.02; color: #fff; margin: 0 0 22px; }
    .slide h1 em, .slide .h1 em { font-style: normal; color: var(--orange-on-dark); display: block; }
    .slide p { color: #e8edf5; font-size: 1.15rem; max-width: 560px; }
    .hero-ctas { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 32px; }
    .btn-light { border-color: rgb(255 255 255 / .4); color: #fff; background: rgb(255 255 255 / .08); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); }
    .btn-light:hover { background: #fff; border-color: #fff; color: var(--navy); }
    .next-session { display: inline-flex; align-items: center; gap: 10px; background: rgb(255 255 255 / .1); border: 1px solid rgb(255 255 255 / .22); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); border-radius: var(--pill); padding: 7px 16px 7px 12px; font-size: .86rem; margin-bottom: 14px; }
    .next-session b { color: #fff; }
    .live { position: relative; width: 8px; height: 8px; border-radius: 50%; background: #3ddc84; flex: none; }
    .live::after { content: ''; position: absolute; inset: 0; border-radius: 50%; background: #3ddc84; animation: ping 2s var(--ease) infinite; }

    .banner-nav { position: absolute; z-index: 3; left: 0; right: 0; bottom: 96px; }
    .banner-nav .wrap { display: flex; align-items: center; gap: 18px; }
    .counter { font-family: var(--heading); font-weight: 600; font-size: .85rem; color: #c9d3e2; font-variant-numeric: tabular-nums; }
    .counter b { color: #fff; }
    .dots { display: flex; gap: 8px; }
    .dots button { position: relative; width: 44px; height: 4px; border-radius: 4px; border: 0; background: rgb(255 255 255 / .28); cursor: pointer; padding: 0; overflow: hidden; }
    .dots button::after { content: ''; position: absolute; inset: 0; background: var(--orange-on-dark); transform: scaleX(0); transform-origin: left; }
    .dots button[aria-current="true"] { width: 72px; }
    .dots button[aria-current="true"]::after { animation: fill 6.5s linear forwards; }
    .banner.is-paused .dots button::after { animation-play-state: paused; }
    @keyframes fill { to { transform: scaleX(1); } }
    .arrows { margin-left: auto; display: flex; gap: 10px; }
    .arrows button { width: 50px; height: 50px; border-radius: 50%; border: 1px solid rgb(255 255 255 / .3); background: rgb(255 255 255 / .08); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); color: #fff; font-size: 1.3rem; cursor: pointer; transition: background .2s, border-color .2s, transform .2s var(--ease); }
    .arrows button:hover { background: var(--orange); border-color: var(--orange); transform: scale(1.06); }

    .stats { position: relative; z-index: 4; margin-top: -64px; display: grid; grid-template-columns: repeat(4, 1fr); background: #fff; border: 1px solid var(--line); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); overflow: hidden; }
    .stats div { padding: 26px 28px; font-size: .88rem; color: var(--muted); position: relative; }
    .stats div + div::before { content: ''; position: absolute; left: 0; top: 24px; bottom: 24px; width: 1px; background: var(--line); }
    .stats b { display: block; font-family: var(--heading); font-size: 2.1rem; font-weight: 700; letter-spacing: -.03em; color: var(--navy); line-height: 1.1; margin-bottom: 2px; }
    .stats b em { font-style: normal; color: var(--orange); }
    .stats b .star { color: var(--gold); }
    .chips { display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; padding: 32px 0 0; }
    .chips span { display: inline-flex; align-items: center; gap: 8px; padding: 9px 16px; border: 1px solid var(--line); border-radius: var(--pill); font-size: .88rem; font-weight: 600; color: var(--ink); background: #fff; }
    .chips span::before { content: '✓'; display: grid; place-items: center; width: 20px; height: 20px; border-radius: 50%; background: var(--orange-50); color: var(--orange-text); font-size: .7rem; font-weight: 800; }

    @media (max-width: 800px) {
        .banner { min-height: 0; display: grid; border-radius: var(--radius-lg); width: calc(100% - 16px); }
        .slide { position: relative; grid-area: 1 / 1; padding: 56px 0 110px; align-items: flex-start; }
        .slide .wrap { padding-bottom: 0; }
        .banner-nav { position: relative; grid-area: 1 / 1; align-self: end; bottom: auto; padding-bottom: 32px; }
        .arrows { display: none; }
        .stats { margin-top: 16px; grid-template-columns: 1fr 1fr; }
        .stats div { padding: 18px 20px; }
        .stats div + div::before { display: none; }
        .stats div:nth-child(2n) { border-left: 1px solid var(--line); }
        .stats div:nth-child(n + 3) { border-top: 1px solid var(--line); }
        .stats b { font-size: 1.6rem; }
    }
    @media (prefers-reduced-motion: reduce) {
        .slide, .slide img, .slide-content > * { transition: none; }
        .dots button[aria-current="true"]::after { animation: none; transform: scaleX(1); }
        .live::after { display: none; }
    }


    .steps { counter-reset: s; }
    .step { position: relative; background: #fff; border: 1px solid var(--line); border-radius: var(--radius-lg); padding: 32px; overflow: hidden; transition: transform .35s var(--ease), box-shadow .35s var(--ease), border-color .35s; }
    .step:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); border-color: var(--orange-100); }
    .step::after { counter-increment: s; content: counter(s, decimal-leading-zero); position: absolute; top: 18px; right: 24px; font-family: var(--heading); font-weight: 700; font-size: 3.6rem; letter-spacing: -.04em; line-height: 1; color: var(--navy-50); }
    .step .icon-box { position: relative; z-index: 1; margin-bottom: 22px; }
    .step h3 { position: relative; } .step p { color: var(--muted); margin: 0; font-size: .95rem; }

    .mosaic { display: grid; grid-template-columns: 1.6fr 1fr 1fr; grid-template-rows: 250px 250px; gap: 16px; }
    .mosaic a { position: relative; overflow: hidden; border-radius: var(--radius-lg); }
    .mosaic a:first-child { grid-row: span 2; }
    .mosaic img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .8s var(--ease); }
    .mosaic a:hover img { transform: scale(1.06); }
    .mosaic span { position: absolute; left: 14px; bottom: 14px; background: rgb(255 255 255 / .9); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); color: var(--navy); font-size: .82rem; font-weight: 600; padding: 7px 14px; border-radius: var(--pill); box-shadow: var(--shadow-sm); transition: transform .3s var(--ease); }
    .mosaic a:hover span { transform: translateY(-3px); }
    @media (max-width: 760px) { .mosaic { grid-template-columns: 1fr 1fr; grid-template-rows: 260px 170px 170px; gap: 12px; } .mosaic a:first-child { grid-column: span 2; grid-row: auto; } }

    .cta-band { position: relative; overflow: hidden; border-radius: var(--radius-xl); padding: 80px 64px; display: flex; justify-content: space-between; align-items: center; gap: 28px; flex-wrap: wrap; color: #fff; isolation: isolate; }
    .cta-band img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: -2; transition: transform 1.2s var(--ease); }
    .cta-band:hover img { transform: scale(1.04); }
    .cta-band::before { content: ''; position: absolute; inset: 0; background: rgb(2 23 50 / .74); z-index: -1; }
    .cta-band::after { content: ''; position: absolute; left: 64px; bottom: 0; width: 96px; height: 4px; border-radius: 4px 4px 0 0; background: var(--gold); }
    .cta-band h2 { color: #fff; margin-bottom: 8px; }
    .cta-band p { margin: 0; color: #e8edf5; font-size: 1.08rem; max-width: 520px; }
    @media (max-width: 640px) { .cta-band { padding: 48px 28px; border-radius: var(--radius-lg); } .cta-band::after { left: 28px; } }
@endpush

@section('content')
    @php($nextSession = collect($site->sessions())->firstWhere('left', '>', 0))

    <div class="hero-shell">
        <section class="banner" aria-roledescription="carrousel" aria-label="À la une" data-banner>
            @foreach ($site->banners() as $banner)
                <div @class(['slide', 'is-active' => $loop->first]) role="group" aria-roledescription="diapositive" aria-label="{{ $loop->iteration }} sur {{ $loop->count }}" @unless ($loop->first) aria-hidden="true" @endunless>
                    <img src="{{ $site->photo($banner['image']) }}" alt="" @if ($loop->first) fetchpriority="high" @else loading="lazy" @endif>
                    <div class="wrap">
                        <div class="slide-content">
                            @if ($loop->first && $nextSession)
                                <div><span class="next-session"><span class="live" aria-hidden="true"></span>Prochaine rentrée : <b>{{ $nextSession['start'] }}</b> · {{ $nextSession['left'] }} places</span></div>
                            @endif
                            <div><span class="eyebrow">{{ $banner['eyebrow'] }}</span></div>
                            @if ($loop->first)
                                <h1>{{ $banner['title'] }} <em>{{ $banner['highlight'] }}</em></h1>
                            @else
                                <h2 class="h1">{{ $banner['title'] }} <em>{{ $banner['highlight'] }}</em></h2>
                            @endif
                            <p>{{ $banner['text'] }}</p>
                            <div class="hero-ctas">
                                <a class="btn btn-primary" href="{{ $site->url($banner['cta_page']) }}">{{ $banner['cta'] }}</a>
                                <a class="btn btn-light" href="{{ $site->url($banner['secondary_page']) }}">{{ $banner['secondary'] }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="banner-nav">
                <div class="wrap">
                    <span class="counter" aria-hidden="true"><b data-counter>01</b> / {{ sprintf('%02d', count($site->banners())) }}</span>
                    <div class="dots">
                        @foreach ($site->banners() as $banner)
                            <button type="button" aria-label="Diapositive {{ $loop->iteration }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" data-go="{{ $loop->index }}"></button>
                        @endforeach
                    </div>
                    <div class="arrows">
                        <button type="button" aria-label="Précédente" data-step="-1">‹</button>
                        <button type="button" aria-label="Suivante" data-step="1">›</button>
                    </div>
                </div>
            </div>
        </section>

        <div class="wrap">
            <div class="stats">
                <div><b>10<em>+</em></b>années d’expérience</div>
                <div><b>500<em>+</em></b>élèves formés</div>
                <div><b>4,9 <span class="star">★</span></b>note des avis clients</div>
                <div><b>12</b>élèves maximum par groupe</div>
            </div>
            <div class="chips">
                <span>Formation culinaire à Cocody</span>
                <span>Paiement Wave & Mobile Money</span>
                <span>Attestation de fin de formation</span>
                <span>Livraison Cocody & Riviera</span>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="wrap">
            <div class="section-head">
                <div>
                    <span class="eyebrow">Nos formations</span>
                    <h2>Un métier entre vos mains</h2>
                    <p class="lead" style="margin: 0;">Des cours 80 % pratiques, en petits groupes, pour cuisiner à la maison ou lancer votre activité.</p>
                </div>
                <a class="more" href="{{ $site->url('formations') }}">Toutes les formations</a>
            </div>
            <div class="grid grid-4">
                @foreach (array_slice($site->trainings(), 0, 4) as $training)
                    @include('site.partials.training-card')
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="wrap">
            <div class="section-head">
                <div>
                    <span class="eyebrow">Menu en ligne</span>
                    <h2>Les plats de nos chefs, livrés chez vous</h2>
                    <p class="lead" style="margin: 0;">Choisissez, puis envoyez : votre commande arrive toute prête sur notre WhatsApp.</p>
                </div>
                <a class="more" href="{{ $site->url('menu') }}">Menu complet</a>
            </div>
            @include('site.partials.menu-order', ['categories' => ['Plats ivoiriens', 'Boissons']])
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="wrap">
            <div class="center">
                <span class="eyebrow">Simple comme un message</span>
                <h2>Comment ça marche ?</h2>
                <p class="lead">Trois étapes, aucun compte à créer : tout se passe sur WhatsApp.</p>
            </div>
            <div class="grid grid-3 steps mt-2">
                <div class="step"><span class="icon-box" aria-hidden="true">📱</span><h3>Vous choisissez</h3><p>Une formation ou des plats, depuis votre téléphone, à toute heure.</p></div>
                <div class="step"><span class="icon-box" aria-hidden="true">💬</span><h3>Vous envoyez sur WhatsApp</h3><p>Le message est déjà rédigé : détail, quantités et total. Il suffit d’appuyer sur « Envoyer ».</p></div>
                <div class="step"><span class="icon-box" aria-hidden="true">✅</span><h3>Nous confirmons</h3><p>Nous vous répondons rapidement pour valider la date, la livraison et le paiement.</p></div>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="wrap">
            <div class="section-head">
                <div>
                    <span class="eyebrow">La vie de l’atelier</span>
                    <h2>Dans nos cuisines</h2>
                </div>
                <a class="more" href="{{ $site->url('galerie') }}">Toute la galerie</a>
            </div>
            <div class="mosaic">
                @foreach (array_slice($site->gallery(), 0, 5) as $item)
                    <a href="{{ $site->url('galerie') }}"><img src="{{ $site->photo($item['image']) }}" alt="{{ $item['label'] }}" loading="lazy"><span>{{ $item['label'] }}</span></a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="wrap">
            <div class="section-head">
                <div>
                    <span class="eyebrow">Ils nous font confiance</span>
                    <h2>Ce que disent nos élèves et clients</h2>
                </div>
                <a class="more" href="{{ $site->url('avis') }}">Tous les avis</a>
            </div>
            <div class="grid grid-3">
                @foreach (array_slice($site->reviews(), 0, 3) as $review)
                    @include('site.partials.review-card')
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="wrap">
            <div class="cta-band">
                <img src="{{ $site->photo('salle') }}" alt="" loading="lazy">
                <div>
                    <span class="eyebrow" style="color: #fff; background: rgb(255 255 255 / .1); border-color: rgb(255 255 255 / .22);">Traiteur & événements</span>
                    <h2>Un événement à préparer ?</h2>
                    <p>Mariages, baptêmes, séminaires : nos chefs cuisinent pour 20 à 300 personnes.</p>
                </div>
                <a class="btn btn-primary" href="{{ $site->url('traiteur') }}">Demander un devis gratuit</a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (() => {
            const banner = document.querySelector('[data-banner]');
            const slides = [...banner.querySelectorAll('.slide')];
            const dots = [...banner.querySelectorAll('[data-go]')];
            const counter = banner.querySelector('[data-counter]');
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            let current = 0;
            let timer = null;

            const show = (index) => {
                current = (index + slides.length) % slides.length;
                slides.forEach((slide, i) => {
                    slide.classList.toggle('is-active', i === current);
                    slide.setAttribute('aria-hidden', i === current ? 'false' : 'true');
                    slide.querySelectorAll('a').forEach((link) => { link.tabIndex = i === current ? 0 : -1; });
                });
                dots.forEach((dot, i) => dot.setAttribute('aria-current', i === current ? 'true' : 'false'));
                counter.textContent = String(current + 1).padStart(2, '0');
            };
            const pause = () => { clearInterval(timer); banner.classList.add('is-paused'); };
            const play = () => {
                clearInterval(timer);
                banner.classList.remove('is-paused');
                // Restart the progress bar so it stays in step with the timer.
                dots[current].setAttribute('aria-current', 'false');
                void dots[current].offsetWidth;
                dots[current].setAttribute('aria-current', 'true');
                if (!reducedMotion) { timer = setInterval(() => show(current + 1), 6500); }
            };

            dots.forEach((dot) => dot.addEventListener('click', () => { show(Number(dot.dataset.go)); play(); }));
            banner.querySelectorAll('[data-step]').forEach((button) => button.addEventListener('click', () => { show(current + Number(button.dataset.step)); play(); }));
            banner.addEventListener('mouseenter', pause);
            banner.addEventListener('mouseleave', play);
            banner.addEventListener('focusin', pause);

            let touchStart = null;
            banner.addEventListener('touchstart', (event) => { touchStart = event.touches[0].clientX; }, { passive: true });
            banner.addEventListener('touchend', (event) => {
                const distance = event.changedTouches[0].clientX - touchStart;
                if (Math.abs(distance) > 50) { show(current + (distance < 0 ? 1 : -1)); play(); }
            });

            show(0);
            play();
        })();
    </script>
@endpush
