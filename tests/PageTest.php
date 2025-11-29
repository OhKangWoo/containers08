<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class PageTest extends TestCase
{
    public function testRenderPage(): void
    {
        require_once __DIR__ . '/../site/modules/page.php';

        $page = new Page(__DIR__ . '/../site/templates/index.tpl');
        $html = $page->Render(['title' => 'Test Title', 'content' => 'Test Content']);

        $this->assertStringContainsString('Test Title', $html);
    }
}
