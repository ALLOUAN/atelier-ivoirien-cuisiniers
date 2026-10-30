@extends('site.layouts.gerant')

@push('styles')
    .pos { display: grid; grid-template-columns: 1fr 360px; gap: 20px; align-items: start; }
    .products { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; }
    .product { background: #fff; border: 1px solid var(--line); border-radius: var(--radius); padding: 14px; text-align: left; cursor: pointer; font: inherit; display: grid; gap: 4px; }
    .product:hover { border-color: var(--orange); }
    .product:active { transform: scale(.98); }
    .product .e { font-size: 1.8rem; height: 84px; margin: -14px -14px 6px; display: grid; place-items: center; background: var(--orange-50); border-radius: var(--radius) var(--radius) 0 0; overflow: hidden; }
    .product .e img { width: 100%; height: 100%; object-fit: cover; }
    .product b { color: var(--ink); font-size: .9rem; line-height: 1.3; }
    .product span { color: var(--navy); font-weight: 700; font-size: .85rem; }
    .ticket { position: sticky; top: 20px; border-top: 4px solid var(--orange); }
    .ticket-lines { list-style: none; padding: 0; margin: 0 0 12px; min-height: 120px; max-height: 300px; overflow: auto; }
    .ticket-lines li { display: grid; grid-template-columns: 1fr auto auto; gap: 10px; align-items: center; padding: 8px 0; border-bottom: 1px dashed var(--line); font-size: .9rem; }
    .ticket-lines button { border: 0; background: var(--danger-bg); color: var(--danger); border-radius: 6px; width: 26px; height: 26px; cursor: pointer; font-weight: 700; }
    .ticket-total { display: flex; justify-content: space-between; font-family: var(--heading); font-size: 1.4rem; font-weight: 700; color: var(--navy); padding: 12px 0; border-top: 1px solid var(--line); }
    .receipt { position: fixed; inset: 0; background: rgb(2 23 50 / .55); display: grid; place-items: center; z-index: 100; padding: 20px; }
    .receipt .panel { width: min(380px, 100%); text-align: center; }
    .receipt .ok { width: 64px; height: 64px; border-radius: 50%; background: var(--success-bg); color: var(--success); display: grid; place-items: center; font-size: 2rem; margin: 0 auto 12px; }
    @media (max-width: 1000px) { .pos { grid-template-columns: 1fr; } .ticket { position: static; } }
@endpush

@section('content')
    @php
        $menu = $site->menu();
        $extras = ['Formations' => array_map(fn (array $training): array => ['name' => 'Versement · '.$training['title'], 'price' => (int) (ceil($training['price'] / $training['installments'] / 500) * 500), 'emoji' => $training['icon'], 'image' => $training['image'], 'desc' => ''], $site->trainings())];
    @endphp

    <div class="pos" data-pos>
        <div>
            <div class="choices" role="group" aria-label="Catégories" style="margin-bottom: 16px;">
                @foreach (array_keys($menu + $extras) as $category)
                    <label class="choice"><input type="radio" name="cat" value="{{ $loop->index }}" @checked($loop->first)><span>{{ $category }}</span></label>
                @endforeach
            </div>
            @foreach (array_values($menu + $extras) as $index => $items)
                <div class="products" data-cat="{{ $index }}" @if ($index > 0) hidden @endif>
                    @foreach ($items as $item)
                        <button class="product" type="button" data-name="{{ $item['name'] }}" data-price="{{ $item['price'] }}">
                            <span class="e" aria-hidden="true">@isset($item['image'])<img src="{{ $site->photo($item['image']) }}" alt="" loading="lazy">@else{{ $item['emoji'] }}@endisset</span><b>{{ $item['name'] }}</b><span>{{ $site->money($item['price']) }}</span>
                        </button>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="panel ticket">
            <h2>Ticket en cours</h2>
            <input class="input" data-client placeholder="Client (facultatif) : nom ou téléphone" style="margin-bottom: 10px;">
            <ul class="ticket-lines" data-lines></ul>
            <p class="muted small" data-empty>Touchez un produit pour l’ajouter.</p>
            <div class="ticket-total"><span>Total</span><span data-total>0 FCFA</span></div>
            <div class="choices" style="margin-bottom: 14px;">
                @foreach (['Espèces', 'Wave', 'Orange Money', 'MTN MoMo', 'Moov'] as $method)
                    <label class="choice"><input type="radio" name="method" value="{{ $method }}" @checked($loop->first)><span>{{ $method }}</span></label>
                @endforeach
            </div>
            <button class="btn btn-primary btn-block" type="button" data-pay disabled>Encaisser</button>
        </div>
    </div>

    <div class="receipt" data-receipt hidden>
        <div class="panel">
            <div class="ok">✓</div>
            <h2 style="margin-bottom: 4px;">Vente enregistrée</h2>
            <p class="muted" data-receipt-text></p>
            <button class="btn btn-primary btn-block" type="button" data-receipt-send><svg class="wa-ico"><use href="#wa"/></svg>Envoyer le reçu par WhatsApp</button>
            <button class="btn btn-ghost btn-block mt-1" type="button" data-receipt-close>Nouvelle vente</button>
            <p class="muted small mt-1" style="margin-bottom: 0;">Le stock et le tableau de bord sont mis à jour automatiquement.</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            const root = document.querySelector('[data-pos]');
            const ticket = new Map();
            let lastSale = null;
            const total = () => [...ticket.values()].reduce((sum, line) => sum + line.price * line.quantity, 0);

            root.querySelectorAll('[name="cat"]').forEach((input) => input.addEventListener('change', () => {
                root.querySelectorAll('[data-cat]').forEach((group) => { group.hidden = group.dataset.cat !== input.value; });
            }));

            const render = () => {
                const lines = root.querySelector('[data-lines]');
                lines.innerHTML = '';
                ticket.forEach((line, name) => {
                    const row = document.createElement('li');
                    row.innerHTML = '<span></span><b></b><button type="button" aria-label="Retirer">−</button>';
                    row.children[0].textContent = line.quantity + ' × ' + name;
                    row.children[1].textContent = AIC.money(line.price * line.quantity);
                    row.children[2].addEventListener('click', () => {
                        line.quantity > 1 ? line.quantity-- : ticket.delete(name);
                        render();
                    });
                    lines.append(row);
                });
                root.querySelector('[data-empty]').hidden = ticket.size > 0;
                root.querySelector('[data-total]').textContent = AIC.money(total());
                root.querySelector('[data-pay]').disabled = ticket.size === 0;
            };

            root.querySelectorAll('.product').forEach((button) => button.addEventListener('click', () => {
                const line = ticket.get(button.dataset.name) ?? { price: Number(button.dataset.price), quantity: 0 };
                line.quantity++;
                ticket.set(button.dataset.name, line);
                render();
            }));

            const receipt = document.querySelector('[data-receipt]');
            root.querySelector('[data-pay]').addEventListener('click', () => {
                const method = root.querySelector('[name="method"]:checked').value;
                const number = 'V-' + String(Date.now()).slice(-5);
                lastSale = ['Atelier Ivoirien Des Cuisiniers', 'Reçu ' + number + ' · ' + new Date().toLocaleString('fr-FR'), '',
                    ...[...ticket].map(([name, line]) => line.quantity + ' × ' + name + ' : ' + AIC.money(line.price * line.quantity)),
                    '', 'Total : ' + AIC.money(total()), 'Payé par : ' + method, '', 'Merci et à bientôt !'].join('\n');
                document.querySelector('[data-receipt-text]').textContent = 'Reçu ' + number + ' · ' + AIC.money(total()) + ' · ' + method;
                receipt.hidden = false;
            });
            document.querySelector('[data-receipt-send]').addEventListener('click', () => AIC.send(lastSale));
            document.querySelector('[data-receipt-close]').addEventListener('click', () => {
                receipt.hidden = true;
                ticket.clear();
                root.querySelector('[data-client]').value = '';
                render();
            });
        })();
    </script>
@endpush
