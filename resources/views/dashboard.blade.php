@extends('adminlte::page')

@section('title', 'Medical Command Center')

@section('content_header')
@stop

@section('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-deep: #F8FAFC;
            --bg-surface: #FFFFFF;
            --bg-elevated: #F1F5F9;
            --bg-card: rgba(255, 255, 255, 0.95);
            --bg-glass: rgba(255, 255, 255, 0.80);
            --text-primary: #0F172A;
            --text-secondary: #475569;
            --text-tertiary: #64748B;
            --text-muted: #94A3B8;
            --text-inverse: #FFFFFF;
            --border-subtle: rgba(148, 163, 184, 0.20);
            --border-medium: rgba(148, 163, 184, 0.35);
            --border-glow: rgba(15, 157, 138, 0.25);
            --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.06), 0 1px 2px rgba(15, 23, 42, 0.04);
            --shadow-md: 0 4px 16px rgba(15, 23, 42, 0.08), 0 2px 8px rgba(15, 23, 42, 0.04);
            --shadow-lg: 0 12px 40px rgba(15, 23, 42, 0.10), 0 4px 12px rgba(15, 23, 42, 0.05);
            --shadow-xl: 0 20px 60px rgba(15, 23, 42, 0.12);
            --hero-bg: linear-gradient(135deg, #0A2647 0%, #144272 50%, #0F4F4A 100%);
            --hero-text: #FFFFFF;
            --hero-text-muted: #C5D8E3;
            --hero-glass: rgba(255, 255, 255, 0.10);
            --hero-border: rgba(255, 255, 255, 0.12);
            --accent-teal: #0F9D8A;
            --accent-teal-light: #2DD4BF;
            --accent-teal-dim: rgba(15, 157, 138, 0.10);
            --accent-blue: #3B8FC2;
            --accent-blue-dim: rgba(59, 143, 194, 0.10);
            --accent-amber: #C89B3C;
            --accent-amber-dim: rgba(200, 155, 60, 0.10);
            --accent-rose: #D65A5A;
            --accent-rose-dim: rgba(214, 90, 90, 0.10);
            --accent-violet: #7B5EA7;
            --accent-violet-dim: rgba(123, 94, 167, 0.10);
            --accent-navy: #0A2647;
            --accent-navy-dim: rgba(10, 38, 71, 0.08);
            --chart-grid: rgba(148, 163, 184, 0.15);
            --chart-text: #64748B;
            --chart-tooltip-bg: rgba(255, 255, 255, 0.98);
            --chart-tooltip-border: rgba(148, 163, 184, 0.25);
            --alert-amber-bg: #FFFBEB;
            --alert-amber-border: #FDE68A;
            --alert-amber-text: #92400E;
            --alert-amber-icon: #D97706;
            --progress-track: #E2E8F0;
            --progress-fill: linear-gradient(90deg, var(--accent-teal), var(--accent-teal-light));
            --radius: 20px;
            --radius-lg: 22px;
            --radius-md: 16px;
            --radius-sm: 12px;
            --radius-xs: 8px;
        }

        [data-theme="dark"] {
            --bg-deep: #070B14;
            --bg-surface: #0D111C;
            --bg-elevated: #131A2A;
            --bg-card: rgba(19, 26, 42, 0.70);
            --bg-glass: rgba(13, 17, 28, 0.75);
            --text-primary: #F0F4F8;
            --text-secondary: #94A3B8;
            --text-tertiary: #64748B;
            --text-muted: #475569;
            --text-inverse: #0F172A;
            --border-subtle: rgba(148, 163, 184, 0.08);
            --border-medium: rgba(148, 163, 184, 0.15);
            --border-glow: rgba(0, 229, 201, 0.20);
            --shadow-sm: 0 0 0 1px var(--border-subtle), 0 4px 12px rgba(0,0,0,0.40);
            --shadow-md: 0 0 0 1px var(--border-subtle), 0 8px 32px rgba(0,0,0,0.50);
            --shadow-lg: 0 0 0 1px var(--border-subtle), 0 16px 48px rgba(0,0,0,0.60);
            --shadow-xl: 0 0 0 1px var(--border-subtle), 0 24px 64px rgba(0,0,0,0.70);
            --hero-bg: linear-gradient(135deg, #0A1628 0%, #0D1F35 50%, #0A2E2A 100%);
            --hero-text: #FFFFFF;
            --hero-text-muted: #94A3B8;
            --hero-glass: rgba(255, 255, 255, 0.05);
            --hero-border: rgba(255, 255, 255, 0.08);
            --accent-teal: #00E5C9;
            --accent-teal-light: #2DD4BF;
            --accent-teal-dim: rgba(0, 229, 201, 0.12);
            --accent-blue: #3B82F6;
            --accent-blue-dim: rgba(59, 130, 246, 0.12);
            --accent-amber: #F59E0B;
            --accent-amber-dim: rgba(245, 158, 11, 0.12);
            --accent-rose: #F43F5E;
            --accent-rose-dim: rgba(244, 63, 94, 0.12);
            --accent-violet: #8B5CF6;
            --accent-violet-dim: rgba(139, 92, 246, 0.12);
            --accent-navy: #1E293B;
            --accent-navy-dim: rgba(30, 41, 59, 0.30);
            --chart-grid: rgba(148, 163, 184, 0.08);
            --chart-text: #64748B;
            --chart-tooltip-bg: rgba(13, 17, 28, 0.98);
            --chart-tooltip-border: rgba(148, 163, 184, 0.12);
            --alert-amber-bg: rgba(245, 158, 11, 0.06);
            --alert-amber-border: rgba(245, 158, 11, 0.15);
            --alert-amber-text: #FCD34D;
            --alert-amber-icon: #F59E0B;
            --progress-track: rgba(255, 255, 255, 0.06);
            --progress-fill: linear-gradient(90deg, var(--accent-teal), #0EA5E9);
        }

        .content-wrapper {
            background: var(--bg-deep);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            color: var(--text-primary);
            transition: background-color 0.4s ease, color 0.4s ease;
        }
        .content { padding: 24px; }
        h1, h2, h3, .card-title, .metric-value {
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -0.03em;
            font-weight: 700;
        }
        .badge, .status-badge, .metric-label, .mono {
            font-family: 'JetBrains Mono', monospace;
            letter-spacing: -0.01em;
        }

        .theme-toggle {
            position: fixed;
            top: 80px;
            right: 24px;
            z-index: 9999;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--bg-card);
            border: 1px solid var(--border-medium);
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1);
            font-size: 1.2rem;
            color: var(--text-secondary);
        }
        .theme-toggle:hover {
            transform: scale(1.1) rotate(15deg);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent-teal);
            color: var(--accent-teal);
        }
        .theme-toggle:active { transform: scale(0.95); }
        .theme-toggle .icon-sun { display: none; }
        .theme-toggle .icon-moon { display: block; }
        [data-theme="dark"] .theme-toggle .icon-sun { display: block; }
        [data-theme="dark"] .theme-toggle .icon-moon { display: none; }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 0 4px;
        }
        .page-header-left { display: flex; flex-direction: column; gap: 4px; }
        .page-header-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--text-muted);
        }
        .page-header-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }
        .page-header-desc {
            font-size: 0.8rem;
            color: var(--text-tertiary);
            max-width: 400px;
        }
        .page-header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .update-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent-teal-dim);
            border: 1px solid var(--border-glow);
            color: var(--accent-teal);
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .update-badge .pulse {
            width: 6px; height: 6px;
            background: var(--accent-teal);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.3); }
        }
        .period-chip {
            background: var(--bg-elevated);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-xs);
            padding: 6px 14px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            font-family: 'JetBrains Mono', monospace;
        }

        .hero-command {
            position: relative;
            border-radius: var(--radius-lg);
            background: var(--hero-bg);
            padding: 40px 40px 36px;
            margin-bottom: 24px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: var(--shadow-xl);
        }
        .hero-command::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -5%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(45, 212, 191, 0.12) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-command::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
            pointer-events: none;
        }
        .hero-ekg {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 45px;
            opacity: 0.18;
            pointer-events: none;
        }
        .hero-ekg path {
            stroke: var(--accent-teal-light);
            stroke-width: 2;
            fill: none;
            filter: drop-shadow(0 0 6px var(--accent-teal));
        }
        .hero-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 40px;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(45, 212, 191, 0.12);
            border: 1px solid rgba(45, 212, 191, 0.20);
            color: #A6F0E0;
            padding: 5px 14px;
            border-radius: 999px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin-bottom: 16px;
            width: fit-content;
        }
        .hero-title {
            font-size: clamp(1.8rem, 3.5vw, 2.8rem);
            font-weight: 800;
            color: var(--hero-text);
            line-height: 1.15;
            margin-bottom: 10px;
            letter-spacing: -0.04em;
        }
        .hero-desc {
            color: var(--hero-text-muted);
            font-size: 1rem;
            max-width: 520px;
            line-height: 1.6;
            margin-bottom: 0;
        }
        .hero-panel {
            background: var(--hero-glass);
            backdrop-filter: blur(16px);
            border: 1px solid var(--hero-border);
            border-radius: var(--radius-md);
            padding: 24px 28px;
            min-width: 240px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }
        .hero-panel-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }
        .hero-panel-item:last-child { border-bottom: none; }
        .hero-panel-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--hero-text-muted);
            font-weight: 600;
        }
        .hero-panel-value {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--hero-text);
            font-family: 'JetBrains Mono', monospace;
        }
        .hero-panel-value.teal { color: var(--accent-teal-light); }

        .filter-bar {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            padding: 14px 18px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
            backdrop-filter: blur(8px);
        }
        .filter-bar .form-control {
            background: var(--bg-elevated);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-xs);
            color: var(--text-primary);
            height: 42px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            padding-left: 36px;
        }
        .filter-bar .form-control:focus {
            background-color: var(--bg-surface);
            border-color: var(--accent-teal);
            box-shadow: 0 0 0 3px var(--accent-teal-dim);
            color: var(--text-primary);
            outline: none;
        }
        .filter-bar label {
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            margin-bottom: 4px;
            display: block;
        }
        .filter-bar .btn-primary {
            height: 42px;
            border-radius: var(--radius-xs);
            background: linear-gradient(135deg, var(--accent-teal), #0C7A6A);
            border: none;
            color: #FFFFFF;
            font-weight: 700;
            font-size: 0.85rem;
            box-shadow: 0 4px 16px rgba(15, 157, 138, 0.30);
            transition: all 0.25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .filter-bar .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(15, 157, 138, 0.40);
        }
        .filter-icon-wrap { position: relative; }
        .filter-icon-wrap i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.85rem;
            pointer-events: none;
            z-index: 2;
        }

        .kpi-grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 16px;
        }
        @media (max-width: 1200px) { .kpi-grid-4 { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 576px) { .kpi-grid-4 { grid-template-columns: 1fr; } }

        .kpi-premium {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius);
            padding: 24px 22px 20px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1);
            box-shadow: var(--shadow-sm);
        }
        .kpi-premium::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: var(--kpi-accent);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .kpi-premium:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--border-medium);
        }
        .kpi-premium:hover::before { opacity: 1; }
        .kpi-premium.teal { --kpi-accent: var(--accent-teal); }
        .kpi-premium.blue  { --kpi-accent: var(--accent-blue); }
        .kpi-premium.amber { --kpi-accent: var(--accent-amber); }
        .kpi-premium.sky   { --kpi-accent: var(--accent-blue); }
        .kpi-premium-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        .kpi-premium-icon {
            width: 44px; height: 44px;
            border-radius: var(--radius-xs);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        .kpi-premium.teal .kpi-premium-icon { background: var(--accent-teal-dim); color: var(--accent-teal); }
        .kpi-premium.blue .kpi-premium-icon { background: var(--accent-blue-dim); color: var(--accent-blue); }
        .kpi-premium.amber .kpi-premium-icon { background: var(--accent-amber-dim); color: var(--accent-amber); }
        .kpi-premium.sky .kpi-premium-icon { background: var(--accent-blue-dim); color: var(--accent-blue); }
        .kpi-premium-badge {
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 4px 10px;
            border-radius: 999px;
            background: var(--bg-elevated);
            color: var(--text-muted);
            border: 1px solid var(--border-subtle);
        }
        .kpi-premium-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
        }
        .kpi-premium-value {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1;
            letter-spacing: -0.03em;
            margin-bottom: 8px;
        }
        .kpi-premium-foot {
            font-size: 0.8rem;
            color: var(--text-muted);
            padding-top: 10px;
            border-top: 1px solid var(--border-subtle);
        }
        .kpi-premium-foot strong {
            color: var(--text-secondary);
            font-weight: 600;
        }

        .kpi-grid-6 {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 12px;
            margin-bottom: 16px;
        }
        @media (max-width: 1200px) { .kpi-grid-6 { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 576px) { .kpi-grid-6 { grid-template-columns: repeat(2, 1fr); } }

        .kpi-compact {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            padding: 18px 16px;
            transition: all 0.25s;
            box-shadow: var(--shadow-sm);
        }
        .kpi-compact:hover {
            border-color: var(--border-medium);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        .kpi-compact-icon {
            width: 34px; height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        .kpi-compact-label {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 4px;
        }
        .kpi-compact-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
            letter-spacing: -0.02em;
        }
        .kpi-compact-sub {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 4px;
        }
        .kpi-compact-bar {
            height: 4px;
            background: var(--progress-track);
            border-radius: 999px;
            margin-top: 8px;
            overflow: hidden;
        }
        .kpi-compact-bar-fill {
            height: 100%;
            border-radius: 999px;
            background: var(--accent-teal);
            transition: width 1s ease;
        }
        .kpi-compact-status {
            font-size: 0.65rem;
            font-weight: 700;
            margin-top: 6px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .kpi-compact-status.optima { color: var(--accent-teal); }
        .kpi-compact-status.aceptable { color: var(--accent-amber); }
        .kpi-compact-status.revision { color: var(--accent-rose); }

        .alert-quality-card {
            background: var(--alert-amber-bg);
            border: 1px solid var(--alert-amber-border);
            border-left: 4px solid var(--alert-amber-icon);
            border-radius: var(--radius-sm);
            padding: 16px 20px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s;
        }
        .alert-quality-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }
        .alert-quality-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: var(--alert-amber-icon);
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .alert-quality-title {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--alert-amber-text);
            margin-bottom: 2px;
        }
        .alert-quality-text {
            font-size: 0.8rem;
            color: var(--alert-amber-text);
            opacity: 0.85;
            line-height: 1.5;
        }
        .alert-quality-count {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--alert-amber-icon);
        }

        .meta-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius);
            padding: 24px 28px;
            margin-bottom: 16px;
            box-shadow: var(--shadow-sm);
        }
        .meta-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        .meta-card-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .meta-card-percent {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--accent-teal);
        }
        .meta-progress-track {
            height: 10px;
            background: var(--progress-track);
            border-radius: 999px;
            overflow: hidden;
            position: relative;
        }
        .meta-progress-fill {
            height: 100%;
            border-radius: 999px;
            background: var(--progress-fill);
            box-shadow: 0 0 12px rgba(15, 157, 138, 0.3);
            transition: width 1.2s cubic-bezier(0.2, 0.9, 0.4, 1);
            position: relative;
        }
        .meta-progress-fill::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 2.5s ease-in-out infinite;
        }
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .meta-card-footer {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        .meta-card-footer strong {
            color: var(--text-secondary);
            font-weight: 600;
        }
        .meta-projection-note {
            margin-top: 12px;
            padding: 10px 14px;
            background: var(--accent-teal-dim);
            border: 1px solid var(--border-glow);
            border-radius: var(--radius-xs);
            font-size: 0.8rem;
            color: var(--accent-teal);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .chart-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius);
            padding: 22px 22px 16px;
            height: 100%;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s;
        }
        .chart-card:hover {
            border-color: var(--border-medium);
            box-shadow: var(--shadow-md);
        }
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }
        .chart-title-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .chart-title {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-primary);
            letter-spacing: -0.01em;
        }
        .chart-subtitle {
            font-size: 0.78rem;
            color: var(--text-muted);
        }
        .chart-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .chart-box { height: 300px; position: relative; }
        .chart-box-sm { height: 240px; }

        .exec-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius);
            padding: 22px;
            height: 100%;
            box-shadow: var(--shadow-sm);
        }
        .exec-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-primary);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .exec-reading-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }
        .exec-reading-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 12px;
            border-radius: var(--radius-xs);
            background: var(--bg-elevated);
            border: 1px solid var(--border-subtle);
            transition: all 0.2s;
        }
        .exec-reading-item:hover {
            border-color: var(--border-medium);
            transform: translateX(2px);
        }
        .exec-reading-icon {
            width: 28px; height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .exec-reading-icon.teal { background: var(--accent-teal-dim); color: var(--accent-teal); }
        .exec-reading-icon.blue { background: var(--accent-blue-dim); color: var(--accent-blue); }
        .exec-reading-icon.amber { background: var(--accent-amber-dim); color: var(--accent-amber); }
        .exec-reading-icon.rose { background: var(--accent-rose-dim); color: var(--accent-rose); }
        .exec-reading-icon.violet { background: var(--accent-violet-dim); color: var(--accent-violet); }
        .exec-reading-text {
            font-size: 0.82rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }
        .exec-milestones {
            border-top: 1px solid var(--border-subtle);
            padding-top: 16px;
        }
        .exec-milestone-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid var(--border-subtle);
        }
        .exec-milestone-row:last-child { border-bottom: none; }
        .exec-milestone-label {
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        .exec-milestone-value {
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--text-primary);
            font-family: 'JetBrains Mono', monospace;
        }

        .leader-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius);
            padding: 22px;
            height: 100%;
            box-shadow: var(--shadow-sm);
        }
        .leader-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-subtle);
        }
        .leader-avatar {
            width: 52px; height: 52px;
            border-radius: var(--radius-sm);
            background: var(--accent-violet-dim);
            color: var(--accent-violet);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        .leader-info-label {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 2px;
        }
        .leader-info-name {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }
        .leader-info-sub {
            font-size: 0.85rem;
            color: var(--text-tertiary);
            margin-top: 2px;
        }
        .leader-bar-track {
            height: 8px;
            background: var(--progress-track);
            border-radius: 999px;
            overflow: hidden;
            margin: 8px 0 16px;
        }
        .leader-bar-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--accent-violet), #A78BFA);
            transition: width 1s ease;
        }
        .leader-metric-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid var(--border-subtle);
        }
        .leader-metric-row:last-child { border-bottom: none; }
        .leader-metric-label {
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        .leader-metric-value {
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--text-primary);
            font-family: 'JetBrains Mono', monospace;
        }

        .final-metrics {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-top: 16px;
        }
        @media (max-width: 992px) { .final-metrics { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 576px) { .final-metrics { grid-template-columns: 1fr; } }
        .final-metric-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s;
        }
        .final-metric-card:hover { border-color: var(--border-medium); }
        .final-metric-icon {
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            flex-shrink: 0;
        }
        .final-metric-content {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .final-metric-label {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        .final-metric-value {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-primary);
            font-family: 'JetBrains Mono', monospace;
        }

        .dashboard-footer {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border-subtle);
            text-align: center;
        }
        .footer-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--bg-elevated);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-sm);
            padding: 10px 20px;
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        .footer-badge strong {
            color: var(--text-secondary);
            font-weight: 700;
        }

        @media (max-width: 767px) {
            .content { padding: 16px; }
            .theme-toggle { top: 70px; right: 12px; width: 40px; height: 40px; }
            .page-header { flex-direction: column; align-items: flex-start; gap: 8px; }
            .hero-grid { grid-template-columns: 1fr; gap: 20px; }
            .hero-panel { width: 100%; }
            .kpi-premium-value { font-size: 1.8rem; }
            .chart-box { height: 240px; }
            .chart-box-sm { height: 200px; }
            .filter-bar .row > div { margin-bottom: 8px; }
        }
        @media (min-width: 768px) and (max-width: 991px) {
            .kpi-premium-value { font-size: 2rem; }
            .chart-box { height: 260px; }
        }
    </style>
@stop

@section('content')

    @php
        $fmt = fn($numero) => number_format((float) $numero, 0, '.', ',');
        $fmtDecimal = fn($numero) => number_format((float) $numero, 1, '.', ',');

        $mesNombre = $meses[$mes] ?? $mes;
        $totalMes = $totalMes ?? 0;
        $totalAnio = $totalAnio ?? 0;
        $promedioDia = $promedioDia ?? 0;
        $diasDelMes = $diasDelMes ?? 0;
        $diasLaborablesMes = $diasLaborablesMes ?? 0;
        $diasLaborablesEvaluados = $diasLaborablesEvaluados ?? 0;
        $diasConAtencion = $diasConAtencion ?? 0;
        $diasSinRegistro = $diasSinRegistro ?? 0;
        $coberturaRegistro = $coberturaRegistro ?? 0;
        $promedioPorDiaConActividad = $promedioPorDiaConActividad ?? 0;
        $proyeccionMensual = $proyeccionMensual ?? 0;
        $registrosFinSemana = $registrosFinSemana ?? 0;
        $totalMenoresCinco = $totalMenoresCinco ?? 0;
        $promedioMensual = $promedioMensual ?? 0;
        $proyeccionAnual = $proyeccionAnual ?? 0;
        $acumuladoHastaMes = $acumuladoHastaMes ?? 0;
        $mesesEvaluados = $mesesEvaluados ?? 0;
        $mesesConMovimiento = $mesesConMovimiento ?? 0;
        $variacionMes = $variacionMes ?? null;
        $cumplimientoMeta = $cumplimientoMeta ?? null;
        $topConceptoNombre = $topConceptoNombre ?? 'Sin datos';
        $topConceptoCodigo = $topConceptoCodigo ?? '-';
        $topConceptoTotal = $topConceptoTotal ?? 0;
        $participacionTopConcepto = $participacionTopConcepto ?? 0;
        $topMedicoNombre = $topMedicoNombre ?? 'Sin datos';
        $topMedicoTotal = $topMedicoTotal ?? 0;
        $participacionTopMedico = $participacionTopMedico ?? 0;
        $mejorDia = $mejorDia ?? ['dia' => '-', 'total' => 0];
        $mejorMes = $mejorMes ?? ['nombre' => '-', 'total' => 0];
        $lecturaEjecutiva = $lecturaEjecutiva ?? [];
        $resumenMedico = $resumenMedico ?? 'Todos los médicos';
        $porcentajeMenoresCinco = $totalMes > 0 ? round(($totalMenoresCinco / $totalMes) * 100, 1) : 0;
        $productividadEsperada = $diasLaborablesMes > 0 ? round($proyeccionMensual / $diasLaborablesMes, 1) : 0;
        $faltanteMeta = $metaMensual && $metaMensual > $totalMes ? $metaMensual - $totalMes : 0;

        $estadoCobertura = match (true) {
            $coberturaRegistro >= 95 => ['texto' => 'Óptima', 'clase' => 'optima'],
            $coberturaRegistro >= 80 => ['texto' => 'Aceptable', 'clase' => 'aceptable'],
            default => ['texto' => 'Requiere revisión', 'clase' => 'revision'],
        };

        $estadoVariacion = match (true) {
            is_null($variacionMes) => ['texto' => 'Sin comparación', 'clase' => 'text-muted', 'icono' => 'fa-minus'],
            $variacionMes > 0 => ['texto' => 'Incremento', 'clase' => 'text-success', 'icono' => 'fa-arrow-up'],
            $variacionMes < 0 => ['texto' => 'Disminución', 'clase' => 'text-danger', 'icono' => 'fa-arrow-down'],
            default => ['texto' => 'Sin cambio', 'clase' => 'text-muted', 'icono' => 'fa-equals'],
        };
    @endphp

    <button class="theme-toggle" id="themeToggle" title="Cambiar tema">
        <i class="fas fa-sun icon-sun"></i>
        <i class="fas fa-moon icon-moon"></i>
    </button>

    <div class="page-header">
        <div class="page-header-left">
            <span class="page-header-label">Centro de Decisiones</span>
            <h1 class="page-header-title">Medical Command Center</h1>
            <p class="page-header-desc">Panel ejecutivo para monitoreo de productividad clínica y toma de decisiones estratégicas.</p>
        </div>
        <div class="page-header-right">
            <span class="update-badge">
                <span class="pulse"></span>
                Datos actualizados
            </span>
            <span class="period-chip">{{ $mesNombre }} {{ $anio }}</span>
        </div>
    </div>

    <div class="hero-command">
        <svg class="hero-ekg" viewBox="0 0 900 60" preserveAspectRatio="none" aria-hidden="true">
            <path d="M0,30 L180,30 L200,30 L215,8 L235,52 L250,20 L270,30 L420,30 L440,30 L455,8 L475,52 L490,20 L510,30 L720,30 L740,30 L755,8 L775,52 L790,20 L810,30 L900,30"/>
        </svg>
        <div class="hero-grid">
            <div>
                <div class="hero-kicker">
                    <i class="fas fa-brain" style="font-size:0.7rem;"></i>
                    Inteligencia clínica
                </div>
                <h1 class="hero-title">Panorama de pacientes atendidos</h1>
                <p class="hero-desc">Indicador oficial de productividad asistencial. Monitoreo en tiempo real del volumen de atenciones, cobertura del registro y proyecciones operativas.</p>
            </div>
            <div class="hero-panel">
                <div class="hero-panel-item">
                    <span class="hero-panel-label">Médico</span>
                    <span class="hero-panel-value">{{ $resumenMedico }}</span>
                </div>
                <div class="hero-panel-item">
                    <span class="hero-panel-label">Periodo</span>
                    <span class="hero-panel-value">{{ $mesNombre }} {{ $anio }}</span>
                </div>
                <div class="hero-panel-item">
                    <span class="hero-panel-label">Días evaluados</span>
                    <span class="hero-panel-value">{{ $diasLaborablesEvaluados }}</span>
                </div>
                <div class="hero-panel-item">
                    <span class="hero-panel-label">Cobertura</span>
                    <span class="hero-panel-value teal">{{ $fmtDecimal($coberturaRegistro) }}%</span>
                </div>
            </div>
        </div>
    </div>

    <div class="filter-bar">
        <form method="GET" action="{{ route('dashboard') }}">
            <div class="row align-items-end g-2">
                <div class="col-xl-2 col-lg-2 col-md-2 col-6">
                    <label for="anio">Año</label>
                    <div class="filter-icon-wrap">
                        <i class="fas fa-calendar"></i>
                        <input type="number" id="anio" name="anio" class="form-control" value="{{ $anio }}" min="2000" max="2100" required>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-6">
                    <label for="mes">Mes</label>
                    <div class="filter-icon-wrap">
                        <i class="fas fa-calendar-alt"></i>
                        <select id="mes" name="mes" class="form-control" required>
                            @foreach ($meses as $numero => $nombre)
                                <option value="{{ $numero }}" {{ (int) $mes === (int) $numero ? 'selected' : '' }}>
                                    {{ $nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                    <label for="medico_id">Médico</label>
                    <div class="filter-icon-wrap">
                        <i class="fas fa-user-md"></i>
                        <select id="medico_id" name="medico_id" class="form-control">
                            <option value="">Todos los médicos</option>
                            @foreach ($medicos as $medico)
                                <option value="{{ $medico->id }}" {{ (int) $medicoId === (int) $medico->id ? 'selected' : '' }}>
                                    {{ $medico->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-6">
                    <label for="meta_mensual">Meta mensual</label>
                    <div class="filter-icon-wrap">
                        <i class="fas fa-bullseye"></i>
                        <input type="number" id="meta_mensual" name="meta_mensual" class="form-control" value="{{ $metaMensual }}" min="0" placeholder="Opcional">
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-12">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Consultar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="kpi-grid-4">
        <div class="kpi-premium teal">
            <div class="kpi-premium-header">
                <div class="kpi-premium-icon"><i class="fas fa-hospital-user"></i></div>
                <span class="kpi-premium-badge">Mes actual</span>
            </div>
            <div class="kpi-premium-label">Pacientes atendidos del mes</div>
            <div class="kpi-premium-value">{{ $fmt($totalMes) }}</div>
            <div class="kpi-premium-foot">Total oficial del periodo seleccionado</div>
        </div>

        <div class="kpi-premium blue">
            <div class="kpi-premium-header">
                <div class="kpi-premium-icon"><i class="fas fa-chart-line"></i></div>
                <span class="kpi-premium-badge">Acumulado</span>
            </div>
            <div class="kpi-premium-label">Pacientes acumulados del año</div>
            <div class="kpi-premium-value">{{ $fmt($totalAnio) }}</div>
            <div class="kpi-premium-foot">Promedio mensual: <strong>{{ $fmtDecimal($promedioMensual) }}</strong></div>
        </div>

        <div class="kpi-premium amber">
            <div class="kpi-premium-header">
                <div class="kpi-premium-icon"><i class="fas fa-chart-area"></i></div>
                <span class="kpi-premium-badge">Proyección</span>
            </div>
            <div class="kpi-premium-label">Proyección al cierre del mes</div>
            <div class="kpi-premium-value">{{ $fmt($proyeccionMensual) }}</div>
            <div class="kpi-premium-foot">Estimación basada en ritmo actual</div>
        </div>

        <div class="kpi-premium sky">
            <div class="kpi-premium-header">
                <div class="kpi-premium-icon"><i class="fas fa-calendar-check"></i></div>
                <span class="kpi-premium-badge">Estimación</span>
            </div>
            <div class="kpi-premium-label">Proyección anual</div>
            <div class="kpi-premium-value">{{ $fmt($proyeccionAnual) }}</div>
            <div class="kpi-premium-foot">Cierre estimado según tendencia</div>
        </div>
    </div>

    <div class="kpi-grid-6">
        <div class="kpi-compact">
            <div class="kpi-compact-icon" style="background:var(--accent-violet-dim);color:var(--accent-violet);">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="kpi-compact-label">Promedio / día laborable</div>
            <div class="kpi-compact-value">{{ $fmtDecimal($promedioDia) }}</div>
        </div>

        <div class="kpi-compact">
            <div class="kpi-compact-icon" style="background:var(--accent-teal-dim);color:var(--accent-teal);">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="kpi-compact-label">Cobertura del registro</div>
            <div class="kpi-compact-value">{{ $fmtDecimal($coberturaRegistro) }}%</div>
            <div class="kpi-compact-sub">{{ $diasConAtencion }} de {{ $diasLaborablesEvaluados }} días</div>
            <div class="kpi-compact-bar">
                <div class="kpi-compact-bar-fill" style="width:{{ $coberturaRegistro }}%;"></div>
            </div>
            <div class="kpi-compact-status {{ $estadoCobertura['clase'] }}">{{ $estadoCobertura['texto'] }}</div>
        </div>

        <div class="kpi-compact">
            <div class="kpi-compact-icon" style="background:var(--accent-blue-dim);color:var(--accent-blue);">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="kpi-compact-label">Meses con actividad</div>
            <div class="kpi-compact-value">{{ $mesesConMovimiento }}<span style="font-size:0.85rem;color:var(--text-muted);">/{{ $mesesEvaluados }}</span></div>
        </div>

        <div class="kpi-compact">
            <div class="kpi-compact-icon" style="background:var(--accent-teal-dim);color:var(--accent-teal);">
                <i class="fas fa-child"></i>
            </div>
            <div class="kpi-compact-label">Menores de 5 años</div>
            <div class="kpi-compact-value">{{ $fmt($totalMenoresCinco) }}</div>
            <div class="kpi-compact-sub">{{ $fmtDecimal($porcentajeMenoresCinco) }}% del total</div>
        </div>

        <div class="kpi-compact">
            <div class="kpi-compact-icon" style="background:var(--accent-violet-dim);color:var(--accent-violet);">
                <i class="fas fa-user-md"></i>
            </div>
            <div class="kpi-compact-label">Médico con mayor atención</div>
            <div class="kpi-compact-value" style="font-size:1.1rem;">{{ \Illuminate\Support\Str::limit($topMedicoNombre, 16) }}</div>
            <div class="kpi-compact-sub">{{ $fmt($topMedicoTotal) }} pac · {{ $fmtDecimal($participacionTopMedico) }}%</div>
        </div>

        <div class="kpi-compact">
            <div class="kpi-compact-icon" style="background:var(--accent-rose-dim);color:var(--accent-rose);">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div class="kpi-compact-label">Variación mensual</div>
            <div class="kpi-compact-value {{ $estadoVariacion['clase'] }}">
                @if (!is_null($variacionMes))
                    <i class="fas {{ $estadoVariacion['icono'] }}" style="font-size:0.8rem;"></i>
                    {{ $variacionMes > 0 ? '+' : '' }}{{ $fmtDecimal($variacionMes) }}%
                @else
                    N/D
                @endif
            </div>
            <div class="kpi-compact-sub">vs mes anterior · {{ $estadoVariacion['texto'] }}</div>
        </div>
    </div>

    @if ($diasSinRegistro > 0 || $registrosFinSemana > 0)
        <div class="row g-3 mb-3">
            @if ($diasSinRegistro > 0)
                <div class="col-md-6">
                    <div class="alert-quality-card">
                        <div class="alert-quality-icon"><i class="fas fa-calendar-times"></i></div>
                        <div style="flex:1;">
                            <div class="alert-quality-title">Días laborables sin registro</div>
                            <div class="alert-quality-text">
                                Se detectaron <span class="alert-quality-count">{{ $diasSinRegistro }}</span> días sin pacientes atendidos.
                                <br>Recomendación: Verificar ausencias, permisos o fallas en el registro.
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($registrosFinSemana > 0)
                <div class="col-md-6">
                    <div class="alert-quality-card">
                        <div class="alert-quality-icon"><i class="fas fa-exclamation-triangle"></i></div>
                        <div style="flex:1;">
                            <div class="alert-quality-title">Registros en fin de semana</div>
                            <div class="alert-quality-text">
                                Se detectaron <span class="alert-quality-count">{{ $registrosFinSemana }}</span> registros en sábados o domingos.
                                <br>Recomendación: Validar si corresponden a guardias o registros erróneos.
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    @if (!is_null($cumplimientoMeta))
        <div class="meta-card">
            <div class="meta-card-header">
                <span class="meta-card-title">
                    <i class="fas fa-bullseye" style="color:var(--accent-teal);"></i>
                    Cumplimiento de meta mensual
                </span>
                <span class="meta-card-percent">{{ $fmtDecimal($cumplimientoMeta) }}%</span>
            </div>
            <div class="meta-progress-track">
                <div class="meta-progress-fill" style="width: {{ min($cumplimientoMeta, 100) }}%;"></div>
            </div>
            <div class="meta-card-footer">
                <span>Meta: <strong>{{ $fmt($metaMensual) }}</strong> pacientes</span>
                <span>Actual: <strong>{{ $fmt($totalMes) }}</strong> pacientes</span>
                @if ($faltanteMeta > 0)
                    <span style="color:var(--accent-rose);">Faltan: <strong>{{ $fmt($faltanteMeta) }}</strong></span>
                @else
                    <span style="color:var(--accent-teal);"><strong><i class="fas fa-check-circle mr-1"></i>Meta alcanzada</strong></span>
                @endif
            </div>
            @if ($proyeccionMensual >= $metaMensual && $faltanteMeta > 0)
                <div class="meta-projection-note">
                    <i class="fas fa-chart-line"></i>
                    La proyección mensual ({{ $fmt($proyeccionMensual) }}) indica que se alcanzará la meta.
                </div>
            @endif
        </div>
    @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title-group">
                        <div class="chart-title">Tendencia anual de pacientes</div>
                        <div class="chart-subtitle">Evolución mensual durante {{ $anio }}</div>
                    </div>
                    <div class="chart-icon" style="background:var(--accent-teal-dim);color:var(--accent-teal);">
                        <i class="fas fa-chart-area"></i>
                    </div>
                </div>
                <div class="chart-box">
                    <canvas id="chartMeses"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="exec-card">
                <div class="exec-title">
                    <i class="fas fa-clipboard-list" style="color:var(--accent-teal);"></i>
                    Lectura ejecutiva
                </div>
                @if (count($lecturaEjecutiva) > 0)
                    <div class="exec-reading-list">
                        @foreach ($lecturaEjecutiva as $index => $lectura)
                            @php
                                $iconos = ['fa-check-circle', 'fa-chart-line', 'fa-shield-alt', 'fa-exclamation-triangle', 'fa-chart-area', 'fa-lightbulb'];
                                $colores = ['teal', 'blue', 'teal', 'rose', 'amber', 'violet'];
                                $icono = $iconos[$index % count($iconos)];
                                $color = $colores[$index % count($colores)];
                            @endphp
                            <div class="exec-reading-item">
                                <div class="exec-reading-icon {{ $color }}">
                                    <i class="fas {{ $icono }}"></i>
                                </div>
                                <span class="exec-reading-text">{{ $lectura }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color:var(--text-muted);text-align:center;padding:20px 0;">Sin observaciones para el periodo.</p>
                @endif
                <div class="exec-milestones">
                    <div class="exec-milestone-row">
                        <span class="exec-milestone-label">Mes de mayor atención</span>
                        <span class="exec-milestone-value">{{ $mejorMes['nombre'] ?? '-' }} ({{ $fmt($mejorMes['total'] ?? 0) }})</span>
                    </div>
                    <div class="exec-milestone-row">
                        <span class="exec-milestone-label">Día de mayor carga</span>
                        <span class="exec-milestone-value">Día {{ $mejorDia['dia'] ?? '-' }} ({{ $fmt($mejorDia['total'] ?? 0) }})</span>
                    </div>
                    <div class="exec-milestone-row">
                        <span class="exec-milestone-label">Promedio días activos</span>
                        <span class="exec-milestone-value">{{ $fmtDecimal($promedioPorDiaConActividad) }}</span>
                    </div>
                    <div class="exec-milestone-row">
                        <span class="exec-milestone-label">Proyección anual</span>
                        <span class="exec-milestone-value">{{ $fmt($proyeccionAnual) }}</span>
                    </div>
                    <div class="exec-milestone-row">
                        <span class="exec-milestone-label">Meses con actividad</span>
                        <span class="exec-milestone-value">{{ $mesesConMovimiento }}/{{ $mesesEvaluados }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-0">
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title-group">
                        <div class="chart-title">Pacientes por día laborable</div>
                        <div class="chart-subtitle">Actividad diaria de {{ $mesNombre }} · Sábados y domingos excluidos</div>
                    </div>
                    <div class="chart-icon" style="background:var(--accent-blue-dim);color:var(--accent-blue);">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </div>
                <div class="chart-box">
                    <canvas id="chartDias"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title-group">
                        <div class="chart-title">Principales servicios</div>
                        <div class="chart-subtitle">Excluye filas automáticas 19 y 44</div>
                    </div>
                    <div class="chart-icon" style="background:var(--accent-amber-dim);color:var(--accent-amber);">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
                <div class="chart-box-sm">
                    <canvas id="chartConceptos"></canvas>
                </div>
                <div style="margin-top:12px;padding:12px 14px;background:var(--bg-elevated);border-radius:var(--radius-xs);border:1px solid var(--border-subtle);">
                    <span class="badge" style="background:var(--accent-amber);color:#fff;font-size:0.65rem;font-weight:700;padding:3px 8px;">TOP</span>
                    <strong style="color:var(--text-primary);font-size:0.9rem;margin-left:6px;">{{ $topConceptoNombre }}</strong>
                    <span style="color:var(--text-muted);font-size:0.78rem;"> · {{ $topConceptoCodigo }} · {{ $fmt($topConceptoTotal) }} reg · {{ $fmtDecimal($participacionTopConcepto) }}%</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-0">
        <div class="col-lg-7">
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title-group">
                        <div class="chart-title">Distribución de pacientes por médico</div>
                        <div class="chart-subtitle">Volumen de atención en el periodo</div>
                    </div>
                    <div class="chart-icon" style="background:var(--accent-rose-dim);color:var(--accent-rose);">
                        <i class="fas fa-user-md"></i>
                    </div>
                </div>
                <div class="chart-box">
                    <canvas id="chartMedicos"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="leader-card">
                <div class="exec-title">
                    <i class="fas fa-trophy" style="color:var(--accent-amber);"></i>
                    Médico líder del mes
                </div>
                <div class="leader-header">
                    <div class="leader-avatar"><i class="fas fa-user-md"></i></div>
                    <div>
                        <div class="leader-info-label">Mayor volumen de atención</div>
                        <div class="leader-info-name">{{ $topMedicoNombre }}</div>
                        <div class="leader-info-sub">{{ $fmt($topMedicoTotal) }} pacientes atendidos</div>
                    </div>
                </div>
                <div class="leader-bar-track">
                    <div class="leader-bar-fill" style="width:{{ $participacionTopMedico }}%;"></div>
                </div>
                <div class="leader-metric-row">
                    <span class="leader-metric-label">Participación del total mensual</span>
                    <span class="leader-metric-value">{{ $fmtDecimal($participacionTopMedico) }}%</span>
                </div>
                <div class="leader-metric-row">
                    <span class="leader-metric-label">Total institucional del mes</span>
                    <span class="leader-metric-value">{{ $fmt($totalMes) }}</span>
                </div>
                <div class="leader-metric-row">
                    <span class="leader-metric-label">Diferencia frente al resto</span>
                    <span class="leader-metric-value">{{ $fmt(max(0, $totalMes - $topMedicoTotal)) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="final-metrics">
        <div class="final-metric-card">
            <div class="final-metric-icon" style="background:var(--accent-navy-dim);color:var(--accent-navy);">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="final-metric-content">
                <span class="final-metric-label">Días laborables del mes</span>
                <span class="final-metric-value">{{ $diasLaborablesMes }}</span>
            </div>
        </div>
        <div class="final-metric-card">
            <div class="final-metric-icon" style="background:var(--accent-teal-dim);color:var(--accent-teal);">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="final-metric-content">
                <span class="final-metric-label">Días con atención</span>
                <span class="final-metric-value">{{ $diasConAtencion }}</span>
            </div>
        </div>
        <div class="final-metric-card">
            <div class="final-metric-icon" style="background:var(--accent-blue-dim);color:var(--accent-blue);">
                <i class="fas fa-tachometer-alt"></i>
            </div>
            <div class="final-metric-content">
                <span class="final-metric-label">Productividad proyectada</span>
                <span class="final-metric-value">{{ $fmtDecimal($productividadEsperada) }}/día</span>
            </div>
        </div>
        <div class="final-metric-card">
            <div class="final-metric-icon" style="background:var(--accent-rose-dim);color:var(--accent-rose);">
                <i class="fas fa-child"></i>
            </div>
            <div class="final-metric-content">
                <span class="final-metric-label">Menores de 5 años</span>
                <span class="final-metric-value">{{ $fmtDecimal($porcentajeMenoresCinco) }}%</span>
            </div>
        </div>
    </div>

    <div class="dashboard-footer">
        <div class="footer-badge">
            <i class="fas fa-code" style="color:var(--accent-teal);"></i>
            <span>Desarrollado por <strong>Jose Hernandez</strong></span>
        </div>
    </div>

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ═══════════════════════════════════════════════════════════
            // SISTEMA DE TEMAS — Toggle Claro/Oscuro
            // ═══════════════════════════════════════════════════════════
            const themeToggle = document.getElementById('themeToggle');
            const html = document.documentElement;
            const body = document.body;

            const savedTheme = localStorage.getItem('medical-dashboard-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                html.setAttribute('data-theme', 'dark');
                body.classList.add('dark-mode');
            }

            themeToggle.addEventListener('click', function() {
                const isDark = html.getAttribute('data-theme') === 'dark';
                if (isDark) {
                    html.removeAttribute('data-theme');
                    body.classList.remove('dark-mode');
                    localStorage.setItem('medical-dashboard-theme', 'light');
                } else {
                    html.setAttribute('data-theme', 'dark');
                    body.classList.add('dark-mode');
                    localStorage.setItem('medical-dashboard-theme', 'dark');
                }
                updateChartsTheme();
            });

            // ═══════════════════════════════════════════════════════════
            // DATOS DESDE PHP
            // ═══════════════════════════════════════════════════════════
            const mesesLabels = @json($chartMesesLabels ?? []);
            const datosMeses = @json($chartMesesData ?? []);
            const diasLabels = @json($chartDiasLabels ?? []);
            const datosDias = @json($chartDiasData ?? []);
            const conceptosLabels = @json($chartConceptosLabels ?? []);
            const conceptosData = @json($chartConceptosData ?? []);
            const medicosLabels = @json($chartMedicosLabels ?? []);
            const medicosData = @json($chartMedicosData ?? []);

            const mesActualIndex = mesesLabels.indexOf('{{ $mesNombre }}');

            // ═══════════════════════════════════════════════════════════
            // CONFIGURACIÓN BASE DE CHART.JS
            // ═══════════════════════════════════════════════════════════
            Chart.register(ChartDataLabels);

            const isDark = () => html.getAttribute('data-theme') === 'dark';

            function getThemeColors() {
                return {
                    text: isDark() ? '#94A3B8' : '#64748B',
                    grid: isDark() ? 'rgba(148, 163, 184, 0.08)' : 'rgba(148, 163, 184, 0.15)',
                    tooltipBg: isDark() ? 'rgba(13, 17, 28, 0.98)' : 'rgba(255, 255, 255, 0.98)',
                    tooltipBorder: isDark() ? 'rgba(148, 163, 184, 0.12)' : 'rgba(148, 163, 184, 0.25)',
                    tooltipTitle: isDark() ? '#F0F4F8' : '#0F172A',
                    tooltipBody: isDark() ? '#94A3B8' : '#475569'
                };
            }

            function fmt(val) {
                return new Intl.NumberFormat('es-HN').format(val || 0);
            }

            function commonOptions() {
                const theme = getThemeColors();
                return {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: theme.tooltipBg,
                            titleColor: theme.tooltipTitle,
                            bodyColor: theme.tooltipBody,
                            borderColor: theme.tooltipBorder,
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false,
                            titleFont: { family: "'Plus Jakarta Sans', sans-serif", size: 12, weight: 'bold' },
                            bodyFont: { family: "'Plus Jakarta Sans', sans-serif", size: 11 }
                        },
                        datalabels: {
                            color: theme.tooltipTitle,
                            font: { weight: 'bold', size: 9, family: "'JetBrains Mono', monospace" },
                            formatter: v => v > 0 ? fmt(v) : '',
                            offset: 4
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: theme.text, font: { size: 10 } }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                callback: v => fmt(v),
                                color: theme.text,
                                font: { size: 10 }
                            },
                            grid: { color: theme.grid }
                        }
                    }
                };
            }

            // ═══════════════════════════════════════════════════════════
            // GRÁFICA 1: TENDENCIA ANUAL (Línea con área)
            // ═══════════════════════════════════════════════════════════
            let chartMeses;
            const ctxMeses = document.getElementById('chartMeses')?.getContext('2d');

            function initChartMeses() {
                if (!ctxMeses) return;
                if (chartMeses) chartMeses.destroy();

                const theme = getThemeColors();
                const tealColor = isDark() ? '#00E5C9' : '#0F9D8A';
                const tealDim = isDark() ? 'rgba(0, 229, 201, 0.15)' : 'rgba(15, 157, 138, 0.15)';
                const tealDimEnd = isDark() ? 'rgba(0, 229, 201, 0.01)' : 'rgba(15, 157, 138, 0.01)';

                const pointColors = mesesLabels.map((_, i) => i === mesActualIndex ? tealColor : tealColor);
                const pointRadii = mesesLabels.map((_, i) => i === mesActualIndex ? 6 : 4);
                const pointBorderWidths = mesesLabels.map((_, i) => i === mesActualIndex ? 3 : 2);

                chartMeses = new Chart(ctxMeses, {
                    type: 'line',
                    data: {
                        labels: mesesLabels,
                        datasets: [{
                            label: 'Pacientes',
                            data: datosMeses,
                            borderColor: tealColor,
                            backgroundColor: (context) => {
                                const ctx = context.chart.ctx;
                                const grad = ctx.createLinearGradient(0, 0, 0, 300);
                                grad.addColorStop(0, tealDim);
                                grad.addColorStop(1, tealDimEnd);
                                return grad;
                            },
                            pointBackgroundColor: pointColors,
                            pointBorderColor: isDark() ? '#070B14' : '#FFFFFF',
                            pointBorderWidth: pointBorderWidths,
                            pointRadius: pointRadii,
                            pointHoverRadius: 7,
                            borderWidth: 2.5,
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        ...commonOptions(),
                        plugins: {
                            ...commonOptions().plugins,
                            datalabels: {
                                ...commonOptions().plugins.datalabels,
                                anchor: 'end',
                                align: 'top'
                            },
                            tooltip: {
                                ...commonOptions().plugins.tooltip,
                                callbacks: {
                                    label: ctx => 'Pacientes: ' + fmt(ctx.raw)
                                }
                            }
                        }
                    }
                });
            }

            // ═══════════════════════════════════════════════════════════
            // GRÁFICA 2: ACTIVIDAD DIARIA (Barras verticales)
            // ═══════════════════════════════════════════════════════════
            let chartDias;
            const ctxDias = document.getElementById('chartDias')?.getContext('2d');

            function initChartDias() {
                if (!ctxDias) return;
                if (chartDias) chartDias.destroy();

                const theme = getThemeColors();
                const navyColor = isDark() ? '#3B82F6' : '#0A2647';
                const navyBg = isDark() ? 'rgba(59, 130, 246, 0.7)' : 'rgba(10, 38, 71, 0.75)';
                const maxVal = Math.max(...datosDias);

                chartDias = new Chart(ctxDias, {
                    type: 'bar',
                    data: {
                        labels: diasLabels,
                        datasets: [{
                            label: 'Pacientes',
                            data: datosDias,
                            backgroundColor: datosDias.map(v => v === maxVal ? 'rgba(15, 157, 138, 0.85)' : navyBg),
                            borderColor: datosDias.map(v => v === maxVal ? '#0F9D8A' : navyColor),
                            borderWidth: 1,
                            borderRadius: 6,
                            maxBarThickness: 28
                        }]
                    },
                    options: {
                        ...commonOptions(),
                        plugins: {
                            ...commonOptions().plugins,
                            datalabels: {
                                ...commonOptions().plugins.datalabels,
                                anchor: 'end',
                                align: 'top'
                            },
                            tooltip: {
                                ...commonOptions().plugins.tooltip,
                                callbacks: {
                                    title: items => 'Dia ' + items[0].label,
                                    label: ctx => 'Pacientes: ' + fmt(ctx.raw)
                                }
                            }
                        }
                    }
                });
            }

            // ═══════════════════════════════════════════════════════════
            // GRÁFICA 3: TOP CONCEPTOS (Barras horizontales)
            // ═══════════════════════════════════════════════════════════
            let chartConceptos;
            const ctxConceptos = document.getElementById('chartConceptos')?.getContext('2d');

            function initChartConceptos() {
                if (!ctxConceptos) return;
                if (chartConceptos) chartConceptos.destroy();

                const theme = getThemeColors();
                const amberColor = isDark() ? '#F59E0B' : '#C89B3C';
                const amberBg = isDark() ? 'rgba(245, 158, 11, 0.7)' : 'rgba(200, 155, 60, 0.75)';

                chartConceptos = new Chart(ctxConceptos, {
                    type: 'bar',
                    data: {
                        labels: conceptosLabels,
                        datasets: [{
                            label: 'Registros',
                            data: conceptosData,
                            backgroundColor: amberBg,
                            borderColor: amberColor,
                            borderWidth: 1,
                            borderRadius: 6,
                            maxBarThickness: 22
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: theme.tooltipBg,
                                titleColor: theme.tooltipTitle,
                                bodyColor: theme.tooltipBody,
                                borderColor: theme.tooltipBorder,
                                borderWidth: 1,
                                padding: 10,
                                cornerRadius: 8,
                                callbacks: {
                                    label: ctx => 'Registros: ' + fmt(ctx.raw)
                                }
                            },
                            datalabels: {
                                color: theme.tooltipTitle,
                                font: { weight: 'bold', size: 9, family: "'JetBrains Mono', monospace" },
                                anchor: 'end',
                                align: 'right',
                                formatter: v => v > 0 ? fmt(v) : '',
                                offset: 4
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    callback: v => fmt(v),
                                    color: theme.text,
                                    font: { size: 10 }
                                },
                                grid: { color: theme.grid }
                            },
                            y: {
                                grid: { display: false },
                                ticks: {
                                    autoSkip: false,
                                    color: theme.text,
                                    font: { size: 10 }
                                }
                            }
                        }
                    }
                });
            }

            // ═══════════════════════════════════════════════════════════
            // GRÁFICA 4: DISTRIBUCIÓN POR MÉDICO (Barras horizontales)
            // ═══════════════════════════════════════════════════════════
            let chartMedicos;
            const ctxMedicos = document.getElementById('chartMedicos')?.getContext('2d');

            function initChartMedicos() {
                if (!ctxMedicos) return;
                if (chartMedicos) chartMedicos.destroy();

                const theme = getThemeColors();
                const violetColor = isDark() ? '#8B5CF6' : '#7B5EA7';
                const violetBg = isDark() ? 'rgba(139, 92, 246, 0.7)' : 'rgba(123, 94, 167, 0.75)';
                const maxVal = Math.max(...medicosData);

                chartMedicos = new Chart(ctxMedicos, {
                    type: 'bar',
                    data: {
                        labels: medicosLabels,
                        datasets: [{
                            label: 'Pacientes',
                            data: medicosData,
                            backgroundColor: medicosData.map(v => v === maxVal ? 'rgba(15, 157, 138, 0.85)' : violetBg),
                            borderColor: medicosData.map(v => v === maxVal ? '#0F9D8A' : violetColor),
                            borderWidth: 1,
                            borderRadius: 6,
                            maxBarThickness: 32
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: theme.tooltipBg,
                                titleColor: theme.tooltipTitle,
                                bodyColor: theme.tooltipBody,
                                borderColor: theme.tooltipBorder,
                                borderWidth: 1,
                                padding: 10,
                                cornerRadius: 8,
                                callbacks: {
                                    label: ctx => {
                                        const total = medicosData.reduce((a, b) => a + b, 0);
                                        const pct = total > 0 ? ((ctx.raw / total) * 100).toFixed(1) : 0;
                                        return ['Pacientes: ' + fmt(ctx.raw), 'Participacion: ' + pct + '%'];
                                    }
                                }
                            },
                            datalabels: {
                                color: theme.tooltipTitle,
                                font: { weight: 'bold', size: 9, family: "'JetBrains Mono', monospace" },
                                anchor: 'end',
                                align: 'right',
                                formatter: v => v > 0 ? fmt(v) : '',
                                offset: 4
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    callback: v => fmt(v),
                                    color: theme.text,
                                    font: { size: 10 }
                                },
                                grid: { color: theme.grid }
                            },
                            y: {
                                grid: { display: false },
                                ticks: { color: theme.text, font: { size: 10 } }
                            }
                        }
                    }
                });
            }

            // ═══════════════════════════════════════════════════════════
            // INICIALIZACIÓN Y ACTUALIZACIÓN DE TEMA
            // ═══════════════════════════════════════════════════════════
            function updateChartsTheme() {
                initChartMeses();
                initChartDias();
                initChartConceptos();
                initChartMedicos();
            }

            updateChartsTheme();

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (!localStorage.getItem('medical-dashboard-theme')) {
                    if (e.matches) {
                        html.setAttribute('data-theme', 'dark');
                        body.classList.add('dark-mode');
                    } else {
                        html.removeAttribute('data-theme');
                        body.classList.remove('dark-mode');
                    }
                    updateChartsTheme();
                }
            });
        });
    </script>
@stop