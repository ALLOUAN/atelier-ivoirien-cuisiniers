@extends('site.layouts.site')

@push('styles')
    .signup-layout { display: grid; grid-template-columns: 1fr 340px; gap: 30px; align-items: start; }
    .stepper { display: flex; gap: 8px; margin-bottom: 24px; }
    .stepper span { flex: 1; text-align: center; font-size: .8rem; font-weight: 600; color: var(--muted); padding-bottom: 8px; border-bottom: 3px solid var(--line); }
    .stepper span.on { color: var(--orange-text); border-color: var(--orange); }
    .recap { position: sticky; top: 96px; background: #fff; border: 1px solid var(--line); border-radius: var(--radius-lg); padding: 28px; box-shadow: var(--shadow-lg); }
    .recap dl { display: grid; gap: 10px; margin: 16px 0; font-size: .92rem; }
    .recap dl div { display: flex; justify-content: space-between; gap: 10px; border-bottom: 1px dashed var(--line); padding-bottom: 8px; }
    .recap dt { color: var(--muted); } .recap dd { margin: 0; font-weight: 600; color: var(--ink); text-align: right; }
    .recap .due { font-family: var(--heading); font-size: 1.5rem; font-weight: 700; color: var(--navy); }
    @media (max-width: 900px) { .signup-layout { grid-template-columns: 1fr; } .recap { position: static; } }
@endpush

@section('page_head')
    <h1>Inscription en ligne</h1>
    <p class="lead" style="margin: 0;">Réservez votre place en 2 minutes. Nous confirmons sur WhatsApp, puis vous réglez le premier versement par Mobile Money.</p>
@endsection

@section('content')
    @php
        $trainings = collect($site->trainings())->keyBy('slug');
        $selected = $trainings->has(request('formation')) ? request('formation') : $trainings->keys()->first();
    @endphp

    <section class="section">
        <div class="wrap signup-layout">
            <form class="card" data-signup>
                <div class="stepper"><span class="on">1. Formation</span><span class="on">2. Vos infos</span><span>3. Confirmation WhatsApp</span></div>

                <h3>Votre formation</h3>
                <div class="form-grid">
                    <label class="field">Formation
                        <select class="input" name="formation">
                            @foreach ($trainings as $slug => $training)
                                <option value="{{ $slug }}" data-price="{{ $training['price'] }}" data-installments="{{ $training['installments'] }}" @selected($slug === $selected)>{{ $training['title'] }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="field">Session
                        <select class="input" name="session">
                            @foreach ($site->sessions() as $session)
                                <option data-slug="{{ $session['slug'] }}" @disabled($session['left'] === 0)>{{ $session['start'] }}{{ $session['left'] === 0 ? ' (complet)' : '' }}</option>
                            @endforeach
                            <option data-slug="*">Prochaine session disponible</option>
                        </select>
                    </label>
                </div>

                <h3 class="mt-2">Vos informations</h3>
                <div class="form-grid">
                    <label class="field">Nom et prénoms<input class="input" name="nom" required autocomplete="name"></label>
                    <label class="field">Téléphone (WhatsApp)<input class="input" name="telephone" type="tel" required placeholder="07 00 00 00 00" autocomplete="tel"></label>
                    <label class="field">Âge<input class="input" name="age" type="number" min="16" max="80"></label>
                    <label class="field">Commune<input class="input" name="commune" placeholder="Ex. Cocody, Yopougon…"></label>
                    <label class="field full">Votre projet (facultatif)<textarea class="input" name="projet" placeholder="Ex. ouvrir un maquis, travailler en hôtel, cuisiner pour la famille…"></textarea></label>
                </div>

                <h3 class="mt-2">Paiement</h3>
                <div class="field" style="margin-bottom: 14px;">Moyen de paiement
                    <div class="choices">
                        @foreach (['Wave', 'Orange Money', 'MTN MoMo', 'Moov Money', 'Espèces à l’atelier'] as $method)
                            <label class="choice"><input type="radio" name="paiement" value="{{ $method }}" @checked($loop->first)><span>{{ $method }}</span></label>
                        @endforeach
                    </div>
                </div>
                <div class="field">Formule
                    <div class="choices">
                        <label class="choice"><input type="radio" name="formule" value="1" checked><span>En une fois</span></label>
                        <label class="choice"><input type="radio" name="formule" value="n"><span data-installments-label>En plusieurs versements</span></label>
                    </div>
                </div>

                <button class="btn btn-primary btn-block mt-2" type="submit"><svg class="wa-ico"><use href="#wa"/></svg>Envoyer mon inscription sur WhatsApp</button>
                <p class="muted small center mt-1" style="margin-bottom: 0;">Votre place est réservée dès réception du premier versement.</p>
            </form>

            <aside class="recap" aria-live="polite">
                <h3>Récapitulatif</h3>
                <dl>
                    <div><dt>Formation</dt><dd data-recap="formation"></dd></div>
                    <div><dt>Session</dt><dd data-recap="session"></dd></div>
                    <div><dt>Prix total</dt><dd data-recap="price"></dd></div>
                    <div><dt>Paiement</dt><dd data-recap="paiement"></dd></div>
                </dl>
                <span class="muted small">À régler maintenant</span>
                <div class="due" data-recap="due"></div>
            </aside>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (() => {
            const form = document.querySelector('[data-signup]');
            const recap = (key, value) => { document.querySelector('[data-recap="' + key + '"]').textContent = value; };
            const state = () => {
                const option = form.formation.selectedOptions[0];
                const price = Number(option.dataset.price);
                const installments = Number(option.dataset.installments);
                const split = form.formule.value === 'n' && installments > 1;
                return { title: option.textContent, price, installments, split, due: split ? Math.ceil(price / installments / 500) * 500 : price };
            };
            const filterSessions = () => {
                const slug = form.formation.value;
                let first = null;
                [...form.session.options].forEach((option) => {
                    option.hidden = option.dataset.slug !== slug && option.dataset.slug !== '*';
                    if (!option.hidden && !option.disabled && !first) { first = option; }
                });
                form.session.value = first.value;
            };
            const render = () => {
                const s = state();
                document.querySelector('[data-installments-label]').textContent = s.installments > 1 ? 'En ' + s.installments + ' versements' : 'En une fois uniquement';
                recap('formation', s.title);
                recap('session', form.session.value);
                recap('price', AIC.money(s.price));
                recap('paiement', form.paiement.value + (s.split ? ' · ' + s.installments + ' fois' : ''));
                recap('due', AIC.money(s.due));
            };
            form.formation.addEventListener('change', filterSessions);
            form.addEventListener('change', render);
            form.addEventListener('submit', (event) => {
                event.preventDefault();
                const s = state();
                const f = form.elements;
                AIC.send(['Bonjour, je souhaite m’inscrire :', '• Formation : ' + s.title, '• Session : ' + f.session.value, '• Paiement : ' + f.paiement.value + (s.split ? ' en ' + s.installments + ' versements' : ' en une fois'),
                    '• Premier versement : ' + AIC.money(s.due), '', 'Nom : ' + f.nom.value, 'Téléphone : ' + f.telephone.value,
                    f.age.value ? 'Âge : ' + f.age.value : '', f.commune.value ? 'Commune : ' + f.commune.value : '', f.projet.value ? 'Projet : ' + f.projet.value : '']
                    .filter(Boolean).join('\n'));
            });
            filterSessions();
            render();
        })();
    </script>
@endpush
