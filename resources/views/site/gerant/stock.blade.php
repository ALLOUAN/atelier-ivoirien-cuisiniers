@extends('site.layouts.gerant')

@push('styles')
    .level { width: 120px; height: 8px; background: var(--navy-100); border-radius: 4px; overflow: hidden; display: inline-block; vertical-align: middle; margin-right: 8px; }
    .level i { display: block; height: 100%; background: var(--success); }
    tr.low .level i { background: var(--danger); }
    .adjust { display: inline-flex; gap: 6px; align-items: center; }
    .adjust button { width: 30px; height: 30px; border-radius: 6px; border: 1px solid var(--line); background: var(--navy-50); color: var(--navy); font-weight: 700; cursor: pointer; }
    .adjust button.plus { background: var(--orange); border-color: var(--orange); color: #fff; }
    .adjust output { min-width: 44px; text-align: center; font-weight: 700; color: var(--ink); }
    .toolbar { display: flex; gap: 12px; flex-wrap: wrap; justify-content: space-between; margin-bottom: 16px; }
@endpush

@section('top_actions')
    <button class="btn btn-ghost btn-sm" type="button" data-order>🛒 Bon de commande fournisseur</button>
@endsection

@section('content')
    @php
        $stock = collect($site->stock());
        $value = $stock->sum(fn (array $item): float => $item['quantity'] * $item['cost']);
    @endphp

    <div class="kpis">
        <div class="kpi dark"><span>Valeur du stock</span><b>{{ $site->money($value) }}</b><span class="up">au prix d’achat</span></div>
        <div class="kpi"><span>Articles suivis</span><b>{{ $stock->count() }}</b></div>
        <div class="kpi"><span>En alerte</span><b style="color: var(--danger)" data-low-count></b><span class="muted small">sous le minimum</span></div>
        <div class="kpi"><span>Dernière livraison</span><b>Hier</b><span class="muted small">Marché d’Adjamé</span></div>
    </div>

    <div class="panel">
        <div class="toolbar">
            <input class="input search" type="search" placeholder="Rechercher un ingrédient…" data-search>
            <label class="choice"><input type="checkbox" data-only-low><span>⚠️ Seulement les alertes</span></label>
        </div>
        <div class="table-wrap" style="border: 0;">
            <table>
                <thead><tr><th>Ingrédient</th><th>Catégorie</th><th>Niveau</th><th>Quantité</th><th class="num">Prix d’achat</th></tr></thead>
                <tbody data-stock>
                    @foreach ($stock as $item)
                        <tr data-name="{{ \Illuminate\Support\Str::lower($item['name']) }}" data-minimum="{{ $item['minimum'] }}" data-unit="{{ $item['unit'] }}" data-label="{{ $item['name'] }}">
                            <td><b style="color: var(--ink)">{{ $item['name'] }}</b> <span class="tag tag-danger" data-alert>Stock bas</span></td>
                            <td class="muted">{{ $item['category'] }}</td>
                            <td><span class="level"><i></i></span><span class="muted small">min. {{ $item['minimum'] }} {{ $item['unit'] }}</span></td>
                            <td><span class="adjust"><button type="button" class="minus" aria-label="Retirer">−</button><output data-quantity="{{ $item['quantity'] }}"></output><button type="button" class="plus" aria-label="Ajouter">+</button></span></td>
                            <td class="num">{{ $site->money($item['cost']) }} / {{ $item['unit'] }}</td>
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
            const rows = [...document.querySelectorAll('[data-stock] tr')];
            const search = document.querySelector('[data-search]');
            const onlyLow = document.querySelector('[data-only-low]');
            const isLow = (row) => Number(row.querySelector('output').dataset.quantity) < Number(row.dataset.minimum);

            const render = () => {
                rows.forEach((row) => {
                    const output = row.querySelector('output');
                    const quantity = Number(output.dataset.quantity);
                    const minimum = Number(row.dataset.minimum);
                    output.textContent = quantity + ' ' + row.dataset.unit;
                    row.classList.toggle('low', isLow(row));
                    row.querySelector('[data-alert]').hidden = !isLow(row);
                    row.querySelector('.level i').style.width = Math.min(100, quantity / (minimum * 2) * 100) + '%';
                    row.hidden = !row.dataset.name.includes(search.value.trim().toLowerCase()) || (onlyLow.checked && !isLow(row));
                });
                document.querySelector('[data-low-count]').textContent = rows.filter(isLow).length;
            };

            rows.forEach((row) => {
                const output = row.querySelector('output');
                row.querySelector('.plus').addEventListener('click', () => { output.dataset.quantity = Number(output.dataset.quantity) + 1; render(); });
                row.querySelector('.minus').addEventListener('click', () => { output.dataset.quantity = Math.max(0, Number(output.dataset.quantity) - 1); render(); });
            });
            search.addEventListener('input', render);
            onlyLow.addEventListener('change', render);

            document.querySelector('[data-order]').addEventListener('click', () => {
                const lines = rows.filter(isLow).map((row) => '• ' + row.dataset.label + ' : ' + (Number(row.dataset.minimum) * 2 - Number(row.querySelector('output').dataset.quantity)) + ' ' + row.dataset.unit);
                AIC.send(['Bonjour, commande pour l’Atelier Ivoirien Des Cuisiniers :', ...lines, '', 'Livraison souhaitée demain matin. Merci !'].join('\n'));
            });
            render();
        })();
    </script>
@endpush
