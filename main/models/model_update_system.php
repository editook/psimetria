<?php
class ModelUpdateSystem
{
    public function getUpdates(int $limit, int $offset): array
    {
        $con = new Connection();
        $limit = max(1, $limit);
        $offset = max(0, $offset);
        $query = "SELECT * FROM update_system ORDER BY `date` DESC, id DESC LIMIT $limit OFFSET $offset";
        return mysqli_fetch_all($con->execute_query($query), MYSQLI_ASSOC);
    }

    public function countUpdates(): int
    {
        $con = new Connection();
        $result = $con->execute_query("SELECT COUNT(*) AS total FROM update_system");
        $row = mysqli_fetch_assoc($result);
        return (int) ($row['total'] ?? 0);
    }

    public function getUpdate(int $id): ?array
    {
        $con = new Connection();
        $result = $con->execute_query("SELECT * FROM update_system WHERE id = " . (int) $id . " LIMIT 1");
        return mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result) : null;
    }

    public function getItems(int $updateId): array
    {
        $con = new Connection();
        $result = $con->execute_query("SELECT * FROM item_update_system WHERE id_update_system = " . (int) $updateId . " ORDER BY id ASC");
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getItem(int $id): ?array
    {
        $con = new Connection();
        $result = $con->execute_query("SELECT * FROM item_update_system WHERE id = " . (int) $id . " LIMIT 1");
        return mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result) : null;
    }

    public function createUpdate(string $date, string $title, string $version)
    {
        $con = new Connection();
        $date = $con->getRealEscapeString($date);
        $title = $con->getRealEscapeString($title);
        $version = $con->getRealEscapeString($version);
        $query = "INSERT INTO update_system (`date`, title, version) VALUES ('$date', '$title', '$version')";
        if (!$con->execute_query($query)) {
            return false;
        }
        return $con->getLastInsertedID();
    }

    public function updateUpdate(int $id, string $date, string $title, string $version): bool
    {
        $con = new Connection();
        $date = $con->getRealEscapeString($date);
        $title = $con->getRealEscapeString($title);
        $version = $con->getRealEscapeString($version);
        $query = "UPDATE update_system SET `date` = '$date', title = '$title', version = '$version' WHERE id = " . (int) $id;
        return (bool) $con->execute_query($query);
    }

    public function deleteUpdate(int $id): bool
    {
        $con = new Connection();
        $id = (int) $id;
        if (!$con->execute_query("DELETE FROM item_update_system WHERE id_update_system = $id")) {
            return false;
        }
        return (bool) $con->execute_query("DELETE FROM update_system WHERE id = $id");
    }

    public function createItem(int $updateId, string $name, ?string $image)
    {
        $con = new Connection();
        $name = $con->getRealEscapeString($name);
        $imageSql = $image === null ? 'NULL' : "'" . $con->getRealEscapeString($image) . "'";
        $query = "INSERT INTO item_update_system (item_name, item_image, id_update_system) VALUES ('$name', $imageSql, " . (int) $updateId . ")";
        if (!$con->execute_query($query)) {
            return false;
        }
        return $con->getLastInsertedID();
    }

    public function updateItem(int $id, string $name, ?string $image): bool
    {
        $con = new Connection();
        $name = $con->getRealEscapeString($name);
        $imageSql = $image === null ? 'NULL' : "'" . $con->getRealEscapeString($image) . "'";
        $query = "UPDATE item_update_system SET item_name = '$name', item_image = $imageSql WHERE id = " . (int) $id;
        return (bool) $con->execute_query($query);
    }

    public function deleteItem(int $id): bool
    {
        $con = new Connection();
        return (bool) $con->execute_query("DELETE FROM item_update_system WHERE id = " . (int) $id);
    }

    public function markAllUnviewed(int $updateId): bool
    {
        $con = new Connection();
        return (bool) $con->execute_query(
            "UPDATE users SET id_update_system = " . (int) $updateId . ", is_view = 0"
        );
    }

    public function markViewed(int $userId): bool
    {
        $con = new Connection();
        $latestId = $this->getLatestUpdateId();
        return (bool) $con->execute_query(
            "UPDATE users SET id_update_system = $latestId, is_view = 1 WHERE id = " . (int) $userId
        );
    }

    public function hasUnviewedUpdates(int $userId): bool
    {
        try {
            $con = new Connection();
            $result = $con->execute_query(
                "SELECT (users.is_view = 0 AND EXISTS (SELECT 1 FROM update_system LIMIT 1)) AS has_unviewed
                 FROM users WHERE users.id = " . (int) $userId . " LIMIT 1"
            );
            if (!$result || mysqli_num_rows($result) === 0) {
                return false;
            }
            $row = mysqli_fetch_assoc($result);
            return (int) $row['has_unviewed'] === 1;
        } catch (Throwable $error) {
            return false;
        }
    }

    private function getLatestUpdateId(): int
    {
        $con = new Connection();
        $result = $con->execute_query("SELECT COALESCE(MAX(id), 0) AS id FROM update_system");
        $row = mysqli_fetch_assoc($result);
        return (int) ($row['id'] ?? 0);
    }
}
