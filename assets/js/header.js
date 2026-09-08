$(document).ready(function () {


    $('#user-profile-btn').on('click', function (e) {

        e.stopPropagation();

        $('#user-dropdown-menu').toggleClass('hidden');


        const isOpen = !$('#user-dropdown-menu').hasClass('hidden');

        $(this).attr('aria-expanded', isOpen);

    });


    /*
    |--------------------------------------------------------------------------
    | CLOSE DROPDOWNS WHEN CLICK OUTSIDE
    |--------------------------------------------------------------------------
    */

    $(document).on('click', function () {

        $('#user-dropdown-menu').addClass('hidden');

        $('#user-profile-btn')
            .attr('aria-expanded', 'false');

    });


    /*
    |--------------------------------------------------------------------------
    | PREVENT DROPDOWN CLOSE WHEN CLICKING INSIDE
    |--------------------------------------------------------------------------
    */

    $('#user-dropdown-menu').on('click', function (e) {
        e.stopPropagation();
    });




    /*
    |--------------------------------------------------------------------------
    | FULLSCREEN
    |--------------------------------------------------------------------------
    */

    $('#fullscreen-toggle-btn').on('click', function () {

        if (!document.fullscreenElement) {

            document.documentElement
                .requestFullscreen()
                .catch(function (err) {
                    console.error(
                        'No se pudo activar pantalla completa:',
                        err
                    );
                });

        } else {

            document.exitFullscreen();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | UPDATE FULLSCREEN ICON
    |--------------------------------------------------------------------------
    */

    $(document).on('fullscreenchange', function () {

        const $button = $('#fullscreen-toggle-btn');

        if (document.fullscreenElement) {

            $button.attr('title', 'Salir de Pantalla Completa');

        } else {

            $button.attr('title', 'Pantalla Completa');

        }

    });


});