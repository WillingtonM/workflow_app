-- ****************** SqlDBM: MySQL ******************;
-- ***************************************************;


-- DROP TABLE IF EXISTS `companies`;

-- ************************************** `companies`

CREATE TABLE IF NOT EXISTS `companies`
(
 `company_id`                       BIGINT NOT NULL AUTO_INCREMENT ,
 `user_id`                          bigint NULL ,
 `company_name`                     varchar(255) NULL ,
 `company_slug`                     varchar(255) NULL ,
 `company_short`                    varchar(255) NULL ,
 `company_description`              TEXT ,
 `company_type`                     varchar(255) NULL ,
 `company_subscription`             TINYINT DEFAULT 1 ,
 `company_subscription_active`      TINYINT DEFAULT 0 ,
 `company_subscription_active_date` datetime NULL ,
 `company_updated`                  timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
 `company_created`                  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `company_status`                   TINYINT DEFAULT 1 ,
 `company_complete`                 TINYINT DEFAULT 0 ,

PRIMARY KEY (`company_id`)
);


-- ***************************************************;
-- DROP TABLE IF EXISTS `offices`;

-- ************************************** `offices`

CREATE TABLE IF NOT EXISTS `offices`
(
 `office_id`         BIGINT NOT NULL AUTO_INCREMENT ,
 `user_id`           bigint NULL ,
 `company_id`        bigint NOT NULL ,
 `office_name`       varchar(255) NULL ,
 `office_slug`       varchar(255) NULL ,
 `office_short`      varchar(255) NULL ,
 `office_address`    TEXT ,
 `office_telephone`  varchar(255) NULL ,
 `office_phone`      varchar(255) NULL ,
 `office_updated`    timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
 `office_created`    datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `office_status`     TINYINT DEFAULT 1 ,

PRIMARY KEY (`office_id`)
);


-- ***************************************************;
-- DROP TABLE IF EXISTS `users`;

-- ************************************** `users`

CREATE TABLE IF NOT EXISTS `users`
(
  `user_id`            bigint NOT NULL AUTO_INCREMENT ,
  `company_id`         bigint NOT NULL ,
  `office_id`          bigint NOT NULL ,
  `username`           varchar(45) NULL ,
  `email`              char(94) NULL ,
  `password`           varchar(255) NULL ,
  `name`               varchar(45) NULL ,
  `last_name`          varchar(45) NULL ,
  `gender`             TINYTEXT NULL ,
  `contact_number`     VARCHAR(45) NULL ,
  `alt_contact_number` VARCHAR(45) NULL ,
  `user_position`      VARCHAR(45) NULL ,
  `user_description`	 TEXT ,
  `user_province`      VARCHAR(45) NULL ,
  `user_listpos`			 TINYINT(1) NOT NULL DEFAULT 0 ,
  `last_seen`          datetime NULL ,
  `user_type`          tinytext NULL ,
  `user_type_id`       BIGINT NOT NULL DEFAULT 0,
  `user_image`         varchar(45) DEFAULT 'profile.png' ,
  `user_status`			   TINYINT(1) NOT NULL DEFAULT 1 ,
  `email_confirm`      tinyint DEFAULT 0 ,
  `user_is_checker`    tinyint DEFAULT 0 ,
  `email_confirm_code` varchar(255) NULL ,
  `pass_reset_code`    varchar(255) NULL ,
  `pass_reset_date`    datetime NULL ,
  `date_created`       datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `date_updated`       timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,

PRIMARY KEY (`user_id`)
);


-- ************************************** `user_types`
-- DROP TABLE IF EXISTS `user_types`;

-- ************************************** `user_types`

CREATE TABLE IF NOT EXISTS `user_types`
(
  `user_type_id`        BIGINT NOT NULL AUTO_INCREMENT ,
  `user_id`             bigint NULL ,
  `company_id`          bigint NOT NULL ,
  `user_type`           VARCHAR(45) NOT NULL ,
  `user_type_slug`      VARCHAR(45) NOT NULL ,
  `user_type_admin`     TINYINT DEFAULT 0 ,
  `permission_execute`  TINYINT DEFAULT 0 ,
  `permission_write`    TINYINT DEFAULT 0 ,
  `permission_read`     TINYINT DEFAULT 0 ,
  `user_type_default`   TINYINT DEFAULT 0 ,
  `user_type_status`    TINYINT DEFAULT 1 ,
  `date_updated`        timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  `date_created`        datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,

PRIMARY KEY (`user_type_id`)
);



-- ***************************************************;
-- DROP TABLE IF EXISTS `orders`;

-- ***** AUTO_INCREMENT
-- ALTER TABLE orders AUTO_INCREMENT=1000;

-- ************************************** `orders`

CREATE TABLE IF NOT EXISTS `orders`
(
 `order_id`               bigint NOT NULL AUTO_INCREMENT ,
 `user_id`                bigint NULL,
 `event_id`               bigint NOT NULL,
 `username`               varchar(255) NULL ,
 `order_confirmation`     tinyint NULL DEFAULT 0 ,
 `payment_method`         varchar(45) NULL ,
 `payment_type`           varchar(45) NULL ,
 `delivery_method`        varchar(45) NULL ,
 `delivery_comment`       text NULL ,
 `shipping_option_id`     int(11) DEFAULT NULL,
 `delivery_address_id`    bigint NULL,
 `collection_address_id`  bigint NULL,
 `confirmation_code`      varchar(45) DEFAULT NULL ,
 `order_amount`           float(11,2) DEFAULT NULL,
 `order_amount_net`       float(11,2) DEFAULT NULL ,
 `order_amount_fee`       float(11,2) DEFAULT NULL ,
 `order_payment_id`       varchar(255) DEFAULT NULL ,
 `order_token`            varchar(255) DEFAULT NULL ,
 `order_track_code`       varchar(255) DEFAULT NULL ,
 `order_status`           tinyint NOT NULL DEFAULT 0 ,
 `order_collected`        tinyint NOT NULL DEFAULT 0 ,
 `order_collection_hub`   tinyint NOT NULL DEFAULT 0 ,
 `order_enroute`          tinyint NOT NULL DEFAULT 0 ,
 `order_delivery_hub`     tinyint NOT NULL DEFAULT 0 ,
 `order_ondelivery`       tinyint NOT NULL DEFAULT 0 ,
 `order_delivered`        tinyint(4) NOT NULL DEFAULT 0 ,
 `order_complete`         tinyint(4) NOT NULL DEFAULT 0 ,
 `order_cancel`           tinyint NOT NULL DEFAULT 0 ,
 `order_message`          text DEFAULT NULL ,
 `order_cancel_message`   text DEFAULT NULL ,
 `order_payment_status`   tinyint NOT NULL DEFAULT 0 ,
 `order_billing_date`     datetime DEFAULT NULL,
 `order_date`             datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `update_date`            timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,

PRIMARY KEY (`order_id`)
);


-- ***************************************************;
-- DROP TABLE IF EXISTS `countries`;

-- ************************************** `countries`
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso3` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numeric_code` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso2` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phonecode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capital` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tld` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `native` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subregion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `translations` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `emoji` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emojiU` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `wikiDataId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Rapid API GeoDB Cities',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- ***************************************************;
-- DROP TABLE IF EXISTS `notifications`;


-- ************************************** `notifications`

CREATE TABLE IF NOT EXISTS `notifications`
(
 `notification_id`              bigint NOT NULL AUTO_INCREMENT ,
 `user_id`                      bigint NULL ,
 `company_id`                   bigint NOT NULL ,
 `user_type`                    tinyint NOT NULL DEFAULT 0 ,
 `notification_alt_id`          bigint NULL ,
 `notification_database`        varchar(90) ,
 `notification_database_id`     bigint NULL ,
 `notification_type`            tinyint NOT NULL DEFAULT 0 ,
 `notification_read_status`     tinyint NOT NULL DEFAULT 0 ,
 `notification_message`         TEXT ,
 `notification_message_index`   TEXT ,
 `notification_status`          tinyint NOT NULL DEFAULT 1 ,
 `notification_created_date`    datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `notification_updated_date`    timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,

  PRIMARY KEY (`notification_id`)
);


-- ***************************************************;
-- DROP TABLE IF EXISTS `departments`;

-- ************************************** `departments`

CREATE TABLE IF NOT EXISTS `departments`
(
 `department_id`              BIGINT NOT NULL AUTO_INCREMENT ,
 `user_id`                    bigint NULL ,
 `company_id`                 bigint NOT NULL ,
 `office_id`                  bigint NULL ,
 `department_name`            varchar(255) NULL ,
 `department_slug`            varchar(255) NULL ,
 `department_type`            TINYINT DEFAULT 0 ,
 `department_date_updated`    timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
 `department_date_created`    datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `department_status`          TINYINT DEFAULT 1 ,

PRIMARY KEY (`department_id`)
);


-- ***************************************************;
-- DROP TABLE IF EXISTS `tasks`;

-- ************************************** `tasks`

CREATE TABLE IF NOT EXISTS `tasks`
(
 `task_id`                BIGINT NOT NULL AUTO_INCREMENT ,
 `user_id`                bigint NULL ,
 `company_id`             bigint NULL ,
 `assigned_to`            bigint NULL ,
 `task_checker`           bigint NULL ,
 `task_admins`            TEXT ,
 `category_id`            bigint NOT NULL ,
 `department_id`          bigint NOT NULL ,
 `task_name`              varchar(255) NULL ,
 `task_text`              TEXT ,
 `task_priority`          ENUM('low', 'medium', 'high') NOT NULL DEFAULT 'medium',
 `task_slug`              varchar(255) NULL ,
 `task_completed`         tinyint NOT NULL DEFAULT 0 ,
 `task_sms`               varchar(255) NULL ,
 `task_email`             varchar(255) NULL ,
 `task_sms_text`          varchar(255) NULL ,
 `task_email_text`        varchar(255) NULL ,
 `task_type`              TINYINT DEFAULT 0 ,
 `task_deadline`          datetime NULL ,
 `task_date_updated`      timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
 `task_date_created`      datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `task_status`            TINYINT DEFAULT 1 ,

FOREIGN KEY (`assigned_to`) REFERENCES users(`user_id`),
PRIMARY KEY (`task_id`)
);


-- ***************************************************;
-- DROP TABLE IF EXISTS `activity_tasks`;

-- ************************************** `activity_tasks`

CREATE TABLE IF NOT EXISTS `activity_tasks`
(
 `activity_task_id`          BIGINT NOT NULL AUTO_INCREMENT ,
 `user_id`                   bigint NULL ,
 `category_id`               bigint NULL ,
 `client_association_id`     bigint NOT NULL ,
 `task_id`                   bigint NOT NULL ,
 `activity_task`             TEXT ,
 `activity_task_date`        varchar(255) NULL ,
 `activity_task_type`        TINYINT DEFAULT 0 ,
 `activity_task_updated`     timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
 `activity_task_created`     datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `activity_task_status`      TINYINT DEFAULT 1 ,

PRIMARY KEY (`activity_task_id`)
);


-- ***************************************************;
-- DROP TABLE IF EXISTS `task_dependencies`;

-- ************************************** `task_dependencies`

CREATE TABLE IF NOT EXISTS `task_dependencies`
(
 `dependency_id`                    BIGINT NOT NULL AUTO_INCREMENT ,
 `user_id`                          bigint NULL ,
 `task_id`                          bigint NULL ,
 `task_dependency_id`               bigint NULL ,
 `dependency`                       varchar(255) NULL ,
 `dependency_date_updated`          timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
 `dependency_date_created`          datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `dependency_status`                TINYINT DEFAULT 1 ,

PRIMARY KEY (`dependency_id`)
);


-- ***************************************************;
-- DROP TABLE IF EXISTS `task_categories`;

-- ************************************** `task_categories`

CREATE TABLE IF NOT EXISTS `task_categories`
(
 `category_id`                      BIGINT NOT NULL AUTO_INCREMENT ,
 `user_id`                          bigint NULL ,
 `company_id`                       bigint NULL ,
 `category`                         varchar(255) NULL ,
 `category_slug`                    varchar(255) NULL ,
 `category_date_updated`            timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
 `category_date_created`            datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `category_status`                  TINYINT DEFAULT 1 ,

PRIMARY KEY (`category_id`)
);


-- ***************************************************;
-- DROP TABLE IF EXISTS `attachments`;

-- ************************************** `attachments`

CREATE TABLE IF NOT EXISTS `attachments`
(
 `attachment_id`                    BIGINT NOT NULL AUTO_INCREMENT ,
 `user_id`                          bigint NULL ,
 `task_id`                          bigint NULL ,
 `attachment`                       varchar(255) NULL ,
 `attachment_path`                  varchar(255) NULL ,
 `attachment_date_updated`          timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
 `attachment_date_created`          datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `attachment_status`                TINYINT DEFAULT 1 ,

PRIMARY KEY (`attachment_id`)
);


-- ***************************************************;
-- DROP TABLE IF EXISTS `events`;

-- ************************************** `events`

CREATE TABLE IF NOT EXISTS `events`
(
 `event_id`             bigint NOT NULL AUTO_INCREMENT ,
 `user_id`              bigint NULL ,
 `event_title`          varchar (255) NULL ,
 `event_description`    text NULL ,
 `event_user_name`      varchar (255) NULL ,
 `event_last_name`      varchar (255) NULL ,
 `event_user_email`     varchar (255) NULL ,
 `event_user_phone`     varchar (255) NULL ,
 `event_alt_user_name`  varchar (255) NULL ,
 `event_alt_last_name`  varchar (255) NULL ,
 `event_alt_user_email` varchar (255) NULL ,
 `event_alt_user_phone` varchar (255) NULL ,
 `event_company_name`   varchar (255) NULL ,
 `event_budget`         varchar (255) NULL ,
 `event_venue`          varchar (255) NULL ,
 `event_user_count`     INTEGER (11) NULL ,
 `event_price`          varchar (255) NULL ,
 `event_town`           varchar (255) NULL ,
 `event_city`           varchar (255) NULL ,
 `event_province`       varchar (255) NULL ,
 `event_country`        varchar (255) NULL ,
 `event_occupation`     varchar (255) NULL ,
 `event_address`        text NULL ,
 `collection_addresss`  text NULL ,
 `delivery_address`     text NULL ,
 `event_message`        text NULL ,
 `event_processed`      tinyint NOT NULL DEFAULT 0 ,
 `event_status`         tinyint default 1 ,
 `event_period`         tinytext NULL ,
 `event_type`           tinytext NULL ,
 `event_begin_date`     datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `event_end_date`       datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `event_host_date`      datetime NULL DEFAULT CURRENT_TIMESTAMP ,
 `event_date_created`   datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `event_date_updated`   timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,

PRIMARY KEY (`event_id`),
KEY `fkIdx_1064` (`user_id`),
CONSTRAINT `FK_1064` FOREIGN KEY `fkIdx_1064` (`user_id`) REFERENCES `users` (`user_id`)
);




-- ***************************************************;
-- DROP TABLE IF EXISTS `task_history`;

-- ************************************** `task_history`

CREATE TABLE IF NOT EXISTS `task_history`
(
 `task_history_id`                  BIGINT NOT NULL AUTO_INCREMENT ,
 `user_id`                          bigint NULL ,
 `task_id`                          bigint NULL ,
 `company_id`                       bigint NULL ,
 `activity_type`                    ENUM('creation', 'update', 'assignment', 'completion', 'comment', 'attachment') NOT NULL,
 `details`                          TEXT ,
 `history_date_updated`             timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
 `history_date_created`             datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `history_status`                   TINYINT DEFAULT 1 ,

PRIMARY KEY (`task_history_id`)
);


-- ************************************** `insert companies`

INSERT INTO `companies` (`company_id`, `user_id`, `company_name`, `company_slug`) VALUES (1, 1, 'Default Company', 'default_company')

ON DUPLICATE KEY UPDATE
user_id             = VALUES (user_id),
company_name        = VALUES (company_name),
company_slug        = VALUES (company_slug)
;

-- ***************************************************;

INSERT INTO `users` (`user_id`, `company_id`, `office_id`, `user_type_id`, `user_type`, `username`, `email`, `password`, `name`, `last_name`, `last_seen`, `date_created`, `date_updated`, `user_status`) VALUES (1, 1, 1, 1, 'sys_admin', 'admin', 'info@tralon.co.za', '$2y$12$7ckh0OcRipJe7q2R0me/M.NPoPT6SyJIomXYXRD7skjT0TXg51RMu', 'Admin', '', '2020-01-02 06:55:27', '2020-01-02 00:00:00', '2020-01-02 00:00:00', 1)

ON DUPLICATE KEY UPDATE
user_type = VALUES (user_type),
username  = VALUES (username),
email     = VALUES (email),
password  = VALUES (password),
name      = VALUES (name),
last_name = VALUES (last_name)
;

-- ************************************** `insert user_types`

INSERT INTO `user_types` (`user_type_id`, `company_id`, `user_type`, `user_type_slug`, `user_type_default`,`user_type_admin`,`permission_execute`, `permission_write`, `permission_read`) VALUES (1, 1, 'administrator', 'admin',1,1,1,1,1), (2, 1, 'Guest', 'guest',1,0,0,0,1)

ON DUPLICATE KEY UPDATE
user_type_id        = VALUES (user_type_id),
company_id          = VALUES (company_id),
user_type           = VALUES (user_type),
user_type_slug      = VALUES (user_type_slug),
user_type_default   = VALUES (user_type_default),
user_type_admin     = VALUES (user_type_admin),
permission_execute  = VALUES (permission_execute),
permission_write    = VALUES (permission_write),
permission_read     = VALUES (permission_read)
;

-- ***************************************************;
-- DROP TABLE IF EXISTS `settings`;

-- ************************************** `settings`

CREATE TABLE IF NOT EXISTS `settings`
(
 `setting_id`           bigint NOT NULL AUTO_INCREMENT ,
 `user_id`              bigint NULL ,
 `subscription_popup`   tinyint NOT NULL DEFAULT 0 ,
 `subscription_active`  tinyint NOT NULL DEFAULT 0 ,
 `article_email_length` tinyint NOT NULL DEFAULT 0 ,
 `setting_email_header` text NOT NULL ,
 `setting_email_footer` text NOT NULL ,
 `setting_date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `setting_date_updated` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,

PRIMARY KEY (`setting_id`)
);
