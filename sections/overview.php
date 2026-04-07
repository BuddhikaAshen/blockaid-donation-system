<!-- ── OVERVIEW ──────────────────────────────── -->
    <div class="section-panel active" id="section-overview">
      <div class="page-header">
        <h1>Overview</h1>
        <p>Welcome back, Ahmad. Here's a summary of your activity.</p>
      </div>

      <div class="summary-grid">
        <div class="summary-card">
          <div class="sc-icon blue">📋</div>
          <div class="sc-label">Total Requests</div>
          <div class="sc-value">7</div>
          <div class="sc-sub blue">↑ 2 this month</div>
        </div>
        <div class="summary-card">
          <div class="sc-icon teal">🌐</div>
          <div class="sc-label">Active Requests</div>
          <div class="sc-value">3</div>
          <div class="sc-sub blue">Fundraising live</div>
        </div>
        <div class="summary-card">
          <div class="sc-icon green">💰</div>
          <div class="sc-label">Total Received</div>
          <div class="sc-value" style="font-size:1.3rem;">RM 18,400</div>
          <div class="sc-sub up">↑ RM 3,200 this week</div>
        </div>
        <div class="summary-card">
          <div class="sc-icon orange">⏳</div>
          <div class="sc-label">Pending Reviews</div>
          <div class="sc-value">2</div>
          <div class="sc-sub warn">Admin reviewing</div>
        </div>
      </div>

      <div class="two-col">
        <div class="card">
          <div class="card-head"><span class="card-title">⏱ Recent Activity</span></div>
          <div class="card-pad">
            <div class="activity-list">
              <div class="activity-item">
                <div class="activity-ico green">✅</div>
                <div>
                  <div class="activity-text">Donation verified on blockchain</div>
                  <div class="activity-meta">REQ-007 · 2 hrs ago</div>
                </div>
              </div>
              <div class="activity-item">
                <div class="activity-ico teal">⬆️</div>
                <div>
                  <div class="activity-text">Proof of usage uploaded</div>
                  <div class="activity-meta">REQ-005 · 5 hrs ago</div>
                </div>
              </div>
              <div class="activity-item">
                <div class="activity-ico blue">⭐</div>
                <div>
                  <div class="activity-text">Admin verified your request</div>
                  <div class="activity-meta">REQ-006 · 1 day ago</div>
                </div>
              </div>
              <div class="activity-item">
                <div class="activity-ico orange">📤</div>
                <div>
                  <div class="activity-text">Request submitted for review</div>
                  <div class="activity-meta">REQ-007 · 2 days ago</div>
                </div>
              </div>
              <div class="activity-item">
                <div class="activity-ico green">💵</div>
                <div>
                  <div class="activity-text">New donation of RM 500 received</div>
                  <div class="activity-meta">REQ-004 · 3 days ago</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-head"><span class="card-title">⚡ Quick Actions</span></div>
          <div class="card-pad">
            <div class="quick-actions">
              <button class="btn btn-primary" onclick="navigate('create-request')" style="width:100%;">➕ Create New
                Request</button>
              <button class="qa-btn" onclick="navigate('open-requests')"><span class="qa-icon">🌐</span> View Open
                Requests</button>
              <button class="qa-btn" onclick="navigate('proof-usage')"><span class="qa-icon">🛡️</span> Upload Usage
                Proof</button>
              <button class="qa-btn" onclick="navigate('donations-received')"><span class="qa-icon">💰</span> View
                Donation History</button>
            </div>
            <div class="chain-info-box">
              <div class="ci-title"><span class="live-dot"></span> Blockchain Status</div>
              <p>All donations & proofs are immutably recorded. Only document hashes are stored on-chain for integrity
                verification.</p>
            </div>
          </div>
        </div>
      </div>
    </div>