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

window.Alpine = Alpine;

Alpine.start();
