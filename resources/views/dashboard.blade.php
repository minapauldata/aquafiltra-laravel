<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AquaFiltra Monitor</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<link rel="icon" type="image/png" href="{{ asset('images/aquafiltra_logo_themed.png') }}">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #070d1a;
      --card: #0c1525;
      --border: #152035;
      --accent: #00d4ff;
      --green: #00ff9d;
      --yellow: #ffd700;
      --red: #ff4757;
      --text: #8fa8c8;
      --white: #e8f4ff;
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { background:var(--bg); color:var(--text); font-family:'Syne',sans-serif; min-height:100vh; }
    body::before {
      content:''; position:fixed; inset:0;
      background-image:
        linear-gradient(rgba(0,212,255,0.025) 1px,transparent 1px),
        linear-gradient(90deg,rgba(0,212,255,0.025) 1px,transparent 1px);
      background-size:40px 40px; pointer-events:none; z-index:0;
    }

    /* NAV */
    nav {
      display:flex; align-items:center; justify-content:space-between;
      padding:14px 24px; border-bottom:1px solid var(--border);
      background:rgba(7,13,26,0.97); position:sticky; top:0; z-index:100;
      backdrop-filter:blur(10px); gap:12px;
    }
    .logo { font-family:'Space Mono',monospace; font-size:13px; color:var(--white);
            display:flex; align-items:center; gap:8px; flex-shrink:0; }
    .logo-dot { width:8px; height:8px; background:var(--green); border-radius:50%; animation:pulse 2s infinite; flex-shrink:0; }
    @keyframes pulse { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:0.5;transform:scale(1.4);} }
    .nav-right { display:flex; align-items:center; gap:12px; font-family:'Space Mono',monospace; font-size:11px; flex-wrap:wrap; justify-content:flex-end; }
    .nav-right a { color:var(--text); text-decoration:none; transition:color 0.2s; white-space:nowrap; }
    .nav-right a:hover { color:var(--accent); }

    /* FLOATING BUTTON */
    .fab {
      position:fixed; bottom:28px; right:24px; z-index:200;
      background:var(--accent); color:#070d1a;
      font-family:'Space Mono',monospace; font-size:11px; font-weight:700;
      padding:12px 20px; border-radius:100px;
      text-decoration:none; display:flex; align-items:center; gap:8px;
      box-shadow:0 4px 24px rgba(0,212,255,0.35);
      transition:transform 0.2s, box-shadow 0.2s;
      letter-spacing:0.5px;
    }
    .fab:hover { transform:translateY(-3px); box-shadow:0 8px 32px rgba(0,212,255,0.45); }
    #last-updated { color:var(--accent); white-space:nowrap; }
    #connection-status { padding:3px 8px; border:1px solid; font-size:10px; letter-spacing:1px; white-space:nowrap; }
    .status-ok  { border-color:var(--green); color:var(--green); }
    .status-err { border-color:var(--red);   color:var(--red);   }

    /* MAIN */
    main { padding:20px; max-width:1200px; margin:0 auto; position:relative; z-index:1; }

    /* PAGE HEADER */
    .page-header { margin-bottom:20px; }
    .page-header h1 { font-size:1.4rem; font-weight:800; color:var(--white); margin-bottom:4px; }
    .page-header p { font-family:'Space Mono',monospace; font-size:10px; color:var(--text); opacity:0.6; }

    /* FLOW */
    .flow {
      display:flex; align-items:center; gap:0; margin-bottom:20px;
      background:var(--card); border:1px solid var(--border);
      padding:14px 16px; overflow-x:auto;
      -webkit-overflow-scrolling:touch;
      scrollbar-width:thin; scrollbar-color:var(--border) transparent;
    }
    .flow::-webkit-scrollbar { height:4px; }
    .flow::-webkit-scrollbar-track { background:transparent; }
    .flow::-webkit-scrollbar-thumb { background:var(--border); border-radius:2px; }
    .flow-item { display:flex; flex-direction:column; align-items:center; gap:5px; min-width:80px; }
    .flow-icon { font-size:1.3rem; }
    .flow-label { font-family:'Space Mono',monospace; font-size:9px; color:var(--white); text-align:center; letter-spacing:0.5px; }
    .flow-sub   { font-size:8px; color:var(--text); opacity:0.5; text-align:center; }
    .flow-arrow { color:var(--accent); font-size:1rem; padding:0 4px; opacity:0.5; flex-shrink:0; }
    .flow-sensor { display:flex; flex-direction:column; align-items:center; gap:4px; min-width:50px; }
    .flow-sensor-dot { width:8px; height:8px; border-radius:50%; background:var(--accent); animation:pulse 2s infinite; }
    .flow-sensor-label { font-family:'Space Mono',monospace; font-size:8px; color:var(--accent); text-align:center; }

    /* STATUS BAR */
    .status-bar {
      background:var(--card); border:1px solid var(--border); border-radius:8px;
      padding:12px 16px; margin-bottom:20px; display:flex; align-items:center;
      gap:10px; font-size:13px; flex-wrap:wrap;
    }
    .badge { padding:4px 12px; border-radius:3px; font-size:11px; font-weight:700;
             text-transform:uppercase; letter-spacing:1px; font-family:'Space Mono',monospace; white-space:nowrap; }
    .badge.normal  { background:rgba(0,255,157,.08); color:var(--green);  border:1px solid var(--green); }
    .badge.warning { background:rgba(255,215,0,.08);  color:var(--yellow); border:1px solid var(--yellow); }
    .badge.danger  { background:rgba(255,71,87,.08);  color:var(--red);    border:1px solid var(--red); animation:blink 1s infinite; }
    @keyframes blink { 50%{opacity:0.4;} }

    /* GAUGE CARDS */
    .cards { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:20px; }
    .gauge-card {
      background:var(--card); border:1px solid var(--border); border-top:3px solid var(--border);
      border-radius:4px; padding:20px 16px 16px; display:flex; flex-direction:column; align-items:center;
      transition:border-top-color 0.3s, box-shadow 0.3s;
    }
    .gauge-card.warning { border-top-color:var(--yellow); box-shadow:0 0 20px rgba(255,215,0,0.07); }
    .gauge-card.danger  { border-top-color:var(--red);    box-shadow:0 0 20px rgba(255,71,87,0.1); }
    .gauge-card.normal  { border-top-color:var(--green);  box-shadow:0 0 20px rgba(0,255,157,0.05); }
    .gauge-label { font-size:10px; color:var(--text); text-transform:uppercase;
                   letter-spacing:2px; margin-bottom:12px; font-family:'Space Mono',monospace; }

    /* GAUGE SVG — scales with container */
    .gauge-wrap { position:relative; width:100%; max-width:180px; margin-bottom:6px; }
    .gauge-wrap svg { width:100%; height:auto; overflow:visible; }
    .gauge-value {
      position:absolute; bottom:22%; left:50%; transform:translateX(-50%);
      font-size:clamp(18px,4vw,26px); font-weight:800; line-height:1;
      font-family:'Space Mono',monospace; white-space:nowrap;
    }
    .gauge-unit  { font-size:10px; color:var(--text); font-family:'Space Mono',monospace; text-align:center; }
    .gauge-range { display:flex; justify-content:space-between; width:100%; max-width:180px;
                   font-size:9px; color:#4a6a7a; font-family:'Space Mono',monospace; margin-top:3px; }
    .gauge-safe  { font-size:10px; color:var(--text); margin-top:5px; font-family:'Space Mono',monospace; text-align:center; }
    .gauge-safe span { color:var(--green); }

    /* CHARTS */
    .charts { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:20px; }
    .chart-box { background:var(--card); border:1px solid var(--border); padding:16px; }
    .chart-box h3 { font-size:10px; color:var(--text); margin-bottom:12px;
                    text-transform:uppercase; letter-spacing:2px; font-family:'Space Mono',monospace; }

    /* HISTORY TABLE */
    .history-section { background:var(--card); border:1px solid var(--border); padding:16px; }
    .section-title {
      font-size:0.7rem; font-family:'Space Mono',monospace; color:var(--text);
      letter-spacing:2px; text-transform:uppercase; margin-bottom:16px;
      padding-bottom:12px; border-bottom:1px solid var(--border);
      display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;
    }
    .section-title span { color:var(--accent); }

    /* TABLE — scrollable on mobile */
    .table-wrap { overflow-x:auto; -webkit-overflow-scrolling:touch; }
    table { width:100%; border-collapse:collapse; min-width:420px; }
    th { font-family:'Space Mono',monospace; font-size:9px; letter-spacing:1px; color:var(--text);
         text-align:left; padding:8px 10px; border-bottom:1px solid var(--border); opacity:0.6; white-space:nowrap; }
    td { font-family:'Space Mono',monospace; font-size:11px; padding:9px 10px;
         border-bottom:1px solid var(--border); color:var(--text); white-space:nowrap; }
    tr:last-child td { border-bottom:none; }
    tr:hover td { background:rgba(255,255,255,0.02); }
    .td-val { color:var(--white); font-weight:700; }
    .td-badge { display:inline-block; font-size:9px; padding:2px 7px; border:1px solid; font-family:'Space Mono',monospace; }
    .td-badge.normal  { color:var(--green);  border-color:var(--green); }
    .td-badge.warning { color:var(--yellow); border-color:var(--yellow); }
    .td-badge.danger  { color:var(--red);    border-color:var(--red); }

    /* ── TABLET: 2 columns for gauges/charts ── */
    @media(max-width:900px) {
      .cards  { grid-template-columns:repeat(3,1fr); }
      .charts { grid-template-columns:repeat(3,1fr); }
    }

    /* ── MOBILE: single column ── */
    @media(max-width:600px) {
      nav { padding:10px 14px; }
      .logo { font-size:12px; }
      .nav-right { font-size:10px; gap:8px; }
      #last-updated-wrap { display:none; } /* hide "Updated:" on very small screens */

      main { padding:12px; }
      .page-header h1 { font-size:1.1rem; }
      .page-header p { font-size:9px; }

      /* Gauges: 1 per row on phone */
      .cards  { grid-template-columns:1fr; gap:12px; }
      .charts { grid-template-columns:1fr; gap:12px; }

      /* Gauge SVG bigger on single column */
      .gauge-wrap { max-width:220px; }
      .gauge-value { font-size:clamp(22px,8vw,30px); }
      .gauge-range { max-width:220px; }

      .gauge-card { padding:16px 14px 14px; }
      .gauge-label { font-size:10px; margin-bottom:10px; }

      .chart-box { padding:14px; }
      .history-section { padding:14px; }

      .flow { padding:12px; }
    }

    /* ── VERY SMALL (< 380px) ── */
    @media(max-width:380px) {
      .logo span { display:none; } /* hide text, keep dot+emoji */
      .nav-right gap { gap:6px; }
      .page-header h1 { font-size:1rem; }
    }
  </style>
</head>
<body>

<nav>
  <div class="logo">
    <div class="logo-dot" id="logoDot"></div>
    <img src="https://aquafiltra.up.railway.app/images/aquafiltra_logo_themed.png" style="width:32px;height:32px;object-fit:contain;"> AquaFiltra Monitor
  </div>
  <div class="nav-right">

    <span id="last-updated-wrap">Updated: <span id="last-updated">--:--:--</span></span>
    <span id="connection-status" class="status-ok">● LIVE</span>
  </div>
</nav>

<!-- FLOATING ABOUT US BUTTON -->
<a href="{{ url('/about') }}" class="fab">👥 About Us</a>
<a href="https://aquafiltra.up.railway.app/app-debug.apk" download class="fab" style="bottom:80px;">
  Download App
</a>


<main>

  <div class="page-header">
    <h1>Water Filtration Monitor</h1>
    <p>3-LAYER SYSTEM · ESP32 + pH · TURBIDITY · TDS SENSORS · AUTO-REFRESH EVERY 3 SECONDS</p>
  </div>

  <!-- FILTRATION FLOW -->
  <div class="flow">
    <div class="flow-item">
      <div class="flow-icon">🪣</div>
      <div class="flow-label">RAW WATER</div>
      <div class="flow-sub">Input</div>
    </div>
    <div class="flow-arrow">→</div>
    <div class="flow-item">
      <div class="flow-icon">🪨</div>
      <div class="flow-label">PEBBLES</div>
      <div class="flow-sub">Layer 1</div>
    </div>
    <div class="flow-arrow">→</div>
    <div class="flow-item">
      <div class="flow-icon">🏖️</div>
      <div class="flow-label">SILICA SAND</div>
      <div class="flow-sub">Layer 2</div>
    </div>
    <div class="flow-arrow">→</div>
    <div class="flow-item">
      <div class="flow-icon">⬛</div>
      <div class="flow-label">GAC</div>
      <div class="flow-sub">Layer 3</div>
    </div>
    <div class="flow-arrow">→</div>
    <div class="flow-item">
      <div class="flow-icon">🔆</div>
      <div class="flow-label">UV LIGHT</div>
      <div class="flow-sub">Sterilize</div>
    </div>
    <div class="flow-arrow">→</div>
    <div class="flow-sensor">
      <div class="flow-sensor-dot"></div>
      <div class="flow-sensor-label">pH<br>Sensor</div>
    </div>
    <div class="flow-arrow">·</div>
    <div class="flow-sensor">
      <div class="flow-sensor-dot" style="background:#ff6b35;"></div>
      <div class="flow-sensor-label" style="color:#ff6b35;">Turbidity<br>Sensor</div>
    </div>
    <div class="flow-arrow">·</div>
    <div class="flow-sensor">
      <div class="flow-sensor-dot" style="background:#00ff94;"></div>
      <div class="flow-sensor-label" style="color:#00ff94;">TDS<br>Sensor</div>
    </div>
    <div class="flow-arrow">→</div>
    <div class="flow-item">
      <div class="flow-icon">💧</div>
      <div class="flow-label">CLEAN WATER</div>
      <div class="flow-sub">Output</div>
    </div>
  </div>

  <!-- STATUS BAR -->
  <div class="status-bar">
    <span style="font-family:'Space Mono',monospace;font-size:11px;">Water Quality:</span>
    <span class="badge normal" id="statusBadge">NORMAL</span>
    <span style="font-family:'Space Mono',monospace;font-size:10px;color:#4a6a7a;" id="readingTime"></span>
  </div>

  <!-- GAUGE CARDS -->
  <div class="cards">

    <div class="gauge-card" id="phCard">
      <div class="gauge-label">⚗️ pH Level</div>
      <div class="gauge-wrap">
        <svg viewBox="0 0 180 100">
          <path d="M 15 95 A 75 75 0 0 1 57 28"  fill="none" stroke="#ff4757" stroke-width="14" stroke-linecap="butt" opacity="0.2"/>
          <path d="M 57 28 A 75 75 0 0 1 123 28"  fill="none" stroke="#00ff9d" stroke-width="14" stroke-linecap="butt" opacity="0.2"/>
          <path d="M 123 28 A 75 75 0 0 1 165 95" fill="none" stroke="#ffd700" stroke-width="14" stroke-linecap="butt" opacity="0.2"/>
          <path d="M 15 95 A 75 75 0 0 1 165 95"  fill="none" stroke="#152035" stroke-width="8" stroke-linecap="round"/>
          <path id="phArc" d="M 15 95 A 75 75 0 0 1 165 95" fill="none" stroke="#00d4ff" stroke-width="8" stroke-linecap="round"
                stroke-dasharray="235" stroke-dashoffset="235" style="transition:stroke-dashoffset 1s ease,stroke 0.5s;"/>
          <line id="phNeedle" x1="90" y1="92" x2="90" y2="32" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" opacity="0.9"
                style="transform-origin:90px 95px;transition:transform 1s ease;transform:rotate(-90deg);"/>
          <circle cx="90" cy="95" r="6" fill="#0c1525" stroke="#00d4ff" stroke-width="2.5"/>
        </svg>
        <div class="gauge-value" id="phVal" style="color:#00d4ff;">--</div>
      </div>
      <div class="gauge-unit">pH Scale 0 – 14</div>
      <div class="gauge-range"><span>0</span><span>7</span><span>14</span></div>
      <div class="gauge-safe">Safe: <span>6.5 – 8.5</span></div>
    </div>

    <div class="gauge-card" id="turbCard">
      <div class="gauge-label">🌊 Turbidity</div>
      <div class="gauge-wrap">
        <svg viewBox="0 0 180 100">
          <path d="M 15 95 A 75 75 0 0 1 62 26"  fill="none" stroke="#00ff9d" stroke-width="14" stroke-linecap="butt" opacity="0.2"/>
          <path d="M 62 26 A 75 75 0 0 1 118 26"  fill="none" stroke="#ffd700" stroke-width="14" stroke-linecap="butt" opacity="0.2"/>
          <path d="M 118 26 A 75 75 0 0 1 165 95" fill="none" stroke="#ff4757" stroke-width="14" stroke-linecap="butt" opacity="0.2"/>
          <path d="M 15 95 A 75 75 0 0 1 165 95"  fill="none" stroke="#152035" stroke-width="8" stroke-linecap="round"/>
          <path id="turbArc" d="M 15 95 A 75 75 0 0 1 165 95" fill="none" stroke="#ff6b35" stroke-width="8" stroke-linecap="round"
                stroke-dasharray="235" stroke-dashoffset="235" style="transition:stroke-dashoffset 1s ease,stroke 0.5s;"/>
          <line id="turbNeedle" x1="90" y1="92" x2="90" y2="32" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" opacity="0.9"
                style="transform-origin:90px 95px;transition:transform 1s ease;transform:rotate(-90deg);"/>
          <circle cx="90" cy="95" r="6" fill="#0c1525" stroke="#ff6b35" stroke-width="2.5"/>
        </svg>
        <div class="gauge-value" id="turbVal" style="color:#ff6b35;">--</div>
      </div>
      <div class="gauge-unit">NTU (0 – 20)</div>
      <div class="gauge-range"><span>0</span><span>10</span><span>20</span></div>
      <div class="gauge-safe">Safe: <span>&lt; 4 NTU</span></div>
    </div>

    <div class="gauge-card" id="tdsCard">
      <div class="gauge-label">🧪 TDS</div>
      <div class="gauge-wrap">
        <svg viewBox="0 0 180 100">
          <path d="M 15 95 A 75 75 0 0 1 90 20"   fill="none" stroke="#00ff9d" stroke-width="14" stroke-linecap="butt" opacity="0.2"/>
          <path d="M 90 20 A 75 75 0 0 1 142 36"  fill="none" stroke="#ffd700" stroke-width="14" stroke-linecap="butt" opacity="0.2"/>
          <path d="M 142 36 A 75 75 0 0 1 165 95" fill="none" stroke="#ff4757" stroke-width="14" stroke-linecap="butt" opacity="0.2"/>
          <path d="M 15 95 A 75 75 0 0 1 165 95"  fill="none" stroke="#152035" stroke-width="8" stroke-linecap="round"/>
          <path id="tdsArc" d="M 15 95 A 75 75 0 0 1 165 95" fill="none" stroke="#00ff9d" stroke-width="8" stroke-linecap="round"
                stroke-dasharray="235" stroke-dashoffset="235" style="transition:stroke-dashoffset 1s ease,stroke 0.5s;"/>
          <line id="tdsNeedle" x1="90" y1="92" x2="90" y2="32" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" opacity="0.9"
                style="transform-origin:90px 95px;transition:transform 1s ease;transform:rotate(-90deg);"/>
          <circle cx="90" cy="95" r="6" fill="#0c1525" stroke="#00ff9d" stroke-width="2.5"/>
        </svg>
        <div class="gauge-value" id="tdsVal" style="color:#00ff9d;">--</div>
      </div>
      <div class="gauge-unit">ppm (0 – 1000)</div>
      <div class="gauge-range"><span>0</span><span>500</span><span>1000</span></div>
      <div class="gauge-safe">Safe: <span>&lt; 500 ppm</span></div>
    </div>

  </div>

  <!-- CHARTS -->
  <div class="charts">
    <div class="chart-box"><h3>pH History</h3><canvas id="phChart"></canvas></div>
    <div class="chart-box"><h3>Turbidity History</h3><canvas id="turbChart"></canvas></div>
    <div class="chart-box"><h3>TDS History</h3><canvas id="tdsChart"></canvas></div>
  </div>

  <!-- HISTORY TABLE -->
  <div class="history-section">
    <div class="section-title">
      Recent Readings Log
      <span id="total-readings">0 records</span>
    </div>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>TIMESTAMP</th>
            <th>⚗️ pH</th>
            <th>🌊 TURBIDITY</th>
            <th>🧪 TDS</th>
            <th>STATUS</th>
          </tr>
        </thead>
        <tbody id="readings-table">
          <tr>
            <td colspan="5" style="text-align:center;opacity:0.4;padding:30px;">
              Waiting for sensor data from ESP32...
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</main>

<script>
  const BASE    = window.location.origin;
  const HEADERS = { 'ngrok-skip-browser-warning': 'true' };
  const STATUS_COLORS = { normal:'#00ff9d', warning:'#ffd700', danger:'#ff4757' };

  function setGauge(arcId, needleId, valueElId, value, min, max, defaultColor, warnThresh, dangerThresh) {
    const pct    = Math.min(Math.max((value - min) / (max - min), 0), 1);
    const offset = 235 - (pct * 235);
    const arc    = document.getElementById(arcId);
    const needle = document.getElementById(needleId);
    let color = defaultColor;
    if (value >= dangerThresh)    color = '#ff4757';
    else if (value >= warnThresh) color = '#ffd700';
    arc.style.strokeDashoffset = offset;
    arc.style.stroke = color;
    document.getElementById(valueElId).style.color = color;
    needle.style.transform = `rotate(${-90 + pct * 180}deg)`;
  }

  function makeChart(id, label, color) {
    return new Chart(document.getElementById(id), {
      type: 'line',
      data: { labels:[], datasets:[{ label, data:[], borderColor:color,
              backgroundColor:color+'18', tension:0.4, fill:true, pointRadius:2, borderWidth:2 }] },
      options: {
        responsive:true, animation:{ duration:500 },
        plugins:{ legend:{ display:false } },
        scales:{
          x:{ display:false },
          y:{ ticks:{ color:'#5a7090', font:{ family:'Space Mono', size:10 } },
              grid:{ color:'rgba(255,255,255,0.04)' } }
        }
      }
    });
  }

  const phChart   = makeChart('phChart',   'pH',        '#00d4ff');
  const turbChart = makeChart('turbChart', 'Turbidity', '#ff6b35');
  const tdsChart  = makeChart('tdsChart',  'TDS',       '#00ff9d');

  function addData(chart, label, value) {
    if (chart.data.labels.length > 20) {
      chart.data.labels.shift(); chart.data.datasets[0].data.shift();
    }
    chart.data.labels.push(label);
    chart.data.datasets[0].data.push(value);
    chart.update('none');
  }

  let tableData = [];
  function addTableRow(data) {
    const ph     = parseFloat(data.ph_level);
    const turb   = parseFloat(data.turbidity);
    const tds    = parseFloat(data.tds);
    const status = data.status || 'normal';
    tableData.unshift({
      time: new Date(data.created_at).toLocaleString(),
      ph: ph.toFixed(2), turb: turb.toFixed(2), tds: tds.toFixed(1), status
    });
    if (tableData.length > 20) tableData = tableData.slice(0, 20);
    document.getElementById('readings-table').innerHTML = tableData.map(row => `
      <tr>
        <td>${row.time}</td>
        <td class="td-val" style="color:${STATUS_COLORS[row.status]}">${row.ph}</td>
        <td class="td-val" style="color:${STATUS_COLORS[row.status]}">${row.turb}</td>
        <td class="td-val" style="color:${STATUS_COLORS[row.status]}">${row.tds}</td>
        <td><span class="td-badge ${row.status}">${row.status.toUpperCase()}</span></td>
      </tr>`).join('');
    document.getElementById('total-readings').textContent = tableData.length + ' records';
  }

  function updateUI(data) {
    if (!data) return;
    const ph   = parseFloat(data.ph_level);
    const turb = parseFloat(data.turbidity);
    const tds  = parseFloat(data.tds);

    document.getElementById('phVal').textContent   = ph.toFixed(2);
    document.getElementById('turbVal').textContent = turb.toFixed(2);
    document.getElementById('tdsVal').textContent  = tds.toFixed(1);

    setGauge('phArc',   'phNeedle',   'phVal',   ph,   0, 14,   '#00d4ff', 8.5,  9.0);
    setGauge('turbArc', 'turbNeedle', 'turbVal', turb, 0, 20,   '#ff6b35', 4,    10);
    setGauge('tdsArc',  'tdsNeedle',  'tdsVal',  tds,  0, 1000, '#00ff9d', 500,  1000);

    const badge = document.getElementById('statusBadge');
    badge.textContent = data.status.toUpperCase();
    badge.className   = 'badge ' + data.status;

    ['phCard','turbCard','tdsCard'].forEach(c => {
      document.getElementById(c).className = 'gauge-card ' + data.status;
    });

    const t = new Date(data.created_at);
    document.getElementById('readingTime').textContent  = 'Last reading: ' + t.toLocaleTimeString();
    document.getElementById('last-updated').textContent = t.toLocaleTimeString();

    const timeLabel = t.toLocaleTimeString();
    addData(phChart,   timeLabel, ph);
    addData(turbChart, timeLabel, turb);
    addData(tdsChart,  timeLabel, tds);
    addTableRow(data);
  }

  let missedPolls = 0;

  function setOffline() {
    document.getElementById('connection-status').className   = 'status-err';
    document.getElementById('connection-status').textContent = '● OFFLINE';
    document.getElementById('logoDot').style.background     = '#ff4757';
    document.getElementById('logoDot').style.animation      = 'none';
    document.getElementById('statusBadge').textContent      = 'OFFLINE';
    document.getElementById('statusBadge').className        = 'badge danger';
  }

  function setOnline() {
    document.getElementById('connection-status').className   = 'status-ok';
    document.getElementById('connection-status').textContent = '● LIVE';
    document.getElementById('logoDot').style.background     = '#00ff9d';
    document.getElementById('logoDot').style.animation      = 'pulse 2s infinite';
    missedPolls = 0;
  }

  function loadHistory() {
    fetch(BASE + '/api/sensor/history', { headers: HEADERS })
      .then(r => r.json())
      .then(rows => {
        rows.forEach(d => {
          const t = new Date(d.created_at).toLocaleTimeString();
          addData(phChart,   t, parseFloat(d.ph_level));
          addData(turbChart, t, parseFloat(d.turbidity));
          addData(tdsChart,  t, parseFloat(d.tds));
        });
        if (rows.length) updateUI(rows[rows.length - 1]);
      }).catch(() => {});
  }

  function poll() {
    fetch(BASE + '/api/sensor/latest', { headers: HEADERS })
      .then(r => { if (!r.ok) throw new Error(); return r.json(); })
      .then(data => {
        if (!data || !data.id) { missedPolls++; if (missedPolls >= 2) setOffline(); return; }
        const age = (Date.now() - new Date(data.created_at).getTime()) / 1000;
        if (age > 15) { missedPolls++; if (missedPolls >= 2) setOffline(); return; }
        setOnline();
        updateUI(data);
      })
      .catch(() => { missedPolls++; if (missedPolls >= 2) setOffline(); });
  }

  loadHistory();
  setInterval(poll, 3000);
</script>
</body>
</html>
