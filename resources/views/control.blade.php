<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
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
    body {
      background:var(--bg); color:var(--text);
      font-family:'Syne',sans-serif; min-height:100vh;
    }
    body::before {
      content:''; position:fixed; inset:0;
      background-image:
        linear-gradient(rgba(0,212,255,0.025) 1px,transparent 1px),
        linear-gradient(90deg,rgba(0,212,255,0.025) 1px,transparent 1px);
      background-size:40px 40px; pointer-events:none; z-index:0;
    }
    nav {
      display:flex; align-items:center; justify-content:space-between;
      padding:14px 24px; border-bottom:1px solid var(--border);
      background:rgba(7,13,26,0.97); position:sticky; top:0; z-index:100;
      backdrop-filter:blur(10px);
    }
    .logo { font-family:'Space Mono',monospace; font-size:13px; color:var(--white);
            display:flex; align-items:center; gap:8px; }
    main {
      padding:40px 20px; max-width:600px; margin:0 auto;
      position:relative; z-index:1;
    }
    .page-header { margin-bottom:32px; text-align:center; }
    .page-header h1 { font-size:1.6rem; font-weight:800; color:var(--white); margin-bottom:8px; }
    .page-header p  { font-family:'Space Mono',monospace; font-size:11px; color:var(--text); opacity:0.6; }

    .current-box {
      background:var(--card); border:1px solid var(--border);
      padding:20px; margin-bottom:32px; text-align:center;
    }
    .current-label { font-family:'Space Mono',monospace; font-size:10px; color:var(--text);
                     letter-spacing:2px; text-transform:uppercase; margin-bottom:10px; }
    .current-value { font-family:'Space Mono',monospace; font-size:24px; font-weight:700; }

    .btn-grid { display:grid; grid-template-columns:1fr; gap:16px; margin-bottom:32px; }
    .btn-water {
      padding:24px; border:2px solid; border-radius:8px;
      font-family:'Space Mono',monospace; font-size:14px; font-weight:700;
      cursor:pointer; background:transparent; letter-spacing:1px;
      transition:all 0.2s; display:flex; align-items:center;
      justify-content:space-between; width:100%;
    }
    .btn-water:hover { transform:translateY(-2px); }
    .btn-full   { border-color:var(--red);    color:var(--red); }
    .btn-full:hover   { background:rgba(255,71,87,0.08); }
    .btn-near   { border-color:var(--yellow); color:var(--yellow); }
    .btn-near:hover   { background:rgba(255,215,0,0.08); }
    .btn-empty  { border-color:var(--green);  color:var(--green); }
    .btn-empty:hover  { background:rgba(0,255,157,0.08); }
    .btn-water.active { opacity:1; box-shadow:0 0 20px rgba(0,212,255,0.15); }
    .btn-water:not(.active) { opacity:0.5; }
    .btn-icon { font-size:24px; }
    .btn-desc { font-size:10px; opacity:0.7; text-align:right; }

    .feedback {
      text-align:center; font-family:'Space Mono',monospace; font-size:12px;
      padding:12px; border-radius:4px; display:none; margin-bottom:16px;
    }
    .feedback.success { background:rgba(0,255,157,0.08); color:var(--green); border:1px solid var(--green); }
    .feedback.error   { background:rgba(255,71,87,0.08);  color:var(--red);   border:1px solid var(--red); }

    .fab {
      position:fixed; bottom:28px; right:24px; z-index:200;
      background:var(--accent); color:#070d1a;
      font-family:'Space Mono',monospace; font-size:11px; font-weight:700;
      padding:12px 20px; border-radius:100px;
      text-decoration:none; display:flex; align-items:center; gap:8px;
      box-shadow:0 4px 24px rgba(0,212,255,0.35);
      transition:transform 0.2s, box-shadow 0.2s;
    }
    .fab:hover { transform:translateY(-3px); }
  </style>
</head>
<body>

<nav>
  <div class="logo">
    <img src="{{ asset('images/aquafiltra_logo_themed.png') }}" style="width:28px;height:28px;object-fit:contain;">
    <span>AquaFiltra — Water Level Control</span>
  </div>
</nav>

<a href="{{ url('/') }}" class="fab">← Dashboard</a>

<main>

  <div class="page-header">
    <h1>🚰 Water Level Control</h1>
    <p>Manually set the water level status displayed on the dashboard</p>
  </div>

  <div class="current-box">
    <div class="current-label">Current Water Level</div>
    <div class="current-value" id="currentStatus">Loading...</div>
  </div>

  <div class="feedback" id="feedback"></div>

  <div class="btn-grid">

    <button class="btn-water btn-full" onclick="setWaterLevel('FULL')">
      <div>
        <div class="btn-icon">🔴</div>
        <div>FULL</div>
      </div>
      <div class="btn-desc">Water container is full<br>Output valve should open</div>
    </button>

    <button class="btn-water btn-near" onclick="setWaterLevel('ALMOST FULL')">
      <div>
        <div class="btn-icon">🟡</div>
        <div>ALMOST FULL</div>
      </div>
      <div class="btn-desc">Water level is near full<br>Monitor closely</div>
    </button>

    <button class="btn-water btn-empty" onclick="setWaterLevel('NOT FULL')">
      <div>
        <div class="btn-icon">🟢</div>
        <div>NOT FULL</div>
      </div>
      <div class="btn-desc">Water level is low<br>Filtration in progress</div>
    </button>

  </div>

</main>

<script>
  const BASE = window.location.origin;

  // Load current water level
  function loadCurrent() {
    fetch(BASE + '/api/sensor/latest')
      .then(r => r.json())
      .then(data => {
        const wl = data.water_level || 'NOT FULL';
        document.getElementById('currentStatus').textContent = wl;
        updateActiveBtn(wl);
      })
      .catch(() => {
        document.getElementById('currentStatus').textContent = 'Unknown';
      });
  }

  function updateActiveBtn(wl) {
    document.querySelectorAll('.btn-water').forEach(b => b.classList.remove('active'));
    const wlUp = (wl || '').toString().toUpperCase();
    if (wlUp.includes('NOT'))         document.querySelector('.btn-empty').classList.add('active');
    else if (wlUp.includes('ALMOST')) document.querySelector('.btn-near').classList.add('active');
    else if (wlUp.includes('FULL'))   document.querySelector('.btn-full').classList.add('active');
  }

  function setWaterLevel(level) {
    const feedback = document.getElementById('feedback');
    feedback.style.display = 'none';

    console.log('Setting water level to:', level);

    fetch(BASE + '/api/water-level', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify({ water_level: level })
    })
    .then(r => {
      console.log('Response status:', r.status);
      return r.json();
    })
    .then(data => {
      console.log('Response data:', data);
      if (data.success) {
        document.getElementById('currentStatus').textContent = level;
        updateActiveBtn(level);
        feedback.className = 'feedback success';
        feedback.textContent = '✅ Water level updated to: ' + level;
        feedback.style.display = 'block';
        setTimeout(() => { feedback.style.display = 'none'; }, 3000);
      } else {
        throw new Error(data.message || 'Failed');
      }
    })
    .catch(err => {
      console.error('Error:', err);
      feedback.className = 'feedback error';
      feedback.textContent = '❌ Failed: ' + err.message;
      feedback.style.display = 'block';
    });
  }

  loadCurrent();
</script>

</body>
</html>