<?php

$article_type       = (isset($key_article))? $key_article : $key;

$page_nmb           = (int) (isset($_GET['page']) && $_GET['page'] != '' && isset($_GET['tab']) && $_GET['tab'] == $article_type) ? $_GET['page'] : 1;

if (HOST_IS_LIVE) {
    $cnt_sql        = "SELECT * FROM articles WHERE article_status = 1 AND article_type = ?";
    $cnt_dta        = [$article_type];
    $artcl_count    = (int) prep_exec($cnt_sql, $cnt_dta, $sql_request_data[3]);
}

$page_count         = ceil(($artcl_count / $intval));
$sql_pg_strt        = (int)($page_nmb - 1) * $intval;

if (HOST_IS_LIVE) {
    $rgst_sql       = "SELECT article_id, article_title, article_type, article_link, article_publisher, article_publish_date, article_content, article_source, article_image, article_author, article_status, article_date_created, user_id FROM articles WHERE article_type = ? AND article_status = 1 ORDER BY article_publish_date DESC LIMIT $sql_pg_strt, $intval";
    $rgst_dta       = [$article_type];
    $nwsf_qry       = prep_exec($rgst_sql, $rgst_dta, $sql_request_data[1]);
}

$artcle_cnt         = 0;

if (is_array($nwsf_qry) || is_object($nwsf_qry)) :
    foreach ($nwsf_qry as $key => $value) :
        $artcle_cnt++;
        $artcl_date  = DateTime::createFromFormat('Y-m-d H:i:s', $value['article_publish_date']);
        $cnt_res     = get_article_visits_count($value['article_id']);

        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            $article_link   = 'blog-article?article_id=' . (int) $value['article_id'] . '&type=' . $value['article_type'];
        } else {
            $article_link   = 'article?article=' . $slugify->slugify($value['article_title']) . '&slgid=' . $value['article_id'] . '&type=' . $value['article_type'];
        }

        require $config['PARSERS_PATH'] . 'articles' . DS . 'article.php';
    endforeach;
endif;