-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2025 at 05:44 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `allstartechdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `action_logs`
--

CREATE TABLE `action_logs` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `area` varchar(100) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `action_logs`
--

INSERT INTO `action_logs` (`id`, `admin_id`, `action`, `details`, `area`, `timestamp`) VALUES
(2731, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 01:36:46'),
(2732, 12, 'Approved Application', 'Approved application ID: 42', 'City of Malolos', '2025-06-01 01:36:50'),
(2733, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 01:36:51'),
(2734, 12, 'Sent Install Request', 'Application ID: 42', 'City of Malolos', '2025-06-01 01:36:58'),
(2735, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 01:37:00'),
(2736, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 01:37:05'),
(2737, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 01:37:29'),
(2738, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 01:37:40'),
(2739, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 01:44:25'),
(2740, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 01:44:29'),
(2741, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 01:44:35'),
(2742, 12, 'Saved Account Number', 'Subscriber ID: 44, Account #: 019001', 'City of Malolos', '2025-06-01 01:44:44'),
(2743, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 01:44:45'),
(2744, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 01:46:39'),
(2745, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 01:47:02'),
(2746, 12, 'Saved Account Number', 'Subscriber ID: 44, Account #: 019001', 'City of Malolos', '2025-06-01 01:47:06'),
(2747, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 01:47:07'),
(2748, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 01:49:11'),
(2749, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 01:49:55'),
(2750, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 01:50:10'),
(2751, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 01:50:16'),
(2752, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 01:52:34'),
(2753, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 01:52:45'),
(2754, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 01:53:28'),
(2755, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 01:53:59'),
(2756, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 01:54:07'),
(2757, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 01:54:07'),
(2758, 12, 'Set Billing Info + Install Fee', 'Set billing info and installation fee paid for subscriber ID: 44', 'City of Malolos', '2025-06-01 01:54:23'),
(2759, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 01:54:23'),
(2760, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:04:16'),
(2761, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:04:17'),
(2762, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:04:31'),
(2763, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 02:04:46'),
(2764, 12, 'Saved Account Number', 'Subscriber ID: 44, Account #: 019001', 'City of Malolos', '2025-06-01 02:04:53'),
(2765, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 02:04:54'),
(2766, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:04:59'),
(2767, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:06:55'),
(2768, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 02:06:59'),
(2769, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 02:07:00'),
(2770, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 02:07:02'),
(2771, 12, 'Approved Application', 'Approved application ID: 43', 'City of Malolos', '2025-06-01 02:07:04'),
(2772, 12, 'Approved Application', 'Approved application ID: 43', 'City of Malolos', '2025-06-01 02:07:04'),
(2773, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 02:07:04'),
(2774, 12, 'Sent Install Request', 'Application ID: 43', 'City of Malolos', '2025-06-01 02:07:09'),
(2775, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 02:07:10'),
(2776, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 02:08:13'),
(2777, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 02:08:18'),
(2778, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 02:08:18'),
(2779, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 02:08:22'),
(2780, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 02:08:26'),
(2781, 12, 'Saved Account Number', 'Subscriber ID: 45, Account #: 019001', 'City of Malolos', '2025-06-01 02:08:30'),
(2782, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 02:08:31'),
(2783, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:08:38'),
(2784, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:08:49'),
(2785, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:09:01'),
(2786, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:09:33'),
(2787, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:09:33'),
(2788, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 02:09:38'),
(2789, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 02:09:38'),
(2790, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 02:09:59'),
(2791, 12, 'Saved Account Number', 'Subscriber ID: 45, Account #: 019001', 'City of Malolos', '2025-06-01 02:10:04'),
(2792, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 02:10:05'),
(2793, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:10:07'),
(2794, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:10:17'),
(2795, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:12:08'),
(2796, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:12:16'),
(2797, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:19:08'),
(2798, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:19:22'),
(2799, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 02:19:34'),
(2800, 12, 'Saved Account Number', 'Subscriber ID: 45, Account #: 019001', 'City of Malolos', '2025-06-01 02:19:39'),
(2801, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 02:19:40'),
(2802, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:19:43'),
(2803, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:19:53'),
(2804, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:23:12'),
(2805, 12, 'Set Billing Info + Install Fee', 'Set billing info and installation fee paid for subscriber ID: 45', 'City of Malolos', '2025-06-01 02:23:24'),
(2806, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:23:24'),
(2807, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:25:24'),
(2808, 12, 'Set Billing Info + Install Fee', 'Set billing info and installation fee paid for subscriber ID: 45', 'City of Malolos', '2025-06-01 02:25:38'),
(2809, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:25:39'),
(2810, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:26:37'),
(2811, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:27:13'),
(2812, 12, 'Set Billing Info + Install Fee', 'Set billing info and installation fee paid for subscriber ID: 45', 'City of Malolos', '2025-06-01 02:27:27'),
(2813, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:27:27'),
(2814, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:29:51'),
(2815, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:30:06'),
(2816, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:30:40'),
(2817, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:30:49'),
(2818, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:32:25'),
(2819, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:32:34'),
(2820, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:32:47'),
(2821, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:33:02'),
(2822, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:33:13'),
(2823, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:35:36'),
(2824, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:35:58'),
(2825, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:36:11'),
(2826, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:38:53'),
(2827, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:39:13'),
(2828, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:39:27'),
(2829, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:41:22'),
(2830, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:41:49'),
(2831, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:42:01'),
(2832, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:44:51'),
(2833, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:45:04'),
(2834, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:46:46'),
(2835, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:46:57'),
(2836, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:47:45'),
(2837, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:48:05'),
(2838, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:48:18'),
(2839, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:49:38'),
(2840, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:49:57'),
(2841, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:50:07'),
(2842, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:50:30'),
(2843, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:50:51'),
(2844, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:51:03'),
(2845, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:51:29'),
(2846, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:51:44'),
(2847, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:51:56'),
(2848, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:54:40'),
(2849, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 02:55:12'),
(2850, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 02:56:08'),
(2851, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 02:56:11'),
(2852, 12, 'Approved Application', 'Approved application ID: 44', 'City of Malolos', '2025-06-01 02:56:13'),
(2853, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 02:56:15'),
(2854, 12, 'Sent Install Request', 'Application ID: 44', 'City of Malolos', '2025-06-01 02:56:20'),
(2855, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 02:56:21'),
(2856, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 02:58:18'),
(2857, 12, 'Saved Account Number', 'Subscriber ID: 46, Account #: 019001', 'City of Malolos', '2025-06-01 02:58:23'),
(2858, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 02:58:24'),
(2859, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:58:26'),
(2860, 12, 'Set Billing Info + Install Fee', 'Set billing info and installation fee paid for subscriber ID: 46', 'City of Malolos', '2025-06-01 02:58:36'),
(2861, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 02:58:37'),
(2862, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 03:00:11'),
(2863, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 03:00:44'),
(2864, 12, 'Set Billing Info + Install Fee', 'Set billing info and installation fee paid for subscriber ID: 46', 'City of Malolos', '2025-06-01 03:01:03'),
(2865, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 03:01:03'),
(2866, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 03:02:12'),
(2867, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 03:03:01'),
(2868, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 03:03:06'),
(2869, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 03:03:09'),
(2870, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 03:06:49'),
(2871, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 03:06:53'),
(2872, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 03:08:30'),
(2873, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 03:11:26'),
(2874, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 03:11:57'),
(2875, 12, 'Saved Account Number', 'Subscriber ID: 49, Account #: 019002', 'City of Malolos', '2025-06-01 03:12:03'),
(2876, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 03:12:03'),
(2877, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 03:12:06'),
(2878, 12, 'Set Billing Info + Install Fee', 'Set billing info and installation fee paid for subscriber ID: 49', 'City of Malolos', '2025-06-01 03:12:15'),
(2879, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 03:12:15'),
(2880, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 03:13:33'),
(2881, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 03:13:56'),
(2882, 12, 'Marked Billing as Paid', 'Marked billing id 49 as paid on 2025-06-01T03:14 with Invoice #INV-20250531-9875', 'City of Malolos', '2025-06-01 03:14:42'),
(2883, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 03:14:46'),
(2884, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 03:15:36'),
(2885, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 03:15:38'),
(2886, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 03:16:00'),
(2887, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 03:16:05'),
(2888, 0, 'Failed Login Attempt', 'Invalid password for admin in area: City of Malolos', NULL, '2025-06-01 06:47:01'),
(2889, 0, 'Failed Login Attempt', 'No admin found for area: ', NULL, '2025-06-01 06:47:07'),
(2890, 0, 'Failed Login Attempt', 'Invalid password for admin in area: City of Malolos', NULL, '2025-06-01 06:47:19'),
(2891, 0, 'Failed Login Attempt', 'Invalid password for admin in area: City of Malolos', NULL, '2025-06-01 06:47:28'),
(2892, 0, 'Failed Login Attempt', 'Invalid password for admin in area: City of Malolos', NULL, '2025-06-01 06:47:39'),
(2893, 0, 'Failed Login Attempt', 'No admin found for area: ', NULL, '2025-06-01 06:47:44'),
(2894, 0, 'Failed Login Attempt', 'Invalid password for admin in area: City of Malolos', NULL, '2025-06-01 07:10:25'),
(2895, 0, 'Failed Login Attempt', 'Invalid password for admin in area: City of Malolos', NULL, '2025-06-01 07:10:34'),
(2896, 12, 'Logged In', 'Admin logged in successfully from area: City of Malolos', 'City of Malolos', '2025-06-01 07:23:36'),
(2897, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:23:41'),
(2898, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:23:41'),
(2899, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:26:47'),
(2900, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:26:48'),
(2901, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:27:15'),
(2902, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:27:16'),
(2903, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:28:27'),
(2904, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:28:53'),
(2905, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:28:53'),
(2906, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:29:04'),
(2907, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:29:25'),
(2908, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:29:26'),
(2909, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:29:26'),
(2910, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:30:46'),
(2911, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:30:47'),
(2912, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:30:47'),
(2913, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:31:13'),
(2914, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:31:31'),
(2915, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:32:04'),
(2916, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:32:35'),
(2917, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:32:36'),
(2918, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:33:04'),
(2919, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:35:27'),
(2920, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:36:25'),
(2921, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:38:24'),
(2922, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:39:16'),
(2923, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:41:13'),
(2924, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:41:50'),
(2925, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:42:35'),
(2926, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:45:20'),
(2927, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:45:56'),
(2928, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:46:12'),
(2929, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:46:13'),
(2930, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:46:45'),
(2931, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:47:56'),
(2932, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:48:05'),
(2933, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:48:33'),
(2934, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:48:41'),
(2935, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:48:42'),
(2936, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 07:48:42'),
(2937, 12, 'Logged In', 'Admin logged in successfully from area: City of Malolos', 'City of Malolos', '2025-06-01 08:27:52'),
(2938, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 08:28:02'),
(2939, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 08:28:07'),
(2940, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 08:32:50'),
(2941, 12, 'Approved Application', 'Approved application ID: 45', 'City of Malolos', '2025-06-01 08:32:58'),
(2942, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 08:33:00'),
(2943, 12, 'Sent Install Request', 'Application ID: 45', 'City of Malolos', '2025-06-01 08:36:01'),
(2944, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 08:36:03'),
(2945, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 08:37:12'),
(2946, 12, 'Logged Out', 'Admin logged out from area: City of Malolos', 'City of Malolos', '2025-06-01 08:37:59'),
(2947, 11, 'Logged In', 'Admin logged in successfully from area: Hagonoy', 'Hagonoy', '2025-06-01 08:38:17'),
(2948, 11, 'Logged Out', 'Admin logged out from area: Hagonoy', 'Hagonoy', '2025-06-01 08:38:43'),
(2949, 12, 'Logged In', 'Admin logged in successfully from area: City of Malolos', 'City of Malolos', '2025-06-01 08:38:54'),
(2950, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 08:39:02'),
(2951, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 08:39:59'),
(2952, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 08:40:17'),
(2953, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 08:43:31'),
(2954, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 08:43:34'),
(2955, 12, 'Saved Account Number', 'Subscriber ID: 50, Account #: 019003', 'City of Malolos', '2025-06-01 08:43:55'),
(2956, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 08:43:57'),
(2957, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 08:44:13'),
(2958, 12, 'Updated Subscriber Info', 'Subscriber ID: 50', 'City of Malolos', '2025-06-01 08:44:34'),
(2959, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 08:44:36'),
(2960, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 08:44:47'),
(2961, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 08:44:54'),
(2962, 12, 'Set Billing Info + Install Fee', 'Set billing info and installation fee paid for subscriber ID: 50', 'City of Malolos', '2025-06-01 08:45:36'),
(2963, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 08:45:36'),
(2964, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 08:48:31'),
(2965, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 09:26:21'),
(2966, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 09:27:32'),
(2967, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 09:27:50'),
(2968, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 09:28:04'),
(2969, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 09:28:31'),
(2970, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 09:28:35'),
(2971, 12, 'Marked Billing as Paid', 'Marked billing id 50 as paid on 2025-06-01T09:28 with Invoice #INV-20250601-5875', 'City of Malolos', '2025-06-01 09:29:45'),
(2972, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 09:29:56'),
(2973, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 09:36:53'),
(2974, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 09:37:03'),
(2975, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 09:37:20'),
(2976, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 09:37:22'),
(2977, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 09:37:24'),
(2978, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 09:37:57'),
(2979, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 09:38:00'),
(2980, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 09:38:04'),
(2981, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 09:39:09'),
(2982, 12, 'Marked Billing as Paid', 'Marked billing id 49 as paid on 2025-06-01T09:39 with Invoice #INV-20250601-9788', 'City of Malolos', '2025-06-01 09:40:24'),
(2983, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 09:40:26'),
(2984, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 09:40:32'),
(2985, 12, 'Created Repair Ticket', 'Repair ticket created for Subscriber ID: 49 with issue: MODEM ISSUE', 'City of Malolos', '2025-06-01 09:40:55'),
(2986, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 09:40:56'),
(2987, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 09:41:28'),
(2988, 12, 'Updated Repair Ticket Schedule', 'Updated schedule for repair ticket ID: 32 to new date: 2025-06-02', 'City of Malolos', '2025-06-01 09:41:35'),
(2989, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 09:41:37'),
(2990, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 09:43:50'),
(2991, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 09:43:56'),
(2992, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 09:44:33'),
(2993, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 09:45:01'),
(2994, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 09:49:24'),
(2995, 12, 'Created Repair Ticket', 'Repair ticket created for Subscriber ID: 46 with issue: SLOW BROWSED', 'City of Malolos', '2025-06-01 09:49:47'),
(2996, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 09:49:48'),
(2997, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 09:50:25'),
(2998, 12, 'Updated Repair Ticket Schedule', 'Updated schedule for repair ticket ID: 33 to new date: 2025-06-01', 'City of Malolos', '2025-06-01 09:50:32'),
(2999, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 09:50:33'),
(3000, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 09:52:34'),
(3001, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 09:52:37'),
(3002, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 09:52:48'),
(3003, 12, 'Logged In', 'Admin logged in successfully from area: City of Malolos', 'City of Malolos', '2025-06-01 10:54:28'),
(3004, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 10:57:14'),
(3005, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 11:02:20'),
(3006, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 11:02:23'),
(3007, 12, 'Approved Application', 'Approved application ID: 46', 'City of Malolos', '2025-06-01 11:03:03'),
(3008, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 11:03:06'),
(3009, 12, 'Sent Install Request', 'Application ID: 46', 'City of Malolos', '2025-06-01 11:04:09'),
(3010, 12, 'Viewed Approved Applications', 'Admin viewed approved applications for area: City of Malolos', 'City of Malolos', '2025-06-01 11:04:10'),
(3011, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 11:05:35'),
(3012, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 11:06:16'),
(3013, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 11:09:38'),
(3014, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 11:11:25'),
(3015, 12, 'Viewed Tickets', 'Admin viewed install and repair tickets for area: City of Malolos', 'City of Malolos', '2025-06-01 11:17:27'),
(3016, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 11:17:32'),
(3017, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 11:19:26'),
(3018, 12, 'Saved Account Number', 'Subscriber ID: 51, Account #: 019004', 'City of Malolos', '2025-06-01 11:19:54'),
(3019, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 11:19:56'),
(3020, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 11:20:31'),
(3021, 12, 'Viewed Subscribers', 'Viewed subscriber list for area: City of Malolos', 'City of Malolos', '2025-06-01 11:21:49'),
(3022, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 11:21:52'),
(3023, 12, 'Set Billing Info + Install Fee', 'Set billing info and installation fee paid for subscriber ID: 51', 'City of Malolos', '2025-06-01 11:22:57'),
(3024, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 11:22:57'),
(3025, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 11:27:54'),
(3026, 12, 'Marked Billing as Paid', 'Marked billing id 51 as paid on 2025-06-01T11:28 with Invoice #INV-20250601-2519', 'City of Malolos', '2025-06-01 11:29:09'),
(3027, 12, 'Viewed Billing Page', 'Viewed billing page for area: City of Malolos', 'City of Malolos', '2025-06-01 11:29:29');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `area` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `area`, `password`) VALUES
(11, 'Hagonoy', '$2y$10$7XlZR9xrhW6oZMQHLJPlrODEcvaAcZGE5DGq205mc6bJ8LMTKJtlO'),
(12, 'City of Malolos', '$2y$10$9otJv6c1hGHZFNxfhODM/ecGLWaM3hRrQvAI.0knnOIvKGSqxnz/6'),
(13, 'Paombong', '$2y$10$jkmqdPgUpjWagleh.02Qpu8QFLZJnKW7mp2r44SycPjNlqN21FVru'),
(14, 'Bataan', '$2y$10$.Fui59Grk4ybMkKcOeJol.pLQa3an6JXsPm48.LRvpyT93ny4QRYy'),
(15, 'Pampanga', '$2y$10$IVZa8b1fcydkd4AlB93sx.1VRbCUqGZsmWCQHU1OskKqfGdBcStqC');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `province` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `house_number` varchar(50) NOT NULL,
  `apartment` varchar(100) DEFAULT NULL,
  `landmark` varchar(255) NOT NULL,
  `contact_number1` varchar(20) NOT NULL,
  `contact_number2` varchar(20) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `plan` varchar(50) NOT NULL,
  `application_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending',
  `decline_reason` text DEFAULT NULL,
  `schedule_date` date DEFAULT NULL,
  `app_status` varchar(255) DEFAULT 'Pending',
  `app_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `first_name`, `middle_name`, `last_name`, `suffix`, `province`, `city`, `barangay`, `house_number`, `apartment`, `landmark`, `contact_number1`, `contact_number2`, `email`, `plan`, `application_date`, `status`, `decline_reason`, `schedule_date`, `app_status`, `app_reason`) VALUES
(44, 'Mark Daniel', 'Abrera', 'Asunto', '', 'Bulacan', 'City of Malolos', 'Bungahan', '1', 'Celia Apt.', 'Allstar Tech', '09611889396', '', 'markemdieasunto@gmail.com', '150 Mbps', '2025-05-31 18:56:01', 'Approved', NULL, NULL, 'Installed', NULL),
(45, 'Ralph Alec', 'Sabaria', 'Legaria', '', 'Bulacan', 'City of Malolos', '101', '6', 'test', 'Memes', '77676', '767676', 'legariaralph@dmcfi.edu.ph', '50 Mbps', '2025-06-01 00:32:21', 'Approved', NULL, NULL, 'Installed', NULL),
(46, 'Kurt Michael', 'C', 'Abaiz', '', 'Bulacan', 'City of Malolos', 'Sumapang Bata', '23', 'Celia Apt.', 'Allstar Tech', '09611889396', '', 'markemdieasunto@gmail.com', '130 Mbps', '2025-06-01 02:51:07', 'Approved', NULL, NULL, 'Installed', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `subscriber_id` int(11) NOT NULL,
  `billing_day` tinyint(2) NOT NULL,
  `price_to_pay` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'unpaid',
  `paid_date` datetime DEFAULT NULL,
  `invoice_number` varchar(50) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `subscriber_id`, `billing_day`, `price_to_pay`, `status`, `paid_date`, `invoice_number`, `due_date`, `created_at`) VALUES
(47, 46, 14, 1499, 'paid', '2025-05-31 19:01:03', 'INSTALL-683B51EFBC379', '2025-07-14', '2025-05-31 11:01:03'),
(49, 49, 5, 999, 'paid', '2025-06-01 09:39:00', 'INV-20250601-9788', '2025-07-05', '2025-05-31 11:12:15'),
(50, 50, 5, 799, 'paid', '2025-06-01 09:28:00', 'INV-20250601-5875', '2025-07-05', '2025-05-31 16:45:36'),
(51, 51, 1, 1299, 'paid', '2025-06-01 11:28:00', 'INV-20250601-2519', '2025-07-01', '2025-05-31 19:22:57');

-- --------------------------------------------------------

--
-- Table structure for table `finance_records`
--

CREATE TABLE `finance_records` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` enum('revenue','expenses') NOT NULL,
  `category` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `record_date` date NOT NULL,
  `month_tag` char(7) NOT NULL COMMENT 'Format: YYYY-MM',
  `description` text DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finance_records`
--

INSERT INTO `finance_records` (`id`, `type`, `category`, `amount`, `record_date`, `month_tag`, `description`, `created_by`, `created_at`) VALUES
(122, 'revenue', 'Installation Fee: Mark Daniel Asunto', 1000.00, '2025-05-31', 'May', 'Account Number: 019001', 'City of Malolos', '2025-05-31 19:01:03'),
(123, 'revenue', 'Installation Fee: Carl Joseph Piler', 1000.00, '2025-05-31', 'May', 'Account Number: 019002', 'City of Malolos', '2025-05-31 19:12:15'),
(124, 'revenue', 'Monthly of Subscribers: Carl Joseph Tarog Piler', 999.00, '2025-06-01', 'June', 'FROM Account Number: 019002', 'City of Malolos', '2025-05-31 19:14:06'),
(125, 'revenue', 'Installation Fee: Ralph Alec Legaria', 1000.00, '2025-06-01', 'June', 'Account Number: 019003', 'City of Malolos', '2025-06-01 00:45:36'),
(126, 'expenses', 'Modem', 12000.00, '2025-06-01', 'June', 'bought modem', 'City of Malolos', '2025-06-01 00:47:26'),
(127, 'revenue', 'Monthly of Subscribers: Ralph Alec Sabaria Legaria', 799.00, '2025-06-01', 'June', 'FROM Account Number: 019003', 'City of Malolos', '2025-06-01 01:28:45'),
(128, 'revenue', 'Monthly of Subscribers: Carl Joseph Tarog Piler', 999.00, '2025-06-01', 'June', 'FROM Account Number: 019002', 'City of Malolos', '2025-06-01 01:39:29'),
(129, 'revenue', 'FOC', 2500.00, '2025-06-01', 'June', 'SOLD FOC', 'City of Malolos', '2025-06-01 01:58:20'),
(130, 'revenue', 'Installation Fee: Kurt Michael Abaiz', 1000.00, '2025-06-01', 'June', 'Account Number: 019004', 'City of Malolos', '2025-06-01 03:22:57'),
(131, 'revenue', 'Monthly of Subscribers: Kurt Michael C Abaiz', 1299.00, '2025-06-01', 'June', 'FROM Account Number: 019004', 'City of Malolos', '2025-06-01 03:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `install_materials_reports`
--

CREATE TABLE `install_materials_reports` (
  `id` int(11) NOT NULL,
  `install_id` int(11) NOT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `modem_qty` int(11) DEFAULT NULL,
  `foc_qty` int(11) DEFAULT NULL,
  `fic_qty` int(11) DEFAULT NULL,
  `materials_others` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `power_nap` varchar(255) DEFAULT NULL,
  `nap_picture` varchar(255) DEFAULT NULL,
  `gui_pon` varchar(255) DEFAULT NULL,
  `speedtest` varchar(255) DEFAULT NULL,
  `power_ground` varchar(255) DEFAULT NULL,
  `with_subscriber` varchar(255) DEFAULT NULL,
  `picture_of_id` varchar(255) DEFAULT NULL,
  `picture_of_page` varchar(255) DEFAULT NULL,
  `house_picture` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `install_materials_reports`
--

INSERT INTO `install_materials_reports` (`id`, `install_id`, `serial_number`, `modem_qty`, `foc_qty`, `fic_qty`, `materials_others`, `remarks`, `power_nap`, `nap_picture`, `gui_pon`, `speedtest`, `power_ground`, `with_subscriber`, `picture_of_id`, `picture_of_page`, `house_picture`, `created_at`) VALUES
(22, 59, 'ZTEGD67CAB', 1, 150, 2, '0', 'INSTALLATION COMPLETED', 'uploads/install_images/1748717889_e7b6d8cddc8de7861193.jpg', 'uploads/install_images/1748717889_397925d9686fc5992254.jpg', 'uploads/install_images/1748717889_4573033e2930f0860e5d.jpg', 'uploads/install_images/1748717889_62299764f6d7c7d7f522.jpg', 'uploads/install_images/1748717889_739e2b58e00414bd84f4.jpg', NULL, 'uploads/install_images/1748717889_2fff570012ea5d0d8e63.jpg', 'uploads/install_images/1748717889_6ce11bb043ad4e6af7e7.jpg', 'uploads/install_images/1748717889_9fa03dd151b3526566dd.jpg', '2025-05-31 18:58:09'),
(23, 60, 'ZTEGD67CAB', 1, 150, 2, '0', 'Install done', 'uploads/install_images/1748738572_4e3143f59189830205db.jpg', 'uploads/install_images/1748738572_4c218bc11fadd881dfc0.jpg', 'uploads/install_images/1748738572_5e3bc5229c9ae5e54b1d.jpg', 'uploads/install_images/1748738572_19b20722b7d08ab1b897.jpg', 'uploads/install_images/1748738572_33e8a9bc8fd5ddcdb7c5.jpg', NULL, 'uploads/install_images/1748738572_176421d783df9844722e.jpg', 'uploads/install_images/1748738572_054f44dbe88a6c852002.jpg', 'uploads/install_images/1748738572_4c09d0cd20f345fddad2.jpg', '2025-06-01 00:42:52'),
(24, 61, 'ZTEGD67CAB', 1, 150, 2, 'Adaptor', 'Installed', 'uploads/install_images/1748747729_97c6edae13ea46b21b3f.jpg', 'uploads/install_images/1748747729_455e289bfca327367436.jpg', 'uploads/install_images/1748747729_7bbeb4ae8f22582da4b9.jpg', 'uploads/install_images/1748747729_a8c6fee38a4754aa307a.jpg', 'uploads/install_images/1748747729_0b10981f3742a74dfa00.jpg', NULL, 'uploads/install_images/1748747729_aaef2deb78aa910a8664.jpg', 'uploads/install_images/1748747729_7d994048b3b34784e578.jpg', 'uploads/install_images/1748747729_45ffd883dccb350bbf0a.jpg', '2025-06-01 03:15:29');

-- --------------------------------------------------------

--
-- Table structure for table `install_requests`
--

CREATE TABLE `install_requests` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `schedule_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `install_requests`
--

INSERT INTO `install_requests` (`id`, `application_id`, `schedule_date`, `created_at`, `status`) VALUES
(59, 44, '2025-06-01', '2025-05-31 18:56:20', 'Installed'),
(60, 45, '2025-06-05', '2025-06-01 00:36:01', 'Installed'),
(61, 46, '2025-06-01', '2025-06-01 03:04:09', 'Installed');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_history`
--

CREATE TABLE `invoice_history` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(100) NOT NULL,
  `subscriber_id` int(11) NOT NULL,
  `billing_day` varchar(50) NOT NULL,
  `price_to_pay` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `paid_date` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_history`
--

INSERT INTO `invoice_history` (`id`, `invoice_number`, `subscriber_id`, `billing_day`, `price_to_pay`, `status`, `paid_date`, `created_at`) VALUES
(62, 'INV-20250531-9875', 49, '5', 999.00, 'paid', '2025-06-01', '2025-05-31 19:14:06'),
(63, 'INV-20250601-5875', 50, '5', 799.00, 'paid', '2025-06-01', '2025-06-01 01:28:45'),
(64, 'INV-20250601-9788', 49, '5', 999.00, 'paid', '2025-06-01', '2025-06-01 01:39:29'),
(65, 'INV-20250601-2519', 51, '1', 1299.00, 'paid', '2025-06-01', '2025-06-01 03:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `repair_materials_reports`
--

CREATE TABLE `repair_materials_reports` (
  `id` int(11) NOT NULL,
  `repair_id` int(11) NOT NULL,
  `modem_qty` int(11) NOT NULL,
  `foc_qty` int(11) NOT NULL,
  `fic_qty` int(11) NOT NULL,
  `materials_others` varchar(255) NOT NULL,
  `trouble` text NOT NULL,
  `action_taken` text NOT NULL,
  `power_nap` varchar(255) NOT NULL,
  `nap_picture` varchar(255) NOT NULL,
  `gui_pon` varchar(255) NOT NULL,
  `speedtest` varchar(255) NOT NULL,
  `power_ground` varchar(255) NOT NULL,
  `with_subscriber` varchar(255) NOT NULL,
  `house_picture` varchar(255) NOT NULL,
  `tagging` varchar(255) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `repair_materials_reports`
--

INSERT INTO `repair_materials_reports` (`id`, `repair_id`, `modem_qty`, `foc_qty`, `fic_qty`, `materials_others`, `trouble`, `action_taken`, `power_nap`, `nap_picture`, `gui_pon`, `speedtest`, `power_ground`, `with_subscriber`, `house_picture`, `tagging`, `serial_number`, `created_at`, `updated_at`) VALUES
(11, 32, 1, 150, 2, 'sd', 'Slow browsed', 'asdsd', 'uploads/repair_images/1748742209_b845b74c120fddce077d.jpg', 'uploads/repair_images/1748742209_cecb3aabc423d256da5e.jpg', 'uploads/repair_images/1748742209_9a46c1a62f6ea7b5c561.jpg', 'uploads/repair_images/1748742209_888deea16785b81ca525.jpg', 'uploads/repair_images/1748742209_d2254af6cb118b89c507.jpg', 'uploads/repair_images/1748742209_3d53708f5b1314f21517.jpg', 'uploads/repair_images/1748742209_197cb75fe3af0c5fc478.jpg', 'ZTEGD12345', '123123', '2025-05-31 17:43:29', '2025-05-31 17:43:29'),
(12, 33, 1, 150, 2, '0', 'slowbrowsed', 'asd', 'uploads/repair_images/1748742732_897a663e14d7136e353e.jpg', 'uploads/repair_images/1748742732_11518b9505cbe7e22483.jpg', 'uploads/repair_images/1748742732_64320cfadeace24dfbd1.jpg', 'uploads/repair_images/1748742732_efe4778ba80a7eb6c4b0.jpg', 'uploads/repair_images/1748742732_5b8f74600fe9d54288e6.jpg', 'uploads/repair_images/1748742732_db491a0355da8bc5c9fd.jpg', 'uploads/repair_images/1748742732_60371879ddf32cd7e37b.jpg', '019001', 'ZTEGD67CAB', '2025-05-31 17:52:12', '2025-05-31 17:52:12');

-- --------------------------------------------------------

--
-- Table structure for table `repair_tickets`
--

CREATE TABLE `repair_tickets` (
  `id` int(11) NOT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `subscriber_id` int(11) NOT NULL,
  `issue` text NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'OPEN',
  `scheduled_date` date DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `repair_tickets`
--

INSERT INTO `repair_tickets` (`id`, `account_number`, `subscriber_id`, `issue`, `description`, `status`, `scheduled_date`, `reason`, `created_at`, `updated_at`) VALUES
(32, '019002', 49, 'MODEM ISSUE', 'asdasd', 'Resolved', '2025-06-02', NULL, '2025-05-31 17:40:55', '2025-05-31 17:43:29'),
(33, '019001', 46, 'SLOW BROWSED', 'Slowbrowsed', 'Resolved', '2025-06-01', NULL, '2025-05-31 17:49:47', '2025-05-31 17:52:12');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `application_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `contact_number1` varchar(20) DEFAULT NULL,
  `contact_number2` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `plan` varchar(50) DEFAULT NULL,
  `billing_day` varchar(255) DEFAULT NULL,
  `price_to_pay` int(4) DEFAULT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Connected'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `application_id`, `first_name`, `middle_name`, `last_name`, `contact_number1`, `contact_number2`, `email`, `address`, `city`, `plan`, `billing_day`, `price_to_pay`, `account_number`, `created_at`, `status`) VALUES
(46, 44, 'Mark Daniel', 'Abrera', 'Asunto', '09611889396', '', 'markemdieasunto@gmail.com', '1 Celia Apt., Bungahan', 'City of Malolos', '150 Mbps', '14', 1499, '019001', '2025-06-01 02:58:09', 'Active'),
(49, NULL, 'Carl Joseph', 'Tarog', 'Piler', '09667090709', '', 'sijeyit1@gmail.com', '1 Celia Apt. Bungahan', 'City of Malolos', '100 Mbps', '5', 999, '019002', '2025-06-01 03:11:57', 'Active'),
(50, 45, 'Ralph Alec', 'Sabaria', 'Legaria', '09123456789', '767676', 'legariaralph@dmcfi.edu.ph', '6 test, 101', 'City of Malolos', '50 Mbps', '5', 799, '019003', '2025-06-01 08:42:52', 'Active'),
(51, 46, 'Kurt Michael', 'C', 'Abaiz', '09611889396', '', 'markemdieasunto@gmail.com', '23 Celia Apt., Sumapang Bata', 'City of Malolos', '130 Mbps', '1', 1299, '019004', '2025-06-01 11:15:29', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

CREATE TABLE `technicians` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `area` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`id`, `name`, `email`, `phone`, `password`, `area`, `created_at`) VALUES
(7, 'Dulay', 'dulay@gmail.com', '09123456789', '$2y$10$32j4jwGpF2EJDTF05GhXu.PjxCOQeXSGMd36a6bkxOdNYuCTauDlS', 'City of Malolos', '2025-04-03 20:33:46'),
(8, 'Turko', 'turko@gmail.com', '09123456789', '$2y$10$44t3fflaqpOmIP43boANzufWTEWxJYc.EUdYyTyR50.Z7/QmVsXbe', 'Hagonoy', '2025-04-03 20:33:46'),
(9, 'Asiong', 'Asiong@gmail.com', '09123456789', '$2y$10$g2A/OVthTnF.AwUUZ/LJp.r/VHl1RsdYg9UAPH/YpXSUb28ZTUDZS', 'Paombong', '2025-04-07 04:14:15');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_logs`
--

CREATE TABLE `ticket_logs` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `remarks` text DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action_logs`
--
ALTER TABLE `action_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`);

--
-- Indexes for table `finance_records`
--
ALTER TABLE `finance_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `install_materials_reports`
--
ALTER TABLE `install_materials_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `install_requests`
--
ALTER TABLE `install_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_id` (`application_id`);

--
-- Indexes for table `invoice_history`
--
ALTER TABLE `invoice_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_subscriber` (`subscriber_id`);

--
-- Indexes for table `repair_materials_reports`
--
ALTER TABLE `repair_materials_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_repair_materials_repair` (`repair_id`);

--
-- Indexes for table `repair_tickets`
--
ALTER TABLE `repair_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriber_id` (`subscriber_id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_number` (`account_number`);

--
-- Indexes for table `technicians`
--
ALTER TABLE `technicians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ticket_logs`
--
ALTER TABLE `ticket_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `action_logs`
--
ALTER TABLE `action_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3028;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `finance_records`
--
ALTER TABLE `finance_records`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `install_materials_reports`
--
ALTER TABLE `install_materials_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `install_requests`
--
ALTER TABLE `install_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `invoice_history`
--
ALTER TABLE `invoice_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `repair_materials_reports`
--
ALTER TABLE `repair_materials_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `repair_tickets`
--
ALTER TABLE `repair_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `technicians`
--
ALTER TABLE `technicians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ticket_logs`
--
ALTER TABLE `ticket_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `install_requests`
--
ALTER TABLE `install_requests`
  ADD CONSTRAINT `install_requests_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`);

--
-- Constraints for table `invoice_history`
--
ALTER TABLE `invoice_history`
  ADD CONSTRAINT `fk_invoice_subscriber` FOREIGN KEY (`subscriber_id`) REFERENCES `subscribers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `repair_materials_reports`
--
ALTER TABLE `repair_materials_reports`
  ADD CONSTRAINT `fk_repair_materials_repair` FOREIGN KEY (`repair_id`) REFERENCES `repair_tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `repair_tickets`
--
ALTER TABLE `repair_tickets`
  ADD CONSTRAINT `repair_tickets_ibfk_1` FOREIGN KEY (`subscriber_id`) REFERENCES `subscribers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
