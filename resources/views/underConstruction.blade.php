<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>PrintShopEld — Coming soon</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    <style>
        :root { --bg:#09090d; --panel:#181820; --border:#302b3b; --brand:#8b5cf6; --brand2:#a78bfa; --text:#f5f3fa; --muted:#a5a1b2; }
        * { box-sizing:border-box; margin:0; }
        body { min-height:100vh; display:flex; align-items:center; justify-content:center; background:radial-gradient(ellipse at 60% 30%, #1b1430 0%, var(--bg) 60%); color:var(--text); font-family:'Manrope',sans-serif; text-align:center; padding:2rem; }
        .card { max-width:520px; }
        img { height:64px; margin-bottom:1.5rem; opacity:.95; }
        .eyebrow { font-size:.7rem; letter-spacing:.3em; text-transform:uppercase; color:var(--brand2); font-weight:800; }
        h1 { font-family:'Playfair Display',serif; font-weight:600; font-size:clamp(2.2rem,6vw,3.4rem); line-height:1.1; margin:.8rem 0 1rem; }
        h1 em { font-style:italic; color:var(--brand2); }
        p { color:var(--muted); line-height:1.7; }
        .bar { width:120px; height:2px; background:linear-gradient(90deg,transparent,var(--brand),transparent); margin:1.5rem auto 0; animation:slide 2.4s infinite; }
        @keyframes slide { 0%{opacity:.2} 50%{opacity:1} 100%{opacity:.2} }
        a { display:inline-block; margin-top:1.6rem; color:var(--brand2); text-decoration:none; border:1px solid var(--border); border-radius:12px; padding:.7rem 1.4rem; font-weight:700; }
        a:hover { border-color:var(--brand2); }
        @media (prefers-reduced-motion:reduce){ .bar{animation:none} }
    </style>
</head>

<body>
    <main class="card">
        <img src="{{ asset('assets/img/logo.png') }}" alt="PrintShopEld">
        <span class="eyebrow">Coming soon</span>
        <h1>Something <em>beautiful</em> is printing.</h1>
        <p>We're putting the finishing touches on a new PrintShopEld experience. Meanwhile, browse the catalog or reach us on WhatsApp.</p>
        <a href="{{ url('/contacts') }}">Contact the studio</a>
        <div class="bar"></div>
    </main>
</body>

</html>
