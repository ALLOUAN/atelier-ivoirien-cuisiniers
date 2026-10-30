{{-- One review: $review (see AtelierCuisiniers::reviews()). --}}
<blockquote class="card hover review" style="margin: 0; position: relative;">
    <span aria-hidden="true" style="position: absolute; top: 10px; right: 22px; font-family: var(--heading); font-size: 4.5rem; line-height: 1; color: var(--orange-100);">”</span>
    <div class="stars" aria-label="{{ $review['rating'] }} étoiles sur 5">{{ str_repeat('★', $review['rating']) }}<span style="color: var(--line-strong)">{{ str_repeat('★', 5 - $review['rating']) }}</span></div>
    <p style="margin-top: 14px; color: var(--ink); font-size: 1.02rem;">« {{ $review['text'] }} »</p>
    <footer style="display: flex; gap: 12px; align-items: center; font-size: .88rem; margin-top: auto;">
        <span class="avatar">{{ mb_substr($review['name'], 0, 1) }}</span>
        <div><b style="color: var(--ink)">{{ $review['name'] }}</b><span class="muted small" style="display: block;">{{ $review['role'] }} · {{ $review['date'] }}</span></div>
    </footer>
</blockquote>
