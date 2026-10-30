@extends('site.layouts.gerant')

@push('styles')
    .dash { display: grid; grid-template-columns: 1.6fr 1fr; gap: 20px; }
    .chart { display: flex; align-items: flex-end; gap: 12px; height: 200px; padding-top: 10px; }
    .chart div { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 6px; height: 100%; justify-content: flex-end; font-size: .75rem; color: var(--muted); }
    .chart i { width: 100%; max-width: 44px; background: var(--navy-100); border-radius: 6px 6px 0 0; }
    .chart div:last-child i { background: var(--orange); }
    .chart div:last-child { color: var(--orange-text); font-weight: 700; }
    .split { display: grid; gap: 12px; }
    .split div { display: grid; grid-template-columns: 110px 1fr auto; gap: 10px; align-items: center; font-size: .88rem; }
    .split i { height: 10px; border-radius: 5px; background: var(--navy-100); overflow: hidden; }
    .split i::before { content: ''; display: block; height: 100%; width: var(--w); background: var(--navy); }
    .alert-list { display: grid; gap: 10px; }
    .alert { display: flex; gap: 10px; align-items: center; padding: 12px; border-radius: var(--radius-sm); font-size: .88rem; }
    .alert-warning { background: var(--warning-bg); color: var(--warning); }
    .alert-info { background: var(--navy-50); color: var(--navy); }
    @media (max-width: 1000px) { .dash { grid-template-columns: 1fr; } }
@endpush

@section('top_actions')
    <a class="btn btn-primary btn-sm" href="{{ $site->url('gerant/caisse') }}">+ Nouvelle vente</a>
@endsection

@section('content')
    @php
        $dashboard = $site->dashboard();
        $peak = max(array_column($dashboard['week'], 'amount'));
        $cashTotal = array_sum($dashboard['cash_in']);
        $lowStock = collect($site->stock())->filter(fn (array $item): bool => $item['quantity'] < $item['minimum']);
        $balances = collect($site->clients())->sum(fn (array $client): int => $client['total'] - $client['paid']);
    @endphp

    <div class="kpis">
        <div class="kpi dark"><span>Ventes du jour</span><b>{{ $site->money($dashboard['today']) }}</b><span class="up">▲ {{ $dashboard['change'] }} % vs hier</span></div>
        <div class="kpi"><span>Commandes</span><b>{{ $dashboard['orders'] }}</b><span class="muted small">dont 9 livrées</span></div>
        <div class="kpi"><span>Inscriptions</span><b>{{ $dashboard['signups'] }}</b><span class="muted small">cette semaine : 11</span></div>
        <div class="kpi"><span>Reste à encaisser</span><b>{{ $site->money($balances) }}</b><span class="muted small">versements élèves</span></div>
    </div>

    <div class="dash">
        <div class="panel">
            <h2>Ventes des 7 derniers jours</h2>
            <div class="chart">
                @foreach ($dashboard['week'] as $day)
                    <div title="{{ $site->money($day['amount']) }}"><span>{{ round($day['amount'] / 1000) }}k</span><i style="height: {{ round($day['amount'] / $peak * 80) }}%"></i>{{ $day['day'] }}</div>
                @endforeach
            </div>
        </div>
        <div class="panel">
            <h2>Encaissements du jour</h2>
            <div class="split">
                @foreach ($dashboard['cash_in'] as $method => $amount)
                    <div><span>{{ $method }}</span><i style="--w: {{ round($amount / $cashTotal * 100) }}%"></i><b style="color: var(--ink)">{{ $site->money($amount) }}</b></div>
                @endforeach
            </div>
        </div>

        <div class="panel">
            <h2>Dernières opérations</h2>
            <div class="table-wrap" style="border: 0;">
                <table>
                    <thead><tr><th>Heure</th><th>Client</th><th>Détail</th><th>Moyen</th><th>Statut</th><th class="num">Montant</th></tr></thead>
                    <tbody>
                        @foreach ($dashboard['recent'] as $operation)
                            <tr>
                                <td class="muted">{{ $operation['time'] }}</td>
                                <td><b style="color: var(--ink)">{{ $operation['client'] }}</b></td>
                                <td>{{ $operation['label'] }}</td>
                                <td>{{ $operation['method'] }}</td>
                                <td><span @class(['tag', 'tag-success' => in_array($operation['status'], ['Livrée', 'Payée']), 'tag-orange' => $operation['status'] === 'En livraison', 'tag-warning' => $operation['status'] === 'En préparation'])>{{ $operation['status'] }}</span></td>
                                <td class="num"><b style="color: var(--navy)">{{ $site->money($operation['amount']) }}</b></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div style="display: grid; gap: 20px; align-content: start;">
            <div class="panel">
                <h2>À surveiller</h2>
                <div class="alert-list">
                    @foreach ($lowStock as $item)
                        <a class="alert alert-warning" href="{{ $site->url('gerant/stock') }}">⚠️ <span><b>{{ $item['name'] }}</b> : {{ $item['quantity'] }} {{ $item['unit'] }} (min. {{ $item['minimum'] }})</span></a>
                    @endforeach
                    <a class="alert alert-info" href="{{ $site->url('gerant/clients') }}">🎓 <span><b>3 élèves</b> ont un versement à faire cette semaine</span></a>
                </div>
            </div>
            <div class="panel">
                <h2>Plats les plus vendus (mois)</h2>
                <ol style="margin: 0; padding-left: 20px; display: grid; gap: 8px; font-size: .92rem;">
                    @foreach ($dashboard['best_sellers'] as $dish)
                        <li><span style="display: flex; justify-content: space-between;"><span>{{ $dish['name'] }}</span><b style="color: var(--navy)">{{ $dish['sold'] }}</b></span></li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
@endsection
