<?php
// sql execution statement types
$app_links          = array('','home', 'users', 'blog', 'featured', 'blog-article', 'media', 'contact', 'logout', 'academics', 'about', 'search', 'test', 'confirmation', 'confirm', 'subscriptions','login', 'categories', 'tasks', 'settings');
$admin_links        = array('admin', 'settings', 'users');
$sql_request_data   = array('fetchcolumn', 'fetchall', 'execute', 'countrows');
$page_excludes      = array('login', 'logout', 'passreset', 'terms', 'policy', 'confirm', 'resetpass');
$project_status     = array('production' => true, 'development' => true, 'staging' => true);
$question_types     = array('radio', 'text', 'full_text');
$image_modify_paths = array('', 'square', 'rect');
$media_types        = array('video');
$article_types      = array('articles', 'blog');
$article_array_new  = array('articles' => 'Articles & Columns');
$media_array        = array('appearance' => 'Media Appearances', 'gallery' => 'Gallery', 'file' => 'Files');
$article_array      = array('civil_matters' => 'Civil Matters', 'labour_matters' => 'Labour Matters', 'criminal_matters' => "Criminal Matters", 'estate_planning' => 'Estate Planning', 'wills_trust' => 'Wills and Trusts');
$priority_level     = array(
  "low" => array(
    "name" => "Low",
    "class" => "info",
  ),
  "medium" => array(
    "name" => "Medium",
    "class" => "warning",
  ),
  "high" => array(
    "name" => "High",
    "class" => "danger",
  ),
);

$admin_emails = array(
  'admin' => array(
    'name'  => $_ENV['MAIL_USER'],
    'mail'  => $_ENV['MAIL_MAIL'],
  ),
  // 'snattorneys' => array(
  //   'name'  => PROJECT_TITLE,
  //   'mail'  => 'info@'.$_ENV['PROJECT_HOST'],
  // ),
  'will' => array(
    'name'  => 'Willington Mhlanga',
    'mail'  => 'willington.mhlanga@gmail.com',
  ),
);

$system_pages = array(
  'users' => array(
    'short' => 'Users',
    'long'  => 'Manage users',
    'imgs'  => 'fas fa-users',
    // 'imgs'  => 'user_profile.png',
    'type'  => 'img',
    'link'  => 'users',
    'anim'  => 'zoomInLeft'
  ),
  // 'tasks' => array(
  //   'short' => 'Tasks',
  //   'long'  => 'User Tasks',
  //   'imgs'  => 'fa-solid fa-list-check',
  //   // 'imgs'  => 'blog.png',
  //   'type'  => 'img',
  //   'link'  => 'tasks',
  //   'anim'  => 'zoomInRight'
  // ),
  // 'categories' => array(
  //   'short' => 'Task Categories',
  //   'long'  => 'Task Categories',
  //   'imgs'  => 'fa-solid fa-list-ul',
  //   // 'imgs'  => 'blog.png',
  //   'type'  => 'img',
  //   'link'  => 'categories',
  //   'anim'  => 'zoomInRight'
  // ),
  'bookings' => array(
    'short' => 'Bookings',
    'long'  => 'Manage Bookings',
    'imgs'  => 'fas fa-calendar-alt',
    // 'imgs'  => 'publications.png',
    'type'  => 'img',
    'link'  => 'bookings',
    'anim'  => 'zoomInUp'
  ),
  'feedback' => array(
    'short' => 'Feedback',
    'long'  => 'Manage User Feedback',
    'imgs'  => 'fa-solid fa-rss',
    // 'imgs'  => 'publications.png',
    'type'  => 'img',
    'link'  => 'feedback',
    'anim'  => 'zoomInUp'
  ),
  // 'activities' => array(
  //   'short' => 'Task Activities',
  //   'long'  => 'Task Activities',
  //   'imgs'  => 'fa-solid fa-chart-line',
  //   // 'imgs'  => 'blog.png',
  //   'type'  => 'img',
  //   'link'  => 'activities',
  //   'anim'  => 'zoomInRight'
  // ),
  'settings' => array(
    'short' => 'Settings',
    'long'  => 'Page Settings ',
    'imgs'  => 'fa-solid fa-screwdriver-wrench',
    // 'imgs'  => 'blog.png',
    'type'  => 'img',
    'link'  => 'settings',
    'anim'  => 'zoomInRight'
  ),
   'admin' => array(
    'short' => 'Admin Tasks',
    'long'  => 'Admin Tasks ',
    'imgs'  => 'fa-solid fa-screwdriver-wrench',
    // 'imgs'  => 'blog.png',
    'type'  => 'img',
    'link'  => 'admin',
    'anim'  => 'zoomInRight'
  ),
);

$user_pages = array(
  'tasks' => array(
    'short' => 'Tasks',
    'long'  => 'User Tasks',
    'imgs'  => 'fa-solid fa-list-check',
    // 'imgs'  => 'blog.png',
    'type'  => 'img',
    'link'  => 'tasks',
    'anim'  => 'zoomInRight'
  ),
  'activities' => array(
    'short' => 'Task Activities',
    'long'  => 'Task Activities',
    'imgs'  => 'fa-solid fa-chart-line',
    // 'imgs'  => 'blog.png',
    'type'  => 'img',
    'link'  => 'activities',
    'anim'  => 'zoomInRight'
  ),
);

$admin_pages = array(
  'users' => array(
    'short' => 'Users',
    'long'  => 'Manage users',
    'imgs'  => 'fas fa-users',
    // 'imgs'  => 'user_profile.png',
    'type'  => 'img',
    'link'  => 'users',
    'anim'  => 'zoomInLeft'
  ),
  'tasks' => array(
    'short' => 'Tasks',
    'long'  => 'User Tasks',
    'imgs'  => 'fa-solid fa-list-check',
    // 'imgs'  => 'blog.png',
    'type'  => 'img',
    'link'  => 'tasks',
    'anim'  => 'zoomInRight'
  ),
  // 'categories' => array(
  //   'short' => 'Task Categories',
  //   'long'  => 'Task Categories',
  //   'imgs'  => 'fa-solid fa-list-ul',
  //   // 'imgs'  => 'blog.png',
  //   'type'  => 'img',
  //   'link'  => 'categories',
  //   'anim'  => 'zoomInRight'
  // ),
  'activities' => array(
    'short' => 'Task Activities',
    'long'  => 'Task Activities',
    'imgs'  => 'fa-solid fa-chart-line',
    // 'imgs'  => 'blog.png',
    'type'  => 'img',
    'link'  => 'activities',
    'anim'  => 'zoomInRight'
  ),
  'admin' => array(
    'short' => 'Admin Tasks',
    'long'  => 'Admin Tasks ',
    'imgs'  => 'fa-solid fa-screwdriver-wrench',
    // 'imgs'  => 'blog.png',
    'type'  => 'img',
    'link'  => 'admin',
    'anim'  => 'zoomInRight'
  ),
);

$events_navba      = array(
  'upcoming' => array(
    'short' => 'Upcoming Events',
    'long'  => 'Upcoming Events',
    'imgs'  => 'fa-solid fa-calendar-days',
    'type'  => 'font',
    'anim'  => 'zoomInUp'
  ),
  'previous' => array(
    'short' => 'Previous Events',
    'long'  => 'Previous Events',
    'imgs'  => 'fa-solid fa-clock-rotate-left',
    'type'  => 'font',
    'anim'  => 'zoomInUp'
  ),
);

// settings tabs ************************
// login tabs
$login_tabs   = array(
  'signin'      => array(
    'name'      => 'Sign In',
    'long'      => 'Login to your account',
    'imgs'      => 'fas fa-user',
    'type'      => 'font',
    'page'      => 'signin',
    'anim'      => 'zoomInUp'
  ),
  'signup'      => array(
    'name'      => 'Sign up',
    'long'      => 'Register a new account',
    'imgs'      => 'fa-solid fa-address-card',
    'type'      => 'font',
    'page'      => 'signup',
    'anim'      => 'zoomInUp'
  ),

);

// login tabs
$user_login_tabs   = array(
  'login'      => array(
    'name'      => 'Sign In',
    'long'      => 'Login to your account',
    'imgs'      => 'fas fa-user',
    'type'      => 'font',
    'page'      => 'user_login',
    'anim'      => 'zoomInUp'
  ),
  'auth'        => array(
    'name'      => 'Authentification',
    'long'      => 'Two-Factor Authentification',
    'imgs'      => '',
    'type'      => 'font',
    'page'      => 'user_auth',
    'anim'      => 'zoomInUp'
  ),
);

$login_carousel   = array(
  'carousel1' => array(
    'signin'      => array(
      'name'      => 'Communication tools',
      'long'      => 'SMS integration, email and other Communication tools',
      'imgs'      => 'fas fa-user',
      'type'      => 'font',
      'page'      => 'communication.jpg',
      'anim'      => 'bounce'
    ),
    'signup'      => array(
      'name'      => 'Data management tools',
      'long'      => 'Data integration, migration and data management tools',
      'imgs'      => 'fa-solid fa-address-card',
      'type'      => 'font',
      'page'      => 'data.jpg',
      'anim'      => 'bounce'
    ),
  ),
  'carousel2' => array(
    'signin'      => array(
      'name'      => 'Seamlessly automated processes',
      'long'      => 'Automation tools to ensure easy management of processes',
      'imgs'      => 'fas fa-user',
      'type'      => 'font',
      'page'      => 'seamless.jpg',
      'anim'      => 'bounce'
    ),
    'signup'      => array(
      'name'      => 'Save time and reduce costs',
      'long'      => 'Time and Cost effective data management technological system',
      'imgs'      => 'fa-solid fa-address-card',
      'type'      => 'font',
      'page'      => 'time.jpg',
      'anim'      => 'bounce'
    ),
  ),
  'carousel3' => array(
    'signin'      => array(
      'name'      => 'Task tracking',
      'long'      => 'Platform to track user tasks and workflow with data visualisation',
      'imgs'      => 'fas fa-user',
      'type'      => 'font',
      'page'      => 'tasks.jpg',
      'anim'      => 'bounce'
    ),
    'signup'      => array(
      'name'      => 'User management tools',
      'long'      => 'Platform to manage users and user permissions and task assignment',
      'imgs'      => 'fa-solid fa-address-card',
      'type'      => 'font',
      'page'      => 'user.jpg',
      'anim'      => 'bounce'
    ),
  ),
);

// create account tabs
$account_tabs   = array(
  'account'     => array(
    'name'      => 'Create Account',
    'long'      => '',
    'imgs'      => 'fas fa-tools',
    'type'      => 'font',
    'page'      => 'create_account',
    'anim'      => 'zoomInUp'
  ),
  'username'  => array(
    'name'      => 'Create Username',
    'long'      => '',
    'imgs'      => 'fas fa-user-shield',
    'type'      => 'font',
    'page'      => 'username',
    'anim'      => 'zoomInUp'
  ),
  'details'  => array(
    'name'      => 'Personal Information',
    'long'      => '',
    'imgs'      => 'fas fa-user-shield',
    'type'      => 'font',
    'page'      => 'user_details',
    'anim'      => 'zoomInUp'
  ),

);

$article_navba      = array(
  'civil_matters' => array(
    'short' => 'Civil Matters',
    'long'  => 'Lorem ipsum dolor sit amet, consectetur',
    'imgs'  => 'fas fa-gavel',
    'type'  => 'font',
    'anim'  => 'zoomInUp'
  ),
  'labour_matters' => array(
    'short' => 'Estate Administration',
    'long'  => 'Employment and labour maters,',
    'imgs'  => 'fas fa-briefcase',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
  'criminal_matters' => array(
    'short' => 'Property Tranfers',
    'long'  => 'Lorem ipsum dolor sit amet, consectetur',
    'imgs'  => 'fas fa-user-secret',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
  'estate_planning' => array(
    'short' => 'Estate Planning',
    'long'  => 'Lorem ipsum dolor sit amet, consectetur',
    'imgs'  => 'fas fa-building',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
  'wills_trust' => array(
    'short' => 'Road Accident Fund',
    'long'  => 'Lorem ipsum dolor sit amet, consectetur',
    'imgs'  => 'fas fa-journal-whills',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
);

$user_activities    = array(
  'all' => array(
    'short' => 'All Activities',
    'long'  => '',
    'imgs'  => 'fas fa-clipboard-list',
    'type'  => 'font',
    'anim'  => 'zoomInUp'
  ),
  'users' => array(
    'short' => 'All Users',
    'long'  => '',
    'imgs'  => 'fas fa-users',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
  'user' => array(
    'short' => 'User Activities',
    'long'  => '',
    'imgs'  => 'fas fa-user-secret',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
);

$user_types_navs    = array(
  'user_types' => array(
    'short' => 'User Types',
    'long'  => '',
    'imgs'  => 'fas fa-clipboard-list',
    'type'  => 'font',
    'anim'  => 'zoomInUp'
  ),
  'add_user_type' => array(
    'short' => 'Add User Types',
    'long'  => '',
    'imgs'  => 'fas fa-users',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
);

$category_navs    = array(
  'categories' => array(
    'short' => 'Task Categories',
    'long'  => '',
    'imgs'  => 'fa-solid fa-cubes-stacked',
    'type'  => 'font',
    'anim'  => 'zoomInUp'
  ),
  'add_category' => array(
    'short' => 'Add Category',
    'long'  => '',
    'imgs'  => 'fa-solid fa-plus',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
);

$user_permissions    = array(
  'execute' => array(
    'short' => 'Execute',
    'long'  => '',
    'imgs'  => 'fas fa-clipboard-list',
    'type'  => 'font',
    'anim'  => 'zoomInUp'
  ),
  'write' => array(
    'short' => 'Write',
    'long'  => '',
    'imgs'  => 'fas fa-users',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
  'read' => array(
    'short' => 'Read Only',
    'long'  => '',
    'imgs'  => 'fas fa-users',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
);

$admin_pagenav = array(
  'performance' => array(
    'short' => 'User Performance',
    'long'  => 'Manage Practice Tasks',
    'imgs'  => 'fa-solid fa-list-check',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
  // 'company' => array(
  //   'short' => 'Company Settings',
  //   'long'  => 'Manage Company and Offices',
  //   'imgs'  => 'fa-solid fa-registered',
  //   'type'  => 'font',
  //   'anim'  => 'zoomInUp'
  // ),
  // 'migration' => array(
  //   'short' => 'Data Migration',
  //   'long'  => 'Manage Data Migration/Import',
  //   'imgs'  => 'fa-solid fa-database',
  //   'type'  => 'font',
  //   'anim'  => 'zoomInLeft'
  // ),
);

$association_navs    = array(
  'client' => array(
    'short' => 'Assign Applicant / Executor',
    'long'  => '',
    'imgs'  => 'fas fa-clipboard-list',
    'type'  => 'font',
    'anim'  => 'zoomInUp'
  ),
  'member' => array(
    'short' => 'Assign Deceased Estate',
    'long'  => '',
    'imgs'  => 'fas fa-users',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
);

// notifications 
$notifications_arr = array(
  'associations' => array(
    'updt_0'       => array(
      'msg' => 'Applicant/Executor has been deassociated',
      'sts' => 'update',
      'oth' => '',
    ),
    'updt_1'       => array(
      'msg' => 'Applicant/Executor has been associated again',
      'sts' => 'update',
      'oth' => '',
    ),
    'insert'  => array(
      'msg' => 'applicant/Executor has been newly associated ',
      'sts' => 'insert',
      'oth' => '',
    ),
  ),
  'client_associations' => array(
    'updt_0'       => array(
      'msg' => 'Applicant/Executor has been updated',
      'sts' => 'update',
      'oth' => '',
    ),
    'updt_1'       => array(
      'msg' => 'Applicant/Executor has been updated again',
      'sts' => 'update',
      'oth' => '',
    ),
    'insert'  => array(
      'msg' => 'applicant/Executor has been created ',
      'sts' => 'insert',
      'oth' => '',
    ),
  ),
  'members'   => array(
    'update' => array(
      'msg'   => 'Deceased estate has been updated',
      'ntf'   => '',
    ),
    'insert' => array(
      'msg'   => 'New deceased estate has been created',
      'ntf'   => '',
    ),
    'remove' => array(
      'msg'   => 'Deceased estate has been removed',
      'ntf'   => '',
    ),
  ),
);


$booking_navba      = array(
  'moderator' => array(
    'short' => 'Moderator',
    'long'  => 'Moderator Bookings',
    'imgs'  => 'fas fa-chalkboard-teacher',
    'type'  => 'font',
    'anim'  => 'zoomInUp'
  ),
  'mc' => array(
    'short' => 'MC',
    'long'  => 'MC Bookings',
    'imgs'  => 'fab fa-teamspeak',
    // 'imgs'  => 'fab fa-uncharted',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
  'podcast' => array(
    'short' => 'Podcast',
    'long'  => 'Podcast Bookings',
    'imgs'  => 'fas fa-microphone-alt',
    // 'imgs'  => 'fab fa-uncharted',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),

);

$admin_booking      = array(
  'bookings' => array(
    'short' => 'Bookings',
    'long'  => 'Consultation Bookings',
    'imgs'  => 'fa-solid fa-calendar-check',
    'type'  => 'font',
    'anim'  => 'zoomInUp'
  ),
  'processed' => array(
    'short' => 'Processed',
    'long'  => 'Processed Bookings',
    'imgs'  => 'fas fa-clipboard-check',
    // 'imgs'  => 'fab fa-uncharted',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),

);

// pages
$pages_nav      = array(
  'home' => array(
    'short' => 'Home Page',
    'long'  => '',
    'imgs'  => 'fas fa-home',
    'type'  => 'font',
    'anim'  => 'zoomInUp'
  ),
  'contact' => array(
    'short' => 'Contact Page',
    'long'  => '',
    'imgs'  => 'fas fa-id-card',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  )
);

$media_navba      = array(
  'appearance' => array(
    'short' => 'Media Appearance',
    'long'  => 'Published podcast & TV Appearances',
    'imgs'  => 'fas fa-podcast',
    'type'  => 'font',
    'anim'  => 'zoomInUp'
  ),
  'gallery' => array(
    'short' => 'Gallery',
    'long'  => 'Media Gallery',
    'imgs'  => 'fas fa-camera-retro',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
  'file' => array(
    'short' => 'Files',
    'long'  => 'Media Files',
    'imgs'  => 'fas fa-folder-open',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
);

$articles_nav      = array(
  'articles' => array(
    'short' => 'Articles & Columns',
    'long'  => 'Journal articles and Published policy briefs',
    'imgs'  => 'fab fa-leanpub',
    'type'  => 'font',
    'anim'  => 'zoomInUp'
  ),
  'everyday_economics' => array(
    'short' => 'Everyday Economics',
    'long'  => 'Everyday economic analysis & insights',
    'imgs'  => 'fas fa-blog',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
  // 'featured' => array(
  //   'short' => 'Featured',
  //   'long'  => 'Featured articles, publications & blogs',
  //   'imgs'  => 'far fa-newspaper',
  //   'type'  => 'font',
  //   'anim'  => 'zoomInLeft'
  // ),
);

// dietary
$dietary_list = array(
  'none'        => 'None',
  'vegetarian'  => 'Vegetarian',
  'vegan'       => 'Vegan',
  'gluten'      => 'Gluten-free',
  'dairy'       => 'Dairy-free',
  'other'       => 'Other (Please elaborate below)',
);


// {"messages\":[
//   {\"document\":
//     {\"variables\":{},\"version\":0}
//   }]
// "};

// SMS send options
$msg_array = array(
  "content"     => "",
  "destination" => "",
  "customerId"  => "",
  "document"      => array(
    "template"    => "",
    "version"     => "",
    "password"    => "",
    "variables"   => array(),
  ),
);

$sms_arr = array(
  "sendOptions" => array(
    "senderId"          => "",
    "duplicateCheck"    => "",
    "startDeliveryUtc"  => "",
    "endDeliveryUtc"    => "",
    "replyRuleSetName"  => "",
    "campaignName"      => "",
    "costCentre"        => "",
    "checkOptOuts"      => "",
    "shortenUrls"       => "",
    "validityPeriod"    => "",
    "testMode"          => "",
    "rulename"          => "",
    "replyRuleVersion"  => "",
    "extraForwardEmails" => "",
  ),
  "messages" => array(),

);

function service_cnt()
{
  global $article_navba;
  $cntnt = '';
  $arr = count($article_navba);
  $cnt = 0;
  foreach ($article_navba as $key => $val) {
    $cnt++;
    $cntnt .=  $val['short'] . (($cnt != $arr) ? '  <span style="font-weigght: bolder;" class="alt_dflt"> &middot; </span> ' : '');
  }

  return $cntnt;
}

$home_array         = array(
  'about' => array(
    'short' => 'About us',
    'long'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
    'font'  => 'fa-solid fa-circle-info',
    'imgs'  => 'user_profile.png',
    'type'  => 'img',
    'link'  => 'about',
    'anim'  => 'swing',
    'wait'  => '1',
  ),
  'features' => array(
    'short' => 'Features',
    'long'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
    'font'  => 'fa-solid fa-briefcase',
    'imgs'  => 'publications.png',
    'type'  => 'img',
    'link'  => 'features',
    'anim'  => 'tada',
    'wait'  => '2',
  ),
  'contact' => array(
    'short' => 'Contact us',
    'long'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
    'font'  => 'fa-solid fa-address-book',
    'imgs'  => 'blog.png',
    'type'  => 'img',
    'link'  => 'contact',
    'anim'  => 'wobble',
    'wait'  => '3',
  )
);

// service options
$serviceopt_array = array(
  'online' => array(
    'short' => 'Online Access',
    'long'  => 'Online Access',
    'font'  => 'fa-solid fa-cloud',
    'imgs'  => 'user_profile.png',
    'type'  => 'img',
    'link'  => 'about',
    'page'  => 'login',
    'clas'  => 'col-md-4',
    'anim'  => 'slideInLeft',
    'wait'  => '1',
  ),
  'communication' => array(
    'short' => 'Communication Tools',
    'long'  => 'Communication Tools',
    'font'  => 'fa-solid fa-tower-cell',
    'imgs'  => 'publications.png',
    'type'  => 'img',
    'link'  => 'communication',
    'page'  => 'tasks',
    'clas'  => 'col-md-4',
    'anim'  => 'slideInUp',
    'wait'  => '1',
  ),
  'migration' => array(
    'short' => 'Data Migration',
    'long'  => 'Data Migration',
    'font'  => 'fa-solid fa-database',
    'imgs'  => 'blog.png',
    'type'  => 'img',
    'link'  => 'contact',
    'page'  => 'migration',
    'clas'  => 'col-md-4',
    'anim'  => 'slideInRight',
    'wait'  => '1',
  ),
  'customisation' => array(
    'short' => 'Customisation',
    'long'  => 'Customisation',
    'font'  => 'fa-brands fa-mixer',
    'imgs'  => 'user_profile.png',
    'type'  => 'img',
    'link'  => 'about',
    'page'  => 'customisation',
    'clas'  => 'col-md-6',
    'anim'  => 'bounceInLeft',
    'wait'  => '2',
  ),
  'data' => array(
    'short' => 'Secure Data Storage',
    'long'  => 'Secure Data Storage',
    'font'  => 'fa-sharp fa-solid fa-warehouse',
    'imgs'  => 'publications.png',
    'type'  => 'img',
    'link'  => 'services',
    'page'  => 'data',
    'clas'  => 'col-md-6',
    'anim'  => 'bounceInRight',
    'wait'  => '2',
  ),
);

// about
$about_navba = array(
  'background' => array(
    'short' => 'Our background',
    'long'  => '',
    'font'  => 'fa-solid fa-hourglass-half',
    'imgs'  => 'user_profile.png',
    'type'  => 'img',
    'link'  => 'background',
    'anim'  => 'swing',
    'wait'  => '1',
  ),
  'promise' => array(
    'short' => 'Our service offerings',
    'long'  => '',
    'font'  => 'fa-solid fa-briefcase',
    'imgs'  => 'publications.png',
    'type'  => 'img',
    'link'  => 'promise',
    'anim'  => 'tada',
    'wait'  => '2',
  ),
  'testimonials' => array(
    'short' => 'Our team', 
    'long'  => '',
    'font'  => 'fa-solid fa-comments',
    'imgs'  => 'blog.png',
    'type'  => 'img',
    'link'  => 'testimonials',
    'anim'  => 'wobble',
    'wait'  => '3',
  ),
);

// contact tabs
$contact_tabs         = array(
  'client' => array(
    'short' => 'Client Inquiries',
    'long'  => '',
    'font'  => 'fa-solid fa-circle-info',
    'imgs'  => '/icons/articles-white.png',
    'type'  => 'img',
    'link'  => '',
    'call'  => '+27 00 000 0000',
    'wapp'  => '27 00 000 0000',
    'mail'  => 'info@'.$_ENV['PROJECT_HOST'],
    'site'  => $_ENV['PROJECT_HOST'],
    'anim'  => 'slideInUp',
    'wait'  => '1',
  ),
  'media' => array(
    'short' => 'Media Inquiries',
    'long'  => '',
    'font'  => 'fa-solid fa-newspaper',
    'imgs'  => '/icons/media-white.png',
    'type'  => 'img',
    'link'  => '',
    'call'  => '+27 21 879 3035',
    'wapp'  => '27 21 879 3035',
    'mail'  => 'media@'.$_ENV['PROJECT_HOST'],
    'site'  => $_ENV['PROJECT_HOST'],
    'anim'  => 'slideInUp',
    'wait'  => '2',
  ), 
  'business' => array(
    'short' => 'Business Related',
    'long'  => '',
    'font'  => 'fa-solid fa-address-book',
    'imgs'  => '/icons/newsletter-white.png',
    'type'  => 'img',
    'link'  => '',
    'call'  => '+27 21 879 3035',
    'wapp'  => '27 21 879 3035',
    'mail'  => 'business@'.$_ENV['PROJECT_HOST'],
    'site'  => $_ENV['PROJECT_HOST'],
    'anim'  => 'slideInUp',
    'wait'  => '3',
  ),
  'recruitment' => array(
    'short' => 'Recruitment Related',
    'long'  => '',
    'font'  => 'fa-solid fa-briefcase',
    'imgs'  => '/icons/newsletter-white.png',
    'type'  => 'img',
    'link'  => '',
    'call'  => '+27 21 879 3035',
    'wapp'  => '27 21 879 3035',
    'mail'  => 'jobs@'.$_ENV['PROJECT_HOST'],
    'site'  => $_ENV['PROJECT_HOST'],
    'anim'  => 'slideInUp',
    'wait'  => '4',
  ),
);


// contact
$contact_array = array(
  'contact' => array(
    'short' => 'Contact Us',
    'long'  => '',
    'font'  => 'fa-solid fa-phone',
    'imgs'  => 'user_profile.png',
    'type'  => 'img',
    'link'  => 'contact',
    'anim'  => 'swing',
    'wait'  => '1',
  ),
  'booking' => array(
    'short' => 'Booking',
    'long'  => '',
    'font'  => 'fa-solid fa-buildin',
    'imgs'  => 'publications.png',
    'type'  => 'img',
    'link'  => 'booking',
    'anim'  => 'tada',
    'wait'  => '2',
  ),
  'feedback' => array(
    'short' => 'Feedback',
    'long'  => '',
    'font'  => 'fa-solid fa-comments',
    'imgs'  => 'blog.png',
    'type'  => 'img',
    'link'  => 'feedback',
    'anim'  => 'wobble',
    'wait'  => '3',
  )
);

$booking_types = array(
  'booking' => array(
    'short' => 'Enquiry Form',
    'long' => 'Complete the form below to make an enquiry',
    'imgs' => 'fas fa-chalkboard-teacher',
    'text' => 'Online Booking',
    'type' => 'font',
    'anim' => 'zoomInUp'
  ),
  'registration' => array(
    'short' => 'YDW program registration',
    'long' => 'Complete the form below to register',
    'imgs' => 'fab fa-teamspeak',
    'text' => 'YDW program registration',
    'type' => 'font',
    'anim' => 'zoomInLeft'
  ),
  'business' => array(
    'short' => 'BLM program registrations',
    'long' => 'Complete the form below to register',
    'imgs' => 'fas fa-microphone-alt',
    'text' => 'BLM program registrations',
    'type' => 'font',
    'anim' => 'zoomInLeft'
  ),
  'development' => array(
    'short' => 'HOW CAN WE ASSIST?',
    'long' => 'Fill the form below and we will get in touch with you',
    'imgs' => 'Complete the form below',
    'text' => 'History and Arts Development',
    'type' => 'font',
    'anim' => 'zoomInLeft'
  ),
  'program' => array(
    'short' => 'Who Did You Lead Today?',
    'long' => '',
    'imgs' => 'fas fa-microphone-alt',
    'text' => 'iL3AD Program',
    'type' => 'font',
    'anim' => 'zoomInLeft'
  ),
  'construction' => array(
    'short' => 'SPONSOR OUR BMC PROGRAM?',
    'long' => 'Fill the form below and we will get in touch with you',
    'imgs' => 'Complete the form below',
    'text' => 'BMC Sponsorship',
    'type' => 'font',
    'anim' => 'zoomInLeft'
  ),
  'service' => array(
    'short' => 'REQUEST OUR BMC SERVICE?',
    'long' => 'Fill the form below and we will get in touch with you',
    'imgs' => '',
    'text' => 'BMC Service Request',
    'type' => 'font',
    'anim' => 'zoomInLeft'
  ),
  'quotation' => array(
    'short' => 'Quotation Request',
    'long' => 'Fill the form below and we will get in touch with you',
    'imgs' => '',
    'text' => 'Quotation Request',
    'type' => 'font',
    'anim' => 'zoomInLeft'
  ),
  'enquiry' => array(
    'short' => 'Enquiry Form',
    'long' => 'Complete the form below to make an enquiry',
    'imgs' => '',
    'text' => 'Enquiry Form',
    'type' => 'font',
    'anim' => 'zoomInLeft'
  ),
  'event' => array(
    'short' => 'Events',
    'long' => 'You may add or edit events',
    'imgs' => '',
    'text' => 'Events',
    'type' => 'font',
    'anim' => 'zoomInLeft'
  ),
  'request' => array(
    'short' => 'Account Request',
    'long' => 'You may add or edit events',
    'imgs' => '',
    'text' => 'Account Request',
    'type' => 'font',
    'anim' => 'zoomInLeft'
  ),

);

$services_navba      = array(
  'commercial' => array(
    'short' => 'Service 1',
    'long'  => 'Lorem ipsum dolor <br> consectetur adipiscing',
    'imgs'  => 'fa-solid fa-building',
    'type'  => 'font',
    'anim'  => 'pulse',
    'wait'  => '1',
  ),
  'laundry' => array(
    'short' => 'Service 2',
    'long'  => 'Lorem ipsum dolor <br> consectetur adipiscing',
    'imgs'  => 'fa-solid fa-soap',
    'type'  => 'font',
    'anim'  => 'pulse',
    'wait'  => '1',
  ),
  'residential' => array(
    'short' => 'Service 3',
    'long'  => 'Lorem ipsum dolor <br> consectetur adipiscing',
    'imgs'  => 'fa-solid fa-house-chimney',
    'type'  => 'font',
    'anim'  => 'pulse',
    'wait'  => '1',
  ),
  'others'  => array(
    'short' => 'Service 4',
    'long'  => 'Lorem ipsum dolor <br> consectetur adipiscing',
    'imgs'  => 'fa-solid fa-broom',
    'type'  => 'font',
    'anim'  => 'pulse',
    'wait'  => '1',
  ),
);

// locations
$office_info      = array(
  'headoffice' => array(
    'short' => 'Head Office',
    'long'  => 'Arttorneys',
    'user'  => 'Info',
    'email' => 'info@' . $_ENV['MAIL_HOST'],
    'type'  => 'font',
    'anim'  => 'zoomInUp'
  ),
);

// user members
$company_types      = array(
  'law_firm' => array(
    'short' => 'Law firm',
    'long'  => 'Law firm',
    'imgs'  => 'fas fa-gavel',
    'type'  => 'font',
    'anim'  => 'zoomInUp'
  ),
  'arttorneys' => array(
    'short' => 'Arttorneys',
    'long'  => 'Arttorneys',
    'imgs'  => 'fas fa-gavel',
    'type'  => 'font',
    'anim'  => 'zoomInUp'
  ),
  'conveyancers' => array(
    'short' => 'Conveyancers',
    'long'  => 'Conveyancers',
    'imgs'  => 'fas fa-home',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
  'notaries' => array(
    'short' => 'Notaries',
    'long'  => 'notaries',
    'imgs'  => 'fab fa-leanpub',
    'type'  => 'font',
    'anim'  => 'zoomInLeft'
  ),
);

$social_media = array(
  // 'facebook'  => array(
  //   'name' => 'facebook',
  //   'user' => '',
  //   'font' => 'fab fa-facebook',
  //   'link' => '',
  //   'lnk2' => 'https://' . $_ENV['PROJECT_HOST'] . '/img/other/facebook.png',
  // ),
  // 'intagram'  => array(
  //   'name' => 'instagram',
  //   'user' => '',
  //   'font' => 'fab fa-instagram',
  //   'link' => '',
  //   'lnk2' => 'https://'.$_ENV['PROJECT_HOST'] . '/img/other/instagram.png',
  // ),
  // 'linkedin'  => array(
  //   'name' => 'linkedin',
  //   'user' => '',
  //   'font' => 'fab fa-linkedin',
  //   'link' => '',
  //   'lnk2' => 'https://'.$_ENV['PROJECT_HOST'] . '/img/other/linkedin.png',),
  // 'twitter'   => array(
  //   'name' => 'twitter',
  //   'user' => '',
  //   'font' => 'fab fa-twitter',
  //   'link' => '',
  //   'lnk2' => 'https://' . $_ENV['PROJECT_HOST'] . '/img/other/twitter.png',
  // ),
);

$user_types = array(
  'administrator' => 'Administrator',
  'executive'     => 'Executive',
  'registrar'     => 'registrar',
  'member'        => 'Staff',
  'attorney'      => 'Attorney',
  'conveyancer'   => 'Conveyancer',
  'notary'        => 'Notary',
  'guest'         => 'Guest',
  'other'         => 'Other',
);

// client association 
$client_task_associations = array(
  'consultation_date'         => 'Consultation',
  'executorship_letter_date'  => 'Letter of Appointment',
  'section_29_date'           => 'Section 29 Advert',
  'section_28_date'           => 'Section 28 Bank Account',
  'claims_lodged_date'        => 'Claims lodged',
  'ld_lodged_date'            => 'L & D lodged / Sent to SARS',
  'advertise_permission_date' => 'Permission to advertise i.t.o Section 35',
  'section_35_date'           => 'Section 35 Advert',
  'conveyancers_file_refer'   => 'File referred to conveyancers',
  'masters_fee_date'          => 'Master\'s Fee paid',
  'filing_notice_date'        => 'Filing Notice',
);

// client association message updates
$client_task_associations_msgs = array(
  'consultation_date'         => array(
    'name' => 'Consultation',
    'mesg' => "Login info; username: Cell; password: Password; website: sn-attorneys.co.za ~S&A Attorneys",
    'long' => "Notice of consultation",
    'notc' => "Notice of consultation issued",
  ),
  'executorship_letter_date'  => array(
    'name' => 'Letter of Appointment',
    'mesg' => "Hi, the Letter of Appointment for Name's estate has been issued. ~S&A Attorneys",
    'long' => "Good day, kindly note that we received the letter of Executorship. We will proceed to advertise for creditors. We will keep in touch. SN Attorneys",
    'notc' => "Letter of Appointment",
  ),
  'section_29_date'           => array(
    'name' => 'Section 29 Advert',
    'mesg' => "Hi, Section 29 Advert for Name's estate has been published. ~S&A Attorneys",
    'long' => "Good day, the advert for creditors will appear in The Star next week Friday. SN Attorneys",
    'notc' => "Letter of Appointment",
  ),
  'section_28_date'           => array(
    'name' => 'Section 28 Bank Account',
    'mesg' => "Hi, Section 28 Bank Account for Name's estate has been created. ~S&A Attorneys",
    'long' => "Good day, the advert for creditors was published. After 30 days we will draft Liquidation and Distribution account for lodgment at the Master. SN Attorneys.",
    'notc' => "Section 28 Bank Account",
  ),
  'claims_lodged_date'        => array(
    'name' => 'Claims lodged',
    'mesg' => "Hi, the claims due to Name's estate have been lodged. ~S&A Attorneys",
    'long' => "Good day, the advert for creditors was published. After 30 days we will draft Liquidation and Distribution account for lodgment at the Master. SN Attorneys.",
    'notc' => "Claims lodged",
  ),
  'ld_lodged_date'            => array(
    'name' => 'L & D lodged / Sent to SARS',
    'mesg' => "Hi, the L&D account for Name's estate has been lodged and sent to SARS. ~S&A Attorneys",
    'long' => "Good day, the Liquidation and Distribution account has been lodged at the Master. We are waiting for permission to advertise the L and D account. SN Attorneys.",
    'notc' => "L & D lodged / Sent to SARS",
  ),
  'advertise_permission_date' => array(
    'name' => "Permission to advertise i.t.o Section 35",
    'mesg' => "Hi, we have been given permission to advertise i.t.o Section 35 of Name's estate. ~S&A Attorneys",
    'long' => "",
    'notc' => "Permission to advertise i.t.o Section 35",
  ),
  'section_35_date'           => array(
    'name' => 'Section 35 Advert',
    'mesg' => "Hi, Section 35 Advert of Name's estate has been published. ~S&A Attorneys",
    'long' => "",
    'notc' => "Section 35 Advert",
  ),
  'conveyancers_file_refer'   => array(
    'name' => 'File referred to conveyancers',
    'mesg' => "Hi, we have referred Name's estate file to our conveyancers for property tansfers. ~S&A Attorneys",
    'long' => "",
    'notc' => "File referred to conveyancers",
  ),
  'masters_fee_date'          => array(
    'name' => 'Master\'s Fee paid',
    'mesg' => "Hi, the Master's Fee for Name's estate has been paid. ~S&A Attorneys",
    'long' => "Good day, the Master's Fee has been paid. S&A Attorneys.",
    'notc' => "Master's Fee paid",
  ),
  'filing_notice_date'        => array(
    'name' => 'Filing Notice',
    'mesg' => "",
    'long' => "",
    'notc' => "Filing Notice",
  ),
);

// colors array
$colors_array = array(
  'red' => array(
    'rgb' => 'rgba(255, 99, 132, 0.5)',
  ),
  'blue' => array(
    'rgb' => 'rgba(54, 162, 235, 0.5)',
  ),
  'yellow' => array(
    'rgb' => 'rgba(255, 206, 86, 0.5)',
  ),
  'green' => array(
    'rgb' => 'rgba(75, 192, 192, 0.5)',
  ),
  'purple' => array(
    'rgb' => 'rgba(153, 102, 255, 0.5)',
  ),
  'orange' => array(
    'rgb' => 'rgba(255, 159, 64, 0.5)',
  ),
  'black' => array(
    'rgb' => 'rgba(0, 0, 0, 0.5)',
  ),
  'grey' => array(
    'rgb' => 'rgba(126, 126, 126, 0.5)',
  ),
  'aliceblue' => array(
    'rgb' => 'rgba(240, 248, 255, 0.5)',
  ),
  'coral' => array(
    'rgb' => 'rgba(255, 127, 80, 0.5)',
  ),
  'firebrick' => array(
    'rgb' => 'rgba(178, 34, 34, 0.5)',
  ),
  'lemonchiffon' => array(
    'rgb' => 'rgba(255, 250, 205, 0.5)',
  ),

);
// Provinces
$provinces = array(
  'gauteng'       =>  'Gauteng',
  'eastern_cape'  =>  'Eastern Cape',
  'freestate'     =>  'Free State',
  'kwazulunatal'  =>  'KwaZulu-Natal',
  'limpopo'       =>  'Limpopo',
  'mpumalanga'    =>  'Mpumalanga',
  'northerncape'  =>  'Northern Cape',
  'westerncape'   =>  'Western Cape',
  'northwest'     =>  'North West'
);

// months
$date_months = array(
  "1"   => "January",
  "2"   => "Febuary",
  "3"   => "March",
  "4"   => "April",
  "5"   => "May",
  "6"   => "June",
  "7"   => "July",
  "8"   => "August",
  "9"   => "September",
  "10"  => "October",
  "11"  => "November",
  "12"  => "December",
);

// countries
$countries_array = array(
  "AF" => "Afghanistan",
  "AL" => "Albania",
  "DZ" => "Algeria",
  "AS" => "American Samoa",
  "AD" => "Andorra",
  "AO" => "Angola",
  "AI" => "Anguilla",
  "AQ" => "Antarctica",
  "AG" => "Antigua and Barbuda",
  "AR" => "Argentina",
  "AM" => "Armenia",
  "AW" => "Aruba",
  "AU" => "Australia",
  "AT" => "Austria",
  "AZ" => "Azerbaijan",
  "BS" => "Bahamas",
  "BH" => "Bahrain",
  "BD" => "Bangladesh",
  "BB" => "Barbados",
  "BY" => "Belarus",
  "BE" => "Belgium",
  "BZ" => "Belize",
  "BJ" => "Benin",
  "BM" => "Bermuda",
  "BT" => "Bhutan",
  "BO" => "Bolivia",
  "BA" => "Bosnia and Herzegowina",
  "BW" => "Botswana",
  "BV" => "Bouvet Island",
  "BR" => "Brazil",
  "IO" => "British Indian Ocean Territory",
  "BN" => "Brunei Darussalam",
  "BG" => "Bulgaria",
  "BF" => "Burkina Faso",
  "BI" => "Burundi",
  "KH" => "Cambodia",
  "CM" => "Cameroon",
  "CA" => "Canada",
  "CV" => "Cape Verde",
  "KY" => "Cayman Islands",
  "CF" => "Central African Republic",
  "TD" => "Chad",
  "CL" => "Chile",
  "CN" => "China",
  "CX" => "Christmas Island",
  "CC" => "Cocos (Keeling) Islands",
  "CO" => "Colombia",
  "KM" => "Comoros",
  "CG" => "Congo",
  "CD" => "Congo, the Democratic Republic of the",
  "CK" => "Cook Islands",
  "CR" => "Costa Rica",
  "CI" => "Cote d'Ivoire",
  "HR" => "Croatia (Hrvatska)",
  "CU" => "Cuba",
  "CY" => "Cyprus",
  "CZ" => "Czech Republic",
  "DK" => "Denmark",
  "DJ" => "Djibouti",
  "DM" => "Dominica",
  "DO" => "Dominican Republic",
  "TP" => "East Timor",
  "EC" => "Ecuador",
  "EG" => "Egypt",
  "SV" => "El Salvador",
  "GQ" => "Equatorial Guinea",
  "ER" => "Eritrea",
  "EE" => "Estonia",
  "ET" => "Ethiopia",
  "FK" => "Falkland Islands (Malvinas)",
  "FO" => "Faroe Islands",
  "FJ" => "Fiji",
  "FI" => "Finland",
  "FR" => "France",
  "FX" => "France, Metropolitan",
  "GF" => "French Guiana",
  "PF" => "French Polynesia",
  "TF" => "French Southern Territories",
  "GA" => "Gabon",
  "GM" => "Gambia",
  "GE" => "Georgia",
  "DE" => "Germany",
  "GH" => "Ghana",
  "GI" => "Gibraltar",
  "GR" => "Greece",
  "GL" => "Greenland",
  "GD" => "Grenada",
  "GP" => "Guadeloupe",
  "GU" => "Guam",
  "GT" => "Guatemala",
  "GN" => "Guinea",
  "GW" => "Guinea-Bissau",
  "GY" => "Guyana",
  "HT" => "Haiti",
  "HM" => "Heard and Mc Donald Islands",
  "VA" => "Holy See (Vatican City State)",
  "HN" => "Honduras",
  "HK" => "Hong Kong",
  "HU" => "Hungary",
  "IS" => "Iceland",
  "IN" => "India",
  "ID" => "Indonesia",
  "IR" => "Iran (Islamic Republic of)",
  "IQ" => "Iraq",
  "IE" => "Ireland",
  "IL" => "Israel",
  "IT" => "Italy",
  "JM" => "Jamaica",
  "JP" => "Japan",
  "JO" => "Jordan",
  "KZ" => "Kazakhstan",
  "KE" => "Kenya",
  "KI" => "Kiribati",
  "KP" => "Korea, Democratic People's Republic of",
  "KR" => "Korea, Republic of",
  "KW" => "Kuwait",
  "KG" => "Kyrgyzstan",
  "LA" => "Lao People's Democratic Republic",
  "LV" => "Latvia",
  "LB" => "Lebanon",
  "LS" => "Lesotho",
  "LR" => "Liberia",
  "LY" => "Libyan Arab Jamahiriya",
  "LI" => "Liechtenstein",
  "LT" => "Lithuania",
  "LU" => "Luxembourg",
  "MO" => "Macau",
  "MK" => "Macedonia, The Former Yugoslav Republic of",
  "MG" => "Madagascar",
  "MW" => "Malawi",
  "MY" => "Malaysia",
  "MV" => "Maldives",
  "ML" => "Mali",
  "MT" => "Malta",
  "MH" => "Marshall Islands",
  "MQ" => "Martinique",
  "MR" => "Mauritania",
  "MU" => "Mauritius",
  "YT" => "Mayotte",
  "MX" => "Mexico",
  "FM" => "Micronesia, Federated States of",
  "MD" => "Moldova, Republic of",
  "MC" => "Monaco",
  "MN" => "Mongolia",
  "MS" => "Montserrat",
  "MA" => "Morocco",
  "MZ" => "Mozambique",
  "MM" => "Myanmar",
  "NA" => "Namibia",
  "NR" => "Nauru",
  "NP" => "Nepal",
  "NL" => "Netherlands",
  "AN" => "Netherlands Antilles",
  "NC" => "New Caledonia",
  "NZ" => "New Zealand",
  "NI" => "Nicaragua",
  "NE" => "Niger",
  "NG" => "Nigeria",
  "NU" => "Niue",
  "NF" => "Norfolk Island",
  "MP" => "Northern Mariana Islands",
  "NO" => "Norway",
  "OM" => "Oman",
  "PK" => "Pakistan",
  "PW" => "Palau",
  "PA" => "Panama",
  "PG" => "Papua New Guinea",
  "PY" => "Paraguay",
  "PE" => "Peru",
  "PH" => "Philippines",
  "PN" => "Pitcairn",
  "PL" => "Poland",
  "PT" => "Portugal",
  "PR" => "Puerto Rico",
  "QA" => "Qatar",
  "RE" => "Reunion",
  "RO" => "Romania",
  "RU" => "Russian Federation",
  "RW" => "Rwanda",
  "KN" => "Saint Kitts and Nevis",
  "LC" => "Saint LUCIA",
  "VC" => "Saint Vincent and the Grenadines",
  "WS" => "Samoa",
  "SM" => "San Marino",
  "ST" => "Sao Tome and Principe",
  "SA" => "Saudi Arabia",
  "SN" => "Senegal",
  "SC" => "Seychelles",
  "SL" => "Sierra Leone",
  "SG" => "Singapore",
  "SK" => "Slovakia (Slovak Republic)",
  "SI" => "Slovenia",
  "SB" => "Solomon Islands",
  "SO" => "Somalia",
  "ZA" => "South Africa",
  "GS" => "South Georgia and the South Sandwich Islands",
  "ES" => "Spain",
  "LK" => "Sri Lanka",
  "SH" => "St. Helena",
  "PM" => "St. Pierre and Miquelon",
  "SD" => "Sudan",
  "SR" => "Suriname",
  "SJ" => "Svalbard and Jan Mayen Islands",
  "SZ" => "Swaziland",
  "SE" => "Sweden",
  "CH" => "Switzerland",
  "SY" => "Syrian Arab Republic",
  "TW" => "Taiwan, Province of China",
  "TJ" => "Tajikistan",
  "TZ" => "Tanzania, United Republic of",
  "TH" => "Thailand",
  "TG" => "Togo",
  "TK" => "Tokelau",
  "TO" => "Tonga",
  "TT" => "Trinidad and Tobago",
  "TN" => "Tunisia",
  "TR" => "Turkey",
  "TM" => "Turkmenistan",
  "TC" => "Turks and Caicos Islands",
  "TV" => "Tuvalu",
  "UG" => "Uganda",
  "UA" => "Ukraine",
  "AE" => "United Arab Emirates",
  "GB" => "United Kingdom",
  "US" => "United States",
  "UM" => "United States Minor Outlying Islands",
  "UY" => "Uruguay",
  "UZ" => "Uzbekistan",
  "VU" => "Vanuatu",
  "VE" => "Venezuela",
  "VN" => "Viet Nam",
  "VG" => "Virgin Islands (British)",
  "VI" => "Virgin Islands (U.S.)",
  "WF" => "Wallis and Futuna Islands",
  "EH" => "Western Sahara",
  "YE" => "Yemen",
  "YU" => "Yugoslavia",
  "ZM" => "Zambia",
  "ZW" => "Zimbabwe"
);
