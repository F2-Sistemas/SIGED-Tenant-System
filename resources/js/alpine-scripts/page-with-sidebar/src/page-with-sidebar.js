document.addEventListener('alpine:init', () => {
    localStorage.setItem('pageWithSidebarIsOpen', (localStorage.getItem('pageWithSidebarIsOpen') ?? true));

    class PageWithSidebar {
        isOpen = null;

        constructor(isOpen = null) {
            this.isOpen = !! (localStorage.getItem('pageWithSidebarIsOpen') ?? isOpen ?? true);
        }

        open() {
            this.isOpen = true;
            localStorage.setItem('pageWithSidebarIsOpen', true);
        }

        close() {
            this.isOpen = false;
            localStorage.setItem('pageWithSidebarIsOpen', false);
        }

        toggle() {
            let isOpen = !(this.isOpen);
            this.isOpen = isOpen;
            localStorage.setItem('pageWithSidebarIsOpen', isOpen);
        }
    };

    let pageWithSidebar = new PageWithSidebar();

    Alpine.store('pageWithSidebar', pageWithSidebar);
})
