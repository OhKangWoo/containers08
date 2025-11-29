<?php

require_once __DIR__ . '/testframework.php';

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../modules/database.php';
require_once __DIR__ . '/../modules/page.php';

$tests = new TestFramework();

// test 1: check database connection
$tests->add('Database connection', function () use ($config) {
    try {
        $db = new Database($config['db']['path']);
        return assertExpression(true, 'Connected to DB');
    } catch (Exception $e) {
        return assertExpression(false, '', 'Failed to connect to DB');
    }
});

// test 2: count records
$tests->add('Table count', function () use ($config) {
    $db = new Database($config['db']['path']);
    $count = $db->Count('page');
    return assertExpression($count >= 3, 'Found records', 'No records found');
});

// test 3: create record
$tests->add('Create record', function () use ($config) {
    $db = new Database($config['db']['path']);
    $id = $db->Create('page', ['title' => 'Test', 'content' => 'Test content']);
    return assertExpression($id > 0, 'Insert ok', 'Insert failed');
});

// test 4: read record
$tests->add('Read record', function () use ($config) {
    $db = new Database($config['db']['path']);
    $data = $db->Read('page', 1);
    return assertExpression($data && isset($data['title']), 'Read ok', 'Read failed');
});

// test 5: update record
$tests->add('Update record', function () use ($config) {
    $db = new Database($config['db']['path']);
    $success = $db->Update('page', 1, ['title' => 'Updated']);
    return assertExpression($success, 'Update ok', 'Update failed');
});

// test 6: delete record
$tests->add('Delete record', function () use ($config) {
    $db = new Database($config['db']['path']);
    $id = $db->Create('page', ['title' => 'To delete', 'content' => '...']);
    $success = $db->Delete('page', $id);
    return assertExpression($success, 'Delete ok', 'Delete failed');
});

// test 7: page render
$tests->add('Render page', function () {
    $page = new Page(__DIR__ . '/../site/templates/index.tpl');
    $html = $page->Render(['title' => 'Test Title', 'content' => 'Test Content']);
    return assertExpression(strpos($html, 'Test Title') !== false, 'Render ok', 'Render failed');
});

// run and report
$tests->run();
echo $tests->getResult();
