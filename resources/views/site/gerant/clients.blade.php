@extends('site.layouts.gerant')

@push('styles')
    .toolbar { display: flex; gap: 12px; flex-wrap: wrap; justify-content: space-between; margin-bottom: 16px; }
    .paid { width: 110px; height: 8px; background: var(--navy-100); border-radius: 4px; overflow: hidden; display: inline-block; vertical-align: middle; margin-right: 8px; }
    .paid i { display: block; height: 100%; background: var(--success); }
@endpush

@section('top_actions')
    <button class="btn btn-primary btn-sm" type="button" onclick="alert('Maquette : formulaire d’ajout d’un élève ou d’un client.')">+ Ajouter</button>
@endsection

@section('content')
    @php
        $clients = collect($site->clients());
        $owed = $clients->sum(fn (array $client): int => $client['total'] - $client['paid']);
    @endphp

    <div class="kpis">
        <div class="kpi dark"><span>Reste à encaisser</span><b>{{ $site->money($owed) }}</b><span class="up">{{ $clients->filter(fn (array $client): bool => $client['paid'] < $client['total'])->count() }} dossiers</span></div>
        <div class="kpi"><span>Élèves en cours</span><b>{{ $clients->where('type', 'Élève')->count() }}</b></div>
        <div class="kpi"><span>Clients fidèles</span><b>{{ $clients->where('type', '!=', 'Élève')->count() }}</b><span class="muted small">5 commandes et plus</span></div>
        <div class="kpi"><span>Nouveaux ce mois</span><b>27</b><span class="up">▲ 8 vs septembre</span></div>
    </div>

    <div class="panel">
        <div class="toolbar">
            <input class="input search" type="search" placeholder="Nom ou téléphone…" data-search>
            <div class="choices" data-type>
                @foreach (['Tous', 'Élève', 'Client', 'Entreprise'] as $type)
                    <label class="choice"><input type="radio" name="type" value="{{ $type }}" @checked($loop->first)><span>{{ $type }}</span></label>
                @endforeach
            </div>
        </div>
        <div class="table-wrap" style="border: 0;">
            <table>
                <thead><tr><th>Nom</th><th>Type</th><th>Détail</th><th>Versements</th><th class="num">Reste</th><th>Dernier contact</th><th></th></tr></thead>
                <tbody data-clients>
                    @foreach ($clients as $client)
                        @php($left = $client['total'] - $client['paid'])
                        <tr data-type="{{ $client['type'] }}" data-search="{{ \Illuminate\Support\Str::lower($client['name'].' '.str_replace(' ', '', $client['phone'])) }}">
                            <td><b style="color: var(--ink)">{{ $client['name'] }}</b><span class="muted small" style="display: block;">{{ $client['phone'] }}</span></td>
                            <td><span @class(['tag', 'tag-orange' => $client['type'] === 'Élève', 'tag-gold' => $client['type'] === 'Entreprise'])>{{ $client['type'] }}</span></td>
                            <td>{{ $client['detail'] }}</td>
                            <td>
                                @if ($client['total'] > 0)
                                    <span class="paid"><i style="width: {{ round($client['paid'] / $client['total'] * 100) }}%"></i></span><span class="small muted">{{ $site->money($client['paid']) }}</span>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>
                            <td class="num">@if ($left > 0)<b style="color: var(--danger)">{{ $site->money($left) }}</b>@else<span class="tag tag-success">À jour</span>@endif</td>
                            <td class="muted">{{ $client['last'] }}</td>
                            <td>
                                <a class="btn btn-ghost btn-sm" href="{{ $site->whatsappLink($left > 0 ? 'Bonjour '.$client['name'].', petit rappel : il reste '.$site->money($left).' à régler pour votre formation. Merci !' : 'Bonjour '.$client['name'].', ') }}" target="_blank" rel="noopener">{{ $left > 0 ? 'Relancer' : 'Écrire' }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            const search = document.querySelector('[data-search]');
            const filter = () => {
                const type = document.querySelector('[name="type"]:checked').value;
                const term = search.value.trim().toLowerCase().replace(/\s/g, '');
                document.querySelectorAll('[data-clients] tr').forEach((row) => {
                    row.hidden = (type !== 'Tous' && row.dataset.type !== type) || !row.dataset.search.replace(/\s/g, '').includes(term);
                });
            };
            search.addEventListener('input', filter);
            document.querySelectorAll('[name="type"]').forEach((input) => input.addEventListener('change', filter));
        })();
    </script>
@endpush
