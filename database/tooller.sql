/*
 Navicat Premium Data Transfer

 Source Server         : 腾讯云-私有MySQL
 Source Server Type    : MySQL
 Source Server Version : 50718
 Source Host           : cdb-crxscikh.gz.tencentcdb.com:10149
 Source Schema         : tooller

 Target Server Type    : MySQL
 Target Server Version : 50718
 File Encoding         : 65001

 Date: 22/06/2020 20:35:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for t_article
-- ----------------------------
DROP TABLE IF EXISTS `t_article`;
CREATE TABLE `t_article`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '主题',
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL COMMENT '文章',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '描述',
  `user_id` bigint(20) NULL DEFAULT NULL COMMENT '用户id',
  `parent_category_id` bigint(20) NULL DEFAULT NULL COMMENT '父分类id',
  `child_category_id` bigint(20) NULL DEFAULT NULL COMMENT '子分类id',
  `support_num` int(10) NULL DEFAULT 0 COMMENT '点赞数量',
  `collect_num` int(10) NULL DEFAULT 0 COMMENT '收藏数量',
  `is_public` tinyint(4) NULL DEFAULT 1 COMMENT '1 是 0 否',
  `process_parent_id` bigint(20) NULL DEFAULT NULL COMMENT '父任务id',
  `is_about` tinyint(2) NULL DEFAULT 0 COMMENT '是否是关于 0 否 1是',
  `process_id` bigint(20) NULL DEFAULT NULL COMMENT '任务id',
  `create_at` bigint(20) NULL DEFAULT NULL,
  `update_at` bigint(20) NULL DEFAULT NULL,
  `delete_at` bigint(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for t_books
-- ----------------------------
DROP TABLE IF EXISTS `t_books`;
CREATE TABLE `t_books`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '书名',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL COMMENT '描述',
  `invitation_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '邀请码',
  `pdf_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '书存储位置',
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '作者',
  `page_num` int(20) NULL DEFAULT NULL COMMENT '页数',
  `cover_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '封面',
  `user_id` bigint(20) NULL DEFAULT NULL COMMENT '用户id',
  `create_at` bigint(20) NULL DEFAULT NULL COMMENT '创建时间',
  `update_at` bigint(20) NULL DEFAULT NULL COMMENT '更新时间',
  `delete_at` bigint(20) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for t_category
-- ----------------------------
DROP TABLE IF EXISTS `t_category`;
CREATE TABLE `t_category`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '分类名称',
  `is_top` tinyint(4) NULL DEFAULT 0 COMMENT '是否根目录 0 否 1 是',
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '描述',
  `pid` bigint(20) NULL DEFAULT NULL COMMENT '父级分类',
  `user_id` bigint(20) NULL DEFAULT NULL COMMENT '创建人',
  `create_at` bigint(20) NULL DEFAULT NULL,
  `update_at` bigint(20) NULL DEFAULT NULL,
  `delete_at` bigint(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for t_collect
-- ----------------------------
DROP TABLE IF EXISTS `t_collect`;
CREATE TABLE `t_collect`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NULL DEFAULT NULL COMMENT '用户id',
  `collect_id` bigint(20) NULL DEFAULT NULL COMMENT '收藏id',
  `type` tinyint(4) NULL DEFAULT NULL COMMENT '1 文章 2书籍',
  `create_at` bigint(20) NULL DEFAULT NULL,
  `update_at` bigint(20) NULL DEFAULT NULL,
  `delete_at` bigint(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for t_process
-- ----------------------------
DROP TABLE IF EXISTS `t_process`;
CREATE TABLE `t_process`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '名称',
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '内容',
  `pid` bigint(20) NULL DEFAULT NULL COMMENT '父id',
  `status` tinyint(4) NULL DEFAULT NULL COMMENT '状态',
  `user_id` bigint(20) NULL DEFAULT NULL COMMENT '用户id',
  `create_at` bigint(20) NULL DEFAULT NULL,
  `update_at` bigint(20) NULL DEFAULT NULL,
  `delete_at` bigint(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 66 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for t_user
-- ----------------------------
DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '名称',
  `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '昵称',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '密码',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '邮箱',
  `qq` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT 'QQ',
  `wechat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '微信',
  `level` int(10) NULL DEFAULT NULL COMMENT '等级 1：普通会员 2：管理员',
  `salt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '加盐',
  `user_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT '用户编码',
  `create_at` bigint(20) NULL DEFAULT NULL,
  `update_at` bigint(20) NULL DEFAULT NULL,
  `delete_at` bigint(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
