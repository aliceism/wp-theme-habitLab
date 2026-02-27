(function () {
    'use strict';

    var body = document.body;
    var toggle = document.querySelector('[data-nav-toggle]');
    var nav = document.getElementById('site-navigation');
    var overlay = document.querySelector('[data-nav-overlay]');
    var desktopBreakpoint = 768;

    if (!body || !toggle || !nav || !overlay) {
        return;
    }

    function setMenuState(isOpen) {
        body.classList.toggle('nav-open', isOpen);
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
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
            closeMenu();
            toggle.focus();
        }
    });

    nav.addEventListener('click', function (event) {
        var target = event.target;

        if (window.innerWidth < desktopBreakpoint && target instanceof Element && target.closest('a')) {
            closeMenu();
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth >= desktopBreakpoint) {
            closeMenu();
        }
    });
})();
