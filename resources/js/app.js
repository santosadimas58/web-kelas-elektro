import './bootstrap';

import Alpine from 'alpinejs';

const storageKey = 'theme';

const getPreferredTheme = () => {
    const storedTheme = localStorage.getItem(storageKey);

    if (storedTheme === 'dark' || storedTheme === 'light') {
        return storedTheme;
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

const applyTheme = (theme) => {
    document.documentElement.classList.toggle('dark', theme === 'dark');
    document.documentElement.style.colorScheme = theme;
};

window.setTheme = (theme) => {
    localStorage.setItem(storageKey, theme);
    applyTheme(theme);
};

window.toggleTheme = () => {
    window.setTheme(document.documentElement.classList.contains('dark') ? 'light' : 'dark');
};

applyTheme(getPreferredTheme());

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
    if (localStorage.getItem(storageKey)) {
        return;
    }

    applyTheme(event.matches ? 'dark' : 'light');
});

const cookieConsentName = 'cookie_consent';
const cookieConsentMaxAge = 60 * 60 * 24 * 180;

const getCookie = (name) => document.cookie
    .split('; ')
    .find((row) => row.startsWith(`${name}=`))
    ?.split('=')[1];

const setCookieConsent = (value) => {
    document.cookie = `${cookieConsentName}=${value}; Max-Age=${cookieConsentMaxAge}; Path=/; SameSite=Lax`;
};

const initCookieConsent = () => {
    const banner = document.querySelector('[data-cookie-consent]');

    if (!banner || getCookie(cookieConsentName)) {
        return;
    }

    const hideBanner = (value) => {
        setCookieConsent(value);
        banner.classList.add('hidden');
    };

    banner.classList.remove('hidden');

    banner.querySelector('[data-cookie-consent-accept]')?.addEventListener('click', () => {
        hideBanner('accepted');
    });

    banner.querySelector('[data-cookie-consent-decline]')?.addEventListener('click', () => {
        hideBanner('declined');
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCookieConsent);
} else {
    initCookieConsent();
}

window.Alpine = Alpine;

Alpine.start();
