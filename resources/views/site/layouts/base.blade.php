{{-- Mock-up for "Atelier Ivoirien Des Cuisiniers". Self-contained (no theme, no Vite build), styled after the
     KOVA MARKET charter (public/assets/css/kova.css): night blue structure, orange as the only accent, gold rare,
     plain colours, white and #F4F6FA surfaces. --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $pageTitle }} – {{ $business['name'] }} (maquette)</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="theme-color" content="#021732">
    <script>document.documentElement.classList.add('js');</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap">
    <style>
        :root {
            --navy: #021732; --navy-800: #0a2448; --navy-700: #1b3560; --navy-100: #e8edf5; --navy-50: #f2f5fa;
            --orange: #cc4400; --orange-hover: #b83a00; --orange-text: #a33400; --orange-on-dark: #ff6a1a; --orange-bright: #f85000;
            --orange-100: #ffe8da; --orange-50: #fff4ec; --gold: #c69e3e; --gold-100: #f8f0dc;
            --ink: #0f1d33; --body: #3f4a5a; --muted: #667085; --line: #e3e8ef; --line-strong: #cfd6e0; --alt: #fff;
            --success: #0e7d42; --success-bg: #e5f3eb; --danger: #c0362c; --danger-bg: #fdeceb; --warning: #a86b12; --warning-bg: #fdf3e2;
            --wa: #25d366; --radius: 16px; --radius-sm: 10px; --radius-lg: 24px; --radius-xl: 32px; --pill: 999px;
            --shadow-sm: 0 1px 2px rgb(2 23 50 / .05);
            --shadow: 0 1px 2px rgb(2 23 50 / .04), 0 10px 30px -8px rgb(2 23 50 / .10);
            --shadow-lg: 0 2px 6px rgb(2 23 50 / .05), 0 30px 60px -18px rgb(2 23 50 / .22);
            --ease: cubic-bezier(.2, .7, .2, 1);
            --heading: Poppins, 'Segoe UI', Arial, sans-serif;
        }
        * { box-sizing: border-box; }
        [hidden] { display: none !important; }
        html { scroll-behavior: smooth; scroll-padding-top: 100px; }
        body { margin: 0; font-family: Inter, 'Segoe UI', Arial, sans-serif; color: var(--body); background: #fff; line-height: 1.65; -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility; }
        ::selection { background: var(--orange-100); color: var(--navy); }
        img { max-width: 100%; }
        a { color: inherit; text-decoration: none; }
        :focus-visible { outline: none; box-shadow: 0 0 0 3px rgb(204 68 0 / .28); border-radius: var(--radius-sm); }
        h1, h2, h3, h4 { font-family: var(--heading); font-weight: 700; line-height: 1.15; margin: 0 0 .5em; color: var(--navy); }
        h1 { font-size: clamp(2.2rem, 5.6vw, 4rem); letter-spacing: -.03em; line-height: 1.05; }
        h2 { font-size: clamp(1.75rem, 3.6vw, 2.6rem); letter-spacing: -.025em; }
        h3 { font-size: 1.15rem; letter-spacing: -.01em; font-weight: 600; }
        p { margin: 0 0 1em; }
        .wrap { width: min(1200px, 100% - 40px); margin-inline: auto; }
        .narrow { width: min(820px, 100% - 40px); margin-inline: auto; }
        .section { padding: 104px 0; }
        .section-alt { background: var(--alt); }
        .section-tight { padding: 64px 0; }
        .eyebrow { display: inline-flex; align-items: center; gap: 8px; font-size: .74rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--orange-text); background: var(--orange-50); border: 1px solid var(--orange-100); padding: 6px 12px; border-radius: var(--pill); margin-bottom: 16px; }
        .eyebrow::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: var(--orange); }
        .lead { font-size: 1.12rem; color: var(--muted); max-width: 640px; }
        .center { text-align: center; } .center .lead { margin-inline: auto; }
        .muted { color: var(--muted); } .small { font-size: .85rem; }
        .mt-1 { margin-top: 12px; } .mt-2 { margin-top: 24px; } .mt-3 { margin-top: 44px; }
        .link { color: var(--orange-text); font-weight: 600; } .link:hover { text-decoration: underline; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 10px; padding: 14px 26px; border-radius: var(--pill); border: 1.5px solid transparent; cursor: pointer; font: inherit; font-weight: 600; line-height: 1.2; transition: background .2s, color .2s, border-color .2s, transform .2s var(--ease), box-shadow .2s; }
        .btn:hover { transform: translateY(-2px); }
        .btn:active { transform: translateY(0); }
        .btn-primary { background: var(--orange); color: #fff; box-shadow: 0 8px 20px -6px rgb(204 68 0 / .45); }
        .btn-primary:hover { background: var(--orange-hover); box-shadow: 0 12px 26px -8px rgb(204 68 0 / .55); }
        .btn-ghost { border-color: var(--line-strong); color: var(--navy); background: #fff; }
        .btn-ghost:hover { border-color: var(--navy); background: var(--navy); color: #fff; }
        .btn-navy { background: var(--navy); color: #fff; } .btn-navy:hover { background: var(--navy-800); }
        .btn-sm { padding: 10px 18px; font-size: .9rem; }
        .btn-block { width: 100%; }
        .btn[disabled] { opacity: .5; cursor: not-allowed; }
        .wa-ico { width: 20px; height: 20px; flex: none; }

        /* Small pieces */
        .tag { display: inline-block; background: var(--navy-50); color: var(--navy); font-size: .75rem; font-weight: 600; padding: 5px 11px; border-radius: var(--pill); }
        .tag-orange { background: var(--orange-50); color: var(--orange-text); }
        .tag-gold { background: var(--gold-100); color: #8a6a1f; }
        .tag-success { background: var(--success-bg); color: var(--success); }
        .tag-danger { background: var(--danger-bg); color: var(--danger); }
        .tag-warning { background: var(--warning-bg); color: var(--warning); }
        .tags { display: flex; gap: 8px; flex-wrap: wrap; }
        .stars { color: var(--gold); letter-spacing: 2px; }
        .grid { display: grid; gap: 24px; }
        .grid-2 { grid-template-columns: repeat(auto-fit, minmax(min(320px, 100%), 1fr)); }
        .grid-3 { grid-template-columns: repeat(auto-fit, minmax(min(320px, 100%), 1fr)); }
        .grid-4 { grid-template-columns: repeat(auto-fit, minmax(min(240px, 100%), 1fr)); }
        .card { background: #fff; border: 1px solid var(--line); border-radius: var(--radius-lg); padding: 26px; display: flex; flex-direction: column; box-shadow: var(--shadow-sm); transition: transform .35s var(--ease), box-shadow .35s var(--ease), border-color .35s; }
        a.card:hover, .card.hover:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); border-color: var(--orange-100); }
        .card.featured { border: 1.5px solid var(--orange); position: relative; box-shadow: 0 0 0 4px var(--orange-50), var(--shadow); }
        .card.featured::before { content: attr(data-badge); position: absolute; top: -13px; left: 22px; background: var(--gold); color: var(--navy); font-size: .72rem; font-weight: 700; padding: 4px 12px; border-radius: var(--pill); box-shadow: var(--shadow-sm); }
        .icon-box { font-size: 1.8rem; width: 56px; height: 56px; display: grid; place-items: center; background: var(--orange-50); border-radius: var(--radius); margin-bottom: 14px; flex: none; }
        .bullets { list-style: none; padding: 0; margin: 0 0 20px; color: var(--muted); font-size: .92rem; }
        .bullets li { padding: 4px 0 4px 22px; position: relative; }
        .bullets li::before { content: '✓'; position: absolute; left: 2px; color: var(--orange); font-weight: 700; }
        .price-line { margin-top: auto; font-size: .85rem; color: var(--muted); }
        .price-line b { display: block; font-family: var(--heading); font-size: 1.35rem; color: var(--navy); }
        .avatar { width: 42px; height: 42px; border-radius: 50%; background: var(--navy); display: grid; place-items: center; font-weight: 700; color: #fff; flex: none; }
        details.faq { background: #fff; border: 1px solid var(--line); border-radius: var(--radius); padding: 18px 22px; margin-bottom: 12px; transition: border-color .2s, box-shadow .2s; }
        details.faq:hover { border-color: var(--line-strong); }
        details.faq[open] { border-color: var(--orange-100); box-shadow: var(--shadow); }
        details.faq summary { cursor: pointer; font-weight: 600; color: var(--ink); list-style: none; display: flex; justify-content: space-between; align-items: center; gap: 10px; }
        details.faq summary::-webkit-details-marker { display: none; }
        details.faq summary::after { content: '+'; flex: none; width: 28px; height: 28px; border-radius: 50%; display: grid; place-items: center; background: var(--orange-50); color: var(--orange-text); font-size: 1.2rem; line-height: 1; transition: transform .3s var(--ease); }
        details.faq[open] summary::after { transform: rotate(45deg); }
        details.faq p { margin: 10px 0 0; color: var(--muted); }

        /* Forms */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-grid .full { grid-column: 1 / -1; }
        @media (max-width: 640px) { .form-grid { grid-template-columns: 1fr; } }
        label.field { display: grid; gap: 6px; font-size: .88rem; font-weight: 600; color: var(--ink); }
        .input { width: 100%; padding: 13px 16px; border-radius: var(--radius-sm); border: 1px solid var(--line-strong); font: inherit; font-weight: 400; color: var(--ink); background: #fff; transition: border-color .2s, box-shadow .2s; }
        .input:hover { border-color: var(--muted); }
        .input:focus { outline: none; border-color: var(--orange); box-shadow: 0 0 0 3px rgb(204 68 0 / .28); }
        textarea.input { min-height: 110px; resize: vertical; }
        .choices { display: flex; flex-wrap: wrap; gap: 10px; }
        .choice input { position: absolute; opacity: 0; pointer-events: none; }
        .choice span { display: inline-block; padding: 10px 18px; border: 1px solid var(--line-strong); border-radius: var(--pill); cursor: pointer; font-weight: 600; font-size: .9rem; background: #fff; transition: border-color .2s, background .2s; }
        .choice input:checked + span { border-color: var(--orange); background: var(--orange-50); color: var(--orange-text); }
        .choice input:focus-visible + span { box-shadow: 0 0 0 3px rgb(204 68 0 / .28); }

        /* Tables */
        .table-wrap { overflow-x: auto; border: 1px solid var(--line); border-radius: var(--radius); background: #fff; }
        table { width: 100%; border-collapse: collapse; font-size: .92rem; }
        th { text-align: left; font-size: .75rem; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); background: var(--alt); font-weight: 700; }
        th, td { padding: 12px 16px; border-bottom: 1px solid var(--line); white-space: nowrap; }
        tr:last-child td { border-bottom: 0; }
        td.num, th.num { text-align: right; font-variant-numeric: tabular-nums; }

        .demo-bar { background: var(--navy); color: #c9d3e2; font-size: .82rem; text-align: center; padding: 8px 16px; border-bottom: 2px solid var(--gold); }
        .demo-bar strong, .demo-bar a { color: #fff; } .demo-bar a { text-decoration: underline; }

        /* Scroll reveal (only when JS runs; off for reduced motion) */
        .js .reveal { opacity: 0; transform: translateY(24px); transition: opacity .8s var(--ease), transform .8s var(--ease); transition-delay: var(--delay, 0s); }
        .js .reveal.is-in { opacity: 1; transform: none; }
        @media (prefers-reduced-motion: reduce) { html { scroll-behavior: auto; } .js .reveal { opacity: 1; transform: none; transition: none; } .btn:hover { transform: none; } }

        @stack('styles')
    </style>
</head>
<body class="@yield('body_class')">
    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <symbol id="wa" viewBox="0 0 24 24"><path fill="currentColor" d="M17.5 14.4c-.3-.1-1.8-.9-2-1s-.5-.1-.7.1-.8 1-.9 1.2-.3.2-.6.1a8.2 8.2 0 0 1-4-3.5c-.3-.5.3-.5.9-1.6.1-.2 0-.4 0-.5l-.9-2.2c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4s-1 1-1 2.5 1.1 2.9 1.2 3.1c.1.2 2.1 3.2 5.1 4.5 1.9.8 2.6.9 3.6.7.6-.1 1.8-.7 2-1.4.3-.7.3-1.3.2-1.4l-.8-.5zM12 21.8a9.8 9.8 0 0 1-5-1.4l-.4-.2-3.7 1 1-3.6-.2-.4A9.8 9.8 0 1 1 12 21.8zm0-21.6A11.8 11.8 0 0 0 1.8 17.9L.2 23.8l6-1.6A11.8 11.8 0 1 0 12 .2z"/></symbol>
    </svg>

    <div class="demo-bar"><strong>Maquette gratuite</strong> préparée pour {{ $business['name'] }} · textes, prix, noms et avis donnés à titre d’exemple</div>

    @yield('body')

    <script>
        window.AIC = {
            whatsapp: @json($business['whatsapp']),
            money: (amount) => Math.round(amount).toLocaleString('fr-FR').replace(/ | /g, ' ') + ' FCFA',
            send: (text) => window.open('https://wa.me/' + window.AIC.whatsapp + '?text=' + encodeURIComponent(text), '_blank', 'noopener'),
        };

        // Reveal blocks as they scroll into view: section headings, then grid items one after the other.
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
                if (entry.isIntersecting) { entry.target.classList.add('is-in'); observer.unobserve(entry.target); }
            }), { rootMargin: '0px 0px -8% 0px' });
            document.querySelectorAll('main .section .wrap > :not(.grid), main .section .grid > *').forEach((element) => {
                if (element.parentElement.classList.contains('grid')) {
                    element.style.setProperty('--delay', Math.min([...element.parentElement.children].indexOf(element), 5) * 0.08 + 's');
                }
                element.classList.add('reveal');
                observer.observe(element);
            });
        } else {
            document.documentElement.classList.remove('js');
        }
    </script>
    @stack('scripts')
</body>
</html>
