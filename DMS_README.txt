1. ======================
ALTER TABLE `dm__files`
	ADD COLUMN `UPDATED_AT` DATETIME NULL DEFAULT NULL AFTER `tags`;

2. =====================
CREATE TABLE `dm__trigger__log` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`UPDATED_TABLE_NAME` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
	`OPERATION_TYPE` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
	`UPDATED_DATA_ID` INT NOT NULL,
	`OLD_VALUE` TEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	`USER_IP` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	`USER_ID` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	`UPDATED_AT` DATETIME NULL DEFAULT (now()),
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=1
;


3. ============================
CREATE TABLE `dm__files_status` (
	`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`STATUS_NAME` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
	`STATUS` TINYINT(1) NULL DEFAULT NULL COMMENT '1-Active, 2-Inactive',
	`SLUG` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
	`PERMISSION` TINYINT(1) NULL DEFAULT NULL,
	PRIMARY KEY (`ID`) USING BTREE
)
COLLATE='latin1_swedish_ci'
ENGINE=MyISAM
ROW_FORMAT=DYNAMIC
AUTO_INCREMENT=6
;

INSERT INTO `dm__files_status` (`ID`, `STATUS_NAME`, `STATUS`, `SLUG`, `PERMISSION`) VALUES (1, 'PUBLISHED', 1, 'published', 1);
INSERT INTO `dm__files_status` (`ID`, `STATUS_NAME`, `STATUS`, `SLUG`, `PERMISSION`) VALUES (2, 'REVERT', 5, 'revert', 1);
INSERT INTO `dm__files_status` (`ID`, `STATUS_NAME`, `STATUS`, `SLUG`, `PERMISSION`) VALUES (3, 'DRAFT', 3, 'draft', 0);
INSERT INTO `dm__files_status` (`ID`, `STATUS_NAME`, `STATUS`, `SLUG`, `PERMISSION`) VALUES (4, 'SEND TO REVIEW', 4, 'send to reveiw', 0);
INSERT INTO `dm__files_status` (`ID`, `STATUS_NAME`, `STATUS`, `SLUG`, `PERMISSION`) VALUES (5, 'UNPUBLISHED', 2, 'unpublished', 1);
$dm__files_status = [
	[
		'ID' => 1,
		'STATUS_NAME' => 'PUBLISHED',
		'STATUS' => 1,
		'SLUG' => 'published',
		'PERMISSION' => 1,
	],
	[
		'ID' => 2,
		'STATUS_NAME' => 'REVERT',
		'STATUS' => 5,
		'SLUG' => 'revert',
		'PERMISSION' => 1,
	],
	[
		'ID' => 3,
		'STATUS_NAME' => 'DRAFT',
		'STATUS' => 3,
		'SLUG' => 'draft',
		'PERMISSION' => 0,
	],
	[
		'ID' => 4,
		'STATUS_NAME' => 'SEND TO REVIEW',
		'STATUS' => 4,
		'SLUG' => 'send to reveiw',
		'PERMISSION' => 0,
	],
	[
		'ID' => 5,
		'STATUS_NAME' => 'UNPUBLISHED',
		'STATUS' => 2,
		'SLUG' => 'unpublished',
		'PERMISSION' => 1,
	],
];


