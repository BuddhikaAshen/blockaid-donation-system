// ─── NAVIGATION ────────────────────────────────────
    function navigate(id) {
      document.querySelectorAll('.section-panel').forEach(p => p.classList.remove('active'));
      const panel = document.getElementById('section-' + id);
      if (panel) { panel.classList.add('active'); window.scrollTo(0, 0); }

      document.querySelectorAll('.nav-item').forEach(n => {
        n.classList.toggle('active', n.dataset.section === id);
        if (n.dataset.section === id) n.setAttribute('aria-current', 'page');
        else n.removeAttribute('aria-current');
      });
      closeSidebar();
    }

    // ─── SIDEBAR ───────────────────────────────────────
    function toggleSidebar() {
      const sb = document.getElementById('sidebar');
      const ov = document.getElementById('overlay');
      sb.classList.toggle('open');
      ov.classList.toggle('open');
    }
    function closeSidebar() {
      if (window.innerWidth < 768) {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('overlay').classList.remove('open');
      }
    }

    // ─── PROFILE DROPDOWN ──────────────────────────────
    function toggleProfile() {
      document.getElementById('profileDropdown').classList.toggle('open');
    }
    document.addEventListener('click', e => {
      if (!e.target.closest('.profile-btn') && !e.target.closest('.profile-dropdown')) {
        document.getElementById('profileDropdown').classList.remove('open');
      }
    });

    // ─── ACCOUNT TYPE TOGGLE ───────────────────────────
    let isOrg = false;
    function toggleAccountType() {
      isOrg = !isOrg;
      document.getElementById('accountBadge').textContent = isOrg ? 'Recipient – Organisation' : 'Recipient – Individual';
      const orgBlock = document.getElementById('orgBlock');
      if (orgBlock) orgBlock.style.display = isOrg ? 'block' : 'none';
    }

    // ─── 2FA TOGGLE ────────────────────────────────────
    let twoFAOn = false;
    function toggle2FA() {
      twoFAOn = !twoFAOn;
      const btn = document.getElementById('twoFAToggle');
      btn.classList.toggle('on', twoFAOn);
      btn.setAttribute('aria-checked', twoFAOn);
    }

    // ─── FAQ ACCORDION ──────────────────────────────────
    document.querySelectorAll('.faq-q-dash').forEach(q => {
      q.addEventListener('click', () => {
        const item = q.closest('.faq-item-dash');
        const wasOpen = item.classList.contains('open');
        document.querySelectorAll('.faq-item-dash').forEach(i => i.classList.remove('open'));
        if (!wasOpen) item.classList.add('open');
      });
      q.addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); q.click(); }
      });
    });

    // ─── HELP FORM ─────────────────────────────────────
    function handleHelpSubmit(btn) {
      const orig = btn.textContent;
      btn.textContent = '✓ Message Sent!';
      btn.style.background = 'var(--c-success)';
      setTimeout(() => { btn.textContent = orig; btn.style.background = ''; }, 3000);
    }

    // ─── KEYBOARD: sidebar nav ─────────────────────────
    document.querySelectorAll('.nav-item').forEach(item => {
      item.setAttribute('tabindex', '0');
      item.addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); item.click(); }
      });
    });

    // ─── NAVBAR NOTIF SHORTCUT ─────────────────────────
    document.querySelector('.notif-btn').addEventListener('click', () => navigate('notifications'));

    // ─── ANIMATE PROGRESS BARS ─────────────────────────
    function animateProgress() {
      document.querySelectorAll('.prog-fill').forEach(bar => {
        const w = bar.style.width; bar.style.width = '0';
        requestAnimationFrame(() => setTimeout(() => { bar.style.width = w; }, 80));
      });
    }
    animateProgress();

    