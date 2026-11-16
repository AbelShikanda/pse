<?php

/**
 * Compare row counts between the source MySQL (printshop) and the target
 * PostgreSQL database, table by table.
 *
 * Usage:
 *   MYSQL_PASSWORD='...' PG_PASSWORD='...' php scripts/verify_counts.php
 * Optional env:
 *   MYSQL_HOST (127.0.0.1) MYSQL_PORT (3306) MYSQL_DATABASE (printshop) MYSQL_USER (root)
 *   PG_HOST    (127.0.0.1) PG_PORT    (5432) PG_DATABASE    (printshop) PG_USER    (printshop)
 */

$mysqlHost = getenv('MYSQL_HOST') ?: '127.0.0.1';
$mysqlPort = getenv('MYSQL_PORT') ?: '3306';
$mysqlDb   = getenv('MYSQL_DATABASE') ?: 'printshop';
$mysqlUser = getenv('MYSQL_USER') ?: 'root';
$mysqlPass = getenv('MYSQL_PASSWORD');

$pgHost = getenv('PG_HOST') ?: '127.0.0.1';
$pgPort = getenv('PG_PORT') ?: '5432';
$pgDb   = getenv('PG_DATABASE') ?: 'printshop';
$pgUser = getenv('PG_USER') ?: 'printshop';
$pgPass = getenv('PG_PASSWORD');

if (!$mysqlPass || !$pgPass) {
    fwrite(STDERR, "Set MYSQL_PASSWORD and PG_PASSWORD in the environment.\n");
    exit(1);
}

$mysql = new PDO("mysql:host=$mysqlHost;port=$mysqlPort;dbname=$mysqlDb;charset=utf8mb4", $mysqlUser, $mysqlPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$pg = new PDO("pgsql:host=$pgHost;port=$pgPort;dbname=$pgDb", $pgUser, $pgPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$tables = $mysql->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
sort($tables);

$fail = 0;
printf("%-45s %12s %12s %s\n", 'table', 'mysql', 'postgres', 'status');
echo str_repeat('-', 85), "\n";
foreach ($tables as $table) {
    $mysqlCount = (int) $mysql->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();

    try {
        $pgCount = (int) $pg->query('SELECT COUNT(*) FROM "' . $table . '"')->fetchColumn();
    } catch (Throwable $e) {
        printf("%-45s %12d %12s %s\n", $table, $mysqlCount, 'MISSING', 'FAIL');
        $fail++;
        continue;
    }

    $ok = $mysqlCount === $pgCount;
    if (!$ok) {
        $fail++;
    }
    printf("%-45s %12d %12d %s\n", $table, $mysqlCount, $pgCount, $ok ? 'ok' : 'FAIL');
}

echo str_repeat('-', 85), "\n";
echo $fail === 0 ? "All tables match.\n" : "$fail table(s) differ.\n";
exit($fail === 0 ? 0 : 1);
