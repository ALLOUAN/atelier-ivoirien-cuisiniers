@extends('site.layouts.site')

@php
    $sessions = collect($site->sessions());
    $trainings = collect($site->trainings())->keyBy('slug');
    $nextOpen = $sessions->firstWhere('left', '>', 0);
    $monthShort = ['janvier' => 'janv', 'février' => 'févr', 'mars' => 'mars', 'avril' => 'avr', 'mai' => 'mai', 'juin' => 'juin', 'juillet' => 'juil', 'août' => 'août', 'septembre' => 'sept', 'octobre' => 'oct', 'novembre' => 'nov', 'décembre' => 'déc'];
@endphp

@push('styles')

    .toolbar { position: sticky; top: 78px; z-index: 20; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 14px; padding: 14px 0; margin-bottom: 36px; background: rgb(255 255 255 / .9); -webkit-backdrop-filter: blur(14px); backdrop-filter: blur(14px); border-bottom: 1px solid var(--line); }
    .filters { display: flex; gap: 6px; overflow-x: auto; scrollbar-width: none; padding: 2px; }
    .filters::-webkit-scrollbar { display: none; }
    .filter { flex: none; padding: 9px 16px; border: 1px solid var(--line-strong); border-radius: var(--pill); background: #fff; font: inherit; font-size: .88rem; font-weight: 600; color: var(--navy); cursor: pointer; transition: background .2s, color .2s, border-color .2s; }
    .filter:hover { border-color: var(--navy); }
    .filter[aria-pressed="true"] { background: var(--navy); border-color: var(--navy); color: #fff; }
    .switch { display: inline-flex; align-items: center; gap: 10px; font-size: .88rem; font-weight: 600; color: var(--ink); cursor: pointer; user-select: none; }
    .switch input { appearance: none; width: 42px; height: 24px; border-radius: var(--pill); background: var(--line-strong); position: relative; cursor: pointer; margin: 0; transition: background .2s; }
    .switch input::after { content: ''; position: absolute; top: 3px; left: 3px; width: 18px; height: 18px; border-radius: 50%; background: #fff; box-shadow: var(--shadow-sm); transition: transform .25s var(--ease); }
    .switch input:checked { background: var(--orange); }
    .switch input:checked::after { transform: translateX(18px); }

    .month { margin-bottom: 56px; }
    .month-head { display: flex; align-items: center; gap: 14px; margin-bottom: 18px; }
    .month-head h2 { font-size: 1.35rem; margin: 0; }
    .month-head .count { font-size: .78rem; font-weight: 700; color: var(--muted); padding: 4px 10px; border: 1px solid var(--line); border-radius: var(--pill); }
    .month-head::after { content: ''; flex: 1; height: 1px; background: var(--line); }
    .sessions { display: grid; gap: 14px; }

    .session { display: grid; grid-template-columns: 84px 132px 1fr 230px; gap: 22px; align-items: center; background: #fff; border: 1px solid var(--line); border-radius: var(--radius-lg); padding: 14px 22px 14px 14px; transition: transform .35s var(--ease), box-shadow .35s var(--ease), border-color .35s; }
    .session:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); border-color: var(--orange-100); }
    .session.is-next { border-color: var(--orange); box-shadow: 0 0 0 4px var(--orange-50); }
    .session.full { background: #fff; }
    .session.full .thumb img { filter: grayscale(1); opacity: .7; }

    .date { text-align: center; border-radius: var(--radius); background: var(--navy); color: #c9d3e2; padding: 12px 6px 10px; font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; position: relative; overflow: hidden; }
    .date::after { content: ''; position: absolute; left: 18px; right: 18px; bottom: 0; height: 3px; border-radius: 3px 3px 0 0; background: var(--gold); }
    .date b { display: block; font-family: var(--heading); font-size: 2rem; letter-spacing: -.03em; line-height: 1.05; color: #fff; margin: 2px 0; }
    .thumb { position: relative; height: 96px; border-radius: var(--radius); overflow: hidden; }
    .thumb img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .8s var(--ease); }
    .session:hover .thumb img { transform: scale(1.08); }
    .thumb .icon { position: absolute; left: 8px; bottom: 8px; width: 32px; height: 32px; border-radius: 10px; display: grid; place-items: center; background: #fff; font-size: 1rem; box-shadow: var(--shadow-sm); }

    .info h3 { margin: 0 0 8px; font-size: 1.1rem; }
    .info h3 a:hover { color: var(--orange-text); }
    .info .tags { margin-bottom: 10px; }
    .meta { display: flex; flex-wrap: wrap; gap: 4px 18px; font-size: .86rem; color: var(--muted); }
    .meta b { color: var(--navy); font-weight: 700; }
    .next-flag { display: inline-flex; align-items: center; gap: 6px; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--orange-text); margin-bottom: 6px; }
    .next-flag::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: var(--orange); animation: blink 1.6s ease-in-out infinite; }
    @keyframes blink { 50% { opacity: .25; } }

    .seats { display: grid; gap: 10px; }
    .seats-top { display: flex; justify-content: space-between; align-items: baseline; font-size: .82rem; color: var(--muted); }
    .seats-top b { font-size: .9rem; }
    .seats-top .ok { color: var(--success); } .seats-top .low { color: var(--orange-text); } .seats-top .none { color: var(--danger); }
    .seats-bar { height: 8px; background: var(--navy-50); border-radius: var(--pill); overflow: hidden; }
    .seats-bar i { display: block; height: 100%; width: 0; border-radius: inherit; background: var(--navy); transition: width 1.2s var(--ease); }
    .seats-bar i.low { background: var(--orange); }
    .seats-bar i.none { background: var(--danger); }

    .session[hidden], .month[hidden] { display: none !important; }
    .empty { text-align: center; padding: 56px 24px; border: 1px dashed var(--line-strong); border-radius: var(--radius-lg); color: var(--muted); }
    .empty span { font-size: 2.4rem; display: block; margin-bottom: 8px; }


    @media (max-width: 980px) {
        .session { grid-template-columns: 76px 1fr 200px; }
        .thumb { display: none; }
    }
    @media (max-width: 700px) {
        .toolbar { top: 70px; }
        .session { grid-template-columns: 72px 1fr; gap: 16px; padding: 14px; }
        .date b { font-size: 1.7rem; }
        .seats { grid-column: 1 / -1; padding-top: 12px; border-top: 1px dashed var(--line); }
    }
    @media (prefers-reduced-motion: reduce) { .seats-bar i { transition: none; } .next-flag::before { animation: none; } }
@endpush

@section('page_head')
    <h1>Calendrier des sessions</h1>
    <p class="lead" style="margin: 0;">Les prochaines rentrées et les places restantes, mises à jour par l’atelier. Une session est complète ? Rejoignez la liste d’attente en un message.</p>
    <div class="head-stats">
        <div><span aria-hidden="true">📅</span><p style="margin: 0;"><b>{{ $sessions->count() }} sessions</b>d’ici {{ mb_strtolower($sessions->last()['month']) }}</p></div>
        <div><span aria-hidden="true">🎟️</span><p style="margin: 0;"><b>{{ $sessions->sum('left') }} places</b>encore libres</p></div>
        @if ($nextOpen)
            <div><span aria-hidden="true">🚀</span><p style="margin: 0;"><b>{{ $nextOpen['start'] }}</b>prochaine rentrée</p></div>
        @endif
    </div>
@endsection

@section('content')
    <section class="section" style="padding-top: 24px;">
        <div class="wrap" data-calendar>
            <div class="toolbar">
                <div class="filters" role="group" aria-label="Filtrer par formation">
                    <button type="button" class="filter" aria-pressed="true" data-filter="">Toutes</button>
                    @foreach ($sessions->pluck('training', 'slug')->unique() as $slug => $label)
                        <button type="button" class="filter" aria-pressed="false" data-filter="{{ $slug }}">{{ $trainings[$slug]['title'] ?? $label }}</button>
                    @endforeach
                </div>
                <label class="switch"><input type="checkbox" data-hide-full> Masquer les sessions complètes</label>
            </div>

            @foreach ($sessions->groupBy('month') as $month => $monthSessions)
                <div class="month" data-month>
                    <div class="month-head">
                        <h2>{{ $month }}</h2>
                        <span class="count" data-count>{{ $monthSessions->count() }} {{ \Illuminate\Support\Str::plural('session', $monthSessions->count()) }}</span>
                    </div>
                    <div class="sessions">
                        @foreach ($monthSessions as $session)
                            @php
                                $training = $trainings[$session['slug']] ?? null;
                                $taken = $session['seats'] - $session['left'];
                                $state = $session['left'] === 0 ? 'none' : ($session['left'] <= 3 ? 'low' : 'ok');
                                $isNext = $nextOpen && $session === $nextOpen;
                            @endphp
                            <article @class(['session', 'full' => $state === 'none', 'is-next' => $isNext]) data-slug="{{ $session['slug'] }}" data-full="{{ $state === 'none' ? 1 : 0 }}">
                                <div class="date" aria-label="{{ $session['start'] }}">
                                    {{ mb_substr(explode(' ', $session['start'])[0], 0, 3) }}
                                    <b>{{ (int) filter_var($session['start'], FILTER_SANITIZE_NUMBER_INT) }}</b>
                                    {{ $monthShort[\Illuminate\Support\Str::afterLast($session['start'], ' ')] ?? \Illuminate\Support\Str::afterLast($session['start'], ' ') }}
                                </div>
                                @if ($training)
                                    <a class="thumb" href="{{ $site->trainingUrl($session['slug']) }}" tabindex="-1" aria-hidden="true">
                                        <img src="{{ $site->photo($training['image']) }}" alt="" loading="lazy">
                                        <span class="icon">{{ $training['icon'] }}</span>
                                    </a>
                                @else
                                    <span class="thumb" aria-hidden="true"></span>
                                @endif
                                <div class="info">
                                    @if ($isNext)
                                        <span class="next-flag">Prochaine rentrée</span>
                                    @endif
                                    <h3><a href="{{ $site->trainingUrl($session['slug']) }}">{{ $session['training'] }}</a></h3>
                                    @if ($training)
                                        <div class="tags"><span class="tag tag-orange">{{ $training['level'] }}</span><span class="tag">⏱ {{ $training['duration'] }}</span></div>
                                    @endif
                                    <div class="meta">
                                        <span>🕗 {{ $session['days'] }}</span>
                                        @if ($training)
                                            <span>Dès <b>{{ $site->money($training['price']) }}</b></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="seats">
                                    <div class="seats-top">
                                        @if ($state === 'none')
                                            <b class="none">Complet</b>
                                        @elseif ($state === 'low')
                                            <b class="low">Plus que {{ $session['left'] }} places</b>
                                        @else
                                            <b class="ok">{{ $session['left'] }} places libres</b>
                                        @endif
                                        <span>{{ $taken }}/{{ $session['seats'] }}</span>
                                    </div>
                                    <div class="seats-bar" role="img" aria-label="{{ $taken }} places prises sur {{ $session['seats'] }}"><i class="{{ $state }}" data-width="{{ round($taken / $session['seats'] * 100) }}%"></i></div>
                                    @if ($state === 'none')
                                        <a class="btn btn-ghost btn-sm btn-block" href="{{ $site->whatsappLink('Bonjour, je souhaite être sur la liste d’attente : '.$session['training'].' ('.$session['start'].').') }}" target="_blank" rel="noopener"><svg class="wa-ico"><use href="#wa"/></svg>Liste d’attente</a>
                                    @else
                                        <a @class(['btn btn-sm btn-block', 'btn-primary' => $state !== 'ok' || $isNext, 'btn-navy' => $state === 'ok' && ! $isNext]) href="{{ $site->url('inscription') }}?formation={{ $session['slug'] }}">Réserver ma place</a>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="empty" data-empty hidden><span aria-hidden="true">🗓️</span>Aucune session ne correspond à ce filtre pour le moment.</div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="wrap">
            <div class="help">
                <div>
                    <span class="eyebrow">Sur mesure</span>
                    <h2>Aucune date ne vous convient ?</h2>
                    <p>Dites-nous vos disponibilités : nous ouvrons de nouveaux groupes dès 6 inscrits, en semaine ou le samedi.</p>
                </div>
                <div class="help-actions">
                    <a class="btn btn-primary" href="{{ $site->whatsappLink('Bonjour, aucune date du calendrier ne me convient. Mes disponibilités : ') }}" target="_blank" rel="noopener"><svg class="wa-ico"><use href="#wa"/></svg>Proposer mes dates</a>
                    <a class="btn btn-ghost" href="{{ $site->url('formations') }}">Voir les formations</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (() => {
            const root = document.querySelector('[data-calendar]');
            const filters = [...root.querySelectorAll('[data-filter]')];
            const hideFull = root.querySelector('[data-hide-full]');
            let current = '';

            const apply = () => {
                let visible = 0;
                root.querySelectorAll('[data-month]').forEach((month) => {
                    let shown = 0;
                    month.querySelectorAll('.session').forEach((session) => {
                        const match = (!current || session.dataset.slug === current) && !(hideFull.checked && session.dataset.full === '1');
                        session.hidden = !match;
                        shown += match;
                    });
                    month.hidden = shown === 0;
                    month.querySelector('[data-count]').textContent = shown + (shown > 1 ? ' sessions' : ' session');
                    visible += shown;
                });
                root.querySelector('[data-empty]').hidden = visible > 0;
            };

            filters.forEach((button) => button.addEventListener('click', () => {
                current = button.dataset.filter;
                filters.forEach((other) => other.setAttribute('aria-pressed', other === button ? 'true' : 'false'));
                apply();
            }));
            hideFull.addEventListener('change', apply);

            // Fill the seat gauges once they are on screen.
            const fill = (bar) => { bar.style.width = bar.dataset.width; };
            const bars = root.querySelectorAll('.seats-bar i');
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
                    if (entry.isIntersecting) { fill(entry.target); observer.unobserve(entry.target); }
                }));
                bars.forEach((bar) => observer.observe(bar));
            } else {
                bars.forEach(fill);
            }
        })();
    </script>
@endpush
