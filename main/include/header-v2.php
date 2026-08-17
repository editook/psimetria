<?php
include_once('../configs.php');
?>
<!-- TOP HEADER BAR -->
<header id="main-header" class="w-full bg-white border-b border-slate-200 sticky top-0 z-40 select-none">

    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between h-16">

            <!-- LEFT: Brand Logo & Mobile Menu Toggle -->
            <div class="flex items-center gap-3">

                <!-- Brand Logo -->
                <a
                    id="brand-logo-link"
                    href="<?= LOCALHOST ?>"
                    class="flex items-center gap-2.5 group transition-transform active:scale-95">

                    <div class="relative flex items-center justify-center w-10 h-10">

                        <img src="../../assets/img/brand/favicon.png" class="desktop-logo">

                    </div>

                    <!-- Brand Typography -->
                    <div class="flex flex-col leading-none">
                        <span class="text-xs font-black tracking-widest text-[#00828A] uppercase">
                            PSYMETRIA
                        </span>
                    </div>

                </a>

            </div>


            <!-- RIGHT -->
            <div class="flex items-center gap-3 sm:gap-4">

                <!-- COUNTRY SELECTOR -->
                <div class="relative dropdown-container">

                    <button
                        type="button"
                        class="flex items-center justify-center p-1 rounded-md hover:bg-slate-100 transition-colors border border-transparent hover:border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        title="Seleccionar Región / Idioma"
                        aria-haspopup="true"
                        aria-expanded="false">

                        <!-- Bolivia Flag -->
                        <img src="../../assets/img/flags/bolivia.png" alt="img">

                    </button>

                </div>


                <!-- FULLSCREEN -->
                <button
                    id="fullscreen-toggle-btn"
                    type="button"
                    class="flex items-center justify-center w-8 h-8 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    title="Pantalla Completa"
                    aria-label="Alternar pantalla completa">

                    <i data-lucide="maximize" class="w-5 h-5"></i>

                </button>


                <!-- USER PROFILE -->
                <div class="relative dropdown-container">

                    <button
                        id="user-profile-btn"
                        type="button"
                        class="relative flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-full"
                        aria-haspopup="true"
                        aria-expanded="false">

                        <!-- Avatar -->
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-gradient-to-b from-blue-100 to-sky-200 border-2 border-white shadow-sm flex items-center justify-center overflow-hidden">

                            <img alt="" src="../../assets/img/users/profile.png">

                        </div>

                        <!-- Online status -->
                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>

                    </button>


                    <!-- USER DROPDOWN -->
                    <div
                        id="user-dropdown-menu"
                        class="hidden absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-slate-200 py-2 z-50">

                        <!-- User info -->
                        <div class="px-4 py-3 border-b border-slate-100">

                            <p class="text-xs font-semibold text-slate-800">
                                <?= $_SESSION['REST_name_user'] ?>
                            </p>

                            <p class="text-xs text-blue-600 font-medium truncate">
                                <?= $_SESSION['REST_type_user'] ?>
                            </p>

                        </div>


                        <!-- Menu -->
                        <div class="py-1">


                            <a
                                href="<?= LOCALHOST ?>/view/configuration.php"
                                class="w-full flex items-center gap-2.5 px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 transition-colors">
                                <i data-lucide="settings" class="w-5 h-5"></i>

                                Configuración
                            </a>



                        </div>


                        <!-- Logout -->
                        <div class="border-t border-slate-100 pt-1">

                            <a
                                href="../close_session.php"
                                class="w-full flex items-center gap-2.5 px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors">
                                <i data-lucide="x" class="w-5 h-5"></i>


                                Cerrar Sesión

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- SECONDARY NAVIGATION -->
    <div class="w-full bg-white border-t border-slate-200 shadow-2xs">

        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <nav
                class="flex items-center gap-6 sm:gap-8 h-11"
                aria-label="Navegación secundaria">

                <!-- INICIO -->
                <a

                    href="<?= LOCALHOST . '/view/index.php' ?>"
                    class="relative inline-flex items-center gap-2 h-full px-1 text-sm font-medium text-blue-600 transition-all group focus:outline-none">

                    <i data-lucide="home" class="w-5 h-5"></i>

                    <span class="tracking-normal">
                        Inicio
                    </span>

                </a>
                <a

                    href="<?= LOCALHOST . '/view/calendary.php' ?>"
                    class="relative inline-flex items-center gap-2 h-full px-1 text-sm font-medium text-blue-600 transition-all group focus:outline-none">

                    <i data-lucide="calendar" class="w-5 h-5"></i>

                    <span class="tracking-normal">
                        Calendario
                    </span>

                </a>
                <?php
                if ($_SESSION['REST_type_user'] == 'Administrador') {
                ?>
                    <a
                        href="<?= LOCALHOST ?>/view/configuration.php"
                        class="relative inline-flex items-center gap-2 h-full px-1 text-sm font-medium text-slate-600 hover:text-slate-900 transition-all group focus:outline-none">

                        <i data-lucide="settings" class="w-5 h-5"></i>

                        <span class="tracking-normal">
                            Configuracion
                        </span>

                    </a>
                <?php
                }
                ?>
            </nav>

        </div>

    </div>

</header>