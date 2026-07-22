@props(['audience' => 'client'])

@php($liveNewsId = 'live-news-' . str_replace('.', '-', uniqid('', true)))

<section
    id="{{ $liveNewsId }}"
    class="premium-panel premium-card-hover min-w-0 rounded-[30px] p-5"
    data-live-news
    data-endpoint="{{ localized_route('international-news') }}"
    data-locale="{{ app()->getLocale() }}"
>
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">{{ __('dashboard.live_news_label') }}</p>
            <h2 class="premium-brand-title mt-2 text-2xl font-semibold text-slate-950">{{ __('dashboard.live_news_title') }}</h2>
        </div>
        <span class="inline-flex shrink-0 items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200/80">
            <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-500"></span>
            {{ __('dashboard.live_news_realtime') }}
        </span>
    </div>

    <div class="mt-5 space-y-3" data-live-news-list aria-live="polite">
        <div class="rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70">
            <div class="flex items-center gap-3">
                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-2xl bg-blue-50 text-blue-700"><i class="fas fa-spinner fa-spin"></i></span>
                <p class="text-sm font-medium text-slate-500">{{ __('dashboard.live_news_loading') }}</p>
            </div>
        </div>
    </div>

    <div class="mt-4 flex items-center justify-between border-t border-slate-200/70 pt-4 text-xs text-slate-400">
        <span class="inline-flex items-center gap-2"><i class="fas fa-globe"></i>GNews API</span>
        <time data-live-news-time>{{ now()->format('H:i:s') }}</time>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const root = document.getElementById(@json($liveNewsId));
        if (!root) return;

        const list = root.querySelector('[data-live-news-list]');
        const updatedAt = root.querySelector('[data-live-news-time]');
        const locale = root.dataset.locale || 'fr';
        const labels = {
            emptyTitle: @json(__('dashboard.live_news_empty_title')),
            emptyMessage: @json(__('dashboard.live_news_empty_message')),
            error: @json(__('dashboard.live_news_error')),
        };

        const createArticle = function (article) {
            const card = document.createElement('a');
            card.href = article.url;
            card.target = '_blank';
            card.rel = 'noopener noreferrer';
            card.className = 'group flex items-start gap-3 rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70 transition hover:bg-white hover:shadow-md';

            const media = document.createElement('span');
            media.className = 'grid h-12 w-12 shrink-0 place-items-center overflow-hidden rounded-2xl bg-blue-50 text-blue-700';
            if (article.image) {
                const image = document.createElement('img');
                image.src = article.image;
                image.alt = '';
                image.loading = 'lazy';
                image.referrerPolicy = 'no-referrer';
                image.className = 'h-full w-full object-cover';
                image.addEventListener('error', () => { media.innerHTML = '<i class="fas fa-earth-europe"></i>'; }, { once: true });
                media.append(image);
            } else {
                media.innerHTML = '<i class="fas fa-earth-europe"></i>';
            }

            const content = document.createElement('span');
            content.className = 'min-w-0 flex-1';
            const source = document.createElement('span');
            source.className = 'block text-[11px] font-semibold uppercase tracking-[0.14em] text-blue-600';
            source.textContent = article.source || 'International';
            const title = document.createElement('span');
            title.className = 'mt-1 line-clamp-2 block text-sm font-semibold leading-5 text-slate-900 group-hover:text-blue-700';
            title.textContent = article.title;
            const time = document.createElement('time');
            time.className = 'mt-2 block text-xs text-slate-400';
            time.textContent = article.published_at
                ? new Intl.DateTimeFormat(locale, { dateStyle: 'short', timeStyle: 'short' }).format(new Date(article.published_at))
                : '';
            content.append(source, title, time);

            const arrow = document.createElement('i');
            arrow.className = 'fas fa-arrow-up-right-from-square mt-1 text-xs text-slate-300 transition group-hover:text-blue-600';
            card.append(media, content, arrow);
            return card;
        };

        const renderStatus = function (title, message, error = false) {
            list.replaceChildren();
            const card = document.createElement('div');
            card.className = 'rounded-[22px] bg-slate-50 px-4 py-4 ring-1 ring-slate-200/70';
            const heading = document.createElement('p');
            heading.className = `text-sm font-semibold ${error ? 'text-rose-700' : 'text-slate-900'}`;
            heading.textContent = title;
            const description = document.createElement('p');
            description.className = 'mt-1 text-sm leading-5 text-slate-500';
            description.textContent = message;
            card.append(heading, description);
            list.append(card);
        };

        const refresh = async function () {
            try {
                const response = await fetch(root.dataset.endpoint, { headers: { Accept: 'application/json' }, cache: 'no-store' });
                const payload = await response.json();
                if (!response.ok || !payload.success) throw new Error(payload.message || 'news-api');
                const articles = Array.isArray(payload.articles) ? payload.articles.slice(0, 3) : [];
                if (articles.length === 0) {
                    renderStatus(labels.emptyTitle, labels.emptyMessage);
                } else {
                    list.replaceChildren(...articles.map(createArticle));
                }
                updatedAt.textContent = new Intl.DateTimeFormat(locale, { hour: '2-digit', minute: '2-digit', second: '2-digit' }).format(new Date());
            } catch (error) {
                renderStatus(labels.error, labels.emptyMessage, true);
            }
        };

        refresh();
        const refreshTimer = window.setInterval(() => { if (!document.hidden) refresh(); }, 60000);
        window.addEventListener('pagehide', () => window.clearInterval(refreshTimer), { once: true });
    });
</script>
