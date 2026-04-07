<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BlockAid – Login & Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            syne: ['Syne', 'sans-serif'],
            dm: ['DM Sans', 'sans-serif'],
          },
          colors: {
            primary: { DEFAULT: '#1a5cff', dark: '#1044cc', light: '#4a82ff' },
            accent:  { DEFAULT: '#00d4aa', dark: '#00a882' },
            dark:    { DEFAULT: '#0d1b3e', mid: '#1e2f5a' },
          },
          boxShadow: {
            glass: '0 8px 32px rgba(13,27,62,0.18)',
            card:  '0 4px 24px rgba(13,27,62,0.10)',
          },
        }
      }
    }
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'DM Sans', sans-serif; }
    h1, h2, h3, .font-syne { font-family: 'Syne', sans-serif; }

    .bg-mesh {
      background-color: #0d1b3e;
      background-image:
        radial-gradient(ellipse at 20% 50%, rgba(26,92,255,0.35) 0%, transparent 55%),
        radial-gradient(ellipse at 80% 20%, rgba(0,212,170,0.22) 0%, transparent 50%),
        radial-gradient(ellipse at 60% 80%, rgba(26,92,255,0.18) 0%, transparent 50%);
    }
    .dot-pattern {
      background-image: radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px);
      background-size: 28px 28px;
    }
    .glass-card {
      background: rgba(255,255,255,0.97);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
    }
    .tab-active {
      background: #1a5cff;
      color: #ffffff;
      box-shadow: 0 4px 14px rgba(26,92,255,0.35);
    }
    .tab-inactive {
      background: transparent;
      color: #6b7a9e;
    }
    .tab-inactive:hover { color: #1a5cff; background: rgba(26,92,255,0.06); }

    .form-input {
      width: 100%;
      padding: 0.65rem 1rem;
      border: 1.5px solid #dce3f0;
      border-radius: 0.6rem;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.9rem;
      color: #2c3e6b;
      background: #f8faff;
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }
    .form-input:focus {
      border-color: #1a5cff;
      box-shadow: 0 0 0 3px rgba(26,92,255,0.1);
      background: #fff;
    }
    .form-input::placeholder { color: #b0bacf; }
    .form-label {
      display: block;
      font-size: 0.8rem;
      font-weight: 600;
      color: #2c3e6b;
      margin-bottom: 0.35rem;
      font-family: 'DM Sans', sans-serif;
    }
    .form-group { margin-bottom: 1.1rem; }

    .field-slide {
      overflow: hidden;
      transition: max-height 0.38s cubic-bezier(.4,0,.2,1), opacity 0.3s ease;
    }
    .field-slide.hidden-field { max-height: 0 !important; opacity: 0; pointer-events: none; }
    .field-slide.visible-field { opacity: 1; pointer-events: auto; }

    .btn-primary {
      width: 100%;
      padding: 0.78rem;
      background: #1a5cff;
      color: #fff;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.95rem;
      font-weight: 600;
      border-radius: 0.65rem;
      border: none;
      cursor: pointer;
      transition: background .2s, transform .15s, box-shadow .2s;
      box-shadow: 0 4px 14px rgba(26,92,255,0.35);
    }
    .btn-primary:hover { background: #1044cc; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(26,92,255,0.42); }
    .btn-primary:active { transform: translateY(0); }

    .error-msg {
      font-size: 0.75rem;
      color: #e53e3e;
      margin-top: 0.25rem;
      display: none;
    }
    .error-msg.show { display: block; }
    .input-error { border-color: #e53e3e !important; }
    .input-error:focus { box-shadow: 0 0 0 3px rgba(229,62,62,0.12) !important; }

    .success-toast {
      position: fixed; top: 1.5rem; right: 1.5rem; z-index: 9999;
      background: #00c37a; color: #fff;
      padding: .75rem 1.5rem; border-radius: .75rem;
      font-weight: 600; font-size: .875rem;
      box-shadow: 0 4px 20px rgba(0,195,122,.35);
      transform: translateY(-10px); opacity: 0;
      transition: all .35s ease;
      pointer-events: none;
    }
    .success-toast.show { transform: translateY(0); opacity: 1; }

    /* custom checkbox */
    .custom-check { accent-color: #1a5cff; width: 15px; height: 15px; cursor: pointer; }

    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #dce3f0; border-radius: 10px; }
  </style>
</head>
<body class="min-h-screen bg-mesh flex items-center justify-center p-4 lg:p-8">

<!-- Success toast -->
<div id="successToast" class="success-toast">✓ Action successful!</div>

<!-- ── MAIN WRAPPER ── -->
<div class="w-full max-w-5xl mx-auto flex rounded-2xl overflow-hidden shadow-glass" style="min-height:580px;">

  <!-- ── LEFT BRANDING PANEL (lg+) ── -->
  <div class="hidden lg:flex lg:w-5/12 flex-col justify-between p-10 relative overflow-hidden bg-mesh dot-pattern">
    <!-- Decorative circles -->
    <div class="absolute -top-20 -left-20 w-64 h-64 rounded-full opacity-10" style="background:radial-gradient(circle,#00d4aa,transparent)"></div>
    <div class="absolute -bottom-16 -right-16 w-80 h-80 rounded-full opacity-10" style="background:radial-gradient(circle,#1a5cff,transparent)"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full opacity-5" style="background:radial-gradient(circle,#fff,transparent)"></div>

    <!-- Logo -->
    <div class="relative z-10">
      <div class="flex items-center gap-3 mb-2">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl"><img src="img/blockaid_logo.png" alt="" srcset=""></div>
        <span class="font-syne text-2xl font-extrabold text-white">BlockAid</span>
      </div>
      
    </div>

    <!-- Tagline + Features -->
    <div class="relative z-10 flex flex-col gap-6">
      <div>
        <h2 class="font-syne text-3xl font-extrabold text-white leading-tight mb-3">
          Donate with Proof.<br/>
          <span style="color:#00d4aa;">Track with Transparency.</span>
        </h2>
        <p class="text-sm leading-relaxed" style="color:rgba(255,255,255,.55);">
          Every donation verified. Every record immutable. BlockAid uses blockchain to ensure your charity contributions create real, traceable impact.
        </p>
      </div>

      <div class="flex flex-col gap-3">
        <div class="flex items-center gap-3 text-sm" style="color:rgba(255,255,255,.75);">
          <div class="w-7 h-7 rounded-lg flex items-center justify-center text-base flex-shrink-0" style="background:rgba(0,212,170,.15);border:1px solid rgba(0,212,170,.25)">✅</div>
          <span>Admin-verified donation requests</span>
        </div>
        <div class="flex items-center gap-3 text-sm" style="color:rgba(255,255,255,.75);">
          <div class="w-7 h-7 rounded-lg flex items-center justify-center text-base flex-shrink-0" style="background:rgba(26,92,255,.15);border:1px solid rgba(26,92,255,.25)">🔐</div>
          <span>SHA-256 document hashing</span>
        </div>
        <div class="flex items-center gap-3 text-sm" style="color:rgba(255,255,255,.75);">
          <div class="w-7 h-7 rounded-lg flex items-center justify-center text-base flex-shrink-0" style="background:rgba(0,212,170,.15);border:1px solid rgba(0,212,170,.25)">🌐</div>
          <span>Public immutable blockchain ledger</span>
        </div>
      </div>
    </div>

    <!-- Bottom badge -->
    <div class="relative z-10 flex items-center gap-2 text-xs" style="color:rgba(255,255,255,.35);">
      <span class="inline-block w-2 h-2 rounded-full animate-pulse" style="background:#00d4aa;"></span>
      Blockchain network active
    </div>
  </div>

  <!-- ── RIGHT FORM PANEL ── -->
  <div class="glass-card flex-1 flex flex-col p-7 sm:p-10 overflow-y-auto" style="max-height:90vh;">

    <!-- Mobile logo -->
    <div class="lg:hidden flex items-center gap-2 mb-6">
      <div class="w-8 h-8 rounded-lg flex items-center justify-center text-lg" style="background:linear-gradient(135deg,#1a5cff,#00d4aa)">⛓</div>
      <span class="font-syne text-xl font-extrabold" style="color:#0d1b3e;">BlockAid</span>
    </div>

    <!-- Heading -->
    <div class="mb-6">
      <h1 id="formHeading" class="font-syne text-2xl font-extrabold" style="color:#0d1b3e;">Welcome back</h1>
      <p id="formSubheading" class="text-sm mt-1" style="color:#6b7a9e;">Sign in to your BlockAid account</p>
    </div>

    <!-- Tab Toggle -->
    <div class="flex gap-1 p-1 rounded-xl mb-7" style="background:#f0f4ff;">
      <button id="tabLogin" onclick="switchTab('login')" class="flex-1 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 tab-active" style="font-family:'DM Sans',sans-serif;">
        Log In
      </button>
      <button id="tabRegister" onclick="switchTab('register')" class="flex-1 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 tab-inactive" style="font-family:'DM Sans',sans-serif;">
        Register
      </button>
    </div>

    <!-- ═══════════ LOGIN FORM ═══════════ -->
    <form id="loginForm" onsubmit="handleLogin(event)" novalidate autocomplete="on">

      <div class="form-group">
        <label class="form-label" for="login_email">Username</label>
        <input class="form-input" type="text" id="login_email" name="login_email"
          placeholder="Enter your username" required autocomplete="username" />
        <span class="error-msg" id="err_login_username">Please enter your username.</span>
      </div>

      <div class="form-group">
        <label class="form-label" for="login_password">Password</label>
        <div class="relative">
          <input class="form-input pr-10" type="password" id="login_password" name="login_password"
            placeholder="Enter your password" required autocomplete="current-password" />
          <button type="button" onclick="togglePwd('login_password', this)"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary text-lg focus:outline-none">
            👁
          </button>
        </div>
        <span class="error-msg" id="err_login_password">Please enter your password.</span>
      </div>

      <div class="flex items-center justify-between mb-5 mt-1">
        <label class="flex items-center gap-2 text-sm cursor-pointer" style="color:#6b7a9e;">
          <input type="checkbox" name="remember_me" class="custom-check" />
          Remember me
        </label>
        <a href="#" class="text-sm font-semibold hover:underline" style="color:#1a5cff;">Forgot password?</a>
      </div>

      <button type="submit" class="btn-primary">Sign In →</button>

      <p class="text-center text-sm mt-5" style="color:#6b7a9e;">
        Don't have an account?
        <button type="button" onclick="switchTab('register')" class="font-semibold hover:underline focus:outline-none" style="color:#1a5cff;">Create one</button>
      </p>
    </form>

    <!-- ═══════════ REGISTER FORM ═══════════ -->
    <form id="registerForm" class="hidden" onsubmit="handleRegister(event)" action="registerback.php" method="POST" novalidate autocomplete="off">

      <!-- Account Type -->
      <div class="form-group">
        <label class="form-label" for="account_type">Account Type <span style="color:#e53e3e;">*</span></label>
        <select class="form-input" id="account_type" name="account_type" onchange="switchAccountType(this.value)" required>
          <option value="" disabled selected>Select account type…</option>
          <option value="person">👤 Person</option>
          <option value="organization">🏢 Organization</option>
        </select>
        <span class="error-msg" id="err_account_type">Please select an account type.</span>
      </div>

      <!-- ── PERSON FIELDS ── -->
      <div id="personFields" class="field-slide hidden-field" style="max-height:0;">
        <div class="form-group">
          <label class="form-label" for="full_name">Full Name <span style="color:#e53e3e;">*</span></label>
          <input class="form-input" type="text" id="full_name" name="full_name" placeholder="e.g. Ahmad bin Ibrahim" autocomplete="name" />
          <span class="error-msg" id="err_full_name">Full name is required.</span>
        </div>
        <div class="form-group">
          <label class="form-label" for="p_email">Email Address <span style="color:#e53e3e;">*</span></label>
          <input class="form-input" type="email" id="p_email" name="person_email" placeholder="you@example.com" autocomplete="email" />
          <span class="error-msg" id="err_p_email">A valid email is required.</span>
        </div>
        <div class="form-group">
          <label class="form-label" for="p_phone">Phone Number <span style="color:#e53e3e;">*</span></label>
          <input class="form-input" type="tel" id="p_phone" name="phone" placeholder="+60 12-345 6789" autocomplete="tel" />
          <span class="error-msg" id="err_p_phone">Phone number is required.</span>
        </div>
      </div>

      <!-- ── ORGANIZATION FIELDS ── -->
      <div id="orgFields" class="field-slide hidden-field" style="max-height:0;">
        <div class="form-group">
          <label class="form-label" for="organization_name">Organization Name <span style="color:#e53e3e;">*</span></label>
          <input class="form-input" type="text" id="organization_name" name="organization_name" placeholder="e.g. Yayasan Cahaya Harapan" />
          <span class="error-msg" id="err_organization_name">Organization name is required.</span>
        </div>
        <div class="form-group">
          <label class="form-label" for="organization_type">Organization Type <span style="color:#e53e3e;">*</span></label>
          <select class="form-input" id="organization_type" name="organization_type">
            <option value="" disabled selected>Select type…</option>
            <option value="temple">🛕 Temple</option>
            <option value="elders_home">🏠 Elders Home</option>
            <option value="ngo">🤝 NGO</option>
            <option value="school">🏫 School</option>
          </select>
          <span class="error-msg" id="err_organization_type">Please select an organization type.</span>
        </div>
        <div class="form-group">
          <label class="form-label" for="registration_number">Registration Number <span style="color:#e53e3e;">*</span></label>
          <input class="form-input" type="text" id="registration_number" name="registration_number" placeholder="e.g. RON-12345-K" />
          <span class="error-msg" id="err_registration_number">Registration number is required.</span>
        </div>
        <div class="form-group">
          <label class="form-label" for="responsible_person">Responsible Person Name <span style="color:#e53e3e;">*</span></label>
          <input class="form-input" type="text" id="responsible_person" name="responsible_person" placeholder="Full legal name of PIC" />
          <span class="error-msg" id="err_responsible_person">Responsible person name is required.</span>
        </div>
        <div class="form-group">
          <label class="form-label" for="o_email">Official Email <span style="color:#e53e3e;">*</span></label>
          <input class="form-input" type="email" id="o_email" name="org_email" placeholder="office@organization.org" />
          <span class="error-msg" id="err_o_email">A valid email is required.</span>
        </div>
        <div class="form-group">
          <label class="form-label" for="o_phone">Phone Number <span style="color:#e53e3e;">*</span></label>
          <input class="form-input" type="tel" id="o_phone" name="phone" placeholder="+60 3-1234 5678" />
          <span class="error-msg" id="err_o_phone">Phone number is required.</span>
        </div>
      </div>

      <!-- ── SHARED PASSWORD FIELDS ── -->
      <div id="passwordFields" class="field-slide hidden-field" style="max-height:0;">
        <div class="form-group">
          <label class="form-label" for="reg_password">Password <span style="color:#e53e3e;">*</span></label>
          <div class="relative">
            <input class="form-input pr-10" type="password" id="reg_password" name="password"
              placeholder="Min. 8 characters" oninput="checkStrength(this.value)" />
            <button type="button" onclick="togglePwd('reg_password', this)"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary text-lg focus:outline-none">👁</button>
          </div>
          <!-- Strength bar -->
          <div class="flex gap-1 mt-2" id="strengthBar">
            <div class="h-1 flex-1 rounded-full transition-all duration-300" id="sb1" style="background:#dce3f0;"></div>
            <div class="h-1 flex-1 rounded-full transition-all duration-300" id="sb2" style="background:#dce3f0;"></div>
            <div class="h-1 flex-1 rounded-full transition-all duration-300" id="sb3" style="background:#dce3f0;"></div>
            <div class="h-1 flex-1 rounded-full transition-all duration-300" id="sb4" style="background:#dce3f0;"></div>
          </div>
          <p id="strengthLabel" class="text-xs mt-1" style="color:#b0bacf;"></p>
          <span class="error-msg" id="err_reg_password">Password must be at least 8 characters.</span>
        </div>

        <div class="form-group">
          <label class="form-label" for="confirm_password">Confirm Password <span style="color:#e53e3e;">*</span></label>
          <div class="relative">
            <input class="form-input pr-10" type="password" id="confirm_password" name="confirm_password"
              placeholder="Repeat your password" />
            <button type="button" onclick="togglePwd('confirm_password', this)"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary text-lg focus:outline-none">👁</button>
          </div>
          <span class="error-msg" id="err_confirm_password">Passwords do not match.</span>
        </div>

        <div class="mb-5">
          <label class="flex items-start gap-2 text-sm cursor-pointer" style="color:#6b7a9e;">
            <input type="checkbox" id="agreeTerms" name="agree_terms" class="custom-check mt-0.5 flex-shrink-0" />
            <span>I agree to BlockAid's <a href="#" class="font-semibold hover:underline" style="color:#1a5cff;">Terms of Service</a> and <a href="#" class="font-semibold hover:underline" style="color:#1a5cff;">Privacy Policy</a></span>
          </label>
          <span class="error-msg" id="err_terms">You must agree to the terms.</span>
        </div>

        <button type="submit" class="btn-primary">Create Account →</button>
      </div>

      <p class="text-center text-sm mt-5" style="color:#6b7a9e;">
        Already have an account?
        <button type="button" onclick="switchTab('login')" class="font-semibold hover:underline focus:outline-none" style="color:#1a5cff;">Sign in</button>
      </p>
    </form>

  </div><!-- end form panel -->
</div><!-- end main wrapper -->


<script>
  // ── CONSTANTS ────────────────────────────────────────
  const PERSON_MAX_H   = '700px';
  const ORG_MAX_H      = '900px';
  const PWD_MAX_H      = '340px';

  // ── TAB SWITCHING ─────────────────────────────────────
  function switchTab(tab) {
    const loginForm     = document.getElementById('loginForm');
    const registerForm  = document.getElementById('registerForm');
    const tabLogin      = document.getElementById('tabLogin');
    const tabRegister   = document.getElementById('tabRegister');
    const heading       = document.getElementById('formHeading');
    const subheading    = document.getElementById('formSubheading');

    clearAllErrors();

    if (tab === 'login') {
      loginForm.classList.remove('hidden');
      registerForm.classList.add('hidden');
      tabLogin.className = tabLogin.className.replace('tab-inactive','') + ' tab-active';
      tabRegister.className = tabRegister.className.replace('tab-active','') + ' tab-inactive';
      tabLogin.classList.remove('tab-inactive');
      tabRegister.classList.remove('tab-active');
      heading.textContent    = 'Welcome back';
      subheading.textContent = 'Sign in to your BlockAid account';
    } else {
      loginForm.classList.add('hidden');
      registerForm.classList.remove('hidden');
      tabRegister.className = tabRegister.className.replace('tab-inactive','') + ' tab-active';
      tabLogin.className = tabLogin.className.replace('tab-active','') + ' tab-inactive';
      tabRegister.classList.remove('tab-inactive');
      tabLogin.classList.remove('tab-active');
      heading.textContent    = 'Create an account';
      subheading.textContent = 'Join BlockAid and donate with confidence';
    }
  }

  // ── ACCOUNT TYPE SWITCHING ────────────────────────────
  function switchAccountType(val) {
    const personFields   = document.getElementById('personFields');
    const orgFields      = document.getElementById('orgFields');
    const passwordFields = document.getElementById('passwordFields');

    // Reset all
    [personFields, orgFields, passwordFields].forEach(el => {
      el.classList.add('hidden-field');
      el.classList.remove('visible-field');
      el.style.maxHeight = '0';
    });

    clearAllErrors();
    resetFieldInputs(personFields);
    resetFieldInputs(orgFields);

    setTimeout(() => {
      if (val === 'person') {
        personFields.classList.remove('hidden-field');
        personFields.classList.add('visible-field');
        personFields.style.maxHeight = PERSON_MAX_H;
      } else if (val === 'organization') {
        orgFields.classList.remove('hidden-field');
        orgFields.classList.add('visible-field');
        orgFields.style.maxHeight = ORG_MAX_H;
      }
      // Password always shown once a type is selected
      passwordFields.classList.remove('hidden-field');
      passwordFields.classList.add('visible-field');
      passwordFields.style.maxHeight = PWD_MAX_H;
    }, 10);
  }

  function resetFieldInputs(container) {
    container.querySelectorAll('input, select').forEach(el => {
      if (el.type !== 'checkbox') el.value = '';
      el.classList.remove('input-error');
    });
  }

  // ── PASSWORD VISIBILITY TOGGLE ────────────────────────
  function togglePwd(inputId, btn) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
      input.type = 'text';
      btn.textContent = '🙈';
    } else {
      input.type = 'password';
      btn.textContent = '👁';
    }
  }

  // ── PASSWORD STRENGTH ─────────────────────────────────
  function checkStrength(val) {
    const bars    = [1,2,3,4].map(i => document.getElementById('sb' + i));
    const label   = document.getElementById('strengthLabel');
    const colors  = { 1:'#e53e3e', 2:'#f59e0b', 3:'#1a5cff', 4:'#00c37a' };
    const labels  = { 1:'Weak', 2:'Fair', 3:'Good', 4:'Strong' };

    let score = 0;
    if (val.length >= 8)            score++;
    if (/[A-Z]/.test(val))          score++;
    if (/[0-9]/.test(val))          score++;
    if (/[^A-Za-z0-9]/.test(val))  score++;

    bars.forEach((bar, i) => {
      bar.style.background = i < score ? colors[score] : '#dce3f0';
    });
    label.textContent = val ? labels[score] || '' : '';
    label.style.color = score > 0 ? colors[score] : '#b0bacf';
  }

  // ── ERROR HELPERS ─────────────────────────────────────
  function showError(id, inputId) {
    const el = document.getElementById(id);
    if (el) { el.classList.add('show'); }
    if (inputId) {
      const inp = document.getElementById(inputId);
      if (inp) inp.classList.add('input-error');
    }
  }

  function hideError(id, inputId) {
    const el = document.getElementById(id);
    if (el) el.classList.remove('show');
    if (inputId) {
      const inp = document.getElementById(inputId);
      if (inp) inp.classList.remove('input-error');
    }
  }

  function clearAllErrors() {
    document.querySelectorAll('.error-msg').forEach(el => el.classList.remove('show'));
    document.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
  }

  // ── TOAST ─────────────────────────────────────────────
  function showToast(msg) {
    const toast = document.getElementById('successToast');
    toast.textContent = '✓ ' + msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3200);
  }

  // ── REGISTER VALIDATION ───────────────────────────────
  function handleRegister(e) {
    e.preventDefault();
    clearAllErrors();
    let valid = true;

    const accountType = document.getElementById('account_type').value;
    if (!accountType) { showError('err_account_type', 'account_type'); valid = false; }

    if (accountType === 'person') {
      if (!document.getElementById('full_name').value.trim())
        { showError('err_full_name', 'full_name'); valid = false; }
      const pEmail = document.getElementById('p_email').value.trim();
      if (!pEmail || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(pEmail))
        { showError('err_p_email', 'p_email'); valid = false; }
      if (!document.getElementById('p_phone').value.trim())
        { showError('err_p_phone', 'p_phone'); valid = false; }
    }

    if (accountType === 'organization') {
      if (!document.getElementById('organization_name').value.trim())
        { showError('err_organization_name', 'organization_name'); valid = false; }
      if (!document.getElementById('organization_type').value)
        { showError('err_organization_type', 'organization_type'); valid = false; }
      if (!document.getElementById('registration_number').value.trim())
        { showError('err_registration_number', 'registration_number'); valid = false; }
      if (!document.getElementById('responsible_person').value.trim())
        { showError('err_responsible_person', 'responsible_person'); valid = false; }
      const oEmail = document.getElementById('o_email').value.trim();
      if (!oEmail || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(oEmail))
        { showError('err_o_email', 'o_email'); valid = false; }
      if (!document.getElementById('o_phone').value.trim())
        { showError('err_o_phone', 'o_phone'); valid = false; }
    }

    if (accountType) {
      const pwd    = document.getElementById('reg_password').value;
      const cpwd   = document.getElementById('confirm_password').value;
      const agreed = document.getElementById('agreeTerms').checked;

      if (!pwd || pwd.length < 8) { showError('err_reg_password', 'reg_password'); valid = false; }
      if (!cpwd || pwd !== cpwd)  { showError('err_confirm_password', 'confirm_password'); valid = false; }
      if (!agreed) { showError('err_terms'); valid = false; }
    }

    if (valid) {
      showToast('Account created successfully!');
      document.getElementById("registerForm").submit();
    }
  }

  // ── CLEAR ERROR ON INPUT ──────────────────────────────
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.form-input').forEach(input => {
      input.addEventListener('input', () => {
        input.classList.remove('input-error');
      });
    });
  });

  function handleLogin(e){

  e.preventDefault();

  let email = document.getElementById("login_email").value;
  let password = document.getElementById("login_password").value;

  fetch("loginback.php",{
      method:"POST",
      headers:{
          "Content-Type":"application/x-www-form-urlencoded"
      },
      body:new URLSearchParams({
          login_email:email,
          login_password:password
      })
  })
  .then(res=>res.json())
  .then(data=>{

      if(data.status === "success"){

          // save JWT
          localStorage.setItem("token",data.token);

          alert("Login successful");

          window.location.href="index.php";

      }else{

          alert(data.message);

      }

  });

}

  
</script>
</body>
</html>