<?php
function validateUsername($username) {
    if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        die('The user name must contain only Latin letters and numbers.');
    }
    return htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
}

function validateEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Incorrect email');
    }
    return htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
}

function validateUrl($url) {
    if (!empty($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
        die('Incorrect URL');
    }
    return htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
}

function validateText($text) {
    $text = strip_tags($text); // Удаляем HTML теги
    if (empty($text)) {
        die('Message text cannot be empty');
    }
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function sort_link($column, $label, $currentSort, $currentOrder) {
    $isCurrent = $column === $currentSort;
    $nextOrder = $isCurrent && $currentOrder === 'ASC' ? 'DESC' : 'ASC';
    $arrow = $isCurrent ? ($currentOrder === 'ASC' ? ' ▲' : ' ▼') : '';
    return '<a href="?sort='.$column.'&order='.$nextOrder.'">'.$label.$arrow.'</a>';
}
?>

