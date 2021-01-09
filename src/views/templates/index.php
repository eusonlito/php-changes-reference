<nav id="head-nav" class="navbar">
    <h1>PHP Changes Cheatsheet</h1>
</nav>

<main class="index-main">
    <ul>
        <?php foreach ($groups as $group) { ?>
        <li>
            <a href="<?= $group['link']; ?>">
                <?= $group['title']; ?>
                <div class="versions"><span><?= implode('</span><span>', $group['versions']); ?></span></div>
            </a>
        </li>
        <?php } ?>

        <li><a href="all.html">All</a></li>
        <li><a href="https://www.php.net/manual/en/appendices.php" target="_blank">Appendices at php.net</a></li>
        <li><a href="https://php-legacy-docs.zend.com/manual/php5/en/appendices" target="_blank">Appendices at php-legacy-docs.zend.com</a></li>
        <li><a href="https://github.com/eusonlito/php-changes-cheatsheet" target="_blank">About this project in Github</a></li>
    </ul>
</main>