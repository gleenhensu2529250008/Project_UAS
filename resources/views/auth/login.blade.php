<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login — Anime Portal</title>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700;900&family=Rajdhani:wght@300;400;500;600&family=Noto+Sans+JP:wght@300;400;700&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --sakura:    #ff6eb4;
      --sakura-lt: #ffb3d9;
      --indigo:    #1a0a2e;
      --violet:    #2d1b69;
      --gold:      #ffd700;
      --ice:       #e0f7ff;
      --glass-bg:  rgba(15, 5, 35, 0.65);
      --glass-bdr: rgba(255, 110, 180, 0.35);
      --glow:      0 0 24px rgba(255, 110, 180, 0.55);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Rajdhani', 'Noto Sans JP', sans-serif;
      min-height: 100vh;
      overflow: hidden;
      background: var(--indigo);
      color: #fff;
      cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Ccircle cx='12' cy='12' r='4' fill='%23ff6eb4' opacity='0.85'/%3E%3C/svg%3E") 12 12, auto;
    }

    /* ── BACKGROUND SLIDESHOW ── */
    #bg-wrap {
      position: fixed; inset: 0; z-index: 0;
    }
    .bg-slide {
      position: absolute; inset: 0;
      background-size: cover;
      background-position: center;
      opacity: 0;
      transition: opacity 1.2s cubic-bezier(.4,0,.2,1);
      will-change: opacity;
    }
    .bg-slide.active { opacity: 1; }

    /* ── Placeholder anime‐style gradient scenes ── */
    .bg-slide:nth-child(1) {
      background: linear-gradient(135deg, #0d0221 0%, #1a0537 30%, #3b0764 60%, #6a0572 80%, #ff6eb4 100%),
                  radial-gradient(ellipse at 70% 30%, rgba(255,110,180,.4) 0%, transparent 60%);
      background-blend-mode: multiply;
    }
    .bg-slide:nth-child(2) {
      background: linear-gradient(160deg, #000510 0%, #001233 40%, #00335a 65%, #005c8a 85%, #00b4d8 100%),
                  radial-gradient(ellipse at 30% 70%, rgba(0,180,216,.45) 0%, transparent 55%);
      background-blend-mode: multiply;
    }
    .bg-slide:nth-child(3) {
      background: linear-gradient(120deg, #1a0a00 0%, #3d1c02 35%, #7a3b04 60%, #d4700a 80%, #ffd700 100%),
                  radial-gradient(ellipse at 60% 20%, rgba(255,180,0,.4) 0%, transparent 55%);
      background-blend-mode: multiply;
    }
    .bg-slide:nth-child(4) {
      background: linear-gradient(150deg, #050017 0%, #120036 35%, #2a0066 60%, #4400a8 80%, #9b00ff 100%),
                  radial-gradient(ellipse at 40% 60%, rgba(130,0,255,.5) 0%, transparent 55%);
      background-blend-mode: multiply;
    }
    .bg-slide:nth-child(5) {
      background: linear-gradient(140deg, #001a0a 0%, #003d1f 35%, #005c2e 60%, #007a3d 80%, #00e676 100%),
                  radial-gradient(ellipse at 75% 40%, rgba(0,200,100,.4) 0%, transparent 55%);
      background-blend-mode: multiply;
    }

    /* ── Overlay effects ── */
    #overlay {
      position: fixed; inset: 0; z-index: 1;
      background:
        radial-gradient(ellipse at 50% 50%, rgba(15,5,35,.3) 0%, rgba(10,3,25,.75) 100%);
      pointer-events: none;
    }
    /* scanline */
    #overlay::after {
      content: '';
      position: absolute; inset: 0;
      background: repeating-linear-gradient(
        0deg,
        transparent,
        transparent 3px,
        rgba(255,110,180,.025) 3px,
        rgba(255,110,180,.025) 4px
      );
      pointer-events: none;
    }

    /* ── SAKURA PETALS ── */
    .petal {
      position: fixed; z-index: 2;
      width: 10px; height: 12px;
      border-radius: 50% 0 50% 0;
      background: linear-gradient(135deg, #ffb3d9, #ff6eb4);
      opacity: 0;
      pointer-events: none;
      animation: fall linear infinite;
    }
    @keyframes fall {
      0%   { transform: translateY(-20px) rotate(0deg); opacity: .9; }
      100% { transform: translateY(110vh) rotate(720deg); opacity: 0; }
    }

    /* ── STARS / PARTICLES ── */
    .star {
      position: fixed; z-index: 2;
      width: 3px; height: 3px;
      border-radius: 50%;
      background: #fff;
      animation: twinkle ease-in-out infinite;
      pointer-events: none;
    }
    @keyframes twinkle {
      0%,100% { opacity: .15; transform: scale(1); }
      50%      { opacity: .9;  transform: scale(1.6); }
    }

    /* ── MAIN LAYOUT ── */
    #scene {
      position: relative; z-index: 10;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }

    /* ── LOGIN CARD ── */
    .card {
      width: 100%;
      max-width: 420px;
      background: var(--glass-bg);
      border: 1px solid var(--glass-bdr);
      border-radius: 20px;
      padding: 48px 40px 40px;
      backdrop-filter: blur(22px) saturate(180%);
      -webkit-backdrop-filter: blur(22px) saturate(180%);
      box-shadow:
        0 0 0 1px rgba(255,110,180,.12),
        0 8px 48px rgba(0,0,0,.6),
        inset 0 1px 0 rgba(255,255,255,.08);
      position: relative;
      overflow: hidden;
      animation: cardIn .9s cubic-bezier(.22,1,.36,1) both;
    }
    @keyframes cardIn {
      from { opacity:0; transform: translateY(32px) scale(.97); }
      to   { opacity:1; transform: translateY(0) scale(1); }
    }

    /* corner ornaments */
    .card::before,
    .card::after {
      content: '';
      position: absolute;
      width: 60px; height: 60px;
      border-color: var(--sakura);
      border-style: solid;
      opacity: .5;
    }
    .card::before {
      top: 14px; left: 14px;
      border-width: 2px 0 0 2px;
      border-radius: 8px 0 0 0;
    }
    .card::after {
      bottom: 14px; right: 14px;
      border-width: 0 2px 2px 0;
      border-radius: 0 0 8px 0;
    }

    /* inner glow strip */
    .card-glow {
      position: absolute;
      top: -1px; left: 50%; transform: translateX(-50%);
      width: 160px; height: 2px;
      background: linear-gradient(90deg, transparent, var(--sakura), transparent);
      border-radius: 50%;
      box-shadow: 0 0 18px 4px rgba(255,110,180,.6);
    }

    /* ── LOGO / SYMBOL ── */
    .logo-wrap {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 6px;
      margin-bottom: 28px;
    }
    .logo-title {
      font-family: 'Cinzel Decorative', serif;
      font-size: 26px;
      font-weight: 900;
      letter-spacing: 4px;
      text-transform: uppercase;
      background: linear-gradient(135deg, #fff 0%, var(--sakura-lt) 50%, var(--sakura) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      text-shadow: none;
    }
    .logo-sub {
      font-size: 11px;
      letter-spacing: 5px;
      text-transform: uppercase;
      color: rgba(255,179,217,.55);
    }

    /* ── FORM ── */
    .field {
      margin-bottom: 18px;
    }
    .field label {
      display: block;
      font-size: 11px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: rgba(255,179,217,.7);
      margin-bottom: 7px;
    }
    .field-wrap {
      position: relative;
    }
    .field-icon {
      position: absolute;
      left: 14px; top: 50%;
      transform: translateY(-50%);
      font-size: 16px;
      opacity: .6;
      pointer-events: none;
    }
    .field input {
      width: 100%;
      padding: 13px 16px 13px 42px;
      background: rgba(255,255,255,.05);
      border: 1px solid rgba(255,110,180,.2);
      border-radius: 10px;
      color: #fff;
      font-family: 'Rajdhani', sans-serif;
      font-size: 15px;
      font-weight: 500;
      letter-spacing: .5px;
      outline: none;
      transition: border-color .25s, box-shadow .25s, background .25s;
    }
    .field input::placeholder { color: rgba(255,255,255,.25); }
    .field input:focus {
      border-color: var(--sakura);
      background: rgba(255,110,180,.06);
      box-shadow: 0 0 0 3px rgba(255,110,180,.15), 0 0 18px rgba(255,110,180,.12);
    }

    /* ── OPTIONS ROW ── */
    .options {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
      font-size: 12px;
    }
    .remember {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      color: rgba(255,179,217,.65);
    }
    .remember input[type=checkbox] { display: none; }
    .chk-box {
      width: 16px; height: 16px;
      border: 1px solid rgba(255,110,180,.4);
      border-radius: 4px;
      display: flex; align-items: center; justify-content: center;
      font-size: 10px;
      transition: background .2s, border-color .2s;
    }
    .remember input:checked + .chk-box {
      background: var(--sakura);
      border-color: var(--sakura);
    }
    .forgot {
      color: var(--sakura-lt);
      text-decoration: none;
      letter-spacing: 1px;
      font-size: 12px;
      transition: color .2s, text-shadow .2s;
    }
    .forgot:hover {
      color: var(--gold);
      text-shadow: 0 0 8px rgba(255,215,0,.5);
    }

    /* ── BUTTON ── */
    .btn-login {
      width: 100%;
      padding: 15px;
      border: none;
      border-radius: 10px;
      font-family: 'Cinzel Decorative', serif;
      font-size: 13px;
      font-weight: 700;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #fff;
      background: linear-gradient(135deg, #c2185b 0%, #e91e8c 40%, #ff6eb4 100%);
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition: transform .2s, box-shadow .2s;
      box-shadow: 0 4px 24px rgba(255,110,180,.45);
    }
    .btn-login::before {
      content: '';
      position: absolute; top: 0; left: -100%;
      width: 100%; height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,.2), transparent);
      transition: left .4s ease;
    }
    .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(255,110,180,.65); }
    .btn-login:hover::before { left: 100%; }
    .btn-login:active { transform: translateY(0); }

    /* ── DIVIDER ── */
    .divider {
      display: flex; align-items: center; gap: 12px;
      margin: 22px 0;
      font-size: 11px;
      letter-spacing: 3px;
      color: rgba(255,179,217,.35);
    }
    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(255,110,180,.25), transparent);
    }

    /* ── SOCIAL ── */
    .socials {
      display: flex; gap: 12px;
    }
    .social-btn {
      flex: 1; padding: 11px;
      background: rgba(255,255,255,.04);
      border: 1px solid rgba(255,110,180,.18);
      border-radius: 10px;
      color: rgba(255,255,255,.7);
      font-size: 18px;
      cursor: pointer;
      text-align: center;
      transition: background .2s, border-color .2s, color .2s, box-shadow .2s;
    }
    .social-btn:hover {
      background: rgba(255,110,180,.12);
      border-color: var(--sakura);
      color: var(--sakura-lt);
      box-shadow: 0 0 14px rgba(255,110,180,.25);
    }

    /* ── REGISTER LINK ── */
    .register-row {
      text-align: center;
      margin-top: 20px;
      font-size: 12px;
      color: rgba(255,179,217,.5);
      letter-spacing: 1px;
    }
    .register-row a {
      color: var(--sakura-lt);
      text-decoration: none;
      font-weight: 600;
      transition: color .2s, text-shadow .2s;
    }
    .register-row a:hover {
      color: var(--gold);
      text-shadow: 0 0 8px rgba(255,215,0,.4);
    }

  </style>
</head>
<body>

<!-- BACKGROUND SLIDES -->
<div id="bg-wrap">
  <div class="bg-slide active" id="slide-0" style="background-image: url('https://wallpapercave.com/wp/wp9076883.jpg'); background-size: cover; background-position: center;></div>
  <div class="bg-slide" id="slide-1"></div>
  <div class="bg-slide" id="slide-2"></div>
  <div class="bg-slide" id="slide-3"></div>
  <div class="bg-slide" id="slide-4"></div>
</div>

<div id="overlay"></div>

<!-- MAIN SCENE -->
<div id="scene">
  <div class="card">
    <div class="card-glow"></div>

    <!-- LOGO -->
    <div class="logo-wrap">
      <div class="logo-title">Wibudesu</div>
      <div class="logo-sub">Streaming Anime</div>
    </div>

    <!-- FIELDS -->
    <div class="field">
      <label>Email / Username</label>
      <div class="field-wrap">
        <span class="field-icon">✦</span>
        <input type="text" placeholder="Masukkan username..." />
      </div>
    </div>

    <div class="field">
      <label>Password</label>
      <div class="field-wrap">
        <span class="field-icon">🔐</span>
        <input type="password" placeholder="••••••••" />
      </div>
    </div>

    <!-- OPTIONS -->
    <div class="options">
      <label class="remember">
        <input type="checkbox" id="rememberMe" />
        <span class="chk-box" id="chkBox"></span>
        Ingat saya
      </label>
      <a href="#" class="forgot">Lupa password?</a>
    </div>

    <!-- BUTTON -->
    <button class="btn-login" onclick="handleLogin()">Masuk ✦</button>

    <!-- REGISTER -->
    <div class="register-row">
      Belum punya akun? <a href="#">Daftar sekarang</a>
    </div>
  </div>
</div>

<script>
  /* ── Checkbox visual ── */
  const rememberMe = document.getElementById('rememberMe');
  const chkBox = document.getElementById('chkBox');
  rememberMe.addEventListener('change', () => {
    chkBox.textContent = rememberMe.checked ? '✓' : '';
  });

  /* ── Login button ── */
  function handleLogin() {
    const btn = document.querySelector('.btn-login');
    btn.textContent = '⌛ Memuat...';
    btn.disabled = true;
    setTimeout(() => {
      btn.textContent = '✓ Selamat Datang!';
      btn.style.background = 'linear-gradient(135deg, #1b5e20, #2e7d32, #43a047)';
      setTimeout(() => {
        btn.textContent = 'Masuk ✦';
        btn.style.background = '';
        btn.disabled = false;
      }, 2000);
    }, 1400);
  }

  /* ── Slideshow ── */
  const slides = document.querySelectorAll('.bg-slide');
  let current  = 0;
  let timer;

  function goTo(n) {
    slides[current].classList.remove('active');
    current = n;
    slides[current].classList.add('active');
    resetTimer();
  }

  function next() { goTo((current + 1) % slides.length); }

  function resetTimer() {
    clearInterval(timer);
    timer = setInterval(next, 4000);
  }

  resetTimer();

  /* ── Sakura petals ── */
  for (let i = 0; i < 18; i++) {
    const p = document.createElement('div');
    p.className = 'petal';
    p.style.cssText = `
      left: ${Math.random()*100}%;
      top: ${Math.random()*-20}%;
      width: ${8 + Math.random()*8}px;
      height: ${10 + Math.random()*8}px;
      opacity: ${.4 + Math.random()*.5};
      animation-duration: ${6 + Math.random()*10}s;
      animation-delay: ${Math.random()*8}s;
      transform: rotate(${Math.random()*360}deg);
    `;
    document.body.appendChild(p);
  }

  /* ── Stars ── */
  for (let i = 0; i < 55; i++) {
    const s = document.createElement('div');
    s.className = 'star';
    s.style.cssText = `
      left: ${Math.random()*100}%;
      top:  ${Math.random()*100}%;
      width:  ${1 + Math.random()*2.5}px;
      height: ${1 + Math.random()*2.5}px;
      animation-duration: ${2 + Math.random()*3}s;
      animation-delay: ${Math.random()*4}s;
    `;
    document.body.appendChild(s);
  }
</script>
</body>
</html>