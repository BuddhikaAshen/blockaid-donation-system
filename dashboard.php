<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BlockAid – Recipient Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link
    href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap"
    rel="stylesheet" />
  <style>
    /* ─── THEME VARIABLES (matched to homepage) ──────── */
    :root {
      --c-bg: #f4f6f9;
      --c-surface: #ffffff;
      --c-primary: #1a5cff;
      --c-primary-d: #1044cc;
      --c-accent: #00d4aa;
      --c-accent-d: #00a882;
      --c-dark: #0d1b3e;
      --c-dark-mid: #1e2f5a;
      --c-text: #2c3e6b;
      --c-muted: #6b7a9e;
      --c-border: #dce3f0;
      --c-success: #00c37a;
      --c-warning: #f59e0b;
      --c-danger: #ef4444;
      --r-sm: 0.5rem;
      --r-md: 1rem;
      --r-lg: 1.5rem;
      --r-xl: 2rem;
      --shadow-sm: 0 2px 8px rgba(13, 27, 62, .07);
      --shadow-md: 0 6px 24px rgba(13, 27, 62, .1);
      --shadow-lg: 0 16px 48px rgba(13, 27, 62, .14);
      --ff-head: 'Syne', sans-serif;
      --ff-body: 'DM Sans', sans-serif;
      --sidebar-w: 256px;
      --topbar-h: 64px;
    }

    /* ─── RESET & BASE ────────────────────────────────── */
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html {
      scroll-behavior: smooth;
      font-size: 16px;
    }

    body {
      font-family: var(--ff-body);
      background: var(--c-bg);
      color: var(--c-text);
      line-height: 1.65;
      overflow-x: hidden;
    }

    a {
      color: inherit;
      text-decoration: none;
    }

    button {
      cursor: pointer;
      font-family: var(--ff-body);
    }

    input,
    select,
    textarea {
      font-family: var(--ff-body);
    }

    img {
      display: block;
      max-width: 100%;
    }

    ::-webkit-scrollbar {
      width: 5px;
      height: 5px;
    }

    ::-webkit-scrollbar-track {
      background: var(--c-bg);
    }

    ::-webkit-scrollbar-thumb {
      background: var(--c-border);
      border-radius: 3px;
    }

    /* ─── BUTTONS ─────────────────────────────────────── */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: .45rem;
      padding: .65rem 1.4rem;
      border-radius: var(--r-md);
      font-size: .875rem;
      font-weight: 600;
      font-family: var(--ff-body);
      border: none;
      cursor: pointer;
      transition: all .2s ease;
      white-space: nowrap;
    }

    .btn-primary {
      background: var(--c-primary);
      color: #fff;
      box-shadow: 0 4px 14px rgba(26, 92, 255, .3);
    }

    .btn-primary:hover {
      background: var(--c-primary-d);
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(26, 92, 255, .38);
    }

    .btn-accent {
      background: var(--c-accent);
      color: var(--c-dark);
      font-weight: 700;
      box-shadow: 0 4px 14px rgba(0, 212, 170, .3);
    }

    .btn-accent:hover {
      background: var(--c-accent-d);
      transform: translateY(-1px);
    }

    .btn-outline {
      background: transparent;
      color: var(--c-dark);
      border: 1.5px solid var(--c-border);
    }

    .btn-outline:hover {
      border-color: var(--c-primary);
      color: var(--c-primary);
    }

    .btn-danger-outline {
      background: transparent;
      color: var(--c-danger);
      border: 1.5px solid rgba(239, 68, 68, .25);
    }

    .btn-danger-outline:hover {
      background: rgba(239, 68, 68, .05);
      border-color: var(--c-danger);
    }

    .btn-sm {
      padding: .4rem .9rem;
      font-size: .8rem;
      border-radius: var(--r-sm);
    }

    /* ─── BADGES ──────────────────────────────────────── */
    .badge {
      display: inline-flex;
      align-items: center;
      gap: .3rem;
      font-size: .72rem;
      font-weight: 700;
      padding: .22rem .65rem;
      border-radius: 2rem;
      letter-spacing: .02em;
      white-space: nowrap;
    }

    .badge-verified {
      background: rgba(0, 195, 122, .1);
      color: var(--c-success);
      border: 1px solid rgba(0, 195, 122, .25);
    }

    .badge-pending {
      background: rgba(245, 158, 11, .1);
      color: var(--c-warning);
      border: 1px solid rgba(245, 158, 11, .25);
    }

    .badge-review {
      background: rgba(26, 92, 255, .1);
      color: var(--c-primary);
      border: 1px solid rgba(26, 92, 255, .2);
    }

    .badge-rejected {
      background: rgba(239, 68, 68, .1);
      color: var(--c-danger);
      border: 1px solid rgba(239, 68, 68, .2);
    }

    .badge-draft {
      background: rgba(107, 122, 158, .1);
      color: var(--c-muted);
      border: 1px solid rgba(107, 122, 158, .2);
    }

    .badge-closed {
      background: rgba(13, 27, 62, .08);
      color: var(--c-dark-mid);
      border: 1px solid rgba(13, 27, 62, .12);
    }

    .badge-success {
      background: rgba(0, 195, 122, .1);
      color: var(--c-success);
      border: 1px solid rgba(0, 195, 122, .25);
    }

    .badge-onchain {
      background: rgba(0, 212, 170, .1);
      color: var(--c-accent-d);
      border: 1px solid rgba(0, 212, 170, .3);
    }

    /* ─── LAYOUT SHELL ────────────────────────────────── */
    #app {
      display: flex;
      min-height: 100vh;
    }

    /* ─── TOPBAR ──────────────────────────────────────── */
    #topbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 200;
      height: var(--topbar-h);
      background: rgba(255, 255, 255, .92);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--c-border);
      box-shadow: var(--shadow-sm);
      display: flex;
      align-items: center;
      padding: 0 1.5rem;
      gap: 1rem;
    }

    .topbar-logo {
      display: flex;
      align-items: center;
      gap: .55rem;
      font-family: var(--ff-head);
      font-size: 1.2rem;
      font-weight: 800;
      color: var(--c-dark);
      white-space: nowrap;
      min-width: max-content;
    }

    .topbar-logo .logo-icon {
      width: 34px;
      height: 34px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .topbar-search {
      flex: 1;
      max-width: 360px;
      position: relative;
      margin-left: 1rem;
    }

    .topbar-search input {
      width: 100%;
      padding: .5rem 1rem .5rem 2.4rem;
      border: 1.5px solid var(--c-border);
      border-radius: var(--r-md);
      font-size: .85rem;
      background: var(--c-bg);
      color: var(--c-text);
      transition: border-color .2s, box-shadow .2s;
      outline: none;
    }

    .topbar-search input:focus {
      border-color: var(--c-primary);
      box-shadow: 0 0 0 3px rgba(26, 92, 255, .1);
    }

    .topbar-search input::placeholder {
      color: var(--c-muted);
    }

    .topbar-search .search-icon {
      position: absolute;
      left: .75rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--c-muted);
      font-size: .85rem;
      pointer-events: none;
    }

    .topbar-right {
      margin-left: auto;
      display: flex;
      align-items: center;
      gap: .75rem;
    }

    .chain-pill {
      display: flex;
      align-items: center;
      gap: .4rem;
      background: rgba(0, 195, 122, .08);
      border: 1px solid rgba(0, 195, 122, .2);
      border-radius: 2rem;
      padding: .28rem .75rem;
      font-size: .75rem;
      font-weight: 600;
      color: var(--c-success);
    }

    .live-dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: var(--c-success);
      animation: pulse 2s infinite;
    }

    @keyframes pulse {

      0%,
      100% {
        opacity: 1;
      }

      50% {
        opacity: .4;
      }
    }

    .notif-btn {
      position: relative;
      width: 38px;
      height: 38px;
      border: 1.5px solid var(--c-border);
      border-radius: var(--r-sm);
      background: var(--c-surface);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      color: var(--c-muted);
      transition: all .2s;
      cursor: pointer;
    }

    .notif-btn:hover {
      border-color: var(--c-primary);
      color: var(--c-primary);
    }

    .notif-dot {
      position: absolute;
      top: 6px;
      right: 6px;
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--c-primary);
      border: 2px solid var(--c-surface);
    }

    .profile-btn {
      display: flex;
      align-items: center;
      gap: .6rem;
      padding: .35rem .6rem .35rem .35rem;
      border: 1.5px solid var(--c-border);
      border-radius: var(--r-md);
      background: var(--c-surface);
      cursor: pointer;
      transition: all .2s;
      position: relative;
    }

    .profile-btn:hover {
      border-color: var(--c-primary);
    }

    .profile-avatar {
      width: 30px;
      height: 30px;
      border-radius: .5rem;
      background: linear-gradient(135deg, var(--c-primary), var(--c-accent));
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: var(--ff-head);
      font-size: .75rem;
      font-weight: 800;
      color: #fff;
      flex-shrink: 0;
    }

    .profile-name {
      font-size: .82rem;
      font-weight: 600;
      color: var(--c-dark);
    }

    .profile-chevron {
      color: var(--c-muted);
      font-size: .7rem;
    }

    .profile-dropdown {
      display: none;
      position: absolute;
      top: calc(100% + .5rem);
      right: 0;
      width: 240px;
      background: var(--c-surface);
      border: 1px solid var(--c-border);
      border-radius: var(--r-lg);
      box-shadow: var(--shadow-lg);
      z-index: 300;
      overflow: hidden;
    }

    .profile-dropdown.open {
      display: block;
    }

    .pd-head {
      padding: 1rem 1.1rem;
      border-bottom: 1px solid var(--c-border);
    }

    .pd-name {
      font-family: var(--ff-head);
      font-weight: 700;
      font-size: .9rem;
      color: var(--c-dark);
    }

    .pd-email {
      font-size: .78rem;
      color: var(--c-muted);
      margin-top: .1rem;
    }

    .pd-badge-row {
      margin-top: .5rem;
      display: flex;
      align-items: center;
      gap: .5rem;
    }

    .pd-body {
      padding: .5rem;
    }

    .pd-item {
      display: block;
      width: 100%;
      text-align: left;
      padding: .55rem .75rem;
      border-radius: var(--r-sm);
      font-size: .84rem;
      color: var(--c-text);
      background: none;
      border: none;
      cursor: pointer;
      transition: background .15s;
    }

    .pd-item:hover {
      background: var(--c-bg);
    }

    .pd-item.danger {
      color: var(--c-danger);
    }

    .pd-divider {
      height: 1px;
      background: var(--c-border);
      margin: .35rem .75rem;
    }

    .hamburger {
      display: none;
      width: 38px;
      height: 38px;
      border: 1.5px solid var(--c-border);
      border-radius: var(--r-sm);
      background: var(--c-surface);
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      color: var(--c-dark);
      cursor: pointer;
      flex-shrink: 0;
    }

    /* ─── SIDEBAR ─────────────────────────────────────── */
    #sidebar {
      position: fixed;
      top: var(--topbar-h);
      left: 0;
      bottom: 0;
      width: var(--sidebar-w);
      z-index: 100;
      background: var(--c-surface);
      border-right: 1px solid var(--c-border);
      overflow-y: auto;
      transition: transform .3s ease;
      display: flex;
      flex-direction: column;
    }

    .sidebar-nav {
      flex: 1;
      padding: 1rem .75rem;
    }

    .nav-group-label {
      font-size: .68rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .1em;
      color: var(--c-muted);
      padding: .6rem .6rem .3rem;
      margin-top: .5rem;
    }

    .nav-group-label:first-child {
      margin-top: 0;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: .65rem;
      padding: .6rem .75rem;
      border-radius: var(--r-sm);
      font-size: .86rem;
      font-weight: 500;
      color: var(--c-muted);
      cursor: pointer;
      transition: all .18s;
      border: none;
      background: none;
      width: 100%;
      text-align: left;
      margin-bottom: .1rem;
    }

    .nav-item:hover {
      background: rgba(26, 92, 255, .05);
      color: var(--c-primary);
    }

    .nav-item.active {
      background: rgba(26, 92, 255, .08);
      color: var(--c-primary);
      font-weight: 700;
    }

    .nav-item .nav-icon {
      font-size: 1rem;
      flex-shrink: 0;
      width: 20px;
      text-align: center;
    }

    .nav-badge {
      margin-left: auto;
      font-size: .68rem;
      font-weight: 700;
      background: var(--c-primary);
      color: #fff;
      padding: .1rem .5rem;
      border-radius: 2rem;
    }

    .sidebar-bottom {
      padding: .75rem;
      border-top: 1px solid var(--c-border);
    }

    .sidebar-bottom .nav-item {
      color: var(--c-muted);
    }

    /* ─── MAIN CONTENT ────────────────────────────────── */
    #main {
      margin-left: var(--sidebar-w);
      margin-top: var(--topbar-h);
      min-height: calc(100vh - var(--topbar-h));
      padding: 2rem 2rem 3rem;
      flex: 1;
    }

    .page-header {
      margin-bottom: 1.75rem;
    }

    .page-header h1 {
      font-family: var(--ff-head);
      font-size: 1.6rem;
      font-weight: 800;
      color: var(--c-dark);
    }

    .page-header p {
      font-size: .9rem;
      color: var(--c-muted);
      margin-top: .25rem;
    }

    .page-header-row {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
    }

    /* ─── CARDS ───────────────────────────────────────── */
    .card {
      background: var(--c-surface);
      border: 1px solid var(--c-border);
      border-radius: var(--r-lg);
      box-shadow: var(--shadow-sm);
    }

    .card-pad {
      padding: 1.5rem;
    }

    .card-head {
      padding: 1.1rem 1.5rem;
      border-bottom: 1px solid var(--c-border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
    }

    .card-title {
      font-family: var(--ff-head);
      font-weight: 700;
      font-size: .95rem;
      color: var(--c-dark);
    }

    /* ─── SECTION VISIBILITY ──────────────────────────── */
    .section-panel {
      display: none;
      animation: fadeUp .3s ease;
    }

    .section-panel.active {
      display: block;
    }

    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(12px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* ─── SUMMARY CARDS ───────────────────────────────── */
    .summary-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.25rem;
      margin-bottom: 1.75rem;
    }

    .summary-card {
      background: var(--c-surface);
      border: 1px solid var(--c-border);
      border-radius: var(--r-lg);
      padding: 1.4rem 1.5rem;
      box-shadow: var(--shadow-sm);
      transition: all .22s;
    }

    .summary-card:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
    }

    .sc-label {
      font-size: .72rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .08em;
      color: var(--c-muted);
      margin-bottom: .5rem;
    }

    .sc-value {
      font-family: var(--ff-head);
      font-size: 1.75rem;
      font-weight: 800;
      color: var(--c-dark);
      line-height: 1;
    }

    .sc-sub {
      font-size: .78rem;
      margin-top: .4rem;
      font-weight: 600;
    }

    .sc-sub.up {
      color: var(--c-success);
    }

    .sc-sub.warn {
      color: var(--c-warning);
    }

    .sc-sub.blue {
      color: var(--c-primary);
    }

    .sc-icon {
      width: 40px;
      height: 40px;
      border-radius: .65rem;
      margin-bottom: .85rem;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.15rem;
    }

    .sc-icon.blue {
      background: rgba(26, 92, 255, .1);
    }

    .sc-icon.green {
      background: rgba(0, 195, 122, .1);
    }

    .sc-icon.orange {
      background: rgba(245, 158, 11, .1);
    }

    .sc-icon.teal {
      background: rgba(0, 212, 170, .1);
    }

    /* ─── GRIDS ───────────────────────────────────────── */
    .two-col {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
    }

    .three-col {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
    }

    /* ─── ACTIVITY LIST ───────────────────────────────── */
    .activity-list {
      display: flex;
      flex-direction: column;
    }

    .activity-item {
      display: flex;
      align-items: flex-start;
      gap: .9rem;
      padding: .85rem 0;
      border-bottom: 1px solid var(--c-border);
    }

    .activity-item:last-child {
      border-bottom: none;
    }

    .activity-ico {
      width: 34px;
      height: 34px;
      border-radius: .55rem;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .9rem;
    }

    .activity-ico.green {
      background: rgba(0, 195, 122, .1);
    }

    .activity-ico.blue {
      background: rgba(26, 92, 255, .1);
    }

    .activity-ico.orange {
      background: rgba(245, 158, 11, .1);
    }

    .activity-ico.teal {
      background: rgba(0, 212, 170, .1);
    }

    .activity-text {
      font-size: .85rem;
      color: var(--c-text);
      line-height: 1.5;
    }

    .activity-meta {
      font-size: .75rem;
      color: var(--c-muted);
      margin-top: .15rem;
      font-family: monospace;
    }

    /* ─── QUICK ACTIONS ───────────────────────────────── */
    .quick-actions {
      display: flex;
      flex-direction: column;
      gap: .75rem;
    }

    .qa-btn {
      display: flex;
      align-items: center;
      gap: .75rem;
      padding: .85rem 1rem;
      border-radius: var(--r-md);
      border: 1.5px solid var(--c-border);
      background: var(--c-surface);
      cursor: pointer;
      transition: all .2s;
      font-size: .875rem;
      font-weight: 600;
      color: var(--c-dark);
      text-align: left;
    }

    .qa-btn:hover {
      border-color: var(--c-primary);
      color: var(--c-primary);
      background: rgba(26, 92, 255, .02);
      transform: translateX(2px);
    }

    .qa-btn .qa-icon {
      font-size: 1.1rem;
    }

    .chain-info-box {
      margin-top: 1rem;
      padding: 1rem 1.1rem;
      background: rgba(0, 212, 170, .05);
      border: 1px solid rgba(0, 212, 170, .2);
      border-radius: var(--r-md);
    }

    .chain-info-box .ci-title {
      font-size: .75rem;
      font-weight: 700;
      color: var(--c-accent-d);
      display: flex;
      align-items: center;
      gap: .4rem;
      margin-bottom: .3rem;
    }

    .chain-info-box p {
      font-size: .8rem;
      color: var(--c-muted);
      line-height: 1.6;
    }

    /* ─── TABLE ───────────────────────────────────────── */
    .table-wrap {
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      min-width: 600px;
    }

    thead {
      background: linear-gradient(135deg, var(--c-dark), var(--c-dark-mid));
    }

    thead th {
      padding: .85rem 1.1rem;
      text-align: left;
      font-family: var(--ff-head);
      font-size: .72rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .08em;
      color: rgba(255, 255, 255, .65);
    }

    tbody tr {
      border-bottom: 1px solid var(--c-border);
      transition: background .15s;
    }

    tbody tr:last-child {
      border-bottom: none;
    }

    tbody tr:hover {
      background: var(--c-bg);
    }

    tbody td {
      padding: .85rem 1.1rem;
      font-size: .865rem;
      color: var(--c-text);
    }

    .td-mono {
      font-family: monospace;
      font-size: .78rem;
      color: var(--c-primary);
      font-weight: 600;
    }

    .td-muted {
      color: var(--c-muted);
      font-size: .8rem;
    }

    .td-action {
      color: var(--c-primary);
      font-weight: 700;
      font-size: .82rem;
      cursor: pointer;
      background: none;
      border: none;
    }

    .td-action:hover {
      text-decoration: underline;
    }

    /* ─── FILTERS BAR ─────────────────────────────────── */
    .filters-bar {
      display: flex;
      gap: .75rem;
      flex-wrap: wrap;
      padding: 1rem 1.25rem;
      background: var(--c-bg);
      border-bottom: 1px solid var(--c-border);
    }

    .filter-input {
      padding: .45rem .9rem;
      border: 1.5px solid var(--c-border);
      border-radius: var(--r-sm);
      font-size: .85rem;
      background: var(--c-surface);
      color: var(--c-text);
      outline: none;
      transition: border-color .2s;
    }

    .filter-input:focus {
      border-color: var(--c-primary);
      box-shadow: 0 0 0 3px rgba(26, 92, 255, .1);
    }

    /* ─── PROGRESS BAR ────────────────────────────────── */
    .prog-wrap {
      margin-bottom: 1rem;
    }

    .prog-labels {
      display: flex;
      justify-content: space-between;
      font-size: .78rem;
      font-weight: 600;
      margin-bottom: .35rem;
    }

    .prog-left {
      color: var(--c-dark);
    }

    .prog-right {
      color: var(--c-success);
    }

    .prog-bar {
      height: 7px;
      background: var(--c-border);
      border-radius: 2rem;
      overflow: hidden;
    }

    .prog-fill {
      height: 100%;
      border-radius: 2rem;
      background: linear-gradient(90deg, var(--c-accent), var(--c-success));
      transition: width 1s ease;
    }

    .prog-goal {
      font-size: .75rem;
      color: var(--c-muted);
      margin-top: .3rem;
    }

    /* ─── REQUEST CARDS ───────────────────────────────── */
    .req-card {
      background: var(--c-surface);
      border: 1px solid var(--c-border);
      border-radius: var(--r-lg);
      overflow: hidden;
      box-shadow: var(--shadow-sm);
      transition: all .22s;
      display: flex;
      flex-direction: column;
    }

    .req-card:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-md);
    }

    .req-card-head {
      padding: 1.1rem 1.25rem;
      background: linear-gradient(135deg, #f0f4ff, #e8f5f0);
      border-bottom: 1px solid var(--c-border);
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: .5rem;
    }

    .req-category {
      font-size: .7rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .08em;
      color: var(--c-primary);
      background: rgba(26, 92, 255, .1);
      padding: .2rem .6rem;
      border-radius: 2rem;
    }

    .req-card-body {
      padding: 1.25rem;
      flex: 1;
    }

    .req-title {
      font-family: var(--ff-head);
      font-weight: 700;
      font-size: .98rem;
      color: var(--c-dark);
      margin-bottom: .5rem;
    }

    .req-desc {
      font-size: .85rem;
      color: var(--c-muted);
      line-height: 1.6;
      margin-bottom: 1rem;
    }

    .req-card-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: .75rem;
      border-top: 1px solid var(--c-border);
    }

    .days-badge {
      font-size: .75rem;
      font-weight: 600;
    }

    .days-badge.urgent {
      color: var(--c-warning);
    }

    .days-badge.ok {
      color: var(--c-success);
    }

    /* ─── FORM STYLES ─────────────────────────────────── */
    .form-section-title {
      font-family: var(--ff-head);
      font-size: .9rem;
      font-weight: 700;
      color: var(--c-dark);
      margin-bottom: 1rem;
      padding-bottom: .5rem;
      border-bottom: 1px solid var(--c-border);
      display: flex;
      align-items: center;
      gap: .5rem;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: .35rem;
      margin-bottom: 1rem;
    }

    .form-group:last-child {
      margin-bottom: 0;
    }

    .form-group label {
      font-size: .8rem;
      font-weight: 700;
      color: var(--c-dark);
    }

    .form-group label .req-star {
      color: var(--c-danger);
      margin-left: .15rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      padding: .65rem .9rem;
      border: 1.5px solid var(--c-border);
      border-radius: var(--r-sm);
      font-size: .875rem;
      background: var(--c-bg);
      color: var(--c-text);
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      border-color: var(--c-primary);
      box-shadow: 0 0 0 3px rgba(26, 92, 255, .1);
      background: #fff;
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
      color: var(--c-muted);
      opacity: .7;
    }

    .form-group textarea {
      resize: vertical;
      min-height: 100px;
    }

    .form-hint {
      font-size: .75rem;
      color: var(--c-muted);
      margin-top: .25rem;
      display: flex;
      align-items: flex-start;
      gap: .35rem;
    }

    .upload-zone {
      border: 2px dashed var(--c-border);
      border-radius: var(--r-md);
      padding: 2rem 1.5rem;
      text-align: center;
      cursor: pointer;
      transition: border-color .2s, background .2s;
    }

    .upload-zone:hover {
      border-color: var(--c-primary);
      background: rgba(26, 92, 255, .02);
    }

    .upload-icon {
      font-size: 2rem;
      margin-bottom: .5rem;
    }

    .upload-text {
      font-size: .875rem;
      color: var(--c-muted);
    }

    .upload-text strong {
      color: var(--c-primary);
    }

    .upload-sub {
      font-size: .75rem;
      color: var(--c-muted);
      margin-top: .25rem;
    }

    .form-actions {
      display: flex;
      gap: .75rem;
      margin-top: 1.5rem;
      padding-top: 1.5rem;
      border-top: 1px solid var(--c-border);
      flex-wrap: wrap;
    }

    .info-box {
      padding: .85rem 1rem;
      border-radius: var(--r-md);
      background: rgba(0, 212, 170, .05);
      border: 1px solid rgba(0, 212, 170, .2);
      font-size: .8rem;
      color: var(--c-muted);
      line-height: 1.6;
      display: flex;
      align-items: flex-start;
      gap: .5rem;
      margin-bottom: 1rem;
    }

    .info-box .info-ico {
      flex-shrink: 0;
      color: var(--c-accent-d);
    }

    /* ─── NOTIFICATIONS ───────────────────────────────── */
    .notif-list {
      display: flex;
      flex-direction: column;
      gap: .85rem;
    }

    .notif-item {
      display: flex;
      align-items: flex-start;
      gap: .9rem;
      padding: 1rem 1.1rem;
      background: var(--c-surface);
      border: 1px solid var(--c-border);
      border-radius: var(--r-md);
      border-left: 4px solid var(--c-border);
      transition: box-shadow .2s;
    }

    .notif-item:hover {
      box-shadow: var(--shadow-sm);
    }

    .notif-item.green {
      border-left-color: var(--c-success);
    }

    .notif-item.blue {
      border-left-color: var(--c-primary);
    }

    .notif-item.orange {
      border-left-color: var(--c-warning);
    }

    .notif-item.red {
      border-left-color: var(--c-danger);
    }

    .notif-item.read {
      opacity: .65;
    }

    .notif-ico {
      width: 36px;
      height: 36px;
      border-radius: .55rem;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .95rem;
    }

    .notif-ico.green {
      background: rgba(0, 195, 122, .1);
    }

    .notif-ico.blue {
      background: rgba(26, 92, 255, .1);
    }

    .notif-ico.orange {
      background: rgba(245, 158, 11, .1);
    }

    .notif-ico.red {
      background: rgba(239, 68, 68, .1);
    }

    .notif-text-title {
      font-size: .875rem;
      font-weight: 700;
      color: var(--c-dark);
      margin-bottom: .2rem;
    }

    .notif-text-body {
      font-size: .83rem;
      color: var(--c-muted);
      line-height: 1.55;
    }

    .notif-time {
      font-size: .72rem;
      color: var(--c-muted);
      margin-top: .3rem;
    }

    /* ─── SETTINGS ────────────────────────────────────── */
    .settings-block {
      margin-bottom: 1.5rem;
    }

    .toggle-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
    }

    .toggle-btn {
      position: relative;
      width: 44px;
      height: 24px;
      border-radius: 2rem;
      background: var(--c-border);
      border: none;
      cursor: pointer;
      transition: background .25s;
      flex-shrink: 0;
    }

    .toggle-btn.on {
      background: var(--c-primary);
    }

    .toggle-knob {
      position: absolute;
      top: 3px;
      left: 3px;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      background: #fff;
      transition: transform .25s;
      box-shadow: 0 1px 4px rgba(0, 0, 0, .2);
    }

    .toggle-btn.on .toggle-knob {
      transform: translateX(20px);
    }

    /* ─── SECURITY TABLE ──────────────────────────────── */
    .session-item {
      display: flex;
      align-items: center;
      gap: .9rem;
      padding: .85rem 1rem;
      border-radius: var(--r-md);
      border: 1px solid var(--c-border);
      margin-bottom: .6rem;
      transition: box-shadow .2s;
    }

    .session-item:hover {
      box-shadow: var(--shadow-sm);
    }

    .session-item.current {
      background: rgba(26, 92, 255, .03);
      border-color: rgba(26, 92, 255, .2);
    }

    .session-ico {
      width: 38px;
      height: 38px;
      border-radius: .55rem;
      background: var(--c-bg);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      flex-shrink: 0;
    }

    .session-name {
      font-size: .875rem;
      font-weight: 600;
      color: var(--c-dark);
    }

    .session-meta {
      font-size: .78rem;
      color: var(--c-muted);
      margin-top: .1rem;
    }

    /* ─── FAQ ACCORDION ───────────────────────────────── */
    .faq-item-dash {
      border: 1px solid var(--c-border);
      border-radius: var(--r-md);
      margin-bottom: .75rem;
      overflow: hidden;
    }

    .faq-q-dash {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 1.25rem;
      cursor: pointer;
      font-family: var(--ff-head);
      font-weight: 700;
      font-size: .9rem;
      color: var(--c-dark);
      background: var(--c-surface);
      user-select: none;
      transition: background .2s;
    }

    .faq-q-dash:hover {
      background: var(--c-bg);
    }

    .faq-icon-dash {
      font-size: 1rem;
      color: var(--c-primary);
      transition: transform .3s;
      flex-shrink: 0;
    }

    .faq-a-dash {
      max-height: 0;
      overflow: hidden;
      font-size: .875rem;
      color: var(--c-muted);
      line-height: 1.7;
      transition: max-height .35s ease, padding .35s ease;
      padding: 0 1.25rem;
    }

    .faq-item-dash.open .faq-q-dash {
      background: rgba(26, 92, 255, .03);
    }

    .faq-item-dash.open .faq-icon-dash {
      transform: rotate(45deg);
    }

    .faq-item-dash.open .faq-a-dash {
      max-height: 300px;
      padding: .85rem 1.25rem 1.25rem;
    }

    /* ─── OVERLAY ─────────────────────────────────────── */
    #overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(13, 27, 62, .35);
      z-index: 90;
    }

    #overlay.open {
      display: block;
    }

    /* ─── EMPTY STATE ─────────────────────────────────── */
    .empty-state {
      text-align: center;
      padding: 3rem 1.5rem;
      color: var(--c-muted);
    }

    .empty-state .es-icon {
      font-size: 2.5rem;
      margin-bottom: .75rem;
    }

    .empty-state p {
      font-size: .9rem;
    }

    /* ─── PROOF HISTORY ───────────────────────────────── */
    .proof-item {
      display: flex;
      align-items: flex-start;
      gap: .9rem;
      padding: 1rem 1.1rem;
      border: 1px solid var(--c-border);
      border-radius: var(--r-md);
      margin-bottom: .75rem;
      transition: box-shadow .2s;
    }

    .proof-item:hover {
      box-shadow: var(--shadow-sm);
    }

    .proof-ico {
      width: 36px;
      height: 36px;
      border-radius: .55rem;
      background: rgba(26, 92, 255, .08);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      flex-shrink: 0;
    }

    .proof-title {
      font-size: .875rem;
      font-weight: 700;
      color: var(--c-dark);
      margin-bottom: .15rem;
    }

    .proof-meta {
      font-size: .78rem;
      color: var(--c-muted);
    }

    .proof-hash {
      font-family: monospace;
      font-size: .75rem;
      color: var(--c-primary);
    }

    /* ─── RESPONSIVE ──────────────────────────────────── */
    @media (max-width: 1100px) {
      .summary-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .three-col {
        grid-template-columns: 1fr 1fr;
      }
    }

    @media (max-width: 900px) {
      .two-col {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 768px) {
      #sidebar {
        transform: translateX(-100%);
      }

      #sidebar.open {
        transform: translateX(0);
      }

      #main {
        margin-left: 0;
        padding: 1.25rem 1rem 2rem;
      }

      .hamburger {
        display: flex;
      }

      .topbar-search {
        display: none;
      }

      .chain-pill {
        display: none;
      }

      .summary-grid {
        grid-template-columns: 1fr 1fr;
      }

      .form-grid {
        grid-template-columns: 1fr;
      }

      .three-col {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 480px) {
      .summary-grid {
        grid-template-columns: 1fr;
      }

      .page-header-row {
        flex-direction: column;
        align-items: flex-start;
      }
    }

    .topbar-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 24px;
      font-weight: 700;
    }

    .logo-icon {
      width: 40px;
      height: 40px;
      object-fit: contain;
    }

    .logo-text {
      font-family: Arial, sans-serif;
    }

    .highlight {
      color: var(--c-primary);
    }
  </style>
</head>

<body>
  <div id="overlay" onclick="closeSidebar()"></div>

  <!-- ═══════════ TOPBAR ═══════════ -->
  <header id="topbar" role="banner">
    <button class="hamburger" onclick="toggleSidebar()" aria-label="Toggle navigation">☰</button>
    <div class="topbar-logo">
      <img src="img/blockaid_logo.png" class="logo-icon" alt="BlockAid Logo">
      Block<span style="color:var(--c-primary)">Aid</span>
    </div>
    <div class="topbar-search">
      <span class="search-icon">🔍</span>
      <input type="text" placeholder="Search requests, donations…" aria-label="Search" />
    </div>
    <div class="topbar-right">
      <div class="chain-pill" aria-label="Blockchain status: live">
        <span class="live-dot"></span> Chain: Live
      </div>
      <button class="notif-btn" onclick="navigate('notifications')" aria-label="Notifications">
        🔔<span class="notif-dot"></span>
      </button>
      <div style="position:relative;">
        <button class="profile-btn" onclick="toggleProfile()" aria-label="Profile menu" aria-haspopup="true">
          <div class="profile-avatar">AK</div>
          <span class="profile-name">Ahmad Karim</span>
          <span class="profile-chevron">▾</span>
        </button>
        <div class="profile-dropdown" id="profileDropdown" role="menu">
          <div class="pd-head">
            <div class="pd-name">Ahmad Karim</div>
            <div class="pd-email">ahmad@example.com</div>
            <div class="pd-badge-row">
              <span id="accountBadge" class="badge badge-verified">Recipient – Individual</span>
              <button onclick="toggleAccountType()"
                style="font-size:.72rem;color:var(--c-primary);background:none;border:none;cursor:pointer;font-weight:600;">Switch</button>
            </div>
          </div>
          <div class="pd-body">
            <button class="pd-item" onclick="navigate('settings');toggleProfile()">⚙️ Settings</button>
            <button class="pd-item" onclick="navigate('security');toggleProfile()">🔐 Security</button>
            <div class="pd-divider"></div>
            <button class="pd-item danger">Sign Out</button>
          </div>
        </div>
      </div>
    </div>
  </header>

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

  <!-- ═══════════ MAIN CONTENT ═══════════ -->
  <main id="main" role="main">

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

    <!-- ── MY DONATION REQUESTS ───────────────────── -->
    <div class="section-panel" id="section-my-requests">
      <div class="page-header-row page-header">
        <div>
          <h1>My Donation Requests</h1>
          <p>Manage and track all your submitted requests.</p>
        </div>
        <button class="btn btn-primary btn-sm" onclick="navigate('create-request')">➕ New Request</button>
      </div>
      <div class="card">
        <div class="filters-bar">
          <select class="filter-input" aria-label="Filter by status">
            <option value="">All Statuses</option>
            <option>Draft</option>
            <option>Submitted</option>
            <option>Under Review</option>
            <option>Verified</option>
            <option>Rejected</option>
            <option>Closed</option>
          </select>
          <input type="text" class="filter-input" placeholder="Search by title or ID…" aria-label="Search requests"
            style="flex:1;min-width:180px;" />
        </div>
        <div class="table-wrap">
          <table aria-label="My donation requests">
            <thead>
              <tr>
                <th>Request ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Target</th>
                <th>Received</th>
                <th>Status</th>
                <th>Submitted</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="td-mono">REQ-007</td>
                <td style="font-weight:600;color:var(--c-dark);">Surgery for Arif</td>
                <td class="td-muted">Medical</td>
                <td>RM 15,000</td>
                <td>RM 4,200</td>
                <td><span class="badge badge-review">Under Review</span></td>
                <td class="td-muted">15 Jan 2025</td>
                <td><button class="td-action">View</button></td>
              </tr>
              <tr>
                <td class="td-mono">REQ-006</td>
                <td style="font-weight:600;color:var(--c-dark);">Flood Relief Kota Bharu</td>
                <td class="td-muted">Disaster Relief</td>
                <td>RM 30,000</td>
                <td>RM 8,700</td>
                <td><span class="badge badge-verified">Verified</span></td>
                <td class="td-muted">10 Jan 2025</td>
                <td><button class="td-action">View</button></td>
              </tr>
              <tr>
                <td class="td-mono">REQ-005</td>
                <td style="font-weight:600;color:var(--c-dark);">School Supplies Drive</td>
                <td class="td-muted">Education</td>
                <td>RM 5,000</td>
                <td>RM 5,000</td>
                <td><span class="badge badge-closed">Closed</span></td>
                <td class="td-muted">1 Dec 2024</td>
                <td><button class="td-action">View</button></td>
              </tr>
              <tr>
                <td class="td-mono">REQ-004</td>
                <td style="font-weight:600;color:var(--c-dark);">Community Well Project</td>
                <td class="td-muted">Community</td>
                <td>RM 10,000</td>
                <td>RM 500</td>
                <td><span class="badge badge-verified">Verified</span></td>
                <td class="td-muted">20 Nov 2024</td>
                <td><button class="td-action">View</button></td>
              </tr>
              <tr>
                <td class="td-mono">REQ-003</td>
                <td style="font-weight:600;color:var(--c-dark);">Medical Assistance – Elderly</td>
                <td class="td-muted">Medical</td>
                <td>RM 8,000</td>
                <td>RM 0</td>
                <td><span class="badge badge-rejected">Rejected</span></td>
                <td class="td-muted">10 Nov 2024</td>
                <td><button class="td-action">View</button></td>
              </tr>
              <tr>
                <td class="td-mono">REQ-002</td>
                <td style="font-weight:600;color:var(--c-dark);">Orphanage Renovation</td>
                <td class="td-muted">Community</td>
                <td>RM 20,000</td>
                <td>RM 0</td>
                <td><span class="badge badge-draft">Draft</span></td>
                <td class="td-muted">—</td>
                <td><button class="td-action">Edit</button></td>
              </tr>
              <tr>
                <td class="td-mono">REQ-001</td>
                <td style="font-weight:600;color:var(--c-dark);">School Uniform Aid</td>
                <td class="td-muted">Education</td>
                <td>RM 3,000</td>
                <td>RM 3,000</td>
                <td><span class="badge badge-closed">Closed</span></td>
                <td class="td-muted">3 Oct 2024</td>
                <td><button class="td-action">View</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ── OPEN REQUESTS ──────────────────────────── -->
    <div class="section-panel" id="section-open-requests">
      <div class="page-header">
        <h1>Open Requests</h1>
        <p>Active fundraising campaigns open for donations.</p>
      </div>
      <div class="three-col">
        <div class="req-card">
          <div class="req-card-head">
            <span class="req-category">Medical</span>
            <span class="badge badge-verified">✓ Verified</span>
          </div>
          <div class="req-card-body">
            <h3 class="req-title">Surgery for Arif</h3>
            <p class="req-desc">Urgent surgery for 8-year-old Arif diagnosed with a rare heart condition. Funds cover
              hospital and surgical fees.</p>
            <div class="prog-wrap">
              <div class="prog-labels"><span class="prog-left">RM 4,200 raised</span><span class="prog-right">28%</span>
              </div>
              <div class="prog-bar">
                <div class="prog-fill" style="width:28%"></div>
              </div>
              <div class="prog-goal">Goal: RM 15,000</div>
            </div>
            <div class="req-card-footer">
              <span class="days-badge urgent">⏱ 20 days left</span>
              <button class="btn btn-outline btn-sm">View &amp; Donate</button>
            </div>
          </div>
        </div>
        <div class="req-card">
          <div class="req-card-head">
            <span class="req-category">Disaster Relief</span>
            <span class="badge badge-verified">✓ Verified</span>
          </div>
          <div class="req-card-body">
            <h3 class="req-title">Flood Relief Kota Bharu</h3>
            <p class="req-desc">Emergency aid for 200+ families displaced by the December floods in Kelantan.</p>
            <div class="prog-wrap">
              <div class="prog-labels"><span class="prog-left">RM 8,700 raised</span><span class="prog-right">29%</span>
              </div>
              <div class="prog-bar">
                <div class="prog-fill" style="width:29%"></div>
              </div>
              <div class="prog-goal">Goal: RM 30,000</div>
            </div>
            <div class="req-card-footer">
              <span class="days-badge urgent">⏱ 8 days left</span>
              <button class="btn btn-outline btn-sm">View &amp; Donate</button>
            </div>
          </div>
        </div>
        <div class="req-card">
          <div class="req-card-head">
            <span class="req-category">Community</span>
            <span class="badge badge-verified">✓ Verified</span>
          </div>
          <div class="req-card-body">
            <h3 class="req-title">Community Well Project</h3>
            <p class="req-desc">Building a clean water well for a rural village in Pahang with no piped water access.
            </p>
            <div class="prog-wrap">
              <div class="prog-labels"><span class="prog-left">RM 500 raised</span><span class="prog-right">5%</span>
              </div>
              <div class="prog-bar">
                <div class="prog-fill" style="width:5%"></div>
              </div>
              <div class="prog-goal">Goal: RM 10,000</div>
            </div>
            <div class="req-card-footer">
              <span class="days-badge ok">⏱ 45 days left</span>
              <button class="btn btn-outline btn-sm">View &amp; Donate</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── CREATE REQUEST ─────────────────────────── -->
    <div class="section-panel" id="section-create-request">
      <div class="page-header">
        <h1>Create Donation Request</h1>
        <p>Fill in the details to submit a new fundraising request for admin review.</p>
      </div>
      <div style="max-width:700px;">
        <div class="card card-pad">
          <div class="form-group">
            <label>Request Title <span class="req-star">*</span></label>
            <input type="text" placeholder="e.g. Heart Surgery for Ahmad, 5 years old" />
          </div>
          <div class="form-grid">
            <div class="form-group">
              <label>Category <span class="req-star">*</span></label>
              <select>
                <option value="">Select category</option>
                <option>Medical</option>
                <option>Education</option>
                <option>Disaster Relief</option>
                <option>Community</option>
                <option>Other</option>
              </select>
            </div>
            <div class="form-group">
              <label>Target Amount (RM) <span class="req-star">*</span></label>
              <input type="number" placeholder="10000" />
            </div>
          </div>
          <div class="form-group">
            <label>Deadline <span class="req-star">*</span></label>
            <input type="date" />
          </div>

          <div class="form-section-title">🏦 Bank Details</div>
          <div class="form-group">
            <label>Account Holder Name <span class="req-star">*</span></label>
            <input type="text" placeholder="Ahmad Karim bin Abdullah" />
          </div>
          <div class="form-grid">
            <div class="form-group">
              <label>Bank Name <span class="req-star">*</span></label>
              <select>
                <option>Maybank</option>
                <option>CIMB Bank</option>
                <option>Public Bank</option>
                <option>RHB Bank</option>
                <option>Bank Islam</option>
              </select>
            </div>
            <div class="form-group">
              <label>Account Number <span class="req-star">*</span></label>
              <input type="text" placeholder="••••••••1234" />
            </div>
          </div>
          <div class="form-hint" style="margin-bottom:1rem;">🔒 Account details are encrypted and shown as masked in
            public view.</div>

          <div class="form-group">
            <label>Description <span class="req-star">*</span></label>
            <textarea
              placeholder="Describe your situation, how funds will be used, and any relevant background…"></textarea>
          </div>

          <div class="form-section-title">📎 Supporting Documents</div>
          <div class="upload-zone" role="button" tabindex="0" aria-label="Upload supporting documents">
            <div class="upload-icon">📁</div>
            <div class="upload-text">Drag & drop or <strong>browse files</strong></div>
            <div class="upload-sub">PDF, JPG, PNG · Max 10MB each</div>
          </div>
          <div class="info-box" style="margin-top:.75rem;">
            <span class="info-ico">ℹ️</span>
            Documents stored off-chain; only cryptographic hashes (SHA-256) are recorded on-chain for integrity
            verification.
          </div>

          <div class="form-actions">
            <button class="btn btn-primary">Submit Request</button>
            <button class="btn btn-outline">Save as Draft</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ── DONATIONS RECEIVED ─────────────────────── -->
    <div class="section-panel" id="section-donations-received">
      <div class="page-header">
        <h1>Donations Received</h1>
        <p>Complete history of all donations made to your requests.</p>
      </div>
      <div class="card">
        <div class="table-wrap">
          <table aria-label="Donations received history">
            <thead>
              <tr>
                <th>Donation ID</th>
                <th>Request</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Verification</th>
                <th>Tx Hash</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="td-mono">DON-041</td>
                <td class="td-muted">REQ-007</td>
                <td style="font-weight:700;color:var(--c-success);">RM 1,000</td>
                <td class="td-muted">18 Jan 2025</td>
                <td><span class="badge badge-onchain">✓ Verified on Blockchain</span></td>
                <td class="td-mono">0xa1b2…f9e3</td>
                <td><button class="td-action">View</button></td>
              </tr>
              <tr>
                <td class="td-mono">DON-040</td>
                <td class="td-muted">REQ-006</td>
                <td style="font-weight:700;color:var(--c-success);">RM 500</td>
                <td class="td-muted">17 Jan 2025</td>
                <td><span class="badge badge-onchain">✓ Verified on Blockchain</span></td>
                <td class="td-mono">0xc3d4…a7b1</td>
                <td><button class="td-action">View</button></td>
              </tr>
              <tr>
                <td class="td-mono">DON-039</td>
                <td class="td-muted">REQ-007</td>
                <td style="font-weight:700;color:var(--c-success);">RM 200</td>
                <td class="td-muted">16 Jan 2025</td>
                <td><span class="badge badge-pending">Pending</span></td>
                <td class="td-muted">—</td>
                <td><button class="td-action">View</button></td>
              </tr>
              <tr>
                <td class="td-mono">DON-038</td>
                <td class="td-muted">REQ-004</td>
                <td style="font-weight:700;color:var(--c-success);">RM 500</td>
                <td class="td-muted">14 Jan 2025</td>
                <td><span class="badge badge-onchain">✓ Verified on Blockchain</span></td>
                <td class="td-mono">0xe5f6…1c2d</td>
                <td><button class="td-action">View</button></td>
              </tr>
              <tr>
                <td class="td-mono">DON-037</td>
                <td class="td-muted">REQ-006</td>
                <td style="font-weight:700;color:var(--c-success);">RM 8,000</td>
                <td class="td-muted">12 Jan 2025</td>
                <td><span class="badge badge-onchain">✓ Verified on Blockchain</span></td>
                <td class="td-mono">0x7a8b…3e4f</td>
                <td><button class="td-action">View</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ── DONOR SLIPS ─────────────────────────────── -->
    <div class="section-panel" id="section-donor-slips">
      <div class="page-header">
        <h1>Donor Slip Uploads</h1>
        <p>Payment proofs submitted by donors for your requests.</p>
      </div>
      <div class="three-col">
        <div class="card card-pad">
          <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.9rem;">
            <div
              style="width:40px;height:40px;border-radius:.65rem;background:rgba(0,212,170,.1);display:flex;align-items:center;justify-content:center;font-size:1.1rem;">
              🧾</div>
            <div>
              <div style="font-weight:700;font-size:.9rem;color:var(--c-dark);">Slip from Donor #A-21</div>
              <div style="font-size:.75rem;color:var(--c-muted);font-family:monospace;">DON-041 · REQ-007</div>
            </div>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.6rem;"><span
              style="font-weight:700;color:var(--c-success);">RM 1,000</span><span
              class="badge badge-verified">Verified</span></div>
          <div style="font-size:.75rem;color:var(--c-muted);margin-bottom:.75rem;">18 Jan 2025, 2:45 PM</div>
          <button class="btn btn-outline btn-sm" style="width:100%;">View Slip</button>
        </div>
        <div class="card card-pad">
          <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.9rem;">
            <div
              style="width:40px;height:40px;border-radius:.65rem;background:rgba(245,158,11,.1);display:flex;align-items:center;justify-content:center;font-size:1.1rem;">
              🧾</div>
            <div>
              <div style="font-weight:700;font-size:.9rem;color:var(--c-dark);">Slip from Donor #B-09</div>
              <div style="font-size:.75rem;color:var(--c-muted);font-family:monospace;">DON-039 · REQ-007</div>
            </div>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.6rem;"><span
              style="font-weight:700;color:var(--c-success);">RM 200</span><span
              class="badge badge-pending">Pending</span></div>
          <div style="font-size:.75rem;color:var(--c-muted);margin-bottom:.75rem;">16 Jan 2025, 10:12 AM</div>
          <button class="btn btn-outline btn-sm" style="width:100%;">View Slip</button>
        </div>
        <div class="card card-pad">
          <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.9rem;">
            <div
              style="width:40px;height:40px;border-radius:.65rem;background:rgba(0,212,170,.1);display:flex;align-items:center;justify-content:center;font-size:1.1rem;">
              🧾</div>
            <div>
              <div style="font-weight:700;font-size:.9rem;color:var(--c-dark);">Slip from Donor #C-17</div>
              <div style="font-size:.75rem;color:var(--c-muted);font-family:monospace;">DON-040 · REQ-006</div>
            </div>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.6rem;"><span
              style="font-weight:700;color:var(--c-success);">RM 500</span><span
              class="badge badge-verified">Verified</span></div>
          <div style="font-size:.75rem;color:var(--c-muted);margin-bottom:.75rem;">17 Jan 2025, 4:00 PM</div>
          <button class="btn btn-outline btn-sm" style="width:100%;">View Slip</button>
        </div>
      </div>
    </div>

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

    <!-- ── NOTIFICATIONS ──────────────────────────── -->
    <div class="section-panel" id="section-notifications">
      <div class="page-header">
        <h1>Notifications</h1>
        <p>Updates on your requests, donations, and account.</p>
      </div>
      <div style="max-width:680px;" class="notif-list">
        <div class="notif-item green">
          <div class="notif-ico green">✅</div>
          <div>
            <div class="notif-text-title">Donation Verified on Blockchain</div>
            <div class="notif-text-body">Donation DON-041 of RM 1,000 for REQ-007 has been verified and recorded
              on-chain.</div>
            <div class="notif-time">2 hours ago</div>
          </div>
        </div>
        <div class="notif-item blue">
          <div class="notif-ico blue">🛡️</div>
          <div>
            <div class="notif-text-title">Request Verified by Admin</div>
            <div class="notif-text-body">Your request REQ-006 "Flood Relief Kota Bharu" has been verified and is now
              live for donations.</div>
            <div class="notif-time">1 day ago</div>
          </div>
        </div>
        <div class="notif-item orange">
          <div class="notif-ico orange">💬</div>
          <div>
            <div class="notif-text-title">Admin Comment on REQ-007</div>
            <div class="notif-text-body">Admin has requested additional documentation for REQ-007. Please upload the
              latest medical report.</div>
            <div class="notif-time">2 days ago</div>
          </div>
        </div>
        <div class="notif-item red read">
          <div class="notif-ico red">❌</div>
          <div>
            <div class="notif-text-title">Request REQ-003 Rejected</div>
            <div class="notif-text-body">Request "Medical Assistance – Elderly" was rejected. Reason: Insufficient
              documentation provided.</div>
            <div class="notif-time">5 days ago</div>
          </div>
        </div>
        <div class="notif-item green read">
          <div class="notif-ico green">💵</div>
          <div>
            <div class="notif-text-title">New Donation Received</div>
            <div class="notif-text-body">RM 500 received for REQ-004 "Community Well Project" from an anonymous donor.
            </div>
            <div class="notif-time">1 week ago</div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── SETTINGS ───────────────────────────────── -->
    <div class="section-panel" id="section-settings">
      <div class="page-header">
        <h1>Settings</h1>
        <p>Manage your profile, password, and account preferences.</p>
      </div>
      <div style="max-width:680px;display:flex;flex-direction:column;gap:1.5rem;">

        <div class="card card-pad">
          <div class="form-section-title">👤 Profile Information</div>
          <div class="form-grid">
            <div class="form-group"><label>Full Name</label><input type="text" value="Ahmad Karim" /></div>
            <div class="form-group"><label>Email Address</label><input type="email" value="ahmad@example.com" /></div>
            <div class="form-group"><label>Phone Number</label><input type="tel" value="+60 12-345 6789" /></div>
            <div class="form-group"><label>State</label><select>
                <option>Selangor</option>
                <option>Kuala Lumpur</option>
                <option>Kelantan</option>
                <option>Johor</option>
              </select></div>
          </div>
          <div class="form-group"><label>Address (Optional)</label><textarea
              style="min-height:70px;">No. 12, Jalan Mawar, Taman Bahagia, 40000 Shah Alam</textarea></div>
          <div class="form-actions" style="margin-top:0;padding-top:1rem;"><button class="btn btn-primary">Save
              Profile</button></div>
        </div>

        <div class="card card-pad" id="orgBlock" style="display:none;">
          <div class="form-section-title">🏢 Organisation Details</div>
          <div class="form-grid">
            <div class="form-group"><label>Organisation Name</label><input type="text"
                placeholder="e.g. Yayasan Sejahtera" /></div>
            <div class="form-group"><label>Organisation Type</label><select>
                <option>NGO</option>
                <option>Foundation</option>
                <option>Religious Body</option>
                <option>Government Agency</option>
              </select></div>
            <div class="form-group"><label>Registration No.</label><input type="text"
                placeholder="PPM-001-14-01012023" /></div>
            <div class="form-group"><label>Responsible Person</label><input type="text" placeholder="Full name" /></div>
          </div>
          <div class="form-actions" style="margin-top:0;padding-top:1rem;"><button class="btn btn-primary">Save
              Organisation</button></div>
        </div>

        <div class="card card-pad">
          <div class="form-section-title">🔑 Change Password</div>
          <div class="form-group"><label>Current Password</label><input type="password" placeholder="••••••••" /></div>
          <div class="form-grid">
            <div class="form-group"><label>New Password</label><input type="password" placeholder="••••••••" /></div>
            <div class="form-group"><label>Confirm New Password</label><input type="password" placeholder="••••••••" />
            </div>
          </div>
          <div class="form-actions" style="margin-top:0;padding-top:1rem;"><button class="btn btn-primary">Update
              Password</button></div>
        </div>

        <div class="card card-pad">
          <div class="toggle-row">
            <div>
              <div style="font-family:var(--ff-head);font-weight:700;font-size:.95rem;color:var(--c-dark);">🔐
                Two-Factor Authentication</div>
              <div style="font-size:.83rem;color:var(--c-muted);margin-top:.25rem;">Add an extra layer of security to
                your account.</div>
            </div>
            <button class="toggle-btn" id="twoFAToggle" onclick="toggle2FA()" role="switch" aria-checked="false"
              aria-label="Enable two-factor authentication">
              <span class="toggle-knob"></span>
            </button>
          </div>
        </div>
      </div>
    </div>

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

  </main>

  <script>
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
  </script>
</body>

</html>