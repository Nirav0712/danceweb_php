<?php
require_once __DIR__ . '/../../app/Core/Env.php';
require_once __DIR__ . '/../../app/Core/Config.php';
require_once __DIR__ . '/../../app/Core/Database.php';

\App\Core\Env::load(__DIR__ . '/../../.env');
\App\Core\Config::load(__DIR__ . '/../../config');

$pdo = \App\Core\Database::getConnection();

// 1. Create hero_slides table if it doesn't exist
$pdo->exec("CREATE TABLE IF NOT EXISTS hero_slides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NULL,
    image_url VARCHAR(500) NOT NULL,
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME(3) DEFAULT CURRENT_TIMESTAMP(3),
    updated_at DATETIME(3) DEFAULT CURRENT_TIMESTAMP(3) ON UPDATE CURRENT_TIMESTAMP(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

// Check existing count
$count = (int)$pdo->query("SELECT COUNT(*) FROM hero_slides")->fetchColumn();
if ($count === 0) {
    $initialSlides = [
        ['title' => 'Academy World Record Showcase', 'image_url' => '/assets/banners/homebanner.jpg', 'sort_order' => 1],
        ['title' => 'Cultural Dance Troupe Performance', 'image_url' => '/assets/about/academy_group.jpg', 'sort_order' => 2],
        ['title' => 'Heritage Stage Grand Production', 'image_url' => '/assets/about/founded-2002-stage.jpg', 'sort_order' => 3],
        ['title' => 'Artistic Excellence & Rhythmic Mastery', 'image_url' => '/assets/about/dance-teaching-steps.jpg', 'sort_order' => 4],
        ['title' => 'Traditional Garba & Raas Heritage', 'image_url' => '/assets/gallery/1.jpg', 'sort_order' => 5],
    ];
    $stmt = $pdo->prepare("INSERT INTO hero_slides (title, image_url, sort_order, is_active, created_at, updated_at) VALUES (:title, :image_url, :sort_order, 1, NOW(), NOW())");
    foreach ($initialSlides as $s) {
        $stmt->execute($s);
    }
    echo "Inserted initial hero slides.\n";
} else {
    echo "hero_slides already has {$count} entries.\n";
}

// 2. Ensure hero section exists in sections table with default heading
$heroSec = $pdo->query("SELECT id, heading, subheading FROM sections WHERE section_key = 'hero' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
if (!$heroSec) {
    $pdo->exec("INSERT INTO sections (page_id, section_key, heading, subheading, content, sort_order, is_visible, created_at, updated_at)
                VALUES (1, 'hero', 'Culture Is a Way of Life', '', '', 1, 1, NOW(), NOW())");
    echo "Created hero section in sections table.\n";
} else {
    $pdo->exec("UPDATE sections SET heading = 'Culture Is a Way of Life' WHERE section_key = 'hero'");
    echo "Updated hero section in sections table to 'Culture Is a Way of Life'.\n";
}
