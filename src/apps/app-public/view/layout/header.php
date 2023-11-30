<head>
  <meta charset="UTF-8"/>
  <meta http-equiv="Content-Security-Policy" content="default-src 'self' 'unsafe-inline' 'unsafe-eval' data: gap: https://ssl.gstatic.com https://*.bootstrap.com https://*.jsdelivr.net https://*.fontawesome.com https://fonts.googleapis.com https://fonts.gstatic.com https://code.jquery.com https://www.googletagmanager.com https://www.google-analytics.com/ https://buttons.github.io/; img-src 'self' data: content:; font-src 'self' fonts.gstatic.com data: https://*.fontawesome.com; style-src 'self' 'unsafe-inline' fonts.googleapis.com https://*.fontawesome.com; media-src *; ">
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?= (isset($_ENV['G_ANALYTIC'])) ? $_ENV['G_ANALYTIC'] : '' ?>"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', '<?= (isset($_ENV['G_ANALYTIC'])) ? $_ENV['G_ANALYTIC'] : '' ?>');
  </script>
  
  <?php $head_title = (isset($project_apps[$_SESSION['active_app']]['slog']) && !empty($project_apps[$_SESSION['active_app']]['slog'])) ? $project_apps[$_SESSION['active_app']]['slog'] : $_ENV['PROJECT_SLOG']; ?>
  <title><?= ($page == 'article' && isset($req_res)) ? $req_res['article_title'] : ucfirst($page) . ' | ' . PROJECT_TITLE . ' - ' . $head_title ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <meta name="description" content="<?= PROJECT_TITLE . ' | ' . $_ENV['PROJECT_DSCPT_SHORT'] ?>">
  <meta name="keywords" content="<?= $_ENV['PROJECT_DSCPT'] ?>">
  <meta name="note" content="">
  <meta name="subject" content="">
  <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
  <link rel="shortcut icon" href="<?= PROJECT_LOGO_WHITE_SMALL ?>">
  <link rel="canonical" href="<?= host_url($_SERVER['REQUEST_URI']) ?>">

  <meta name="Classification" content="Business, Economy, Blog, Policy">
  <meta name="identifier-URL" content="<?= host_url($_SERVER['REQUEST_URI']) ?>">
  <meta name="reply-to" content="info@<?= $_ENV["PROJECT_HOST"] ?>">
  <meta name="author" content="<?= AUTHOR ?>, info@tralon.co.za">
  <meta name="copyright" content="Tralon Digital Agency (TDA)">

  <meta name="coverage" content="Worldwide">
  <meta name="distribution" content="Global">
  <meta name="revisit-after" content="1 days">

  <meta name="presdate" content="<?= (isset($artcl_date) && !empty($artcl_date) && (is_array($artcl_date) || is_object($artcl_date))) ? $artcl_date->format('c') : '' ?>">
  <meta name="creation_date" content="<?= (isset($artcl_date) && !empty($artcl_date)) ? $artcl_date->format('c') : '' ?>">
  <meta name="host" content="<?= host_url($_SERVER['REQUEST_URI']) ?>">
  <meta name="linkage" CONTENT="http://tda.tralon.co.za/">

  <meta name="twitter:title" content="<?= ($page == 'article' && isset($req_res)) ? $req_res['article_title'] : strtoupper($page) . ' | ' . PROJECT_TITLE ?>">
  <meta name="twitter:description" content="<?= ($page == 'article' && isset($req_res)) ? $req_res['article_title'] : PROJECT_TITLE . ' | ' . $_ENV['PROJECT_DSCPT_SHORT'] ?>">
  <meta name="twitter:site" content="<?= (isset($social_media['twitter']['user'])) ? $social_media['twitter']['user'] : '' ?>">
  <meta name="twitter:creator" content="<?= (isset($social_media['twitter']['user'])) ? $social_media['twitter']['user'] : '' ?>">
  <meta name="twitter:domain" content="<?= host_url($_SERVER['REQUEST_URI']) ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:image" content="<?= ($page == 'article' && isset($req_res)) ? host_url(DS . article_img($req_res['article_type'], $req_res['article_image'])) : PROJECT_LOGO_WHITE_SMALL ?>">
  <meta name="twitter:image:alt" content="<?= ($page == 'article' && isset($req_res)) ? $req_res['article_title'] : '' ?>">

  <meta property="og:locale" content="{'locale':'en_us'}" />
  <meta property="og:type" content="<?= ($page == 'article' || $page == 'articles') ? 'article' : 'website' ?>">
  <meta property="og:title" content="<?= ($page == 'article' && isset($req_res)) ? $req_res['article_title'] : strtoupper($page) . ' | ' . PROJECT_TITLE ?>">
  <meta property="og:description" content="<?= PROJECT_TITLE . ' | ' . $_ENV['PROJECT_DSCPT_SHORT'] ?>">
  <meta property="og:image" content="<?= ($page == 'article' && isset($req_res)) ? host_url(DS . article_img($req_res['article_type'], $req_res['article_image'])) : PROJECT_LOGO_WHITE_SMALL ?>">
  <meta property="og:image:alt" content="<?= ($page == 'article' && isset($req_res)) ? $req_res['article_title'] : strtoupper($page) . ' | ' . PROJECT_TITLE ?>" />
  <meta property="og:url" content="<?= host_url($_SERVER['REQUEST_URI']) ?>">
  <meta property="og:site_name" content="<?= PROJECT_TITLE ?>">
  <meta property="og:article:author" content="<?= $_ENV["PROJECT_TITLE"] ?><?= (isset($req_res['article_author']) && $req_res['article_author'] != '') ? ', ' . $req_res['article_author'] : '' ?>">
  <meta property="og:article:publisher" content="<?= $_ENV["PROJECT_TITLE"] ?>" />

  <meta property="fb:app_id" content="1494794767360399" />
  <meta property="fb:admins" content="100054987624650, 100000243640137" />
  <?php if ($page == 'article') : ?>
    <meta property="article:author" content="<?= $_ENV["PROJECT_TITLE"] ?><?= (isset($req_res['article_author']) && $req_res['article_author'] != '') ? ', ' . $req_res['article_author'] : '' ?>">
    <meta property="article:publisher" content="<?= $_ENV["PROJECT_TITLE"] ?>" />
    <meta property="article:published_time" content="<?= (isset($artcl_date) && !empty($artcl_date)) ? $artcl_date->format('c') : '' ?>" />
    <meta property="article:modified_time" content="<?= (isset($artcl_dateud) && !empty($artcl_dateud)) ? $artcl_dateud->format('c') : '' ?>" />
    <meta property="article:section" content="<?= (isset($req_res['article_type'])) ? $req_res['article_type'] : '' ?>" />
    <meta property="article:tag" content="Article Tag" />
  <?php endif; ?>


  <?php if (!isset($_SESSION['reload'])) : ?>
    <?php $_SESSION['reload'] = true ?>
    <script>
      window.location.reload(true);
    </script>
  <?php endif; ?>

  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="./css/nucleo-icons.css" rel="stylesheet" />
  <link href="./css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/cd0ac0cda1.js" crossorigin="anonymous"></script>
  <link href="./css/nucleo-svg.css" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="./css/dashboard.css?v=1.0.3" rel="stylesheet">

  <!-- lib -->
  <link rel="stylesheet" href="./css/spinner.min.css">
  <!-- <link rel="stylesheet" href="./css/spinner.css.map"> -->

  <!-- animate -->
  <link rel="stylesheet" href="./css/animate.min.css">

  <?php if ($_ENV['PROJECT_STATE'] == 'development') : ?>
    <link rel="stylesheet" href="./css/master.css">

    <!-- custom css -->
    <?php $css_page_file = DIST_CSS_CUSTOM . $page . '.css' ?>
    <?php if (file_exists($css_page_file)) : ?>
      <link rel="stylesheet" href="<?= $css_page_file ?>">
    <?php endif; ?>
  <?php else : ?>
    <!-- Custom css files -->
    <link rel="stylesheet" href="./css/master.min.css<?= $script_vsn ?>"

    <!-- custom css -->
    <?php $css_page_file = DIST_CSS_CUSTOM . $page . '.min.css' . $script_vsn ?>
    <?php if (file_exists($css_page_file)) : ?>
      <link rel="stylesheet" href="<?= $css_page_file ?>">
    <?php endif; ?>
  <?php endif; ?>

</head>