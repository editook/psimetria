<?php
include_once('../configs.php');
session_start();

if (empty($_SESSION['REST_type_user']) || empty($_SESSION['REST_id_user'])) {
    header('Location: ' . LOCALHOST . '/signin.php');
    exit;
}

require_once '../connection.php';
require_once '../models/model_update_system.php';

$updateSystemModel = new ModelUpdateSystem();
$isAdmin = $_SESSION['REST_type_user'] === 'Administrador';
$userId = (int) $_SESSION['REST_id_user'];

if (empty($_SESSION['update_system_csrf'])) {
    $_SESSION['update_system_csrf'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['update_system_csrf'];

function updateSystemRedirect(int $page, string $message, string $type = 'success'): void
{
    $_SESSION['update_system_flash'] = ['message' => $message, 'type' => $type];
    header('Location: update-system.php?page=' . max(1, $page));
    exit;
}

function updateSystemUploadImage(array $file, string $updateDate, string $uploadDirectory): ?string
{
    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > 5 * 1024 * 1024) {
        throw new RuntimeException('La imagen no se pudo cargar o supera el límite de 5 MB.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);
    $extensions = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];
    if (!isset($extensions[$mimeType])) {
        throw new RuntimeException('Formato de imagen no permitido. Usa JPG, PNG, WEBP o GIF.');
    }

    if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true) && !is_dir($uploadDirectory)) {
        throw new RuntimeException('No se pudo preparar la carpeta de imágenes.');
    }
    $random_number = random_int(19398, 119398);
    $fileName = 'EA-SU-' . $updateDate . '-' . $random_number . '.' . $extensions[$mimeType];
    if (!move_uploaded_file($file['tmp_name'], $uploadDirectory . DIRECTORY_SEPARATOR . $fileName)) {
        throw new RuntimeException('No se pudo guardar la imagen cargada.');
    }
    return $fileName;
}

function updateSystemDeleteImage(?string $fileName, string $uploadDirectory): void
{
    if ($fileName === null || $fileName === '') {
        return;
    }
    $baseName = basename($fileName);
    if ($baseName === $fileName && strpos($baseName, 'EA-SU-') === 0) {
        $path = $uploadDirectory . DIRECTORY_SEPARATOR . $baseName;
        if (is_file($path)) {
            unlink($path);
        }
    }
}

$uploadDirectory = dirname(__DIR__, 2) . '/assets/update-system';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($postedToken) || !hash_equals($csrfToken, $postedToken)) {
        updateSystemRedirect(1, 'La solicitud expiró. Vuelve a intentarlo.', 'danger');
    }
    if (!$isAdmin) {
        http_response_code(403);
        exit('No tienes permisos para administrar las actualizaciones.');
    }

    $action = $_POST['action'] ?? '';
    $pageAfterPost = filter_var($_POST['page'] ?? 1, FILTER_VALIDATE_INT);
    $pageAfterPost = max(1, $pageAfterPost !== false ? $pageAfterPost : 1);

    try {
        if ($action === 'create_update' || $action === 'edit_update') {
            $title = trim((string) ($_POST['title'] ?? ''));
            $version = trim((string) ($_POST['version'] ?? ''));
            $dateInput = trim((string) ($_POST['update_date'] ?? ''));
            $date = DateTime::createFromFormat('Y-m-d', $dateInput);
            $dateErrors = DateTime::getLastErrors();
            if ($title === '' || strlen($title) > 200 || $version === '' || strlen($version) > 20 || !$date || ($dateErrors !== false && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0))) {
                throw new RuntimeException('Completa un título, una versión y una fecha válidos.');
            }

            $dateValue = $date->format('Y-m-d H:i:s');
            if ($action === 'create_update') {
                $newId = $updateSystemModel->createUpdate($dateValue, $title, $version);
                if ($newId === false) {
                    throw new RuntimeException('No se pudo crear el registro de actualización.');
                }
                $updateSystemModel->markAllUnviewed((int) $newId);
                updateSystemRedirect(1, 'Registro de actualización creado.');
            }

            $updateId = filter_var($_POST['update_id'] ?? null, FILTER_VALIDATE_INT);
            if ($updateId === false || !$updateSystemModel->getUpdate((int) $updateId)) {
                throw new RuntimeException('No se encontró el registro que intentas actualizar.');
            }
            if (!$updateSystemModel->updateUpdate((int) $updateId, $dateValue, $title, $version)) {
                throw new RuntimeException('No se pudo actualizar el registro.');
            }
            $updateSystemModel->markAllUnviewed((int) $updateId);
            updateSystemRedirect($pageAfterPost, 'Registro de actualización actualizado.');
        }

        if ($action === 'delete_update') {
            $updateId = filter_var($_POST['update_id'] ?? null, FILTER_VALIDATE_INT);
            $update = $updateId !== false ? $updateSystemModel->getUpdate((int) $updateId) : null;
            if (!$update) {
                throw new RuntimeException('No se encontró el registro que intentas eliminar.');
            }
            $items = $updateSystemModel->getItems((int) $updateId);
            if (!$updateSystemModel->deleteUpdate((int) $updateId)) {
                throw new RuntimeException('No se pudo eliminar el registro.');
            }
            foreach ($items as $item) {
                updateSystemDeleteImage($item['item_image'], $uploadDirectory);
            }
            updateSystemRedirect($pageAfterPost, 'Registro de actualización eliminado.');
        }

        if ($action === 'create_item' || $action === 'edit_item') {
            $updateId = filter_var($_POST['update_id'] ?? null, FILTER_VALIDATE_INT);
            $update = $updateId !== false ? $updateSystemModel->getUpdate((int) $updateId) : null;
            $itemName = trim((string) ($_POST['item_name'] ?? ''));
            if (!$update || $itemName === '' || strlen($itemName) > 500) {
                throw new RuntimeException('Completa el contenido del ítem.');
            }

            $itemId = null;
            $existingItem = null;
            if ($action === 'edit_item') {
                $itemId = filter_var($_POST['item_id'] ?? null, FILTER_VALIDATE_INT);
                $existingItem = $itemId !== false ? $updateSystemModel->getItem((int) $itemId) : null;
                if (!$existingItem || (int) $existingItem['id_update_system'] !== (int) $updateId) {
                    throw new RuntimeException('No se encontró el ítem que intentas actualizar.');
                }
            }

            $newImage = updateSystemUploadImage(
                $_FILES['item_image'] ?? [],
                date('Y-m-d', strtotime($update['date'])),
                $uploadDirectory
            );
            $removeCurrentImage = isset($_POST['remove_image']);
            $imageName = $newImage ?? ($removeCurrentImage ? null : ($existingItem['item_image'] ?? null));

            if ($action === 'create_item') {
                $savedItem = $updateSystemModel->createItem((int) $updateId, $itemName, $imageName);
                if ($savedItem === false) {
                    updateSystemDeleteImage($newImage, $uploadDirectory);
                    throw new RuntimeException('No se pudo crear el ítem.');
                }
            } else {
                if (!$updateSystemModel->updateItem((int) $itemId, $itemName, $imageName)) {
                    updateSystemDeleteImage($newImage, $uploadDirectory);
                    throw new RuntimeException('No se pudo actualizar el ítem.');
                }
                if ($existingItem['item_image'] !== $imageName) {
                    updateSystemDeleteImage($existingItem['item_image'], $uploadDirectory);
                }
            }
            $updateSystemModel->markAllUnviewed((int) $updateId);
            updateSystemRedirect($pageAfterPost, 'Ítem guardado correctamente.');
        }

        if ($action === 'delete_item') {
            $itemId = filter_var($_POST['item_id'] ?? null, FILTER_VALIDATE_INT);
            $item = $itemId !== false ? $updateSystemModel->getItem((int) $itemId) : null;
            if (!$item) {
                throw new RuntimeException('No se encontró el ítem que intentas eliminar.');
            }
            if (!$updateSystemModel->deleteItem((int) $itemId)) {
                throw new RuntimeException('No se pudo eliminar el ítem.');
            }
            updateSystemDeleteImage($item['item_image'], $uploadDirectory);
            $updateSystemModel->markAllUnviewed((int) $item['id_update_system']);
            updateSystemRedirect($pageAfterPost, 'Ítem eliminado correctamente.');
        }

        throw new RuntimeException('Acción no reconocida.');
    } catch (RuntimeException $error) {
        updateSystemRedirect($pageAfterPost, $error->getMessage(), 'danger');
    }
}

$updateSystemModel->markViewed($userId);
$flash = $_SESSION['update_system_flash'] ?? null;
unset($_SESSION['update_system_flash']);

$pageSize = 8;
$requestedPage = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT);
$currentPage = max(1, $requestedPage !== false ? $requestedPage : 1);
$totalUpdates = $updateSystemModel->countUpdates();
$totalPages = max(1, (int) ceil($totalUpdates / $pageSize));
$currentPage = min($currentPage, $totalPages);
$offset = ($currentPage - 1) * $pageSize;
$updates = $updateSystemModel->getUpdates($pageSize, $offset);
$firstUpdate = $totalUpdates > 0 ? $offset + 1 : 0;
$lastUpdate = min($offset + $pageSize, $totalUpdates);
$todayDate = date('Y-m-d');
$defaultVersion = VERSION_CODE;
$escape = static function ($value): string {
    return htmlspecialchars((string) $value);
};
$formatUpdateItem = static function ($value) use ($escape): string {
    $escapedText = $escape($value);
    $uppercasePattern = '/(?<![\p{L}\p{N}])(?=[\p{Lu}\p{N}_-]*(?:[ \t]+[\p{Lu}\p{N}_-]*)*\p{Lu})[\p{Lu}\p{N}_-]+(?:[ \t]+[\p{Lu}\p{N}_-]+)*(?![\p{L}\p{N}])/u';
    $formattedText = preg_replace_callback($uppercasePattern, static function ($matches): string {
        return '<span class="update-system-uppercase">' . $matches[0] . '</span>';
    }, $escapedText);

    return nl2br($formattedText ?? $escapedText);
};
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $escape(WEB_TITLE) ?> - Actualizaciones</title>
    <link rel="icon" href="../../assets/img/brand/favicon.png" type="image/x-icon">
    <link href="../../assets/css/icons.css?v=<?= $escape(VERSION_CODE) ?>" rel="stylesheet">
    <link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/plugins/sidebar/sidebar.css" rel="stylesheet">
    <link href="../../assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet">
    <link href="../../assets/css/style.css?v=<?= $escape(VERSION_CODE) ?>" rel="stylesheet">
    <link href="../../assets/css/style-dark.css" rel="stylesheet">
    <link href="../../assets/css/boxed.css" rel="stylesheet">
    <link href="../../assets/css/dark-boxed.css" rel="stylesheet">
    <link href="../../assets/css/skin-modes.css" rel="stylesheet">
    <style>
        .update-system-image {
            max-width: 100%;
            max-height: 340px;
            object-fit: contain;
            border-radius: 8px;
        }

        .update-system-item {
            border-left: 3px solid #6259ca;
            padding-left: .75rem;
        }

        .update-system-list {
            list-style: disc !important;
            list-style-position: outside;
            padding-left: 2.5rem !important;
            margin-bottom: 0;
        }

        .update-system-list>li::marker {
            color: #6259ca;
        }

        .update-system-version {
            font-family: monospace;
        }

        .update-system-uppercase {
            font-weight: 700;
        }
    </style>
</head>

<body class="main-body">
    <div id="global-loader"><img src="../../assets/img/loader.svg" class="loader-img" alt="Cargando"></div>
    <div class="page <?= TESTING === '1' ? 'istesting' : '' ?>">
        <?php include('../include/header_top.php'); ?>
        <?php include('../include/header_bottom.php'); ?>

        <main class="main-content horizontal-content">
            <div class="container containermobile pt-4 pb-5">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="tx-24 mb-1">Historial de actualizaciones</h1>
                        <p class="text-muted mb-0">Novedades y cambios disponibles en el sistema.</p>
                    </div>
                    <?php if ($isAdmin): ?>
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#updateSystemModal" onclick="openUpdateSystemModal()">
                            <i class="las la-plus"></i> Nueva actualización
                        </button>
                    <?php endif; ?>
                </div>

                <?php if ($flash): ?>
                    <div class="alert alert-<?= $escape($flash['type']) ?> alert-dismissible fade show" role="alert">
                        <?= $escape($flash['message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                <?php endif; ?>

                <?php if (count($updates) === 0): ?>
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="las la-bullhorn tx-50 text-muted"></i>
                            <h2 class="tx-18 mt-2">Todavía no hay actualizaciones</h2>
                        </div>
                    </div>
                <?php endif; ?>

                <?php foreach ($updates as $update): ?>
                    <?php $items = $updateSystemModel->getItems((int) $update['id']); ?>
                    <article class="card mb-4">
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-start gap-2">
                            <div>
                                <span class="badge bg-primary-transparent text-primary update-system-version">Versión <?= $escape($update['version']) ?></span>
                                <h2 class="tx-20 mt-2 mb-1"><?= $escape($update['title']) ?></h2>
                                <span class="text-muted"><?= $escape(date('d/m/Y H:i', strtotime($update['date']))) ?></span>
                            </div>
                            <?php if ($isAdmin): ?>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-warning" type="button" data-bs-toggle="modal" data-bs-target="#updateSystemModal"
                                        data-update="<?= $escape(json_encode(['id' => $update['id'], 'title' => $update['title'], 'version' => $update['version'], 'date' => date('Y-m-d', strtotime($update['date']))])) ?>" onclick="openUpdateSystemModal(this)">Editar</button>
                                    <button class="btn btn-sm btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteUpdateModal"
                                        data-update-id="<?= (int) $update['id'] ?>" data-update-title="<?= $escape($update['title']) ?>" onclick="prepareDeleteUpdate(this)">Eliminar</button>
                                    <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#updateItemModal"
                                        data-update-id="<?= (int) $update['id'] ?>" onclick="openUpdateItemModal(this)">Agregar ítem</button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column gap-3">
                                <ul class="update-system-list p-3 bg-light rounded">
                                    <?php foreach ($items as $item): ?>
                                        <li class="mb-3">
                                            <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                                                <p class="mb-0 flex-grow-1"><?= $formatUpdateItem($item['item_name']) ?>
                                                    <?php if (!empty($item['item_image'])): ?>
                                                        <br>
                                                        <img class="update-system-image mt-2" style="border: groove" src="../../assets/update-system/<?= $escape(basename($item['item_image'])) ?>" alt="Imagen de actualización">
                                                    <?php endif; ?>
                                                </p>

                                                <?php if ($isAdmin): ?>
                                                    <div class="d-flex gap-2 flex-shrink-0">
                                                        <button class="btn btn-sm btn-outline-warning" type="button" data-bs-toggle="modal" data-bs-target="#updateItemModal"
                                                            data-item="<?= $escape(json_encode(['id' => $item['id'], 'update_id' => $update['id'], 'name' => $item['item_name'], 'image' => $item['item_image']])) ?>" onclick="openUpdateItemModal(this)">Editar</button>
                                                        <button class="btn btn-sm btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteItemModal"
                                                            data-item-id="<?= (int) $item['id'] ?>" data-item-name="<?= $escape($item['item_name']) ?>" onclick="prepareDeleteItem(this)">Eliminar</button>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                        </li>

                                    <?php endforeach; ?>
                                </ul>

                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <p class="text-muted">Mostrando <?= $firstUpdate ?>-<?= $lastUpdate ?> de <?= $totalUpdates ?> actualizaciones</p>
                    <?php if ($totalPages > 1): ?>
                        <nav aria-label="Paginación de actualizaciones">
                            <ul class="pagination mb-0">
                                <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="update-system.php?page=<?= max(1, $currentPage - 1) ?>">Anterior</a></li>
                                <?php for ($pageNumber = max(1, $currentPage - 2); $pageNumber <= min($totalPages, $currentPage + 2); $pageNumber++): ?>
                                    <li class="page-item <?= $pageNumber === $currentPage ? 'active' : '' ?>"><a class="page-link" href="update-system.php?page=<?= $pageNumber ?>"><?= $pageNumber ?></a></li>
                                <?php endfor; ?>
                                <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>"><a class="page-link" href="update-system.php?page=<?= min($totalPages, $currentPage + 1) ?>">Siguiente</a></li>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <?php if ($isAdmin): ?>
            <?php include __DIR__ . '/modals/modal-update-system.php'; ?>
            <?php include __DIR__ . '/modals/modal-update-item.php'; ?>
            <?php include __DIR__ . '/modals/modal-delete-update.php'; ?>
            <?php include __DIR__ . '/modals/modal-delete-item.php'; ?>
        <?php endif; ?>

        <?php include('../include/footer.php'); ?>
    </div>
    <script src="../../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../../assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/plugins/sidebar/sidebar.js"></script>
    <script src="../../assets/plugins/sidebar/sidebar-custom.js"></script>
    <script src="../../assets/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>
    <script src="../../assets/js/sticky.js"></script>
    <script src="../../assets/js/custom.js?v=<?= $escape(VERSION_CODE) ?>"></script>
    <script>
        const csrfToken = <?= json_encode($csrfToken) ?>;
        const currentPage = <?= (int) $currentPage ?>;
        const currentDate = <?= json_encode($todayDate) ?>;
        const currentVersion = <?= json_encode($defaultVersion) ?>;

        function openUpdateSystemModal(button = null) {
            const form = document.getElementById('updateSystemForm');
            form.reset();
            document.getElementById('updateSystemAction').value = 'create_update';
            document.getElementById('updateSystemId').value = '';
            document.getElementById('updateSystemModalTitle').textContent = 'Nueva actualización';
            document.getElementById('updateDateInput').value = currentDate;
            document.getElementById('updateVersionInput').value = currentVersion;
            if (button && button.dataset.update) {
                const update = JSON.parse(button.dataset.update);
                document.getElementById('updateSystemAction').value = 'edit_update';
                document.getElementById('updateSystemId').value = update.id;
                document.getElementById('updateSystemModalTitle').textContent = 'Editar actualización';
                document.getElementById('updateTitleInput').value = update.title;
                document.getElementById('updateDateInput').value = update.date;
                document.getElementById('updateVersionInput').value = update.version;
            }
        }

        function openUpdateItemModal(button) {
            const form = document.getElementById('updateItemForm');
            form.reset();
            document.getElementById('updateItemAction').value = 'create_item';
            document.getElementById('updateItemId').value = '';
            document.getElementById('updateItemModalTitle').textContent = 'Agregar ítem';
            document.getElementById('updateItemUpdateId').value = button.dataset.updateId || '';
            document.getElementById('currentItemImage').textContent = '';
            document.getElementById('removeItemImageContainer').classList.add('d-none');
            if (button.dataset.item) {
                const item = JSON.parse(button.dataset.item);
                document.getElementById('updateItemAction').value = 'edit_item';
                document.getElementById('updateItemId').value = item.id;
                document.getElementById('updateItemUpdateId').value = item.update_id;
                document.getElementById('updateItemModalTitle').textContent = 'Editar ítem';
                document.getElementById('updateItemName').value = item.name;
                document.getElementById('currentItemImage').textContent = item.image ? 'Imagen actual: ' + item.image : 'Sin imagen actual.';
                document.getElementById('removeItemImageContainer').classList.toggle('d-none', !item.image);
            }
        }

        function prepareDeleteUpdate(button) {
            document.getElementById('deleteUpdateId').value = button.dataset.updateId;
            document.getElementById('deleteUpdateTitle').textContent = button.dataset.updateTitle;
        }

        function prepareDeleteItem(button) {
            document.getElementById('deleteItemId').value = button.dataset.itemId;
            document.getElementById('deleteItemName').textContent = button.dataset.itemName;
        }
    </script>
    <?php include("../include/print_content.php"); ?>
</body>

</html>