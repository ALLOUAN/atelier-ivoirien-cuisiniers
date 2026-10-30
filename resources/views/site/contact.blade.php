@extends('site.layouts.site')

@php
    // Opening hours by ISO weekday (1 = Monday); null = closed.
    $hours = [1 => [8, 18], 2 => [8, 18], 3 => [8, 18], 4 => [8, 18], 5 => [8, 18], 6 => [8, 15], 7 => null];
    $dayNames = [1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi', 7 => 'Dimanche'];
@endphp

@push('styles')
    .channels { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 56px; }
    .channel { display: grid; gap: 14px; padding: 26px; }
    .channel .icon-box { margin: 0; }
    .channel b { display: block; font-family: var(--heading); color: var(--navy); font-size: 1.05rem; word-break: break-word; }
    .channel p { margin: 0; font-size: .9rem; color: var(--muted); }
    .channel .go { display: inline-flex; align-items: center; gap: 8px; font-weight: 600; font-size: .88rem; color: var(--orange-text); }
    .channel .go::after { content: '→'; transition: transform .25s var(--ease); }
    .channel:hover .go::after { transform: translateX(4px); }
    .channel.main { border-color: var(--orange); box-shadow: 0 0 0 4px var(--orange-50), var(--shadow); }
    .channel.main .icon-box { background: var(--wa); color: #fff; }
    .channel.main .icon-box svg { width: 28px; height: 28px; }
    @media (max-width: 860px) { .channels { grid-template-columns: 1fr; } }

    .contact-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; align-items: start; }
    .panel { padding: 32px; border: 1px solid var(--line); border-radius: var(--radius-lg); background: #fff; }
    .panel h2 { font-size: 1.5rem; margin-bottom: 6px; }
    .topics { display: flex; flex-wrap: wrap; gap: 8px; margin: 4px 0 6px; }
    .form-stack { display: grid; gap: 16px; margin-top: 22px; }

    .map-card { overflow: hidden; padding: 0; }
    .map { position: relative; aspect-ratio: 16 / 10; background: var(--navy-50); }
    .map iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; filter: saturate(.9); }
    .map-info { padding: 24px 28px 28px; display: grid; gap: 18px; }
    .address { display: flex; gap: 14px; align-items: flex-start; }
    .address span { width: 40px; height: 40px; border-radius: 12px; display: grid; place-items: center; background: var(--orange-50); flex: none; }
    .address b { display: block; color: var(--navy); }
    .address p { margin: 0; font-size: .9rem; color: var(--muted); }

    .hours-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 10px; }
    .hours-head h3 { margin: 0; }
    .status { display: inline-flex; align-items: center; gap: 8px; font-size: .78rem; font-weight: 700; padding: 5px 12px; border-radius: var(--pill); background: var(--success-bg); color: var(--success); }
    .status::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: currentColor; }
    .status.closed { background: var(--navy-50); color: var(--muted); }
    .hours { list-style: none; margin: 0; padding: 0; font-size: .92rem; }
    .hours li { display: flex; justify-content: space-between; padding: 9px 12px; border-radius: var(--radius-sm); color: var(--body); }
    .hours li + li { border-top: 1px dashed var(--line); }
    .hours li b { color: var(--navy); font-variant-numeric: tabular-nums; }
    .hours li.today { background: var(--orange-50); border-color: transparent; font-weight: 600; color: var(--orange-text); }
    .hours li.today + li { border-top-color: transparent; }
    .hours li.today b { color: var(--orange-text); }
    @media (max-width: 900px) { .contact-layout { grid-template-columns: 1fr; } .panel { padding: 26px; } }
@endpush

@section('page_head')
    <h1>Contact & accès</h1>
    <p class="lead" style="margin: 0;">Passez nous voir, appelez-nous ou écrivez sur WhatsApp : nous répondons vite.</p>
    <div class="head-stats">
        <div><span aria-hidden="true">⚡</span><p><b>Moins d’une heure</b>pour vous répondre sur WhatsApp</p></div>
        <div><span aria-hidden="true">📍</span><p><b>{{ $business['city'] }}</b>parking devant l’atelier</p></div>
    </div>
@endsection

@section('content')
    <section class="section" style="padding-top: 32px;">
        <div class="wrap">
            <div class="channels">
                <a class="card hover channel main" href="{{ $site->whatsappLink('Bonjour, j’ai une question.') }}" target="_blank" rel="noopener">
                    <span class="icon-box"><svg><use href="#wa"/></svg></span>
                    <div><b>WhatsApp</b><p>Le plus rapide : réponse en moins d’une heure, de 8h à 18h.</p></div>
                    <span class="go">Écrire maintenant</span>
                </a>
                <a class="card hover channel" href="tel:{{ str_replace(' ', '', $business['phone']) }}">
                    <span class="icon-box" aria-hidden="true">📞</span>
                    <div><b>{{ $business['phone'] }}</b><p>Appel en un clic, aux heures d’ouverture.</p></div>
                    <span class="go">Appeler</span>
                </a>
                <a class="card hover channel" href="mailto:{{ $business['email'] }}">
                    <span class="icon-box" aria-hidden="true">✉️</span>
                    <div><b>{{ $business['email'] }}</b><p>Pour les devis entreprise et les factures.</p></div>
                    <span class="go">Envoyer un e-mail</span>
                </a>
            </div>

            <div class="contact-layout">
                <form class="panel" data-contact>
                    <span class="eyebrow">Message rapide</span>
                    <h2>Une question ? Écrivez-nous</h2>
                    <p class="muted" style="margin: 0;">Votre message s’ouvre tout prêt dans WhatsApp, il n’y a plus qu’à l’envoyer.</p>
                    <div class="form-stack">
                        <div>
                            <span class="field" style="display: block; margin-bottom: 8px;">Votre demande concerne</span>
                            <div class="topics choices">
                                @foreach (['Une formation', 'Une commande', 'Le traiteur', 'Autre chose'] as $topic)
                                    <label class="choice"><input type="radio" name="sujet" value="{{ $topic }}" @checked($loop->first)><span>{{ $topic }}</span></label>
                                @endforeach
                            </div>
                        </div>
                        <label class="field">Votre nom<input class="input" name="nom" required autocomplete="name"></label>
                        <label class="field">Votre message<textarea class="input" name="message" required placeholder="Ex. Quelles sont les dates de la prochaine session de pâtisserie ?"></textarea></label>
                        <button class="btn btn-primary btn-block" type="submit"><svg class="wa-ico"><use href="#wa"/></svg>Envoyer sur WhatsApp</button>
                    </div>
                </form>

                <div class="panel map-card">
                    <div class="map">
                        <iframe src="https://maps.google.com/maps?q={{ rawurlencode('Cocody Angré, Abidjan') }}&z=14&output=embed" title="Carte : Cocody Angré, Abidjan" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="map-info">
                        <div class="address"><span aria-hidden="true">📍</span><div><b>Adresse</b><p>{{ $business['address'] }}. Parking possible devant l’atelier.</p></div></div>
                        <a class="btn btn-navy btn-block" href="https://www.google.com/maps/search/?api=1&query={{ rawurlencode('Cocody Angré Abidjan') }}" target="_blank" rel="noopener">🧭 Itinéraire jusqu’à l’atelier</a>
                        <div>
                            <div class="hours-head"><h3>Horaires</h3><span class="status" data-status>…</span></div>
                            <ul class="hours" data-hours>
                                @foreach ($dayNames as $day => $name)
                                    <li data-day="{{ $day }}"><span>{{ $name }}</span>@if ($hours[$day])<b>{{ $hours[$day][0] }}h00 – {{ $hours[$day][1] }}h00</b>@else<span class="tag">Fermé</span>@endif</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (() => {
            // Highlight today and tell whether the workshop is open right now (Abidjan time is UTC).
            const hours = @json($hours);
            const now = new Date();
            const day = now.getUTCDay() || 7;
            const hour = now.getUTCHours() + now.getUTCMinutes() / 60;
            const today = hours[day];
            const status = document.querySelector('[data-status]');
            document.querySelector('[data-hours] [data-day="' + day + '"]').classList.add('today');
            if (today && hour >= today[0] && hour < today[1]) {
                status.textContent = 'Ouvert · jusqu’à ' + today[1] + 'h';
            } else {
                status.classList.add('closed');
                status.textContent = 'Fermé en ce moment';
            }

            const form = document.querySelector('[data-contact]');
            form.addEventListener('submit', (event) => {
                event.preventDefault();
                AIC.send(['Bonjour, ma demande concerne : ' + form.sujet.value.toLowerCase() + '.', '', form.message.value.trim(), '', 'Nom : ' + form.nom.value.trim()].join('\n'));
            });
        })();
    </script>
@endpush
