@extends('site.layouts.base')

@php
    $sections = ['gerant' => ['📊', 'Tableau de bord'], 'gerant/caisse' => ['💰', 'Caisse'], 'gerant/stock' => ['📦', 'Stock'], 'gerant/clients' => ['👥', 'Élèves & clients']];
@endphp

@push('styles')
    body { background: var(--alt); }
    .app { display: grid; grid-template-columns: 250px 1fr; min-height: calc(100vh - 36px); }
    .sidebar { background: var(--navy); color: #c9d3e2; padding: 22px 16px; display: flex; flex-direction: column; gap: 6px; border-right: 3px solid var(--gold); }
    .sidebar .brand { display: flex; align-items: center; gap: 10px; color: #fff; font-family: var(--heading); font-weight: 700; margin-bottom: 22px; font-size: .9rem; line-height: 1.2; }
    .sidebar .brand span:first-child { width: 38px; height: 38px; border-radius: var(--radius-sm); background: var(--orange); display: grid; place-items: center; font-size: .8rem; flex: none; }
    .sidebar .brand small { display: block; color: #9fb0c8; font-weight: 500; }
    .sidebar a.item { display: flex; gap: 12px; align-items: center; padding: 11px 14px; border-radius: var(--radius-sm); font-weight: 600; font-size: .93rem; }
    .sidebar a.item:hover { background: var(--navy-800); color: #fff; }
    .sidebar a.item[aria-current="page"] { background: var(--orange); color: #fff; }
    .sidebar .back { margin-top: auto; font-size: .85rem; color: #9fb0c8; padding: 10px 14px; }
    .sidebar .back:hover { color: var(--orange-on-dark); }
    .app-main { padding: 28px 32px 40px; min-width: 0; }
    .app-top { display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; margin-bottom: 24px; }
    .app-top h1 { font-size: 1.6rem; margin: 0; }
    .app-top .who { display: flex; align-items: center; gap: 10px; font-size: .88rem; }
    .panel { background: #fff; border: 1px solid var(--line); border-radius: var(--radius); padding: 20px; box-shadow: var(--shadow-sm); }
    .panel h2 { font-size: 1.05rem; margin-bottom: 14px; }
    .kpis { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 20px; }
    .kpi { background: #fff; border: 1px solid var(--line); border-radius: var(--radius); padding: 18px; }
    .kpi span { font-size: .8rem; color: var(--muted); font-weight: 600; }
    .kpi b { display: block; font-family: var(--heading); font-size: 1.45rem; color: var(--navy); margin: 4px 0; }
    .kpi.dark { background: var(--navy); border-color: var(--navy); border-bottom: 3px solid var(--gold); }
    .kpi.dark span { color: #9fb0c8; } .kpi.dark b { color: #fff; }
    .up { color: var(--success); font-size: .8rem; font-weight: 600; } .kpi.dark .up { color: #7fd6a4; }
    .search { max-width: 280px; }
    .app-tabs { display: none; }
    @media (max-width: 1000px) { .kpis { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 760px) {
        .app { grid-template-columns: 1fr; }
        .sidebar { display: none; }
        .app-main { padding: 20px 16px 96px; }
        .app-tabs { display: grid; grid-template-columns: repeat(4, 1fr); position: fixed; inset: auto 0 0 0; z-index: 60; background: var(--navy); padding: 8px 6px calc(8px + env(safe-area-inset-bottom)); border-top: 3px solid var(--gold); }
        .app-tabs a { display: grid; justify-items: center; gap: 2px; font-size: .68rem; font-weight: 600; color: #c9d3e2; padding: 4px; border-radius: var(--radius-sm); }
        .app-tabs a span { font-size: 1.2rem; }
        .app-tabs a[aria-current="page"] { color: #fff; background: var(--orange); }
    }
@endpush

@section('body')
    <div class="app">
        <aside class="sidebar">
            <div class="brand"><span>{{ $business['short'] }}</span><span>Espace gérant<small>Atelier Ivoirien Des Cuisiniers</small></span></div>
            @foreach ($sections as $slug => [$icon, $label])
                <a class="item" href="{{ $site->url($slug) }}" @if ($currentPage === $slug) aria-current="page" @endif><span>{{ $icon }}</span>{{ $label }}</a>
            @endforeach
            <a class="back" href="{{ $site->url() }}">← Voir le site public</a>
        </aside>

        <div class="app-main">
            <div class="app-top">
                <div>
                    <span class="muted small">{{ ucfirst(now()->locale('fr')->isoFormat('dddd D MMMM YYYY')) }}</span>
                    <h1>{{ $pageTitle }}</h1>
                </div>
                <div class="who">
                    @yield('top_actions')
                    <span class="avatar">A</span><span><b style="color: var(--ink)">Chef Adjoua</b><span class="muted" style="display: block; font-size: .78rem;">Gérante</span></span>
                </div>
            </div>
            @yield('content')
        </div>
    </div>

    <nav class="app-tabs" aria-label="Espace gérant">
        @foreach ($sections as $slug => [$icon, $label])
            <a href="{{ $site->url($slug) }}" @if ($currentPage === $slug) aria-current="page" @endif><span>{{ $icon }}</span>{{ \Illuminate\Support\Str::before($label, ' &') }}</a>
        @endforeach
    </nav>
@endsection
