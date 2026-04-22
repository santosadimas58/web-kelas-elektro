<script>
    (() => {
        const storageKey = 'theme';
        const storedTheme = localStorage.getItem(storageKey);
        const theme = storedTheme ?? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

        document.documentElement.classList.toggle('dark', theme === 'dark');
        document.documentElement.style.colorScheme = theme;
    })();
</script>
