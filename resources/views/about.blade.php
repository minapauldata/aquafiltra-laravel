<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AquaFiltra — About Us</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<link rel="icon" type="image/png" href="{{ asset('images/aquafiltra_logo_themed.png') }}">
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #0a0f1e;
      --surface: #0f172a;
      --surface2: #1e293b;
      --border: #1e3a5f;
      --accent: #00d4ff;
      --accent2: #00ff94;
      --accent3: #ff6b35;
      --text: #e2f0ff;
      --muted: #6b8caa;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      background: var(--bg);
      color: var(--text);
      font-family: 'Syne', sans-serif;
      min-height: 100vh;
      overflow-x: hidden;
    }

    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(rgba(0,212,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0,212,255,0.03) 1px, transparent 1px);
      background-size: 40px 40px;
      pointer-events: none;
      z-index: 0;
    }

    body::after {
      content: '';
      position: fixed;
      width: 600px; height: 600px;
      background: radial-gradient(circle, rgba(0,212,255,0.06) 0%, transparent 70%);
      top: -200px; left: -200px;
      pointer-events: none;
      z-index: 0;
    }

    /* HEADER */
    .header {
      background: rgba(15,23,42,0.9);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid var(--border);
      padding: 16px 32px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .header h1 { font-size: 20px; color: var(--accent); font-weight: 700; }

    /* FLOATING BACK BUTTON */
    .fab {
      position: fixed;
      bottom: 28px; right: 24px;
      z-index: 200;
      background: var(--accent);
      color: #070d1a;
      font-family: 'Space Mono', monospace;
      font-size: 11px;
      font-weight: 700;
      padding: 12px 20px;
      border-radius: 100px;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 4px 24px rgba(0,212,255,0.35);
      transition: transform 0.2s, box-shadow 0.2s;
      letter-spacing: 0.5px;
    }
    .fab:hover { transform: translateY(-3px); box-shadow: 0 8px 32px rgba(0,212,255,0.45); }

    /* HERO */
    .hero {
      text-align: center;
      padding: 80px 24px 60px;
      position: relative;
      z-index: 1;
    }
    .hero-badge {
      display: inline-block;
      background: rgba(0,212,255,0.1);
      border: 1px solid var(--accent);
      color: var(--accent);
      font-family: 'Space Mono', monospace;
      font-size: 11px;
      padding: 5px 16px;
      border-radius: 2px;
      letter-spacing: 3px;
      text-transform: uppercase;
      margin-bottom: 24px;
      animation: fadeUp 0.6s ease both;
    }
    .hero h2 {
      font-size: clamp(28px, 5vw, 52px);
      font-weight: 800;
      margin-bottom: 16px;
      animation: fadeUp 0.6s ease 0.1s both;
    }
    .hero h2 span { color: var(--accent); }
    .hero p {
      color: var(--muted);
      font-size: 15px;
      max-width: 520px;
      margin: 0 auto;
      line-height: 1.7;
      animation: fadeUp 0.6s ease 0.2s both;
    }

    .project-info {
      display: flex;
      justify-content: center;
      gap: 16px;
      flex-wrap: wrap;
      margin-top: 36px;
      animation: fadeUp 0.6s ease 0.3s both;
    }
    .pill {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 100px;
      padding: 8px 20px;
      font-size: 13px;
      color: var(--muted);
      font-family: 'Space Mono', monospace;
    }
    .pill span { color: var(--accent2); }

    /* CONTAINER */
    .container {
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 24px 80px;
      position: relative;
      z-index: 1;
    }

    .section-label {
      text-align: center;
      font-family: 'Space Mono', monospace;
      font-size: 11px;
      letter-spacing: 3px;
      color: var(--muted);
      text-transform: uppercase;
      margin-bottom: 48px;
    }

    /* LEADER CARD */
    .leader-wrap {
      display: flex;
      justify-content: center;
      margin-bottom: 32px;
      animation: fadeUp 0.6s ease 0.4s both;
    }
    .leader-card {
      background: var(--surface);
      border: 1px solid var(--accent);
      border-radius: 16px;
      padding: 40px 48px;
      display: flex;
      align-items: center;
      gap: 40px;
      max-width: 700px;
      width: 100%;
      position: relative;
      overflow: hidden;
      box-shadow: 0 0 40px rgba(0,212,255,0.08);
    }
    .leader-card::before {
      content: 'PROJECT LEADER';
      position: absolute;
      top: 14px; right: 20px;
      font-family: 'Space Mono', monospace;
      font-size: 9px;
      letter-spacing: 2px;
      color: var(--accent);
      opacity: 0.7;
    }
    .leader-card::after {
      content: '';
      position: absolute;
      top: -60px; right: -60px;
      width: 200px; height: 200px;
      background: radial-gradient(circle, rgba(0,212,255,0.07) 0%, transparent 70%);
      pointer-events: none;
    }

    /* MEMBER GRIDS */
    .team-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      margin-bottom: 20px;
    }
    .team-grid-bottom {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
    }
    .member-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 28px;
      display: flex;
      align-items: flex-start;
      gap: 20px;
      transition: border-color 0.3s, transform 0.3s, box-shadow 0.3s;
      animation: fadeUp 0.6s ease both;
      position: relative;
      overflow: hidden;
    }
    .member-card:hover {
      border-color: rgba(0,212,255,0.4);
      transform: translateY(-4px);
      box-shadow: 0 12px 32px rgba(0,212,255,0.06);
    }
    .member-card:nth-child(1) { animation-delay: 0.5s; }
    .member-card:nth-child(2) { animation-delay: 0.6s; }
    .member-card:nth-child(3) { animation-delay: 0.7s; }
    .member-card:nth-child(4) { animation-delay: 0.8s; }

    /* AVATAR */
    .avatar {
      width: 72px; height: 72px;
      border-radius: 12px;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      font-weight: 800;
      font-family: 'Space Mono', monospace;
    }
    .avatar.leader { width: 90px; height: 90px; font-size: 34px; border-radius: 16px; }
    .av1 { background: linear-gradient(135deg, #0d2137, #0a3d52); color: var(--accent);  border: 1px solid rgba(0,212,255,0.3); }
    .av2 { background: linear-gradient(135deg, #0d2137, #0a3d52); color: var(--accent2); border: 1px solid rgba(0,255,148,0.3); }
    .av3 { background: linear-gradient(135deg, #1a1230, #2a1a42); color: #b388ff;        border: 1px solid rgba(179,136,255,0.3); }
    .av4 { background: linear-gradient(135deg, #1a2012, #2a3a1a); color: #a8e063;        border: 1px solid rgba(168,224,99,0.3); }
    .av5 { background: linear-gradient(135deg, #2a1a0d, #3d2a0d); color: var(--accent3); border: 1px solid rgba(255,107,53,0.3); }

    /* CARD INFO */
    .card-info { flex: 1; min-width: 0; }
    .card-name { font-size: 18px; font-weight: 700; margin-bottom: 4px; color: var(--text); }
    .leader-card .card-name { font-size: 22px; }
    .card-role {
      font-family: 'Space Mono', monospace;
      font-size: 11px;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-bottom: 12px;
      padding: 3px 10px;
      border-radius: 3px;
      display: inline-block;
    }
    .role-leader    { color: var(--accent);  background: rgba(0,212,255,0.08);   border: 1px solid rgba(0,212,255,0.2); }
    .role-fullstack { color: var(--accent2); background: rgba(0,255,148,0.08);   border: 1px solid rgba(0,255,148,0.2); }
    .role-frontend  { color: #b388ff;        background: rgba(179,136,255,0.08); border: 1px solid rgba(179,136,255,0.2); }
    .role-hardware  { color: #a8e063;        background: rgba(168,224,99,0.08);  border: 1px solid rgba(168,224,99,0.2); }
    .role-docs      { color: var(--accent3); background: rgba(255,107,53,0.08);  border: 1px solid rgba(255,107,53,0.2); }

    .card-bio { font-size: 13px; color: var(--muted); line-height: 1.6; margin-bottom: 14px; }

    /* SOCIAL LINKS */
    .social-links { display: flex; gap: 8px; flex-wrap: wrap; }
    .social-link {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-family: 'Space Mono', monospace;
      font-size: 11px;
      color: var(--muted);
      text-decoration: none;
      border: 1px solid var(--border);
      border-radius: 4px;
      padding: 5px 10px;
      transition: all 0.2s;
      min-height: 30px;
      white-space: nowrap;
    }
    .social-link:hover { color: var(--accent); border-color: var(--accent); background: rgba(0,212,255,0.06); }

    /* FOOTER */
    footer {
      border-top: 1px solid var(--border);
      padding: 32px;
      text-align: center;
      color: var(--muted);
      font-size: 12px;
      font-family: 'Space Mono', monospace;
      position: relative;
      z-index: 1;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ── MOBILE RESPONSIVE ── */
    @media (max-width: 640px) {
      .header { padding: 12px 16px; }
      .header h1 { font-size: 16px; }
      .hero { padding: 40px 16px 32px; }
      .hero p { font-size: 13px; }
      .pill { font-size: 11px; padding: 6px 14px; }
      .project-info { gap: 8px; margin-top: 20px; }
      .container { padding: 0 16px 60px; }
      .section-label { margin-bottom: 28px; }
      .leader-card {
        flex-direction: column;
        align-items: flex-start;
        padding: 24px 20px;
        gap: 16px;
      }
      .leader-card::before { font-size: 8px; top: 10px; right: 12px; }
      .leader-card .card-name { font-size: 18px; }
      .team-grid,
      .team-grid-bottom { grid-template-columns: 1fr; }
      .member-card {
        flex-direction: column;
        gap: 14px;
        padding: 20px 16px;
      }
      .avatar { width: 60px; height: 60px; font-size: 22px; }
      .avatar.leader { width: 68px; height: 68px; font-size: 26px; }
      .member-card img { width: 60px !important; height: 60px !important; }
      .card-name { font-size: 16px; }
      .card-role { font-size: 10px; }
      .card-bio  { font-size: 12px; }
      .social-link { font-size: 10px; padding: 6px 9px; min-height: 34px; }
      .fab { bottom: 20px; right: 16px; padding: 10px 16px; font-size: 10px; }
    }

    @media (max-width: 380px) {
      .header h1 { font-size: 14px; }
      .hero h2   { font-size: 24px; }
      .social-link { font-size: 9px; padding: 5px 7px; }
    }
  </style>
</head>
<body>

<div class="header">
  <img src="{{ asset('images/aquafiltra_logo_themed.png') }}" style="width:32px;height:32px;object-fit:contain;"> AquaFiltra
</div>

<!-- FLOATING BACK BUTTON -->
<a id="downloadBtn" href="https://aquafiltra.up.railway.app/app-debug.apk" download class="fab" style="bottom:80px;">
  Download App
</a>
<a href="{{ url('/') }}" class="fab">← Dashboard</a>

<div class="hero">
  <div class="hero-badge">⬡ Thesis Project 2026</div>
  <h2>Meet the <span>Team</span></h2>
  <p>The brilliant minds behind AquaFiltra — a real-time water filtration monitoring system using ESP32, IoT sensors, and Laravel.</p>
  <div class="project-info">
    <div class="pill">💧 <span>Water Filtration</span> Monitor</div>
    <div class="pill">🔌 <span>ESP32</span> + IoT Sensors</div>
    <div class="pill">🖥️ <span>Laravel</span> + Real-Time Dashboard</div>
  </div>
</div>

<div class="container">
  <div class="section-label">— Our Team —</div>

  <!-- LEADER -->
  <div class="leader-wrap">
    <div class="leader-card">
      <img src="https://aquafiltra.up.railway.app/images/john_wincy.png" style="width:90px;height:90px;border-radius:16px;object-fit:cover;flex-shrink:0;border:1px solid rgba(0,212,255,0.3);">
      <div class="card-info">
        <div class="card-name">John Wincy Musa</div>
        <div class="card-role role-leader">Project Leader · 3D Designer</div>
        <div class="card-bio">
          Leads the AquaFiltra project from conception to completion, overseeing all technical and creative decisions. Also responsible for the 3D design and physical structure of the water filtration system.
        </div>
        <div class="social-links">
          <a class="social-link" href="https://www.facebook.com/Winzeeeey"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg> Facebook</a>
          <a class="social-link" href="https://github.com/Jwmusa"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg> GitHub</a>
          <a class="social-link" href="https://www.linkedin.com/in/john-wincy-musa-676bb8257/"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg> LinkedIn</a>
          <a class="social-link" href="mailto:johnwincymusa@gmail.com"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg> Email</a>
        </div>
      </div>
    </div>
  </div>

  <!-- TOP 2 MEMBERS -->
  <div class="team-grid">

    <!-- Paul -->
    <div class="member-card">
      <img src="https://aquafiltra.up.railway.app/images/paul_albert.png" style="width:72px;height:72px;border-radius:12px;object-fit:cover;flex-shrink:0;border:1px solid rgba(0,255,148,0.3);">
      <div class="card-info">
        <div class="card-name">Paul Albert Mina</div>
        <div class="card-role role-fullstack">Full Stack Engineer</div>
        <div class="card-bio">
          Architects and develops the full AquaFiltra web application — from the Laravel REST API that receives ESP32 sensor data to the real-time dashboard interface users interact with.
        </div>
        <div class="social-links">
          <a class="social-link" href="https://www.facebook.com/paul.albert.r.mina"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg> Facebook</a>
          <a class="social-link" href="https://github.com/minapauldata"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg> GitHub</a>
          <a class="social-link" href="https://www.linkedin.com/in/minapauldata/"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg> LinkedIn</a>
          <a class="social-link" href="mailto:minapaul@gmail.com"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg> Email</a>
        </div>
      </div>
    </div>

    <!-- Manuel -->
    <div class="member-card">
      <img src="https://aquafiltra.up.railway.app/images/manuel_arthur.png" style="width:72px;height:72px;border-radius:12px;object-fit:cover;flex-shrink:0;border:1px solid rgba(168,224,99,0.3);">
      <div class="card-info">
        <div class="card-name">Manuel Arthur SanJuan</div>
        <div class="card-role role-frontend">Front End Developer</div>
        <div class="card-bio">
          Designs and builds the visual experience of AquaFiltra — crafting the real-time dashboard interface, sensor data visualizations, and ensuring a seamless user experience across all devices.
        </div>
        <div class="social-links">
          <a class="social-link" href="https://www.facebook.com/em.snjuan"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg> Facebook</a>
          <a class="social-link" href="#"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg> GitHub</a>
          <a class="social-link" href="https://www.youtube.com/shorts/_6HzLIJPH2A"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg> LinkedIn</a>
          <a class="social-link" href="mailto:martsanjuan12@gmail.com"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg> Email</a>
        </div>
      </div>
    </div>

  </div>

  <!-- BOTTOM 2 MEMBERS -->
  <div class="team-grid-bottom">

    <!-- Gervin -->
    <div class="member-card">
      <img src="{{ asset('images/gervin_ogarte.jpg') }}" style="width:72px;height:72px;border-radius:12px;object-fit:cover;flex-shrink:0;border:1px solid rgba(168,224,99,0.3);">
      <div class="card-info">
        <div class="card-name">Gervin Ryan Ogarte</div>
        <div class="card-role role-hardware">Hardware & Fabrication Designer</div>
        <div class="card-bio">
          Responsible for the physical construction and fabrication of the AquaFiltra water filtration system — assembling the 3-layer filtration structure and integrating the hardware components.
        </div>
        <div class="social-links">
          <a class="social-link" href="https://www.facebook.com/gervun"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg> Facebook</a>
          <a class="social-link" href="https://github.com/engrgerviiin"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg> GitHub</a>
          <a class="social-link" href="https://www.linkedin.com/in/gervin-ryan-ogarte-958bb0257/"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg> LinkedIn</a>
          <a class="social-link" href="mailto:engrgerviiin@gmail.com"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg> Email</a>
        </div>
      </div>
    </div>

    <!-- Ron -->
    <div class="member-card">
      <img src="https://aquafiltra.up.railway.app/images/ron_albert.jpg" style="width:72px;height:72px;border-radius:12px;object-fit:cover;flex-shrink:0;border:1px solid rgba(255,107,53,0.3);">
      <div class="card-info">
        <div class="card-name">Ron Albert Madrid</div>
        <div class="card-role role-docs">Research & Data Analyst</div>
        <div class="card-bio">
          Leads the research documentation and data gathering efforts — collecting, analyzing, and interpreting sensor data to support the scientific validity of the AquaFiltra water filtration study.
        </div>
        <div class="social-links">
          <a class="social-link" href="https://www.facebook.com/akotalagasiron/"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg> Facebook</a>
          <a class="social-link" href="https://github.com/tu3ron"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg> GitHub</a>
          <a class="social-link" href="https://www.linkedin.com/in/ron-albert-madrid-191bab257/"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg> LinkedIn</a>
          <a class="social-link" href="mailto:schoolronmadrid@gmail.com"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg> Email</a>
        </div>
      </div>
    </div>

  </div>
</div>

<footer>
  AquaFiltra · Thesis Project 2026 · Built with Laravel + ESP32
</footer>

<script>
  if (navigator.userAgent.includes('AquaFiltraApp')) {
    document.getElementById('downloadBtn').style.display = 'none';
  }
</script>
</body>
</html>
