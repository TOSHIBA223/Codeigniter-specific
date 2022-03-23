INSERT INTO `payment_gateway` (`id`, `identity`, `agent`, `public_key`, `private_key`, `shop_id`, `secret_key`, `status`) VALUES (NULL, 'stripe', 'Stripe', 'pk_test_BPLwYal0sn4KkKaDTzuj5oRq', 'sk_test_6J6dcwXf8ruEZGCvlC09C9NK', 'test', '', '1');
INSERT INTO `language` (`id`, `phrase`, `english`, `french`) VALUES (NULL, 'Wrong_payment', 'Wrong Payment', NULL);
INSERT INTO `language` (`id`, `phrase`, `english`, `french`) VALUES (NULL, 'Server_problem', 'Server problem, contact with the administrator', NULL);
INSERT INTO `language` (`id`, `phrase`, `english`, `french`) VALUES (NULL, 'Invalid_payment', 'Invalid Payment', NULL);
ALTER TABLE `deposit` ADD `stripe_session_id` VARCHAR(255) NULL AFTER `comments`;