const nativeControlSelector = "button, input[type='button'], input[type='submit'], input[type='reset'], [role='button']";
const loadingTimeouts = new WeakMap();
let pageProgress = null;

const isButtonLikeLink = (element) => {
    if (!(element instanceof HTMLAnchorElement)) return false;

    const classes = typeof element.className === 'string' ? element.className : '';
    return element.matches('[role="button"], [data-ui-feedback], .btn')
        || /(button|btn|cta)/i.test(classes)
        || (classes.includes('inline-flex') && classes.includes('rounded'));
};

const findControl = (target) => {
    if (!(target instanceof Element)) return null;
    const candidate = target.closest(`${nativeControlSelector}, a`);
    if (!candidate) return null;
    if (candidate instanceof HTMLAnchorElement && !isButtonLikeLink(candidate)) return null;
    return candidate;
};

const canAnimate = (control) => {
    return control
        && !control.matches(':disabled, [aria-disabled="true"], [data-ui-no-feedback]');
};

const prepareControl = (control) => {
    if (!canAnimate(control)) return false;
    control.classList.add('ui-feedback-control');
    return true;
};

const playClickFeedback = (control, event) => {
    if (!prepareControl(control)) return;

    control.classList.remove('ui-click-feedback');
    void control.offsetWidth;
    control.classList.add('ui-click-feedback');
    window.setTimeout(() => control.classList.remove('ui-click-feedback'), 380);

    if (control instanceof HTMLInputElement) return;

    if (window.getComputedStyle(control).position === 'static') {
        control.classList.add('ui-ripple-positioned');
    }

    control.classList.add('ui-ripple-host');
    const bounds = control.getBoundingClientRect();
    const ripple = document.createElement('span');
    ripple.className = 'ui-button-ripple';
    ripple.setAttribute('aria-hidden', 'true');
    ripple.style.left = `${event.clientX > 0 ? event.clientX - bounds.left : bounds.width / 2}px`;
    ripple.style.top = `${event.clientY > 0 ? event.clientY - bounds.top : bounds.height / 2}px`;
    control.appendChild(ripple);
    ripple.addEventListener('animationend', () => ripple.remove(), { once: true });
    window.setTimeout(() => ripple.remove(), 650);
};

const ensurePageProgress = () => {
    if (pageProgress?.isConnected) return pageProgress;
    pageProgress = document.createElement('div');
    pageProgress.className = 'ui-page-progress';
    pageProgress.setAttribute('aria-hidden', 'true');
    document.body.appendChild(pageProgress);
    return pageProgress;
};

const startPageProgress = () => {
    const progress = ensurePageProgress();
    progress.classList.remove('is-active');
    void progress.offsetWidth;
    progress.classList.add('is-active');
};

const resetLoading = (control) => {
    if (!control) return;
    window.clearTimeout(loadingTimeouts.get(control));
    loadingTimeouts.delete(control);
    control.classList.remove('ui-is-loading', 'ui-input-loading');
    control.removeAttribute('aria-busy');
    control.removeAttribute('aria-disabled');
    control.querySelector?.('.ui-loading-indicator')?.remove();
    pageProgress?.classList.remove('is-active');

    if (control instanceof HTMLInputElement && control.dataset.uiOriginalValue !== undefined) {
        control.value = control.dataset.uiOriginalValue;
        delete control.dataset.uiOriginalValue;
    }
};

const startLoading = (control) => {
    if (!prepareControl(control) || control.matches('[data-ui-no-loading], .ui-is-loading, .ui-input-loading')) return;

    control.setAttribute('aria-busy', 'true');
    control.setAttribute('aria-disabled', 'true');

    if (control instanceof HTMLInputElement) {
        control.dataset.uiOriginalValue = control.value;
        control.value = '…';
        control.classList.add('ui-input-loading');
    } else {
        control.style.setProperty('--ui-spinner-color', window.getComputedStyle(control).color);
        if (window.getComputedStyle(control).position === 'static') {
            control.classList.add('ui-ripple-positioned');
        }
        control.classList.add('ui-is-loading');
        const spinner = document.createElement('span');
        spinner.className = 'ui-loading-indicator';
        spinner.setAttribute('aria-hidden', 'true');
        control.appendChild(spinner);
    }

    startPageProgress();
    loadingTimeouts.set(control, window.setTimeout(() => resetLoading(control), 15000));
};

const isNavigatingLink = (control, event) => {
    if (!(control instanceof HTMLAnchorElement)) return false;
    if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return false;
    if (control.hasAttribute('download') || control.target === '_blank') return false;

    const href = control.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return false;

    const url = new URL(control.href, window.location.href);
    return url.origin === window.location.origin;
};

document.addEventListener('pointerdown', (event) => {
    const control = findControl(event.target);
    if (prepareControl(control)) control.classList.remove('ui-click-feedback');
}, { passive: true });

document.addEventListener('click', (event) => {
    const control = findControl(event.target);
    if (!canAnimate(control)) return;
    playClickFeedback(control, event);

    if (isNavigatingLink(control, event)) {
        queueMicrotask(() => {
            if (!event.defaultPrevented) startLoading(control);
        });
    }
});

document.addEventListener('submit', (event) => {
    const form = event.target;
    if (!(form instanceof HTMLFormElement) || form.matches('[data-ui-no-loading]')) return;

    queueMicrotask(() => {
        if (event.defaultPrevented) return;
        const submitter = event.submitter
            || form.querySelector("button[type='submit'], input[type='submit'], button:not([type])");
        if (submitter) startLoading(submitter);
    });
});

window.addEventListener('pageshow', () => {
    document.querySelectorAll('.ui-is-loading, .ui-input-loading').forEach(resetLoading);
    pageProgress?.classList.remove('is-active');
});
