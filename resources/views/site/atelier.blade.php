@extends('site.layouts.site')

@push('styles')
    .story { display: grid; grid-template-columns: 1fr 1.05fr; gap: 64px; align-items: center; }
    .story p { font-size: 1.04rem; }
    .story-visual { position: relative; padding: 0 0 48px 48px; }
    .story-visual .main { width: 100%; aspect-ratio: 4 / 3.4; object-fit: cover; display: block; border-radius: var(--radius-xl); box-shadow: var(--shadow-lg); }
    .story-visual .inset { position: absolute; left: 0; bottom: 0; width: 44%; aspect-ratio: 1; object-fit: cover; border: 6px solid #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); }
    .story-visual .badge { position: absolute; right: 22px; top: 22px; display: flex; align-items: center; gap: 12px; padding: 12px 18px 12px 12px; border-radius: var(--pill); background: rgb(255 255 255 / .92); -webkit-backdrop-filter: blur(10px); backdrop-filter: blur(10px); box-shadow: var(--shadow); font-size: .82rem; color: var(--muted); line-height: 1.2; }
    .story-visual .badge span { width: 40px; height: 40px; border-radius: 50%; display: grid; place-items: center; background: var(--navy); color: #fff; font-family: var(--heading); font-weight: 700; font-size: .85rem; box-shadow: inset 0 -3px 0 var(--gold); }
    .story-visual .badge b { display: block; color: var(--navy); font-size: .92rem; }
    .signature { display: flex; align-items: center; gap: 14px; margin: 28px 0; padding: 16px 18px; border-left: 3px solid var(--gold); background: #fff; }
    .signature span { font-size: 2rem; }
    .signature p { margin: 0; font-style: italic; color: var(--ink); }
    .signature small { display: block; font-style: normal; color: var(--muted); margin-top: 4px; }

    .figures-band { position: relative; overflow: hidden; background: var(--navy); border-radius: var(--radius-xl); padding: 56px 40px; }
    .figures-band::after { content: ''; position: absolute; left: 50%; translate: -50% 0; bottom: 0; width: 120px; height: 4px; border-radius: 4px 4px 0 0; background: var(--gold); }
    .figures { display: grid; grid-template-columns: repeat(4, 1fr); text-align: center; }
    .figures div + div { border-left: 1px solid var(--navy-700); }
    .figures b { display: block; font-family: var(--heading); font-size: clamp(2.2rem, 4vw, 3rem); letter-spacing: -.03em; line-height: 1.1; color: #fff; }
    .figures b em { font-style: normal; color: var(--orange-on-dark); }
    .figures span { color: #9fb0c8; font-size: .92rem; }

    .chef { align-items: center; text-align: center; padding: 34px 28px; }
    .chef-photo { position: relative; width: 116px; height: 116px; border-radius: 50%; background: var(--orange-50); display: grid; place-items: center; font-size: 3.4rem; margin-bottom: 18px; box-shadow: 0 0 0 6px #fff, 0 0 0 7px var(--orange-100); transition: transform .4s var(--ease); }
    .chef:hover .chef-photo { transform: scale(1.06) rotate(-3deg); }
    .chef h3 { margin-bottom: 8px; }
    .chef p { color: var(--muted); margin: 14px 0 0; }

    @media (max-width: 860px) {
        .story { grid-template-columns: 1fr; gap: 40px; }
        .story-visual { padding: 0 0 36px 28px; }
        .figures { grid-template-columns: 1fr 1fr; row-gap: 28px; }
        .figures div:nth-child(3) { border-left: 0; }
        .figures-band { padding: 40px 20px; border-radius: var(--radius-lg); }
    }
@endpush

@section('page_head')
    <h1>L’atelier & les chefs</h1>
    <p class="lead" style="margin: 0;">Une école de cuisine née à Cocody, avec une conviction : un bon métier commence par de bons gestes.</p>
    <div class="head-stats">
        <div><span aria-hidden="true">📍</span><p><b>{{ $business['city'] }}</b>{{ $business['address'] }}</p></div>
        <div><span aria-hidden="true">🕗</span><p><b>Horaires</b>{{ $business['hours'] }}</p></div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="wrap story">
            <div>
                <span class="eyebrow">Notre histoire</span>
                <h2>De la cuisine familiale à l’école</h2>
                <p>Tout a commencé dans une cuisine d’Angré, où Chef Adjoua formait les jeunes du quartier qui voulaient travailler en restaurant. Les demandes se sont multipliées : l’Atelier Ivoirien Des Cuisiniers est né.</p>
                <p>Aujourd’hui, l’atelier, c’est une cuisine pédagogique de 12 postes, une équipe de chefs formateurs, un menu du jour cuisiné par les élèves et un service traiteur pour les grandes occasions.</p>
                <div class="signature"><span aria-hidden="true">👩🏾‍🍳</span><p>« Ici, on apprend en faisant : chaque élève repart avec des gestes sûrs et des recettes qui se vendent. »<small>Chef Adjoua K., fondatrice</small></p></div>
                <div class="hero-ctas" style="display: flex; flex-wrap: wrap; gap: 12px;">
                    <a class="btn btn-primary" href="{{ $site->url('formations') }}">Découvrir les formations</a>
                    <a class="btn btn-ghost" href="{{ $site->url('contact') }}">Visiter l’atelier</a>
                </div>
            </div>
            <div class="story-visual">
                <img class="main" src="{{ $site->photo('cuisiniere2') }}" alt="Une cuisinière dresse une assiette en cuisine professionnelle" loading="lazy">
                <img class="inset" src="{{ $site->photo('sauce-graine1') }}" alt="Sauce graine préparée au pilon" loading="lazy">
                <div class="badge"><span>10+</span><div><b>ans de métier</b>à Cocody</div></div>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="wrap">
            <div class="figures-band">
                <div class="figures">
                    <div><b>10<em>+</em></b><span>années d’expérience</span></div>
                    <div><b>500<em>+</em></b><span>élèves formés</span></div>
                    <div><b>12</b><span>postes de cuisine</span></div>
                    <div><b>80<em>%</em></b><span>de pratique</span></div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="wrap">
            <div class="center" style="margin-bottom: 44px;">
                <span class="eyebrow">L’équipe</span>
                <h2>Nos chefs formateurs</h2>
                <p class="lead">Des professionnels passés par l’hôtellerie et la restauration, qui transmettent leurs gestes au quotidien.</p>
            </div>
            <div class="grid grid-3">
                @foreach ($site->chefs() as $chef)
                    <div class="card hover chef">
                        <div class="chef-photo" aria-hidden="true">{{ $chef['emoji'] }}</div>
                        <h3>{{ $chef['name'] }}</h3>
                        <span class="tag tag-orange">{{ $chef['role'] }}</span>
                        <p>{{ $chef['bio'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="wrap">
            <div class="center" style="margin-bottom: 44px;">
                <span class="eyebrow">Nos engagements</span>
                <h2>Ce qui fait la différence</h2>
            </div>
            <div class="tiles">
                @foreach ([['🧑🏾‍🍳', 'Petits groupes', '12 élèves maximum, chacun à son poste.'], ['🧼', 'Hygiène stricte', 'Les règles d’un vrai restaurant, dès le premier jour.'], ['🤝', 'Suivi après la formation', 'Mise en relation avec des restaurants partenaires.'], ['💳', 'Paiement souple', 'En plusieurs fois, par Mobile Money.']] as [$icon, $title, $text])
                    <div class="tile"><span class="icon-box" aria-hidden="true">{{ $icon }}</span><h3>{{ $title }}</h3><p>{{ $text }}</p></div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 0;">
        <div class="wrap">
            <div class="help">
                <div>
                    <span class="eyebrow">Portes ouvertes</span>
                    <h2>Venez voir l’atelier avant de vous inscrire</h2>
                    <p>Visitez la cuisine, rencontrez un chef et posez vos questions, du lundi au samedi.</p>
                </div>
                <div class="help-actions">
                    <a class="btn btn-primary" href="{{ $site->whatsappLink('Bonjour, je souhaite visiter l’atelier. Quand puis-je passer ?') }}" target="_blank" rel="noopener"><svg class="wa-ico"><use href="#wa"/></svg>Planifier une visite</a>
                    <a class="btn btn-ghost" href="{{ $site->url('reussites') }}">Réussites d’élèves</a>
                </div>
            </div>
        </div>
    </section>
@endsection
