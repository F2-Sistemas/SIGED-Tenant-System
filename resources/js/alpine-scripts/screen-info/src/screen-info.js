document.addEventListener('alpine:init', () => {
    const screenType = (windowWidth) => {
        if (windowWidth <= 700) {
            return 'mobile';
        }

        if (windowWidth <= 1024) {
            return 'medium';
        }

        if (windowWidth <= 2048) {
            return 'large';
        }

        if (windowWidth > 2048) {
            return 'extra large';
        }

        return '';
    }

    Alpine.store('windowWidth', window.innerWidth);
    Alpine.store('windowHeight', window.innerHeight);
    Alpine.store('screenType', screenType(window.innerWidth));
    Alpine.store('screenInfo', {
        width: window.innerWidth,
        height: window.innerHeight,
        screenType: screenType(window.innerWidth),
        isMediumOrLess: () => {
            return (window.innerHeight <= 1024);
        },
        isMobile: () => {
            return (window.innerHeight <= 700);
        }
    });

    new ResizeObserver(entries => {
        const screenInfo = {
            width: entries[0].contentRect.width,
            height: entries[0].contentRect.height,
            screenType: screenType(entries[0].contentRect.width),
            isMediumOrLess: () => {
                return (entries[0].contentRect.width <= 1024);
            },
            isMobile: () => {
                return (entries[0].contentRect.width <= 700);
            }
        };

        Alpine.store('screenInfo', {
            ...screenInfo
        });

        Alpine.store('windowWidth', entries[0].contentRect.width);
        Alpine.store('windowHeight', entries[0].contentRect.height);
        Alpine.store('screenType', screenType(entries[0].contentRect.width));
    }).observe(document.body);
})
