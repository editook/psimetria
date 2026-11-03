<?php
if (!isset($hasUnviewedUpdates)) {
    $hasUnviewedUpdates = false;
    if (isset($_SESSION['REST_id_user'])) {
        require_once __DIR__ . '/../connection.php';
        require_once __DIR__ . '/../models/model_update_system.php';
        $headerUpdateSystemModel = new ModelUpdateSystem();
        $hasUnviewedUpdates = $headerUpdateSystemModel->hasUnviewedUpdates((int) $_SESSION['REST_id_user']);
    }
}
?>
<style>
    .update-system-blink {
        animation: update-system-blink 1s steps(2, start) infinite;
        color: #e63946;
        font-weight: 700;
    }

    @keyframes update-system-blink {
        to {
            visibility: hidden;
        }
    }
</style>
<div class="sticky">
    <div class="horizontal-main hor-menu clearfix side-header">
        <div class="horizontal-mainwrapper container clearfix">
            <!--Nav-->
            <nav class="horizontalMenu clearfix">
                <ul class="horizontalMenu-list">
                    <li aria-haspopup="true"><a href="<?= LOCALHOST . '/view/index.php' ?>" class=""><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0V0z" fill="none" />
                                <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
                                <path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
                            </svg>Inicio</a></li>

                    <li aria-haspopup="true"><a href="<?= LOCALHOST . '/view/calendary.php' ?>" class="sub-icon"><svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="side-menu__icon"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg> Calendario </a>
                    </li>

                    <?php
                    if ($_SESSION['REST_type_user'] == 'Administrador') {
                    ?>
                        <li aria-haspopup="true"><a href="<?= LOCALHOST . '/view/configuration.php' ?>" class="sub-icon"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                                    <path d="M0 0h24v24H0V0z" fill="none" />
                                    <path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" opacity=".3" />
                                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z" />
                                </svg> Configuracion </a>
                        </li>
                    <?php
                    }
                    ?>
                    <li aria-haspopup="true">
                        <a href="<?= LOCALHOST . '/view/update-system.php' ?>" class="sub-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                            </svg> Actualizaciones
                            <?php if ($hasUnviewedUpdates): ?><span class="update-system-blink ms-1" aria-label="Novedades sin ver">●</span><?php endif; ?>
                        </a>
                    </li>

                </ul>
            </nav>
            <!--Nav-->
        </div>
    </div>
</div>