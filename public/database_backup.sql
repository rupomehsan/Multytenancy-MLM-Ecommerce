

CREATE TABLE `about_us` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `banner_bg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_sub_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_description` longtext COLLATE utf8mb4_unicode_ci,
  `btn_icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btn_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btn_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `ac_accounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `count_id` bigint unsigned DEFAULT NULL,
  `store_id` bigint unsigned DEFAULT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `sort_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` double(20,4) DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `short_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_time` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_ip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_bit` bigint unsigned DEFAULT NULL,
  `account_selection_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paymenttypes_id` bigint unsigned DEFAULT NULL,
  `expense_id` bigint unsigned DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO ac_accounts (id, count_id, store_id, parent_id, sort_code, account_name, account_code, balance, note, supplier_id, customer_id, short_code, created_time, system_ip, system_name, delete_bit, account_selection_name, paymenttypes_id, expense_id, creator, slug, status, created_at, updated_at) VALUES ('1','','','','','asset','1','','','','','','','','','','','','','','','active','','');

INSERT INTO ac_accounts (id, count_id, store_id, parent_id, sort_code, account_name, account_code, balance, note, supplier_id, customer_id, short_code, created_time, system_ip, system_name, delete_bit, account_selection_name, paymenttypes_id, expense_id, creator, slug, status, created_at, updated_at) VALUES ('2','','','','','liability','2','','','','','','','','','','','','','','','active','','');

INSERT INTO ac_accounts (id, count_id, store_id, parent_id, sort_code, account_name, account_code, balance, note, supplier_id, customer_id, short_code, created_time, system_ip, system_name, delete_bit, account_selection_name, paymenttypes_id, expense_id, creator, slug, status, created_at, updated_at) VALUES ('3','','','','','owner_equity','3','','','','','','','','','','','','','','','active','','');

INSERT INTO ac_accounts (id, count_id, store_id, parent_id, sort_code, account_name, account_code, balance, note, supplier_id, customer_id, short_code, created_time, system_ip, system_name, delete_bit, account_selection_name, paymenttypes_id, expense_id, creator, slug, status, created_at, updated_at) VALUES ('4','','','','','revenue','4','','','','','','','','','','','','','','','active','','');

INSERT INTO ac_accounts (id, count_id, store_id, parent_id, sort_code, account_name, account_code, balance, note, supplier_id, customer_id, short_code, created_time, system_ip, system_name, delete_bit, account_selection_name, paymenttypes_id, expense_id, creator, slug, status, created_at, updated_at) VALUES ('5','','','','','expense','5','','','','','','','','','','','','','','','active','','');


CREATE TABLE `ac_money_deposits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `deposit_date` date DEFAULT NULL,
  `reference_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_account_id` bigint unsigned DEFAULT NULL,
  `credit_account_id` bigint unsigned DEFAULT NULL,
  `amount` double(20,4) DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_time` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_ip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `ac_money_transfers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `count_id` bigint unsigned DEFAULT NULL,
  `transfer_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `reference_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_account_id` bigint unsigned DEFAULT NULL,
  `credit_account_id` bigint unsigned DEFAULT NULL,
  `amount` double(20,4) DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_time` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_ip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `ac_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `payment_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `transaction_type` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_account_id` bigint unsigned DEFAULT NULL,
  `credit_account_id` bigint unsigned DEFAULT NULL,
  `debit_amt` double(20,4) DEFAULT NULL,
  `credit_amt` double(20,4) DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `ref_accounts_id` bigint unsigned DEFAULT NULL,
  `ref_moneytransfer_id` bigint unsigned DEFAULT NULL,
  `ref_moneydeposits_id` bigint unsigned DEFAULT NULL,
  `ref_salespayments_id` bigint unsigned DEFAULT NULL,
  `ref_salespaymentsreturn_id` bigint unsigned DEFAULT NULL,
  `ref_purchasepayments_id` bigint unsigned DEFAULT NULL,
  `ref_purchasepaymentsreturn_id` bigint unsigned DEFAULT NULL,
  `ref_expense_id` bigint unsigned DEFAULT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `short_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `account_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_type_id` bigint unsigned NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_groups_code_unique` (`code`),
  KEY `account_groups_account_type_id_foreign` (`account_type_id`),
  CONSTRAINT `account_groups_account_type_id_foreign` FOREIGN KEY (`account_type_id`) REFERENCES `account_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('1','Furniture & Fixtures','1101001000','1','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('2','Office Equipment','1101002000','1','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('3','Computer & Computer Equipment','1101003000','1','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('4','Software Development','1101004000','1','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('5','Motor Vehicles','1101005000','1','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('6','Land & Buildings','1101006000','1','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('7','Cash in Hand','1101007000','1','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('8','Cash at Bank','1101008000','1','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('9','Account Receivable','1101009000','1','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('10','Advance','1101010000','1','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('11','Other Fixed Assets','1101011000','1','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('12','Capital Fund/Equity','2001001000','2','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('13','Long-term Liabilities','2001002000','2','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('14','Current Liabilities','2001003000','2','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('15','Accounts Payable','2001004000','2','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('16','Loans & Advances','2001005000','2','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('17','Operating Income','3001000000','3','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('18','Non-Operating Income','3001001000','3','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('19','Operating Expenses','4001000000','4','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('20','Administrative Expenses','4001001000','4','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('21','Marketing Expenses','4001002000','4','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('22','Cost of Goods Sold','4001003000','4','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('23','Financial Expenses','4001004000','4','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('24','Program Cost','4001005000','4','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('25','VAT','4001006000','4','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('26','Income Tax','4001007000','4','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('27','Transportation & Communication','4001008000','4','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');

INSERT INTO account_groups (id, name, code, account_type_id, note, status, created_at, updated_at, deleted_at) VALUES ('28','Other Expenses','4001009000','4','','1','2025-12-02 14:59:24','2025-12-02 14:59:24','');


CREATE TABLE `account_subsidiary_ledgers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ledger_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` bigint unsigned NOT NULL,
  `account_type_id` bigint unsigned NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_subsidiary_ledgers_ledger_code_unique` (`ledger_code`),
  KEY `account_subsidiary_ledgers_group_id_foreign` (`group_id`),
  KEY `account_subsidiary_ledgers_account_type_id_foreign` (`account_type_id`),
  CONSTRAINT `account_subsidiary_ledgers_account_type_id_foreign` FOREIGN KEY (`account_type_id`) REFERENCES `account_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `account_subsidiary_ledgers_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `account_groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('1','Desktop Computer','1101003001','3','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('2','Laptop','1101003002','3','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('3','Printer','1101003003','3','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('4','Scanner','1101003004','3','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('5','Fax Machine','1101003005','3','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('6','Other Computer Equipment','1101003006','3','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('7','Software Development','1101004001','4','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('8','Inventory','1101005001','5','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('9','Cash','1101007001','7','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('10','Bkash Mobile Banking Account','1101008001','8','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('11','Nogod Mobile Banking Account','1101008002','8','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('12','Rocket Mobile Banking Account','1101008003','8','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('13','DBBL','1101008004','8','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('14','Customer Receivable','1101009001','9','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('15','Advance Payment to Supplier','1101010001','10','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('16','Advance Payment to Customer','1101010002','10','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('17','Other Advance Payment','1101010003','10','1','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('18','Retained Surplus','2001001001','12','2','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('19','Capital Fund - Share Capital','2001001002','12','2','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('20','Capital Fund - Share Premium','2001001003','12','2','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('21','Shareholder's Drawings','2001001004','12','2','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('22','Bank Loan','2001002001','13','2','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('23','Other Long-term Liabilities','2001002002','13','2','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('24','Supplier Payable','2001003001','14','2','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('25','Loans & Advances','2001005001','16','2','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('26','Sales','3001000001','17','3','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('27','Sales of Services','3001000002','17','3','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('28','Wages Sales','3001001001','18','3','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('29','Delivery Charges','3001001002','18','3','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('30','Brokerage Income','3001001003','18','3','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('31','Cost Sharing / Overhead','3001001004','18','3','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('32','Miscellaneous Income','3001001005','18','3','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('33','Other Income','3001001006','18','3','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('34','Manufacturing Expenses','4001000001','19','4','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('35','Raw Materials','4001001001','20','4','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('36','Work-in-Progress','4001002001','21','4','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('37','Wages','4001003001','22','4','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('38','Packaging','4001004001','23','4','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('39','Depreciation','4001005001','24','4','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('40','VAT','4001006001','25','4','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('41','Bank Charges','4001007001','26','4','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('42','Income Tax','4001008001','27','4','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_subsidiary_ledgers (id, name, ledger_code, group_id, account_type_id, status, created_at, updated_at) VALUES ('43','Rent & Lease','4001009001','28','4','1','2025-12-02 14:59:24','2025-12-02 14:59:24');


CREATE TABLE `account_transaction_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `acc_transaction_id` bigint unsigned NOT NULL,
  `dr_adjust_trans_id` int NOT NULL DEFAULT '0',
  `dr_adjust_voucher_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dr_adjust_voucher_date` date DEFAULT NULL,
  `cr_adjust_trans_id` int NOT NULL DEFAULT '0',
  `cr_adjust_voucher_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cr_adjust_voucher_date` date DEFAULT NULL,
  `dr_gl_ledger` int NOT NULL,
  `dr_sub_ledger` int NOT NULL,
  `cr_gl_ledger` int NOT NULL,
  `cr_sub_ledger` int NOT NULL,
  `ref_sub_ledger` int NOT NULL DEFAULT '0',
  `amount` double(11,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `valid` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_transaction_details_acc_transaction_id_foreign` (`acc_transaction_id`),
  CONSTRAINT `account_transaction_details_acc_transaction_id_foreign` FOREIGN KEY (`acc_transaction_id`) REFERENCES `account_transactions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `account_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `voucher_no` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher_int_no` int NOT NULL,
  `auto_voucher` tinyint NOT NULL DEFAULT '0',
  `amount` double(11,2) NOT NULL,
  `comments` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trans_date` date NOT NULL,
  `trans_type` tinyint NOT NULL COMMENT '1=Payment Transaction, 2=Receive Transaction, 3=Journal Voucher',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `valid` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `account_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_types_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO account_types (id, name, code, status, created_at, updated_at) VALUES ('1','PROPERTY AND ASSETS','1000000000','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_types (id, name, code, status, created_at, updated_at) VALUES ('2','LIABILITY AND CAPITAL','2000000000','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_types (id, name, code, status, created_at, updated_at) VALUES ('3','INCOME/REVENUE/SALES','3000000000','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO account_types (id, name, code, status, created_at, updated_at) VALUES ('4','EXPENSES/COST OF GOODS SOLD','4000000000','1','2025-12-02 14:59:24','2025-12-02 14:59:24');


CREATE TABLE `accounts_configurations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accounts_configurations_account_code_unique` (`account_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `banners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint NOT NULL DEFAULT '1' COMMENT '1=>Sliders; 2=>Banners',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btn_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btn_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `serial` double NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `billing_addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thana` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `blog_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>Active; 0=>Inactive',
  `featured` tinyint NOT NULL DEFAULT '0' COMMENT '0=>Not Featured; 1=>Featured',
  `serial` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `blogs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` mediumtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0=>Inactive; 1=>Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categories` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcategories` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` tinyint NOT NULL DEFAULT '0' COMMENT '0=> Not Featured; 1=> Featured',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0=> Inactive; 1=> Active',
  `serial` tinyint NOT NULL DEFAULT '1',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_unique_cart_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `color_id` bigint unsigned DEFAULT NULL COMMENT 'Variant',
  `size_id` bigint unsigned DEFAULT NULL COMMENT 'Variant',
  `region_id` bigint unsigned DEFAULT NULL COMMENT 'Variant',
  `sim_id` bigint unsigned DEFAULT NULL COMMENT 'Variant',
  `storage_id` bigint unsigned DEFAULT NULL COMMENT 'Variant',
  `warrenty_id` bigint unsigned DEFAULT NULL COMMENT 'Variant',
  `device_condition_id` bigint unsigned DEFAULT NULL COMMENT 'Variant',
  `unit_id` bigint unsigned DEFAULT NULL,
  `qty` double NOT NULL,
  `unit_price` double NOT NULL,
  `total_price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>Active; 0=>Inactive',
  `featured` tinyint NOT NULL DEFAULT '0' COMMENT '0=>Not Featured; 1=>Featured',
  `show_on_navbar` tinyint NOT NULL DEFAULT '1' COMMENT '1=>Yes; 0=>No',
  `serial` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `child_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `subcategory_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>Active; 0=>Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `colors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `colors_name_unique` (`name`),
  UNIQUE KEY `colors_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `config_setups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `industry` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>Active; 0=>Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `contact_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>Not Served; 1=>Served',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `custom_pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>Active; 0=>Inactive',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `customer_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `customer_contact_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned DEFAULT NULL,
  `employee_id` bigint unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `contact_history_status` enum('planned','held','not_held') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'planned',
  `priority` enum('low','normal','medium','high','urgent','immediate') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `customer_next_contact_dates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned DEFAULT NULL,
  `next_date` date DEFAULT NULL,
  `contact_status` enum('pending','missed','done') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `customer_source_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_category_id` bigint unsigned DEFAULT NULL,
  `customer_source_type_id` bigint unsigned DEFAULT NULL,
  `reference_by` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `db_customer_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `orderpayment_id` bigint unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment` double(10,2) DEFAULT NULL,
  `payment_note` text COLLATE utf8mb4_unicode_ci,
  `created_time` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_ip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `db_expense_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `category_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `db_expenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `count_id` bigint unsigned DEFAULT NULL,
  `expense_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `expense_date` date DEFAULT NULL,
  `reference_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expense_for` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expense_amt` double(20,4) DEFAULT NULL,
  `payment_type_id` bigint unsigned DEFAULT NULL,
  `account_id` bigint unsigned DEFAULT NULL,
  `credit_account_id` bigint unsigned DEFAULT NULL,
  `debit_account_id` bigint unsigned DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_time` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_ip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `db_payment_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `payment_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment` double(20,4) DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `db_purchase_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `count_id` bigint unsigned DEFAULT NULL,
  `payment_code` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_id` bigint unsigned DEFAULT NULL,
  `purchase_id` bigint unsigned DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment` double(20,4) DEFAULT NULL,
  `payment_note` text COLLATE utf8mb4_unicode_ci,
  `created_time` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_ip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` bigint unsigned DEFAULT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `short_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `db_supplier_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchasepayment_id` bigint unsigned DEFAULT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment` double(20,4) DEFAULT NULL,
  `payment_note` text COLLATE utf8mb4_unicode_ci,
  `created_time` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_ip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `db_suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `count_id` bigint unsigned DEFAULT NULL,
  `supplier_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gstin` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vatin` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opening_balance` double(20,4) DEFAULT NULL,
  `purchase_due` double(20,4) DEFAULT NULL,
  `purchase_return_due` double(20,4) DEFAULT NULL,
  `country_id` bigint unsigned DEFAULT NULL,
  `state_id` bigint unsigned DEFAULT NULL,
  `city` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `system_ip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_time` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` bigint unsigned DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `db_taxes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned DEFAULT NULL,
  `tax_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax` double(20,4) DEFAULT NULL,
  `group_bit` int DEFAULT NULL,
  `subtax_ids` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `device_conditions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `districts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `division_id` int NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lon` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_charge` double(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('1','1','Comilla','কুমিল্লা','23.4682747','91.1788135','www.comilla.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('2','1','Feni','ফেনী','23.023231','91.3840844','www.feni.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('3','1','Brahmanbaria','ব্রাহ্মণবাড়িয়া','23.9570904','91.1119286','www.brahmanbaria.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('4','1','Rangamati','রাঙ্গামাটি','22.65561018','92.17541121','www.rangamati.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('5','1','Noakhali','নোয়াখালী','22.869563','91.099398','www.noakhali.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('6','1','Chandpur','চাঁদপুর','23.2332585','90.6712912','www.chandpur.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('7','1','Lakshmipur','লক্ষ্মীপুর','22.942477','90.841184','www.lakshmipur.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('8','1','Chattogram','চট্টগ্রাম','22.335109','91.834073','www.chittagong.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('9','1','Coxsbazar','কক্সবাজার','21.44315751','91.97381741','www.coxsbazar.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('10','1','Khagrachhari','খাগড়াছড়ি','23.119285','91.984663','www.khagrachhari.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('11','1','Bandarban','বান্দরবান','22.1953275','92.2183773','www.bandarban.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('12','2','Sirajganj','সিরাজগঞ্জ','24.4533978','89.7006815','www.sirajganj.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('13','2','Pabna','পাবনা','23.998524','89.233645','www.pabna.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('14','2','Bogura','বগুড়া','24.8465228','89.377755','www.bogra.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('15','2','Rajshahi','রাজশাহী','24.37230298','88.56307623','www.rajshahi.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('16','2','Natore','নাটোর','24.420556','89.000282','www.natore.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('17','2','Joypurhat','জয়পুরহাট','25.09636876','89.04004280','www.joypurhat.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('18','2','Chapainawabganj','চাঁপাইনবাবগঞ্জ','24.5965034','88.2775122','www.chapainawabganj.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('19','2','Naogaon','নওগাঁ','24.83256191','88.92485205','www.naogaon.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('20','3','Jashore','যশোর','23.16643','89.2081126','www.jessore.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('21','3','Satkhira','সাতক্ষীরা','22.7180905','89.0687033','www.satkhira.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('22','3','Meherpur','মেহেরপুর','23.762213','88.631821','www.meherpur.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('23','3','Narail','নড়াইল','23.172534','89.512672','www.narail.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('24','3','Chuadanga','চুয়াডাঙ্গা','23.6401961','88.841841','www.chuadanga.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('25','3','Kushtia','কুষ্টিয়া','23.901258','89.120482','www.kushtia.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('26','3','Magura','মাগুরা','23.487337','89.419956','www.magura.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('27','3','Khulna','খুলনা','22.815774','89.568679','www.khulna.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('28','3','Bagerhat','বাগেরহাট','22.651568','89.785938','www.bagerhat.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('29','3','Jhenaidah','ঝিনাইদহ','23.5448176','89.1539213','www.jhenaidah.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('30','4','Jhalakathi','ঝালকাঠি','22.6422689','90.2003932','www.jhalakathi.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('31','4','Patuakhali','পটুয়াখালী','22.3596316','90.3298712','www.patuakhali.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('32','4','Pirojpur','পিরোজপুর','22.5781398','89.9983909','www.pirojpur.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('33','4','Barisal','বরিশাল','22.7004179','90.3731568','www.barisal.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('34','4','Bhola','ভোলা','22.685923','90.648179','www.bhola.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('35','4','Barguna','বরগুনা','22.159182','90.125581','www.barguna.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('36','5','Sylhet','সিলেট','24.8897956','91.8697894','www.sylhet.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('37','5','Moulvibazar','মৌলভীবাজার','24.482934','91.777417','www.moulvibazar.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('38','5','Habiganj','হবিগঞ্জ','24.374945','91.41553','www.habiganj.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('39','5','Sunamganj','সুনামগঞ্জ','25.0658042','91.3950115','www.sunamganj.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('40','6','Narsingdi','নরসিংদী','23.932233','90.71541','www.narsingdi.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('41','6','Gazipur','গাজীপুর','24.0022858','90.4264283','www.gazipur.gov.bd','90','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('42','6','Shariatpur','শরীয়তপুর','23.2060195','90.3477725','www.shariatpur.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('43','6','Narayanganj','নারায়ণগঞ্জ','23.63366','90.496482','www.narayanganj.gov.bd','90','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('44','6','Tangail','টাঙ্গাইল','24.264145','89.918029','www.tangail.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('45','6','Kishoreganj','কিশোরগঞ্জ','24.444937','90.776575','www.kishoreganj.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('46','6','Manikganj','মানিকগঞ্জ','23.8602262','90.0018293','www.manikganj.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('47','6','Dhaka','ঢাকা','23.7115253','90.4111451','www.dhaka.gov.bd','70','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('48','6','Munshiganj','মুন্সিগঞ্জ','23.5435742','90.5354327','www.munshiganj.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('49','6','Rajbari','রাজবাড়ী','23.7574305','89.6444665','www.rajbari.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('50','6','Madaripur','মাদারীপুর','23.164102','90.1896805','www.madaripur.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('51','6','Gopalganj','গোপালগঞ্জ','23.0050857','89.8266059','www.gopalganj.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('52','6','Faridpur','ফরিদপুর','23.6070822','89.8429406','www.faridpur.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('53','7','Panchagarh','পঞ্চগড়','26.3411','88.5541606','www.panchagarh.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('54','7','Dinajpur','দিনাজপুর','25.6217061','88.6354504','www.dinajpur.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('55','7','Lalmonirhat','লালমনিরহাট','25.9165451','89.4532409','www.lalmonirhat.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('56','7','Nilphamari','নীলফামারী','25.931794','88.856006','www.nilphamari.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('57','7','Gaibandha','গাইবান্ধা','25.328751','89.528088','www.gaibandha.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('58','7','Thakurgaon','ঠাকুরগাঁও','26.0336945','88.4616834','www.thakurgaon.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('59','7','Rangpur','রংপুর','25.7558096','89.244462','www.rangpur.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('60','7','Kurigram','কুড়িগ্রাম','25.805445','89.636174','www.kurigram.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('61','8','Sherpur','শেরপুর','25.0204933','90.0152966','www.sherpur.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('62','8','Mymensingh','ময়মনসিংহ','24.7465670','90.4072093','www.mymensingh.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('63','8','Jamalpur','জামালপুর','24.937533','89.937775','www.jamalpur.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO districts (id, division_id, name, bn_name, lat, lon, url, delivery_charge, created_at, updated_at) VALUES ('64','8','Netrokona','নেত্রকোণা','24.870955','90.727887','www.netrokona.gov.bd','130','2025-12-02 15:14:29','2025-12-02 15:14:29');


CREATE TABLE `divisions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO divisions (id, name, bn_name, url, created_at, updated_at) VALUES ('1','Chattagram','চট্টগ্রাম','www.chittagongdiv.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO divisions (id, name, bn_name, url, created_at, updated_at) VALUES ('2','Rajshahi','রাজশাহী','www.rajshahidiv.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO divisions (id, name, bn_name, url, created_at, updated_at) VALUES ('3','Khulna','খুলনা','www.khulnadiv.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO divisions (id, name, bn_name, url, created_at, updated_at) VALUES ('4','Barisal','বরিশাল','www.barisaldiv.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO divisions (id, name, bn_name, url, created_at, updated_at) VALUES ('5','Sylhet','সিলেট','www.sylhetdiv.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO divisions (id, name, bn_name, url, created_at, updated_at) VALUES ('6','Dhaka','ঢাকা','www.dhakadiv.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO divisions (id, name, bn_name, url, created_at, updated_at) VALUES ('7','Rangpur','রংপুর','www.rangpurdiv.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO divisions (id, name, bn_name, url, created_at, updated_at) VALUES ('8','Mymensingh','ময়মনসিংহ','www.mymensinghdiv.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');


CREATE TABLE `email_configures` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `host` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `port` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_from_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `encryption` tinyint NOT NULL DEFAULT '0' COMMENT '0=>None; 1=>TLS; 2=>SSL',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0=>Inactive; 1=>Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `email_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '1=>Active; 0=>Inactive',
  `serial` double NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `faqs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `fcm_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fcm_tokens_token_unique` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `flags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `featured` tinyint NOT NULL DEFAULT '0' COMMENT '0=>Not Featured; 1=>Featured',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `general_infos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_dark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fav_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tab_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` longtext COLLATE utf8mb4_unicode_ci,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `google_map_link` longtext COLLATE utf8mb4_unicode_ci,
  `footer_copyright_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_checkout` tinyint NOT NULL DEFAULT '1' COMMENT '1=>Enabled; 0=>Disabled',
  `play_store_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_store_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_css` longtext COLLATE utf8mb4_unicode_ci,
  `custom_js` longtext COLLATE utf8mb4_unicode_ci,
  `header_script` longtext COLLATE utf8mb4_unicode_ci,
  `footer_script` longtext COLLATE utf8mb4_unicode_ci,
  `primary_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tertiary_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paragraph_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `border_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` longtext COLLATE utf8mb4_unicode_ci,
  `meta_og_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_og_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_og_description` longtext COLLATE utf8mb4_unicode_ci,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `messenger` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telegram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiktok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pinterest` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `viber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_analytic_status` tinyint NOT NULL DEFAULT '0' COMMENT '1=>Active; 0=>Inactive',
  `google_analytic_tracking_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_tag_manager_status` tinyint NOT NULL DEFAULT '0' COMMENT '1=>Active; 0=>Inactive',
  `google_tag_manager_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_pixel_status` tinyint NOT NULL DEFAULT '0' COMMENT '1=>Active; 0=>Inactive',
  `fb_pixel_app_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_page_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tawk_chat_status` tinyint NOT NULL DEFAULT '0' COMMENT '1=>Active; 0=>Inactive',
  `tawk_chat_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crisp_chat_status` tinyint NOT NULL DEFAULT '0' COMMENT '1=>Active; 0=>Inactive',
  `crisp_website_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `messenger_chat_status` tinyint NOT NULL DEFAULT '0' COMMENT '1=>Active; 0=>Inactive',
  `about_us` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `google_recaptchas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `captcha_site_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `captcha_secret_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '1=>Active; 0=>Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO migrations (id, migration, batch) VALUES ('1','2014_10_12_000000_create_users_table','1');

INSERT INTO migrations (id, migration, batch) VALUES ('2','2014_10_12_100000_create_password_resets_table','1');

INSERT INTO migrations (id, migration, batch) VALUES ('3','2019_12_14_000001_create_personal_access_tokens_table','1');

INSERT INTO migrations (id, migration, batch) VALUES ('4','2023_04_25_112208_create_user_addresses_table','1');

INSERT INTO migrations (id, migration, batch) VALUES ('5','2025_02_11_102226_create_customer_contact_histories_table','2');

INSERT INTO migrations (id, migration, batch) VALUES ('6','2023_04_13_014055_create_contact_requests_table','3');

INSERT INTO migrations (id, migration, batch) VALUES ('7','2025_02_11_102012_create_customer_categories_table','4');

INSERT INTO migrations (id, migration, batch) VALUES ('8','2025_02_11_102208_create_customers_table','5');

INSERT INTO migrations (id, migration, batch) VALUES ('9','2025_02_05_123505_create_customer_source_types_table','6');

INSERT INTO migrations (id, migration, batch) VALUES ('10','2025_02_11_102712_create_customer_next_contact_dates_table','7');

INSERT INTO migrations (id, migration, batch) VALUES ('11','2023_06_04_091502_create_subscribed_users_table','8');

INSERT INTO migrations (id, migration, batch) VALUES ('12','2023_05_04_235947_create_support_tickets_table','9');

INSERT INTO migrations (id, migration, batch) VALUES ('13','2023_05_06_121329_create_support_messages_table','9');

INSERT INTO migrations (id, migration, batch) VALUES ('14','2023_06_01_102605_create_storage_types_table','10');

INSERT INTO migrations (id, migration, batch) VALUES ('15','2023_06_01_152249_create_device_conditions_table','10');

INSERT INTO migrations (id, migration, batch) VALUES ('16','2023_06_11_162544_create_email_configures_table','10');

INSERT INTO migrations (id, migration, batch) VALUES ('17','2023_06_12_142348_create_sms_gateways_table','10');

INSERT INTO migrations (id, migration, batch) VALUES ('18','2023_06_18_163118_create_payment_gateways_table','10');

INSERT INTO migrations (id, migration, batch) VALUES ('19','2023_12_17_125055_create_config_setups_table','10');

INSERT INTO migrations (id, migration, batch) VALUES ('20','2023_04_25_164433_create_wish_lists_table','11');

INSERT INTO migrations (id, migration, batch) VALUES ('21','2025_12_02_100001_create_divisions_table','12');

INSERT INTO migrations (id, migration, batch) VALUES ('22','2025_12_02_100002_create_districts_table','12');

INSERT INTO migrations (id, migration, batch) VALUES ('23','2025_12_02_100003_create_upazilas_table','12');

INSERT INTO migrations (id, migration, batch) VALUES ('24','2025_12_02_100004_create_unions_table','12');

INSERT INTO migrations (id, migration, batch) VALUES ('25','2023_04_14_220155_create_orders_table','13');

INSERT INTO migrations (id, migration, batch) VALUES ('26','2023_04_15_041941_create_order_details_table','13');

INSERT INTO migrations (id, migration, batch) VALUES ('27','2023_04_15_042355_create_shipping_infos_table','13');

INSERT INTO migrations (id, migration, batch) VALUES ('28','2023_04_15_042838_create_billing_addresses_table','13');

INSERT INTO migrations (id, migration, batch) VALUES ('29','2023_04_15_042952_create_order_progress_table','13');

INSERT INTO migrations (id, migration, batch) VALUES ('30','2023_05_01_230425_create_order_payments_table','13');

INSERT INTO migrations (id, migration, batch) VALUES ('31','2023_05_14_224344_create_product_reviews_table','13');

INSERT INTO migrations (id, migration, batch) VALUES ('32','2023_06_04_123251_create_product_variants_table','13');

INSERT INTO migrations (id, migration, batch) VALUES ('33','2023_06_11_115427_create_product_question_answers_table','13');

INSERT INTO migrations (id, migration, batch) VALUES ('34','2025_06_15_105417_create_order_delivey_men_table','13');

INSERT INTO migrations (id, migration, batch) VALUES ('35','2025_06_23_112102_add_invoice_fields_to_orders_table','13');

INSERT INTO migrations (id, migration, batch) VALUES ('36','2025_10_25_110451_add_avg_cost_price_to_order_details_table','13');

INSERT INTO migrations (id, migration, batch) VALUES ('37','2023_04_26_124004_create_promo_codes_table','14');

INSERT INTO migrations (id, migration, batch) VALUES ('38','2023_06_20_111106_create_notifications_table','15');

INSERT INTO migrations (id, migration, batch) VALUES ('39','2023_06_22_130744_create_sms_templates_table','16');

INSERT INTO migrations (id, migration, batch) VALUES ('40','2023_06_25_104544_create_sms_histories_table','16');

INSERT INTO migrations (id, migration, batch) VALUES ('41','2023_04_12_205032_create_general_infos_table','17');

INSERT INTO migrations (id, migration, batch) VALUES ('42','2023_10_05_111305_create_google_recaptchas_table','17');

INSERT INTO migrations (id, migration, batch) VALUES ('43','2023_10_05_114505_create_social_logins_table','17');

INSERT INTO migrations (id, migration, batch) VALUES ('44','2023_10_18_135527_create_about_us_table','17');

INSERT INTO migrations (id, migration, batch) VALUES ('45','2025_01_27_120333_create_product_suppliers_table','18');

INSERT INTO migrations (id, migration, batch) VALUES ('46','2025_01_27_120343_create_product_supplier_contacts_table','18');

INSERT INTO migrations (id, migration, batch) VALUES ('47','2025_02_05_123524_create_supplier_source_types_table','19');

INSERT INTO migrations (id, migration, batch) VALUES ('48','2025_01_27_120223_create_product_warehouses_table','20');

INSERT INTO migrations (id, migration, batch) VALUES ('49','2025_01_27_120240_create_product_warehouse_rooms_table','21');

INSERT INTO migrations (id, migration, batch) VALUES ('50','2025_01_28_102155_create_product_warehouse_room_cartoons_table','22');

INSERT INTO migrations (id, migration, batch) VALUES ('51','2025_10_05_000002_create_mlm_settings_table','23');

INSERT INTO migrations (id, migration, batch) VALUES ('52','2023_03_29_160138_create_categories_table','24');

INSERT INTO migrations (id, migration, batch) VALUES ('53','2023_04_05_180729_create_child_categories_table','25');

INSERT INTO migrations (id, migration, batch) VALUES ('54','2025_06_25_104028_create_package_product_items_table','26');

INSERT INTO migrations (id, migration, batch) VALUES ('55','2023_04_06_173024_create_products_table','27');

INSERT INTO migrations (id, migration, batch) VALUES ('56','2023_04_06_174647_create_product_images_table','27');

INSERT INTO migrations (id, migration, batch) VALUES ('57','2023_06_05_153507_create_product_warrenties_table','27');

INSERT INTO migrations (id, migration, batch) VALUES ('58','2023_04_01_232755_create_subcategories_table','28');

INSERT INTO migrations (id, migration, batch) VALUES ('59','2023_07_17_212431_create_permission_routes_table','29');

INSERT INTO migrations (id, migration, batch) VALUES ('60','2023_07_17_222638_create_user_roles_table','29');

INSERT INTO migrations (id, migration, batch) VALUES ('61','2023_07_18_010659_create_role_permissions_table','29');

INSERT INTO migrations (id, migration, batch) VALUES ('62','2023_07_18_014657_create_user_role_permissions_table','29');

INSERT INTO migrations (id, migration, batch) VALUES ('63','2025_06_16_171058_add_route_module_name_to_permission_routes_table','29');

INSERT INTO migrations (id, migration, batch) VALUES ('64','2025_06_22_100133_create_user_activities_table','29');

INSERT INTO migrations (id, migration, batch) VALUES ('65','2023_04_13_002226_create_banners_table','30');

INSERT INTO migrations (id, migration, batch) VALUES ('66','2023_06_13_160256_create_promotional_banners_table','30');

INSERT INTO migrations (id, migration, batch) VALUES ('67','2024_01_16_155239_create_custom_pages_table','31');

INSERT INTO migrations (id, migration, batch) VALUES ('68','2023_04_12_213408_create_faqs_table','32');

INSERT INTO migrations (id, migration, batch) VALUES ('69','2025_02_05_123542_create_outlets_table','33');

INSERT INTO migrations (id, migration, batch) VALUES ('70','2025_05_05_101947_create_side_banners_table','34');

INSERT INTO migrations (id, migration, batch) VALUES ('71','2023_04_11_193941_create_terms_and_policies_table','35');

INSERT INTO migrations (id, migration, batch) VALUES ('72','2023_05_19_103848_create_testimonials_table','36');

INSERT INTO migrations (id, migration, batch) VALUES ('73','2025_02_09_105605_create_video_galleries_table','37');

INSERT INTO migrations (id, migration, batch) VALUES ('74','2025_02_02_144552_create_product_purchase_other_charges_table','38');

INSERT INTO migrations (id, migration, batch) VALUES ('75','2025_01_28_125216_create_product_purchase_orders_table','39');

INSERT INTO migrations (id, migration, batch) VALUES ('76','2025_01_28_125245_create_product_purchase_order_products_table','39');

INSERT INTO migrations (id, migration, batch) VALUES ('77','2025_01_28_132326_create_product_stocks_table','39');

INSERT INTO migrations (id, migration, batch) VALUES ('78','2025_01_28_125012_create_product_purchase_quotations_table','40');

INSERT INTO migrations (id, migration, batch) VALUES ('79','2025_01_28_125031_create_product_purchase_quotation_products_table','40');

INSERT INTO migrations (id, migration, batch) VALUES ('80','2023_05_30_130611_create_brands_table','41');

INSERT INTO migrations (id, migration, batch) VALUES ('81','2023_06_01_085646_create_colors_table','42');

INSERT INTO migrations (id, migration, batch) VALUES ('82','2023_04_08_190018_create_flags_table','43');

INSERT INTO migrations (id, migration, batch) VALUES ('83','2023_05_31_161724_create_product_models_table','44');

INSERT INTO migrations (id, migration, batch) VALUES ('84','2023_10_22_122627_create_product_sizes_table','45');

INSERT INTO migrations (id, migration, batch) VALUES ('85','2025_04_27_151318_create_product_size_values_table','45');

INSERT INTO migrations (id, migration, batch) VALUES ('86','2023_04_07_060940_create_units_table','46');

INSERT INTO migrations (id, migration, batch) VALUES ('87','2023_07_03_093759_create_blog_categories_table','47');

INSERT INTO migrations (id, migration, batch) VALUES ('88','2023_07_03_113558_create_blogs_table','48');

INSERT INTO migrations (id, migration, batch) VALUES ('89','2019_08_19_000000_create_failed_jobs_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('90','2023_04_24_104941_create_carts_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('91','2023_04_25_023105_create_user_cards_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('92','2023_06_01_143737_create_sims_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('93','2023_11_08_144020_create_email_templates_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('94','2025_01_27_160000_create_payment_vouchers_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('95','2025_02_17_111246_create_ac_transactions_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('96','2025_02_17_115121_create_ac_accounts_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('97','2025_02_17_122606_create_ac_money_deposits_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('98','2025_02_17_123215_create_ac_money_transfers_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('99','2025_02_17_130630_create_db_taxes_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('100','2025_02_17_131725_create_db_suppliers_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('101','2025_02_17_133009_create_db_supplier_payments_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('102','2025_02_17_133710_create_db_payment_types_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('103','2025_02_17_134150_create_db_expenses_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('104','2025_02_17_135303_create_db_expense_categories_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('105','2025_02_17_142410_create_db_customer_payments_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('106','2025_02_17_143009_create_db_purchase_payments_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('107','2025_05_26_125031_create_fcm_tokens_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('108','2025_06_16_111039_create_jobs_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('109','2025_06_25_104547_add_is_package_to_products_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('110','2025_09_07_115609_create_account_types_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('111','2025_09_07_145554_create_account_groups_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('112','2025_09_07_153829_create_account_subsidiary_ledgers_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('113','2025_09_09_141758_create_account_transactions_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('114','2025_09_09_142737_create_account_transaction_details_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('115','2025_09_09_143056_create_subsidiary_calculations_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('116','2025_09_15_105814_create_accounts_configurations_table','49');

INSERT INTO migrations (id, migration, batch) VALUES ('117','2025_12_02_170000_add_customer_src_type_id_to_orders_table','50');


CREATE TABLE `mlm_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `level_1_percentage` decimal(5,2) NOT NULL DEFAULT '10.00',
  `level_2_percentage` decimal(5,2) NOT NULL DEFAULT '5.00',
  `level_3_percentage` decimal(5,2) NOT NULL DEFAULT '2.00',
  `minimum_withdrawal` decimal(10,2) NOT NULL DEFAULT '100.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `server_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fcm_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `topic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `order_delivey_men` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned DEFAULT NULL,
  `delivery_man_id` bigint DEFAULT NULL,
  `status` enum('pending','accepted','rejected','delivered','returned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `order_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `store_id` bigint unsigned DEFAULT NULL,
  `warehouse_id` bigint unsigned DEFAULT NULL,
  `warehouse_room_id` bigint unsigned DEFAULT NULL,
  `warehouse_room_cartoon_id` bigint unsigned DEFAULT NULL,
  `special_discount` double(20,4) DEFAULT '0.0000',
  `reward_points` int DEFAULT '0',
  `color_id` bigint unsigned DEFAULT NULL COMMENT 'Variant',
  `size_id` bigint unsigned DEFAULT NULL COMMENT 'Variant',
  `region_id` bigint unsigned DEFAULT NULL COMMENT 'Variant',
  `sim_id` bigint unsigned DEFAULT NULL COMMENT 'Variant',
  `storage_id` bigint unsigned DEFAULT NULL COMMENT 'Variant',
  `warrenty_id` bigint unsigned DEFAULT NULL COMMENT 'Variant',
  `device_condition_id` bigint unsigned DEFAULT NULL COMMENT 'Variant',
  `unit_id` bigint unsigned DEFAULT NULL,
  `qty` double NOT NULL,
  `unit_price` double NOT NULL,
  `avg_cost_price` decimal(10,2) DEFAULT NULL COMMENT 'Average cost price of the product at the time of order',
  `total_price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `order_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `payment_through` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SSL COMMERZ',
  `tran_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Response From Payment Gateway',
  `val_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Response From Payment Gateway',
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Response From Payment Gateway',
  `card_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Response From Payment Gateway',
  `store_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Response From Payment Gateway',
  `card_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Response From Payment Gateway',
  `bank_tran_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Response From Payment Gateway',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Response From Payment Gateway',
  `tran_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Response From Payment Gateway',
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Response From Payment Gateway',
  `card_issuer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Response From Payment Gateway',
  `card_brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Response From Payment Gateway',
  `card_sub_brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Response From Payment Gateway',
  `card_issuer_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Response From Payment Gateway',
  `store_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Response From Payment Gateway',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `order_progress` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `order_status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>pending/processing; 1=>confirmed; 2=>intransit; 3=>delivered; 4=>cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `order_date` datetime NOT NULL,
  `invoice_date` timestamp NULL DEFAULT NULL,
  `estimated_dd` date DEFAULT NULL,
  `delivery_date` datetime DEFAULT NULL,
  `delivery_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1=>Home Delivery; 2=>Store Pickup',
  `payment_method` tinyint DEFAULT NULL COMMENT '1=>cash_on_delivery; 2=>bkash; 3=>nagad; 4=>Card',
  `payment_status` tinyint DEFAULT NULL COMMENT '0=>Unpaid; 1=>Payment Success; 2=>Payment Failed',
  `trx_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Created By GenericCommerceV1',
  `bank_tran_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'KEEP THIS bank_tran_id FOR REFUNDING ISSUE',
  `order_status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>pending/processing; 1=>confirmed; 2=>intransit; 3=>delivered; 4=>cancel',
  `sub_total` double NOT NULL DEFAULT '0',
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` double NOT NULL DEFAULT '0',
  `delivery_fee` double NOT NULL DEFAULT '0',
  `vat` double NOT NULL DEFAULT '0',
  `tax` double NOT NULL DEFAULT '0',
  `total` double NOT NULL DEFAULT '0',
  `order_note` longtext COLLATE utf8mb4_unicode_ci COMMENT 'Order Note By Customer',
  `order_remarks` longtext COLLATE utf8mb4_unicode_ci COMMENT 'Special Note By Admin',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complete_order` tinyint NOT NULL DEFAULT '0' COMMENT '0=>Incomplete Order (Address Missing); 1=>Complete Order (Address Given)',
  `invoice_generated` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_src_type_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_no_unique` (`order_no`),
  UNIQUE KEY `orders_slug_unique` (`slug`),
  KEY `orders_customer_src_type_id_foreign` (`customer_src_type_id`),
  CONSTRAINT `orders_customer_src_type_id_foreign` FOREIGN KEY (`customer_src_type_id`) REFERENCES `customer_source_types` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `outlets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `opening` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number_1` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number_2` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number_3` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map` text COLLATE utf8mb4_unicode_ci,
  `video_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `package_product_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `package_product_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `color_id` bigint unsigned DEFAULT NULL,
  `size_id` bigint unsigned DEFAULT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `payment_gateways` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `provider_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'StoreID/ApiKey',
  `secret_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'StorePassword/SecretKey',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `live` tinyint NOT NULL DEFAULT '1' COMMENT '0=>Test/Sandbox; 1=>Product/Live',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0=>Inactive; 1=>Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `payment_vouchers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `voucher_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_date` date NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `general_ledger_id` bigint unsigned DEFAULT NULL,
  `payment_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subsidiary_ledger_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_amount` decimal(15,2) DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_vouchers_voucher_no_unique` (`voucher_no`),
  KEY `payment_vouchers_payment_date_status_index` (`payment_date`,`status`),
  KEY `payment_vouchers_voucher_no_index` (`voucher_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `permission_routes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route_group_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route_module_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_models` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0=>Inactive; 1=>Active',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_purchase_order_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_warehouse_id` bigint unsigned DEFAULT NULL,
  `product_warehouse_room_id` bigint unsigned DEFAULT NULL,
  `product_warehouse_room_cartoon_id` bigint unsigned DEFAULT NULL,
  `product_supplier_id` bigint unsigned DEFAULT NULL,
  `product_purchase_order_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` mediumint unsigned DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `discount_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` int DEFAULT NULL,
  `tax` int DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_purchase_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_warehouse_id` bigint unsigned DEFAULT NULL,
  `product_warehouse_room_id` bigint unsigned DEFAULT NULL,
  `product_warehouse_room_cartoon_id` bigint unsigned DEFAULT NULL,
  `product_supplier_id` bigint unsigned DEFAULT NULL,
  `product_purchase_quotation_id` bigint unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  `discount_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` int DEFAULT NULL,
  `calculated_discount_amount` decimal(6,2) DEFAULT NULL,
  `order_status` enum('pending','received') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `other_charge_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_charge_percentage` decimal(6,2) DEFAULT NULL,
  `other_charge_amount` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `round_off` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_purchase_other_charges` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_purchase_quotation_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_warehouse_id` bigint unsigned DEFAULT NULL,
  `product_warehouse_room_id` bigint unsigned DEFAULT NULL,
  `product_warehouse_room_cartoon_id` bigint unsigned DEFAULT NULL,
  `product_supplier_id` bigint unsigned DEFAULT NULL,
  `product_purchase_quotation_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` mediumint unsigned DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `discount_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` int DEFAULT NULL,
  `tax` int DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_purchase_quotations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_warehouse_id` bigint unsigned DEFAULT NULL,
  `product_warehouse_room_id` bigint unsigned DEFAULT NULL,
  `product_warehouse_room_cartoon_id` bigint unsigned DEFAULT NULL,
  `product_supplier_id` bigint unsigned DEFAULT NULL,
  `is_ordered` tinyint NOT NULL DEFAULT '1',
  `date` date DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `discount_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` int DEFAULT NULL,
  `calculated_discount_amount` decimal(6,2) DEFAULT NULL,
  `other_charge_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_charge_percentage` decimal(6,2) DEFAULT NULL,
  `other_charge_amount` decimal(10,2) DEFAULT NULL,
  `round_off` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_question_answers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question` longtext COLLATE utf8mb4_unicode_ci,
  `answer` longtext COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `rating` double NOT NULL DEFAULT '0',
  `review` longtext COLLATE utf8mb4_unicode_ci,
  `reply` longtext COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>Pending; 1=>Approved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_size_values` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_size_id` tinyint DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_sizes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial` double NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_stocks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_warehouse_id` bigint unsigned DEFAULT NULL,
  `product_warehouse_room_id` bigint unsigned DEFAULT NULL,
  `product_warehouse_room_cartoon_id` bigint unsigned DEFAULT NULL,
  `product_supplier_id` bigint unsigned DEFAULT NULL,
  `product_purchase_order_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  `qty` mediumint unsigned DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_supplier_contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_supplier_id` bigint unsigned DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_variants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_id` bigint unsigned DEFAULT NULL,
  `size_id` bigint unsigned DEFAULT NULL,
  `region_id` bigint unsigned DEFAULT NULL,
  `sim_id` bigint unsigned DEFAULT NULL,
  `storage_type_id` bigint unsigned DEFAULT NULL,
  `stock` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `discounted_price` double NOT NULL DEFAULT '0',
  `warrenty_id` tinyint DEFAULT NULL,
  `device_condition_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_warehouse_room_cartoons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_warehouse_id` bigint unsigned DEFAULT NULL,
  `product_warehouse_room_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_warehouse_room_cartoons_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_warehouse_rooms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_warehouse_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_warehouse_rooms_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_warehouses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_warehouses_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `product_warrenties` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned DEFAULT NULL,
  `subcategory_id` bigint unsigned DEFAULT NULL,
  `childcategory_id` bigint unsigned DEFAULT NULL,
  `brand_id` bigint unsigned DEFAULT NULL,
  `model_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `multiple_images` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `specification` longtext COLLATE utf8mb4_unicode_ci,
  `warrenty_policy` longtext COLLATE utf8mb4_unicode_ci,
  `price` double NOT NULL DEFAULT '0',
  `discount_price` double NOT NULL DEFAULT '0',
  `stock` double NOT NULL DEFAULT '0',
  `unit_id` bigint unsigned DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warrenty_id` tinyint DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag_id` tinyint DEFAULT NULL,
  `avg_cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Average cost price of the product',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>Active; 0=>Inactive',
  `has_variant` tinyint NOT NULL DEFAULT '0' COMMENT '0=>No Variant; 1=>Product Has variant based on Colors, Region etc.',
  `is_demo` tinyint NOT NULL DEFAULT '0' COMMENT '0=>original; 1=>Demo',
  `is_package` tinyint NOT NULL DEFAULT '0' COMMENT '0=>original; 1=>Demo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `promo_codes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `effective_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `type` tinyint NOT NULL COMMENT '1=>Amount; 2=>Percentage',
  `value` double NOT NULL DEFAULT '0',
  `minimum_order_amount` double DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>Active; 0=>Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `promotional_banners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `heading` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `heading_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btn_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btn_text_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btn_bg_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `started_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `time_bg_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_font_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `role_permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission_id` bigint unsigned NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `shipping_infos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thana` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `side_banners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `banner_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `sims` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `sms_gateways` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_endpoint` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secret_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0=>Inactive; 1=>Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `sms_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `template_id` bigint unsigned DEFAULT NULL,
  `template_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_description` longtext COLLATE utf8mb4_unicode_ci,
  `sending_type` tinyint DEFAULT NULL COMMENT '1=>Individual; 2=>Everyone',
  `individual_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_receivers` tinyint DEFAULT NULL COMMENT '1=>Having No Order; 2=>Having Orders',
  `min_order` double DEFAULT NULL,
  `max_order` double DEFAULT NULL,
  `min_order_value` double DEFAULT NULL,
  `max_order_value` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `sms_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `social_logins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fb_login_status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>Inactive; 1=>Active',
  `fb_app_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_app_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_redirect_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gmail_login_status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>Inactive; 1=>Active',
  `gmail_client_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gmail_secret_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gmail_redirect_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `storage_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Inactive; 1=>Active',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `subcategories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>Active; 0=>Inactive',
  `featured` tinyint NOT NULL DEFAULT '0' COMMENT '0=>Not Featured; 1=>Featured',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `subscribed_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `subsidiary_calculations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `particular` int NOT NULL COMMENT '0=Beginning Balance',
  `particular_control_group` int NOT NULL,
  `particular_sub_ledger_group_id` int NOT NULL,
  `trans_date` date NOT NULL,
  `sub_ledger` int NOT NULL,
  `gl_ledger` int NOT NULL,
  `nature_id` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debit_amount` double(11,2) NOT NULL,
  `credit_amount` double(11,2) NOT NULL,
  `transaction_type` tinyint NOT NULL COMMENT '1=acc_opening, 2=acc_transaction, 3=inventory_closing_stock',
  `transaction_id` bigint unsigned NOT NULL,
  `tran_details_id` bigint unsigned NOT NULL,
  `adjust_trans_id` int DEFAULT '0',
  `adjust_vouchar_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `valid` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subsidiary_calculations_transaction_id_foreign` (`transaction_id`),
  KEY `subsidiary_calculations_tran_details_id_foreign` (`tran_details_id`),
  CONSTRAINT `subsidiary_calculations_tran_details_id_foreign` FOREIGN KEY (`tran_details_id`) REFERENCES `account_transaction_details` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subsidiary_calculations_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `account_transactions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `supplier_source_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `support_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `support_ticket_id` bigint unsigned NOT NULL,
  `sender_id` bigint unsigned NOT NULL,
  `sender_type` tinyint NOT NULL COMMENT '1=>Support Agent; 2=>Customer',
  `message` longtext COLLATE utf8mb4_unicode_ci,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `support_tickets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ticket_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `support_taken_by` bigint unsigned NOT NULL COMMENT 'user_id',
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>Pending;1=>In Progress;2=>Solved;3=>Rejected;4=>On Hold',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `terms_and_policies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `terms` longtext COLLATE utf8mb4_unicode_ci,
  `privacy_policy` longtext COLLATE utf8mb4_unicode_ci,
  `shipping_policy` longtext COLLATE utf8mb4_unicode_ci,
  `return_policy` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `testimonials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` double NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `unions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `upazila_id` int NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=749 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('1','1','Subil','সুবিল','subilup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('2','1','North Gunaighor','উত্তর গুনাইঘর','gunaighornorthup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('3','1','South Gunaighor','দক্ষিণ গুনাইঘর','gunaighorsouth.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('4','1','Boroshalghor','বড়শালঘর','boroshalghorup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('5','1','Rajameher','রাজামেহার','rajameherup.comila.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('6','1','Yousufpur','ইউসুফপুর','yousufpurup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('7','1','Rasulpur','রসুলপুর','rasulpurup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('8','1','Fatehabad','ফতেহাবাদ','fatehabadup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('9','1','Elahabad','এলাহাবাদ','elahabadup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('10','1','Jafargonj','জাফরগঞ্জ','jafargonjup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('11','1','Dhampti','ধামতী','dhamptiup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('12','1','Mohanpur','মোহনপুর','mohanpurup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('13','1','Vani','ভানী','vaniup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('14','1','Barkamta','বরকামতা','barkamtaup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('15','1','Sultanpur','সুলতানপুর','sultanpurup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('16','2','Aganagar','আগানগর','aganagarup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('17','2','Bhabanipur','ভবানীপুর','bhabanipurup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('18','2','North Khoshbas','উত্তর খোশবাস','khoshbasnorthup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('19','2','South Khoshbas','দক্ষিন খোশবাস','khoshbassouthup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('20','2','Jhalam','ঝলম','jhalamup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('21','2','Chitodda','চিতড্ডা','chitoddaup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('22','2','North Shilmuri','উত্তর শিলমুড়ি','shilmurinorthup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('23','2','South Shilmuri','দক্ষিন শিলমুড়ি','shilmurisouthup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('24','2','Galimpur','গালিমপুর','galimpurup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('25','2','Shakpur','শাকপুর','shakpurup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('26','2','Bhaukshar','ভাউকসার','bhauksharup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('27','2','Adda','আড্ডা','addaup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('28','2','Adra','আদ্রা','adraup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('29','2','Payalgacha','পয়ালগাছা','payalgachaup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('30','2','Laxmipur','লক্ষীপুর','laxmipurup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('31','3','Shidli','শিদলাই','shidliup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('32','3','Chandla','চান্দলা','chandlaup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('33','3','Shashidal','শশীদল','shashidalup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('34','3','Dulalpur','দুলালপুর','dulalpurup2.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('35','3','Brahmanpara Sadar','ব্রাহ্মনপাড়া সদর','brahmanparasadarup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('36','3','Shahebabad','সাহেবাবাদ','shahebabadup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('37','3','Malapara','মালাপাড়া','malaparaup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('38','3','Madhabpur','মাধবপুর','madhabpurup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('39','4','Shuhilpur','সুহিলপুর','shuhilpurup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('40','4','Bataghashi','বাতাঘাসি','bataghashiup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('41','4','Joag','জোয়াগ','joagup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('42','4','Borcarai','বরকরই','borcaraiup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('43','4','Madhaiya','মাধাইয়া','madhaiyaup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('44','4','Dollai Nowabpur','দোল্লাই নবাবপুর','dollainowabpurup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('45','4','Mohichial','মহিচাইল','mohichialup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('46','4','Gollai','গল্লাই','gollaiup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('47','4','Keronkhal','কেরণখাল','keronkhalup.comilla.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('48','4','Maijkhar','মাইজখার','maijkharup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('49','4','Etberpur','এতবারপুর','etberpurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('50','4','Barera','বাড়েরা','bareraup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('51','4','Borcoit','বরকইট','borcoitup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('52','5','Sreepur','শ্রীপুর','sreepurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('53','5','Kashinagar','কাশিনগর','kashinagarup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('54','5','Kalikapur','কালিকাপুর','kalikapurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('55','5','Shuvapur','শুভপুর','shuvapurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('56','5','Ghulpasha','ঘোলপাশা','ghulpashaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('57','5','Moonshirhat','মুন্সীরহাট','moonshirhatup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('58','5','Batisha','বাতিসা','batishaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('59','5','Kankapait','কনকাপৈত','kankapaitup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('60','5','Cheora','চিওড়া','cheoraup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('61','5','Jagannatdighi','জগন্নাথদিঘী','jagannatdighiup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('62','5','Goonabati','গুনবতী','goonabatiup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('63','5','Alkara','আলকরা','alkaraup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('64','6','Doulotpur','দৌলতপুর','doulotpurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('65','6','Daudkandi','দাউদকান্দি','daudkandinorthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('66','6','North Eliotgonj','উত্তর ইলিয়টগঞ্জ','eliotgonjnorthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('67','6','South Eliotgonj','দক্ষিন ইলিয়টগঞ্জ','eliotgonjsouthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('68','6','Zinglatoli','জিংলাতলী','zinglatoliup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('69','6','Sundolpur','সুন্দলপুর','sundolpurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('70','6','Gouripur','গৌরীপুর','gouripurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('71','6','East Mohammadpur','পুর্ব মোহাম্মদপুর','mohammadpureastup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('72','6','West Mohammadpur','পশ্চিম মোহাম্মদপুর','mohammadpurwestup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('73','6','Goalmari','গোয়ালমারী','goalmariup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('74','6','Maruka','মারুকা','marukaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('75','6','Betessor','বিটেশ্বর','betessorup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('76','6','Podua','পদুয়া','poduaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('77','6','West Passgacia','পশ্চিম পাচঁগাছিয়া','passgaciawestup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('78','6','Baropara','বারপাড়া','baroparaup2.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('79','7','Mathabanga','মাথাভাঙ্গা','mathabangaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('80','7','Gagutiea','ঘাগুটিয়া','gagutieaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('81','7','Asadpur','আছাদপুর','asadpurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('82','7','Chanderchor','চান্দেরচর','chanderchorup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('83','7','Vashania','ভাষানিয়া','vashaniaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('84','7','Nilokhi','নিলখী','nilokhiup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('85','7','Garmora','ঘারমোড়া','garmoraup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('86','7','Joypur','জয়পুর','joypurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('87','7','Dulalpur','দুলালপুর','dulalpurup1.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('88','8','Bakoi','বাকই','bakoiup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('89','8','Mudafargonj','মুদাফফর গঞ্জ','mudafargonjup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('90','8','Kandirpar','কান্দিরপাড়','kandirparup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('91','8','Gobindapur','গোবিন্দপুর','gobindapurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('92','8','Uttarda','উত্তরদা','uttardaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('93','8','Laksam Purba','লাকসাম পুর্ব','laksampurbaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('94','8','Azgora','আজগরা','azgoraup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('95','9','Sreekil','শ্রীকাইল','sreekilup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('96','9','Akubpur','আকুবপুর','akubpurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('97','9','Andicot','আন্দিকোট','andicotup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('98','9','Purbadair (East)','পুর্বধৈইর (পুর্ব)','purbadaireastup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('99','9','Purbadair (West)','পুর্বধৈইর (পশ্চিম)','purbadairwestup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('100','9','Bangara (East)','বাঙ্গরা (পূর্ব)','bangaraeastup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('101','9','Bangara (West)','বাঙ্গরা (পশ্চিম)','bangarawestup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('102','9','Chapitala','চাপিতলা','chapitalaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('103','9','Camalla','কামাল্লা','camallaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('104','9','Jatrapur','যাত্রাপুর','jatrapurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('105','9','Ramachandrapur (North)','রামচন্দ্রপুর (উত্তর)','ramachandrapurnorthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('106','9','Ramachandrapur (South)','রামচন্দ্রপুর (দক্ষিন)','ramachandrapursouthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('107','9','Muradnagar Sadar','মুরাদনগর সদর','muradnagarsadarup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('108','9','Nobipur (East)','নবীপুর (পুর্ব)','nobipureastup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('109','9','Nobipur (West)','নবীপুর (পশ্চিম)','nobipurwestup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('110','9','Damgar','ধামঘর','damgarup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('111','9','Jahapur','জাহাপুর','jahapurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('112','9','Salikandi','ছালিয়াকান্দি','salikandiup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('113','9','Darura','দারোরা','daruraup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('114','9','Paharpur','পাহাড়পুর','paharpurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('115','9','Babutipara','বাবুটিপাড়া','babutiparaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('116','9','Tanki','টনকী','tankiup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('117','10','Bangadda','বাঙ্গড্ডা','bangadda.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('118','10','Paria','পেরিয়া','pariaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('119','10','Raykot','রায়কোট','raykotup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('120','10','Mokara','মোকরা','mokaraup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('121','10','Makrabpur','মক্রবপুর','makrabpurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('122','10','Heshakhal','হেসাখাল','heshakhalup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('123','10','Adra','আদ্রা','adraup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('124','10','Judda','জোড্ডা','juddaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('125','10','Dhalua','ঢালুয়া','dhaluaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('126','10','Doulkha','দৌলখাঁড়','doulkhaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('127','10','Boxgonj','বক্সগঞ্জ','boxgonjup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('128','10','Satbaria','সাতবাড়ীয়া','satbariaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('129','11','Kalirbazer','কালীর বাজার','kalirbazerup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('130','11','North Durgapur','উত্তর দুর্গাপুর','durgapurnorthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('131','11','South Durgapur','দক্ষিন দুর্গাপুর','durgapursouthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('132','11','Amratoli','আমড়াতলী','amratoliup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('133','11','Panchthubi','পাঁচথুবী','panchthubiup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('134','11','Jagannatpur','জগন্নাথপুর','jagannatpurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('135','12','Chandanpur','চন্দনপুর','chandanpurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('136','12','Chalibanga','চালিভাঙ্গা','chalibangaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('137','12','Radanagar','রাধানগর','radanagarup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('138','12','Manikarchar','মানিকারচর','manikarcharup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('139','12','Barakanda','বড়কান্দা','barakandaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('140','12','Govindapur','গোবিন্দপুর','govindapurup1.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('141','12','Luterchar','লুটেরচর','lutercharup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('142','12','Vaorkhola','ভাওরখোলা','vaorkholaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('143','13','Baishgaon','বাইশগাঁও','baishgaonup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('144','13','Shoroshpur','সরসপুর','shoroshpurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('145','13','Hasnabad','হাসনাবাদ','hasnabadup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('146','13','Jholam (North)','ঝলম (উত্তর)','jholamnorthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('147','13','Jholam (South)','ঝলম (দক্ষিন)','jholamsouthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('148','13','Moishatua','মৈশাতুয়া','moishatuaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('149','13','Lokkhanpur','লক্ষনপুর','lokkhanpurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('150','13','Khela','খিলা','khelaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('151','13','Uttarhowla','উত্তর হাওলা','uttarhowlaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('152','13','Natherpetua','নাথেরপেটুয়া','natherpetuaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('153','13','Bipulashar','বিপুলাসার','bipulasharup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('154','14','Chuwara','চৌয়ারা','chuwaraup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('155','14','Baropara','বারপাড়া','baroparaup1.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('156','14','Jorkanoneast','জোড়কানন (পুর্ব)','jorkanoneastup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('157','14','Goliara','গলিয়ারা','goliaraup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('158','14','Jorkanonwest','জোড়কানন (পশ্চিম)','jorkanonwestup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('159','14','Bagmara (North)','বাগমারা (উত্তর)','bagmaranorthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('160','14','Bagmara (South)','বাগমারা (দক্ষিন)','bagmarasouthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('161','14','Bhuloin (North)','ভূলইন (উত্তর)','bhuloinnorthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('162','14','Bhuloin (South)','ভূলইন (দক্ষিন)','bhuloinsouthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('163','14','Belgor (North)','বেলঘর (উত্তর)','belgornorthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('164','14','Belgor (South)','বেলঘর (দক্ষিন)','belgorsouthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('165','14','Perul (North)','পেরুল (উত্তর)','perulnorthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('166','14','Perul (South)','পেরুল (দক্ষিন)','perulsouthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('167','14','Bijoypur','বিজয়পুর','bijoypurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('168','15','Satani','সাতানী','sataniup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('169','15','Jagatpur','জগতপুর','jagatpurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('170','15','Balorampur','বলরামপুর','balorampurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('171','15','Karikandi','কড়িকান্দি','karikandiup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('172','15','Kalakandi','কলাকান্দি','kalakandiup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('173','15','Vitikandi','ভিটিকান্দি','vitikandiup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('174','15','Narayandia','নারান্দিয়া','narayandiaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('175','15','Zearkandi','জিয়ারকান্দি','zearkandiup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('176','15','Majidpur','মজিদপুর','majidpurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('177','16','Moynamoti','ময়নামতি','moynamotiup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('178','16','Varella','ভারেল্লা','varellaup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('179','16','Mokam','মোকাম','mokamup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('180','16','Burichang Sadar','বুড়িচং সদর','burichangsadarup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('181','16','Bakshimul','বাকশীমূল','bakshimulup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('182','16','Pirjatrapur','পীরযাত্রাপুর','pirjatrapurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('183','16','Sholonal','ষোলনল','sholonalup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('184','16','Rajapur','রাজাপুর','rajapurup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('185','17','Bagmara (North)','বাগমারা (উত্তর)','bagmaranorthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('186','17','Bagmara (South)','বাগমারা (দক্ষিন)','bagmarasouthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('187','17','Bhuloin (North)','ভূলইন (উত্তর)','bhuloinnorthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('188','17','Bhuloin (South)','ভূলইন (দক্ষিন)','bhuloinsouthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('189','17','Belgor (North)','বেলঘর (উত্তর)','belgornorthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('190','17','Belgor (South)','বেলঘর (দক্ষিন)','belgorsouthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('191','17','Perul (North)','পেরুল (উত্তর)','perulnorthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('192','17','Perul (South)','পেরুল (দক্ষিন)','perulsouthup.comilla.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('193','18','Mohamaya','মহামায়া','mohamayaup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('194','18','Pathannagar','পাঠাননগর','pathannagarup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('195','18','Subhapur','শুভপুর','subhapurup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('196','18','Radhanagar','রাধানগর','radhanagarup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('197','18','Gopal','ঘোপাল','gopalup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('198','19','Sarishadi','শর্শদি','sarishadiup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('199','19','Panchgachia','পাঁচগাছিয়া','panchgachiaup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('200','19','Dhormapur','ধর্মপুর','dhormapurup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('201','19','Kazirbag','কাজিরবাগ','kazirbagup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('202','19','Kalidah','কালিদহ','kalidahup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('203','19','Baligaon','বালিগাঁও','baligaonup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('204','19','Dholia','ধলিয়া','dholiaup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('205','19','Lemua','লেমুয়া','lemuaup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('206','19','Chonua','ছনুয়া','chonuaup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('207','19','Motobi','মোটবী','motobiup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('208','19','Fazilpur','ফাজিলপুর','fazilpurup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('209','19','Forhadnogor','ফরহাদনগর','forhadnogorup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('210','20','Charmozlishpur','চরমজলিশপুর','charmozlishpurup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('211','20','Bogadana','বগাদানা','bogadanaup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('212','20','Motigonj','মতিগঞ্জ','motigonjup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('213','20','Mongolkandi','মঙ্গলকান্দি','mongolkandiup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('214','20','Chardorbesh','চরদরবেশ','chardorbeshup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('215','20','Chorchandia','চরচান্দিয়া','chorchandiaup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('216','20','Sonagazi','সোনাগাজী','sonagaziup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('217','20','Amirabad','আমিরাবাদ','amirabadup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('218','20','Nababpur','নবাবপুর','nababpurup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('219','21','Fulgazi','ফুলগাজী','fulgaziup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('220','21','Munshirhat','মুন্সিরহাট','munshirhatup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('221','21','Dorbarpur','দরবারপুর','dorbarpurup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('222','21','Anandopur','আনন্দপুর','anandopurup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('223','21','Amzadhat','আমজাদহাট','amzadhatup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('224','21','Gmhat','জি,এম, হাট','gmhatup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('225','22','Mizanagar','মির্জানগর','mizanagarup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('226','22','Ctholia','চিথলিয়া','ctholiaup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('227','22','Boxmahmmud','বক্সমাহমুদ','boxmahmmudup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('228','23','Sindurpur','সিন্দুরপুর','sindurpurup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('229','23','Rajapur','রাজাপুর','rajapurup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('230','23','Purbachandrapur','পূর্বচন্দ্রপুর','purbachandrapurup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('231','23','Ramnagar','রামনগর','ramnagarup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('232','23','Yeakubpur','ইয়াকুবপুর','yeakubpur.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('233','23','Daganbhuiyan','দাগনভূঞা','daganbhuiyanup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('234','23','Matubhuiyan','মাতুভূঞা','matubhuiyanup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('235','23','Jayloskor','জায়লস্কর','jayloskorup.feni.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('236','24','Basudeb','বাসুদেব','basudeb.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('237','24','Machihata','মাছিহাতা','machihata.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('238','24','Sultanpur','সুলতানপুর','sultanpur.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('239','24','Ramrail','রামরাইল','ramrail.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('240','24','Sadekpur','সাদেকপুর','sadekpur.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('241','24','Talsahar','তালশহর','talsahar.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('242','24','Natai','নাটাই (দক্ষিন)','natais.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('243','24','Natai','নাটাই (উত্তর)','natain.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('244','24','Shuhilpur','সুহিলপুর','shuhilpur.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('245','24','Bodhal','বুধল','bodhal.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('246','24','Majlishpur','মজলিশপুর','majlishpur.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('247','25','Mulagram','মূলগ্রাম','mulagramup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('248','25','Mehari','মেহারী','mehariup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('249','25','Badair','বাদৈর','badairup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('250','25','Kharera','খাড়েরা','khareraup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('251','25','Benauty','বিনাউটি','benautyup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('252','25','Gopinathpur','গোপীনাথপুর','gopinathpurup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('253','25','Kasbaw','কসবা','kasbawup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('254','25','Kuti','কুটি','kutiup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('255','25','Kayempur','কাইমপুর','kayempurup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('256','25','Bayek','বায়েক','bayekup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('257','26','Chatalpar','চাতলপাড়','chatalparup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('258','26','Bhalakut','ভলাকুট','bhalakutup.brahmanbaria.gov.bd ','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('259','26','Kunda','কুন্ডা','kundaup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('260','26','Goalnagar','গোয়ালনগর','goalnagarup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('261','26','Nasirnagar','নাসিরনগর','nasirnagarup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('262','26','Burishwar','বুড়িশ্বর','burishwarup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('263','26','Fandauk','ফান্দাউক','fandaukup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('264','26','Goniauk','গুনিয়াউক','goniaukup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('265','26','Chapartala','চাপৈরতলা','chapartalaup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('266','26','Dharnondol','ধরমন্ডল','dharnondolup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('267','26','Haripur','হরিপুর','haripurup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('268','26','Purbabhag','পূর্বভাগ','purbabhagup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('269','26','Gokarna','গোকর্ণ','gokarnaup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('270','27','Auraol','অরুয়াইল','auraolup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('271','27','Pakshimuul','পাকশিমুল','pakshimuulup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('272','27','Chunta','চুন্টা','chuntaup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('273','27','Kalikaccha','কালীকচ্ছ','kalikacchaup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('274','27','Panishor','পানিশ্বর','panishorup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('275','27','Sarail','সরাইল সদর','sarailup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('276','27','Noagoun','নোয়াগাঁও','noagounup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('277','27','Shahajadapur','শাহজাদাপুর','shahajadapurup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('278','27','Shahbazpur','শাহবাজপুর','shahbazpurup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('279','28','Ashuganj','আশুগঞ্জ সদর','ashuganjup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('280','28','Charchartala','চরচারতলা','charchartalaup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('281','28','Durgapur','দুর্গাপুর','durgapurup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('282','28','Araishidha','আড়াইসিধা','araishidhaup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('283','28','Talshaharw','তালশহর(পঃ)','talshaharwup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('284','28','Sarifpur','শরীফপুর','sarifpurup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('285','28','Lalpur','লালপুর','lalpurup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('286','28','Tarua','তারুয়া','taruaup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('287','29','Monionda','মনিয়ন্দ','moniondaup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('288','29','Dharkhar','ধরখার','dharkharup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('289','29','Mogra','মোগড়া','mograup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('290','29','Akhauran','আখাউড়া (উঃ)','akhauranup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('291','29','Akhauras','আখাউড়া (দঃ)','akhaurasup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('292','30','Barail','বড়াইল','barailup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('293','30','Birgaon','বীরগাঁও','birgaonup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('294','30','Krishnanagar','কৃষ্ণনগর','krishnanagarup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('295','30','Nathghar','নাটঘর','nathgharup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('296','30','Biddayakut','বিদ্যাকুট','biddayakutup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('297','30','Nabinagare','নবীনগর (পূর্ব)','nabinagareup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('298','30','Nabinagarw','নবীনগর(পশ্চিম)','nabinagarwup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('299','30','Bitghar','বিটঘর','bitgharup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('300','30','Shibpur','শিবপুর','shibpurup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('301','30','Sreerampur','শ্রীরামপুর','sreerampurup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('302','30','Jinudpur','জিনোদপুর','jinudpurup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('303','30','Laurfatehpur','লাউরফতেপুর','laurfatehpurup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('304','30','Ibrahimpur','ইব্রাহিমপুর','ibrahimpurup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('305','30','Satmura','সাতমোড়া','satmuraup.brahmanbaria.gov.bd','2025-12-02 15:14:32','2025-12-02 15:14:32');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('306','30','Shamogram','শ্যামগ্রাম','shamogramup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('307','30','Rasullabad','রসুল্লাবাদ','rasullabadup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('308','30','Barikandi','বড়িকান্দি','barikandiup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('309','30','Salimganj','ছলিমগঞ্জ','salimganjup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('310','30','Ratanpur','রতনপুর','ratanpurup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('311','30','Kaitala (North)','কাইতলা (উত্তর)','kaitalanup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('312','30','Kaitala (South)','কাইতলা (দক্ষিন)','kaitalasup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('313','31','Tazkhali','তেজখালী','tazkhaliup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('314','31','Pahariya Kandi','পাহাড়িয়া কান্দি','pahariyakandiup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('315','31','Dariadulat','দরিয়াদৌলত','dariadulatup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('316','31','Sonarampur','সোনারামপুর','sonarampurup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('317','31','Darikandi','দড়িকান্দি','darikandiup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('318','31','Saifullyakandi','ছয়ফুল্লাকান্দি','saifullyakandiup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('319','31','Bancharampur','বাঞ্ছারামপুর','bancharampurup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('320','31','Ayabpur','আইয়ুবপুর','ayabpurup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('321','31','Fardabad','ফরদাবাদ','fardabadup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('322','31','Rupushdi','রুপসদী পশ্চিম','rupushdiup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('323','31','Salimabad','ছলিমাবাদ','salimabadup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('324','31','Ujanchar','উজানচর পূর্ব','ujancharup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('325','31','Manikpur','মানিকপুর','manikpurup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('326','32','Bhudanty','বুধন্তি','bhudantyup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('327','32','Chandura','চান্দুরা','chanduraup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('328','32','Ichapura','ইছাপুরা','ichapuraup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('329','32','Champaknagar','চম্পকনগর','champaknagarup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('330','32','Harashpur','হরষপুর','harashpurup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('331','32','Pattan','পত্তন','pattanup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('332','32','Singerbil','সিংগারবিল','singerbilup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('333','32','Bishupor','বিষ্ণুপুর','bishuporup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('334','32','Charislampur','চর-ইসলামপুর','charislampurup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('335','32','Paharpur','পাহাড়পুর','paharpurup.brahmanbaria.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('336','33','Jibtali','জীবতলি','jibtaliup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('337','33','Sapchari','সাপছড়ি','sapchariup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('338','33','Kutukchari','কুতুকছড়ি','kutukchariup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('339','33','Bandukbhanga','বন্দুকভাঙ্গা','bandukbhangaup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('340','33','Balukhali','বালুখালী','balukhaliup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('341','33','Mogban','মগবান','mogbanup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('342','34','Raikhali','রাইখালী','raikhaliup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('343','34','Kaptai','কাপ্তাই','kaptaiup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('344','34','Wagga','ওয়াজ্ঞা','waggaup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('345','34','Chandraghona','চন্দ্রঘোনা','chandraghonaup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('346','34','Chitmorom','চিৎমরম','chitmoromup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('347','35','Ghagra','ঘাগড়া','ghagraup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('348','35','Fatikchari','ফটিকছড়ি','fatikchariup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('349','35','Betbunia','বেতবুনিয়া','betbuniaup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('350','35','Kalampati','কলমপতি','kalampatiup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('351','36','Sajek','সাজেক','sajekup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('352','36','Amtali','আমতলী','amtaliup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('353','36','Bongoltali','বঙ্গলতলী','bongoltaliup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('354','36','Rupokari','রুপকারী','rupokariup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('355','36','Marisha','মারিশ্যা','marishaup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('356','36','Khedarmara','খেদারমারা','khedarmaraup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('357','36','Sharoyatali','সারোয়াতলী','sharoyataliup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('358','36','Baghaichari','বাঘাইছড়ি','baghaichariup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('359','37','Subalong','সুবলং','subalongup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('360','37','Barkal','বরকল','barkalup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('361','37','Bushanchara','ভূষনছড়া','bushancharaup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('362','37','Aimachara','আইমাছড়া','aimacharaup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('363','37','Borohorina','বড় হরিণা','borohorinaup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('364','38','Langad','লংগদু','langaduup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('365','38','Maeinimukh','মাইনীমুখ','maeinimukhup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('366','38','Vasannadam','ভাসান্যাদম','vasannadamup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('367','38','Bogachattar','বগাচতর','bogachattarup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('368','38','Gulshakhali','গুলশাখালী','gulshakhaliup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('369','38','Kalapakujja','কালাপাকুজ্যা','kalapakujjaup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('370','38','Atarakchara','আটারকছড়া','atarakcharaup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('371','39','Ghilachari','ঘিলাছড়ি','ghilachariup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('372','39','Gaindya','গাইন্দ্যা','gaindyaup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('373','39','Bangalhalia','বাঙ্গালহালিয়া','bangalhaliaup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('374','40','Kengrachari','কেংড়াছড়ি','kengrachariup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('375','40','Belaichari','বিলাইছড়ি','belaichariup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('376','40','Farua','ফারুয়া','faruaup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('377','41','Juraichari','জুরাছড়ি','juraichariup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('378','41','Banajogichara','বনযোগীছড়া','banajogicharaup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('379','41','Moidong','মৈদং','moidongup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('380','41','Dumdumya','দুমদুম্যা','dumdumyaup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('381','42','Sabekkhong','সাবেক্ষ্যং','sabekkhongup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('382','42','Naniarchar','নানিয়ারচর','naniarcharup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('383','42','Burighat','বুড়িঘাট','burighatup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('384','42','Ghilachhari','ঘিলাছড়ি','ghilachhariup.rangamati.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('385','43','Charmatua','চরমটুয়া','charmatuaup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('386','43','Dadpur','দাদপুর','dadpurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('387','43','Noannoi','নোয়ান্নই','noannoiup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('388','43','Kadirhanif','কাদির হানিফ','kadirhanifup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('389','43','Binodpur','বিনোদপুর','binodpurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('390','43','Dharmapur','ধর্মপুর','dharmapurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('391','43','Aujbalia','এওজবালিয়া','aujbaliaup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('392','43','Kaladara','কালাদরপ','kaladarapup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('393','43','Ashwadia','অশ্বদিয়া','ashwadiaup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('394','43','Newajpur','নিয়াজপুর','newajpurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('395','43','East Charmatua','পূর্ব চরমটুয়া','eastcharmatuap.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('396','43','Andarchar','আন্ডারচর','andarcharup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('397','43','Noakhali','নোয়াখালী','noakhaliup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('398','44','Sirajpur','সিরাজপুর','sirajpurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('399','44','Charparboti','চরপার্বতী','charparbotiup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('400','44','Charhazari','চরহাজারী','charhazariup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('401','44','Charkakra','চরকাঁকড়া','charkakraup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('402','44','Charfakira','চরফকিরা','charfakiraup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('403','44','Musapur','মুসাপুর','musapurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('404','44','Charelahi','চরএলাহী','charelahiup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('405','44','Rampur','রামপুর','rampurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('406','45','Amanullapur','আমানউল্ল্যাপুর','amanullapurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('407','45','Gopalpur','গোপালপুর','gopalpurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('408','45','Jirtali','জিরতলী','jirtaliup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('409','45','Kutubpur','কুতবপুর','kutubpurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('410','45','Alyearpur','আলাইয়ারপুর','alyearpurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('411','45','Chayani','ছয়ানী','chayaniup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('412','45','Rajganj','রাজগঞ্জ','rajganjup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('413','45','Eklashpur','একলাশপুর','eklashpurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('414','45','Begumganj','বেগমগঞ্জ','begumganjup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('415','45','Mirwarishpur','মিরওয়ারিশপুর','mirwarishpurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('416','45','Narottampur','নরোত্তমপুর','narottampurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('417','45','Durgapur','দূর্গাপুর','durgapurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('418','45','Rasulpur','রসুলপুর','rasulpurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('419','45','Hajipur','হাজীপুর','hajipurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('420','45','Sharifpur','শরীফপুর','sharifpurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('421','45','Kadirpur','কাদিরপুর','kadirpurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('422','46','Sukhchar','সুখচর','sukhcharup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('423','46','Nolchira','নলচিরা','nolchiraup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('424','46','Charishwar','চরঈশ্বর','charishwarup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('425','46','Charking','চরকিং','charkingup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('426','46','Tomoroddi','তমরদ্দি','tomoroddiup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('427','46','Sonadiya','সোনাদিয়া','sonadiyaup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('428','46','Burirchar','বুড়িরচর','burircharup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('429','46','Jahajmara','জাহাজমারা','jahajmaraup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('430','46','Nijhumdwi','নিঝুমদ্বীপ','nijhumdwipup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('431','47','Charjabbar','চরজাব্বার','charjabbarup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('432','47','Charbata','চরবাটা','charbataup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('433','47','Charclerk','চরক্লার্ক','charclerkup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('434','47','Charwapda','চরওয়াপদা','charwapdaup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('435','47','Charjubilee','চরজুবলী','charjubileeup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('436','47','Charaman Ullah','চরআমান উল্যা','charamanullahup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('437','47','East Charbata','পূর্ব চরবাটা','eastcharbataup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('438','47','Mohammadpur','মোহাম্মদপুর','mohammadpurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('439','48','Narottampur','নরোত্তমপুর','narottampurup1.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('440','48','Dhanshiri','ধানসিঁড়ি','dhanshiriup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('441','48','Sundalpur','সুন্দলপুর','sundalpurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('442','48','Ghoshbag','ঘোষবাগ','ghoshbagup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('443','48','Chaprashirhat','চাপরাশিরহাট','chaprashirhatup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('444','48','Dhanshalik','ধানশালিক','dhanshalikup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('445','48','Batoiya','বাটইয়া','batoiyaup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('446','49','Chhatarpaia','ছাতারপাইয়া','chhatarpaiaup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('447','49','Kesharpar','কেশরপাড়া','kesharparup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('448','49','Dumurua','ডুমুরুয়া','dumuruaup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('449','49','Kadra','কাদরা','kadraup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('450','49','Arjuntala','অর্জুনতলা','arjuntalaup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('451','49','Kabilpur','কাবিলপুর','kabilpurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('452','49','Mohammadpur','মোহাম্মদপুর','mohammadpurup7.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('453','49','Nabipur','নবীপুর','nabipurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('454','49','Bejbagh','বিজবাগ','bejbaghup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('455','50','Sahapur','সাহাপুর','sahapurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('456','50','Ramnarayanpur','রামনারায়নপুর','ramnarayanpurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('457','50','Porokote','পরকোট','porokoteup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('458','50','Badalkot','বাদলকোট','badalkotup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('459','50','Panchgaon','পাঁচগাঁও','panchgaonup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('460','50','Hat-Pukuria Ghatlabag','হাট-পুকুরিয়া ঘাটলাবাগ','hatpukuriaghatlabagup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('461','50','Noakhala','নোয়াখলা','noakhalaup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('462','50','Khilpara','খিলপাড়া','khilparaup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('463','50','Mohammadpur','মোহাম্মদপুর','mohammadpuru5p.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('464','51','Joyag','জয়াগ','joyagup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('465','51','Nodona','নদনা','nodonaup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('466','51','Chashirhat','চাষীরহাট','chashirhatup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('467','51','Barogaon','বারগাঁও','barogaonup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('468','51','Ambarnagor','অম্বরনগর','ambarnagorup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('469','51','Nateshwar','নাটেশ্বর','nateshwarup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('470','51','Bajra','বজরা','bajraup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('471','51','Sonapur','সোনাপুর','sonapurup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('472','51','Deoti','দেওটি','deotiup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('473','51','Amishapara','আমিশাপাড়া','amishaparaup.noakhali.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('474','52','Gazipur','গাজীপুর','gazipurup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('475','52','Algidurgapur (North)','আলগী দুর্গাপুর (উত্তর)','algidurgapurnorthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('476','52','Algidurgapur (South)','আলগী দুর্গাপুর (দক্ষিণ)','algidurgapursouth.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('477','52','Nilkamal','নীলকমল','nilkamalup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('478','52','Haimchar','হাইমচর','haimcharup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('479','52','Charbhairabi','চরভৈরবী','charbhairabiup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('480','53','Pathair','পাথৈর','pathairup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('481','53','Bitara','বিতারা','bitaraup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('482','53','Shohodebpur (East)','সহদেবপুর (পূর্ব)','shohodebpureastup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('483','53','Shohodebpur (West)','সহদেবপুর (পশ্চিম)','shohodebpurwestup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('484','53','Kachua (North)','কচুয়া (উত্তর)','kachuanorthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('485','53','Kachua (South)','কচুয়া (দক্ষিণ)','kachuasouthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('486','53','Gohat (North)','গোহাট (উত্তর)','gohatnorthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('487','53','Kadla','কাদলা','kadlaup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('488','53','Ashrafpur','আসরাফপুর','ashrafpurup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('489','53','Gohat (South)','গোহাট (দক্ষিণ)','gohatsouthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('490','53','Sachar','সাচার','sacharup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('491','53','Koroia','কড়ইয়া','koroiaup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('492','54','Tamta (South)','টামটা (দক্ষিণ)','tamtasouthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('493','54','Tamta (North)','টামটা (উত্তর)','tamtanorthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('494','54','Meher (North)','মেহের (উত্তর)','mehernorthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('495','54','Meher (South)','মেহের (দক্ষিণ)','mehersouthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('496','54','Suchipara (North)','সুচিপাড়া (উত্তর)','suchiparanorthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('497','54','Suchipara (South)','সুচিপাড়া (দক্ষিণ)','suchiparasouthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('498','54','Chitoshi (East)','চিতষী (পূর্ব)','chitoshieastup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('499','54','Raysree (South)','রায়শ্রী (দক্ষিন)','raysreesouthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('500','54','Raysree (North)','রায়শ্রী (উত্তর)','raysreenorthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('501','54','Chitoshiwest','চিতষী (পশ্চিম)','chitoshiwestup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('502','55','Bishnapur','বিষ্ণপুর','bishnapurup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('503','55','Ashikati','আশিকাটি','ashikatiup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('504','55','Shahmahmudpur','শাহ্‌ মাহমুদপুর','shahmahmudpurup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('505','55','Kalyanpur','কল্যাণপুর','kalyanpurup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('506','55','Rampur','রামপুর','rampurup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('507','55','Maishadi','মৈশাদী','maishadiup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('508','55','Tarpurchandi','তরপুচন্ডী','tarpurchandiup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('509','55','Baghadi','বাগাদী','baghadiup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('510','55','Laxmipur Model','লক্ষীপুর মডেল','laxmipurmodelup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('511','55','Hanarchar','হানারচর','hanarcharup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('512','55','Chandra','চান্দ্রা','chandraup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('513','55','Rajrajeshwar','রাজরাজেশ্বর','rajrajeshwarup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('514','55','Ibrahimpur','ইব্রাহীমপুর','ibrahimpurup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('515','55','Balia','বালিয়া','baliaup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('516','56','Nayergaon (North)','নায়েরগাঁও (উত্তর)','nayergaonnorthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('517','56','Nayergaon (South)','নায়েরগাঁও (দক্ষিন)','nayergaonsouthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('518','56','Khadergaon','খাদেরগাঁও','khadergaonup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('519','56','Narayanpur','নারায়নপুর','narayanpurup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('520','56','Upadi (South)','উপাদী (দক্ষিণ)','upadisouthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('521','56','Upadi (North)','উপাদী (উত্তর)','upadinorthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('522','57','Rajargaon (North)','রাজারগাঁও (উত্তর)','rajargaonnorthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('523','57','Bakila','বাকিলা','bakilaup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('524','57','Kalocho (North)','কালচোঁ (উত্তর)','kalochonorthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('525','57','Hajiganj Sadar','হাজীগঞ্জ সদর','hajiganjsadarup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('526','57','Kalocho (South)','কালচোঁ (দক্ষিণ)','kalochosouthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('527','57','Barkul (East)','বড়কুল (পূর্ব)','barkuleastup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('528','57','Barkul (West)','বড়কুল (পশ্চিম)','barkulwestup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('529','57','Hatila (East)','হাটিলা (পূর্ব)','hatilaeastup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('530','57','Hatila (West)','হাটিলা (পশ্চিম)','hatilawestup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('531','57','Gandharbapur (North)','গন্ধর্ব্যপুর (উত্তর)','gandharbapurnorthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('532','57','Gandharbapur (South)','গন্ধর্ব্যপুর (দক্ষিণ)','gandharbapursouthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('533','58','Satnal','ষাটনল','satnalup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('534','58','Banganbari','বাগানবাড়ী','banganbariup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('535','58','Sadullapur','সাদুল্ল্যাপুর','sadullapurup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('536','58','Durgapur','দূর্গাপুর','durgapurup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('537','58','Kalakanda','কালাকান্দা','kalakandaup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('538','58','Mohanpur','মোহনপুর','mohanpurup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('539','58','Eklaspur','এখলাছপুর','eklaspurup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('540','58','Jahirabad','জহিরাবাদ','jahirabadup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('541','58','Fatehpur (East)','ফতেহপুর (পূর্ব)','eastfatehpur.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('542','58','Fatehpur (West)','ফতেহপুর (পশ্চিম)','westfatehpurup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('543','58','Farajikandi','ফরাজীকান্দি','farajikandiup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('544','58','Islamabad','ইসলামাবাদ','islamabadup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('545','58','Sultanabad','সুলতানাবাদ','sultanabadup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('546','58','Gazra','গজরা','gazraup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('547','59','Balithuba (West)','বালিথুবা (পশ্চিম)','balithubawestup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('548','59','Balithuba (East)','বালিথুবা (পূর্ব)','balithubaeastup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('549','59','Subidpur (East)','সুবিদপুর (পূর্ব)','subidpureastup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('550','59','Subidpur (West)','সুবিদপুর (পশ্চিম)','subidpurwestup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('551','59','Gupti (West)','গুপ্তি (পশ্চিম)','guptiwestup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('552','59','Gupti (East)','গুপ্তি (পূর্ব)','guptieastup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('553','59','Paikpara (North)','পাইকপাড়া (উত্তর)','paikparanorthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('554','59','Paikpara (South)','পাইকপাড়া (দক্ষিণ)','paikparasouthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('555','59','Gobindapur (North)','গবিন্দপুর (উত্তর)','gobindapurnorthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('556','59','Gobindapur (South)','গবিন্দপুর (দক্ষিণ)','gobindapursouthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('557','59','Chardukhia (East)','চরদুখিয়া (পূর্ব)','chardukhiaeastup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('558','59','Chardukhia (West)','চরদুঃখিয়া (পশ্চিম)','chardukhiawestup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('559','59','Faridgonj (South)','ফরিদ্গঞ্জ (দক্ষিণ)','faridgonjsouthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('560','59','Rupsha (South)','রুপসা (দক্ষিণ)','rupshasouthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('561','59','Rupsha (North)','রুপসা (উত্তর)','rupshanorthup.chandpur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('562','60','Hamsadi (North)','হামছাদী (উত্তর)','northhamsadiup.lakshmipur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('563','60','Hamsadi (South)','হামছাদী (দক্ষিন)','southhamsadiup.lakshmipur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('564','60','Dalalbazar','দালাল বাজার','dalalbazarup.lakshmipur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('565','60','Charruhita','চররুহিতা','charruhitaup.lakshmipur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('566','60','Parbotinagar','পার্বতীনগর','parbotinagarup.lakshmipur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('567','60','Bangakha','বাঙ্গাখাঁ','bangakhaup.lakshmipur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('568','60','Dattapara','দত্তপাড়া','dattaparaup.lakshmipur.gov.bd','2025-12-02 15:14:33','2025-12-02 15:14:33');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('569','60','Basikpur','বশিকপুর','basikpurup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('570','60','Chandrogonj','চন্দ্রগঞ্জ','chandrogonjup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('571','60','Nourthjoypur','উত্তর জয়পুর','nourthjoypurup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('572','60','Hazirpara','হাজিরপাড়া','hazirparaup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('573','60','Charshahi','চরশাহী','charshahiup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('574','60','Digli','দিঘলী','digliup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('575','60','Laharkandi','লাহারকান্দি','laharkandiup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('576','60','Vobanigonj','ভবানীগঞ্জ','vobanigonjup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('577','60','Kusakhali','কুশাখালী','kusakhaliup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('578','60','Sakchor','শাকচর','sakchorup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('579','60','Tearigonj','তেয়ারীগঞ্জ','tearigonjup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('580','60','Tumchor','টুমচর','tumchorup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('581','60','Charramoni Mohon','চররমনী মোহন','charramonimohonup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('582','61','Charkalkini','চর কালকিনি','charkalkiniup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('583','61','Shaheberhat','সাহেবেরহাট','shaheberhatup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('584','61','Char Martin','চর মার্টিন','charmartinup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('585','61','Char Folcon','চর ফলকন','charfolconup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('586','61','Patarirhat','পাটারীরহাট','patarirhatup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('587','61','Hajirhat','হাজিরহাট','hajirhatup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('588','61','Char Kadira','চর কাদিরা','charkadiraup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('589','61','Torabgonj','তোরাবগঞ্জ','torabgonjup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('590','61','Charlorench','চর লরেঞ্চ','charlorenchup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('591','62','North Char Ababil','উত্তর চর আবাবিল','northcharababilup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('592','62','North Char Bangshi','উত্তর চর বংশী','northcharbangshiup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('593','62','Char Mohana','চর মোহনা','charmohanaup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('594','62','Sonapur','সোনাপুর','sonapurup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('595','62','Charpata','চর পাতা','charpataup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('596','62','Bamni','বামনী','bamniup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('597','62','South Char Bangshi','দক্ষিন চর বংশী','southcharbangshiup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('598','62','South Char Ababil','দক্ষিন চর আবাবিল','southcharababilup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('599','62','Raipur','রায়পুর','raipurup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('600','62','Keora','কেরোয়া','keoraup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('601','63','Char Poragacha','চর পোড়াগাছা','charporagachaup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('602','63','Charbadam','চর বাদাম','charbadamup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('603','63','Char Abdullah','চর আবদুল্যাহ','charabdullahup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('604','63','Alxendar','আলেকজান্ডার','alxendarup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('605','63','Char Algi','চর আলগী','charalgiup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('606','63','Char Ramiz','চর রমিজ','charramizup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('607','63','Borokheri','বড়খেড়ী','borokheriup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('608','63','Chargazi','চরগাজী','chargaziup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('609','64','Kanchanpur','কাঞ্চনপুর','kanchanpurup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('610','64','Noagaon','নোয়াগাঁও','noagaonup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('611','64','Bhadur','ভাদুর','bhadurup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('612','64','Ichhapur','ইছাপুর','ichhapurup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('613','64','Chandipur','চন্ডিপুর','chandipurup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('614','64','Lamchar','লামচর','lamcharup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('615','64','Darbeshpur','দরবেশপুর','darbeshpurup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('616','64','Karpara','করপাড়া','karparaup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('617','64','Bholakot','ভোলাকোট','bholakotup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('618','64','Bhatra','ভাটরা','bhatraup.lakshmipur.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('619','65','Rajanagar','রাজানগর','rajanagarup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('620','65','Hosnabad','হোছনাবাদ','hosnabadup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('621','65','Swanirbor Rangunia','স্বনির্ভর রাঙ্গুনিয়া','swanirborranguniaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('622','65','Mariumnagar','মরিয়মনগর','mariumnagarup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('623','65','Parua','পারুয়া','paruaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('624','65','Pomra','পোমরা','pomraup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('625','65','Betagi','বেতাগী','betagiup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('626','65','Sharafbhata','সরফভাটা','sharafbhataup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('627','65','Shilok','শিলক','shilokup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('628','65','Chandraghona','চন্দ্রঘোনা','chandraghonaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('629','65','Kodala','কোদালা','kodalaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('630','65','Islampur','ইসলামপুর','islampurup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('631','65','South Rajanagar','দক্ষিণ রাজানগর','southrajanagarup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('632','65','Lalanagar','লালানগর','lalanagarup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('633','66','Kumira','কুমিরা','kumiraup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('634','66','Banshbaria','বাঁশবারীয়া','banshbariaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('635','66','Barabkunda','বারবকুন্ড','barabkundaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('636','66','Bariadyala','বাড়িয়াডিয়ালা','bariadyalaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('637','66','Muradpur','মুরাদপুর','muradpurup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('638','66','Saidpur','সাঈদপুর','saidpurup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('639','66','Salimpur','সালিমপুর','salimpurup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('640','66','Sonaichhari','সোনাইছড়ি','sonaichhariup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('641','66','Bhatiari','ভাটিয়ারী','bhatiariup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('642','67','Korerhat','করেরহাট','korerhatup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('643','67','Hinguli','হিংগুলি','hinguliup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('644','67','Jorarganj','জোরারগঞ্জ','jorarganjup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('645','67','Dhoom','ধুম','dhoomup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('646','67','Osmanpur','ওসমানপুর','osmanpurup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('647','67','Ichakhali','ইছাখালী','ichakhaliup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('648','67','Katachhara','কাটাছরা','katachharaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('649','67','Durgapur','দূর্গাপুর','durgapurup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('650','67','Mirsharai','মীরসরাই','mirsharaiup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('651','67','Mithanala','মিঠানালা','mithanalaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('652','67','Maghadia','মঘাদিয়া','maghadiaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('653','67','Khaiyachhara','খৈয়াছরা','khaiyachharaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('654','67','Mayani','মায়ানী','mayaniup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('655','67','Haitkandi','হাইতকান্দি','haitkandiup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('656','67','Wahedpur','ওয়াহেদপুর','wahedpurup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('657','67','Saherkhali','সাহেরখালী','saherkhaliup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('658','68','Asia','আশিয়া','asiaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('659','68','Kachuai','কাচুয়াই','kachuaiup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('660','68','Kasiais','কাশিয়াইশ','kasiaisup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('661','68','Kusumpura','কুসুমপুরা','kusumpuraup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('662','68','Kelishahar','কেলিশহর','kelishaharup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('663','68','Kolagaon','কোলাগাঁও','kolagaonup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('664','68','Kharana','খরনা','kharanaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('665','68','Char Patharghata','চর পাথরঘাটা','charpatharghataup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('666','68','Char Lakshya','চর লক্ষ্যা','charlakshyaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('667','68','Chanhara','ছনহরা','chanharaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('668','68','Janglukhain','জঙ্গলখাইন','janglukhainup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('669','68','Jiri','জিরি','jiriup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('670','68','Juldha','জুলধা','juldhaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('671','68','Dakkhin Bhurshi','দক্ষিণ ভূর্ষি','dakhinbhurshiup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('672','68','Dhalghat','ধলঘাট','dhalghatup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('673','68','Bara Uthan','বড় উঠান','barauthanup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('674','68','Baralia','বরলিয়া','baraliaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('675','68','Bhatikhain','ভাটিখাইন','bhatikhainup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('676','68','Sikalbaha','শিকলবাহা','sikalbahaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('677','68','Sobhandandi','শোভনদন্ডী','sobhandandiup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('678','68','Habilasdwi','হাবিলাসদ্বীপ','habilasdwipup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('679','68','Haidgaon','হাইদগাঁও','haidgaonup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('680','69','Rahmatpur','রহমতপুর','rahmatpurup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('681','69','Harispur','হরিশপুর','harispurup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('682','69','Kalapania','কালাপানিয়া','kalapaniaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('683','69','Amanullah','আমানউল্যা','amanullahup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('684','69','Santoshpur','সন্তোষপুর','santoshpurup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('685','69','Gachhua','গাছুয়া','gachhuaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('686','69','Bauria','বাউরিয়া','bauriaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('687','69','Haramia','হারামিয়া','haramiaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('688','69','Magdhara','মগধরা','magdharaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('689','69','Maitbhanga','মাইটভাঙ্গা','maitbhangaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('690','69','Sarikait','সারিকাইত','sarikaitup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('691','69','Musapur','মুছাপুর','musapurup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('692','69','Azimpur','আজিমপুর','azimpurup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('693','69','Urirchar','উড়িরচর','urircharup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('694','70','Pukuria','পুকুরিয়া','pukuriaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('695','70','Sadhanpur','সাধনপুর','sadhanpurup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('696','70','Khankhanabad','খানখানাবাদ','khankhanabadup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('697','70','Baharchhara','বাহারছড়া','baharchharaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('698','70','Kalipur','কালীপুর','kalipurup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('699','70','Bailchhari','বৈলছড়ি','bailchhariup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('700','70','Katharia','কাথরিয়া','kathariaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('701','70','Saral','সরল','saralup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('702','70','Silk','শীলকুপ','silkupup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('703','70','Chambal','চাম্বল','chambalup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('704','70','Gandamara','গন্ডামারা','gandamaraup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('705','70','Sekherkhil','শেখেরখীল','sekherkhilup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('706','70','Puichhari','পুঁইছড়ি','puichhariup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('707','70','Chhanua','ছনুয়া','chhanuaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('708','71','Kandhurkhil','কধুরখীল','kandhurkhilup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('709','71','Pashchim Gamdandi','পশ্চিম গোমদন্ডী','pashchimgamdandiup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('710','71','Purba Gomdandi','পুর্ব গোমদন্ডী','purbagomdandiup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('711','71','Sakpura','শাকপুরা','sakpuraup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('712','71','Saroatali','সারোয়াতলী','saroataliup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('713','71','Popadia','পোপাদিয়া','popadiaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('714','71','Charandwi','চরনদ্বীপ','charandwipup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('715','71','Sreepur-Kharandwi','শ্রীপুর-খরন্দীপ','sreepurkharandwipup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('716','71','Amuchia','আমুচিয়া','amuchiaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('717','71','Ahla Karaldenga','আহল্লা করলডেঙ্গা','ahlakaraldengaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('718','72','Boirag','বৈরাগ','boiragup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('719','72','Barasat','বারশত','barasatup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('720','72','Raipur','রায়পুর','raipurup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('721','72','Battali','বটতলী','battaliup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('722','72','Barumchara','বরম্নমচড়া','barumcharaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('723','72','Baroakhan','বারখাইন','baroakhanup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('724','72','Anwara','আনোয়ারা','anwaraup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('725','72','Chatari','চাতরী','chatariup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('726','72','Paraikora','পরৈকোড়া','paraikoraup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('727','72','Haildhar','হাইলধর','haildharup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('728','72','Juidandi','জুঁইদন্ডী','juidandiup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('729','73','Kanchanabad','কাঞ্চনাবাদ','kanchanabadup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('730','73','Joara','জোয়ারা','joaraup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('731','73','Barkal','বরকল','barkalup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('732','73','Barama','বরমা','baramaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('733','73','Bailtali','বৈলতলী','bailtaliup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('734','73','Satbaria','সাতবাড়িয়া','satbariaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('735','73','Hashimpur','হাশিমপুর','hashimpurup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('736','73','Dohazari','দোহাজারী','dohazariup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('737','73','Dhopachhari','ধোপাছড়ী','dhopachhariup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('738','74','Charati','চরতী','charatiup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('739','74','Khagaria','খাগরিয়া','khagariaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('740','74','Nalua','নলুয়া','naluaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('741','74','Kanchana','কাঞ্চনা','kanchanaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('742','74','Amilaisi','আমিলাইশ','amilaisiup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('743','74','Eochiai','এওচিয়া','eochiaiup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('744','74','Madarsa','মাদার্শা','madarsaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('745','74','Dhemsa','ঢেমশা','dhemsaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('746','74','Paschim Dhemsa','পশ্চিম ঢেমশা','paschimdhemsaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('747','74','Keochia','কেঁওচিয়া','keochiaup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');

INSERT INTO unions (id, upazila_id, name, bn_name, url, created_at, updated_at) VALUES ('748','74','Kaliais','কালিয়াইশ','kaliaisup.chittagong.gov.bd','2025-12-02 15:14:34','2025-12-02 15:14:34');


CREATE TABLE `units` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>Active; 0=>Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `upazilas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `district_id` int NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bn_name` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lon` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=499 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('1','1','Debidwar','দেবিদ্বার','','','debidwar.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('2','1','Barura','বরুড়া','','','barura.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('3','1','Brahmanpara','ব্রাহ্মণপাড়া','','','brahmanpara.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('4','1','Chandina','চান্দিনা','','','chandina.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('5','1','Chauddagram','চৌদ্দগ্রাম','','','chauddagram.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('6','1','Daudkandi','দাউদকান্দি','','','daudkandi.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('7','1','Homna','হোমনা','','','homna.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('8','1','Laksam','লাকসাম','','','laksam.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('9','1','Muradnagar','মুরাদনগর','','','muradnagar.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('10','1','Nangalkot','নাঙ্গলকোট','','','nangalkot.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('11','1','Comilla Sadar','কুমিল্লা সদর','','','comillasadar.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('12','1','Meghna','মেঘনা','','','meghna.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('13','1','Monohargonj','মনোহরগঞ্জ','','','monohargonj.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('14','1','Sadarsouth','সদর দক্ষিণ','','','sadarsouth.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('15','1','Titas','তিতাস','','','titas.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('16','1','Burichang','বুড়িচং','','','burichang.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('17','1','Lalmai','লালমাই','','','lalmai.comilla.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('18','2','Chhagalnaiya','ছাগলনাইয়া','','','chhagalnaiya.feni.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('19','2','Feni Sadar','ফেনী সদর','','','sadar.feni.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('20','2','Sonagazi','সোনাগাজী','','','sonagazi.feni.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('21','2','Fulgazi','ফুলগাজী','','','fulgazi.feni.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('22','2','Parshuram','পরশুরাম','','','parshuram.feni.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('23','2','Daganbhuiyan','দাগনভূঞা','','','daganbhuiyan.feni.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('24','3','Brahmanbaria Sadar','ব্রাহ্মণবাড়িয়া সদর','','','sadar.brahmanbaria.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('25','3','Kasba','কসবা','','','kasba.brahmanbaria.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('26','3','Nasirnagar','নাসিরনগর','','','nasirnagar.brahmanbaria.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('27','3','Sarail','সরাইল','','','sarail.brahmanbaria.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('28','3','Ashuganj','আশুগঞ্জ','','','ashuganj.brahmanbaria.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('29','3','Akhaura','আখাউড়া','','','akhaura.brahmanbaria.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('30','3','Nabinagar','নবীনগর','','','nabinagar.brahmanbaria.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('31','3','Bancharampur','বাঞ্ছারামপুর','','','bancharampur.brahmanbaria.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('32','3','Bijoynagar','বিজয়নগর','','','bijoynagar.brahmanbaria.gov.bd    ','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('33','4','Rangamati Sadar','রাঙ্গামাটি সদর','','','sadar.rangamati.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('34','4','Kaptai','কাপ্তাই','','','kaptai.rangamati.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('35','4','Kawkhali','কাউখালী','','','kawkhali.rangamati.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('36','4','Baghaichari','বাঘাইছড়ি','','','baghaichari.rangamati.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('37','4','Barkal','বরকল','','','barkal.rangamati.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('38','4','Langadu','লংগদু','','','langadu.rangamati.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('39','4','Rajasthali','রাজস্থলী','','','rajasthali.rangamati.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('40','4','Belaichari','বিলাইছড়ি','','','belaichari.rangamati.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('41','4','Juraichari','জুরাছড়ি','','','juraichari.rangamati.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('42','4','Naniarchar','নানিয়ারচর','','','naniarchar.rangamati.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('43','5','Noakhali Sadar','নোয়াখালী সদর','','','sadar.noakhali.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('44','5','Companiganj','কোম্পানীগঞ্জ','','','companiganj.noakhali.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('45','5','Begumganj','বেগমগঞ্জ','','','begumganj.noakhali.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('46','5','Hatia','হাতিয়া','','','hatia.noakhali.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('47','5','Subarnachar','সুবর্ণচর','','','subarnachar.noakhali.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('48','5','Kabirhat','কবিরহাট','','','kabirhat.noakhali.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('49','5','Senbug','সেনবাগ','','','senbug.noakhali.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('50','5','Chatkhil','চাটখিল','','','chatkhil.noakhali.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('51','5','Sonaimori','সোনাইমুড়ী','','','sonaimori.noakhali.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('52','6','Haimchar','হাইমচর','','','haimchar.chandpur.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('53','6','Kachua','কচুয়া','','','kachua.chandpur.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('54','6','Shahrasti','শাহরাস্তি	','','','shahrasti.chandpur.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('55','6','Chandpur Sadar','চাঁদপুর সদর','','','sadar.chandpur.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('56','6','Matlab South','মতলব দক্ষিণ','','','matlabsouth.chandpur.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('57','6','Hajiganj','হাজীগঞ্জ','','','hajiganj.chandpur.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('58','6','Matlab North','মতলব উত্তর','','','matlabnorth.chandpur.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('59','6','Faridgonj','ফরিদগঞ্জ','','','faridgonj.chandpur.gov.bd','2025-12-02 15:14:29','2025-12-02 15:14:29');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('60','7','Lakshmipur Sadar','লক্ষ্মীপুর সদর','','','sadar.lakshmipur.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('61','7','Kamalnagar','কমলনগর','','','kamalnagar.lakshmipur.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('62','7','Raipur','রায়পুর','','','raipur.lakshmipur.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('63','7','Ramgati','রামগতি','','','ramgati.lakshmipur.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('64','7','Ramganj','রামগঞ্জ','','','ramganj.lakshmipur.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('65','8','Rangunia','রাঙ্গুনিয়া','','','rangunia.chittagong.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('66','8','Sitakunda','সীতাকুন্ড','','','sitakunda.chittagong.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('67','8','Mirsharai','মীরসরাই','','','mirsharai.chittagong.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('68','8','Patiya','পটিয়া','','','patiya.chittagong.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('69','8','Sandwip','সন্দ্বীপ','','','sandwip.chittagong.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('70','8','Banshkhali','বাঁশখালী','','','banshkhali.chittagong.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('71','8','Boalkhali','বোয়ালখালী','','','boalkhali.chittagong.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('72','8','Anwara','আনোয়ারা','','','anwara.chittagong.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('73','8','Chandanaish','চন্দনাইশ','','','chandanaish.chittagong.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('74','8','Satkania','সাতকানিয়া','','','satkania.chittagong.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('75','8','Lohagara','লোহাগাড়া','','','lohagara.chittagong.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('76','8','Hathazari','হাটহাজারী','','','hathazari.chittagong.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('77','8','Fatikchhari','ফটিকছড়ি','','','fatikchhari.chittagong.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('78','8','Raozan','রাউজান','','','raozan.chittagong.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('79','8','Karnafuli','কর্ণফুলী','','','karnafuli.chittagong.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('80','9','Coxsbazar Sadar','কক্সবাজার সদর','','','sadar.coxsbazar.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('81','9','Chakaria','চকরিয়া','','','chakaria.coxsbazar.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('82','9','Kutubdia','কুতুবদিয়া','','','kutubdia.coxsbazar.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('83','9','Ukhiya','উখিয়া','','','ukhiya.coxsbazar.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('84','9','Moheshkhali','মহেশখালী','','','moheshkhali.coxsbazar.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('85','9','Pekua','পেকুয়া','','','pekua.coxsbazar.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('86','9','Ramu','রামু','','','ramu.coxsbazar.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('87','9','Teknaf','টেকনাফ','','','teknaf.coxsbazar.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('88','10','Khagrachhari Sadar','খাগড়াছড়ি সদর','','','sadar.khagrachhari.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('89','10','Dighinala','দিঘীনালা','','','dighinala.khagrachhari.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('90','10','Panchari','পানছড়ি','','','panchari.khagrachhari.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('91','10','Laxmichhari','লক্ষীছড়ি','','','laxmichhari.khagrachhari.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('92','10','Mohalchari','মহালছড়ি','','','mohalchari.khagrachhari.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('93','10','Manikchari','মানিকছড়ি','','','manikchari.khagrachhari.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('94','10','Ramgarh','রামগড়','','','ramgarh.khagrachhari.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('95','10','Matiranga','মাটিরাঙ্গা','','','matiranga.khagrachhari.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('96','10','Guimara','গুইমারা','','','guimara.khagrachhari.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('97','11','Bandarban Sadar','বান্দরবান সদর','','','sadar.bandarban.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('98','11','Alikadam','আলীকদম','','','alikadam.bandarban.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('99','11','Naikhongchhari','নাইক্ষ্যংছড়ি','','','naikhongchhari.bandarban.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('100','11','Rowangchhari','রোয়াংছড়ি','','','rowangchhari.bandarban.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('101','11','Lama','লামা','','','lama.bandarban.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('102','11','Ruma','রুমা','','','ruma.bandarban.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('103','11','Thanchi','থানচি','','','thanchi.bandarban.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('104','12','Belkuchi','বেলকুচি','','','belkuchi.sirajganj.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('105','12','Chauhali','চৌহালি','','','chauhali.sirajganj.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('106','12','Kamarkhand','কামারখন্দ','','','kamarkhand.sirajganj.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('107','12','Kazipur','কাজীপুর','','','kazipur.sirajganj.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('108','12','Raigonj','রায়গঞ্জ','','','raigonj.sirajganj.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('109','12','Shahjadpur','শাহজাদপুর','','','shahjadpur.sirajganj.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('110','12','Sirajganj Sadar','সিরাজগঞ্জ সদর','','','sirajganjsadar.sirajganj.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('111','12','Tarash','তাড়াশ','','','tarash.sirajganj.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('112','12','Ullapara','উল্লাপাড়া','','','ullapara.sirajganj.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('113','13','Sujanagar','সুজানগর','','','sujanagar.pabna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('114','13','Ishurdi','ঈশ্বরদী','','','ishurdi.pabna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('115','13','Bhangura','ভাঙ্গুড়া','','','bhangura.pabna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('116','13','Pabna Sadar','পাবনা সদর','','','pabnasadar.pabna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('117','13','Bera','বেড়া','','','bera.pabna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('118','13','Atghoria','আটঘরিয়া','','','atghoria.pabna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('119','13','Chatmohar','চাটমোহর','','','chatmohar.pabna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('120','13','Santhia','সাঁথিয়া','','','santhia.pabna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('121','13','Faridpur','ফরিদপুর','','','faridpur.pabna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('122','14','Kahaloo','কাহালু','','','kahaloo.bogra.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('123','14','Bogra Sadar','বগুড়া সদর','','','sadar.bogra.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('124','14','Shariakandi','সারিয়াকান্দি','','','shariakandi.bogra.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('125','14','Shajahanpur','শাজাহানপুর','','','shajahanpur.bogra.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('126','14','Dupchanchia','দুপচাচিঁয়া','','','dupchanchia.bogra.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('127','14','Adamdighi','আদমদিঘি','','','adamdighi.bogra.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('128','14','Nondigram','নন্দিগ্রাম','','','nondigram.bogra.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('129','14','Sonatala','সোনাতলা','','','sonatala.bogra.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('130','14','Dhunot','ধুনট','','','dhunot.bogra.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('131','14','Gabtali','গাবতলী','','','gabtali.bogra.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('132','14','Sherpur','শেরপুর','','','sherpur.bogra.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('133','14','Shibganj','শিবগঞ্জ','','','shibganj.bogra.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('134','15','Paba','পবা','','','paba.rajshahi.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('135','15','Durgapur','দুর্গাপুর','','','durgapur.rajshahi.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('136','15','Mohonpur','মোহনপুর','','','mohonpur.rajshahi.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('137','15','Charghat','চারঘাট','','','charghat.rajshahi.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('138','15','Puthia','পুঠিয়া','','','puthia.rajshahi.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('139','15','Bagha','বাঘা','','','bagha.rajshahi.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('140','15','Godagari','গোদাগাড়ী','','','godagari.rajshahi.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('141','15','Tanore','তানোর','','','tanore.rajshahi.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('142','15','Bagmara','বাগমারা','','','bagmara.rajshahi.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('143','16','Natore Sadar','নাটোর সদর','','','natoresadar.natore.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('144','16','Singra','সিংড়া','','','singra.natore.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('145','16','Baraigram','বড়াইগ্রাম','','','baraigram.natore.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('146','16','Bagatipara','বাগাতিপাড়া','','','bagatipara.natore.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('147','16','Lalpur','লালপুর','','','lalpur.natore.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('148','16','Gurudaspur','গুরুদাসপুর','','','gurudaspur.natore.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('149','16','Naldanga','নলডাঙ্গা','','','naldanga.natore.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('150','17','Akkelpur','আক্কেলপুর','','','akkelpur.joypurhat.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('151','17','Kalai','কালাই','','','kalai.joypurhat.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('152','17','Khetlal','ক্ষেতলাল','','','khetlal.joypurhat.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('153','17','Panchbibi','পাঁচবিবি','','','panchbibi.joypurhat.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('154','17','Joypurhat Sadar','জয়পুরহাট সদর','','','joypurhatsadar.joypurhat.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('155','18','Chapainawabganj Sadar','চাঁপাইনবাবগঞ্জ সদর','','','chapainawabganjsadar.chapainawabganj.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('156','18','Gomostapur','গোমস্তাপুর','','','gomostapur.chapainawabganj.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('157','18','Nachol','নাচোল','','','nachol.chapainawabganj.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('158','18','Bholahat','ভোলাহাট','','','bholahat.chapainawabganj.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('159','18','Shibganj','শিবগঞ্জ','','','shibganj.chapainawabganj.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('160','19','Mohadevpur','মহাদেবপুর','','','mohadevpur.naogaon.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('161','19','Badalgachi','বদলগাছী','','','badalgachi.naogaon.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('162','19','Patnitala','পত্নিতলা','','','patnitala.naogaon.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('163','19','Dhamoirhat','ধামইরহাট','','','dhamoirhat.naogaon.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('164','19','Niamatpur','নিয়ামতপুর','','','niamatpur.naogaon.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('165','19','Manda','মান্দা','','','manda.naogaon.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('166','19','Atrai','আত্রাই','','','atrai.naogaon.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('167','19','Raninagar','রাণীনগর','','','raninagar.naogaon.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('168','19','Naogaon Sadar','নওগাঁ সদর','','','naogaonsadar.naogaon.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('169','19','Porsha','পোরশা','','','porsha.naogaon.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('170','19','Sapahar','সাপাহার','','','sapahar.naogaon.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('171','20','Manirampur','মণিরামপুর','','','manirampur.jessore.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('172','20','Abhaynagar','অভয়নগর','','','abhaynagar.jessore.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('173','20','Bagherpara','বাঘারপাড়া','','','bagherpara.jessore.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('174','20','Chougachha','চৌগাছা','','','chougachha.jessore.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('175','20','Jhikargacha','ঝিকরগাছা','','','jhikargacha.jessore.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('176','20','Keshabpur','কেশবপুর','','','keshabpur.jessore.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('177','20','Jessore Sadar','যশোর সদর','','','sadar.jessore.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('178','20','Sharsha','শার্শা','','','sharsha.jessore.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('179','21','Assasuni','আশাশুনি','','','assasuni.satkhira.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('180','21','Debhata','দেবহাটা','','','debhata.satkhira.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('181','21','Kalaroa','কলারোয়া','','','kalaroa.satkhira.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('182','21','Satkhira Sadar','সাতক্ষীরা সদর','','','satkhirasadar.satkhira.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('183','21','Shyamnagar','শ্যামনগর','','','shyamnagar.satkhira.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('184','21','Tala','তালা','','','tala.satkhira.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('185','21','Kaliganj','কালিগঞ্জ','','','kaliganj.satkhira.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('186','22','Mujibnagar','মুজিবনগর','','','mujibnagar.meherpur.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('187','22','Meherpur Sadar','মেহেরপুর সদর','','','meherpursadar.meherpur.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('188','22','Gangni','গাংনী','','','gangni.meherpur.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('189','23','Narail Sadar','নড়াইল সদর','','','narailsadar.narail.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('190','23','Lohagara','লোহাগড়া','','','lohagara.narail.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('191','23','Kalia','কালিয়া','','','kalia.narail.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('192','24','Chuadanga Sadar','চুয়াডাঙ্গা সদর','','','chuadangasadar.chuadanga.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('193','24','Alamdanga','আলমডাঙ্গা','','','alamdanga.chuadanga.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('194','24','Damurhuda','দামুড়হুদা','','','damurhuda.chuadanga.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('195','24','Jibannagar','জীবননগর','','','jibannagar.chuadanga.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('196','25','Kushtia Sadar','কুষ্টিয়া সদর','','','kushtiasadar.kushtia.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('197','25','Kumarkhali','কুমারখালী','','','kumarkhali.kushtia.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('198','25','Khoksa','খোকসা','','','khoksa.kushtia.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('199','25','Mirpur','মিরপুর','','','mirpurkushtia.kushtia.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('200','25','Daulatpur','দৌলতপুর','','','daulatpur.kushtia.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('201','25','Bheramara','ভেড়ামারা','','','bheramara.kushtia.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('202','26','Shalikha','শালিখা','','','shalikha.magura.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('203','26','Sreepur','শ্রীপুর','','','sreepur.magura.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('204','26','Magura Sadar','মাগুরা সদর','','','magurasadar.magura.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('205','26','Mohammadpur','মহম্মদপুর','','','mohammadpur.magura.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('206','27','Paikgasa','পাইকগাছা','','','paikgasa.khulna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('207','27','Fultola','ফুলতলা','','','fultola.khulna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('208','27','Digholia','দিঘলিয়া','','','digholia.khulna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('209','27','Rupsha','রূপসা','','','rupsha.khulna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('210','27','Terokhada','তেরখাদা','','','terokhada.khulna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('211','27','Dumuria','ডুমুরিয়া','','','dumuria.khulna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('212','27','Botiaghata','বটিয়াঘাটা','','','botiaghata.khulna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('213','27','Dakop','দাকোপ','','','dakop.khulna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('214','27','Koyra','কয়রা','','','koyra.khulna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('215','28','Fakirhat','ফকিরহাট','','','fakirhat.bagerhat.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('216','28','Bagerhat Sadar','বাগেরহাট সদর','','','sadar.bagerhat.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('217','28','Mollahat','মোল্লাহাট','','','mollahat.bagerhat.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('218','28','Sarankhola','শরণখোলা','','','sarankhola.bagerhat.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('219','28','Rampal','রামপাল','','','rampal.bagerhat.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('220','28','Morrelganj','মোড়েলগঞ্জ','','','morrelganj.bagerhat.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('221','28','Kachua','কচুয়া','','','kachua.bagerhat.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('222','28','Mongla','মোংলা','','','mongla.bagerhat.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('223','28','Chitalmari','চিতলমারী','','','chitalmari.bagerhat.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('224','29','Jhenaidah Sadar','ঝিনাইদহ সদর','','','sadar.jhenaidah.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('225','29','Shailkupa','শৈলকুপা','','','shailkupa.jhenaidah.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('226','29','Harinakundu','হরিণাকুন্ডু','','','harinakundu.jhenaidah.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('227','29','Kaliganj','কালীগঞ্জ','','','kaliganj.jhenaidah.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('228','29','Kotchandpur','কোটচাঁদপুর','','','kotchandpur.jhenaidah.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('229','29','Moheshpur','মহেশপুর','','','moheshpur.jhenaidah.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('230','30','Jhalakathi Sadar','ঝালকাঠি সদর','','','sadar.jhalakathi.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('231','30','Kathalia','কাঠালিয়া','','','kathalia.jhalakathi.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('232','30','Nalchity','নলছিটি','','','nalchity.jhalakathi.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('233','30','Rajapur','রাজাপুর','','','rajapur.jhalakathi.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('234','31','Bauphal','বাউফল','','','bauphal.patuakhali.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('235','31','Patuakhali Sadar','পটুয়াখালী সদর','','','sadar.patuakhali.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('236','31','Dumki','দুমকি','','','dumki.patuakhali.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('237','31','Dashmina','দশমিনা','','','dashmina.patuakhali.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('238','31','Kalapara','কলাপাড়া','','','kalapara.patuakhali.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('239','31','Mirzaganj','মির্জাগঞ্জ','','','mirzaganj.patuakhali.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('240','31','Galachipa','গলাচিপা','','','galachipa.patuakhali.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('241','31','Rangabali','রাঙ্গাবালী','','','rangabali.patuakhali.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('242','32','Pirojpur Sadar','পিরোজপুর সদর','','','sadar.pirojpur.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('243','32','Nazirpur','নাজিরপুর','','','nazirpur.pirojpur.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('244','32','Kawkhali','কাউখালী','','','kawkhali.pirojpur.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('245','32','Zianagar','জিয়ানগর','','','zianagar.pirojpur.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('246','32','Bhandaria','ভান্ডারিয়া','','','bhandaria.pirojpur.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('247','32','Mathbaria','মঠবাড়ীয়া','','','mathbaria.pirojpur.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('248','32','Nesarabad','নেছারাবাদ','','','nesarabad.pirojpur.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('249','33','Barisal Sadar','বরিশাল সদর','','','barisalsadar.barisal.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('250','33','Bakerganj','বাকেরগঞ্জ','','','bakerganj.barisal.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('251','33','Babuganj','বাবুগঞ্জ','','','babuganj.barisal.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('252','33','Wazirpur','উজিরপুর','','','wazirpur.barisal.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('253','33','Banaripara','বানারীপাড়া','','','banaripara.barisal.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('254','33','Gournadi','গৌরনদী','','','gournadi.barisal.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('255','33','Agailjhara','আগৈলঝাড়া','','','agailjhara.barisal.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('256','33','Mehendiganj','মেহেন্দিগঞ্জ','','','mehendiganj.barisal.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('257','33','Muladi','মুলাদী','','','muladi.barisal.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('258','33','Hizla','হিজলা','','','hizla.barisal.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('259','34','Bhola Sadar','ভোলা সদর','','','sadar.bhola.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('260','34','Borhan Sddin','বোরহান উদ্দিন','','','borhanuddin.bhola.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('261','34','Charfesson','চরফ্যাশন','','','charfesson.bhola.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('262','34','Doulatkhan','দৌলতখান','','','doulatkhan.bhola.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('263','34','Monpura','মনপুরা','','','monpura.bhola.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('264','34','Tazumuddin','তজুমদ্দিন','','','tazumuddin.bhola.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('265','34','Lalmohan','লালমোহন','','','lalmohan.bhola.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('266','35','Amtali','আমতলী','','','amtali.barguna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('267','35','Barguna Sadar','বরগুনা সদর','','','sadar.barguna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('268','35','Betagi','বেতাগী','','','betagi.barguna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('269','35','Bamna','বামনা','','','bamna.barguna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('270','35','Pathorghata','পাথরঘাটা','','','pathorghata.barguna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('271','35','Taltali','তালতলি','','','taltali.barguna.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('272','36','Balaganj','বালাগঞ্জ','','','balaganj.sylhet.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('273','36','Beanibazar','বিয়ানীবাজার','','','beanibazar.sylhet.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('274','36','Bishwanath','বিশ্বনাথ','','','bishwanath.sylhet.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('275','36','Companiganj','কোম্পানীগঞ্জ','','','companiganj.sylhet.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('276','36','Fenchuganj','ফেঞ্চুগঞ্জ','','','fenchuganj.sylhet.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('277','36','Golapganj','গোলাপগঞ্জ','','','golapganj.sylhet.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('278','36','Gowainghat','গোয়াইনঘাট','','','gowainghat.sylhet.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('279','36','Jaintiapur','জৈন্তাপুর','','','jaintiapur.sylhet.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('280','36','Kanaighat','কানাইঘাট','','','kanaighat.sylhet.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('281','36','Sylhet Sadar','সিলেট সদর','','','sylhetsadar.sylhet.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('282','36','Zakiganj','জকিগঞ্জ','','','zakiganj.sylhet.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('283','36','Dakshinsurma','দক্ষিণ সুরমা','','','dakshinsurma.sylhet.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('284','36','Osmaninagar','ওসমানী নগর','','','osmaninagar.sylhet.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('285','37','Barlekha','বড়লেখা','','','barlekha.moulvibazar.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('286','37','Kamolganj','কমলগঞ্জ','','','kamolganj.moulvibazar.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('287','37','Kulaura','কুলাউড়া','','','kulaura.moulvibazar.gov.bd','2025-12-02 15:14:30','2025-12-02 15:14:30');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('288','37','Moulvibazar Sadar','মৌলভীবাজার সদর','','','moulvibazarsadar.moulvibazar.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('289','37','Rajnagar','রাজনগর','','','rajnagar.moulvibazar.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('290','37','Sreemangal','শ্রীমঙ্গল','','','sreemangal.moulvibazar.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('291','37','Juri','জুড়ী','','','juri.moulvibazar.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('292','38','Nabiganj','নবীগঞ্জ','','','nabiganj.habiganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('293','38','Bahubal','বাহুবল','','','bahubal.habiganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('294','38','Ajmiriganj','আজমিরীগঞ্জ','','','ajmiriganj.habiganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('295','38','Baniachong','বানিয়াচং','','','baniachong.habiganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('296','38','Lakhai','লাখাই','','','lakhai.habiganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('297','38','Chunarughat','চুনারুঘাট','','','chunarughat.habiganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('298','38','Habiganj Sadar','হবিগঞ্জ সদর','','','habiganjsadar.habiganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('299','38','Madhabpur','মাধবপুর','','','madhabpur.habiganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('300','39','Sunamganj Sadar','সুনামগঞ্জ সদর','','','sadar.sunamganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('301','39','South Sunamganj','দক্ষিণ সুনামগঞ্জ','','','southsunamganj.sunamganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('302','39','Bishwambarpur','বিশ্বম্ভরপুর','','','bishwambarpur.sunamganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('303','39','Chhatak','ছাতক','','','chhatak.sunamganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('304','39','Jagannathpur','জগন্নাথপুর','','','jagannathpur.sunamganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('305','39','Dowarabazar','দোয়ারাবাজার','','','dowarabazar.sunamganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('306','39','Tahirpur','তাহিরপুর','','','tahirpur.sunamganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('307','39','Dharmapasha','ধর্মপাশা','','','dharmapasha.sunamganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('308','39','Jamalganj','জামালগঞ্জ','','','jamalganj.sunamganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('309','39','Shalla','শাল্লা','','','shalla.sunamganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('310','39','Derai','দিরাই','','','derai.sunamganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('311','40','Belabo','বেলাবো','','','belabo.narsingdi.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('312','40','Monohardi','মনোহরদী','','','monohardi.narsingdi.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('313','40','Narsingdi Sadar','নরসিংদী সদর','','','narsingdisadar.narsingdi.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('314','40','Palash','পলাশ','','','palash.narsingdi.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('315','40','Raipura','রায়পুরা','','','raipura.narsingdi.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('316','40','Shibpur','শিবপুর','','','shibpur.narsingdi.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('317','41','Kaliganj','কালীগঞ্জ','','','kaliganj.gazipur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('318','41','Kaliakair','কালিয়াকৈর','','','kaliakair.gazipur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('319','41','Kapasia','কাপাসিয়া','','','kapasia.gazipur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('320','41','Gazipur Sadar','গাজীপুর সদর','','','sadar.gazipur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('321','41','Sreepur','শ্রীপুর','','','sreepur.gazipur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('322','42','Shariatpur Sadar','শরিয়তপুর সদর','','','sadar.shariatpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('323','42','Naria','নড়িয়া','','','naria.shariatpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('324','42','Zajira','জাজিরা','','','zajira.shariatpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('325','42','Gosairhat','গোসাইরহাট','','','gosairhat.shariatpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('326','42','Bhedarganj','ভেদরগঞ্জ','','','bhedarganj.shariatpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('327','42','Damudya','ডামুড্যা','','','damudya.shariatpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('328','43','Araihazar','আড়াইহাজার','','','araihazar.narayanganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('329','43','Bandar','বন্দর','','','bandar.narayanganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('330','43','Narayanganj Sadar','নারায়নগঞ্জ সদর','','','narayanganjsadar.narayanganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('331','43','Rupganj','রূপগঞ্জ','','','rupganj.narayanganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('332','43','Sonargaon','সোনারগাঁ','','','sonargaon.narayanganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('333','44','Basail','বাসাইল','','','basail.tangail.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('334','44','Bhuapur','ভুয়াপুর','','','bhuapur.tangail.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('335','44','Delduar','দেলদুয়ার','','','delduar.tangail.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('336','44','Ghatail','ঘাটাইল','','','ghatail.tangail.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('337','44','Gopalpur','গোপালপুর','','','gopalpur.tangail.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('338','44','Madhupur','মধুপুর','','','madhupur.tangail.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('339','44','Mirzapur','মির্জাপুর','','','mirzapur.tangail.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('340','44','Nagarpur','নাগরপুর','','','nagarpur.tangail.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('341','44','Sakhipur','সখিপুর','','','sakhipur.tangail.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('342','44','Tangail Sadar','টাঙ্গাইল সদর','','','tangailsadar.tangail.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('343','44','Kalihati','কালিহাতী','','','kalihati.tangail.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('344','44','Dhanbari','ধনবাড়ী','','','dhanbari.tangail.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('345','45','Itna','ইটনা','','','itna.kishoreganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('346','45','Katiadi','কটিয়াদী','','','katiadi.kishoreganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('347','45','Bhairab','ভৈরব','','','bhairab.kishoreganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('348','45','Tarail','তাড়াইল','','','tarail.kishoreganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('349','45','Hossainpur','হোসেনপুর','','','hossainpur.kishoreganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('350','45','Pakundia','পাকুন্দিয়া','','','pakundia.kishoreganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('351','45','Kuliarchar','কুলিয়ারচর','','','kuliarchar.kishoreganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('352','45','Kishoreganj Sadar','কিশোরগঞ্জ সদর','','','kishoreganjsadar.kishoreganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('353','45','Karimgonj','করিমগঞ্জ','','','karimgonj.kishoreganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('354','45','Bajitpur','বাজিতপুর','','','bajitpur.kishoreganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('355','45','Austagram','অষ্টগ্রাম','','','austagram.kishoreganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('356','45','Mithamoin','মিঠামইন','','','mithamoin.kishoreganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('357','45','Nikli','নিকলী','','','nikli.kishoreganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('358','46','Harirampur','হরিরামপুর','','','harirampur.manikganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('359','46','Saturia','সাটুরিয়া','','','saturia.manikganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('360','46','Manikganj Sadar','মানিকগঞ্জ সদর','','','sadar.manikganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('361','46','Gior','ঘিওর','','','gior.manikganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('362','46','Shibaloy','শিবালয়','','','shibaloy.manikganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('363','46','Doulatpur','দৌলতপুর','','','doulatpur.manikganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('364','46','Singiar','সিংগাইর','','','singiar.manikganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('365','47','Savar','সাভার','','','savar.dhaka.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('366','47','Dhamrai','ধামরাই','','','dhamrai.dhaka.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('367','47','Keraniganj','কেরাণীগঞ্জ','','','keraniganj.dhaka.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('368','47','Nawabganj','নবাবগঞ্জ','','','nawabganj.dhaka.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('369','47','Dohar','দোহার','','','dohar.dhaka.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('370','48','Munshiganj Sadar','মুন্সিগঞ্জ সদর','','','sadar.munshiganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('371','48','Sreenagar','শ্রীনগর','','','sreenagar.munshiganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('372','48','Sirajdikhan','সিরাজদিখান','','','sirajdikhan.munshiganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('373','48','Louhajanj','লৌহজং','','','louhajanj.munshiganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('374','48','Gajaria','গজারিয়া','','','gajaria.munshiganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('375','48','Tongibari','টংগীবাড়ি','','','tongibari.munshiganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('376','49','Rajbari Sadar','রাজবাড়ী সদর','','','sadar.rajbari.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('377','49','Goalanda','গোয়ালন্দ','','','goalanda.rajbari.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('378','49','Pangsa','পাংশা','','','pangsa.rajbari.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('379','49','Baliakandi','বালিয়াকান্দি','','','baliakandi.rajbari.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('380','49','Kalukhali','কালুখালী','','','kalukhali.rajbari.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('381','50','Madaripur Sadar','মাদারীপুর সদর','','','sadar.madaripur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('382','50','Shibchar','শিবচর','','','shibchar.madaripur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('383','50','Kalkini','কালকিনি','','','kalkini.madaripur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('384','50','Rajoir','রাজৈর','','','rajoir.madaripur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('385','51','Gopalganj Sadar','গোপালগঞ্জ সদর','','','sadar.gopalganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('386','51','Kashiani','কাশিয়ানী','','','kashiani.gopalganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('387','51','Tungipara','টুংগীপাড়া','','','tungipara.gopalganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('388','51','Kotalipara','কোটালীপাড়া','','','kotalipara.gopalganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('389','51','Muksudpur','মুকসুদপুর','','','muksudpur.gopalganj.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('390','52','Faridpur Sadar','ফরিদপুর সদর','','','sadar.faridpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('391','52','Alfadanga','আলফাডাঙ্গা','','','alfadanga.faridpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('392','52','Boalmari','বোয়ালমারী','','','boalmari.faridpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('393','52','Sadarpur','সদরপুর','','','sadarpur.faridpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('394','52','Nagarkanda','নগরকান্দা','','','nagarkanda.faridpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('395','52','Bhanga','ভাঙ্গা','','','bhanga.faridpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('396','52','Charbhadrasan','চরভদ্রাসন','','','charbhadrasan.faridpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('397','52','Madhukhali','মধুখালী','','','madhukhali.faridpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('398','52','Saltha','সালথা','','','saltha.faridpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('399','53','Panchagarh Sadar','পঞ্চগড় সদর','','','panchagarhsadar.panchagarh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('400','53','Debiganj','দেবীগঞ্জ','','','debiganj.panchagarh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('401','53','Boda','বোদা','','','boda.panchagarh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('402','53','Atwari','আটোয়ারী','','','atwari.panchagarh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('403','53','Tetulia','তেতুলিয়া','','','tetulia.panchagarh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('404','54','Nawabganj','নবাবগঞ্জ','','','nawabganj.dinajpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('405','54','Birganj','বীরগঞ্জ','','','birganj.dinajpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('406','54','Ghoraghat','ঘোড়াঘাট','','','ghoraghat.dinajpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('407','54','Birampur','বিরামপুর','','','birampur.dinajpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('408','54','Parbatipur','পার্বতীপুর','','','parbatipur.dinajpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('409','54','Bochaganj','বোচাগঞ্জ','','','bochaganj.dinajpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('410','54','Kaharol','কাহারোল','','','kaharol.dinajpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('411','54','Fulbari','ফুলবাড়ী','','','fulbari.dinajpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('412','54','Dinajpur Sadar','দিনাজপুর সদর','','','dinajpursadar.dinajpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('413','54','Hakimpur','হাকিমপুর','','','hakimpur.dinajpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('414','54','Khansama','খানসামা','','','khansama.dinajpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('415','54','Birol','বিরল','','','birol.dinajpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('416','54','Chirirbandar','চিরিরবন্দর','','','chirirbandar.dinajpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('417','55','Lalmonirhat Sadar','লালমনিরহাট সদর','','','sadar.lalmonirhat.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('418','55','Kaliganj','কালীগঞ্জ','','','kaliganj.lalmonirhat.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('419','55','Hatibandha','হাতীবান্ধা','','','hatibandha.lalmonirhat.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('420','55','Patgram','পাটগ্রাম','','','patgram.lalmonirhat.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('421','55','Aditmari','আদিতমারী','','','aditmari.lalmonirhat.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('422','56','Syedpur','সৈয়দপুর','','','syedpur.nilphamari.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('423','56','Domar','ডোমার','','','domar.nilphamari.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('424','56','Dimla','ডিমলা','','','dimla.nilphamari.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('425','56','Jaldhaka','জলঢাকা','','','jaldhaka.nilphamari.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('426','56','Kishorganj','কিশোরগঞ্জ','','','kishorganj.nilphamari.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('427','56','Nilphamari Sadar','নীলফামারী সদর','','','nilphamarisadar.nilphamari.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('428','57','Sadullapur','সাদুল্লাপুর','','','sadullapur.gaibandha.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('429','57','Gaibandha Sadar','গাইবান্ধা সদর','','','gaibandhasadar.gaibandha.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('430','57','Palashbari','পলাশবাড়ী','','','palashbari.gaibandha.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('431','57','Saghata','সাঘাটা','','','saghata.gaibandha.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('432','57','Gobindaganj','গোবিন্দগঞ্জ','','','gobindaganj.gaibandha.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('433','57','Sundarganj','সুন্দরগঞ্জ','','','sundarganj.gaibandha.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('434','57','Phulchari','ফুলছড়ি','','','phulchari.gaibandha.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('435','58','Thakurgaon Sadar','ঠাকুরগাঁও সদর','','','thakurgaonsadar.thakurgaon.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('436','58','Pirganj','পীরগঞ্জ','','','pirganj.thakurgaon.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('437','58','Ranisankail','রাণীশংকৈল','','','ranisankail.thakurgaon.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('438','58','Haripur','হরিপুর','','','haripur.thakurgaon.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('439','58','Baliadangi','বালিয়াডাঙ্গী','','','baliadangi.thakurgaon.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('440','59','Rangpur Sadar','রংপুর সদর','','','rangpursadar.rangpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('441','59','Gangachara','গংগাচড়া','','','gangachara.rangpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('442','59','Taragonj','তারাগঞ্জ','','','taragonj.rangpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('443','59','Badargonj','বদরগঞ্জ','','','badargonj.rangpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('444','59','Mithapukur','মিঠাপুকুর','','','mithapukur.rangpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('445','59','Pirgonj','পীরগঞ্জ','','','pirgonj.rangpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('446','59','Kaunia','কাউনিয়া','','','kaunia.rangpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('447','59','Pirgacha','পীরগাছা','','','pirgacha.rangpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('448','60','Kurigram Sadar','কুড়িগ্রাম সদর','','','kurigramsadar.kurigram.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('449','60','Nageshwari','নাগেশ্বরী','','','nageshwari.kurigram.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('450','60','Bhurungamari','ভুরুঙ্গামারী','','','bhurungamari.kurigram.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('451','60','Phulbari','ফুলবাড়ী','','','phulbari.kurigram.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('452','60','Rajarhat','রাজারহাট','','','rajarhat.kurigram.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('453','60','Ulipur','উলিপুর','','','ulipur.kurigram.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('454','60','Chilmari','চিলমারী','','','chilmari.kurigram.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('455','60','Rowmari','রৌমারী','','','rowmari.kurigram.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('456','60','Charrajibpur','চর রাজিবপুর','','','charrajibpur.kurigram.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('457','61','Sherpur Sadar','শেরপুর সদর','','','sherpursadar.sherpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('458','61','Nalitabari','নালিতাবাড়ী','','','nalitabari.sherpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('459','61','Sreebordi','শ্রীবরদী','','','sreebordi.sherpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('460','61','Nokla','নকলা','','','nokla.sherpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('461','61','Jhenaigati','ঝিনাইগাতী','','','jhenaigati.sherpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('462','62','Fulbaria','ফুলবাড়ীয়া','','','fulbaria.mymensingh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('463','62','Trishal','ত্রিশাল','','','trishal.mymensingh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('464','62','Bhaluka','ভালুকা','','','bhaluka.mymensingh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('465','62','Muktagacha','মুক্তাগাছা','','','muktagacha.mymensingh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('466','62','Mymensingh Sadar','ময়মনসিংহ সদর','','','mymensinghsadar.mymensingh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('467','62','Dhobaura','ধোবাউড়া','','','dhobaura.mymensingh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('468','62','Phulpur','ফুলপুর','','','phulpur.mymensingh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('469','62','Haluaghat','হালুয়াঘাট','','','haluaghat.mymensingh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('470','62','Gouripur','গৌরীপুর','','','gouripur.mymensingh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('471','62','Gafargaon','গফরগাঁও','','','gafargaon.mymensingh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('472','62','Iswarganj','ঈশ্বরগঞ্জ','','','iswarganj.mymensingh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('473','62','Nandail','নান্দাইল','','','nandail.mymensingh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('474','62','Tarakanda','তারাকান্দা','','','tarakanda.mymensingh.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('475','63','Jamalpur Sadar','জামালপুর সদর','','','jamalpursadar.jamalpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('476','63','Melandah','মেলান্দহ','','','melandah.jamalpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('477','63','Islampur','ইসলামপুর','','','islampur.jamalpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('478','63','Dewangonj','দেওয়ানগঞ্জ','','','dewangonj.jamalpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('479','63','Sarishabari','সরিষাবাড়ী','','','sarishabari.jamalpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('480','63','Madarganj','মাদারগঞ্জ','','','madarganj.jamalpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('481','63','Bokshiganj','বকশীগঞ্জ','','','bokshiganj.jamalpur.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('482','64','Barhatta','বারহাট্টা','','','barhatta.netrokona.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('483','64','Durgapur','দুর্গাপুর','','','durgapur.netrokona.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('484','64','Kendua','কেন্দুয়া','','','kendua.netrokona.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('485','64','Atpara','আটপাড়া','','','atpara.netrokona.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('486','64','Madan','মদন','','','madan.netrokona.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('487','64','Khaliajuri','খালিয়াজুরী','','','khaliajuri.netrokona.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('488','64','Kalmakanda','কলমাকান্দা','','','kalmakanda.netrokona.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('489','64','Mohongonj','মোহনগঞ্জ','','','mohongonj.netrokona.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('490','64','Purbadhala','পূর্বধলা','','','purbadhala.netrokona.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('491','64','Netrokona Sadar','নেত্রকোণা সদর','','','netrokonasadar.netrokona.gov.bd','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('492','9','Eidgaon','ঈদগাঁও','','','null','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('493','39','Madhyanagar','মধ্যনগর','','','null','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('494','50','Dasar','ডাসার','','','null','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('496','15','Boalia Thana','বোয়ালিয়া থানা','','','','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('497','15','Shah Mokhdum Thana','শাহ মখদুম থানা','','','','2025-12-02 15:14:31','2025-12-02 15:14:31');

INSERT INTO upazilas (id, district_id, name, bn_name, lat, lon, url, created_at, updated_at) VALUES ('498','15','Motihar Thana','মতিহার থানা','','','','2025-12-02 15:14:31','2025-12-02 15:14:31');


CREATE TABLE `user_activities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `last_seen` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_activities_user_id_foreign` (`user_id`),
  CONSTRAINT `user_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO user_activities (id, user_id, last_seen, created_at, updated_at) VALUES ('1','1','2025-12-02 18:20:18','2025-12-02 17:08:23','2025-12-02 18:20:18');


CREATE TABLE `user_addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `address_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint NOT NULL DEFAULT '0' COMMENT '0=>No; 1=>Yes',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `user_cards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1=>Visa; 2=>Master',
  `card_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiry_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default` tinyint NOT NULL DEFAULT '0' COMMENT '1=>Default; 0=>Not',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `user_role_permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned DEFAULT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission_id` bigint unsigned NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `user_roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `verification_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` tinyint NOT NULL DEFAULT '3' COMMENT '1=>Admin; 2=>User/Shop; 3=>Customer',
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `balance` double NOT NULL DEFAULT '0' COMMENT 'In BDT',
  `referral_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referred_by` bigint unsigned DEFAULT NULL,
  `wallet_balance` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT 'Wallet balance in BDT',
  `delete_request_submitted` tinyint NOT NULL DEFAULT '0' COMMENT '0=>No; 1=>Yes',
  `delete_request_submitted_at` datetime DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>Active; 0=>Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_referral_code_unique` (`referral_code`),
  KEY `users_referred_by_foreign` (`referred_by`),
  CONSTRAINT `users_referred_by_foreign` FOREIGN KEY (`referred_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO users (id, image, name, phone, email, email_verified_at, verification_code, password, provider_name, provider_id, remember_token, user_type, address, balance, referral_code, referred_by, wallet_balance, delete_request_submitted, delete_request_submitted_at, status, created_at, updated_at) VALUES ('1','','Admin User','01234567890','admin@gmail.com','2025-12-02 14:59:24','','$2y$10$CTs21716nDutsogwyHT/Ie5poNuFRyEaM8kL7lFXFwkGLGxPPlrhK','','','','1','Admin Address','0','','','0.00','0','','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO users (id, image, name, phone, email, email_verified_at, verification_code, password, provider_name, provider_id, remember_token, user_type, address, balance, referral_code, referred_by, wallet_balance, delete_request_submitted, delete_request_submitted_at, status, created_at, updated_at) VALUES ('2','','Shop User','01987654321','shop@gmail.com','2025-12-02 14:59:24','','$2y$10$974ogNr.dMPgGTMXxJBupeo/ttK0FjftPuFQH0ig.Hhko5EgFG4H6','','','','2','Shop Address','0','','','0.00','0','','1','2025-12-02 14:59:24','2025-12-02 14:59:24');

INSERT INTO users (id, image, name, phone, email, email_verified_at, verification_code, password, provider_name, provider_id, remember_token, user_type, address, balance, referral_code, referred_by, wallet_balance, delete_request_submitted, delete_request_submitted_at, status, created_at, updated_at) VALUES ('3','','Customer User','01700000000','customer@gmail.com','2025-12-02 14:59:24','','$2y$10$4Cm5KfYMjEHUyTg2aCYgx.vFvKh8M1vGgpAs9jRdpU7ykAsFTNDoS','','','','3','Customer Address','0','','','0.00','0','','1','2025-12-02 14:59:24','2025-12-02 14:59:24');


CREATE TABLE `video_galleries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8mb4_unicode_ci,
  `source` text COLLATE utf8mb4_unicode_ci,
  `creator` bigint unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `wish_lists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

