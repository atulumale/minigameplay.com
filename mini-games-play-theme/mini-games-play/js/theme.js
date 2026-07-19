/*=========================================
    MINI GAMES PLAY — THEME.JS
    Adapted from the original static site's
    first.js for the WordPress theme.
=========================================*/

document.addEventListener('DOMContentLoaded', () => {

    /*==============================
        ELEMENTS
    ==============================*/

    const menuBtn = document.querySelector('.menu-btn');
    const sidebar = document.querySelector('.sidebar');
    const main = document.querySelector('.main');
    const overlay = document.querySelector('.overlay');
    const searchInput = document.querySelector('.search-box input[type="text"]');
    const gameCards = document.querySelectorAll('.game-card');

    /*==============================
        DESKTOP / MOBILE SIDEBAR
    ==============================*/

    if (menuBtn) {
        menuBtn.addEventListener('click', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.toggle('collapsed');
                main.classList.toggle('expand');
            } else {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('active');
            }
        });
    }

    if (overlay) {
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('active');
        });
    }

    /*==============================
        ACTIVE MENU ITEM
        (WordPress already marks the
        current item via current-menu-item,
        this just supports manual clicks)
    ==============================*/

    const menuItems = document.querySelectorAll('.menu li');
    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            menuItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
        });
    });

    /*==============================
        LIVE SEARCH FILTER
        (client-side quick filter on
        cards already on the page —
        full search still submits to
        WordPress search.php)
    ==============================*/

    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            const value = this.value.toLowerCase();

            gameCards.forEach(card => {
                const titleEl = card.querySelector('h3');
                const catEl = card.querySelector('.game-info p');
                const title = titleEl ? titleEl.textContent.toLowerCase() : '';
                const category = catEl ? catEl.textContent.toLowerCase() : '';

                card.style.display = (title.includes(value) || category.includes(value)) ? 'block' : 'none';
            });
        });
    }

    /*==============================
        FAVORITE BUTTON
    ==============================*/

    document.querySelectorAll('.favorite').forEach(btn => {
        const gameId = btn.dataset.gameId;
        const stored = gameId ? localStorage.getItem('mgp_fav_' + gameId) : null;

        if (stored === '1') {
            btn.classList.add('active');
            btn.innerHTML = '❤';
            btn.style.background = '#ff3b5c';
        }

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            this.classList.toggle('active');

            if (this.classList.contains('active')) {
                this.innerHTML = '❤';
                this.style.background = '#ff3b5c';
                if (gameId) localStorage.setItem('mgp_fav_' + gameId, '1');
            } else {
                this.innerHTML = '♡';
                this.style.background = '';
                if (gameId) localStorage.removeItem('mgp_fav_' + gameId);
            }
        });
    });

    /*==============================
        GAME COUNTER
    ==============================*/

    if (gameCards.length) {
        const counter = document.createElement('div');
        counter.className = 'game-counter';
        counter.innerHTML = `🎮 ${gameCards.length} Games Shown`;
        document.body.appendChild(counter);
    }

    /*==============================
        LOADING EFFECT
    ==============================*/

    window.addEventListener('load', () => {
        document.body.classList.add('loaded');
    });

    /*==============================
        KEYBOARD SHORTCUTS
    ==============================*/

    document.addEventListener('keydown', e => {
        if (e.key === '/') {
            e.preventDefault();
            if (searchInput) searchInput.focus();
        }
        if (e.key === 'Escape') {
            if (sidebar) sidebar.classList.remove('show');
            if (overlay) overlay.classList.remove('active');
        }
    });

    /*==============================
        SMOOTH BUTTON EFFECT
    ==============================*/

    document.querySelectorAll('button').forEach(button => {
        button.addEventListener('mousedown', function () {
            this.style.transform = 'scale(.95)';
        });
        button.addEventListener('mouseup', function () {
            this.style.transform = '';
        });
    });

    /*==============================
        CARD CLICK EFFECT
    ==============================*/

    gameCards.forEach(card => {
        card.addEventListener('click', () => {
            card.classList.add('clicked');
            setTimeout(() => card.classList.remove('clicked'), 300);
        });
    });

    /*==============================
        RANDOM HERO BACKGROUND
    ==============================*/

    const hero = document.querySelector('.hero');
    const heroColors = [
        'linear-gradient(135deg,#6D4AFF,#8B5CFF)',
        'linear-gradient(135deg,#0f2027,#203a43,#2c5364)',
        'linear-gradient(135deg,#ff512f,#dd2476)',
        'linear-gradient(135deg,#11998e,#38ef7d)'
    ];
    let bgIndex = 0;

    if (hero) {
        setInterval(() => {
            bgIndex = (bgIndex + 1) % heroColors.length;
            hero.style.background = heroColors[bgIndex];
        }, 10000);
    }

    /*==============================
        GAME CARD STAGGER
    ==============================*/

    gameCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 80}ms`;
    });

    /*==============================
        THEME TOGGLE (dark / light)
    ==============================*/

    const profile = document.querySelector('.profile');
    const themeBtn = document.createElement('button');
    themeBtn.className = 'theme-btn';
    themeBtn.innerHTML = '🌙';

    if (profile) {
        profile.parentElement.appendChild(themeBtn);
    }

    const savedTheme = localStorage.getItem('mgp_theme');
    if (savedTheme === 'light') {
        document.body.classList.add('light-theme');
        themeBtn.innerHTML = '☀️';
    }

    themeBtn.addEventListener('click', () => {
        document.body.classList.toggle('light-theme');
        if (document.body.classList.contains('light-theme')) {
            themeBtn.innerHTML = '☀️';
            localStorage.setItem('mgp_theme', 'light');
        } else {
            themeBtn.innerHTML = '🌙';
            localStorage.setItem('mgp_theme', 'dark');
        }
    });

    /*==============================
        PROFILE DROPDOWN
    ==============================*/

    const profileMenu = document.createElement('div');
    profileMenu.className = 'profile-menu';
    profileMenu.innerHTML = `
        <ul>
            <li>👤 My Profile</li>
            <li>❤️ Favorites</li>
            <li>🎮 Recently Played</li>
            <li>⚙ Settings</li>
            <li>🚪 Logout</li>
        </ul>
    `;
    document.body.appendChild(profileMenu);

    if (profile) {
        profile.addEventListener('click', () => {
            profileMenu.classList.toggle('show');
        });
    }

    document.addEventListener('click', (e) => {
        if (profile && !profile.contains(e.target) && !profileMenu.contains(e.target)) {
            profileMenu.classList.remove('show');
        }
    });

    /*==============================
        NOTIFICATION BELL
    ==============================*/

    const bell = document.querySelector('.fa-bell');
    if (bell) {
        bell.addEventListener('click', () => {
            alert('🎮 No new notifications');
        });
    }

    /*==============================
        CATEGORY SCROLLER
    ==============================*/

    const categorySlider = document.querySelector('.category-slider');
    if (categorySlider) {
        setInterval(() => {
            categorySlider.scrollBy({ left: 180, behavior: 'smooth' });

            if (categorySlider.scrollLeft + categorySlider.clientWidth >= categorySlider.scrollWidth - 20) {
                categorySlider.scrollTo({ left: 0, behavior: 'smooth' });
            }
        }, 3500);
    }

    /*==============================
        STICKY NAVBAR SHADOW
    ==============================*/

    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (!navbar) return;
        navbar.style.boxShadow = window.scrollY > 40 ? '0 15px 30px rgba(0,0,0,.25)' : 'none';
    });

    /*==============================
        PARALLAX HERO
    ==============================*/

    window.addEventListener('scroll', () => {
        if (hero) {
            hero.style.backgroundPositionY = (window.pageYOffset * 0.3) + 'px';
        }
    });

});

/*==================================================
    PERFORMANCE: resize log
==================================================*/

window.addEventListener('resize', () => {
    clearTimeout(window.mgpResizeTimer);
    window.mgpResizeTimer = setTimeout(() => {
        console.log('Layout Updated');
    }, 250);
});

/*==================================================
    CONSOLE MESSAGE
==================================================*/

console.log('%c Mini Games Play', 'color:#6D4AFF;font-size:24px;font-weight:bold');
console.log('%c WordPress Theme Loaded Successfully!', 'color:#00ff99;font-size:16px;');
