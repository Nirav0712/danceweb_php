<?php
// Initialize SEO metadata from SeoService if not already provided
if (!isset($seo) || !is_array($seo)) {
    $seo = \App\Services\SeoService::resolve($_SERVER['REQUEST_URI'] ?? '/', [
        'title' => $title ?? null,
        'metaTitle' => $metaTitle ?? null,
        'metaDescription' => $metaDescription ?? null,
        'canonicalUrl' => $canonicalUrl ?? null,
        'ogImage' => $ogImage ?? null,
    ]);
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($seo['title'] ?? 'Dynamice Children Academy — Dance Institute', ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="<?= htmlspecialchars($seo['metaDescription'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    <meta name="robots" content="<?= htmlspecialchars($seo['metaRobots'] ?? 'index, follow', ENT_QUOTES, 'UTF-8') ?>">
    <?php if (!empty($seo['googleSiteVerification'])): ?>
    <meta name="google-site-verification" content="<?= htmlspecialchars($seo['googleSiteVerification'], ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>
    <link rel="canonical" href="<?= htmlspecialchars($seo['canonicalUrl'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- OpenGraph Metadata -->
    <meta property="og:title" content="<?= htmlspecialchars($seo['ogTitle'] ?? $seo['metaTitle'], ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($seo['ogDescription'] ?? $seo['metaDescription'], ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:type" content="<?= htmlspecialchars($seo['ogType'] ?? 'website', ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:url" content="<?= htmlspecialchars($seo['canonicalUrl'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($seo['siteName'] ?? 'Dynamice Children Academy', ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image" content="<?= htmlspecialchars($seo['ogImage'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <!-- Twitter Card Metadata -->
    <meta name="twitter:card" content="<?= htmlspecialchars($seo['twitterCard'] ?? 'summary_large_image', ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:title" content="<?= htmlspecialchars($seo['ogTitle'] ?? $seo['metaTitle'], ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($seo['ogDescription'] ?? $seo['metaDescription'], ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($seo['ogImage'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <!-- Structured Data (JSON-LD) -->
    <?= $seo['jsonLdHtml'] ?? '' ?>

    <!-- CSS & Typography -->
    <link rel="stylesheet" href="/assets/index-TmExv8Sz.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif { font-family: 'Playfair Display', Georgia, serif; }
    </style>
    <?php if (!empty($seo['googleAnalyticsId'])): ?>
    <!-- Google Analytics (GA4) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= htmlspecialchars($seo['googleAnalyticsId'], ENT_QUOTES, 'UTF-8') ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?= htmlspecialchars($seo['googleAnalyticsId'], ENT_QUOTES, 'UTF-8') ?>');
    </script>
    <?php endif; ?>
</head>
<body class="bg-white text-slate-800 antialiased flex flex-col min-h-screen">

    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main class="flex-1">
        <?= $content ?? '' ?>
    </main>

    <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>
