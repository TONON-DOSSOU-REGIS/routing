@once
    <style>
        .chat-premium-shell {
            position: fixed !important;
            filter: drop-shadow(0 16px 34px rgba(15, 23, 42, .12));
        }

        .chat-premium-shell .hidden,
        .chat-premium-file-chip.hidden,
        .chat-premium-typing-wrap.hidden {
            display: none !important;
        }

        .chat-premium-backdrop {
            position: fixed;
            inset: 0;
            z-index: 70;
            background: rgba(15, 23, 42, 0.42);
            backdrop-filter: blur(8px);
            opacity: 0;
            pointer-events: none;
            transition: opacity 180ms ease;
        }

        .chat-premium-backdrop.is-open {
            opacity: 1;
            pointer-events: auto;
        }

        .chat-premium-launcher {
            position: relative;
            z-index: 82;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.65rem;
            width: 5.25rem;
            height: 5.25rem;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.96);
            color: #fff;
            box-shadow:
                0 22px 50px rgba(15, 23, 42, 0.22),
                inset 0 1px 0 rgba(255, 255, 255, 0.18);
            transition: transform 180ms ease, box-shadow 180ms ease, filter 180ms ease;
            overflow: visible;
            isolation: isolate;
            background: #fff;
        }

        .chat-premium-launcher:hover {
            transform: translateY(-4px) scale(1.035);
            box-shadow:
                0 26px 60px rgba(15, 23, 42, 0.28),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .chat-premium-launcher[aria-expanded="true"] {
            transform: scale(.92) rotate(-4deg);
            box-shadow: 0 14px 34px rgba(15, 23, 42, .2);
        }

        .chat-premium-invite {
            position: absolute;
            right: calc(100% + .9rem);
            top: 50%;
            width: max-content;
            max-width: 14rem;
            padding: .72rem 1rem .76rem;
            border-radius: 1.15rem 1.15rem .3rem 1.15rem;
            text-align: left;
            color: #0f172a;
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(255,255,255,.86);
            box-shadow: 0 18px 45px rgba(15,23,42,.16), inset 0 1px 0 #fff;
            backdrop-filter: blur(18px);
            transform: translate(12px, -50%) scale(.94);
            opacity: 0;
            pointer-events: none;
            animation: chatInviteArrival .65s 1s cubic-bezier(.22,1,.36,1) forwards;
            transition: opacity 220ms ease, transform 320ms cubic-bezier(.22,1,.36,1);
        }

        .chat-premium-invite strong {
            display: block;
            margin-top: .22rem;
            max-width: 12rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: .82rem;
            line-height: 1.15rem;
        }

        .chat-premium-invite-kicker {
            display: flex;
            align-items: center;
            gap: .4rem;
            color: #64748b;
            font-size: .62rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .chat-premium-invite-kicker span {
            width: .45rem;
            height: .45rem;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 0 4px rgba(34,197,94,.12);
        }

        .chat-premium-launcher[aria-expanded="true"] .chat-premium-invite {
            opacity: 0 !important;
            transform: translate(18px, -50%) scale(.9);
        }

        .chat-premium-launcher::before {
            content: '';
            position: absolute;
            inset: -0.5rem;
            border: 1px solid color-mix(in srgb, var(--chat-accent) 28%, transparent);
            border-radius: 50%;
            z-index: -1;
            animation: chatAdvisorPulse 2.8s ease-out infinite;
        }

        .chat-premium-launcher::after {
            content: '';
            position: absolute;
            inset: 0;
            width: auto;
            height: auto;
            background: linear-gradient(120deg, transparent 22%, rgba(255,255,255,.42) 45%, transparent 68%);
            border-radius: 999px;
            pointer-events: none;
            animation: chatAdvisorSheen 4.8s ease-in-out infinite;
            overflow: hidden;
        }

        .chat-premium-launcher-photo {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border-radius: inherit;
            object-fit: cover;
        }

        .chat-premium-launcher-presence {
            position: absolute;
            z-index: 2;
            right: -.08rem;
            top: .28rem;
            width: 1.05rem;
            height: 1.05rem;
            border-radius: 50%;
            border: 3px solid #fff;
            background: #22c55e;
            box-shadow: 0 0 0 4px rgba(34,197,94,.14);
        }

        .chat-premium-launcher-chat {
            position: absolute;
            z-index: 3;
            right: -.5rem;
            bottom: -.22rem;
            width: 2rem;
            height: 2rem;
            display: grid;
            place-items: center;
            border-radius: .75rem;
            color: #fff;
            border: 2px solid #fff;
            background: linear-gradient(145deg, var(--chat-accent), var(--chat-accent-strong));
            box-shadow: 0 8px 20px color-mix(in srgb, var(--chat-accent-strong) 32%, transparent);
        }

        .chat-premium-launcher-chat svg {
            width: 1rem;
            height: 1rem;
        }

        .chat-premium-window {
            z-index: 81;
            width: min(28rem, calc(100vw - 1rem));
            height: min(78vh, 46rem);
            max-height: min(78vh, 46rem);
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.74);
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.72), transparent 38%),
                linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(244, 247, 251, 0.96));
            box-shadow:
                0 40px 90px rgba(15, 23, 42, 0.26),
                0 16px 45px color-mix(in srgb, var(--chat-accent) 12%, transparent),
                0 0 0 1px rgba(148, 163, 184, 0.12);
            overflow: hidden;
            overscroll-behavior-y: contain;
            -webkit-overflow-scrolling: touch;
            transform: translate3d(1.5rem, 1.6rem, 0) scale(.9) rotate(1.5deg);
            opacity: 0;
            pointer-events: none;
            transform-origin: right bottom;
            transition: transform 360ms cubic-bezier(.22, 1, .36, 1), opacity 240ms ease;
            display: flex;
            flex-direction: column;
        }

        .chat-premium-window.is-open {
            opacity: 1;
            transform: translate3d(0, 0, 0) scale(1) rotate(0);
            pointer-events: auto;
            z-index: 83;
        }

        .chat-premium-window--admin {
            width: min(30rem, calc(100vw - 1rem));
            height: min(76vh, 43rem);
            border-radius: 1.75rem;
        }

        .chat-premium-window--admin .chat-premium-header {
            padding: .9rem 1rem .85rem;
        }

        .chat-premium-window--admin .chat-premium-avatar--photo {
            width: 2.8rem;
            height: 2.8rem;
        }

        .chat-premium-window--admin .chat-premium-badge {
            padding: .2rem .55rem;
            font-size: .6rem;
        }

        .chat-premium-admin-recipient {
            padding: .7rem .85rem;
            border-bottom: 1px solid rgba(226,232,240,.75);
            background: rgba(255,255,255,.8);
            backdrop-filter: blur(16px);
        }

        .chat-premium-admin-recipient-inner {
            padding: .7rem;
            border-radius: 1.1rem;
            border: 1px solid rgba(226,232,240,.88);
            background: linear-gradient(135deg, rgba(255,255,255,.98), rgba(248,250,252,.9));
            box-shadow: 0 10px 30px rgba(15,23,42,.055);
        }

        .chat-premium-admin-recipient .chat-premium-avatar {
            width: 2.55rem;
            height: 2.55rem;
            background: linear-gradient(145deg, color-mix(in srgb, var(--chat-accent) 13%, #fff), #fff);
            color: var(--chat-accent-strong);
            border-color: color-mix(in srgb, var(--chat-accent) 16%, #e2e8f0);
        }

        .chat-premium-change-user {
            min-width: 2.55rem;
            min-height: 2.55rem;
        }

        .chat-premium-window--admin #chat-messages-container-v2 {
            padding-top: 1.15rem;
            background:
                radial-gradient(circle at 12% 12%, color-mix(in srgb, var(--chat-accent) 6%, transparent), transparent 28%),
                linear-gradient(180deg, rgba(248,250,252,.86), rgba(241,245,249,.72));
        }

        .chat-premium-header {
            position: sticky;
            top: 0;
            z-index: 2;
            padding: 1.05rem 1.15rem 0.95rem;
            color: #fff;
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.2), transparent 38%),
                linear-gradient(135deg, var(--chat-accent), var(--chat-accent-strong));
            overflow: hidden;
            isolation: isolate;
        }

        .chat-premium-header > div {
            position: relative;
            z-index: 2;
        }

        .chat-premium-header-orb {
            position: absolute;
            z-index: 0;
            display: block;
            border-radius: 999px;
            pointer-events: none;
            filter: blur(2px);
        }

        .chat-premium-header-orb--one {
            width: 9rem;
            height: 9rem;
            right: -2rem;
            top: -5rem;
            background: rgba(103,232,249,.24);
            animation: chatHeaderOrbOne 7s ease-in-out infinite alternate;
        }

        .chat-premium-header-orb--two {
            width: 6rem;
            height: 6rem;
            left: 30%;
            bottom: -5rem;
            background: rgba(255,255,255,.15);
            animation: chatHeaderOrbTwo 6s ease-in-out infinite alternate;
        }

        .chat-premium-header::after {
            content: '';
            position: absolute;
            inset: auto 0 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.18);
        }

        .chat-premium-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.42rem;
            padding: 0.28rem 0.68rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.14);
            font-size: 0.68rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 700;
        }

        .chat-premium-avatar {
            width: 2.65rem;
            height: 2.65rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.26), rgba(255, 255, 255, 0.08));
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.12);
            font-size: 0.86rem;
            font-weight: 800;
        }

        .chat-premium-avatar--photo {
            width: 3.2rem;
            height: 3.2rem;
            padding: .14rem;
            overflow: hidden;
            background: rgba(255,255,255,.96);
            box-shadow: 0 10px 24px rgba(15,23,42,.18), 0 0 0 3px rgba(255,255,255,.12);
        }

        .chat-premium-avatar--photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: inherit;
        }

        .chat-premium-status-dot {
            width: 0.55rem;
            height: 0.55rem;
            border-radius: 999px;
            flex-shrink: 0;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }

        .chat-premium-status-dot.is-online {
            background: #22c55e;
        }

        .chat-premium-status-dot.is-connected {
            background: #f59e0b;
        }

        .chat-premium-status-dot.is-disconnected {
            background: rgba(255, 255, 255, 0.58);
        }

        .chat-premium-close {
            width: 2.35rem;
            height: 2.35rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #fff;
            transition: background 180ms ease, transform 180ms ease;
        }

        .chat-premium-close:hover {
            background: rgba(255, 255, 255, 0.18);
            transform: scale(1.04);
        }

        .chat-premium-body {
            position: relative;
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
            height: 100%;
            background:
                radial-gradient(circle at top right, rgba(148, 163, 184, 0.08), transparent 28%),
                linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
        }

        .chat-premium-scroll {
            overflow-y: auto;
            overflow-x: hidden;
            min-height: 0;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior-y: contain;
            scrollbar-width: thin;
            scrollbar-color: rgba(148, 163, 184, 0.45) transparent;
            scrollbar-gutter: stable;
            scroll-behavior: smooth;
            touch-action: pan-y;
            -ms-touch-action: pan-y;
        }

        .chat-premium-message-list {
            flex: 1 1 0%;
            width: 100%;
            height: 0;
            max-height: 100%;
            overscroll-behavior: contain;
        }

        .chat-premium-scroll::-webkit-scrollbar {
            width: 8px;
        }

        .chat-premium-scroll::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.4);
            border-radius: 999px;
        }

        .chat-premium-scroll::-webkit-scrollbar-thumb:hover {
            background: color-mix(in srgb, var(--chat-accent) 42%, #94a3b8);
        }

        .chat-premium-thread-view {
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .chat-premium-thread-view:not(.hidden) {
            display: flex;
            min-height: 0;
            flex-direction: column;
        }

        .chat-premium-jump-latest {
            position: absolute;
            z-index: 5;
            right: 1rem;
            bottom: 5.7rem;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .55rem .8rem;
            border-radius: 999px;
            color: #fff;
            background: linear-gradient(145deg, var(--chat-accent), var(--chat-accent-strong));
            border: 1px solid rgba(255,255,255,.2);
            box-shadow: 0 14px 32px color-mix(in srgb, var(--chat-accent-strong) 28%, transparent);
            font-size: .7rem;
            font-weight: 800;
            animation: chatJumpArrival .28s cubic-bezier(.22,1,.36,1) both;
        }

        .chat-premium-empty {
            height: 100%;
            min-height: 16rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.85rem;
            text-align: center;
            color: #64748b;
            padding: 2rem 1.5rem;
        }

        .chat-premium-empty-icon {
            width: 4.5rem;
            height: 4.5rem;
            border-radius: 1.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--chat-accent);
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.96), rgba(255, 255, 255, 0.72));
            box-shadow:
                0 18px 36px rgba(15, 23, 42, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.75);
        }

        .chat-premium-message-row {
            display: flex;
            align-items: flex-end;
            gap: 0.65rem;
            animation: chatMessageArrival .42s cubic-bezier(.22,1,.36,1) both;
        }

        .chat-premium-message-row--outgoing {
            justify-content: flex-end;
        }

        .chat-premium-message-bubble {
            max-width: min(82%, 20.5rem);
            padding: 0.9rem 1rem 0.8rem;
            border-radius: 1.3rem;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(226, 232, 240, 0.9);
            color: #0f172a;
            box-shadow:
                0 16px 34px rgba(15, 23, 42, 0.06),
                inset 0 1px 0 rgba(255, 255, 255, 0.76);
        }

        .chat-premium-message-row--outgoing .chat-premium-message-bubble {
            color: #fff;
            border-color: rgba(255, 255, 255, 0.08);
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.22), transparent 32%),
                linear-gradient(145deg, var(--chat-accent), var(--chat-accent-strong));
            box-shadow:
                0 18px 36px color-mix(in srgb, var(--chat-accent-strong) 26%, transparent),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .chat-premium-meta {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            margin-top: 0.55rem;
            font-size: 0.72rem;
            color: #64748b;
        }

        .chat-premium-message-row--outgoing .chat-premium-meta {
            color: rgba(255, 255, 255, 0.72);
        }

        .chat-premium-attachment {
            display: block;
            margin-top: 0.75rem;
            border-radius: 1rem;
            overflow: hidden;
            border: 1px solid rgba(148, 163, 184, 0.14);
            background: rgba(248, 250, 252, 0.92);
        }

        .chat-premium-message-row--outgoing .chat-premium-attachment {
            border-color: rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.08);
        }

        .chat-premium-image {
            width: 100%;
            max-height: 13rem;
            object-fit: cover;
            display: block;
        }

        .chat-premium-image-trigger {
            position: relative;
            cursor: zoom-in;
        }

        .chat-premium-image-zoom-hint {
            position: absolute;
            right: .65rem;
            bottom: .65rem;
            display: grid;
            width: 2.25rem;
            height: 2.25rem;
            place-items: center;
            border-radius: .8rem;
            color: #fff;
            background: rgba(15,23,42,.72);
            border: 1px solid rgba(255,255,255,.18);
            box-shadow: 0 10px 25px rgba(0,0,0,.24);
            backdrop-filter: blur(10px);
            transition: transform 180ms ease, background 180ms ease;
        }

        .chat-premium-image-trigger:hover .chat-premium-image-zoom-hint {
            transform: scale(1.08);
            background: var(--chat-accent-strong);
        }

        .chat-premium-file {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.85rem 0.95rem;
            color: inherit;
            text-decoration: none;
        }

        .chat-premium-file-icon {
            width: 2.3rem;
            height: 2.3rem;
            border-radius: 0.9rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, 0.06);
            flex-shrink: 0;
        }

        .chat-premium-message-row--outgoing .chat-premium-file-icon {
            background: rgba(255, 255, 255, 0.14);
        }

        .chat-premium-composer {
            position: sticky;
            bottom: 0;
            z-index: 2;
            padding: 0.95rem;
            border-top: 1px solid rgba(226, 232, 240, 0.9);
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(16px);
            box-shadow: 0 -16px 38px rgba(15,23,42,.035);
        }

        .chat-premium-composer-row {
            display: flex;
            align-items: flex-end;
            gap: 0.65rem;
            padding: .25rem;
            border-radius: 1.35rem;
            transition: background 220ms ease, box-shadow 220ms ease;
        }

        .chat-premium-composer-row:focus-within {
            background: color-mix(in srgb, var(--chat-accent) 5%, #fff);
            box-shadow: 0 0 0 1px color-mix(in srgb, var(--chat-accent) 12%, transparent), 0 14px 32px rgba(15,23,42,.06);
        }

        .chat-premium-input {
            width: 100%;
            min-height: 3rem;
            max-height: 7.5rem;
            resize: none;
            border-radius: 1.15rem;
            border: 1px solid rgba(203, 213, 225, 0.95);
            background: #f8fafc;
            padding: 0.86rem 0.95rem;
            color: #0f172a;
            transition: border-color 180ms ease, box-shadow 180ms ease, background 180ms ease;
        }

        .chat-premium-input:focus {
            outline: none;
            border-color: color-mix(in srgb, var(--chat-accent) 32%, #94a3b8);
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--chat-accent) 16%, transparent);
            background: #fff;
        }

        .chat-premium-icon-button,
        .chat-premium-send {
            border-radius: 1rem;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform 180ms ease, filter 180ms ease, background 180ms ease;
        }

        .chat-premium-icon-button {
            width: 3rem;
            height: 3rem;
            border: 1px solid rgba(203, 213, 225, 0.96);
            background: #fff;
            color: #334155;
        }

        .chat-premium-send {
            width: 3rem;
            height: 3rem;
            border: 1px solid transparent;
            color: #fff;
            box-shadow: 0 16px 32px color-mix(in srgb, var(--chat-accent-strong) 20%, transparent);
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.22), transparent 32%),
                linear-gradient(145deg, var(--chat-accent), var(--chat-accent-strong));
        }

        .chat-premium-send:hover,
        .chat-premium-icon-button:hover {
            transform: translateY(-1px);
            filter: brightness(1.02);
        }

        .chat-premium-send:disabled,
        .chat-premium-icon-button:disabled {
            opacity: 0.58;
            cursor: not-allowed;
            transform: none;
            filter: none;
        }

        .chat-premium-file-chip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.85rem;
            width: fit-content;
            max-width: 100%;
            margin-bottom: 0.65rem;
            padding: 0.52rem 0.65rem;
            border-radius: 999px;
            background: color-mix(in srgb, var(--chat-accent) 5%, #fff);
            border: 1px solid color-mix(in srgb, var(--chat-accent) 14%, #e2e8f0);
            box-shadow: 0 8px 22px rgba(15,23,42,.05);
            animation: chatFileChipArrival .3s cubic-bezier(.22,1,.36,1) both;
        }

        .chat-premium-file-chip .chat-premium-file-icon {
            width: 1.9rem;
            height: 1.9rem;
            border-radius: 999px;
            color: var(--chat-accent-strong);
            background: color-mix(in srgb, var(--chat-accent) 10%, #fff);
        }

        .chat-premium-typing {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.68rem 0.92rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.86);
            border: 1px solid rgba(226, 232, 240, 0.9);
            color: #475569;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.06);
        }

        .chat-premium-typing-dots {
            display: inline-flex;
            align-items: center;
            gap: 0.28rem;
        }

        .chat-premium-typing-dots span {
            width: 0.42rem;
            height: 0.42rem;
            border-radius: 999px;
            background: color-mix(in srgb, var(--chat-accent) 70%, #fff);
            animation: chatTypingPulse 1s infinite ease-in-out;
        }

        .chat-premium-typing-dots span:nth-child(2) {
            animation-delay: 0.16s;
        }

        .chat-premium-typing-dots span:nth-child(3) {
            animation-delay: 0.32s;
        }

        .chat-premium-user-list {
            display: flex;
            flex-direction: column;
            gap: 0.55rem;
        }

        .chat-premium-user-item {
            width: 100%;
            text-align: left;
            padding: 0.85rem 0.95rem;
            border-radius: 1.15rem;
            border: 1px solid rgba(226, 232, 240, 0.95);
            background: rgba(255, 255, 255, 0.94);
            transition: border-color 180ms ease, transform 180ms ease, box-shadow 180ms ease;
        }

        .chat-premium-user-item:hover,
        .chat-premium-user-item.is-active {
            transform: translateY(-1px);
            border-color: color-mix(in srgb, var(--chat-accent) 28%, #cbd5e1);
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.08);
        }

        .chat-premium-search {
            width: 100%;
            border-radius: 1rem;
            border: 1px solid rgba(203, 213, 225, 0.95);
            background: rgba(248, 250, 252, 0.95);
            padding: 0.8rem 0.92rem;
            color: #0f172a;
        }

        .chat-premium-search:focus {
            outline: none;
            border-color: color-mix(in srgb, var(--chat-accent) 30%, #94a3b8);
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--chat-accent) 14%, transparent);
            background: #fff;
        }

        .chat-premium-image-modal {
            position: fixed;
            inset: 0;
            z-index: 90;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: rgba(15, 23, 42, 0.82);
            backdrop-filter: blur(8px);
            overflow: auto;
        }

        .chat-premium-image-modal.is-open {
            display: flex;
        }

        .chat-premium-image-view {
            --chat-image-zoom: 1;
            max-width: min(92vw, 60rem);
            max-height: 84vh;
            border-radius: 1.4rem;
            box-shadow: 0 36px 80px rgba(15, 23, 42, 0.45);
            cursor: zoom-in;
            transform: scale(var(--chat-image-zoom));
            transition: transform 220ms cubic-bezier(.22,1,.36,1);
            transform-origin: center;
        }

        .chat-premium-zoom-controls {
            position: fixed;
            z-index: 2;
            left: 50%;
            bottom: calc(env(safe-area-inset-bottom, 0px) + 1.25rem);
            display: flex;
            align-items: center;
            gap: .35rem;
            padding: .38rem;
            border-radius: 999px;
            color: #fff;
            background: rgba(15,23,42,.76);
            border: 1px solid rgba(255,255,255,.16);
            box-shadow: 0 18px 44px rgba(0,0,0,.3);
            backdrop-filter: blur(18px);
            transform: translateX(-50%);
        }

        .chat-premium-zoom-controls button {
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 .65rem;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 800;
            transition: background 160ms ease, transform 160ms ease;
        }

        .chat-premium-zoom-controls button:hover {
            background: rgba(255,255,255,.12);
            transform: scale(1.05);
        }

        @keyframes chatTypingPulse {
            0%, 80%, 100% {
                transform: translateY(0);
                opacity: 0.4;
            }

            40% {
                transform: translateY(-0.18rem);
                opacity: 1;
            }
        }

        @keyframes chatAdvisorPulse {
            0% { transform: scale(.9); opacity: .72; }
            70%, 100% { transform: scale(1.18); opacity: 0; }
        }

        @keyframes chatAdvisorSheen {
            0%, 55% { transform: translateX(-145%) rotate(10deg); }
            78%, 100% { transform: translateX(145%) rotate(10deg); }
        }

        @keyframes chatInviteArrival {
            to { opacity: 1; transform: translate(0, -50%) scale(1); }
        }

        @keyframes chatMessageArrival {
            from { opacity: 0; transform: translateY(12px) scale(.97); filter: blur(3px); }
            to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes chatHeaderOrbOne {
            to { transform: translate(-2rem, 1.7rem) scale(1.18); }
        }

        @keyframes chatHeaderOrbTwo {
            to { transform: translate(3rem, -1.2rem) scale(.82); }
        }

        @keyframes chatFileChipArrival {
            from { opacity: 0; transform: translateY(7px) scale(.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes chatJumpArrival {
            from { opacity: 0; transform: translateY(8px) scale(.94); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @media (max-width: 639px) {
            .chat-premium-backdrop {
                background: rgba(15, 23, 42, 0.2);
                backdrop-filter: blur(4px);
            }

            .chat-premium-window,
            .chat-premium-window--admin {
                top: auto !important;
                left: auto !important;
                right: 0.55rem !important;
                bottom: calc(env(safe-area-inset-bottom, 0px) + 4.85rem) !important;
                width: min(23rem, calc(100vw - 1.1rem));
                max-width: calc(100vw - 1.2rem);
                height: min(72dvh, 38rem, calc(100dvh - env(safe-area-inset-top, 0px) - env(safe-area-inset-bottom, 0px) - 5.4rem));
                max-height: min(72dvh, 38rem, calc(100dvh - env(safe-area-inset-top, 0px) - env(safe-area-inset-bottom, 0px) - 5.4rem));
                border-radius: 1.2rem;
                border: 1px solid rgba(255, 255, 255, 0.72);
                box-shadow:
                    0 24px 60px rgba(15, 23, 42, 0.24),
                    0 0 0 1px rgba(148, 163, 184, 0.12);
                overflow: hidden;
                overscroll-behavior-y: contain;
                -webkit-overflow-scrolling: touch;
            }

            .chat-premium-header {
                position: sticky;
                top: 0;
                z-index: 2;
                padding: 0.8rem 0.9rem 0.78rem;
            }

            .chat-premium-window--admin .chat-premium-header { padding: .7rem .8rem; }
            .chat-premium-window--admin .chat-premium-header p { display: none; }
            .chat-premium-window--admin .chat-premium-header h3 { margin-top: .35rem !important; }
            .chat-premium-admin-recipient { padding: .55rem; }
            .chat-premium-admin-recipient-inner { padding: .55rem; }
            .chat-premium-admin-recipient .chat-premium-avatar { width: 2.25rem; height: 2.25rem; }
            .chat-premium-admin-recipient p { max-width: 12rem; }
            .chat-premium-change-user { width: 2.45rem; height: 2.45rem; padding: 0; }
            .chat-premium-change-user-label { display: none; }

            .chat-premium-header h3 {
                margin-top: 0.55rem !important;
                font-size: 1rem;
                line-height: 1.25rem;
            }

            .chat-premium-header p {
                font-size: 0.78rem;
            }

            .chat-premium-badge {
                font-size: 0.58rem;
                padding: 0.22rem 0.5rem;
            }

            .chat-premium-avatar {
                width: 2.1rem;
                height: 2.1rem;
                font-size: 0.72rem;
            }

            .chat-premium-avatar--photo {
                width: 2.55rem;
                height: 2.55rem;
            }

            .chat-premium-close {
                width: 2rem;
                height: 2rem;
            }

            .chat-premium-empty {
                min-height: 10rem;
                padding: 1.15rem 0.9rem;
            }

            .chat-premium-empty-icon {
                width: 3.15rem;
                height: 3.15rem;
                border-radius: 1.05rem;
            }

            .chat-premium-message-row {
                gap: 0.42rem;
            }

            .chat-premium-message-bubble {
                max-width: min(86%, calc(100vw - 4.7rem));
                padding: 0.72rem 0.82rem 0.68rem;
            }

            .chat-premium-meta {
                flex-wrap: wrap;
                gap: 0.28rem;
                margin-top: 0.45rem;
                font-size: 0.67rem;
            }

            .chat-premium-image {
                max-height: 9.5rem;
            }

            .chat-premium-composer {
                position: sticky;
                bottom: 0;
                z-index: 2;
                padding: 0.62rem;
                padding-bottom: calc(env(safe-area-inset-bottom, 0px) + 0.62rem);
            }

            .chat-premium-composer-row {
                gap: 0.42rem;
            }

            .chat-premium-input {
                min-height: 2.65rem;
                border-radius: 0.95rem;
                padding: 0.72rem 0.78rem;
                font-size: 16px;
            }

            .chat-premium-icon-button,
            .chat-premium-send {
                width: 2.6rem;
                height: 2.6rem;
                border-radius: 0.85rem;
            }

            .chat-premium-file-chip {
                margin-bottom: 0.55rem;
                padding: 0.45rem 0.58rem;
            }

            .chat-premium-typing {
                width: 100%;
                justify-content: center;
                padding: 0.58rem 0.8rem;
            }

            .chat-premium-launcher {
                width: 4rem;
                height: 4rem;
                border-width: 3px;
            }

            .chat-premium-invite { display: none; }

            .chat-premium-launcher-chat { width: 1.65rem; height: 1.65rem; border-radius: .62rem; right: -.35rem; }
            .chat-premium-launcher-presence { width: .85rem; height: .85rem; border-width: 2px; }

            .chat-premium-scroll {
                scroll-padding-bottom: 0.75rem;
            }

            .chat-premium-jump-latest { right: .75rem; bottom: 4.9rem; }
            .chat-premium-jump-latest span { display: none; }
        }

        @media (min-width: 640px) {
            .chat-premium-backdrop {
                background: transparent;
                backdrop-filter: none;
            }

            .chat-premium-backdrop.is-open {
                opacity: 0;
                pointer-events: none;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .chat-premium-launcher::before,
            .chat-premium-launcher::after,
            .chat-premium-typing-dots span { animation: none; }
            .chat-premium-invite,
            .chat-premium-message-row,
            .chat-premium-header-orb,
            .chat-premium-file-chip { animation: none; }
            .chat-premium-invite { opacity: 1; transform: translate(0, -50%) scale(1); }
            .chat-premium-launcher,
            .chat-premium-window { transition-duration: .01ms; }
        }
    </style>
@endonce

@once
    <script>
        window.ZuiderChatAudio = window.ZuiderChatAudio || (() => {
            let context = null;
            const unlock = () => {
                const AudioContextClass = window.AudioContext || window.webkitAudioContext;
                if (!AudioContextClass) return;
                context ||= new AudioContextClass();
                if (context.state === 'suspended') context.resume().catch(() => {});
            };
            const notify = () => {
                if (!context || context.state !== 'running') return;
                const start = context.currentTime;
                [[660, 0], [880, .09]].forEach(([frequency, delay]) => {
                    const oscillator = context.createOscillator();
                    const gain = context.createGain();
                    oscillator.type = 'sine';
                    oscillator.frequency.setValueAtTime(frequency, start + delay);
                    gain.gain.setValueAtTime(.0001, start + delay);
                    gain.gain.exponentialRampToValueAtTime(.055, start + delay + .018);
                    gain.gain.exponentialRampToValueAtTime(.0001, start + delay + .16);
                    oscillator.connect(gain).connect(context.destination);
                    oscillator.start(start + delay);
                    oscillator.stop(start + delay + .18);
                });
            };
            return { unlock, notify };
        })();
    </script>
@endonce
