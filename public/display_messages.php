<?php
require_once 'config.php';
require_once 'functions.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $allowed_sorts = [
        'username'   => 'username',
        'email'      => 'email',
        'created_at' => 'created_at'
    ];
    $allowed_orders = ['ASC', 'DESC'];

    $sort_param = $_GET['sort'] ?? 'created_at';
    $order_param = strtoupper($_GET['order'] ?? 'DESC');

    $sort = $allowed_sorts[$sort_param] ?? 'created_at';
    $order = in_array($order_param, $allowed_orders) ? $order_param : 'DESC';

    $page = max(1, intval($_GET['page'] ?? 1));
    $per_page = 25;
    $offset = ($page - 1) * $per_page;

    $total_stmt = $pdo->query("SELECT COUNT(*) FROM messages");
    $total_messages = $total_stmt->fetchColumn();
    $total_pages = ceil($total_messages / $per_page);

    $sql = "SELECT * FROM messages ORDER BY $sort $order LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($messages)) {
        echo "<p>No messages</p>";
    } else {
        echo '<table class="messages-table">
                <thead>
                    <tr>
                        <th>' . sort_link('username', 'Name', $sort, $order) . '</th>
                        <th>' . sort_link('email', 'Email', $sort, $order) . '</th>
                        <th>Homepage</th>
                        <th>Message</th>
                        <th>' . sort_link('created_at', 'Date', $sort, $order) . '</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($messages as $message) {
            echo '<tr>
                    <td>' . htmlspecialchars($message['username']) . '</td>
                    <td>' . htmlspecialchars($message['email']) . '</td>
                    <td>' . ($message['homepage'] ? '<a href="' . htmlspecialchars($message['homepage']) . '" target="_blank">link</a>' : '') . '</td>
                    <td>' . nl2br(htmlspecialchars($message['text'])) . '</td>
                    <td>' . htmlspecialchars($message['created_at']) . '</td>
                </tr>';
        }
        echo '</tbody></table>';

        if ($total_pages > 1) {
            echo '<div class="pagination">';
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo "<span class='current'>$i</span>";
                } else {
                    echo "<a href='?page=$i&sort=$sort_param&order=$order'>$i</a>";
                }
            }
            echo '</div>';
        }
    }

} catch (PDOException $e) {
    die("Ошибка при получении сообщений: " . $e->getMessage());
}
?>
