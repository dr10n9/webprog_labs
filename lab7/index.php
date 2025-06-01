<?php
session_start();

// Ініціалізація гри
if (!isset($_SESSION['board'])) {
    $_SESSION['board'] = array_fill(0, 9, '');
    $_SESSION['turn'] = 'X';
    $_SESSION['winner'] = null;
}

// Обробка ходу
if (isset($_GET['move']) && $_SESSION['winner'] === null) {
    $move = (int) $_GET['move'];
    if ($_SESSION['board'][$move] === '') {
        $_SESSION['board'][$move] = $_SESSION['turn'];
        checkWinner();
        $_SESSION['turn'] = ($_SESSION['turn'] === 'X') ? 'O' : 'X';
    }
}

// Скидання гри
if (isset($_GET['reset'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Функція перевірки переможця
function checkWinner()
{
    $b = $_SESSION['board'];
    $lines = [
        [0,1,2], [3,4,5], [6,7,8], 
        [0,3,6], [1,4,7], [2,5,8], 
        [0,4,8], [2,4,6]           
    ];
    foreach ($lines as $line) {
        [$a, $b1, $c] = $line;
        if ($_SESSION['board'][$a] !== '' &&
            $_SESSION['board'][$a] === $_SESSION['board'][$b1] &&
            $_SESSION['board'][$a] === $_SESSION['board'][$c]) {
            $_SESSION['winner'] = $_SESSION['board'][$a];
            return;
        }
    }
    // Нічия
    if (!in_array('', $_SESSION['board'])) {
        $_SESSION['winner'] = 'Draw';
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Хрестики-Нолики</title>
    <style>
        body { font-family: sans-serif; text-align: center; }
        .board {
            display: grid;
            grid-template-columns: repeat(3, 100px);
            gap: 5px;
            margin: 20px auto;
            width: 310px;
        }
        .cell {
            width: 100px; height: 100px;
            font-size: 48px;
            display: flex; align-items: center; justify-content: center;
            background-color: #f0f0f0;
            cursor: pointer;
            border: 1px solid #aaa;
        }
        .cell:hover { background-color: #e0e0e0; }
        .disabled { pointer-events: none; background-color: #ddd; }
    </style>
</head>
<body>
    <h1>Хрестики-Нолики</h1>
    <div class="board">
        <?php foreach ($_SESSION['board'] as $i => $value): ?>
            <div class="cell <?= $value || $_SESSION['winner'] ? 'disabled' : '' ?>">
                <?php if (!$value && $_SESSION['winner'] === null): ?>
                    <a href="?move=<?= $i ?>" style="display:block;width:100%;height:100%;text-decoration:none;color:black;">
                        &nbsp;
                    </a>
                <?php else: ?>
                    <?= htmlspecialchars($value) ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($_SESSION['winner']): ?>
        <h2>
            <?= $_SESSION['winner'] === 'Draw' ? 'Нічия!' : "Переміг: " . $_SESSION['winner'] ?>
        </h2>
        <a href="?reset=1">Почати спочатку</a>
    <?php else: ?>
        <h2>Хід: <?= $_SESSION['turn'] ?></h2>
        <a href="?reset=1">Скинути гру</a>
    <?php endif; ?>
</body>
</html>