<?php if (! $__env->hasRenderedOnce('eb31b6cd-d42c-4c95-b095-692e273496de')): $__env->markAsRenderedOnce('eb31b6cd-d42c-4c95-b095-692e273496de'); ?>
    <style>
        .chat-premium-shell {
            position: fixed !important;
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
            width: 4rem;
            height: 4rem;
            border-radius: 1.35rem;
            border: 1px solid rgba(255, 255, 255, 0.28);
            color: #fff;
            box-shadow:
                0 22px 50px rgba(15, 23, 42, 0.22),
                inset 0 1px 0 rgba(255, 255, 255, 0.18);
            transition: transform 180ms ease, box-shadow 180ms ease, filter 180ms ease;
            overflow: hidden;
            isolation: isolate;
        }

        .chat-premium-launcher:hover {
            transform: translateY(-2px);
            box-shadow:
                0 26px 60px rgba(15, 23, 42, 0.28),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .chat-premium-launcher::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.24), transparent 42%),
                linear-gradient(145deg, var(--chat-accent), var(--chat-accent-strong));
            z-index: -1;
        }

        .chat-premium-launcher::after {
            content: '';
            position: absolute;
            inset: auto -25% -45% auto;
            width: 3.2rem;
            height: 3.2rem;
            background: rgba(255, 255, 255, 0.14);
            border-radius: 999px;
            filter: blur(1px);
        }

        .chat-premium-window {
            z-index: 81;
            width: min(28rem, calc(100vw - 1rem));
            height: min(78vh, 46rem);
            max-height: min(78vh, 46rem);
            border-radius: 1.8rem;
            border: 1px solid rgba(255, 255, 255, 0.74);
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.72), transparent 38%),
                linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(244, 247, 251, 0.96));
            box-shadow:
                0 40px 90px rgba(15, 23, 42, 0.26),
                0 0 0 1px rgba(148, 163, 184, 0.12);
            overflow-x: hidden;
            overflow-y: auto;
            overscroll-behavior-y: contain;
            -webkit-overflow-scrolling: touch;
            transform: translateY(0.65rem) scale(0.985);
            opacity: 0;
            pointer-events: none;
            transition: transform 180ms ease, opacity 180ms ease;
            display: flex;
            flex-direction: column;
        }

        .chat-premium-window.is-open {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
            z-index: 83;
        }

        .chat-premium-window--admin {
            width: min(31rem, calc(100vw - 1rem));
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
            background:
                radial-gradient(circle at top right, rgba(148, 163, 184, 0.08), transparent 28%),
                linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
        }

        .chat-premium-scroll {
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior-y: contain;
            scrollbar-width: thin;
            scrollbar-color: rgba(148, 163, 184, 0.45) transparent;
        }

        .chat-premium-scroll::-webkit-scrollbar {
            width: 8px;
        }

        .chat-premium-scroll::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.4);
            border-radius: 999px;
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
        }

        .chat-premium-composer-row {
            display: flex;
            align-items: flex-end;
            gap: 0.65rem;
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
            margin-bottom: 0.75rem;
            padding: 0.75rem 0.9rem;
            border-radius: 1rem;
            background: rgba(248, 250, 252, 0.96);
            border: 1px solid rgba(226, 232, 240, 0.9);
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
        }

        .chat-premium-image-modal.is-open {
            display: flex;
        }

        .chat-premium-image-view {
            max-width: min(92vw, 60rem);
            max-height: 84vh;
            border-radius: 1.4rem;
            box-shadow: 0 36px 80px rgba(15, 23, 42, 0.45);
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

        @media (max-width: 639px) {
            .chat-premium-backdrop {
                background: rgba(15, 23, 42, 0.2);
                backdrop-filter: blur(4px);
            }

            .chat-premium-window,
            .chat-premium-window--admin {
                top: auto !important;
                left: auto !important;
                right: 0.6rem !important;
                bottom: calc(env(safe-area-inset-bottom, 0px) + 4.35rem) !important;
                width: min(21.75rem, calc(100vw - 1.2rem));
                max-width: calc(100vw - 1.2rem);
                height: min(62dvh, 33rem, calc(100dvh - env(safe-area-inset-top, 0px) - env(safe-area-inset-bottom, 0px) - 5.1rem));
                max-height: min(62dvh, 33rem, calc(100dvh - env(safe-area-inset-top, 0px) - env(safe-area-inset-bottom, 0px) - 5.1rem));
                border-radius: 1.2rem;
                border: 1px solid rgba(255, 255, 255, 0.72);
                box-shadow:
                    0 24px 60px rgba(15, 23, 42, 0.24),
                    0 0 0 1px rgba(148, 163, 184, 0.12);
                overflow-x: hidden;
                overflow-y: auto;
                overscroll-behavior-y: contain;
                -webkit-overflow-scrolling: touch;
            }

            .chat-premium-header {
                position: sticky;
                top: 0;
                z-index: 2;
                padding: 0.8rem 0.9rem 0.78rem;
            }

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
                padding: 0.58rem 0.7rem;
            }

            .chat-premium-typing {
                width: 100%;
                justify-content: center;
                padding: 0.58rem 0.8rem;
            }

            .chat-premium-launcher {
                width: 3.15rem;
                height: 3.15rem;
                border-radius: 1rem;
            }

            .chat-premium-scroll {
                scroll-padding-bottom: 0.75rem;
            }
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
    </style>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\components\chat-premium-styles.blade.php ENDPATH**/ ?>