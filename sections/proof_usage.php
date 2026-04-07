<!-- ── PROOF OF FUND USAGE ────────────────────── -->
    <div class="section-panel" id="section-proof-usage">
      <div class="page-header">
        <h1>Proof of Fund Usage</h1>
        <p>Upload evidence of how received funds were utilised.</p>
      </div>
      <div class="two-col">
        <div class="card card-pad">
          <div class="form-section-title">📤 Upload New Proof</div>
          <div class="form-group">
            <label>Select Request <span class="req-star">*</span></label>
            <select>
              <option value="">Choose a request…</option>
              <option>REQ-007 – Surgery for Arif</option>
              <option>REQ-006 – Flood Relief Kota Bharu</option>
              <option>REQ-004 – Community Well Project</option>
            </select>
          </div>
          <div class="form-group">
            <label>Amount Used (RM) <span class="req-star">*</span></label>
            <input type="number" placeholder="0.00" />
          </div>
          <div class="form-group">
            <label>Description of Usage <span class="req-star">*</span></label>
            <textarea
              placeholder="Describe how the funds were used (e.g. hospital invoice, school fees receipt)…"></textarea>
          </div>
          <div class="form-group">
            <label>Upload Proof Files</label>
            <div class="upload-zone">
              <div class="upload-icon">🗂️</div>
              <div class="upload-text">Receipts, invoices, photos — <strong>browse</strong></div>
              <div class="upload-sub">PDF, JPG, PNG</div>
            </div>
          </div>
          <div class="info-box">
            <span class="info-ico">ℹ️</span>
            Only document hashes are recorded on-chain after admin verification. Original files remain off-chain.
          </div>
          <button class="btn btn-primary" style="width:100%;">Submit Proof</button>
        </div>

        <div>
          <div
            style="font-family:var(--ff-head);font-weight:700;font-size:1rem;color:var(--c-dark);margin-bottom:1rem;">📜
            Submission History</div>
          <div class="proof-item">
            <div class="proof-ico">🧾</div>
            <div style="flex:1;">
              <div class="proof-title">Hospital Invoice – Surgery Deposit</div>
              <div class="proof-meta">REQ-007 · 14 Jan 2025 · 2 files attached</div>
              <div class="proof-meta" style="margin-top:.2rem;">Amount used: <strong style="color:var(--c-success);">RM
                  3,000</strong></div>
            </div>
            <span class="badge badge-review">Under Review</span>
          </div>
          <div class="proof-item">
            <div class="proof-ico">🧾</div>
            <div style="flex:1;">
              <div class="proof-title">Flood Relief Supplies Receipt</div>
              <div class="proof-meta">REQ-006 · 8 Jan 2025 · 3 files attached</div>
              <div class="proof-meta" style="margin-top:.2rem;">Amount used: <strong style="color:var(--c-success);">RM
                  5,000</strong></div>
              <div class="proof-hash" style="margin-top:.25rem;">⛓ 0xf1e2…3a4b</div>
            </div>
            <span class="badge badge-onchain">On-Chain ✓</span>
          </div>
          <div class="proof-item">
            <div class="proof-ico">🧾</div>
            <div style="flex:1;">
              <div class="proof-title">School Supplies Purchase</div>
              <div class="proof-meta">REQ-005 · 20 Dec 2024 · 1 file attached</div>
              <div class="proof-meta" style="margin-top:.2rem;">Amount used: <strong style="color:var(--c-success);">RM
                  5,000</strong></div>
              <div class="proof-hash" style="margin-top:.25rem;">⛓ 0x9a8b…7c6d</div>
            </div>
            <span class="badge badge-onchain">On-Chain ✓</span>
          </div>
        </div>
      </div>
    </div>