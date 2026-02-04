<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Documentation | Solana Anchor Templates</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="stylesheet" href="/assets/css/style.css" />

  <style>
  :root {
    --solana-green: #14F195;
    --solana-purple: #9945FF;
    --solana-blue: #00C2FF;
    --bg-dark: #020617;
    --border-dark: #1f2937;
    --text-main: #e5e7eb;
    --text-muted: #9ca3af;
  }

  body {
    margin: 0;
    background: var(--bg-dark);
    color: var(--text-main);
    font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* ================= HERO ================= */
  .hero {
    padding: 140px 24px 96px;
    background: linear-gradient(
      180deg,
      #020617 0%,
      #050b1d 45%,
      #0b0f1a 100%
    );
    position: relative;
    overflow: hidden;
  }

  .hero::after {
    content: "";
    position: absolute;
    inset: 0;
    background: radial-gradient(
      circle at top,
      rgba(153, 69, 255, 0.25),
      transparent 60%
    );
    pointer-events: none;
  }

  .hero-inner {
    position: relative;
    max-width: 960px;
    margin: 0 auto;
  }

  .hero h1 {
    font-size: 40px;
    font-weight: 800;
    margin: 0;
    background: linear-gradient(
      90deg,
      var(--solana-green),
      var(--solana-blue),
      var(--solana-purple)
    );
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .hero p {
    margin-top: 18px;
    font-size: 18px;
    max-width: 760px;
    color: #cbd5f5;
  }

  /* ================= CONTENT ================= */
  .container {
    max-width: 960px;
    margin: 0 auto;
    padding: 72px 24px;
  }

  h2 {
    margin-top: 72px;
    font-size: 24px;
    color: var(--solana-green);
    border-bottom: 1px solid var(--border-dark);
    padding-bottom: 8px;
  }

  h3 {
    margin-top: 32px;
    font-size: 18px;
    color: var(--solana-blue);
  }

  p, li {
    line-height: 1.8;
    color: var(--text-muted);
  }

  strong {
    color: var(--text-main);
  }

  code {
    background: #020617;
    padding: 4px 8px;
    border-radius: 6px;
    color: var(--solana-green);
    border: 1px solid var(--border-dark);
  }

  pre {
    background: #020617;
    padding: 18px;
    border-radius: 12px;
    border: 1px solid var(--border-dark);
    overflow-x: auto;
    color: #c7d2fe;
  }

  /* ================= TOC ================= */
  .toc {
    background: linear-gradient(
      135deg,
      rgba(20, 241, 149, 0.08),
      rgba(153, 69, 255, 0.08)
    );
    border: 1px solid var(--border-dark);
    border-radius: 16px;
    padding: 24px;
    margin: 56px 0;
  }

  .toc strong {
    color: var(--solana-green);
    display: block;
    margin-bottom: 12px;
  }

  .toc a {
    display: block;
    margin: 8px 0;
    color: var(--solana-blue);
    text-decoration: none;
  }

  .toc a:hover {
    color: var(--solana-green);
    transform: translateX(4px);
    transition: all 0.2s ease;
  }

  ul {
    padding-left: 20px;
  }

  li::marker {
    color: var(--solana-purple);
  }
  </style>
</head>

<body>

<?php include __DIR__ . '/partials/nav.php'; ?>

<!-- ================= HERO ================= -->
<section class="hero">
  <div class="hero-inner">
    <h1>Solana Anchor Templates — Documentation</h1>
    <p>
      A collection of <strong>production-ready Anchor program templates</strong>
      covering DeFi, DAO, and DePIN primitives — enabling teams to launch
      secure Solana programs in <strong>days instead of weeks</strong>.
    </p>
  </div>
</section>

<div class="container">

  <!-- ================= TOC ================= -->
  <div class="toc">
    <strong>Contents</strong>
    <a href="#overview">Overview</a>
    <a href="#architecture">Architecture</a>
    <a href="#getting-started">Getting Started</a>
    <a href="#templates">Available Templates</a>
    <a href="#staking">Staking Template</a>
    <a href="#reward-distributor">Reward Distributor</a>
    <a href="#device-registry">Device Registry (DePIN)</a>
    <a href="#security">Security Model</a>
    <a href="#customization">Customization</a>
    <a href="#roadmap">Roadmap</a>
  </div>

  <!-- ================= OVERVIEW ================= -->
  <section id="overview">
    <h2>Overview</h2>
    <ul>
      <li>Token staking</li>
      <li>Reward distribution</li>
      <li>Vaults & escrow</li>
      <li>Multisig governance</li>
      <li>DePIN device registries</li>
    </ul>
  </section>

  <!-- ================= ARCHITECTURE ================= -->
  <section id="architecture">
    <h2>Architecture</h2>
    <pre>
templates/
 └─ &lt;template_name&gt;/
    └─ anchor/
       ├─ Anchor.toml
       ├─ Cargo.toml
       ├─ programs/
       │  └─ &lt;program_name&gt;/
       │     └─ src/
       │        ├─ lib.rs
       │        ├─ errors.rs
       │        ├─ state/
       │        └─ instructions/
       └─ tests/
    </pre>
  </section>

  <!-- ================= GETTING STARTED ================= -->
  <section id="getting-started">
    <h2>Getting Started</h2>
    <pre>
anchor build
anchor test
anchor deploy
    </pre>
  </section>

  <!-- ================= TEMPLATES ================= -->
  <section id="templates">
    <h2>Available Templates</h2>
    <ul>
      <li><strong>Staking</strong> – Token staking with lockups</li>
      <li><strong>Reward Distributor</strong> – Generic reward engine</li>
      <li><strong>Vault</strong> – Program-owned token vaults</li>
      <li><strong>Escrow</strong> – Trust-minimized exchange</li>
      <li><strong>Multisig</strong> – DAO-style governance</li>
      <li><strong>Device Registry</strong> – DePIN identity layer</li>
    </ul>
  </section>

  <!-- ================= SECURITY ================= -->
  <section id="security">
    <h2>Security Model</h2>
    <ul>
      <li>PDA-only program authority (no private keys)</li>
      <li>Strict account constraints in all instructions</li>
      <li>No unchecked signer assumptions</li>
      <li>Explicit ownership & mint verification</li>
      <li>Custom error codes for all failure states</li>
    </ul>
    <p>
      Templates are designed to be <strong>audit-friendly</strong> and
      minimize common Anchor and Solana security footguns.
    </p>
  </section>

  <!-- ================= CUSTOMIZATION ================= -->
  <section id="customization">
    <h2>Customization</h2>
    <p>Teams can easily:</p>
    <ul>
      <li>Add new instructions and account types</li>
      <li>Modify reward logic and emission schedules</li>
      <li>Integrate with custom frontends or indexers</li>
      <li>Compose multiple templates together</li>
    </ul>
    <p>
      Templates are intentionally opinionated for safety,
      while remaining flexible for production use.
    </p>
  </section>

  <!-- ================= ROADMAP ================= -->
  <section id="roadmap">
    <h2>Roadmap</h2>
    <ul>
      <li>V2: More DeFi & DePIN templates</li>
      <li>V2: Improved test coverage</li>
      <li>V2: Frontend starter kits</li>
      <li>V3: CLI generator</li>
      <li>V3: Security review & audits</li>
    </ul>
  </section>

</div>

</body>
</html>