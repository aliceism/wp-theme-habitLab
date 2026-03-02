(function () {
    'use strict';

    var body = document.body;
    var toggle = document.querySelector('[data-nav-toggle]');
    var nav = document.getElementById('site-navigation');
    var overlay = document.querySelector('[data-nav-overlay]');
    var userMenu = document.querySelector('[data-user-menu]');
    var userMenuToggle = document.querySelector('[data-user-menu-toggle]');
    var desktopBreakpoint = 768;

    if (!body || !toggle || !nav || !overlay) {
        return;
    }

    function setUserMenuState(isOpen) {
        if (!userMenu || !userMenuToggle) {
            return;
        }

        userMenu.classList.toggle('is-open', isOpen);
        userMenuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }

    function closeUserMenu() {
        setUserMenuState(false);
    }

    function setMenuState(isOpen) {
        body.classList.toggle('nav-open', isOpen);
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

        if (!isOpen) {
            closeUserMenu();
        }
    }

    function closeMenu() {
        setMenuState(false);
    }

    toggle.addEventListener('click', function () {
        var isOpen = body.classList.contains('nav-open');
        setMenuState(!isOpen);
    });

    overlay.addEventListener('click', closeMenu);

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            if (userMenu && userMenu.classList.contains('is-open')) {
                closeUserMenu();
                if (userMenuToggle) {
                    userMenuToggle.focus();
                }
                return;
            }

            closeMenu();
            toggle.focus();
        }
    });

    nav.addEventListener('click', function (event) {
        var target = event.target;

        if (
            window.innerWidth < desktopBreakpoint &&
            target instanceof Element &&
            target.closest('a') &&
            !target.closest('[data-user-menu-panel]')
        ) {
            closeMenu();
        }
    });

    if (userMenu && userMenuToggle) {
        userMenuToggle.addEventListener('click', function () {
            var isOpen = userMenu.classList.contains('is-open');
            setUserMenuState(!isOpen);
        });

        document.addEventListener('click', function (event) {
            var target = event.target;

            if (target instanceof Element && !userMenu.contains(target)) {
                closeUserMenu();
            }
        });
    }

    window.addEventListener('resize', function () {
        if (window.innerWidth >= desktopBreakpoint) {
            closeMenu();
        }

        if (window.innerWidth < desktopBreakpoint) {
            closeUserMenu();
        }
    });
})();
