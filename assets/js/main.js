(function () {
    'use strict';

    var body = document.body;

    if (!body) {
        return;
    }

    initNavigation(body);
    initSystemModal(body);
})();

function initNavigation(body) {
    var toggle = document.querySelector('[data-nav-toggle]');
    var nav = document.getElementById('site-navigation');
    var overlay = document.querySelector('[data-nav-overlay]');
    var userMenu = document.querySelector('[data-user-menu]');
    var userMenuToggle = document.querySelector('[data-user-menu-toggle]');
    var desktopBreakpoint = 768;

    if (!toggle || !nav || !overlay) {
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
        if (body.classList.contains('modal-open') || event.key !== 'Escape') {
            return;
        }

        if (userMenu && userMenu.classList.contains('is-open')) {
            closeUserMenu();

            if (userMenuToggle) {
                userMenuToggle.focus();
            }

            return;
        }

        closeMenu();
        toggle.focus();
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
}

function initSystemModal(body) {
    var modals = Array.prototype.slice.call(document.querySelectorAll('[data-modal]'));
    var openTriggers = Array.prototype.slice.call(document.querySelectorAll('[data-modal-open]'));
    var activeModal = null;
    var activeDialog = null;
    var activeTrigger = null;
    var closeTimer = null;
    var hoverSuppressionTimer = null;

    if (!modals.length || !openTriggers.length) {
        return;
    }

    function getDialog(modal) {
        return modal ? modal.querySelector('.system-modal__dialog') : null;
    }

    function getFocusableElements() {
        return Array.prototype.slice.call(
            activeDialog.querySelectorAll(
                'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
            )
        );
    }

    function hideModalImmediately(modal) {
        modal.classList.remove('is-open');
        modal.hidden = true;
    }

    function clearHoverSuppression() {
        if (hoverSuppressionTimer) {
            window.clearTimeout(hoverSuppressionTimer);
            hoverSuppressionTimer = null;
        }

        body.classList.remove('suppress-system-card-hover');
    }

    function suppressHoverState() {
        clearHoverSuppression();
        body.classList.add('suppress-system-card-hover');

        window.addEventListener('pointermove', clearHoverSuppression, { once: true });
        hoverSuppressionTimer = window.setTimeout(clearHoverSuppression, 1200);
    }

    function openModal(modal, trigger) {
        if (closeTimer) {
            window.clearTimeout(closeTimer);
            closeTimer = null;
        }

        if (activeModal && activeModal !== modal) {
            if (activeTrigger) {
                activeTrigger.setAttribute('aria-expanded', 'false');
            }

            hideModalImmediately(activeModal);
        }

        activeModal = modal;
        activeDialog = getDialog(modal);
        activeTrigger = trigger;
        modal.hidden = false;
        body.classList.add('modal-open');
        trigger.setAttribute('aria-expanded', 'true');

        window.requestAnimationFrame(function () {
            modal.classList.add('is-open');

            if (activeDialog) {
                activeDialog.focus();
            }
        });
    }

    function closeModal() {
        var activeElement;
        var modalToClose;
        var triggerToRestore;

        if (!activeModal || activeModal.hidden) {
            return;
        }

        activeElement = document.activeElement;
        modalToClose = activeModal;
        triggerToRestore = activeTrigger;

        if (activeElement instanceof HTMLElement && modalToClose.contains(activeElement)) {
            activeElement.blur();
        }

        modalToClose.classList.remove('is-open');
        body.classList.remove('modal-open');
        activeModal = null;
        activeDialog = null;
        activeTrigger = null;

        if (triggerToRestore) {
            triggerToRestore.setAttribute('aria-expanded', 'false');
            triggerToRestore.blur();
        }

        suppressHoverState();

        closeTimer = window.setTimeout(function () {
            modalToClose.hidden = true;
            closeTimer = null;
        }, 320);
    }

    openTriggers.forEach(function (trigger) {
        var targetModalId = trigger.getAttribute('data-modal-open');

        trigger.setAttribute('aria-expanded', 'false');

        trigger.addEventListener('click', function () {
            var targetModal;

            if (!targetModalId) {
                return;
            }

            targetModal = document.getElementById(targetModalId);

            if (!targetModal) {
                return;
            }

            openModal(targetModal, trigger);
        });
    });

    modals.forEach(function (modal) {
        Array.prototype.forEach.call(modal.querySelectorAll('[data-modal-close]'), function (trigger) {
            trigger.addEventListener('click', closeModal);
        });
    });

    document.addEventListener('keydown', function (event) {
        var focusableElements;
        var firstElement;
        var lastElement;

        if (!activeModal || activeModal.hidden || !activeDialog) {
            return;
        }

        if (event.key === 'Escape') {
            event.preventDefault();
            closeModal();
            return;
        }

        if (event.key !== 'Tab') {
            return;
        }

        focusableElements = getFocusableElements();

        if (!focusableElements.length) {
            event.preventDefault();
            activeDialog.focus();
            return;
        }

        firstElement = focusableElements[0];
        lastElement = focusableElements[focusableElements.length - 1];

        if (event.shiftKey && document.activeElement === firstElement) {
            event.preventDefault();
            lastElement.focus();
        } else if (!event.shiftKey && document.activeElement === lastElement) {
            event.preventDefault();
            firstElement.focus();
        }
    });
}
