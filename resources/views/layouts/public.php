<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($metaTitle ?? ($title ?? 'Dynamice Children Academy — Dance Institute'), ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDescription ?? 'Dynamice Children Academy is a premier cultural dance institution in Ahmedabad, Gujarat, specializing in folk, classical, and contemporary arts.', ENT_QUOTES, 'UTF-8') ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl ?? ($_SERVER['REQUEST_URI'] ?? '/'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- OpenGraph Metadata -->
    <meta property="og:title" content="<?= htmlspecialchars($metaTitle ?? ($title ?? 'Dynamice Children Academy'), ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($metaDescription ?? 'Pioneering traditional dance arts in Gujarat since 1998.', ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="/assets/banners/home_hero.jpg">

    <!-- CSS & Typography -->
    <link rel="stylesheet" href="/assets/index-TmExv8Sz.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif { font-family: 'Playfair Display', Georgia, serif; }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased flex flex-col min-h-screen">

    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main class="flex-1">
        <?= $content ?? '' ?>
    </main>

    <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>
