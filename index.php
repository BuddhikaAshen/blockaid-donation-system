<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BlockAid – Blockchain-Based Charity Donation Transparency</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap"
        rel="stylesheet" />
    <style>
        /* ─── THEME VARIABLES ─────────────────────────────── */
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
            --r-sm: 0.5rem;
            --r-md: 1rem;
            --r-lg: 1.5rem;
            --r-xl: 2rem;
            --shadow-sm: 0 2px 8px rgba(13, 27, 62, .07);
            --shadow-md: 0 6px 24px rgba(13, 27, 62, .1);
            --shadow-lg: 0 16px 48px rgba(13, 27, 62, .14);
            --ff-head: 'Syne', sans-serif;
            --ff-body: 'DM Sans', sans-serif;
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

        img {
            display: block;
            max-width: 100%;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button {
            cursor: pointer;
            font-family: var(--ff-body);
        }

        /* ─── UTILITIES ───────────────────────────────────── */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .section {
            padding: 6rem 0;
        }

        .section-label {
            display: inline-block;
            font-family: var(--ff-head);
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--c-primary);
            background: rgba(26, 92, 255, .08);
            padding: .3rem .9rem;
            border-radius: 2rem;
            margin-bottom: 1rem;
        }

        .section-title {
            font-family: var(--ff-head);
            font-size: clamp(1.8rem, 4vw, 2.75rem);
            font-weight: 800;
            color: var(--c-dark);
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .section-sub {
            font-size: 1.05rem;
            color: var(--c-muted);
            max-width: 600px;
            margin-bottom: 3rem;
        }

        .badge-verified {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            background: rgba(0, 195, 122, .1);
            color: var(--c-success);
            font-size: .75rem;
            font-weight: 600;
            padding: .25rem .7rem;
            border-radius: 2rem;
            border: 1px solid rgba(0, 195, 122, .25);
        }

        .badge-verified::before {
            content: '✓';
            font-weight: 800;
        }

        /* ─── BUTTONS ─────────────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .75rem 1.75rem;
            border-radius: var(--r-md);
            font-size: .95rem;
            font-weight: 600;
            font-family: var(--ff-body);
            border: none;
            transition: all .22s ease;
        }

        .btn-primary {
            background: var(--c-primary);
            color: #fff;
            box-shadow: 0 4px 16px rgba(26, 92, 255, .35);
        }

        .btn-primary:hover {
            background: var(--c-primary-d);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(26, 92, 255, .4);
        }

        .btn-outline {
            background: transparent;
            color: var(--c-dark);
            border: 2px solid var(--c-border);
        }

        .btn-outline:hover {
            border-color: var(--c-primary);
            color: var(--c-primary);
            transform: translateY(-2px);
        }

        .btn-accent {
            background: var(--c-accent);
            color: var(--c-dark);
            font-weight: 700;
            box-shadow: 0 4px 16px rgba(0, 212, 170, .35);
        }

        .btn-accent:hover {
            background: var(--c-accent-d);
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: .5rem 1.1rem;
            font-size: .85rem;
        }

        /* ─── NAVBAR ──────────────────────────────────────── */
        #navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, .9);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--c-border);
            transition: box-shadow .3s;
        }

        #navbar.scrolled {
            box-shadow: var(--shadow-md);
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 68px;
            gap: 1.5rem;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: .6rem;
            font-family: var(--ff-head);
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--c-dark);
            white-space: nowrap;
        }

        .logo-img {
            height: 38px;
            width: auto;
            object-fit: contain;
        }

        .logo-text {
            font-family: var(--ff-head);
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--c-dark);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: .15rem;
            list-style: none;
            flex: 1;
            justify-content: center;
        }

        .nav-links a {
            padding: .4rem .75rem;
            border-radius: var(--r-sm);
            font-size: .875rem;
            font-weight: 500;
            color: var(--c-muted);
            transition: all .18s;
        }

        .nav-links a:hover {
            color: var(--c-primary);
            background: rgba(26, 92, 255, .06);
        }

        .nav-actions {
            display: flex;
            gap: .75rem;
            align-items: center;
        }

        .nav-actions .btn {
            padding: .5rem 1.2rem;
            font-size: .85rem;
            border-radius: .6rem;
        }

        .nav-toggle {
            display: none;
            background: none;
            border: 1px solid var(--c-border);
            border-radius: var(--r-sm);
            padding: .4rem .55rem;
            color: var(--c-dark);
            font-size: 1.2rem;
        }

        .mobile-menu {
            display: none;
            flex-direction: column;
            background: var(--c-surface);
            border-bottom: 1px solid var(--c-border);
            padding: 1rem 1.5rem;
            gap: .5rem;
        }

        .mobile-menu.open {
            display: flex;
        }

        .mobile-menu a {
            padding: .6rem .75rem;
            border-radius: var(--r-sm);
            font-weight: 500;
            color: var(--c-text);
        }

        .mobile-menu a:hover {
            background: var(--c-bg);
        }

        .mobile-menu .mob-actions {
            display: flex;
            gap: .75rem;
            margin-top: .5rem;
        }

        /* ─── HERO ────────────────────────────────────────── */
        #home {
            background: linear-gradient(145deg, #e8eeff 0%, #f4f9ff 40%, #e4fbf5 100%);
            position: relative;
            overflow: hidden;
            padding: 5rem 0 4rem;
        }

        #home::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 1px 1px, rgba(26, 92, 255, .06) 1px, transparent 0);
            background-size: 36px 36px;
            pointer-events: none;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(26, 92, 255, .08);
            border: 1px solid rgba(26, 92, 255, .15);
            border-radius: 2rem;
            padding: .3rem 1rem .3rem .5rem;
            font-size: .8rem;
            font-weight: 600;
            color: var(--c-primary);
            margin-bottom: 1.5rem;
        }

        .hero-kicker span {
            background: var(--c-primary);
            color: #fff;
            border-radius: 2rem;
            padding: .1rem .6rem;
            font-size: .72rem;
        }

        .hero-title {
            font-family: var(--ff-head);
            font-size: clamp(2.2rem, 5vw, 3.6rem);
            font-weight: 800;
            color: var(--c-dark);
            line-height: 1.12;
            margin-bottom: 1.25rem;
        }

        .hero-title em {
            font-style: normal;
            color: var(--c-primary);
        }

        .hero-sub {
            font-size: 1.05rem;
            color: var(--c-muted);
            line-height: 1.7;
            max-width: 520px;
            margin-bottom: 2.25rem;
        }

        .hero-ctas {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 2.5rem;
        }

        .trust-bar {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem 1.5rem;
            align-items: center;
            padding: 1rem 1.25rem;
            background: rgba(255, 255, 255, .7);
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            backdrop-filter: blur(8px);
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: .4rem;
            font-size: .82rem;
            font-weight: 600;
            color: var(--c-text);
        }

        .trust-item .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--c-accent);
        }

        .hero-image-wrap {
            position: relative;
            border-radius: var(--r-xl);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .hero-image-wrap img {
            width: 100%;
            height: 420px;
            object-fit: cover;
        }

        .hero-float-card {
            position: absolute;
            bottom: 1.5rem;
            left: 1.5rem;
            background: rgba(255, 255, 255, .95);
            border-radius: var(--r-md);
            padding: .85rem 1.1rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--c-border);
            min-width: 200px;
        }

        .hero-float-title {
            font-family: var(--ff-head);
            font-size: .75rem;
            font-weight: 700;
            color: var(--c-muted);
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: .3rem;
        }

        .hero-float-val {
            font-family: var(--ff-head);
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--c-dark);
        }

        .hero-float-sub {
            font-size: .78rem;
            color: var(--c-success);
            font-weight: 600;
        }

        .hero-float-card2 {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background: var(--c-dark);
            border-radius: var(--r-md);
            padding: .7rem 1rem;
            box-shadow: var(--shadow-md);
            color: #fff;
        }

        .hfc2-label {
            font-size: .7rem;
            color: rgba(255, 255, 255, .6);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .hfc2-val {
            font-family: var(--ff-head);
            font-size: .85rem;
            font-weight: 700;
            font-family: monospace;
            color: var(--c-accent);
        }

        /* ─── HOW IT WORKS ────────────────────────────────── */
        #how-it-works {
            background: var(--c-surface);
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 2rem;
            position: relative;
        }

        .step-card {
            background: var(--c-bg);
            border: 1px solid var(--c-border);
            border-radius: var(--r-lg);
            padding: 2rem 1.75rem;
            position: relative;
            transition: all .25s;
        }

        .step-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: rgba(26, 92, 255, .2);
        }

        .step-num {
            width: 48px;
            height: 48px;
            border-radius: .75rem;
            background: linear-gradient(135deg, var(--c-primary), #4a82ff);
            color: #fff;
            font-family: var(--ff-head);
            font-weight: 800;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            box-shadow: 0 4px 12px rgba(26, 92, 255, .3);
        }

        .step-icon {
            font-size: 1.6rem;
            margin-bottom: .5rem;
        }

        .step-title {
            font-family: var(--ff-head);
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--c-dark);
            margin-bottom: .5rem;
        }

        .step-desc {
            font-size: .9rem;
            color: var(--c-muted);
            line-height: 1.65;
        }

        .step-connector {
            display: none;
        }

        /* ─── FEATURES ────────────────────────────────────── */
        #features {
            background: linear-gradient(160deg, var(--c-dark) 0%, var(--c-dark-mid) 100%);
            color: #fff;
        }

        #features .section-title {
            color: #fff;
        }

        #features .section-sub {
            color: rgba(255, 255, 255, .55);
        }

        #features .section-label {
            background: rgba(255, 255, 255, .1);
            color: var(--c-accent);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: var(--r-lg);
            padding: 1.75rem;
            transition: all .25s;
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, .09);
            transform: translateY(-3px);
            border-color: rgba(0, 212, 170, .3);
        }

        .feat-icon {
            width: 44px;
            height: 44px;
            border-radius: .7rem;
            background: linear-gradient(135deg, rgba(0, 212, 170, .2), rgba(26, 92, 255, .2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(0, 212, 170, .2);
        }

        .feat-title {
            font-family: var(--ff-head);
            font-weight: 700;
            font-size: 1rem;
            color: #fff;
            margin-bottom: .5rem;
        }

        .feat-desc {
            font-size: .88rem;
            color: rgba(255, 255, 255, .55);
            line-height: 1.65;
        }

        /* ─── REQUESTS PREVIEW ────────────────────────────── */
        #requests {
            background: var(--c-bg);
        }

        .requests-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.75rem;
        }

        .request-card {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--r-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: all .25s;
        }

        .request-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .req-header {
            padding: 1.25rem 1.5rem;
            background: linear-gradient(135deg, #f0f4ff, #e8f5f0);
            border-bottom: 1px solid var(--c-border);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
        }

        .req-category {
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--c-primary);
            background: rgba(26, 92, 255, .1);
            padding: .2rem .6rem;
            border-radius: 2rem;
        }

        .req-body {
            padding: 1.5rem;
        }

        .req-title {
            font-family: var(--ff-head);
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--c-dark);
            margin-bottom: .6rem;
        }

        .req-desc {
            font-size: .875rem;
            color: var(--c-muted);
            margin-bottom: 1.25rem;
            line-height: 1.6;
        }

        .req-progress {
            margin-bottom: 1.25rem;
        }

        .progress-labels {
            display: flex;
            justify-content: space-between;
            font-size: .8rem;
            font-weight: 600;
            margin-bottom: .4rem;
        }

        .progress-label-left {
            color: var(--c-dark);
        }

        .progress-label-right {
            color: var(--c-success);
        }

        .progress-bar {
            height: 7px;
            background: var(--c-border);
            border-radius: 2rem;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 2rem;
            background: linear-gradient(90deg, var(--c-accent), var(--c-success));
        }

        .req-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .req-id {
            font-size: .75rem;
            color: var(--c-muted);
            font-family: monospace;
        }

        /* ─── PUBLIC LEDGER ───────────────────────────────── */
        #ledger {
            background: var(--c-surface);
        }

        .table-wrap {
            overflow-x: auto;
            border-radius: var(--r-lg);
            border: 1px solid var(--c-border);
            box-shadow: var(--shadow-sm);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        thead {
            background: linear-gradient(135deg, var(--c-dark), var(--c-dark-mid));
        }

        thead th {
            padding: 1rem 1.25rem;
            text-align: left;
            font-family: var(--ff-head);
            font-size: .78rem;
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
            padding: .9rem 1.25rem;
            font-size: .875rem;
            color: var(--c-text);
        }

        .tx-hash {
            font-family: monospace;
            font-size: .78rem;
            color: var(--c-primary);
            font-weight: 600;
        }

        .rec-type {
            display: inline-block;
            padding: .2rem .65rem;
            border-radius: 2rem;
            font-size: .75rem;
            font-weight: 700;
        }

        .type-donation {
            background: rgba(0, 195, 122, .1);
            color: var(--c-success);
        }

        .type-verify {
            background: rgba(26, 92, 255, .1);
            color: var(--c-primary);
        }

        .type-request {
            background: rgba(245, 158, 11, .12);
            color: var(--c-warning);
        }

        /* ─── SECURITY ────────────────────────────────────── */
        #security {
            background: linear-gradient(145deg, #eef2ff, #e8fbf5);
        }

        .security-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: start;
        }

        .sec-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: .9rem;
            margin-top: 1.5rem;
        }

        .sec-item {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            background: var(--c-surface);
            padding: 1rem 1.25rem;
            border-radius: var(--r-md);
            border: 1px solid var(--c-border);
            transition: all .2s;
        }

        .sec-item:hover {
            box-shadow: var(--shadow-sm);
            transform: translateX(3px);
        }

        .sec-ico {
            font-size: 1.25rem;
            flex-shrink: 0;
            margin-top: .1rem;
        }

        .sec-name {
            font-weight: 700;
            font-size: .9rem;
            color: var(--c-dark);
            margin-bottom: .2rem;
        }

        .sec-text {
            font-size: .85rem;
            color: var(--c-muted);
            line-height: 1.6;
        }

        .chain-visual {
            background: var(--c-dark);
            border-radius: var(--r-xl);
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .chain-title {
            font-family: var(--ff-head);
            font-weight: 800;
            color: #fff;
            font-size: 1rem;
            margin-bottom: .5rem;
        }

        .chain-block {
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(0, 212, 170, .2);
            border-radius: var(--r-md);
            padding: 1rem 1.25rem;
        }

        .cb-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: .3rem;
        }

        .cb-label {
            font-size: .7rem;
            color: rgba(255, 255, 255, .4);
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .cb-val {
            font-family: monospace;
            font-size: .78rem;
            color: var(--c-accent);
            font-weight: 600;
        }

        .chain-arrow {
            text-align: center;
            color: rgba(255, 255, 255, .25);
            font-size: .9rem;
        }

        /* ─── FAQ ─────────────────────────────────────────── */
        #faq {
            background: var(--c-surface);
        }

        .faq-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            max-width: 760px;
        }

        .faq-item {
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            overflow: hidden;
        }

        .faq-q {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            cursor: pointer;
            font-family: var(--ff-head);
            font-weight: 700;
            font-size: .975rem;
            color: var(--c-dark);
            background: var(--c-surface);
            user-select: none;
            transition: background .2s;
        }

        .faq-q:hover {
            background: var(--c-bg);
        }

        .faq-icon {
            font-size: 1.1rem;
            color: var(--c-primary);
            transition: transform .3s;
            flex-shrink: 0;
            margin-left: 1rem;
        }

        .faq-a {
            padding: 0 1.5rem;
            max-height: 0;
            overflow: hidden;
            font-size: .9rem;
            color: var(--c-muted);
            line-height: 1.7;
            transition: max-height .35s ease, padding .35s ease;
        }

        .faq-item.open .faq-q {
            background: rgba(26, 92, 255, .04);
        }

        .faq-item.open .faq-icon {
            transform: rotate(45deg);
        }

        .faq-item.open .faq-a {
            max-height: 300px;
            padding: 1rem 1.5rem 1.5rem;
        }

        /* ─── CONTACT ─────────────────────────────────────── */
        #contact {
            background: linear-gradient(145deg, #f4f6f9, #eef2ff);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 4rem;
            align-items: start;
        }

        .contact-info-list {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            margin-top: 1.5rem;
        }

        .cinfo-item {
            display: flex;
            gap: .9rem;
            align-items: flex-start;
        }

        .cinfo-icon {
            width: 40px;
            height: 40px;
            border-radius: .65rem;
            flex-shrink: 0;
            background: rgba(26, 92, 255, .1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .cinfo-label {
            font-weight: 700;
            font-size: .85rem;
            color: var(--c-dark);
            margin-bottom: .15rem;
        }

        .cinfo-val {
            font-size: .875rem;
            color: var(--c-muted);
        }

        .contact-form {
            background: var(--c-surface);
            border-radius: var(--r-xl);
            padding: 2.5rem;
            border: 1px solid var(--c-border);
            box-shadow: var(--shadow-sm);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: .4rem;
            margin-bottom: 1.25rem;
        }

        .form-group label {
            font-size: .82rem;
            font-weight: 700;
            color: var(--c-dark);
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            padding: .75rem 1rem;
            border: 1.5px solid var(--c-border);
            border-radius: var(--r-sm);
            font-family: var(--ff-body);
            font-size: .9rem;
            color: var(--c-text);
            background: var(--c-bg);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: var(--c-primary);
            box-shadow: 0 0 0 3px rgba(26, 92, 255, .1);
        }

        .form-group textarea {
            min-height: 120px;
        }

        /* ─── FOOTER ──────────────────────────────────────── */
        footer {
            background: var(--c-dark);
            color: rgba(255, 255, 255, .7);
            padding: 3.5rem 0 2rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 2.5rem;
            margin-bottom: 3rem;
        }

        .footer-brand {
            max-width: 260px;
        }

        .footer-logo {
            font-family: var(--ff-head);
            font-size: 1.25rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: .75rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .footer-logo .logo-icon {
            width: 30px;
            height: 30px;
            border-radius: .5rem;
            background: linear-gradient(135deg, var(--c-primary), var(--c-accent));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .95rem;
        }

        .footer-tagline {
            font-size: .875rem;
            line-height: 1.65;
            margin-bottom: 1.25rem;
        }

        .social-links {
            display: flex;
            gap: .6rem;
        }

        .social-link {
            width: 36px;
            height: 36px;
            border-radius: .5rem;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
            color: rgba(255, 255, 255, .65);
            transition: all .2s;
        }

        .social-link:hover {
            background: rgba(26, 92, 255, .3);
            border-color: var(--c-primary);
            color: #fff;
        }

        .footer-col h4 {
            font-family: var(--ff-head);
            font-weight: 700;
            font-size: .85rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: rgba(255, 255, 255, .4);
            margin-bottom: 1rem;
        }

        .footer-col ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: .55rem;
        }

        .footer-col ul li a {
            font-size: .875rem;
            transition: color .2s;
        }

        .footer-col ul li a:hover {
            color: var(--c-accent);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, .08);
            padding-top: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: .8rem;
            color: rgba(255, 255, 255, .35);
        }

        /* ─── RESPONSIVE ──────────────────────────────────── */
        @media (max-width: 1024px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

            .security-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {

            .nav-links,
            .nav-actions {
                display: none;
            }

            .nav-toggle {
                display: flex;
            }

            .hero-grid {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }

            .hero-image-wrap {
                max-height: 300px;
            }

            .hero-image-wrap img {
                height: 300px;
            }

            .contact-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

            .requests-grid {
                grid-template-columns: 1fr;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .hero-ctas {
                flex-direction: column;
            }

            .hero-ctas .btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* ─── ANIMATIONS ──────────────────────────────────── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(28px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-content>* {
            animation: fadeUp .7s ease both;
        }

        .hero-content>*:nth-child(1) {
            animation-delay: .05s;
        }

        .hero-content>*:nth-child(2) {
            animation-delay: .15s;
        }

        .hero-content>*:nth-child(3) {
            animation-delay: .22s;
        }

        .hero-content>*:nth-child(4) {
            animation-delay: .3s;
        }

        .hero-content>*:nth-child(5) {
            animation-delay: .38s;
        }

        .hero-image-wrap {
            animation: fadeUp .85s .2s ease both;
        }

        /* pulse dot */
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .4;
            }
        }

        .live-dot {
            display: inline-block;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--c-success);
            margin-right: .4rem;
            animation: pulse 2s infinite;
        }
    </style>
</head>

<body>

    <!-- ═══════════════════════════════════════════
     NAVBAR
═══════════════════════════════════════════════ -->
    <nav id="navbar" aria-label="Main navigation">
        <div class="container">
            <div class="nav-inner">
                <a href="#home" class="nav-logo" aria-label="BlockAid Home">
                    <img src="img/blockaid_logo.png" alt="BlockAid Logo" class="logo-img">
                    <span class="logo-text">BlockAid</span>
                </a>
                <ul class="nav-links" role="list">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#how-it-works">How It Works</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#requests">Requests</a></li>
                    <li><a href="#ledger">Ledger</a></li>
                    <li><a href="#security">Security</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <div class="nav-actions">
                    <a href="#contact" class="btn btn-outline btn-sm">Log In</a>
                    <a href="#contact" class="btn btn-primary btn-sm">Register</a>
                </div>
                <button class="nav-toggle" id="menuToggle" aria-label="Toggle menu" aria-expanded="false">☰</button>
            </div>
        </div>
        <div class="mobile-menu" id="mobileMenu" aria-label="Mobile navigation">
            <a href="#home">Home</a>
            <a href="#how-it-works">How It Works</a>
            <a href="#features">Features</a>
            <a href="#requests">Verified Requests</a>
            <a href="#ledger">Public Ledger</a>
            <a href="#security">Security</a>
            <a href="#faq">FAQ</a>
            <a href="#contact">Contact</a>
            <div class="mob-actions">
                <a href="#contact" class="btn btn-outline btn-sm">Log In</a>
                <a href="#contact" class="btn btn-primary btn-sm">Register</a>
            </div>
        </div>
    </nav>


    <!-- ═══════════════════════════════════════════
     HERO
═══════════════════════════════════════════════ -->
    <section id="home" aria-labelledby="hero-heading">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <div class="hero-kicker">
                        <span>NEW</span>
                        Blockchain-Verified Donations
                    </div>
                    <h1 class="hero-title" id="hero-heading">
                        Donate with Proof.<br />
                        Track with <em>Transparency.</em>
                    </h1>
                    <p class="hero-sub">
                        BlockAid verifies donation requests and logs verified proof hashes on blockchain to prevent
                        tampering — giving every donor complete confidence their contribution makes a real impact.
                    </p>
                    <div class="hero-ctas">
                        <a href="#requests" class="btn btn-primary">
                            🔍 Browse Verified Requests
                        </a>
                        <a href="#ledger" class="btn btn-accent">
                            📊 View Public Ledger
                        </a>
                    </div>
                    <div class="trust-bar" role="list" aria-label="Trust indicators">
                        <div class="trust-item" role="listitem"><span class="dot"></span>Verified Requests</div>
                        <div class="trust-item" role="listitem"><span class="dot"></span>Audit Logs</div>
                        <div class="trust-item" role="listitem"><span class="dot"></span>Hash Integrity</div>
                        <div class="trust-item" role="listitem"><span class="dot"></span>Admin Review</div>
                    </div>
                </div>

                <div class="hero-image-wrap">
                    <img src="https://picsum.photos/seed/blockaid-charity/800/520"
                        alt="People helping each other in a community — representing charity and transparency"
                        width="800" height="520" loading="eager" />
                    <div class="hero-float-card" aria-hidden="true">
                        <div class="hero-float-title">Total Verified Donations</div>
                        <div class="hero-float-val">RM 482,300</div>
                        <div class="hero-float-sub"><span class="live-dot"></span>Live on Blockchain</div>
                    </div>
                    <div class="hero-float-card2" aria-hidden="true">
                        <div class="hfc2-label">Latest Tx Hash</div>
                        <div class="hfc2-val">0x3a9f…c4d2</div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════
     HOW IT WORKS
═══════════════════════════════════════════════ -->
    <section id="how-it-works" class="section" aria-labelledby="hiw-heading">
        <div class="container">
            <div class="section-label">Process</div>
            <h2 class="section-title" id="hiw-heading">How BlockAid Works</h2>
            <p class="section-sub">A transparent four-step journey from request to blockchain record — every action
                logged, every proof verified.</p>
            <div class="steps-grid">

                <article class="step-card">
                    <div class="step-num">1</div>
                    <div class="step-icon">📋</div>
                    <h3 class="step-title">Recipient Submits Request</h3>
                    <p class="step-desc">Charity recipients submit a detailed donation request along with supporting
                        documents (ID, proof of need) through the BlockAid portal. All files are hashed on upload.</p>
                </article>

                <article class="step-card">
                    <div class="step-num">2</div>
                    <div class="step-icon">🔎</div>
                    <h3 class="step-title">Admin Verifies Request</h3>
                    <p class="step-desc">Assigned admins review submitted documents, cross-check authenticity, and
                        approve or reject requests. Every admin action is recorded in tamper-proof audit logs.</p>
                </article>

                <article class="step-card">
                    <div class="step-num">3</div>
                    <div class="step-icon">🏦</div>
                    <h3 class="step-title">Donor Transfers &amp; Uploads Slip</h3>
                    <p class="step-desc">Donors complete bank transfers and upload their payment slip to the platform.
                        The slip is hashed (SHA-256) and checked against existing records to prevent duplicate
                        submissions.</p>
                </article>

                <article class="step-card">
                    <div class="step-num">4</div>
                    <div class="step-icon">⛓</div>
                    <h3 class="step-title">Hash Written to Blockchain</h3>
                    <p class="step-desc">After admin verification of the slip, a cryptographic record hash is
                        permanently written to the blockchain. The transaction hash is public and immutable — anyone can
                        verify it.</p>
                </article>

            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════
     KEY FEATURES
═══════════════════════════════════════════════ -->
    <section id="features" class="section" aria-labelledby="feat-heading">
        <div class="container">
            <div class="section-label">Capabilities</div>
            <h2 class="section-title" id="feat-heading">Built for Trust at Every Layer</h2>
            <p class="section-sub">Every feature is designed to eliminate fraud, ensure accountability, and give donors
                verifiable proof of impact.</p>
            <div class="features-grid">

                <article class="feature-card">
                    <div class="feat-icon">✅</div>
                    <h3 class="feat-title">Verified Requests</h3>
                    <p class="feat-desc">Each donation request undergoes multi-stage human review before it's made
                        public. Only approved requests are visible to donors, ensuring legitimacy.</p>
                </article>

                <article class="feature-card">
                    <div class="feat-icon">🔐</div>
                    <h3 class="feat-title">Secure Document Upload + SHA-256 Hashing</h3>
                    <p class="feat-desc">Uploaded documents are hashed with SHA-256 immediately on receipt. The hash
                        fingerprint is stored — not the raw file — providing tamper-evidence without data exposure.</p>
                </article>

                <article class="feature-card">
                    <div class="feat-icon">👩‍💼</div>
                    <h3 class="feat-title">Admin Approval Workflow</h3>
                    <p class="feat-desc">Structured approval flows with role-based access ensure only authorized
                        personnel can approve requests, verify slips, and advance records to the blockchain.</p>
                </article>

                <article class="feature-card">
                    <div class="feat-icon">🌐</div>
                    <h3 class="feat-title">Public Ledger with Tx Hash</h3>
                    <p class="feat-desc">Every verified donation generates a blockchain transaction hash visible to the
                        public. Anyone can cross-reference the hash on the network to confirm authenticity.</p>
                </article>

                <article class="feature-card">
                    <div class="feat-icon">🚨</div>
                    <h3 class="feat-title">Fraud Detection</h3>
                    <p class="feat-desc">Automated checks flag duplicate payment slips, duplicate transaction
                        references, and inconsistent amounts — catching common fraud patterns before admin review.</p>
                </article>

                <article class="feature-card">
                    <div class="feat-icon">📜</div>
                    <h3 class="feat-title">Audit Logs for Admin Actions</h3>
                    <p class="feat-desc">Every admin action — approvals, rejections, overrides — is logged with
                        timestamp, user identity, and IP. Logs are immutable and exportable for compliance.</p>
                </article>

            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════
     VERIFIED REQUESTS PREVIEW
═══════════════════════════════════════════════ -->
    <section id="requests" class="section" aria-labelledby="req-heading">
        <div class="container">
            <div class="section-label">Live Preview</div>
            <h2 class="section-title" id="req-heading">Verified Donation Requests</h2>
            <p class="section-sub">Explore active, verified requests. Every card you see has passed admin document
                review.</p>

            <div class="requests-grid">

                <!-- Request 1 -->
                <article class="request-card">
                    <div class="req-header">
                        <span class="req-category">Medical</span>
                        <span class="badge-verified">Verified</span>
                    </div>
                    <div class="req-body">
                        <h3 class="req-title">Cancer Treatment Fund for Aisha Razak</h3>
                        <p class="req-desc">Covering chemotherapy and oncology consultation costs for a single mother of
                            three at Hospital Kuala Lumpur.</p>
                        <div class="req-progress">
                            <div class="progress-labels">
                                <span class="progress-label-left">RM 12,400 raised</span>
                                <span class="progress-label-right">62% funded</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width:62%"></div>
                            </div>
                            <div style="font-size:.78rem;color:var(--c-muted);margin-top:.35rem">Goal: RM 20,000</div>
                        </div>
                        <div class="req-footer">
                            <span class="req-id">REQ-2024-0041</span>
                            <a href="#" class="btn btn-outline btn-sm">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Request 2 -->
                <article class="request-card">
                    <div class="req-header">
                        <span class="req-category">Education</span>
                        <span class="badge-verified">Verified</span>
                    </div>
                    <div class="req-body">
                        <h3 class="req-title">University Scholarship for Rural Students</h3>
                        <p class="req-desc">Supporting five B40 students with tuition fees and living allowances for the
                            2024/25 academic year at public universities.</p>
                        <div class="req-progress">
                            <div class="progress-labels">
                                <span class="progress-label-left">RM 8,750 raised</span>
                                <span class="progress-label-right">88% funded</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width:88%"></div>
                            </div>
                            <div style="font-size:.78rem;color:var(--c-muted);margin-top:.35rem">Goal: RM 10,000</div>
                        </div>
                        <div class="req-footer">
                            <span class="req-id">REQ-2024-0058</span>
                            <a href="#" class="btn btn-outline btn-sm">View Details</a>
                        </div>
                    </div>
                </article>

                <!-- Request 3 -->
                <article class="request-card">
                    <div class="req-header">
                        <span class="req-category">Disaster Relief</span>
                        <span class="badge-verified">Verified</span>
                    </div>
                    <div class="req-body">
                        <h3 class="req-title">Flood Recovery – Kelantan Families</h3>
                        <p class="req-desc">Emergency aid for 30 flood-displaced families in Kelantan covering temporary
                            shelter, food supplies, and basic reconstruction materials.</p>
                        <div class="req-progress">
                            <div class="progress-labels">
                                <span class="progress-label-left">RM 27,100 raised</span>
                                <span class="progress-label-right">45% funded</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width:45%"></div>
                            </div>
                            <div style="font-size:.78rem;color:var(--c-muted);margin-top:.35rem">Goal: RM 60,000</div>
                        </div>
                        <div class="req-footer">
                            <span class="req-id">REQ-2024-0072</span>
                            <a href="#" class="btn btn-outline btn-sm">View Details</a>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════
     PUBLIC LEDGER PREVIEW
═══════════════════════════════════════════════ -->
    <section id="ledger" class="section" aria-labelledby="ledger-heading">
        <div class="container">
            <div class="section-label">Blockchain Ledger</div>
            <h2 class="section-title" id="ledger-heading">Public Transaction Ledger</h2>
            <p class="section-sub">Every verified event is permanently recorded. These records are on-chain and cannot
                be altered or deleted.</p>

            <div class="table-wrap">
                <table aria-label="Public blockchain donation ledger">
                    <thead>
                        <tr>
                            <th scope="col">Record Type</th>
                            <th scope="col">Request ID</th>
                            <th scope="col">Amount (RM)</th>
                            <th scope="col">Date</th>
                            <th scope="col">Tx Hash</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="rec-type type-donation">Donation Verified</span></td>
                            <td>REQ-2024-0041</td>
                            <td>2,500.00</td>
                            <td>14 Nov 2024</td>
                            <td class="tx-hash">0x3a9f4b…c4d2e1</td>
                        </tr>
                        <tr>
                            <td><span class="rec-type type-verify">Request Approved</span></td>
                            <td>REQ-2024-0058</td>
                            <td>—</td>
                            <td>12 Nov 2024</td>
                            <td class="tx-hash">0xd71c2a…09b3f5</td>
                        </tr>
                        <tr>
                            <td><span class="rec-type type-donation">Donation Verified</span></td>
                            <td>REQ-2024-0058</td>
                            <td>1,000.00</td>
                            <td>11 Nov 2024</td>
                            <td class="tx-hash">0xf02e8d…77aa12</td>
                        </tr>
                        <tr>
                            <td><span class="rec-type type-request">New Request</span></td>
                            <td>REQ-2024-0072</td>
                            <td>—</td>
                            <td>09 Nov 2024</td>
                            <td class="tx-hash">0x8bc194…3e50d6</td>
                        </tr>
                        <tr>
                            <td><span class="rec-type type-donation">Donation Verified</span></td>
                            <td>REQ-2024-0041</td>
                            <td>500.00</td>
                            <td>07 Nov 2024</td>
                            <td class="tx-hash">0x21ff7e…b29c08</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════
     SECURITY
═══════════════════════════════════════════════ -->
    <section id="security" class="section" aria-labelledby="sec-heading">
        <div class="container">
            <div class="security-grid">
                <div>
                    <div class="section-label">Security &amp; Compliance</div>
                    <h2 class="section-title" id="sec-heading">Built on Industry-Standard Security Practices</h2>
                    <p style="color:var(--c-muted);font-size:.95rem;line-height:1.7;margin-bottom:1rem;">
                        BlockAid is engineered with OWASP guidelines at its core. Documents never touch the blockchain —
                        only cryptographic proof does.
                    </p>
                    <ul class="sec-list" aria-label="Security features">
                        <li class="sec-item">
                            <span class="sec-ico">🔑</span>
                            <div>
                                <div class="sec-name">Role-Based Access Control (RBAC)</div>
                                <div class="sec-text">Admins, donors, and recipients each have strictly scoped
                                    permissions. No user can perform actions outside their assigned role.</div>
                            </div>
                        </li>
                        <li class="sec-item">
                            <span class="sec-ico">🛡</span>
                            <div>
                                <div class="sec-name">CSRF Protection</div>
                                <div class="sec-text">Every state-changing request requires a CSRF token validated
                                    server-side, preventing cross-site request forgery attacks.</div>
                            </div>
                        </li>
                        <li class="sec-item">
                            <span class="sec-ico">🧹</span>
                            <div>
                                <div class="sec-name">Input Validation &amp; Sanitization</div>
                                <div class="sec-text">All user inputs are validated and sanitized at both client and
                                    server levels to prevent injection attacks and malformed data.</div>
                            </div>
                        </li>
                        <li class="sec-item">
                            <span class="sec-ico">📎</span>
                            <div>
                                <div class="sec-name">Secure File Uploads</div>
                                <div class="sec-text">Uploaded files are type-checked, size-limited, renamed, and stored
                                    in isolated storage. MIME type spoofing is actively detected and blocked.</div>
                            </div>
                        </li>
                        <li class="sec-item">
                            <span class="sec-ico">📜</span>
                            <div>
                                <div class="sec-name">Immutable Audit Logging</div>
                                <div class="sec-text">All privileged actions are logged with user ID, timestamp, and IP.
                                    Logs cannot be modified and are regularly exported for compliance review.</div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div>
                    <div class="chain-visual" aria-label="Blockchain record diagram">
                        <div class="chain-title">⛓ On-Chain vs Off-Chain Storage</div>
                        <div class="chain-block">
                            <div class="cb-row">
                                <span class="cb-label">Stored OFF-CHAIN (Secure Server)</span>
                            </div>
                            <div style="font-size:.82rem;color:rgba(255,255,255,.55);line-height:1.6;">
                                📄 Original PDF documents<br />
                                🖼 Payment slip images<br />
                                👤 Personal identity files<br />
                                📋 Application form data
                            </div>
                        </div>
                        <div class="chain-arrow">↓ SHA-256 hash computed ↓</div>
                        <div class="chain-block">
                            <div class="cb-row">
                                <span class="cb-label">Written ON-CHAIN (Immutable)</span>
                            </div>
                            <div style="font-size:.82rem;line-height:1.7;">
                                <div class="cb-row"><span class="cb-label">Record Type</span><span
                                        class="cb-val">Donation Verified</span></div>
                                <div class="cb-row"><span class="cb-label">Doc Hash (SHA-256)</span><span
                                        class="cb-val">3a9f4b7e…c4d2</span></div>
                                <div class="cb-row"><span class="cb-label">Slip Hash</span><span
                                        class="cb-val">d71c2a0f…09b3</span></div>
                                <div class="cb-row"><span class="cb-label">Timestamp</span><span
                                        class="cb-val">2024-11-14 09:42:11</span></div>
                                <div class="cb-row"><span class="cb-label">Tx Hash</span><span
                                        class="cb-val">0x3a9f4b…c4d2e1</span></div>
                            </div>
                        </div>
                        <div class="chain-arrow">↓ publicly verifiable ↓</div>
                        <div class="chain-block" style="text-align:center;">
                            <div
                                style="color:var(--c-accent);font-family:var(--ff-head);font-weight:800;font-size:1rem;">
                                🌐 Public Blockchain Network</div>
                            <div style="font-size:.8rem;color:rgba(255,255,255,.4);margin-top:.3rem;">Anyone can verify.
                                No one can alter.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════
     FAQ
═══════════════════════════════════════════════ -->
    <section id="faq" class="section" aria-labelledby="faq-heading">
        <div class="container">
            <div class="section-label">FAQ</div>
            <h2 class="section-title" id="faq-heading">Frequently Asked Questions</h2>
            <p class="section-sub">Got questions? We have clear, honest answers about how BlockAid works and keeps your
                donations safe.</p>

            <div class="faq-list" role="list">

                <div class="faq-item" role="listitem">
                    <div class="faq-q" role="button" tabindex="0" aria-expanded="false" aria-controls="faq-a1">
                        Do you store documents on blockchain?
                        <span class="faq-icon" aria-hidden="true">+</span>
                    </div>
                    <div class="faq-a" id="faq-a1" role="region">
                        No. BlockAid follows a strict off-chain / on-chain separation principle. All original documents
                        — identity files, payment slips, application forms — are stored securely on our private servers,
                        never on the blockchain. Only the SHA-256 cryptographic hash of each document is written
                        on-chain. This means you can verify that a document has not been tampered with (by comparing
                        hashes) without ever exposing the actual document publicly. This protects donor and recipient
                        privacy while preserving integrity.
                    </div>
                </div>

                <div class="faq-item" role="listitem">
                    <div class="faq-q" role="button" tabindex="0" aria-expanded="false" aria-controls="faq-a2">
                        How do donors make donations?
                        <span class="faq-icon" aria-hidden="true">+</span>
                    </div>
                    <div class="faq-a" id="faq-a2" role="region">
                        Donations are made via direct bank transfer to a verified BlockAid escrow account. After
                        completing the transfer, the donor logs in to the platform and uploads their bank payment slip.
                        The slip is automatically hashed (SHA-256) and cross-checked for duplicates before an admin
                        reviews it. Once the admin confirms the transaction, the donation is recorded and the proof hash
                        is written to the blockchain. This approach keeps financial flows auditable without relying on
                        third-party payment gateways.
                    </div>
                </div>

                <div class="faq-item" role="listitem">
                    <div class="faq-q" role="button" tabindex="0" aria-expanded="false" aria-controls="faq-a3">
                        How does BlockAid reduce donation fraud?
                        <span class="faq-icon" aria-hidden="true">+</span>
                    </div>
                    <div class="faq-a" id="faq-a3" role="region">
                        Fraud prevention operates at multiple layers. First, every donation request is manually verified
                        by an admin who reviews supporting documents before the request goes public. Second, payment
                        slips are SHA-256 hashed on upload and compared against existing records — any attempt to reuse
                        a slip for multiple donations is immediately flagged. Third, transaction reference numbers are
                        validated for uniqueness. Fourth, every admin action is logged in immutable audit logs, so any
                        insider manipulation is traceable. These combined controls make fraudulent activity extremely
                        difficult to execute and impossible to hide.
                    </div>
                </div>

                <div class="faq-item" role="listitem">
                    <div class="faq-q" role="button" tabindex="0" aria-expanded="false" aria-controls="faq-a4">
                        Who can see the public ledger?
                        <span class="faq-icon" aria-hidden="true">+</span>
                    </div>
                    <div class="faq-a" id="faq-a4" role="region">
                        Anyone, without registration. The public ledger displays record types, request IDs, donation
                        amounts, dates, and blockchain transaction hashes. Sensitive personal information is never
                        included — only anonymized transaction data and verifiable hashes. You can independently verify
                        any transaction hash on the blockchain network to confirm it exists and has not been modified.
                    </div>
                </div>

                <div class="faq-item" role="listitem">
                    <div class="faq-q" role="button" tabindex="0" aria-expanded="false" aria-controls="faq-a5">
                        Is BlockAid open to organizations or only individuals?
                        <span class="faq-icon" aria-hidden="true">+</span>
                    </div>
                    <div class="faq-a" id="faq-a5" role="region">
                        BlockAid accepts requests from both registered non-profit organizations and verified individuals
                        in need. All applicants go through the same rigorous document verification process.
                        Organizations must provide registration certificates, while individuals must provide proof of
                        identity and need. The goal is to ensure every request on the platform is genuine, regardless of
                        whether it comes from a charity or a person.
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════
     CONTACT
═══════════════════════════════════════════════ -->
    <section id="contact" class="section" aria-labelledby="contact-heading">
        <div class="container">
            <div class="contact-grid">
                <div>
                    <div class="section-label">Get In Touch</div>
                    <h2 class="section-title" id="contact-heading">Questions or Partnership Enquiries?</h2>
                    <p style="color:var(--c-muted);font-size:.95rem;line-height:1.7;margin-bottom:1rem;">
                        Whether you're a charity looking to register, a donor seeking guidance, or an organization
                        interested in integrating BlockAid — we'd love to hear from you.
                    </p>
                    <ul class="contact-info-list" aria-label="Contact details">
                        <li class="cinfo-item">
                            <div class="cinfo-icon">📧</div>
                            <div>
                                <div class="cinfo-label">Email</div>
                                <div class="cinfo-val">hello@blockaid.org</div>
                            </div>
                        </li>
                        <li class="cinfo-item">
                            <div class="cinfo-icon">📍</div>
                            <div>
                                <div class="cinfo-label">Address</div>
                                <div class="cinfo-val">Kuala Lumpur, Malaysia</div>
                            </div>
                        </li>
                        <li class="cinfo-item">
                            <div class="cinfo-icon">🕘</div>
                            <div>
                                <div class="cinfo-label">Support Hours</div>
                                <div class="cinfo-val">Monday – Friday, 9am – 6pm MYT</div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="contact-form" role="form" aria-label="Contact form">
                    <h3
                        style="font-family:var(--ff-head);font-size:1.2rem;font-weight:800;color:var(--c-dark);margin-bottom:1.5rem;">
                        Send Us a Message</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cf-name">Full Name</label>
                            <input type="text" id="cf-name" name="name" placeholder="Your name" autocomplete="name" />
                        </div>
                        <div class="form-group">
                            <label for="cf-email">Email Address</label>
                            <input type="email" id="cf-email" name="email" placeholder="you@example.com"
                                autocomplete="email" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cf-subject">Subject</label>
                        <input type="text" id="cf-subject" name="subject" placeholder="How can we help?" />
                    </div>
                    <div class="form-group">
                        <label for="cf-message">Message</label>
                        <textarea id="cf-message" name="message"
                            placeholder="Tell us more about your enquiry..."></textarea>
                    </div>
                    <button type="button" class="btn btn-primary" style="width:100%;justify-content:center;"
                        onclick="handleFormSubmit(this)">
                        Send Message →
                    </button>
                </div>
            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════════ -->
    <footer role="contentinfo">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="footer-logo">
                       <img src="img/blockaid_logo.png" alt="BlockAid Logo" class="logo-img">
                        BlockAid
                    </div>
                    <p class="footer-tagline">
                        Transparent, blockchain-backed charity donations. Every contribution verified. Every record
                        immutable.
                    </p>
                    <div class="social-links" aria-label="Social media links">
                        <a href="#" class="social-link" aria-label="Twitter / X">𝕏</a>
                        <a href="#" class="social-link" aria-label="LinkedIn">in</a>
                        <a href="#" class="social-link" aria-label="GitHub">⌥</a>
                        <a href="#" class="social-link" aria-label="Telegram">✈</a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Platform</h4>
                    <ul>
                        <li><a href="#how-it-works">How It Works</a></li>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#requests">Browse Requests</a></li>
                        <li><a href="#ledger">Public Ledger</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Trust</h4>
                    <ul>
                        <li><a href="#security">Security</a></li>
                        <li><a href="#faq">FAQ</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Use</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Account</h4>
                    <ul>
                        <li><a href="#">Log In</a></li>
                        <li><a href="#">Register</a></li>
                        <li><a href="#">Admin Portal</a></li>
                        <li><a href="#contact">Contact Us</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <span>© 2024 BlockAid. All rights reserved. Built for transparency.</span>
                <span>Powered by Blockchain Technology &amp; SHA-256 Integrity</span>
            </div>
        </div>
    </footer>


    <!-- ═══════════════════════════════════════════
     JAVASCRIPT
═══════════════════════════════════════════════ -->
    <script>
        // Sticky navbar shadow
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 10);
        });

        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        menuToggle.addEventListener('click', () => {
            const open = mobileMenu.classList.toggle('open');
            menuToggle.setAttribute('aria-expanded', open);
            menuToggle.textContent = open ? '✕' : '☰';
        });

        // Close mobile menu on nav link click
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('open');
                menuToggle.setAttribute('aria-expanded', false);
                menuToggle.textContent = '☰';
            });
        });

        // FAQ accordion
        document.querySelectorAll('.faq-q').forEach(btn => {
            btn.addEventListener('click', () => {
                const item = btn.closest('.faq-item');
                const expanded = item.classList.toggle('open');
                btn.setAttribute('aria-expanded', expanded);
            });
            btn.addEventListener('keydown', e => {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); btn.click(); }
            });
        });

        // Contact form mock submit
        function handleFormSubmit(btn) {
            const name = document.getElementById('cf-name').value.trim();
            const email = document.getElementById('cf-email').value.trim();
            const msg = document.getElementById('cf-message').value.trim();
            if (!name || !email || !msg) {
                btn.textContent = '⚠ Please fill all required fields';
                btn.style.background = 'var(--c-warning)';
                setTimeout(() => { btn.textContent = 'Send Message →'; btn.style.background = ''; }, 2500);
                return;
            }
            btn.textContent = '✓ Message Sent!';
            btn.style.background = 'var(--c-success)';
            setTimeout(() => { btn.textContent = 'Send Message →'; btn.style.background = ''; }, 3000);
        }
    </script>

</body>

</html>