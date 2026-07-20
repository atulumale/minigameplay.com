/*=========================================
        MINI GAMES PLAY
        SCRIPT.JS
=========================================*/

document.addEventListener("DOMContentLoaded", () => {

    /*==============================
        ELEMENTS
    ==============================*/

    const menuBtn = document.querySelector(".menu-btn");
    const sidebar = document.querySelector(".sidebar");
    const main = document.querySelector(".main");
    const overlay = document.querySelector(".overlay");

    /*==============================
        DESKTOP SIDEBAR
    ==============================*/

    if (menuBtn) {

        menuBtn.addEventListener("click", () => {

            if (window.innerWidth > 768) {

                sidebar.classList.toggle("collapsed");
                main.classList.toggle("expand");

            } else {

                sidebar.classList.toggle("show");
                overlay.classList.toggle("active");

            }

        });

    }

    /*==============================
        CLOSE MOBILE SIDEBAR
    ==============================*/

    if (overlay) {

        overlay.addEventListener("click", () => {

            sidebar.classList.remove("show");
            overlay.classList.remove("active");

        });

    }

    /*==============================
        ACTIVE MENU
    ==============================*/

    const menuItems = document.querySelectorAll(".menu li");

    menuItems.forEach(item => {

        item.addEventListener("click", () => {

            menuItems.forEach(i => i.classList.remove("active"));

            item.classList.add("active");

        });

    });

});

/*==================================================
            LIVE SEARCH FILTER
==================================================*/

const searchInput = document.querySelector(".search-box input");
const gameCards = document.querySelectorAll(".game-card");

if (searchInput) {

    searchInput.addEventListener("keyup", function () {

        const value = this.value.toLowerCase();

        gameCards.forEach(card => {

            const title = card.querySelector("h3").textContent.toLowerCase();
            const category = card.querySelector("p").textContent.toLowerCase();

            if (
                title.includes(value) ||
                category.includes(value)
            ) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }

        });

    });

}

/*==================================================
            FAVORITE BUTTON
==================================================*/

document.querySelectorAll(".favorite").forEach(btn => {

    btn.addEventListener("click", function (e) {

        e.stopPropagation();

        this.classList.toggle("active");

        if (this.classList.contains("active")) {

            this.innerHTML = "❤";
            this.style.background = "#ff3b5c";

        } else {

            this.innerHTML = "♡";
            this.style.background = "";

        }

    });

});

/*==================================================
            CATEGORY FILTER
==================================================*/

const categoryCards = document.querySelectorAll(".category-card");

categoryCards.forEach(category => {

    category.addEventListener("click", () => {

        const filter = category.innerText.trim().toLowerCase();

        gameCards.forEach(card => {

            const text = card.querySelector("p").textContent.toLowerCase();

            if (
                filter === "all" ||
                text.includes(filter)
            ) {

                card.style.display = "block";

            } else {

                card.style.display = "none";

            }

        });

    });

});

/*==================================================
            GAME COUNTER
==================================================*/

const counter = document.createElement("div");

counter.className = "game-counter";

counter.innerHTML =
`🎮 ${gameCards.length} Games Available`;

document.body.appendChild(counter);

/*==================================================
            LOADING EFFECT
==================================================*/

window.addEventListener("load", () => {

    document.body.classList.add("loaded");

});

/*==================================================
            KEYBOARD SHORTCUTS
==================================================*/

document.addEventListener("keydown", e => {

    if (e.key === "/") {

        e.preventDefault();

        if (searchInput) {

            searchInput.focus();

        }

    }

    if (e.key === "Escape") {

        sidebar.classList.remove("show");

        overlay.classList.remove("active");

    }

});

/*==================================================
            SMOOTH BUTTON EFFECT
==================================================*/

document.querySelectorAll("button").forEach(button => {

    button.addEventListener("mousedown", function () {

        this.style.transform = "scale(.95)";

    });

    button.addEventListener("mouseup", function () {

        this.style.transform = "";

    });

});

/*==================================================
            CARD CLICK EFFECT
==================================================*/

gameCards.forEach(card => {

    card.addEventListener("click", () => {

        card.classList.add("clicked");

        setTimeout(() => {

            card.classList.remove("clicked");

        }, 300);

    });

});

/*==================================================
            RANDOM HERO BACKGROUND
==================================================*/

const hero = document.querySelector(".hero");

const heroColors = [

"linear-gradient(135deg,#6D4AFF,#8B5CFF)",

"linear-gradient(135deg,#0f2027,#203a43,#2c5364)",

"linear-gradient(135deg,#ff512f,#dd2476)",

"linear-gradient(135deg,#11998e,#38ef7d)"

];

let bgIndex = 0;

setInterval(() => {

    if (!hero) return;

    bgIndex++;

    if (bgIndex >= heroColors.length)
        bgIndex = 0;

    hero.style.background = heroColors[bgIndex];

},10000);

/*==================================================
            GAME CARD STAGGER
==================================================*/

gameCards.forEach((card,index)=>{

    card.style.animationDelay = `${index * 80}ms`;

});

/*==================================================
            THEME TOGGLE
==================================================*/

const profile = document.querySelector(".profile");

const themeBtn = document.createElement("button");

themeBtn.className = "theme-btn";
themeBtn.innerHTML = "🌙";

if(profile){
    profile.parentElement.appendChild(themeBtn);
}

const savedTheme = localStorage.getItem("theme");

if(savedTheme === "light"){
    document.body.classList.add("light-theme");
    themeBtn.innerHTML = "☀️";
}

themeBtn.addEventListener("click",()=>{

    document.body.classList.toggle("light-theme");

    if(document.body.classList.contains("light-theme")){

        themeBtn.innerHTML="☀️";
        localStorage.setItem("theme","light");

    }else{

        themeBtn.innerHTML="🌙";
        localStorage.setItem("theme","dark");

    }

});


/*==================================================
            PROFILE DROPDOWN
==================================================*/

const profileMenu=document.createElement("div");

profileMenu.className="profile-menu";

profileMenu.innerHTML=`

<ul>

<li>👤 My Profile</li>

<li>❤️ Favorites</li>

<li>🎮 Recently Played</li>

<li>⚙ Settings</li>

<li>🚪 Logout</li>

</ul>

`;

document.body.appendChild(profileMenu);

if(profile){

profile.addEventListener("click",()=>{

profileMenu.classList.toggle("show");

});

}

document.addEventListener("click",(e)=>{

if(profile && !profile.contains(e.target) && !profileMenu.contains(e.target)){

profileMenu.classList.remove("show");

}

});


/*==================================================
            NOTIFICATION
==================================================*/

const bell=document.querySelector(".fa-bell");

if(bell){

bell.addEventListener("click",()=>{

alert("🎮 No new notifications");

});

}


/*==================================================
            RANDOM PLAY COUNT
==================================================*/

document.querySelectorAll(".game-meta").forEach(meta=>{

const play=meta.querySelector("span:last-child");

if(play){

const value=Math.floor(Math.random()*900+100);

play.innerHTML=value+"K Plays";

}

});


/*==================================================
            PLAY BUTTON
==================================================*/

document.querySelectorAll(".game-info button").forEach(btn=>{

btn.addEventListener("click",(e)=>{

e.preventDefault();

const card=btn.closest(".game-card");

const game=card.querySelector("h3").innerText;

alert("Launching : "+game);

});

});


/*==================================================
            CATEGORY SCROLLER
==================================================*/

const categorySlider=document.querySelector(".category-slider");

let autoScroll;

function startCategoryScroll(){

if(!categorySlider) return;

autoScroll=setInterval(()=>{

categorySlider.scrollBy({

left:180,

behavior:"smooth"

});

if(categorySlider.scrollLeft+categorySlider.clientWidth>=categorySlider.scrollWidth-20){

categorySlider.scrollTo({

left:0,

behavior:"smooth"

});

}

},3500);

}

startCategoryScroll();


/*==================================================
            STICKY NAVBAR SHADOW
==================================================*/

const navbar=document.querySelector(".navbar");

window.addEventListener("scroll",()=>{

if(window.scrollY>40){

navbar.style.boxShadow="0 15px 30px rgba(0,0,0,.25)";

}else{

navbar.style.boxShadow="none";

}

});


/*==================================================
            PARALLAX HERO
==================================================*/

window.addEventListener("scroll",()=>{

const hero=document.querySelector(".hero");

if(hero){

hero.style.backgroundPositionY=window.pageYOffset*.3+"px";

}

});


/*==================================================
            PERFORMANCE
==================================================*/

window.addEventListener("resize",()=>{

clearTimeout(window.resizedFinished);

window.resizedFinished=setTimeout(()=>{

console.log("Layout Updated");

},250);

});


/*==================================================
            CONSOLE MESSAGE
==================================================*/

console.log("%c Mini Games Play",
"color:#6D4AFF;font-size:24px;font-weight:bold");

console.log("%c Website Loaded Successfully!",
"color:#00ff99;font-size:16px;");


/*==================================================
            END OF SCRIPT
==================================================*/


