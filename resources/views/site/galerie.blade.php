@extends('site.layouts.site')

@push('styles')
    .gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px; }
    .shot { position: relative; aspect-ratio: 4 / 3; border-radius: var(--radius); background: var(--navy); overflow: hidden; cursor: zoom-in; }
    .shot img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .5s; }
    .shot:hover img { transform: scale(1.06); }
    .shot figcaption { position: absolute; inset: auto 0 0 0; background: rgb(2 23 50 / .85); color: #fff; font-size: .85rem; font-weight: 600; padding: 10px 14px; text-align: left; transform: translateY(100%); transition: transform .2s; }
    .shot:hover figcaption, .shot:focus-within figcaption { transform: none; }
    .lightbox { position: fixed; inset: 0; z-index: 100; background: rgb(2 23 50 / .92); display: grid; place-items: center; padding: 24px; }
    .lightbox figure { margin: 0; max-width: min(1000px, 100%); }
    .lightbox img { width: 100%; max-height: 78vh; object-fit: contain; border-radius: var(--radius); border-bottom: 4px solid var(--gold); }
    .lightbox figcaption { color: #fff; text-align: center; margin-top: 12px; font-weight: 600; }
    .lightbox button { position: absolute; top: 18px; right: 18px; width: 46px; height: 46px; border-radius: var(--radius-sm); border: 0; background: var(--orange); color: #fff; font-size: 1.4rem; cursor: pointer; }
    .shot .play { position: absolute; top: 12px; right: 12px; background: var(--orange); color: #fff; font-size: .75rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; }
@endpush

@section('page_head')
    <h1>Galerie</h1>
    <p class="lead" style="margin: 0;">Nos cours, nos plats et nos événements, en photos et en vidéos.</p>
@endsection

@section('content')
    <section class="section">
        <div class="wrap">
            <div class="choices" role="group" aria-label="Filtrer la galerie" data-filters>
                @foreach (['Tout', 'Cours', 'Plats', 'Traiteur', 'Atelier'] as $category)
                    <label class="choice"><input type="radio" name="categorie" value="{{ $category }}" @checked($loop->first)><span>{{ $category }}</span></label>
                @endforeach
            </div>
            <div class="gallery mt-2" data-gallery>
                @foreach ($site->gallery() as $item)
                    <figure class="shot" data-category="{{ $item['category'] }}" tabindex="0" style="margin: 0;">
                        <img src="{{ $site->photo($item['image']) }}" alt="{{ $item['label'] }}" loading="lazy">
                        @if ($item['video'])<span class="play">▶ Vidéo</span>@endif
                        <figcaption>{{ $item['label'] }}</figcaption>
                    </figure>
                @endforeach
            </div>
            <p class="muted small center mt-2">Photos d’illustration (voir les <a class="link" href="{{ $site->url('mentions-legales') }}#credits">crédits</a>), à remplacer par celles de l’atelier. Suivez-nous aussi sur Facebook, Instagram et TikTok.</p>
        </div>
    </section>

    <div class="lightbox" role="dialog" aria-modal="true" aria-label="Photo agrandie" data-lightbox hidden>
        <button type="button" aria-label="Fermer" data-close>×</button>
        <figure><img alt=""><figcaption></figcaption></figure>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('[data-filters] input').forEach((input) => input.addEventListener('change', () => {
            document.querySelectorAll('[data-gallery] [data-category]').forEach((shot) => {
                shot.hidden = input.value !== 'Tout' && shot.dataset.category !== input.value;
            });
        }));

        (() => {
            const lightbox = document.querySelector('[data-lightbox]');
            let opener = null;
            const open = (shot) => {
                const image = shot.querySelector('img');
                opener = shot;
                lightbox.querySelector('img').src = image.src;
                lightbox.querySelector('img').alt = image.alt;
                lightbox.querySelector('figcaption').textContent = image.alt;
                lightbox.hidden = false;
                lightbox.querySelector('[data-close]').focus();
            };
            const close = () => { lightbox.hidden = true; opener?.focus(); };
            document.querySelectorAll('[data-gallery] .shot').forEach((shot) => {
                shot.addEventListener('click', () => open(shot));
                shot.addEventListener('keydown', (event) => { if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); open(shot); } });
            });
            lightbox.addEventListener('click', (event) => { if (event.target === lightbox || event.target.closest('[data-close]')) { close(); } });
            document.addEventListener('keydown', (event) => { if (event.key === 'Escape' && !lightbox.hidden) { close(); } });
        })();
    </script>
@endpush
