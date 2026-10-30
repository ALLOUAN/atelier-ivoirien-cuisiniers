@extends('site.layouts.site')

@section('crumbs')<a href="{{ $site->url('formations') }}">Formations</a> › {{ $training['title'] }}@endsection

@push('styles')
    .training-layout { display: grid; grid-template-columns: 1fr 360px; gap: 40px; align-items: start; }
    .booking { position: sticky; top: 96px; background: #fff; border: 1px solid var(--line); border-radius: var(--radius-lg); padding: 28px; box-shadow: var(--shadow-lg); }
    .booking .price { font-family: var(--heading); font-size: 1.8rem; font-weight: 700; color: var(--navy); line-height: 1.1; }
    .facts { list-style: none; padding: 0; margin: 18px 0; display: grid; gap: 10px; font-size: .92rem; }
    .facts li { display: flex; justify-content: space-between; gap: 10px; border-bottom: 1px dashed var(--line); padding-bottom: 8px; }
    .facts b { color: var(--ink); }
    .timeline { list-style: none; padding: 0; margin: 0; border-left: 3px solid var(--line); }
    .timeline li { position: relative; padding: 0 0 22px 24px; }
    .timeline li::before { content: ''; position: absolute; left: -8px; top: 4px; width: 13px; height: 13px; border-radius: 50%; background: var(--orange); box-shadow: 0 0 0 3px #fff; }
    .timeline b { display: block; color: var(--navy); font-family: var(--heading); }
    .included { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; }
    .included div { background: var(--alt); border: 1px solid var(--line); border-radius: var(--radius-sm); padding: 14px; font-weight: 600; color: var(--ink); font-size: .92rem; }
    .included div::before { content: '✓ '; color: var(--success); }
    @media (max-width: 900px) { .training-layout { grid-template-columns: 1fr; } .booking { position: static; } }
@endpush

@section('page_head')
    <div class="training-head">
        <div>
            <div class="tags" style="margin-bottom: 14px;"><span class="tag tag-orange">{{ $training['level'] }}</span><span class="tag">⏱ {{ $training['duration'] }}</span><span class="tag">🗓 {{ $training['schedule'] }}</span></div>
            <h1>{{ $training['icon'] }} {{ $training['title'] }}</h1>
            <p class="lead" style="margin: 0;">{{ $training['summary'] }}</p>
        </div>
    </div>
@endsection

@section('content')
    @php($sessions = collect($site->sessions())->where('slug', $training['slug']))

    <section class="section">
        <div class="wrap training-layout">
            <div>
                <h2>Ce que vous allez apprendre</h2>
                <ul class="bullets" style="font-size: 1rem;">
                    @foreach ($training['points'] as $point)
                        <li>{{ $point }}</li>
                    @endforeach
                </ul>

                <h2 class="mt-3">Programme</h2>
                <ol class="timeline">
                    @foreach ($training['program'] as $step)
                        <li><b>{{ $step['week'] }}</b>{{ $step['topic'] }}</li>
                    @endforeach
                </ol>

                <h2 class="mt-2">Compris dans le prix</h2>
                <div class="included">
                    @foreach ($training['included'] as $item)
                        <div>{{ $item }}</div>
                    @endforeach
                </div>

                <h2 class="mt-3">Questions sur cette formation</h2>
                @foreach ($site->faq()['Formations'] as $item)
                    <details class="faq" @if ($loop->first) open @endif><summary>{{ $item['q'] }}</summary><p>{{ $item['a'] }}</p></details>
                @endforeach
            </div>

            <aside class="booking">
                <span class="muted small">À partir de</span>
                <div class="price">{{ $site->money($training['price']) }}</div>
                @if ($training['installments'] > 1)
                    <span class="tag tag-gold mt-1">ou {{ $training['installments'] }} × {{ $site->money(ceil($training['price'] / $training['installments'] / 500) * 500) }}</span>
                @endif
                <ul class="facts">
                    <li><span>Durée</span><b>{{ $training['duration'] }}</b></li>
                    <li><span>Rythme</span><b>{{ $training['schedule'] }}</b></li>
                    <li><span>Groupe</span><b>12 élèves max.</b></li>
                    <li><span>Prochaine rentrée</span><b>{{ $sessions->first()['start'] ?? 'Sur demande' }}</b></li>
                </ul>
                @if ($sessions->isNotEmpty() && $sessions->first()['left'] > 0)
                    <p class="small" style="color: var(--orange-text); font-weight: 600;">🔥 Plus que {{ $sessions->first()['left'] }} places</p>
                @endif
                <a class="btn btn-primary btn-block" href="{{ $site->url('inscription') }}?formation={{ $training['slug'] }}">Réserver ma place</a>
                <a class="btn btn-ghost btn-block mt-1" href="{{ $site->whatsappLink('Bonjour, j’ai une question sur la formation « '.$training['title'].' ».') }}" target="_blank" rel="noopener"><svg class="wa-ico"><use href="#wa"/></svg>Poser une question</a>
                <p class="muted small center mt-1" style="margin-bottom: 0;">Wave · Orange Money · MTN · Moov · Espèces</p>
            </aside>
        </div>
    </section>

    <section class="section section-alt">
        <div class="wrap">
            <h2>Autres formations</h2>
            <div class="grid grid-3 mt-2">
                @foreach (collect($site->trainings())->where('slug', '!=', $training['slug'])->take(3) as $otherTraining)
                    @include('site.partials.training-card', ['training' => $otherTraining])
                @endforeach
            </div>
        </div>
    </section>
@endsection
