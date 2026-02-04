<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Solana Program Builder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Inter, system-ui, -apple-system, sans-serif;
            background: radial-gradient(
                1000px 500px at top,
                rgba(153,69,255,0.15),
                #0b0f1a
            );
            color: #e5e7eb;
        }

        /* ---------- HEADER ---------- */

        header {
            padding: 24px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-weight: 700;
            letter-spacing: 0.5px;
            font-size: 18px;
        }

        .logo span {
            background: linear-gradient(90deg, #9945FF, #14F195);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ---------- BADGE ---------- */

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            background: linear-gradient(
                90deg,
                rgba(153,69,255,0.15),
                rgba(20,241,149,0.15)
            );
            border: 1px solid rgba(153,69,255,0.35);
            color: #e5e7eb;
            backdrop-filter: blur(6px);
        }

        .badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: linear-gradient(90deg, #9945FF, #14F195);
            box-shadow: 0 0 8px rgba(20,241,149,0.8);
        }

        .badge span {
            background: linear-gradient(90deg, #9945FF, #14F195);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ---------- HERO ---------- */

        .hero {
            max-width: 1100px;
            margin: 0 auto;
            padding: 80px 24px 100px;
            text-align: center;
        }

        .hero h1 {
            font-size: 42px;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .hero h1 span {
            background: linear-gradient(90deg, #9945FF, #14F195);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 18px;
            color: #9ca3af;
            max-width: 700px;
            margin: 0 auto 40px;
        }

        .cta {
            display: inline-flex;
            gap: 16px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn-primary {
            padding: 14px 24px;
            font-size: 16px;
            border-radius: 10px;
            background: linear-gradient(90deg, #9945FF, #14F195);
            color: #020617;
            font-weight: 600;
            text-decoration: none;
            border: none;
        }

        .btn-secondary {
            padding: 14px 24px;
            font-size: 16px;
            border-radius: 10px;
            border: 1px solid #374151;
            color: #e5e7eb;
            text-decoration: none;
            background: transparent;
        }

        /* ---------- FEATURES ---------- */

        .features {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px 80px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
        }

        .card {
            background: #111827;
            border: 1px solid #1f2937;
            border-radius: 14px;
            padding: 24px;
        }

        .card h3 {
            margin-top: 0;
            margin-bottom: 8px;
            font-size: 18px;
        }

        .card p {
            margin: 0;
            font-size: 14px;
            color: #9ca3af;
        }

        /* ---------- BUILDER ---------- */

        .builder {
            max-width: 420px;
            margin: 0 auto 100px;
            padding: 24px;
            background: #020617;
            border-radius: 16px;
            border: 1px solid #1f2937;
        }

        .builder h2 {
            text-align: center;
            margin-top: 0;
        }

        select,
        button {
            width: 100%;
            margin-top: 16px;
            padding: 12px;
            border-radius: 10px;
            border: none;
            font-size: 14px;
        }

        select {
            background: #020617;
            color: #e5e7eb;
            border: 1px solid #334155;
        }

        button {
            background: linear-gradient(90deg, #9945FF, #14F195);
            color: #020617;
            font-weight: 600;
            cursor: pointer;
        }

        /* ---------- FOOTER ---------- */

        footer {
            padding: 32px;
            text-align: center;
            font-size: 13px;
            color: #6b7280;
        }

        /* ---------- NAV DROPDOWN ---------- */

        nav {
            position: relative;
        }

        .nav-toggle {
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #9ca3af;
        }

        .nav-toggle:hover {
            color: #14F195;
        }

        .nav-menu {
            position: absolute;
            right: 0;
            top: 36px;
            min-width: 160px;
            background: #020617;
            border: 1px solid #1f2937;
            border-radius: 12px;
            padding: 8px 0;
            opacity: 0;
            pointer-events: none;
            transform: translateY(8px);
            transition: all 0.2s ease;
        }

        .nav-menu a {
            display: block;
            padding: 10px 16px;
            font-size: 14px;
            color: #e5e7eb;
            text-decoration: none;
        }

        .nav-menu a:hover {
            background: rgba(20,241,149,0.08);
            color: #14F195;
        }

        nav:hover .nav-menu {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }
    </style>
</head>

<body>

<header>
    <div class="logo">Solana<span>Builder</span></div>

    <nav>
        <span class="nav-toggle">Menu ▾</span>
        <div class="nav-menu">
            <a href="/public/index.php">Home</a>
            <a href="/public/docs.php">Documentation</a>
        </div>
    </nav>
</header>

<section class="hero">
    <div style="margin-bottom: 24px;">
        <div class="badge">
            <div class="badge-dot"></div>
            Built for <span>Solana Nigeria</span>
        </div>
    </div>

    <h1>
        Build Solana Programs<br>
        <span>Without Writing Rust</span>
    </h1>

    <p>
        A beginner-friendly program generator that lets developers
        scaffold production-ready Solana smart contracts using
        open-source Anchor templates.
    </p>

    <div class="cta">
        <a href="#builder" class="btn-primary">Generate Program</a>
        <a href="#features" class="btn-secondary">How it works</a>
    </div>
</section>

<section id="features" class="features">
    <div class="card">
        <h3>⚡ No Rust Required</h3>
        <p>Generate Anchor-compatible programs without touching Rust or CLI tools.</p>
    </div>

    <div class="card">
        <h3>🔓 Open Source</h3>
        <p>All templates are auditable, forkable, and community-driven.</p>
    </div>

    <div class="card">
        <h3>🌍 Built for Emerging Markets</h3>
        <p>Runs on low-resource environments.</p>
    </div>

    <div class="card">
        <h3>🧩 Modular Templates</h3>
        <p>Escrow, Vault, Multisig, Subscription — with more coming soon.</p>
    </div>
</section>

<section id="builder" class="builder">
    <h2>Generate a Program</h2>

    <form method="POST" action="generate.php">
        <select name="template" required>
            <option value="">Select template</option>
            <option value="escrow">Escrow</option>
            <option value="staking">Staking</option>
            <option value="reward_distributor">Reward_distributor</option>
            <option value="device_registry">Device_registry</option>
            <option value="vault">Vault</option>
            <option value="multisig">Multisig</option>
            <option value="subscription">Subscription</option>
        </select>

        <button type="submit">Generate</button>
    </form>
</section>

<footer>
    Built for <strong>Solana Nigeria</strong> • Developer tooling • Open source
</footer>

</body>
</html>