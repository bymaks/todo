-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: mysqldb:3306
-- Время создания: Мар 05 2020 г., 15:24
-- Версия сервера: 5.7.25
-- Версия PHP: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `todo` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `todo`;

CREATE TABLE IF NOT EXISTS `todo_item` (
                             `id` int(11) NOT NULL,
                             `todo_list_id` int(11) NOT NULL,
                             `item_name` varchar(128) NOT NULL,
                             `complite_status` tinyint(4) NOT NULL DEFAULT '0',
                             `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `todo_item` (`id`, `todo_list_id`, `item_name`, `complite_status`, `status`) VALUES
(1, 1, 'Create TODO', 1, 1),
(2, 1, 'Add autorizaton', 1, 1);

CREATE TABLE IF NOT EXISTS `todo_list` (
                             `id` int(11) NOT NULL,
                             `name_list` varchar(64) DEFAULT NULL,
                             `user_id` int(11) DEFAULT NULL,
                             `session_id` varchar(128) DEFAULT NULL,
                             `complit_status` tinyint(4) NOT NULL DEFAULT '0',
                             `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `todo_list` (`id`, `name_list`, `user_id`, `session_id`, `complit_status`, `status`) VALUES
(1, NULL, NULL, 'ToDoApp5ca4d412055000.01260043', 0, 1);

CREATE TRIGGER `before_delete` BEFORE DELETE ON `todo_list` FOR EACH ROW DELETE FROM todo_item WHERE todo_item.todo_list_id = OLD.id;


CREATE TABLE IF NOT EXISTS `users` (
                         `id` int(11) NOT NULL,
                         `login` varchar(32) NOT NULL,
                         `password_hash` varchar(128) NOT NULL,
                         `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `todo_item`
    ADD PRIMARY KEY (`id`),
    ADD KEY `todo_list_id` (`todo_list_id`);

ALTER TABLE `todo_list`
    ADD PRIMARY KEY (`id`),
    ADD KEY `user_id` (`user_id`),
    ADD KEY `session_id` (`session_id`);


ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `login` (`login`);

ALTER TABLE `todo_item`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `todo_list`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `todo_item`
    ADD CONSTRAINT `todo_item_ibfk_1` FOREIGN KEY (`todo_list_id`) REFERENCES `todo_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `todo_list`
    ADD CONSTRAINT `todo_list_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

