@extends('site.layouts.site')

@push('styles')
    .legal h2 { font-size: 1.2rem; margin-top: 36px; }
    .legal p, .legal li { color: var(--body); }
    .placeholder { background: var(--warning-bg); color: var(--warning); padding: 1px 6px; border-radius: 4px; font-weight: 600; }
@endpush

@section('page_head')
    <h1>Mentions légales & confidentialité</h1>
    <p class="lead" style="margin: 0;">Les informations entre crochets sont à compléter avec les documents de l’entreprise.</p>
@endsection

@section('content')
    <section class="section">
        <div class="narrow legal">
            <h2>Éditeur du site</h2>
            <p>{{ $business['name'] }}, <span class="placeholder">[forme juridique]</span>, RCCM <span class="placeholder">[numéro]</span>, compte contribuable <span class="placeholder">[numéro]</span>.<br>
                Siège : {{ $business['address'] }}. Téléphone : {{ $business['phone'] }}. E-mail : {{ $business['email'] }}.<br>
                Responsable de la publication : <span class="placeholder">[nom du gérant]</span>.</p>

            <h2>Hébergement</h2>
            <p><span class="placeholder">[nom et adresse de l’hébergeur]</span>.</p>

            <h2>Données personnelles</h2>
            <p>Les informations transmises par le site (nom, téléphone, formation choisie, commande) sont envoyées par WhatsApp et utilisées uniquement pour traiter votre inscription ou votre commande. Elles ne sont ni vendues ni cédées.</p>
            <ul>
                <li>Durée de conservation : 3 ans après le dernier contact.</li>
                <li>Vous pouvez demander à consulter, corriger ou supprimer vos données à {{ $business['email'] }}.</li>
                <li>Conformément à la loi ivoirienne n° 2013-450 relative à la protection des données à caractère personnel.</li>
            </ul>

            <h2>Conditions d’inscription</h2>
            <p>La place est réservée à réception du premier versement. En cas d’empêchement signalé au moins 7 jours avant la rentrée, le versement est reporté sur une session suivante.</p>

            <h2 id="credits">Crédits photos</h2>
            <p>Les photos de cette maquette servent d’illustration et seront remplacées par celles de l’atelier.</p>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Photo</th><th>Auteur</th><th>Licence</th></tr></thead>
                    <tbody>
                        @foreach ($site->photoCredits() as $credit)
                            <tr><td><a class="link" href="{{ $credit['source'] }}" target="_blank" rel="noopener">{{ $credit['images'] }}</a></td><td>{{ $credit['author'] }}</td><td>{{ $credit['licence'] }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="muted small mt-1">Photos Wikimedia Commons : licences Creative Commons, auteurs cités ci-dessus.</p>

            <h2>Cookies</h2>
            <p>Le site n’utilise que les cookies nécessaires à son fonctionnement et, avec votre accord, une mesure d’audience anonyme.</p>
        </div>
    </section>
@endsection
