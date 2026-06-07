<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar — Anime Portal</title>
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
      --error:     #ff4f7b;
      --success:   #43a047;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Rajdhani', 'Noto Sans JP', sans-serif;
      min-height: 100vh;
      overflow-x: hidden;
      background: var(--indigo);
      color: #fff;
      cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Ccircle cx='12' cy='12' r='4' fill='%23ff6eb4' opacity='0.85'/%3E%3C/svg%3E") 12 12, auto;
    }

    /* ── BACKGROUND SLIDESHOW ── */
    #bg-wrap { position: fixed; inset: 0; z-index: 0; }
    .bg-slide {
      position: absolute; inset: 0;
      background-size: cover;
      background-position: center;
      opacity: 0;
      transition: opacity 1.2s cubic-bezier(.4,0,.2,1);
      will-change: opacity;
    }
    .bg-slide.active { opacity: 1; }

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

    /* ── Overlay ── */
    #overlay {
      position: fixed; inset: 0; z-index: 1;
      background: radial-gradient(ellipse at 50% 50%, rgba(15,5,35,.3) 0%, rgba(10,3,25,.75) 100%);
      pointer-events: none;
    }
    #overlay::after {
      content: '';
      position: absolute; inset: 0;
      background: repeating-linear-gradient(
        0deg, transparent, transparent 3px,
        rgba(255,110,180,.025) 3px, rgba(255,110,180,.025) 4px
      );
      pointer-events: none;
    }

    /* ── SAKURA PETALS ── */
    .petal {
      position: fixed; z-index: 2;
      border-radius: 50% 0 50% 0;
      background: linear-gradient(135deg, #ffb3d9, #ff6eb4);
      opacity: 0; pointer-events: none;
      animation: fall linear infinite;
    }
    @keyframes fall {
      0%   { transform: translateY(-20px) rotate(0deg); opacity: .9; }
      100% { transform: translateY(110vh) rotate(720deg); opacity: 0; }
    }

    /* ── STARS ── */
    .star {
      position: fixed; z-index: 2;
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

    /* ── REGISTER CARD ── */
    .card {
      width: 100%;
      max-width: 460px;
      background: var(--glass-bg);
      border: 1px solid var(--glass-bdr);
      border-radius: 20px;
      padding: 44px 40px 38px;
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

    .card::before, .card::after {
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

    .card-glow {
      position: absolute;
      top: -1px; left: 50%; transform: translateX(-50%);
      width: 160px; height: 2px;
      background: linear-gradient(90deg, transparent, var(--sakura), transparent);
      border-radius: 50%;
      box-shadow: 0 0 18px 4px rgba(255,110,180,.6);
    }

    /* ── LOGO ── */
    .logo-wrap {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 6px;
      margin-bottom: 8px;
    }
    .logo-title {
      font-family: 'Cinzel Decorative', serif;
      font-size: 24px;
      font-weight: 900;
      letter-spacing: 4px;
      text-transform: uppercase;
      background: linear-gradient(135deg, #fff 0%, var(--sakura-lt) 50%, var(--sakura) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .logo-sub {
      font-size: 11px;
      letter-spacing: 5px;
      text-transform: uppercase;
      color: rgba(255,179,217,.55);
    }

    /* ── PAGE TITLE ── */
    .page-title {
      text-align: center;
      margin-bottom: 26px;
      margin-top: 10px;
    }
    .page-title h2 {
      font-family: 'Cinzel Decorative', serif;
      font-size: 13px;
      font-weight: 700;
      letter-spacing: 4px;
      text-transform: uppercase;
      color: rgba(255, 179, 217, 0.75);
    }
    .page-title-line {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 6px;
      justify-content: center;
    }
    .page-title-line span {
      display: block;
      width: 40px; height: 1px;
      background: linear-gradient(90deg, transparent, rgba(255,110,180,.5));
    }
    .page-title-line span:last-child {
      background: linear-gradient(90deg, rgba(255,110,180,.5), transparent);
    }
    .page-title-line .sakura-dot {
      width: 6px; height: 6px;
      background: var(--sakura);
      border-radius: 50%;
      box-shadow: 0 0 8px rgba(255,110,180,.8);
      display: block;
    }

    /* ── FORM GRID ── */
    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0 16px;
    }
    .field { margin-bottom: 16px; }
    .field.full { grid-column: 1 / -1; }

    .field label {
      display: block;
      font-size: 11px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: rgba(255,179,217,.7);
      margin-bottom: 7px;
    }
    .field-wrap { position: relative; }
    .field-icon {
      position: absolute;
      left: 13px; top: 50%;
      transform: translateY(-50%);
      font-size: 15px;
      opacity: .6;
      pointer-events: none;
      line-height: 1;
    }

    .field input {
      width: 100%;
      padding: 12px 38px 12px 40px;
      background: rgba(255,255,255,.05);
      border: 1px solid rgba(255,110,180,.2);
      border-radius: 10px;
      color: #fff;
      font-family: 'Rajdhani', sans-serif;
      font-size: 14px;
      font-weight: 500;
      letter-spacing: .5px;
      outline: none;
      transition: border-color .25s, box-shadow .25s, background .25s;
    }
    .field input::placeholder { color: rgba(255,255,255,.22); }
    .field input:focus {
      border-color: var(--sakura);
      background: rgba(255,110,180,.06);
      box-shadow: 0 0 0 3px rgba(255,110,180,.15), 0 0 18px rgba(255,110,180,.12);
    }
    .field input.error {
      border-color: var(--error);
      box-shadow: 0 0 0 3px rgba(255,79,123,.15);
    }
    .field input.valid {
      border-color: #43e097;
      box-shadow: 0 0 0 3px rgba(67,224,151,.12);
    }

    /* password toggle */
    .toggle-pw {
      position: absolute;
      right: 13px; top: 50%;
      transform: translateY(-50%);
      background: none; border: none;
      color: rgba(255,179,217,.5);
      cursor: pointer;
      font-size: 15px;
      padding: 0;
      line-height: 1;
      transition: color .2s;
    }
    .toggle-pw:hover { color: var(--sakura); }

    /* validation hint */
    .hint {
      font-size: 11px;
      letter-spacing: .5px;
      margin-top: 5px;
      min-height: 16px;
      transition: color .2s;
      color: rgba(255,79,123,.0);
    }
    .hint.show-error { color: var(--error); }
    .hint.show-ok    { color: #43e097; }

    /* ── PASSWORD STRENGTH ── */
    .pw-strength {
      margin-top: 7px;
      display: flex;
      gap: 4px;
      align-items: center;
    }
    .pw-bar {
      flex: 1; height: 3px;
      background: rgba(255,255,255,.1);
      border-radius: 99px;
      transition: background .3s;
    }
    .pw-bar.active-weak   { background: #ff4f7b; }
    .pw-bar.active-medium { background: var(--gold); }
    .pw-bar.active-strong { background: #43e097; }
    .pw-label {
      font-size: 10px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: rgba(255,179,217,.5);
      min-width: 48px;
      text-align: right;
      transition: color .3s;
    }

    /* ── SYARAT CHECKBOX ── */
    .terms-row {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin-bottom: 20px;
      font-size: 12px;
      color: rgba(255,179,217,.6);
      letter-spacing: .5px;
      line-height: 1.5;
      cursor: pointer;
    }
    .terms-row input[type=checkbox] { display: none; }
    .chk-box {
      width: 17px; height: 17px;
      min-width: 17px;
      border: 1px solid rgba(255,110,180,.4);
      border-radius: 4px;
      display: flex; align-items: center; justify-content: center;
      font-size: 10px;
      transition: background .2s, border-color .2s;
      margin-top: 1px;
    }
    .terms-row input:checked + .chk-box {
      background: var(--sakura);
      border-color: var(--sakura);
    }
    .terms-row a {
      color: var(--sakura-lt);
      text-decoration: none;
      transition: color .2s;
    }
    .terms-row a:hover { color: var(--gold); }

    /* ── BUTTON ── */
    .btn-register {
      width: 100%;
      padding: 15px;
      border: none;
      border-radius: 10px;
      font-family: 'Cinzel Decorative', serif;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #fff;
      background: linear-gradient(135deg, #c2185b 0%, #e91e8c 40%, #ff6eb4 100%);
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition: transform .2s, box-shadow .2s, opacity .2s;
      box-shadow: 0 4px 24px rgba(255,110,180,.45);
    }
    .btn-register::before {
      content: '';
      position: absolute; top: 0; left: -100%;
      width: 100%; height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,.2), transparent);
      transition: left .4s ease;
    }
    .btn-register:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(255,110,180,.65); }
    .btn-register:hover:not(:disabled)::before { left: 100%; }
    .btn-register:active:not(:disabled) { transform: translateY(0); }
    .btn-register:disabled { opacity: .55; cursor: not-allowed; }

    /* ── DIVIDER ── */
    .divider {
      display: flex; align-items: center; gap: 12px;
      margin: 20px 0 16px;
      font-size: 11px;
      letter-spacing: 3px;
      color: rgba(255,179,217,.35);
    }
    .divider::before, .divider::after {
      content: '';
      flex: 1; height: 1px;
      background: linear-gradient(90deg, transparent, rgba(255,110,180,.25), transparent);
    }

    /* ── LOGIN LINK ── */
    .login-row {
      text-align: center;
      margin-top: 16px;
      font-size: 12px;
      color: rgba(255,179,217,.5);
      letter-spacing: 1px;
    }
    .login-row a {
      color: var(--sakura-lt);
      text-decoration: none;
      font-weight: 600;
      transition: color .2s, text-shadow .2s;
    }
    .login-row a:hover {
      color: var(--gold);
      text-shadow: 0 0 8px rgba(255,215,0,.4);
    }

    /* ── SUCCESS OVERLAY ── */
    .success-overlay {
      position: absolute; inset: 0;
      background: rgba(10,3,25,.92);
      border-radius: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 12px;
      opacity: 0;
      pointer-events: none;
      transition: opacity .4s;
      z-index: 20;
    }
    .success-overlay.show { opacity: 1; pointer-events: all; }
    .success-icon {
      font-size: 52px;
      animation: popIn .5s cubic-bezier(.22,1,.36,1) both;
    }
    @keyframes popIn {
      from { transform: scale(0) rotate(-20deg); }
      to   { transform: scale(1) rotate(0); }
    }
    .success-msg {
      font-family: 'Cinzel Decorative', serif;
      font-size: 14px;
      letter-spacing: 3px;
      color: var(--sakura-lt);
      text-align: center;
    }
    .success-sub {
      font-size: 12px;
      letter-spacing: 2px;
      color: rgba(255,179,217,.5);
      text-align: center;
    }

    /* ── DATE INPUT custom ── */
    input[type="date"]::-webkit-calendar-picker-indicator {
      filter: invert(1) sepia(1) saturate(2) hue-rotate(280deg);
      opacity: .5;
      cursor: pointer;
    }
  </style>
</head>
<body>

<!-- BACKGROUND -->
<div id="bg-wrap">
  <div class="bg-slide active"></div>
  <div class="bg-slide"></div>
  <div class="bg-slide"></div>
  <div class="bg-slide"></div>
  <div class="bg-slide"></div>
</div>
<div id="overlay"></div>

<!-- SCENE -->
<div id="scene">
  <div class="card">
    <div class="card-glow"></div>

    <!-- SUCCESS OVERLAY -->
    <div class="success-overlay" id="successOverlay">
      <div class="success-icon">✿</div>
      <div class="success-msg">Pendaftaran Berhasil!</div>
      <div class="success-sub">Selamat bergabung di Wibudesu ✦</div>
    </div>

    <!-- LOGO -->
    <div class="logo-wrap">
      <div class="logo-title">Wibudesu</div>
      <div class="logo-sub">Streaming Anime</div>
    </div>

    <div class="page-title">
      <h2>Buat Akun Baru</h2>
      <div class="page-title-line">
        <span></span>
        <span class="sakura-dot"></span>
        <span></span>
      </div>
    </div>

    <!-- FORM -->
    <form action="/register" method="POST">
      @csrf
    <div class="form-grid">

      <!-- USERNAME -->
      <div class="field">
        <label>Username</label>
        <div class="field-wrap">
          <span class="field-icon">✦</span>
          <input type="text" id="username" placeholder="username kamu..." autocomplete="off" oninput="validateUsername()" />
        </div>
        <div class="hint" id="hintUsername"></div>
      </div>

      <!-- TANGGAL LAHIR -->
      <div class="field">
        <label>Tanggal Lahir</label>
        <div class="field-wrap">
          <span class="field-icon">🌸</span>
          <input type="date" id="birthdate" oninput="validateBirthdate()" />
        </div>
        <div class="hint" id="hintBirthdate"></div>
      </div>

      <!-- EMAIL -->
      <div class="field full">
        <label>Email</label>
        <div class="field-wrap">
          <span class="field-icon">✉</span>
          <input type="email" id="email" placeholder="email@contoh.com" autocomplete="off" oninput="validateEmail()" />
        </div>
        <div class="hint" id="hintEmail"></div>
      </div>

      <!-- PASSWORD -->
      <div class="field full">
        <label>Password</label>
        <div class="field-wrap">
          <span class="field-icon">🔐</span>
          <input type="password" id="password" placeholder="••••••••" oninput="validatePassword()" />
          <button class="toggle-pw" type="button" onclick="togglePw('password', this)" tabindex="-1">👁</button>
        </div>
        <div class="pw-strength" id="pwStrength">
          <div class="pw-bar" id="bar1"></div>
          <div class="pw-bar" id="bar2"></div>
          <div class="pw-bar" id="bar3"></div>
          <div class="pw-bar" id="bar4"></div>
          <span class="pw-label" id="pwLabel"></span>
        </div>
        <div class="hint" id="hintPassword"></div>
      </div>

      <!-- CONFIRM PASSWORD -->
      <div class="field full">
        <label>Konfirmasi Password</label>
        <div class="field-wrap">
          <span class="field-icon">🔑</span>
          <input type="password" id="confirmPassword" placeholder="••••••••" oninput="validateConfirm()" />
          <button class="toggle-pw" type="button" onclick="togglePw('confirmPassword', this)" tabindex="-1">👁</button>
        </div>
        <div class="hint" id="hintConfirm"></div>
      </div>

    </div>

    <!-- TERMS -->
    <label class="terms-row">
      <input type="checkbox" id="terms" onchange="checkForm()" />
      <span class="chk-box" id="chkTerms"></span>
      <span>Saya setuju dengan <a href="#">Syarat & Ketentuan</a> dan <a href="#">Kebijakan Privasi</a> Wibudesu</span>
    </label>

    <!-- BUTTON -->
    <button class="btn-register" id="btnRegister" disabled onclick="handleRegister()">Daftar Sekarang ✦</button>

    <div class="divider">atau</div>

    <!-- LOGIN LINK -->
    <div class="login-row">
      Sudah punya akun? <a href="/login">Masuk sekarang</a>
    </div>

  </div>
</div>
</form>

<script>
  /* ── Slideshow ── */
  const slides = document.querySelectorAll('.bg-slide');
  let current = 0, timer;
  function goTo(n) {
    slides[current].classList.remove('active');
    current = n;
    slides[current].classList.add('active');
    clearInterval(timer);
    timer = setInterval(() => goTo((current+1)%slides.length), 4000);
  }
  timer = setInterval(() => goTo((current+1)%slides.length), 4000);

  /* ── Sakura petals ── */
  for (let i = 0; i < 18; i++) {
    const p = document.createElement('div');
    p.className = 'petal';
    p.style.cssText = `
      left:${Math.random()*100}%;top:${Math.random()*-20}%;
      width:${8+Math.random()*8}px;height:${10+Math.random()*8}px;
      opacity:${.4+Math.random()*.5};
      animation-duration:${6+Math.random()*10}s;
      animation-delay:${Math.random()*8}s;
      transform:rotate(${Math.random()*360}deg);`;
    document.body.appendChild(p);
  }

  /* ── Stars ── */
  for (let i = 0; i < 55; i++) {
    const s = document.createElement('div');
    s.className = 'star';
    s.style.cssText = `
      left:${Math.random()*100}%;top:${Math.random()*100}%;
      width:${1+Math.random()*2.5}px;height:${1+Math.random()*2.5}px;
      animation-duration:${2+Math.random()*3}s;
      animation-delay:${Math.random()*4}s;`;
    document.body.appendChild(s);
  }

  /* ── Checkbox visual ── */
  document.getElementById('terms').addEventListener('change', function() {
    document.getElementById('chkTerms').textContent = this.checked ? '✓' : '';
    checkForm();
  });

  /* ── Toggle password ── */
  function togglePw(id, btn) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
    btn.textContent = inp.type === 'password' ? '👁' : '🙈';
  }

  /* ── Validators ── */
  function setField(id, hintId, state, msg) {
    const inp = document.getElementById(id);
    const hint = document.getElementById(hintId);
    inp.classList.remove('error','valid');
    hint.classList.remove('show-error','show-ok');
    if (state === 'error') { inp.classList.add('error'); hint.classList.add('show-error'); }
    if (state === 'valid') { inp.classList.add('valid'); hint.classList.add('show-ok'); }
    hint.textContent = msg || '';
    checkForm();
  }

  function validateUsername() {
    const v = document.getElementById('username').value.trim();
    if (!v) return setField('username','hintUsername','','');
    if (v.length < 3) return setField('username','hintUsername','error','Min. 3 karakter');
    if (!/^[a-zA-Z0-9_.]+$/.test(v)) return setField('username','hintUsername','error','Hanya huruf, angka, _ dan .');
    setField('username','hintUsername','valid','Username tersedia ✓');
  }

  function validateEmail() {
    const v = document.getElementById('email').value.trim();
    if (!v) return setField('email','hintEmail','','');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) return setField('email','hintEmail','error','Format email tidak valid');
    setField('email','hintEmail','valid','Email valid ✓');
  }

  function validateBirthdate() {
    const v = document.getElementById('birthdate').value;
    if (!v) return setField('birthdate','hintBirthdate','','');
    const today = new Date();
    const birth = new Date(v);
    let age = today.getFullYear() - birth.getFullYear();
    const m = today.getMonth() - birth.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
    if (age < 13) return setField('birthdate','hintBirthdate','error','Minimal usia 13 tahun');
    if (age > 120) return setField('birthdate','hintBirthdate','error','Tanggal tidak valid');
    setField('birthdate','hintBirthdate','valid',`Usia ${age} tahun ✓`);
  }

  function validatePassword() {
    const v = document.getElementById('password').value;
    const bars = [document.getElementById('bar1'),document.getElementById('bar2'),
                  document.getElementById('bar3'),document.getElementById('bar4')];
    const lbl = document.getElementById('pwLabel');
    bars.forEach(b => b.className = 'pw-bar');

    if (!v) { lbl.textContent = ''; return setField('password','hintPassword','',''); }

    let score = 0;
    if (v.length >= 8) score++;
    if (/[A-Z]/.test(v)) score++;
    if (/[0-9]/.test(v)) score++;
    if (/[^A-Za-z0-9]/.test(v)) score++;

    const cls = score <= 1 ? 'active-weak' : score <= 2 ? 'active-medium' : 'active-strong';
    const labels = ['','Lemah','Sedang','Kuat','Sangat Kuat'];
    const lbMap = {1:'Lemah',2:'Sedang',3:'Kuat',4:'Sangat Kuat'};

    for (let i = 0; i < score; i++) bars[i].classList.add(cls);
    lbl.textContent = lbMap[score] || '';
    lbl.style.color = score <= 1 ? 'var(--error)' : score <= 2 ? 'var(--gold)' : '#43e097';

    if (v.length < 8) return setField('password','hintPassword','error','Min. 8 karakter');
    setField('password','hintPassword','valid','');
    if (document.getElementById('confirmPassword').value) validateConfirm();
  }

  function validateConfirm() {
    const pw = document.getElementById('password').value;
    const cp = document.getElementById('confirmPassword').value;
    if (!cp) return setField('confirmPassword','hintConfirm','','');
    if (cp !== pw) return setField('confirmPassword','hintConfirm','error','Password tidak cocok');
    setField('confirmPassword','hintConfirm','valid','Password cocok ✓');
  }

  /* ── Check all valid to enable button ── */
  function checkForm() {
    const u = document.getElementById('username').classList.contains('valid');
    const e = document.getElementById('email').classList.contains('valid');
    const b = document.getElementById('birthdate').classList.contains('valid');
    const p = document.getElementById('password').classList.contains('valid');
    const c = document.getElementById('confirmPassword').classList.contains('valid');
    const t = document.getElementById('terms').checked;
    document.getElementById('btnRegister').disabled = !(u && e && b && p && c && t);
  }

  /* ── Register handler ── */
  function handleRegister() {
    const btn = document.getElementById('btnRegister');
    btn.textContent = '⌛ Mendaftarkan...';
    btn.disabled = true;
    setTimeout(() => {
      document.getElementById('successOverlay').classList.add('show');
      setTimeout(() => {
        document.getElementById('successOverlay').classList.remove('show');
        btn.textContent = 'Daftar Sekarang ✦';
        btn.disabled = false;
      }, 3000);
    }, 1600);
  }
</script>
</body>
</html>