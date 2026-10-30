@extends('site.layouts.site')

@push('styles')
    .rating-summary { display: grid; grid-template-columns: 240px 1fr; gap: 40px; align-items: center; }
    .score { text-align: center; background: var(--navy); color: #fff; border-radius: var(--radius); padding: 28px; border-bottom: 4px solid var(--gold); }
    .score b { display: block; font-family: var(--heading); font-size: 3.4rem; line-height: 1; }
    .score span { color: #9fb0c8; font-size: .9rem; }
    .dist { display: grid; gap: 8px; }
    .dist div { display: grid; grid-template-columns: 40px 1fr 40px; gap: 12px; align-items: center; font-size: .9rem; }
    .dist i { display: block; height: 10px; background: var(--navy-100); border-radius: 5px; overflow: hidden; }
    .dist i::before { content: ''; display: block; height: 100%; width: var(--w); background: var(--gold); }
    @media (max-width: 700px) { .rating-summary { grid-template-columns: 1fr; } }
@endpush

@section('page_head')
    <h1>Avis clients</h1>
    <p class="lead" style="margin: 0;">Élèves, clients du menu, familles servies par notre traiteur : ils racontent.</p>
@endsection

@section('content')
    @php
        $reviews = collect($site->reviews());
        $average = number_format($reviews->avg('rating'), 1, ',', '');
    @endphp

    <section class="section">
        <div class="wrap">
            <div class="rating-summary">
                <div class="score">
                    <b>{{ $average }}</b>
                    <div class="stars" style="font-size: 1.2rem;">★★★★★</div>
                    <span>{{ $reviews->count() }} avis sur le site · 128 sur Google</span>
                </div>
                <div class="dist">
                    @foreach ([5 => 86, 4 => 10, 3 => 3, 2 => 1, 1 => 0] as $stars => $percent)
                        <div><span>{{ $stars }} ★</span><i style="--w: {{ $percent }}%"></i><span class="muted">{{ $percent }} %</span></div>
                    @endforeach
                    <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 10px;">
                        <a class="btn btn-primary btn-sm" href="{{ $site->whatsappLink('Bonjour, je souhaite laisser un avis :') }}" target="_blank" rel="noopener">Laisser un avis</a>
                        <a class="btn btn-ghost btn-sm" href="#" onclick="return false">Voir nos avis Google</a>
                    </div>
                </div>
            </div>

            <div class="grid grid-3 mt-3">
                @foreach ($reviews as $review)
                    @include('site.partials.review-card')
                @endforeach
            </div>
        </div>
    </section>
@endsection
