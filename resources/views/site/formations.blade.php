@extends('site.layouts.site')

@php
    $trainings = collect($site->trainings());
    $filters = ['tout' => 'Toutes', 'debutant' => 'Débutant', 'professionnel' => 'Professionnel', 'court' => 'Courte durée'];
@endphp

@push('styles')
    .segmented { display: inline-flex; flex-wrap: wrap; gap: 4px; padding: 5px; border: 1px solid var(--line); border-radius: var(--pill); background: #fff; }
    .segmented label { position: relative; }
    .segmented input { position: absolute; opacity: 0; pointer-events: none; }
    .segmented span { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: var(--pill); font-weight: 600; font-size: .9rem; color: var(--navy); cursor: pointer; transition: background .2s, color .2s; }
    .segmented span:hover { background: var(--navy-50); }
    .segmented small { font-size: .72rem; font-weight: 700; min-width: 22px; height: 22px; padding: 0 6px; display: inline-grid; place-items: center; border-radius: var(--pill); background: var(--navy-50); color: var(--muted); }
    .segmented input:checked + span { background: var(--navy); color: #fff; }
    .segmented input:checked + span small { background: rgb(255 255 255 / .16); color: #fff; }
    .segmented input:focus-visible + span { box-shadow: 0 0 0 3px rgb(204 68 0 / .28); }
    .list-bar { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 32px; }
    .list-bar .muted b { color: var(--navy); }
    [data-trainings] > * { transition: opacity .3s var(--ease), transform .3s var(--ease); }
    [data-trainings] > .is-leaving { opacity: 0 !important; transform: scale(.97) !important; transition-delay: 0s !important; }

    .compare td:first-child { font-weight: 600; color: var(--ink); }
    .compare td:first-child a { display: inline-flex; align-items: center; gap: 10px; }
    .compare td:first-child a:hover { color: var(--orange-text); }
    .compare .emoji { width: 34px; height: 34px; border-radius: 10px; display: grid; place-items: center; background: var(--orange-50); flex: none; }
    .compare tbody tr { transition: background .2s; }
    .compare tbody tr:hover { background: var(--navy-50); }
    .compare .price { font-family: var(--heading); font-weight: 700; color: var(--navy); }
    .table-wrap { border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); }
    th { background: #fff; }
@endpush

@section('page_head')
    <h1>Nos formations</h1>
    <p class="lead" style="margin: 0;">Petits groupes de 12, 80 % de pratique, ingrédients fournis, attestation à la fin. Paiement en plusieurs fois possible.</p>
    <div class="head-stats">
        <div><span aria-hidden="true">🎓</span><p><b>{{ $trainings->count() }} formations</b>du samedi au métier</p></div>
        <div><span aria-hidden="true">💳</span><p><b>Dès {{ $site->money($trainings->min('price')) }}</b>payable en plusieurs fois</p></div>
        <div><span aria-hidden="true">📜</span><p><b>Attestation</b>remise en fin de cursus</p></div>
    </div>
@endsection

@section('content')
    <section class="section" style="padding-top: 32px;">
        <div class="wrap">
            <div class="list-bar">
                <div class="segmented" role="radiogroup" aria-label="Filtrer les formations" data-filters>
                    @foreach ($filters as $value => $label)
                        <label><input type="radio" name="filtre" value="{{ $value }}" @checked($loop->first)><span>{{ $label }}<small>{{ $value === 'tout' ? $trainings->count() : $trainings->where('category', $value)->count() }}</small></span></label>
                    @endforeach
                </div>
                <span class="muted small" aria-live="polite"><b data-shown>{{ $trainings->count() }}</b> formation(s) affichée(s)</span>
            </div>
            <div class="grid grid-3" data-trainings>
                @foreach ($site->trainings() as $training)
                    @include('site.partials.training-card')
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="wrap">
            <div class="section-head">
                <div>
                    <span class="eyebrow">Comparatif</span>
                    <h2>Toutes les formations en un coup d’œil</h2>
                    <p class="lead" style="margin: 0;">Durée, rythme et budget côte à côte pour choisir sereinement.</p>
                </div>
                <a class="more" href="{{ $site->url('calendrier') }}">Voir les prochaines dates</a>
            </div>
            <div class="table-wrap compare">
                <table>
                    <thead><tr><th>Formation</th><th>Niveau</th><th>Durée</th><th>Rythme</th><th class="num">Prix</th><th class="num">Paiement</th></tr></thead>
                    <tbody>
                        @foreach ($trainings as $training)
                            <tr>
                                <td><a href="{{ $site->trainingUrl($training['slug']) }}"><span class="emoji" aria-hidden="true">{{ $training['icon'] }}</span>{{ $training['title'] }}</a></td>
                                <td><span class="tag tag-orange">{{ $training['level'] }}</span></td>
                                <td>{{ $training['duration'] }}</td>
                                <td class="muted">{{ $training['schedule'] }}</td>
                                <td class="num price">{{ $site->money($training['price']) }}</td>
                                <td class="num muted">{{ $training['installments'] > 1 ? $training['installments'].' versements' : 'Comptant' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="wrap">
            <div class="center" style="margin-bottom: 40px;">
                <span class="eyebrow">Inclus dans chaque formation</span>
                <h2>Vous venez, on s’occupe du reste</h2>
            </div>
            <div class="tiles">
                <div class="tile"><span class="icon-box" aria-hidden="true">🥘</span><h3>Ingrédients fournis</h3><p>Tout est acheté et préparé pour chaque séance.</p></div>
                <div class="tile"><span class="icon-box" aria-hidden="true">👩🏾‍🍳</span><h3>Des chefs formateurs</h3><p>Des professionnels qui ont travaillé en restaurant et en hôtel.</p></div>
                <div class="tile"><span class="icon-box" aria-hidden="true">👥</span><h3>12 élèves maximum</h3><p>Chacun a son poste et le chef passe voir tout le monde.</p></div>
                <div class="tile"><span class="icon-box" aria-hidden="true">📜</span><h3>Attestation & livret</h3><p>Vos recettes à garder et une attestation pour vos clients.</p></div>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="wrap">
            <div class="help">
                <div>
                    <span class="eyebrow">Conseil gratuit</span>
                    <h2>Vous hésitez entre deux formations ?</h2>
                    <p>Dites-nous votre projet : cuisiner pour la famille, vendre, ou travailler en restaurant. Un chef vous oriente.</p>
                </div>
                <div class="help-actions">
                    <a class="btn btn-primary" href="{{ $site->whatsappLink('Bonjour, j’hésite entre plusieurs formations, pouvez-vous me conseiller ?') }}" target="_blank" rel="noopener"><svg class="wa-ico"><use href="#wa"/></svg>Être conseillé</a>
                    <a class="btn btn-ghost" href="{{ $site->url('inscription') }}">S’inscrire</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (() => {
            const cards = [...document.querySelectorAll('[data-trainings] [data-category]')];
            const shown = document.querySelector('[data-shown]');
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            document.querySelectorAll('[data-filters] input').forEach((input) => input.addEventListener('change', () => {
                const keep = (card) => input.value === 'tout' || card.dataset.category === input.value;
                cards.forEach((card) => card.classList.toggle('is-leaving', !keep(card)));
                setTimeout(() => {
                    cards.forEach((card) => { card.hidden = !keep(card); card.classList.remove('is-leaving'); });
                    shown.textContent = cards.filter(keep).length;
                }, reducedMotion ? 0 : 250);
            }));
        })();
    </script>
@endpush
