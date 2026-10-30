{{-- Online menu with a basket that sends the order to WhatsApp. $categories limits the tabs (null = all). --}}
@php
    $menu = $site->menu();
    if (isset($categories)) {
        $menu = array_intersect_key($menu, array_flip($categories));
    }
@endphp

@push('styles')
    .menu-layout { display: grid; grid-template-columns: 1fr 350px; gap: 30px; align-items: start; }
    .tabs { display: inline-flex; gap: 4px; margin-bottom: 24px; flex-wrap: wrap; padding: 5px; border: 1px solid var(--line); border-radius: var(--pill); }
    .tab { padding: 10px 22px; border-radius: var(--pill); border: 0; background: transparent; font: inherit; font-weight: 600; cursor: pointer; color: var(--navy); transition: background .2s, color .2s; }
    .tab:hover { background: var(--navy-50); }
    .tab[aria-selected="true"] { background: var(--navy); color: #fff; }
    .dishes { display: grid; gap: 14px; }
    .dish { display: grid; grid-template-columns: 104px 1fr auto; gap: 18px; align-items: center; padding: 12px 18px 12px 12px; border: 1px solid var(--line); border-radius: var(--radius-lg); background: #fff; transition: border-color .25s, box-shadow .25s, transform .25s var(--ease); }
    .dish:hover { border-color: var(--orange-100); box-shadow: var(--shadow); transform: translateY(-2px); }
    .dish-emoji { width: 104px; height: 84px; border-radius: var(--radius); background: var(--orange-50); display: grid; place-items: center; font-size: 2.2rem; overflow: hidden; }
    .dish-emoji img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
    .dish:hover .dish-emoji img { transform: scale(1.08); }
    @media (max-width: 480px) { .dish { grid-template-columns: 72px 1fr; } .dish > div:last-child { grid-column: 1 / -1; display: flex; justify-content: space-between; align-items: center; } .dish-emoji { width: 72px; height: 64px; } .qty { margin-top: 0; } }
    .dish h3 { font-family: Inter, sans-serif; font-size: 1rem; margin: 0; color: var(--ink); }
    .dish p { margin: 2px 0 0; font-size: .85rem; color: var(--muted); }
    .dish-price { font-weight: 700; color: var(--navy); font-size: .95rem; text-align: right; }
    .qty { display: flex; align-items: center; gap: 8px; margin-top: 6px; justify-content: flex-end; }
    .qty button { width: 34px; height: 34px; border-radius: 50%; border: 0; transition: background .2s, transform .15s; background: var(--orange); color: #fff; font-size: 1.1rem; font-weight: 700; cursor: pointer; }
    .qty button:hover { background: var(--orange-hover); } .qty button:active { transform: scale(.9); }
    .qty button.minus { background: var(--navy-50); color: var(--navy); border: 1px solid var(--line); }
    .qty output { min-width: 18px; text-align: center; font-weight: 700; color: var(--ink); }
    .basket { position: sticky; top: 100px; background: #fff; border: 1px solid var(--line); border-radius: var(--radius-lg); padding: 28px; box-shadow: var(--shadow-lg); }
    .basket-lines { list-style: none; margin: 0 0 16px; padding: 0; font-size: .9rem; max-height: 240px; overflow: auto; }
    .basket-lines li { display: flex; justify-content: space-between; gap: 10px; padding: 7px 0; border-bottom: 1px dashed var(--line); }
    .basket-total { display: flex; justify-content: space-between; font-family: var(--heading); font-weight: 700; font-size: 1.15rem; color: var(--navy); margin: 10px 0 18px; padding-top: 10px; border-top: 1px solid var(--line); }
    .basket .input { margin-bottom: 10px; }
    @media (max-width: 900px) { .menu-layout { grid-template-columns: 1fr; } .basket { position: static; } }
@endpush

<div class="menu-layout" data-menu-order>
    <div>
        <div class="tabs" role="tablist">
            @foreach (array_keys($menu) as $index => $category)
                <button class="tab" role="tab" type="button" aria-selected="{{ $index === 0 ? 'true' : 'false' }}" data-tab="cat-{{ $index }}">{{ $category }}</button>
            @endforeach
        </div>
        @foreach (array_values($menu) as $index => $dishes)
            <div class="dishes" id="cat-{{ $index }}" role="tabpanel" @if ($index > 0) hidden @endif>
                @foreach ($dishes as $dish)
                    <div class="dish" data-name="{{ $dish['name'] }}" data-price="{{ $dish['price'] }}">
                        <div class="dish-emoji" aria-hidden="true">@isset($dish['image'])<img src="{{ $site->photo($dish['image']) }}" alt="" loading="lazy">@else{{ $dish['emoji'] }}@endisset</div>
                        <div><h3>{{ $dish['name'] }}</h3><p>{{ $dish['desc'] }}</p></div>
                        <div>
                            <div class="dish-price">{{ $site->money($dish['price']) }}</div>
                            <div class="qty">
                                <button type="button" class="minus" aria-label="Retirer {{ $dish['name'] }}">−</button>
                                <output>0</output>
                                <button type="button" class="plus" aria-label="Ajouter {{ $dish['name'] }}">+</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <aside class="basket" aria-live="polite">
        <h3>🧺 Ma commande</h3>
        <ul class="basket-lines" data-lines></ul>
        <p class="muted small" data-empty>Ajoutez des plats avec le bouton « + ».</p>
        <div class="basket-total"><span>Total</span><span data-total>0 FCFA</span></div>
        <input class="input" type="text" data-customer placeholder="Votre nom" autocomplete="name">
        <select class="input" data-zone>
            <option value="">Retrait sur place (gratuit)</option>
            @foreach ($site->deliveryZones() as $zone)
                <option value="{{ $zone['fee'] }}" data-area="{{ $zone['area'] }}">Livraison {{ $zone['area'] }} (+{{ $site->money($zone['fee']) }})</option>
            @endforeach
        </select>
        <button class="btn btn-primary btn-block" type="button" data-send disabled>
            <svg class="wa-ico"><use href="#wa"/></svg>Commander sur WhatsApp
        </button>
        <p class="muted small center mt-1" style="margin-bottom: 0;">Paiement à la livraison, Wave ou Mobile Money</p>
    </aside>
</div>

@push('scripts')
    <script>
        document.querySelectorAll('[data-menu-order]').forEach((root) => {
            const basket = new Map();
            const zone = root.querySelector('[data-zone]');
            const deliveryFee = () => Number(zone.value || 0);

            root.querySelectorAll('.tab').forEach((tab) => tab.addEventListener('click', () => {
                root.querySelectorAll('.tab').forEach((other) => other.setAttribute('aria-selected', other === tab));
                root.querySelectorAll('.dishes').forEach((panel) => { panel.hidden = panel.id !== tab.dataset.tab; });
            }));

            const render = () => {
                const lines = root.querySelector('[data-lines]');
                lines.innerHTML = '';
                let total = 0;
                basket.forEach(({ price, quantity }, name) => {
                    total += price * quantity;
                    const line = document.createElement('li');
                    line.innerHTML = '<span></span><span></span>';
                    line.children[0].textContent = quantity + ' × ' + name;
                    line.children[1].textContent = AIC.money(price * quantity);
                    lines.append(line);
                });
                if (basket.size && deliveryFee()) {
                    total += deliveryFee();
                    const line = document.createElement('li');
                    line.innerHTML = '<span>Livraison</span><span></span>';
                    line.children[1].textContent = AIC.money(deliveryFee());
                    lines.append(line);
                }
                root.querySelector('[data-empty]').hidden = basket.size > 0;
                root.querySelector('[data-total]').textContent = AIC.money(total);
                root.querySelector('[data-send]').disabled = basket.size === 0;
                return total;
            };

            root.querySelectorAll('.dish').forEach((dish) => {
                const change = (step) => {
                    const name = dish.dataset.name;
                    const quantity = Math.max(0, (basket.get(name)?.quantity ?? 0) + step);
                    quantity ? basket.set(name, { price: Number(dish.dataset.price), quantity }) : basket.delete(name);
                    dish.querySelector('output').textContent = quantity;
                    render();
                };
                dish.querySelector('.plus').addEventListener('click', () => change(1));
                dish.querySelector('.minus').addEventListener('click', () => change(-1));
            });
            zone.addEventListener('change', render);

            root.querySelector('[data-send]').addEventListener('click', () => {
                const total = render();
                const customer = root.querySelector('[data-customer]').value.trim();
                const area = zone.selectedOptions[0].dataset.area;
                const lines = [...basket].map(([dish, { price, quantity }]) => '• ' + quantity + ' × ' + dish + ' : ' + AIC.money(price * quantity));
                AIC.send(['Bonjour, je souhaite commander :', ...lines, '', area ? 'Livraison : ' + area : 'Retrait sur place', 'Total : ' + AIC.money(total)]
                    .concat(customer ? ['Nom : ' + customer] : []).join('\n'));
            });
        });
    </script>
@endpush
