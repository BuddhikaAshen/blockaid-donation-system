<!-- ═══════════ SIDEBAR ═══════════ -->
  <aside id="sidebar" role="navigation" aria-label="Dashboard navigation">
    <nav class="sidebar-nav">
      <div class="nav-group-label">Main</div>
      <button class="nav-item active" data-section="overview" onclick="navigate('overview')" aria-current="page">
        <span class="nav-icon">📊</span> Overview
      </button>
      <button class="nav-item" data-section="my-requests" onclick="navigate('my-requests')">
        <span class="nav-icon">📋</span> My Donation Requests
      </button>
      <button class="nav-item" data-section="open-requests" onclick="navigate('open-requests')">
        <span class="nav-icon">🌐</span> Open Requests
      </button>
      <button class="nav-item" data-section="create-request" onclick="navigate('create-request')">
        <span class="nav-icon">➕</span> Create Request
      </button>

      <div class="nav-group-label">Financials</div>
      <button class="nav-item" data-section="donations-received" onclick="navigate('donations-received')">
        <span class="nav-icon">💰</span> Donations Received
      </button>
      <button class="nav-item" data-section="donor-slips" onclick="navigate('donor-slips')">
        <span class="nav-icon">🧾</span> Donor Slip Uploads
      </button>
      <button class="nav-item" data-section="proof-usage" onclick="navigate('proof-usage')">
        <span class="nav-icon">🛡️</span> Proof of Fund Usage
      </button>

      <div class="nav-group-label">Account</div>
      <button class="nav-item" data-section="notifications" onclick="navigate('notifications')">
        <span class="nav-icon">🔔</span> Notifications
        <span class="nav-badge">3</span>
      </button>
      <button class="nav-item" data-section="settings" onclick="navigate('settings')">
        <span class="nav-icon">⚙️</span> Settings
      </button>
      <button class="nav-item" data-section="security" onclick="navigate('security')">
        <span class="nav-icon">🔐</span> Security
      </button>
      <button class="nav-item" data-section="help" onclick="navigate('help')">
        <span class="nav-icon">❓</span> Help / Support
      </button>
    </nav>
    <div class="sidebar-bottom">
      <a href="index.html" class="nav-item">
        <span class="nav-icon">🏠</span> Back to Home
      </a>
    </div>
  </aside>