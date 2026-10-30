@extends('site.layouts.site')

@php($zones = $site->deliveryZones())

@push('styles')
    .zones { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(210px, 100%), 1fr)); gap: 16px; }
    .zone { display: grid; gap: 14px; padding: 24px; border: 1px solid var(--line); border-radius: var(--radius-lg); background: #fff; transition: transform .35s var(--ease), box-shadow .35s var(--ease), border-color .35s; }
    .zone:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--orange-100); }
    .zone.free { border-color: var(--success); box-shadow: 0 0 0 4px var(--success-bg); }
    .zone-top { display: flex; justify-content: space-between; align-items: center; gap: 10px; }
    .zone-top > span:first-child { width: 42px; height: 42px; border-radius: 14px; display: grid; place-items: center; background: var(--orange-50); font-size: 1.2rem; }
    .zone.free .zone-top > span:first-child { background: var(--success-bg); }
    .zone h3 { font-size: 1rem; margin: 0; }
    .zone-bottom { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: baseline; gap: 4px 10px; white-space: nowrap; padding-top: 14px; border-top: 1px dashed var(--line); font-size: .85rem; color: var(--muted); }
    .zone-bottom b { font-family: var(--heading); font-size: 1.15rem; color: var(--navy); }
    .zone.free .zone-bottom b { color: var(--success); }

    .slots { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(260px, 100%), 1fr)); gap: 16px; margin-top: 16px; }
    .slot { display: flex; align-items: center; gap: 16px; padding: 18px 22px; border-radius: var(--radius-lg); border: 1px solid var(--line); }
    .slot span { font-size: 1.6rem; }
    .slot b { display: block; color: var(--navy); font-family: var(--heading); }
    .slot p { margin: 0; font-size: .88rem; color: var(--muted); }
    .status { display: inline-flex; align-items: center; gap: 8px; font-size: .78rem; font-weight: 700; padding: 5px 12px; border-radius: var(--pill); background: var(--success-bg); color: var(--success); }
    .status::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: currentColor; }
    .status.closed { background: var(--navy-50); color: var(--muted); }
@endpush

@section('page_head')
    <h1>Menu & commandes</h1>
    <p class="lead" style="margin: 0;">Cuisiné chaque matin par nos chefs et nos élèves en fin de formation. Commandez jusqu’à 11h pour le déjeuner, 17h pour le dîner.</p>
    <div class="head-stats">
        <div><span aria-hidden="true">🍲</span><p><b>{{ collect($site->menu())->flatten(1)->count() }} plats & boissons</b>préparés le jour même</p></div>
        <div><span aria-hidden="true">🛵</span><p><b>Livraison dès {{ $site->money(collect($zones)->min('fee')) }}</b>Cocody, Riviera & alentours</p></div>
        <div><span aria-hidden="true">💳</span><p><b>Wave, MoMo, espèces</b>payé à la livraison</p></div>
    </div>
@endsection

@section('content')
    <section class="section" style="padding-top: 32px;">
        <div class="wrap">
            <div class="section-head" style="margin-bottom: 28px;">
                <div>
                    <span class="eyebrow">À la carte</span>
                    <h2 style="margin: 0;">Composez votre commande</h2>
                </div>
                <span class="status" data-status>Commandes ouvertes</span>
            </div>
            @include('site.partials.menu-order')
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="wrap">
            <div class="section-head">
                <div>
                    <span class="eyebrow">Livraison</span>
                    <h2>Zones et frais de livraison</h2>
                    <p class="lead" style="margin: 0;">Choisissez votre zone dans le panier : les frais s’ajoutent automatiquement au total.</p>
                </div>
            </div>
            <div class="zones">
                <div class="zone free">
                    <div class="zone-top"><span aria-hidden="true">🏠</span><span class="tag tag-success">Gratuit</span></div>
                    <h3>Retrait à l’atelier</h3>
                    <div class="zone-bottom"><span>⏱ 15 min</span><b>0 FCFA</b></div>
                </div>
                @foreach ($zones as $zone)
                    <div class="zone">
                        <div class="zone-top"><span aria-hidden="true">📍</span></div>
                        <h3>{{ $zone['area'] }}</h3>
                        <div class="zone-bottom"><span>⏱ {{ $zone['delay'] }}</span><b>{{ $site->money($zone['fee']) }}</b></div>
                    </div>
                @endforeach
            </div>
            <div class="slots">
                <div class="slot"><span aria-hidden="true">☀️</span><div><b>Déjeuner</b><p>Commande avant 11h, livré entre 12h et 14h</p></div></div>
                <div class="slot"><span aria-hidden="true">🌙</span><div><b>Dîner</b><p>Commande avant 17h, livré entre 18h et 20h</p></div></div>
                <div class="slot"><span aria-hidden="true">🎂</span><div><b>Gâteaux & grandes quantités</b><p>Commande 48 h à l’avance</p></div></div>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="wrap">
            <div class="help">
                <div>
                    <span class="eyebrow">Plus de 20 personnes ?</span>
                    <h2>Passez par notre service traiteur</h2>
                    <p>Buffets, cérémonies et entreprises : nous cuisinons, livrons et dressons pour 20 à 300 invités.</p>
                </div>
                <div class="help-actions">
                    <a class="btn btn-primary" href="{{ $site->url('traiteur') }}">Demander un devis</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (() => {
            // Open Monday to Saturday from 8h, last orders at 17h (Abidjan time is UTC).
            const status = document.querySelector('[data-status]');
            const now = new Date();
            const hour = now.getUTCHours();
            if (now.getUTCDay() === 0 || hour >= 17 || hour < 8) {
                status.classList.add('closed');
                status.textContent = 'Fermé · commandes du lundi au samedi dès 8h';
            } else {
                status.textContent = hour < 11 ? 'Ouvert · déjeuner jusqu’à 11h' : 'Ouvert · dîner jusqu’à 17h';
            }
        })();
    </script>
@endpush
