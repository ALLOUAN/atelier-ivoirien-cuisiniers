{{-- One training as a card: $training (see AtelierCuisiniers::trainings()). --}}
@once
    @push('styles')
        .card-photo { position: relative; display: block; margin: -26px -26px 20px; aspect-ratio: 16 / 11; overflow: hidden; border-radius: var(--radius-lg) var(--radius-lg) 0 0; }
        .card.featured .card-photo { margin: -26px -26px 20px; }
        .card-photo img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .8s var(--ease); }
        .card:hover .card-photo img { transform: scale(1.06); }
        .card-photo .icon-box { position: absolute; left: 18px; bottom: -24px; margin: 0; background: #fff; box-shadow: var(--shadow); border: 4px solid #fff; border-radius: 16px; width: 56px; height: 56px; font-size: 1.5rem; }
        .card-photo .duration { position: absolute; right: 12px; top: 12px; background: rgb(255 255 255 / .9); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); color: var(--navy); font-size: .75rem; font-weight: 700; padding: 5px 11px; border-radius: var(--pill); box-shadow: var(--shadow-sm); }
        .card.featured::before { z-index: 2; }
    @endpush
@endonce
<article @class(['card', 'hover', 'featured' => $training['featured']]) data-badge="Le plus demandé" data-category="{{ $training['category'] }}">
    <a class="card-photo" href="{{ $site->trainingUrl($training['slug']) }}" tabindex="-1" style="overflow: visible;">
        <span style="display: block; height: 100%; overflow: hidden; border-radius: inherit;"><img src="{{ $site->photo($training['image']) }}" alt="{{ $training['title'] }}" loading="lazy"></span>
        <span class="duration">⏱ {{ $training['duration'] }}</span>
        <span class="icon-box" aria-hidden="true">{{ $training['icon'] }}</span>
    </a>
    <h3 style="margin-top: 14px;"><a href="{{ $site->trainingUrl($training['slug']) }}">{{ $training['title'] }}</a></h3>
    <div class="tags" style="margin-bottom: 14px;"><span class="tag tag-orange">{{ $training['level'] }}</span><span class="tag">🗓 {{ $training['schedule'] }}</span></div>
    <ul class="bullets">
        @foreach ($training['points'] as $point)
            <li>{{ $point }}</li>
        @endforeach
    </ul>
    <div class="price-line">À partir de<b>{{ $site->money($training['price']) }}</b>@if ($training['installments'] > 1)<span class="small">ou {{ $training['installments'] }} versements</span>@endif</div>
    <a class="btn {{ $training['featured'] ? 'btn-primary' : 'btn-ghost' }} btn-sm btn-block mt-1" href="{{ $site->trainingUrl($training['slug']) }}">Voir le programme</a>
</article>
