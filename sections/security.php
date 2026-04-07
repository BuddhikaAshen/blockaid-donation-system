<!-- ── SECURITY ───────────────────────────────── -->
    <div class="section-panel" id="section-security">
      <div class="page-header">
        <h1>Security</h1>
        <p>Monitor login activity and manage active sessions.</p>
      </div>
      <div style="max-width:760px;display:flex;flex-direction:column;gap:1.5rem;">
        <div class="card">
          <div class="card-head">
            <span class="card-title">🕐 Login Activity</span>
          </div>
          <div class="table-wrap">
            <table aria-label="Login activity log">
              <thead>
                <tr>
                  <th>Date &amp; Time</th>
                  <th>IP Address</th>
                  <th>Device</th>
                  <th>Location</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="td-mono" style="font-size:.78rem;">18 Jan 2025, 09:12</td>
                  <td class="td-mono">115.164.12.3</td>
                  <td style="font-size:.85rem;">Chrome / Windows</td>
                  <td class="td-muted">Shah Alam, MY</td>
                  <td><span class="badge badge-verified">Success</span></td>
                </tr>
                <tr>
                  <td class="td-mono" style="font-size:.78rem;">17 Jan 2025, 22:45</td>
                  <td class="td-mono">115.164.12.3</td>
                  <td style="font-size:.85rem;">Safari / iPhone</td>
                  <td class="td-muted">Shah Alam, MY</td>
                  <td><span class="badge badge-verified">Success</span></td>
                </tr>
                <tr>
                  <td class="td-mono" style="font-size:.78rem;">16 Jan 2025, 14:30</td>
                  <td class="td-mono">203.0.113.45</td>
                  <td style="font-size:.85rem;">Firefox / Linux</td>
                  <td class="td-muted">Kuala Lumpur, MY</td>
                  <td><span class="badge badge-rejected">Failed</span></td>
                </tr>
                <tr>
                  <td class="td-mono" style="font-size:.78rem;">15 Jan 2025, 08:02</td>
                  <td class="td-mono">115.164.12.3</td>
                  <td style="font-size:.85rem;">Chrome / Windows</td>
                  <td class="td-muted">Shah Alam, MY</td>
                  <td><span class="badge badge-verified">Success</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="card card-pad">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
            <span class="card-title">💻 Active Sessions</span>
            <button class="btn btn-danger-outline btn-sm">Sign out other sessions</button>
          </div>
          <div class="session-item current">
            <div class="session-ico">🖥️</div>
            <div style="flex:1;">
              <div class="session-name">Chrome on Windows <span
                  style="font-size:.72rem;font-weight:700;color:var(--c-primary);margin-left:.5rem;">● Current</span>
              </div>
              <div class="session-meta">Shah Alam, MY · 115.164.12.3 · Active now</div>
            </div>
          </div>
          <div class="session-item">
            <div class="session-ico">📱</div>
            <div style="flex:1;">
              <div class="session-name">Safari on iPhone</div>
              <div class="session-meta">Shah Alam, MY · Last active 17 Jan 2025</div>
            </div>
            <button class="btn btn-danger-outline btn-sm">Sign out</button>
          </div>
        </div>
      </div>
    </div>