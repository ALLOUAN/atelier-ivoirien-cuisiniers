@extends('site.layouts.site')

@php($packages = $site->cateringPackages())

@push('styles')
    .events { display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; margin-bottom: 48px; }
    .events span { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border: 1px solid var(--line); border-radius: var(--pill); font-weight: 600; font-size: .9rem; color: var(--ink); }

    .pkg-photo { position: relative; display: block; margin: -26px -26px 22px; aspect-ratio: 16 / 10; overflow: hidden; border-radius: var(--radius-lg) var(--radius-lg) 0 0; }
    .pkg-photo img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .8s var(--ease); }
    .card:hover .pkg-photo img { transform: scale(1.06); }
    .pkg-photo .tag { position: absolute; left: 14px; bottom: 14px; background: rgb(255 255 255 / .92); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); box-shadow: var(--shadow-sm); }
    .card.featured .pkg-photo { border-radius: calc(var(--radius-lg) - 1px) calc(var(--radius-lg) - 1px) 0 0; }
    .card.featured::before { z-index: 2; }
    .pkg-price { margin-top: auto; padding-top: 18px; border-top: 1px dashed var(--line); font-size: .85rem; color: var(--muted); }
    .pkg-price b { display: block; font-family: var(--heading); font-size: 1.35rem; letter-spacing: -.02em; color: var(--navy); }

    .timeline { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; counter-reset: t; position: relative; }
    .timeline::before { content: ''; position: absolute; top: 27px; left: 16%; right: 16%; height: 2px; background: var(--line); }
    .timeline div { position: relative; text-align: center; padding: 0 12px; }
    .timeline div::before { counter-increment: t; content: counter(t); position: relative; display: grid; place-items: center; width: 56px; height: 56px; margin: 0 auto 18px; border-radius: 50%; background: var(--navy); color: #fff; font-family: var(--heading); font-weight: 700; font-size: 1.2rem; box-shadow: 0 0 0 8px #fff, inset 0 -3px 0 var(--gold); }
    .timeline h3 { margin-bottom: 6px; }
    .timeline p { color: var(--muted); font-size: .95rem; margin: 0; }
    @media (max-width: 760px) { .timeline { grid-template-columns: 1fr; } .timeline::before { display: none; } }

    .quote-layout { display: grid; grid-template-columns: .85fr 1.15fr; gap: 56px; align-items: start; }
    .quote-aside { position: sticky; top: 110px; }
    .quote-aside ul { list-style: none; padding: 0; margin: 24px 0 0; display: grid; gap: 14px; }
    .quote-aside li { display: flex; gap: 14px; align-items: flex-start; }
    .quote-aside li span { width: 40px; height: 40px; border-radius: 12px; display: grid; place-items: center; background: var(--orange-50); flex: none; }
    .quote-aside li b { display: block; color: var(--navy); }
    .quote-aside li p { margin: 0; font-size: .9rem; color: var(--muted); }
    .quote-form { padding: 32px; box-shadow: var(--shadow-lg); }
    .estimate { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-top: 22px; padding: 18px 20px; border-radius: var(--radius); background: var(--navy); color: #c9d3e2; font-size: .85rem; }
    .estimate b { display: block; font-family: var(--heading); font-size: 1.4rem; letter-spacing: -.02em; color: #fff; }
    .estimate small { color: #9fb0c8; }
    .estimate .badge { padding: 5px 11px; border-radius: var(--pill); background: rgb(255 255 255 / .1); color: #fff; font-weight: 600; font-size: .78rem; white-space: nowrap; }
    @media (max-width: 900px) { .quote-layout { grid-template-columns: 1fr; gap: 32px; } .quote-aside { position: static; } }
@endpush

@section('page_head')
    <h1>Traiteur & événements</h1>
    <p class="lead" style="margin: 0;">Mariages, baptêmes, anniversaires, funérailles, séminaires : nos chefs cuisinent pour 20 à 300 personnes, livré et dressé.</p>
    <div class="head-stats">
        <div><span aria-hidden="true">👥</span><p><b>20 à 300 invités</b>du repas de famille au mariage</p></div>
        <div><span aria-hidden="true">⚡</span><p><b>Devis en 24 h</b>gratuit et sans engagement</p></div>
        <div><span aria-hidden="true">🍽️</span><p><b>Livré et dressé</b>service et vaisselle possibles</p></div>
    </div>
@endsection

@section('content')
    <section class="section" style="padding-top: 32px;">
        <div class="wrap">
            <div class="events" aria-label="Événements couverts">
                @foreach (['💍 Mariages', '👶 Baptêmes', '🎂 Anniversaires', '🕊️ Funérailles', '💼 Séminaires', '☕ Pauses-café'] as $event)
                    <span>{{ $event }}</span>
                @endforeach
            </div>
            <div class="center" style="margin-bottom: 44px;">
                <span class="eyebrow">Nos formules</span>
                <h2>Choisissez la base, on adapte le reste</h2>
            </div>
            <div class="grid grid-3">
                @foreach ($packages as $package)
                    <article @class(['card', 'hover', 'featured' => $package['featured']]) data-badge="Le plus choisi">
                        <div class="pkg-photo"><img src="{{ $site->photo($package['image']) }}" alt="{{ $package['name'] }}" loading="lazy"><span class="tag">👥 {{ $package['guests'] }}</span></div>
                        <h3>{{ $package['name'] }}</h3>
                        <ul class="bullets">
                            @foreach ($package['items'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                        <div class="pkg-price">Tarif<b>{{ $package['price'] }}</b></div>
                        <a class="btn {{ $package['featured'] ? 'btn-primary' : 'btn-ghost' }} btn-sm btn-block mt-1" href="#devis" data-package="{{ $package['name'] }}">Choisir cette formule</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="wrap">
            <div class="center" style="margin-bottom: 48px;">
                <span class="eyebrow">Comment ça se passe</span>
                <h2>De la demande au jour J</h2>
            </div>
            <div class="timeline">
                <div><h3>Vous décrivez l’événement</h3><p>Date, nombre d’invités, lieu et envies : le formulaire ci-dessous suffit.</p></div>
                <div><h3>Devis et menu validés</h3><p>Nous vous envoyons un devis détaillé sur WhatsApp, ajusté avec vous.</p></div>
                <div><h3>Nous cuisinons et dressons</h3><p>Le jour J, nos chefs livrent, installent le buffet et assurent le service.</p></div>
            </div>
        </div>
    </section>

    <section class="section" id="devis" style="padding-top: 0;">
        <div class="wrap quote-layout">
            <div class="quote-aside">
                <span class="eyebrow">Devis gratuit</span>
                <h2>Décrivez votre événement</h2>
                <p class="lead">Nous vous répondons sur WhatsApp avec un devis détaillé, en général dans la journée.</p>
                <ul>
                    <li><span aria-hidden="true">🧾</span><div><b>Sans engagement</b><p>Le devis est gratuit, vous validez seulement s’il vous convient.</p></div></li>
                    <li><span aria-hidden="true">💳</span><div><b>Acompte par Mobile Money</b><p>Wave, Orange Money, MTN ou Moov, le solde le jour J.</p></div></li>
                    <li><span aria-hidden="true">🥘</span><div><b>Menu sur mesure</b><p>Plats ivoiriens, grillades, desserts : composez selon vos invités.</p></div></li>
                </ul>
            </div>
            <form class="card quote-form" data-quote>
                <div class="form-grid">
                    <label class="field">Votre nom<input class="input" name="nom" required autocomplete="name"></label>
                    <label class="field">Type d’événement
                        <select class="input" name="evenement">
                            @foreach (['Mariage', 'Baptême', 'Anniversaire', 'Funérailles', 'Séminaire / entreprise', 'Autre'] as $event)
                                <option>{{ $event }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="field">Date<input class="input" type="date" name="date" required></label>
                    <label class="field">Nombre de personnes<input class="input" type="number" name="personnes" min="10" step="10" value="50" required></label>
                    <label class="field">Formule
                        <select class="input" name="formule">
                            @foreach ($packages as $package)
                                <option data-per-guest="{{ (int) preg_replace('/\D/', '', $package['price']) }}">{{ $package['name'] }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="field">Lieu<input class="input" name="lieu" placeholder="Ex. salle à Riviera 3"></label>
                    <label class="field full">Précisions (plats souhaités, service…)<textarea class="input" name="details"></textarea></label>
                </div>
                <div class="estimate" aria-live="polite">
                    <div><small>Budget indicatif</small><b data-estimate>—</b></div>
                    <span class="badge" data-estimate-note>Estimation</span>
                </div>
                <button class="btn btn-primary btn-block mt-2" type="submit"><svg class="wa-ico"><use href="#wa"/></svg>Envoyer ma demande sur WhatsApp</button>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (() => {
            const quote = document.querySelector('[data-quote]');
            const estimate = quote.querySelector('[data-estimate]');
            const note = quote.querySelector('[data-estimate-note]');

            // A rough "from" budget: guests × the package's starting price per guest.
            const update = () => {
                const perGuest = Number(quote.formule.selectedOptions[0].dataset.perGuest);
                const guests = Number(quote.personnes.value) || 0;
                estimate.textContent = perGuest && guests ? 'dès ' + AIC.money(perGuest * guests) : 'Sur devis';
                note.textContent = perGuest ? guests + ' × ' + AIC.money(perGuest) : 'Selon le besoin';
            };

            document.querySelectorAll('[data-package]').forEach((link) => link.addEventListener('click', () => { quote.formule.value = link.dataset.package; update(); }));
            quote.formule.addEventListener('change', update);
            quote.personnes.addEventListener('input', update);
            update();

            quote.addEventListener('submit', (event) => {
                event.preventDefault();
                const f = quote.elements;
                AIC.send(['Bonjour, je souhaite un devis traiteur :', '• Événement : ' + f.evenement.value, '• Date : ' + f.date.value, '• Personnes : ' + f.personnes.value,
                    '• Formule : ' + f.formule.value, f.lieu.value ? '• Lieu : ' + f.lieu.value : '', f.details.value ? '• Précisions : ' + f.details.value : '', '', 'Nom : ' + f.nom.value]
                    .filter(Boolean).join('\n'));
            });
        })();
    </script>
@endpush
