document.addEventListener('DOMContentLoaded', function(){
    const toggle = document.getElementById('theme-toggle');
    const root = document.documentElement;

    function applyTheme(theme){
        if(theme === 'dark'){
            document.body.classList.add('dark');
            if(toggle) toggle.textContent = '☀️';
        } else {
            document.body.classList.remove('dark');
            if(toggle) toggle.textContent = '🌙';
        }
    }

    // init from localStorage or prefers-color-scheme
    let stored = localStorage.getItem('theme');
    if(!stored){
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        stored = prefersDark ? 'dark' : 'light';
    }
    applyTheme(stored);

    if(toggle){
        toggle.addEventListener('click', function(){
            const now = document.body.classList.contains('dark') ? 'light' : 'dark';
            applyTheme(now);
            localStorage.setItem('theme', now);
        });
    }

});
