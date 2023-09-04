export const URLParam = {
    set: (key, value) => {
        // Get the current URL
        const url = new URL(window.location.href);

        // Get the current value of the 'rows' parameter
        let rows = url.searchParams.get(key);

        url.searchParams.set(key, value);

        // Update the URL in the browser
        window.history.replaceState({}, '', url);
    },
    getOrSet: (key, value) => {
        // Get the current URL
        const url = new URL(window.location.href);

        let currentValue = url.searchParams.get(key);

        if (currentValue) {
            return;
        }

        url.searchParams.set(key, value);

        // Update the URL in the browser
        window.history.replaceState({}, '', url);
    },
    get: (key, defaultParam = null) => {
        // Get the current URL
        const url = new URL(window.location.href);

        let value = url.searchParams.get(key);
        return value ? value : defaultParam;
    },
    remove: (key, defaultParam = null) => {
        // Get the current URL
        const url = new URL(window.location.href);

        url.searchParams.delete(key);

        // Update the URL in the browser
        window.history.replaceState({}, '', url);
    },
};

export const URLPath = {
    lastPath: () => {
        let lastPathPosition = window.location.pathname.lastIndexOf('/');
        return window.location.pathname.slice(parseInt(lastPathPosition) + 1);
    },
}

const URLHelpers = {
    params: URLParam,
    paths: URLPath,
}

export default URLHelpers
