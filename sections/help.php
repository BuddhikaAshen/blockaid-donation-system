<!-- ── HELP / SUPPORT ─────────────────────────── -->
    <div class="section-panel" id="section-help">
      <div class="page-header">
        <h1>Help &amp; Support</h1>
        <p>Find answers or get in touch with our support team.</p>
      </div>
      <div class="two-col" style="align-items:start;">
        <div>
          <div class="card card-pad" style="margin-bottom:1.5rem;">
            <div class="form-section-title">❓ Frequently Asked Questions</div>
            <div class="faq-item-dash">
              <div class="faq-q-dash" role="button" tabindex="0">How are documents stored on the blockchain? <span
                  class="faq-icon-dash">+</span></div>
              <div class="faq-a-dash">Only SHA-256 cryptographic hashes of your documents are stored on-chain. The
                actual files are stored off-chain on secure servers. This ensures immutability without exposing
                sensitive personal data.</div>
            </div>
            <div class="faq-item-dash">
              <div class="faq-q-dash" role="button" tabindex="0">How long does admin verification take? <span
                  class="faq-icon-dash">+</span></div>
              <div class="faq-a-dash">Standard requests are reviewed within 3–5 business days. Urgent medical requests
                are prioritised and typically reviewed within 24 hours.</div>
            </div>
            <div class="faq-item-dash">
              <div class="faq-q-dash" role="button" tabindex="0">Can I edit a submitted request? <span
                  class="faq-icon-dash">+</span></div>
              <div class="faq-a-dash">Draft requests can be fully edited. Once submitted, you can only add supplementary
                documents. This maintains audit trail integrity.</div>
            </div>
            <div class="faq-item-dash">
              <div class="faq-q-dash" role="button" tabindex="0">Who can see the public ledger? <span
                  class="faq-icon-dash">+</span></div>
              <div class="faq-a-dash">Anyone, without registration. The ledger shows record types, request IDs, amounts,
                and blockchain transaction hashes. No personal data is included.</div>
            </div>
          </div>
        </div>
        <div class="card card-pad">
          <div class="form-section-title">✉️ Contact Support</div>
          <div class="form-group"><label>Subject</label><input type="text" placeholder="Describe your issue briefly" />
          </div>
          <div class="form-group"><label>Message</label><textarea
              placeholder="Provide details about your issue or question…"></textarea></div>
          <button class="btn btn-primary" style="width:100%;" onclick="handleHelpSubmit(this)">Send Message →</button>
        </div>
      </div>
    </div>