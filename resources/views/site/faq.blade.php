@extends('site.layouts.site')

@section('page_head')
    <h1>Questions fréquentes</h1>
    <p class="lead" style="margin: 0;">Formations, paiement, commandes : les réponses aux questions qu’on nous pose le plus.</p>
@endsection

@section('content')
    <section class="section">
        <div class="narrow">
            @foreach ($site->faq() as $topic => $questions)
                <h2 @class(['mt-3' => ! $loop->first]) style="font-size: 1.3rem;">{{ $topic }}</h2>
                @foreach ($questions as $item)
                    <details class="faq" @if ($loop->parent->first && $loop->first) open @endif><summary>{{ $item['q'] }}</summary><p>{{ $item['a'] }}</p></details>
                @endforeach
            @endforeach

            <div class="card mt-3 center" style="background: var(--alt);">
                <h3>Vous ne trouvez pas votre réponse ?</h3>
                <p class="muted">Posez-nous la question directement, un membre de l’équipe vous répond.</p>
                <a class="btn btn-primary" style="align-self: center;" href="{{ $site->whatsappLink('Bonjour, j’ai une question :') }}" target="_blank" rel="noopener"><svg class="wa-ico"><use href="#wa"/></svg>Poser ma question</a>
            </div>
        </div>
    </section>
@endsection
