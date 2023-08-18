class Theme {
    // Check if the user prefers dark mode
    isDarkMode() {
        return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    }

    // Store the user's theme preference in local storage
    storeThemePreference(themeName) {
        if (!themeName) {
            localStorage.removeItem('theme');

            return;
        }

        const themes = ['dark', 'light'];
        themeName = themes.includes(themeName) ? themeName : 'light';
        localStorage.setItem('theme', themeName);
    };

    // Retrieve the user's theme preference from local storage
    getStoredThemePreference() {
        return localStorage.getItem('theme');
    };

    // Use the user's theme preference or the system preference as a fallback
    getThemePreference() {
        const themes = ['dark', 'light'];
        let themeName = this.getStoredThemePreference() || (this.isDarkMode() ? 'dark' : 'light');

        return themes.includes(themeName) ? themeName : 'light';
    }

    setTheme(theme = null) {
        this.storeThemePreference(theme);
        this.loadTheme();
    }

    setThemeClass(theme = null) {
        const themes = ['dark', 'light'];

        if (!theme || !themes.includes(theme)) {
            document.body.classList.remove('light');
            document.body.classList.remove('dark');
            return;
        }

        if (theme == 'dark') {
            document.body.classList.remove('light');
            document.body.classList.add('dark');

            return;
        }

        document.body.classList.remove('dark');
        document.body.classList.add('light');
    }

    setViaEventListener(persistOnChangeViaSystem = false) {
        // Listen for changes in the user's preferred color scheme
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            let themeName = e.matches ? 'dark' : 'light';

            if (persistOnChangeViaSystem) {
                this.storeThemePreference(themeName);
            }

            this.setThemeClass(themeName);
        });
    }

    loadTheme(listenEventChange = false, persistOnChangeViaSystem = false) {
        let themePreference = this.getThemePreference();

        // Apply the theme preference to your styles or toggle a class on the <body> tag
        this.setThemeClass(themePreference);

        if (listenEventChange) {
            this.setViaEventListener(persistOnChangeViaSystem);
        }
    }
}

export default Theme
