<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class DatabaseTest extends TestCase
{
    public function testDatabaseConnection(): void
    {
        require __DIR__ . '/../site/config.php';
        require_once __DIR__ . '/../site/modules/database.php';

        $db = new Database($config['db']['path']);
        $this->assertTrue(true, 'Connected to DB');
    }

    public function testTableCount(): void
    {
        require __DIR__ . '/../site/config.php';
        $db = new Database($config['db']['path']);
        $count = $db->Count('page');

        $this->assertGreaterThanOrEqual(3, $count, 'Record count OK');
    }
}
