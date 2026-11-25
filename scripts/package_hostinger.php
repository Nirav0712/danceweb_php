<?php
/**
 * Hostinger Deployment Packaging Script
 * Prepares a clean, production-ready ZIP archive of the PHP application.
 * Excludes: .git, tests, .env, backups, dev temp files.
 */

$sourceDir = realpath(__DIR__ . '/..');
$distDir = dirname($sourceDir) . '/dist-hostinger';
$zipFile = $distDir . '/dynamice_php_hostinger_deploy.zip';

if (!is_dir($distDir)) {
    mkdir($distDir, 0755, true);
}

if (file_exists($zipFile)) {
    unlink($zipFile);
}

$zip = new ZipArchive();
if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    die("Cannot create zip archive at: $zipFile\n");
}

$excludePatterns = [
    '/\.git/',
    '/tests/',
    '/\.env$/', // do not bundle active development .env with local secrets
    '/check_tables\.php/',
    '/check_columns\.php/',
    '/tests/',
];

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

$count = 0;
foreach ($files as $file) {
    $filePath = $file->getRealPath();
    $relative = substr($filePath, strlen($sourceDir) + 1);
    $relativeSlash = str_replace('\\', '/', $relative);

    $skip = false;
    foreach ($excludePatterns as $pattern) {
        if (preg_match($pattern, $relativeSlash)) {
            $skip = true;
            break;
        }
    }

    if ($skip) {
        continue;
    }

    if ($file->isDir()) {
        $zip->addEmptyDir($relativeSlash);
    } elseif ($file->isFile()) {
        $zip->addFile($filePath, $relativeSlash);
        $count++;
    }
}

$zip->close();

echo "Deployment package created successfully!\n";
echo "Location: $zipFile\n";
echo "Total Files Packaged: $count\n";
echo "File Size: " . round(filesize($zipFile) / (1024 * 1024), 2) . " MB\n";
