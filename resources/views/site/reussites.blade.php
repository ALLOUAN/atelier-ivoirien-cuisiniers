@extends('site.layouts.site')

@push('styles')
    .success { display: grid; grid-template-columns: 160px 1fr; gap: 24px; padding: 0; overflow: hidden; }
    .success-visual { position: relative; min-height: 100%; box-shadow: inset -4px 0 0 var(--gold); overflow: hidden; }
    .success-visual img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .success-body { padding: 24px 24px 24px 0; }
    .journey { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin: 12px 0; font-size: .9rem; }
    .journey .arrow { color: var(--orange); font-weight: 700; }
    @media (max-width: 560px) { .success { grid-template-columns: 1fr; } .success-visual { height: 180px; } .success-body { padding: 0 22px 22px; } }
@endpush

@section('page_head')
    <h1>Réussites d’élèves</h1>
    <p class="lead" style="margin: 0;">Ils sont venus apprendre. Aujourd’hui, ils vivent de la cuisine.</p>
@endsection

@section('content')
    <section class="section">
        <div class="wrap grid grid-2">
            @foreach ($site->successes() as $success)
                <article class="card success">
                    <div class="success-visual"><img src="{{ $site->photo($success['image']) }}" alt="{{ $success['after'] }}" loading="lazy"></div>
                    <div class="success-body">
                        <span class="tag tag-orange">{{ $success['training'] }}</span>
                        <h3 class="mt-1" style="margin-bottom: 0;">{{ $success['name'] }}</h3>
                        <div class="journey"><span class="tag">Avant : {{ $success['before'] }}</span><span class="arrow">→</span><span class="tag tag-success">Après : {{ $success['after'] }}</span></div>
                        <p style="font-style: italic; margin: 0;">« {{ $success['quote'] }} »</p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section section-alt">
        <div class="wrap center">
            <h2>Et si la prochaine histoire, c’était la vôtre ?</h2>
            <p class="lead">Rejoignez la prochaine session et apprenez un métier qui recrute.</p>
            <a class="btn btn-primary mt-1" href="{{ $site->url('calendrier') }}">Voir les prochaines sessions</a>
        </div>
    </section>
@endsection
