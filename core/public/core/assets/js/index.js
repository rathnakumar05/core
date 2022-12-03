document.addEventListener("DOMContentLoaded", function(event) {

    const showNavbar = (toggleId, navId, bodyId, headerId, toggleId1) => {
        const toggle = document.getElementById(toggleId),
            nav = document.getElementById(navId),
            bodypd = document.getElementById(bodyId),
            headerpd = document.getElementById(headerId),
            toggle_1 = document.getElementById(toggleId1);
        if (toggle && nav && bodypd && headerpd && toggle_1) {
                toggle.addEventListener('click', () => {
                    nav.classList.toggle('show-0');
                    toggle.classList.toggle('bx-x');
                    toggle_1.classList.toggle('show-1');
                    bodypd.classList.toggle('body');
                    headerpd.classList.toggle('body');
                });

                toggle_1.addEventListener('click', () => {
                    nav.classList.toggle('show-0');
                    toggle.classList.toggle('bx-x');
                    document.getElementById('header-toggle-2').classList.toggle('show-1');
                    bodypd.classList.toggle('body');
                    headerpd.classList.toggle('body');
                });
        }
    }

    showNavbar('header-toggle-1', 'nav-bar', 'body', 'header', 'header-toggle-2')

    /*===== LINK ACTIVE =====*/
    // const linkColor = document.querySelectorAll('.nav_link')

    // function colorLink() {
    //     if (linkColor) {
    //         linkColor.forEach(l => l.classList.remove('active'))
    //         this.classList.add('active')
    //     }
    // }
    // linkColor.forEach(l => l.addEventListener('click', colorLink))

    // Your code to run since DOM is loaded and ready
});


$().ready(function () {
    $("#logoutBtn").on('click', function () {
        $("#logout").submit();
    })
});
