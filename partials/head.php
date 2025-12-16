<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=  isset($title) && !empty($title) ? htmlspecialchars($title) : 'Cinéma' ?>Popcorn-Sama</title>

    <!-- Seo -->
     <meta name="robots" content="index,follow">
     <meta name="description" content="<?=  isset($description) && !empty($description) ? htmlspecialchars($description) : 'Cinéma' ?>">
     <meta name="author" content="PopCorn-Sama">
     <meta name="publisher" content="Dwwm22">
     <meta name="keywords" content="<?=  isset($keywords) && !empty($keywords) ? htmlspecialchars($keywords) : 'Cinéma' ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Font Awesome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&family=SUSE+Mono:ital,wght@0,100..800;1,100..800&family=Sekuya&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- My Custom StyleSheet -->
     <link rel="stylesheet" href="assets/styles/app.css">
</head>
<body class="bg-light">