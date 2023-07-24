-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2018 at 08:31 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mini_shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `parent_id`) VALUES
(1, 'سیاسی', 0),
(2, 'اقتصادی', 0),
(3, 'اجتماعی', 0),
(4, 'فرهنگی', 0),
(5, 'ورزشی', 0),
(6, 'خاورمیانه', 1);

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `meta_keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8_unicode_ci NOT NULL,
  `favicon` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `title`, `meta_keywords`, `meta_description`, `favicon`) VALUES
(1, 'boomava', '', '', '../media/image/logo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `order_date` datetime NOT NULL,
  `status` int(10) UNSIGNED NOT NULL,
  `is_pay` tinyint(1) NOT NULL,
  `pay_info` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `pro_id` int(11) NOT NULL,
  `price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `num` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_info`
--

CREATE TABLE `pay_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pay_date` datetime NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `title_fa` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title_en` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `price_discount` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `sub_category_id` int(10) UNSIGNED NOT NULL,
  `meta_keywords` longtext COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `short_content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `long_content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `thumb_image` text COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_edit` datetime NOT NULL,
  `is_special` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title_fa`, `title_en`, `price`, `price_discount`, `model`, `code`, `category_id`, `sub_category_id`, `meta_keywords`, `meta_description`, `short_content`, `long_content`, `status`, `quantity`, `thumb_image`, `date_created`, `date_edit`, `is_special`) VALUES
(1, 'نفت', 'oil', '', '', '', '1', 1, 6, 'نفت نفت نفت', 'oil oil oil oil oil oil', 'نَفت خام یا پترولیوم مایعی غلیظ و افروختنی به&zwnj;رنگ قهوه&zwnj;ای سیر یا سبز تیره یا سیاه است.', '&lt;p&gt;اقوام متمدن دوران باستان، به&amp;zwnj;ویژه&amp;nbsp;&lt;a title=&quot;سومر&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%B3%D9%88%D9%85%D8%B1&quot;&gt;سومری&amp;zwnj;ها&lt;/a&gt;،&amp;nbsp;&lt;a title=&quot;آشور&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%A2%D8%B4%D9%88%D8%B1&quot;&gt;آشوری&amp;zwnj;ها&lt;/a&gt;&amp;nbsp;و&amp;nbsp;&lt;a title=&quot;تمدن بابل&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%AA%D9%85%D8%AF%D9%86_%D8%A8%D8%A7%D8%A8%D9%84&quot;&gt;بابلی&amp;zwnj;ها&lt;/a&gt;، در حدود چهارهزار و پانصد سال پیش در سرزمین&amp;nbsp;&lt;a class=&quot;mw-redirect&quot; title=&quot;بین&amp;zwnj;النهرین&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%A8%DB%8C%D9%86%E2%80%8C%D8%A7%D9%84%D9%86%D9%87%D8%B1%DB%8C%D9%86&quot;&gt;بین&amp;zwnj;النهرین&lt;/a&gt;&amp;nbsp;(&lt;a title=&quot;عراق&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%B9%D8%B1%D8%A7%D9%82&quot;&gt;عراق&lt;/a&gt;&amp;nbsp;امروزی) با برخی از مواد نفتی که از دریاچه قیر به&amp;zwnj;دست می&amp;zwnj;آمد، آشنایی داشتند. آنان از خود قیر به&amp;zwnj;عنوان مادهٔ غیرقابل نفوذ برای عایق&amp;zwnj;کاری کشتی&amp;zwnj;ها استفاده می&amp;zwnj;کردند. در قرون وسطی دانشمندان مسلمان با تولید&amp;nbsp;&lt;a title=&quot;نفت سفید&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%86%D9%81%D8%AA_%D8%B3%D9%81%DB%8C%D8%AF&quot;&gt;نفت سفید&lt;/a&gt;&amp;nbsp;و نفت ضروری از آن برای چراغ&amp;zwnj;ها استفاده کردند و خیابان&amp;zwnj;ها و حمام&amp;zwnj;های شهر&amp;nbsp;&lt;a title=&quot;بغداد&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%A8%D8%BA%D8%AF%D8%A7%D8%AF&quot;&gt;بغداد&lt;/a&gt;&amp;nbsp;به وسیله قیر و ماسه پوشانده می شد. اولین میدان نفتی دنیا در&amp;nbsp;&lt;a title=&quot;باکو&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%A8%D8%A7%DA%A9%D9%88&quot;&gt;باکو&lt;/a&gt;&amp;nbsp;در قرن نهم ساخته شد که به گفته&amp;nbsp;&lt;a title=&quot;مارکو پولو&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%85%D8%A7%D8%B1%DA%A9%D9%88_%D9%BE%D9%88%D9%84%D9%88&quot;&gt;مارکو پولو&lt;/a&gt;&amp;nbsp;که در قرن سیزده به آنجا سفر کرده محصولات آن با صد&amp;zwnj;ها کشتی حمل می شد. در داستان&amp;zwnj;ها آمده&amp;zwnj;است که&amp;nbsp;&lt;a title=&quot;نوح&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%86%D9%88%D8%AD&quot;&gt;نوح&lt;/a&gt;&amp;nbsp;نیز کشتی خود را با&amp;nbsp;&lt;a title=&quot;قیر&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%82%DB%8C%D8%B1&quot;&gt;قیر&lt;/a&gt;&amp;nbsp;پوشاند تا آب به درون آن نفوذ نکند&lt;sup class=&quot;Fix-tag&quot;&gt;&lt;sup class=&quot;noprint Inline-Template Template-Fact&quot;&gt;[&lt;em&gt;&lt;a title=&quot;ویکی&amp;zwnj;پدیا:نیازمند منبع&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%88%DB%8C%DA%A9%DB%8C%E2%80%8C%D9%BE%D8%AF%DB%8C%D8%A7:%D9%86%DB%8C%D8%A7%D8%B2%D9%85%D9%86%D8%AF_%D9%85%D9%86%D8%A8%D8%B9&quot;&gt;&lt;span title=&quot;&quot;&gt;نیازمند منبع&lt;/span&gt;&lt;/a&gt;&lt;/em&gt;]&lt;/sup&gt;&lt;/sup&gt;.&lt;/p&gt;\r\n&lt;p&gt;اولین چاه اکتشافی مدرن نفت در سال ۱۷۴۵ در&amp;nbsp;&lt;a title=&quot;فرانسه&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%81%D8%B1%D8%A7%D9%86%D8%B3%D9%87&quot;&gt;فرانسه&lt;/a&gt;&amp;nbsp;و اولین چاه استخراج نفت توسط کلنل دریک در سال ۱۸۵۹ در&amp;nbsp;&lt;a title=&quot;پنسیلوانیا&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%BE%D9%86%D8%B3%DB%8C%D9%84%D9%88%D8%A7%D9%86%DB%8C%D8%A7&quot;&gt;پنسیلوانیا&lt;/a&gt;&amp;nbsp;حفاری شد.&lt;a class=&quot;external autonumber&quot; href=&quot;http://www.shana.ir/fa/newsagency/229171/&quot; rel=&quot;nofollow&quot;&gt;[۱]&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;با توسعه و پیشرفت تکنولوژی حفاری در اواسط قرن نوزدهم و تکنولوژی تقطیر و پالایش نفت در اواخر قرن نوزدهم و استفاده از آن در موارد غیر سوختی، جهش حیرت&amp;zwnj;آوری بوجود آمد. بطوری&amp;zwnj;که امروزه صنایع پتروشیمی نفش اساسی و بنیادی در رفع نیاز عمومی جامعه به عهده دارد.&lt;/p&gt;', 1, 0, '../media/image/p29.jpg', '2018-03-10 23:32:41', '2018-03-11 01:17:52', 1),
(2, 'وام بانکی', 'vaaame banki', '0', '0', '', '2', 2, 0, '', '', 'ظام وام&zwnj;دهی متقابل بین&zwnj;بانکی، بانکی که با کمبود موقت نقدینگی مواجه شده است، برای تامین جریان مالی خود، از بانکی که دارای مازاد نقدینگی است وام کوتاه&zwnj;مدت', '&lt;p&gt;پس از&amp;nbsp;&lt;a class=&quot;mw-redirect&quot; title=&quot;انقلاب ۵۷&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%A7%D9%86%D9%82%D9%84%D8%A7%D8%A8_%DB%B5%DB%B7&quot;&gt;انقلاب ۵۷&lt;/a&gt;&amp;nbsp;تمامی بانک&amp;zwnj;های خصوصی در ایران بر اساس&amp;nbsp;&lt;a title=&quot;اصل ۴۴ قانون اساسی جمهوری اسلامی ایران&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%A7%D8%B5%D9%84_%DB%B4%DB%B4_%D9%82%D8%A7%D9%86%D9%88%D9%86_%D8%A7%D8%B3%D8%A7%D8%B3%DB%8C_%D8%AC%D9%85%D9%87%D9%88%D8%B1%DB%8C_%D8%A7%D8%B3%D9%84%D8%A7%D9%85%DB%8C_%D8%A7%DB%8C%D8%B1%D8%A7%D9%86&quot;&gt;اصل ۴۴ قانون اساسی&lt;/a&gt;،&amp;nbsp;&lt;a class=&quot;mw-redirect&quot; title=&quot;دولتی&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%AF%D9%88%D9%84%D8%AA%DB%8C&quot;&gt;دولتی&lt;/a&gt;&amp;nbsp;اعلام شدند، اما رفته رفته تأسیس&amp;nbsp;&lt;a title=&quot;مؤسسه مالی و اعتباری&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%85%D8%A4%D8%B3%D8%B3%D9%87_%D9%85%D8%A7%D9%84%DB%8C_%D9%88_%D8%A7%D8%B9%D8%AA%D8%A8%D8%A7%D8%B1%DB%8C&quot;&gt;مؤسسه&amp;zwnj;های مالی و اعتباری&lt;/a&gt;&amp;nbsp;از سال ۱۳۷۶ زمینه&amp;zwnj;ساز تأسیس بانک&amp;zwnj;های خصوصی شد. نهایتا بانک مرکزی در&amp;nbsp;&lt;a title=&quot;اسفند&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%A7%D8%B3%D9%81%D9%86%D8%AF&quot;&gt;اسفند&lt;/a&gt;&amp;nbsp;۱۳۷۷ موافقت خود را با تأسیس بانک&amp;zwnj;های خصوصی اعلام کرد.&lt;sup id=&quot;cite_ref-1&quot; class=&quot;reference&quot;&gt;&lt;a href=&quot;https://fa.wikipedia.org/wiki/%D9%81%D9%87%D8%B1%D8%B3%D8%AA_%D8%A8%D8%A7%D9%86%DA%A9%E2%80%8C%D9%87%D8%A7%DB%8C_%D8%A7%DB%8C%D8%B1%D8%A7%D9%86#cite_note-1&quot;&gt;[۱]&lt;/a&gt;&lt;/sup&gt;&lt;/p&gt;', 1, 0, '../media/image/p30.jpg', '2018-03-10 23:36:06', '2018-03-11 01:17:32', 0),
(3, 'شهرداری', 'shahrdari', '0', '0', '', '3', 3, 0, '', '', 'شهرداری معمولاً به بخشی شهری از تقسیمات کشوری گفته می&zwnj;شود که به صورت یک ابرشرکت با قدرت خودگردان یا در حیطه قضایی اداره می&zwnj;شود. همچنین اصطلاح شهرداری به معنی بدنه حاکم در یک شهرداری نیز اطلاق می&zwnj;شود.[۱]', '&lt;p&gt;قدرت شهرداری، محدوده&amp;zwnj;ای از استقلال مَجازی می&amp;zwnj;باشد که برای کمک و تکمیل حاکمیت&amp;zwnj;پذیری از&amp;nbsp;&lt;a title=&quot;دولت&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%AF%D9%88%D9%84%D8%AA&quot;&gt;دولت&lt;/a&gt;&amp;nbsp;است. شهرداری&amp;zwnj;ها ممکن است حق داشته باشند که برای افراد و شرکت&amp;zwnj;ها مالیات وضع کنند مثل&amp;nbsp;&lt;a title=&quot;مالیات بر درآمد&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%85%D8%A7%D9%84%DB%8C%D8%A7%D8%AA_%D8%A8%D8%B1_%D8%AF%D8%B1%D8%A2%D9%85%D8%AF&quot;&gt;مالیات بر درآمد&lt;/a&gt;،&amp;nbsp;&lt;a title=&quot;مالیات بر دارایی&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%85%D8%A7%D9%84%DB%8C%D8%A7%D8%AA_%D8%A8%D8%B1_%D8%AF%D8%A7%D8%B1%D8%A7%DB%8C%DB%8C&quot;&gt;مالیات بر دارایی&lt;/a&gt;&amp;nbsp;و&amp;nbsp;&lt;a title=&quot;مالیات بر شرکت&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%85%D8%A7%D9%84%DB%8C%D8%A7%D8%AA_%D8%A8%D8%B1_%D8%B4%D8%B1%DA%A9%D8%AA&quot;&gt;مالیات بر درآمد شرکت&amp;zwnj;ها&lt;/a&gt;&amp;nbsp;و همچنین ممکن است بودجه کلانی را نیز از دولت&amp;zwnj;ها دریافت کنند.&lt;/p&gt;', 1, 0, '../media/image/p27.jpg', '2018-03-10 23:44:53', '2018-03-11 01:18:25', 1),
(4, 'نقاشی', 'paint', '0', '0', '', '4', 4, 0, '', '', 'امید عنوان نقاشی است رنگ روغن بر روی بوم اثر جرج فردریک واتس که در سال ۱۸۸۶ میلادی کشیده شده&zwnj;است. نقاشی امید بر سبک نمادگرایی است و بخشی از نقاشی&zwnj;های تمثیلی جرج فردریک واتس با عنوان &laquo;سرای زندگانی&raquo; است.', '&lt;p&gt;جرمای رایت،&amp;nbsp;&lt;a class=&quot;mw-redirect&quot; title=&quot;پیشوای مذهبی&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%BE%DB%8C%D8%B4%D9%88%D8%A7%DB%8C_%D9%85%D8%B0%D9%87%D8%A8%DB%8C&quot;&gt;پیشوای مذهبی&lt;/a&gt;&amp;nbsp;سابق باراک اوباما، ۲۰ سال پیش در همایشی این تابلو را منبعی الهام&amp;lrm;بخش توصیف کرد. او گفت: &amp;laquo;در این تابلو زن جوان، حال و روز یک قربانی جنگ را دارد؛ ولی در عین حال بی&amp;zwnj;پروایی و شهامت امید را به نمایش می&amp;zwnj;گذارد.&amp;raquo;&lt;/p&gt;\r\n&lt;p&gt;&lt;a title=&quot;باراک اوباما&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%A8%D8%A7%D8%B1%D8%A7%DA%A9_%D8%A7%D9%88%D8%A8%D8%A7%D9%85%D8%A7&quot;&gt;باراک اوباما&lt;/a&gt;&amp;nbsp;هرگز این تصویر و توصیف را فراموش نکرد. او از همین عبارت در نطق سال ۲۰۰۴ و زمان انتخاب&amp;zwnj;اش به عنوان سناتور و همین&amp;zwnj;طور در عنوان کتاب دوم خود استفاده کرد. چرا که این اثر قرن نوزدهمی، الهام&amp;zwnj;بخش عبارت مشهور و تیتر کتاب باراک اوباما، یعنی &amp;laquo;بی&amp;zwnj;پروایی امید&amp;raquo; شد.&lt;/p&gt;', 1, 0, '../media/image/p26.jpg', '2018-03-11 00:42:24', '2018-03-11 01:18:22', 0),
(5, 'فوتبال', 'football', '0', '0', '', '5', 5, 0, '', '', 'امید عنوان نقاشی است رنگ روغن بر روی بوم اثر جرج فردریک واتس که در سال ۱۸۸۶ میلادی کشیده شده&zwnj;است. نقاشی امید بر سبک نمادگرایی است و بخشی از نقاشی&zwnj;های تمثیلی جرج فردریک واتس با عنوان &laquo;سرای زندگانی&raquo; است.', '&lt;p&gt;جرمای رایت،&amp;nbsp;&lt;a class=&quot;mw-redirect&quot; title=&quot;پیشوای مذهبی&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%BE%DB%8C%D8%B4%D9%88%D8%A7%DB%8C_%D9%85%D8%B0%D9%87%D8%A8%DB%8C&quot;&gt;پیشوای مذهبی&lt;/a&gt;&amp;nbsp;سابق باراک اوباما، ۲۰ سال پیش در همایشی این تابلو را منبعی الهام&amp;lrm;بخش توصیف کرد. او گفت: &amp;laquo;در این تابلو زن جوان، حال و روز یک قربانی جنگ را دارد؛ ولی در عین حال بی&amp;zwnj;پروایی و شهامت امید را به نمایش می&amp;zwnj;گذارد.&amp;raquo;&lt;/p&gt;\r\n&lt;p&gt;&lt;a title=&quot;باراک اوباما&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%A8%D8%A7%D8%B1%D8%A7%DA%A9_%D8%A7%D9%88%D8%A8%D8%A7%D9%85%D8%A7&quot;&gt;باراک اوباما&lt;/a&gt;&amp;nbsp;هرگز این تصویر و توصیف را فراموش نکرد. او از همین عبارت در نطق سال ۲۰۰۴ و زمان انتخاب&amp;zwnj;اش به عنوان سناتور و همین&amp;zwnj;طور در عنوان کتاب دوم خود استفاده کرد. چرا که این اثر قرن نوزدهمی، الهام&amp;zwnj;بخش عبارت مشهور و تیتر کتاب باراک اوباما، یعنی &amp;laquo;بی&amp;zwnj;پروایی امید&amp;raquo; شد.&lt;/p&gt;', 1, 0, '../media/image/p22.jpg', '2018-03-12 09:01:44', '2018-03-12 09:03:25', 0),
(6, 'سیاست خارجه', 'khareje', '', '', '', '7', 1, 0, '', '', 'امید عنوان نقاشی است رنگ روغن بر روی بوم اثر جرج فردریک واتس که در سال ۱۸۸۶ میلادی کشیده شده&zwnj;است. نقاشی امید بر سبک نمادگرایی است و بخشی از نقاشی&zwnj;های تمثیلی جرج فردریک واتس با عنوان &laquo;سرای زندگانی&raquo; است.', '&lt;p&gt;&lt;strong&gt;امید&lt;/strong&gt;&amp;nbsp;عنوان نقاشی است رنگ روغن بر روی بوم اثر&amp;nbsp;&lt;a title=&quot;جرج فردریک واتس&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%AC%D8%B1%D8%AC_%D9%81%D8%B1%D8%AF%D8%B1%DB%8C%DA%A9_%D9%88%D8%A7%D8%AA%D8%B3&quot;&gt;جرج فردریک واتس&lt;/a&gt;&amp;nbsp;که در سال ۱۸۸۶ میلادی کشیده شده&amp;zwnj;است. نقاشی امید بر سبک&lt;a title=&quot;نمادگرایی&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%86%D9%85%D8%A7%D8%AF%DA%AF%D8%B1%D8%A7%DB%8C%DB%8C&quot;&gt;نمادگرایی&lt;/a&gt;&amp;nbsp;است و بخشی از نقاشی&amp;zwnj;های&amp;nbsp;&lt;a title=&quot;تمثیل (ادبیات)&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%AA%D9%85%D8%AB%DB%8C%D9%84_(%D8%A7%D8%AF%D8%A8%DB%8C%D8%A7%D8%AA)&quot;&gt;تمثیلی&lt;/a&gt;&amp;nbsp;جرج فردریک واتس با عنوان &amp;laquo;سرای زندگانی&amp;raquo; است.&amp;nbsp;&lt;strong&gt;امید&lt;/strong&gt;&amp;nbsp;عنوان نقاشی است رنگ روغن بر روی بوم اثر&amp;nbsp;&lt;a title=&quot;جرج فردریک واتس&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%AC%D8%B1%D8%AC_%D9%81%D8%B1%D8%AF%D8%B1%DB%8C%DA%A9_%D9%88%D8%A7%D8%AA%D8%B3&quot;&gt;جرج فردریک واتس&lt;/a&gt;&amp;nbsp;که در سال ۱۸۸۶ میلادی کشیده شده&amp;zwnj;است. نقاشی امید بر سبک&lt;a title=&quot;نمادگرایی&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%86%D9%85%D8%A7%D8%AF%DA%AF%D8%B1%D8%A7%DB%8C%DB%8C&quot;&gt;نمادگرایی&lt;/a&gt;&amp;nbsp;است و بخشی از نقاشی&amp;zwnj;های&amp;nbsp;&lt;a title=&quot;تمثیل (ادبیات)&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%AA%D9%85%D8%AB%DB%8C%D9%84_(%D8%A7%D8%AF%D8%A8%DB%8C%D8%A7%D8%AA)&quot;&gt;تمثیلی&lt;/a&gt;&amp;nbsp;جرج فردریک واتس با عنوان &amp;laquo;سرای زندگانی&amp;raquo; است.&lt;/p&gt;', 1, 0, '../media/image/p21.jpg', '2018-03-12 09:05:15', '2018-03-12 09:05:37', 0),
(7, 'موسیقی', 'Music', '0', '0', '', '8', 4, 0, '', '', 'امید عنوان نقاشی است رنگ روغن بر روی بوم اثر جرج فردریک واتس که در سال ۱۸۸۶ میلادی کشیده شده&zwnj;است. نقاشی امید بر سبک نمادگرایی است و بخشی از نقاشی&zwnj;های تمثیلی جرج فردریک واتس با عنوان &laquo;سرای زندگانی&raquo; است.', '&lt;p&gt;&lt;strong&gt;امید&lt;/strong&gt;&amp;nbsp;عنوان نقاشی است رنگ روغن بر روی بوم اثر&amp;nbsp;&lt;a title=&quot;جرج فردریک واتس&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%AC%D8%B1%D8%AC_%D9%81%D8%B1%D8%AF%D8%B1%DB%8C%DA%A9_%D9%88%D8%A7%D8%AA%D8%B3&quot;&gt;جرج فردریک واتس&lt;/a&gt;&amp;nbsp;که در سال ۱۸۸۶ میلادی کشیده شده&amp;zwnj;است. نقاشی امید بر سبک&lt;a title=&quot;نمادگرایی&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%86%D9%85%D8%A7%D8%AF%DA%AF%D8%B1%D8%A7%DB%8C%DB%8C&quot;&gt;نمادگرایی&lt;/a&gt;&amp;nbsp;است و بخشی از نقاشی&amp;zwnj;های&amp;nbsp;&lt;a title=&quot;تمثیل (ادبیات)&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%AA%D9%85%D8%AB%DB%8C%D9%84_(%D8%A7%D8%AF%D8%A8%DB%8C%D8%A7%D8%AA)&quot;&gt;تمثیلی&lt;/a&gt;&amp;nbsp;جرج فردریک واتس با عنوان &amp;laquo;سرای زندگانی&amp;raquo; است.&amp;nbsp;&lt;strong&gt;امید&lt;/strong&gt;&amp;nbsp;عنوان نقاشی است رنگ روغن بر روی بوم اثر&amp;nbsp;&lt;a title=&quot;جرج فردریک واتس&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%AC%D8%B1%D8%AC_%D9%81%D8%B1%D8%AF%D8%B1%DB%8C%DA%A9_%D9%88%D8%A7%D8%AA%D8%B3&quot;&gt;جرج فردریک واتس&lt;/a&gt;&amp;nbsp;که در سال ۱۸۸۶ میلادی کشیده شده&amp;zwnj;است. نقاشی امید بر سبک&lt;a title=&quot;نمادگرایی&quot; href=&quot;https://fa.wikipedia.org/wiki/%D9%86%D9%85%D8%A7%D8%AF%DA%AF%D8%B1%D8%A7%DB%8C%DB%8C&quot;&gt;نمادگرایی&lt;/a&gt;&amp;nbsp;است و بخشی از نقاشی&amp;zwnj;های&amp;nbsp;&lt;a title=&quot;تمثیل (ادبیات)&quot; href=&quot;https://fa.wikipedia.org/wiki/%D8%AA%D9%85%D8%AB%DB%8C%D9%84_(%D8%A7%D8%AF%D8%A8%DB%8C%D8%A7%D8%AA)&quot;&gt;تمثیلی&lt;/a&gt;&amp;nbsp;جرج فردریک واتس با عنوان &amp;laquo;سرای زندگانی&amp;raquo; است.&lt;/p&gt;', 1, 0, '../media/image/p24.jpg', '2018-03-12 09:06:44', '2018-03-12 09:11:22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE `product_image` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `img` text COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `img`, `alt`) VALUES
(1, 1, '../media/image/p28.jpg', ''),
(2, 1, '../media/image/p23.jpg', ''),
(3, 2, '../media/image/Courses%2012.jpg', ''),
(4, 2, '../media/image/Courses%207.jpg', ''),
(11, 5, '', ''),
(6, 3, '../media/image/gallery%202.jpg', ''),
(7, 3, '../media/image/gallery%203.jpg', ''),
(9, 4, '../media/image/Courses%203.jpg', ''),
(10, 4, '../media/image/Courses%204.jpg', ''),
(12, 6, '', ''),
(13, 7, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(10) UNSIGNED NOT NULL,
  `link` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `status` tinyint(1) NOT NULL,
  `last_login` datetime NOT NULL,
  `reg_date_time` datetime NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `fn` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ln` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `status`, `last_login`, `reg_date_time`, `is_admin`, `fn`, `ln`, `avatar`, `tel`, `mobile`, `address`) VALUES
(1, 'a@a.com', '123', 1, '2018-03-14 00:54:33', '2017-04-09 12:20:34', 1, 'a', 'b', 'avatars/20170704183539247121.png', 'c', '09194989194', 'e'),
(4, 'meisamrce@yahoo.com', '1', 1, '2017-08-06 19:26:29', '2017-07-02 18:16:20', 0, 'a', 'a', '', '', '09194843800', ''),
(6, 'abadianparsa51@gmail.com', '1234321', 1, '0000-00-00 00:00:00', '2018-03-13 00:23:04', 0, 'parsa', 'abadian', '', '', '', ''),
(7, 'a@a2.com', '1234', 1, '0000-00-00 00:00:00', '2018-03-14 00:28:25', 0, 'a', 'b', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pay_info`
--
ALTER TABLE `pay_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pay_info`
--
ALTER TABLE `pay_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
