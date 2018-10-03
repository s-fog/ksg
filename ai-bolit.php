<?php
///////////////////////////////////////////////////////////////////////////
// Created and developed by Greg Zemskov, Revisium Company
// Email: audit@revisium.com, http://revisium.com/ai/

// Commercial usage is not allowed without a license purchase or written permission of the author
// Source code and signatures usage is not allowed

// Certificated in Federal Institute of Industrial Property in 2012
// http://revisium.com/ai/i/mini_aibolit.jpg

////////////////////////////////////////////////////////////////////////////
// Запрещено использование скрипта в коммерческих целях без приобретения лицензии.
// Запрещено использование исходного кода скрипта и сигнатур.
//
// По вопросам приобретения лицензии обращайтесь в компанию "Ревизиум": http://www.revisium.com
// audit@revisium.com
// На скрипт получено авторское свидетельство в Роспатенте
// http://revisium.com/ai/i/mini_aibolit.jpg
///////////////////////////////////////////////////////////////////////////
ini_set('memory_limit', '1G');
ini_set('xdebug.max_nesting_level', 500);

$int_enc = @ini_get('mbstring.internal_encoding');

define('SHORT_PHP_TAG', strtolower(ini_get('short_open_tag')) == 'on' || strtolower(ini_get('short_open_tag')) == 1 ? true : false);

// Put any strong password to open the script from web
// Впишите вместо put_any_strong_password_here сложный пароль	 

define('PASS', '123123');

//////////////////////////////////////////////////////////////////////////

if (isCli()) {
    if (strpos('--eng', $argv[$argc - 1]) !== false) {
        define('LANG', 'EN');
    }
} else {
    if (PASS == '????????????????') {
       die('Forbidden'); 
    }

    define('NEED_REPORT', true);
}

if (!defined('LANG')) {
    define('LANG', 'RU');
}

// put 1 for expert mode, 0 for basic check and 2 for paranoid mode
// установите 1 для режима "Обычное сканирование", 0 для быстрой проверки и 2 для параноидальной проверки (диагностика при лечении сайтов) 
define('AI_EXPERT_MODE', 2);

define('REPORT_MASK_DOORWAYS', 4);
define('REPORT_MASK_FULL', REPORT_MASK_DOORWAYS);

define('AI_HOSTER', 0);

define('AI_EXTRA_WARN', 0);

$defaults = array(
    'path' => dirname(__FILE__),
    'scan_all_files' => (AI_EXPERT_MODE == 2), // full scan (rather than just a .js, .php, .html, .htaccess)
    'scan_delay' => 0, // delay in file scanning to reduce system load
    'max_size_to_scan' => '650K',
    'site_url' => '', // website url
    'no_rw_dir' => 0,
    'skip_ext' => '',
    'skip_cache' => false,
    'report_mask' => REPORT_MASK_FULL
);

define('DEBUG_MODE', 0);
define('DEBUG_PERFORMANCE', 0);

define('AIBOLIT_START_TIME', time());
define('START_TIME', microtime(true));

define('DIR_SEPARATOR', '/');

define('AIBOLIT_MAX_NUMBER', 200);

define('DOUBLECHECK_FILE', 'AI-BOLIT-DOUBLECHECK.php');

if ((isset($_SERVER['OS']) && stripos('Win', $_SERVER['OS']) !== false)) {
    define('DIR_SEPARATOR', '\\');
}

$g_SuspiciousFiles = array(
    'cgi',
    'pl',
    'o',
    'so',
    'py',
    'sh',
    'phtml',
    'php3',
    'php4',
    'php5',
    'php6',
    'php7',
    'pht',
    'shtml'
);
$g_SensitiveFiles  = array_merge(array(
    'php',
    'js',
    'json',
    'htaccess',
    'html',
    'htm',
    'tpl',
    'inc',
    'css',
    'txt',
    'sql',
    'ico',
    '',
    'susp',
    'suspected',
    'zip',
    'tar'
), $g_SuspiciousFiles);
$g_CriticalFiles   = array(
    'php',
    'htaccess',
    'cgi',
    'pl',
    'o',
    'so',
    'py',
    'sh',
    'phtml',
    'php3',
    'php4',
    'php5',
    'php6',
    'php7',
    'pht',
    'shtml',
    'susp',
    'suspected',
    'infected',
    'vir',
    'ico',
    'js',
    'json',  
    ''
);
$g_CriticalEntries = '^\s*<\?php|^\s*<\?=|^#!/usr|^#!/bin|\beval|assert|base64_decode|\bsystem|create_function|\bexec|\bpopen|\bfwrite|\bfputs|file_get_|call_user_func|file_put_|\$_REQUEST|ob_start|\$_GET|\$_POST|\$_SERVER|\$_FILES|\bmove|\bcopy|\barray_|reg_replace|\bmysql_|\bchr|fsockopen|\$GLOBALS|sqliteCreateFunction';
$g_VirusFiles      = array(
    'js',
    'json', 
    'html',
    'htm',
    'suspicious'
);
$g_VirusEntries    = '<script|<iframe|<object|<embed|fromCharCode|setTimeout|setInterval|location\.|document\.|window\.|navigator\.|\$(this)\.';
$g_PhishFiles      = array(
    'js',
    'html',
    'htm',
    'suspected',
    'php',
    'phtml',
    'pht',
    'php7'
);
$g_PhishEntries    = '<\s*title|<\s*html|<\s*form|<\s*body|bank|account';
$g_ShortListExt    = array(
    'php',
    'php3',
    'php4',
    'php5',
    'php7',
    'pht',
    'html',
    'htm',
    'phtml',
    'shtml',
    'khtml',
    '',
    'ico',
    'txt'
);

if (LANG == 'RU') {
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // RUSSIAN INTERFACE
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $msg1  = "\"Отображать по _MENU_ записей\"";
    $msg2  = "\"Ничего не найдено\"";
    $msg3  = "\"Отображается c _START_ по _END_ из _TOTAL_ файлов\"";
    $msg4  = "\"Нет файлов\"";
    $msg5  = "\"(всего записей _MAX_)\"";
    $msg6  = "\"Поиск:\"";
    $msg7  = "\"Первая\"";
    $msg8  = "\"Предыдущая\"";
    $msg9  = "\"Следующая\"";
    $msg10 = "\"Последняя\"";
    $msg11 = "\": активировать для сортировки столбца по возрастанию\"";
    $msg12 = "\": активировать для сортировки столбцов по убыванию\"";
    
    define('AI_STR_001', 'Отчет сканера <a href="https://revisium.com/ai/">AI-Bolit</a> v@@VERSION@@:');
    define('AI_STR_002', 'Обращаем внимание на то, что большинство CMS <b>без дополнительной защиты</b> рано или поздно <b>взламывают</b>.<p> Компания <a href="https://revisium.com/">"Ревизиум"</a> предлагает услугу превентивной защиты сайта от взлома с использованием уникальной <b>процедуры "цементирования сайта"</b>. Подробно на <a href="https://revisium.com/ru/client_protect/">странице услуги</a>. <p>Лучшее лечение &mdash; это профилактика.');
    define('AI_STR_003', 'Не оставляйте файл отчета на сервере, и не давайте на него прямых ссылок с других сайтов. Информация из отчета может быть использована злоумышленниками для взлома сайта, так как содержит информацию о настройках сервера, файлах и каталогах.');
    define('AI_STR_004', 'Путь');
    define('AI_STR_005', 'Изменение свойств');
    define('AI_STR_006', 'Изменение содержимого');
    define('AI_STR_007', 'Размер');
    define('AI_STR_008', 'Конфигурация PHP');
    define('AI_STR_009', "Вы установили слабый пароль на скрипт AI-BOLIT. Укажите пароль не менее 8 символов, содержащий латинские буквы в верхнем и нижнем регистре, а также цифры. Например, такой <b>%s</b>");
    define('AI_STR_010', "Сканер AI-Bolit запускается с паролем. Если это первый запуск сканера, вам нужно придумать сложный пароль и вписать его в файле ai-bolit.php в строке №34. <p>Например, <b>define('PASS', '%s');</b><p>
После этого откройте сканер в браузере, указав пароль в параметре \"p\". <p>Например, так <b>http://mysite.ru/ai-bolit.php?p=%s</b>. ");
    define('AI_STR_011', 'Текущая директория не доступна для чтения скрипту. Пожалуйста, укажите права на доступ <b>rwxr-xr-x</b> или с помощью командной строки <b>chmod +r имя_директории</b>');
    define('AI_STR_012', "Затрачено времени: <b>%s</b>. Сканирование начато %s, сканирование завершено %s");
    define('AI_STR_013', 'Всего проверено %s директорий и %s файлов.');
    define('AI_STR_014', '<div class="rep" style="color: #0000A0">Внимание, скрипт выполнил быструю проверку сайта. Проверяются только наиболее критические файлы, но часть вредоносных скриптов может быть не обнаружена. Пожалуйста, запустите скрипт из командной строки для выполнения полного тестирования. Подробнее смотрите в <a href="https://revisium.com/ai/faq.php">FAQ вопрос №10</a>.</div>');
    define('AI_STR_015', '<div class="title">Критические замечания</div>');
    define('AI_STR_016', 'Эти файлы могут быть вредоносными или хакерскими скриптами');
    define('AI_STR_017', 'Вирусы и вредоносные скрипты не обнаружены.');
    define('AI_STR_018', 'Эти файлы могут быть javascript вирусами');
    define('AI_STR_019', 'Обнаружены сигнатуры исполняемых файлов unix и нехарактерных скриптов. Они могут быть вредоносными файлами');
    define('AI_STR_020', 'Двойное расширение, зашифрованный контент или подозрение на вредоносный скрипт. Требуется дополнительный анализ');
    define('AI_STR_021', 'Подозрение на вредоносный скрипт');
    define('AI_STR_022', 'Символические ссылки (symlinks)');
    define('AI_STR_023', 'Скрытые файлы');
    define('AI_STR_024', 'Возможно, каталог с дорвеем');
    define('AI_STR_025', 'Не найдено директорий c дорвеями');
    define('AI_STR_026', 'Предупреждения');
    define('AI_STR_027', 'Подозрение на мобильный редирект, подмену расширений или автовнедрение кода');
    define('AI_STR_028', 'В не .php файле содержится стартовая сигнатура PHP кода. Возможно, там вредоносный код');
    define('AI_STR_029', 'Дорвеи, реклама, спам-ссылки, редиректы');
    define('AI_STR_030', 'Непроверенные файлы - ошибка чтения');
    define('AI_STR_031', 'Невидимые ссылки. Подозрение на ссылочный спам');
    define('AI_STR_032', 'Невидимые ссылки');
    define('AI_STR_033', 'Отображены только первые ');
    define('AI_STR_034', 'Подозрение на дорвей');
    define('AI_STR_035', 'Скрипт использует код, который часто встречается во вредоносных скриптах');
    define('AI_STR_036', 'Директории из файла .adirignore были пропущены при сканировании');
    define('AI_STR_037', 'Версии найденных CMS');
    define('AI_STR_038', 'Большие файлы (больше чем %s). Пропущено');
    define('AI_STR_039', 'Не найдено файлов больше чем %s');
    define('AI_STR_040', 'Временные файлы или файлы(каталоги) - кандидаты на удаление по ряду причин');
    define('AI_STR_041', 'Потенциально небезопасно! Директории, доступные скрипту на запись');
    define('AI_STR_042', 'Не найдено директорий, доступных на запись скриптом');
    define('AI_STR_043', 'Использовано памяти при сканировании: ');
    define('AI_STR_044', 'Просканированы только файлы, перечисленные в ' . DOUBLECHECK_FILE . '. Для полного сканирования удалите файл ' . DOUBLECHECK_FILE . ' и запустите сканер повторно.');
    define('AI_STR_045', '<div class="rep">Внимание! Выполнена экспресс-проверка сайта. Просканированы только файлы с расширением .php, .js, .html, .htaccess. В этом режиме могут быть пропущены вирусы и хакерские скрипты в файлах с другими расширениями. Чтобы выполнить более тщательное сканирование, поменяйте значение настройки на <b>\'scan_all_files\' => 1</b> в строке 50 или откройте сканер в браузере с параметром full: <b><a href="ai-bolit.php?p=' . PASS . '&full">ai-bolit.php?p=' . PASS . '&full</a></b>. <p>Не забудьте перед повторным запуском удалить файл ' . DOUBLECHECK_FILE . '</div>');
    define('AI_STR_050', 'Замечания и предложения по работе скрипта и не обнаруженные вредоносные скрипты присылайте на <a href="mailto:ai@revisium.com">ai@revisium.com</a>.<p>Также будем чрезвычайно благодарны за любые упоминания скрипта AI-Bolit на вашем сайте, в блоге, среди друзей, знакомых и клиентов. Ссылочку можно поставить на <a href="https://revisium.com/ai/">https://revisium.com/ai/</a>. <p>Если будут вопросы - пишите <a href="mailto:ai@revisium.com">ai@revisium.com</a>. ');
    define('AI_STR_051', 'Отчет по ');
    define('AI_STR_052', 'Эвристический анализ обнаружил подозрительные файлы. Проверьте их на наличие вредоносного кода.');
    define('AI_STR_053', 'Много косвенных вызовов функции');
    define('AI_STR_054', 'Подозрение на обфусцированные переменные');
    define('AI_STR_055', 'Подозрительное использование массива глобальных переменных');
    define('AI_STR_056', 'Дробление строки на символы');
    define('AI_STR_057', 'Сканирование выполнено в экспресс-режиме. Многие вредоносные скрипты могут быть не обнаружены.<br> Рекомендуем проверить сайт в режиме "Эксперт" или "Параноидальный". Подробно описано в <a href="https://revisium.com/ai/faq.php">FAQ</a> и инструкции к скрипту.');
    define('AI_STR_058', 'Обнаружены фишинговые страницы');
    
    define('AI_STR_059', 'Мобильных редиректов');
    define('AI_STR_060', 'Вредоносных скриптов');
    define('AI_STR_061', 'JS Вирусов');
    define('AI_STR_062', 'Фишинговых страниц');
    define('AI_STR_063', 'Исполняемых файлов');
    define('AI_STR_064', 'IFRAME вставок');
    define('AI_STR_065', 'Пропущенных больших файлов');
    define('AI_STR_066', 'Ошибок чтения файлов');
    define('AI_STR_067', 'Зашифрованных файлов');
    define('AI_STR_068', 'Подозрительных (эвристика)');
    define('AI_STR_069', 'Символических ссылок');
    define('AI_STR_070', 'Скрытых файлов');
    define('AI_STR_072', 'Рекламных ссылок и кодов');
    define('AI_STR_073', 'Пустых ссылок');
    define('AI_STR_074', 'Сводный отчет');
    define('AI_STR_075', 'Сканер бесплатный только для личного некоммерческого использования. Информация по <a href="https://revisium.com/ai/faq.php#faq11" target=_blank>коммерческой лицензии</a> (пункт №11). <a href="https://revisium.com/images/mini_aibolit.jpg">Авторское свидетельство</a> о гос. регистрации в РосПатенте №2012619254 от 12 октября 2012 г.');
    
    $tmp_str = <<<HTML_FOOTER
   <div class="disclaimer"><span class="vir">[!]</span> Отказ от гарантий: невозможно гарантировать обнаружение всех вредоносных скриптов. Поэтому разработчик сканера не несет ответственности за возможные последствия работы сканера AI-Bolit или неоправданные ожидания пользователей относительно функциональности и возможностей.
   </div>
   <div class="thanx">
      Замечания и предложения по работе скрипта, а также не обнаруженные вредоносные скрипты вы можете присылать на <a href="mailto:ai@revisium.com">ai@revisium.com</a>.<br/>
      Также будем чрезвычайно благодарны за любые упоминания сканера AI-Bolit на вашем сайте, в блоге, среди друзей, знакомых и клиентов. <br/>Ссылку можно поставить на страницу <a href="https://revisium.com/ai/">https://revisium.com/ai/</a>.<br/> 
     <p>Получить консультацию или задать вопросы можно по email <a href="mailto:ai@revisium.com">ai@revisium.com</a>.</p> 
	</div>
HTML_FOOTER;
    
    define('AI_STR_076', $tmp_str);
    define('AI_STR_077', "Подозрительные параметры времени изменения файла");
    define('AI_STR_078', "Подозрительные атрибуты файла");
    define('AI_STR_079', "Подозрительное местоположение файла");
    define('AI_STR_080', "Обращаем внимание, что обнаруженные файлы не всегда являются вирусами и хакерскими скриптами. Сканер минимизирует число ложных обнаружений, но это не всегда возможно, так как найденный фрагмент может встречаться как во вредоносных скриптах, так и в обычных.<p>Для диагностического сканирования без ложных срабатываний мы разработали специальную версию <u><a href=\"https://revisium.com/ru/blog/ai-bolit-4-ISP.html\" target=_blank style=\"background: none; color: #303030\">сканера для хостинг-компаний</a></u>.");
    define('AI_STR_081', "Уязвимости в скриптах");
    define('AI_STR_082', "Добавленные файлы");
    define('AI_STR_083', "Измененные файлы");
    define('AI_STR_084', "Удаленные файлы");
    define('AI_STR_085', "Добавленные каталоги");
    define('AI_STR_086', "Удаленные каталоги");
    define('AI_STR_087', "Изменения в файловой структуре");
    
    $l_Offer = <<<OFFER
    <div>
	 <div class="crit" style="font-size: 17px; margin-bottom: 20px"><b>Внимание! Наш сканер обнаружил подозрительный или вредоносный код</b>.</div> 
	 <p>Возможно, ваш сайт был взломан. Рекомендуем срочно <a href="https://revisium.com/ru/order/#fform" target=_blank>проконсультироваться со специалистами</a> по данному отчету.</p>
	 <p><hr size=1></p>
	 <p>Рекомендуем также проверить сайт бесплатным <b><a href="https://rescan.pro/?utm=aibolit" target=_blank>онлайн-сканером ReScan.Pro</a></b>.</p>
	 <p><hr size=1></p>
         <div class="caution">@@CAUTION@@</div>
    </div>
OFFER;
    
    $l_Offer2 = <<<OFFER2
	   <b>Наши продукты:</b><br/>
              <ul>
               <li style="margin-top: 10px"><font color=red><sup>[new]</sup></font><b><a href="https://revisium.com/ru/products/antivirus_for_ispmanager/" target=_blank>Антивирус для ISPmanager Lite</a></b> &mdash;  сканирование и лечение сайтов прямо в панели хостинга</li>
               <li style="margin-top: 10px"><b><a href="https://revisium.com/ru/blog/revisium-antivirus-for-plesk.html" target=_blank>Антивирус для Plesk</a> Onyx 17.x</b> &mdash;  сканирование и лечение сайтов прямо в панели хостинга</li>
               <li style="margin-top: 10px"><b><a href="https://cloudscan.pro/ru/" target=_blank>Облачный антивирус CloudScan.Pro</a> для веб-специалистов</b> &mdash; лечение сайтов в один клик</li>
               <li style="margin-top: 10px"><b><a href="https://revisium.com/ru/antivirus-server/" target=_blank>Антивирус для сервера</a></b> &mdash; для хостин-компаний, веб-студий и агентств.</li>
              </ul>  
	</div>
OFFER2;
    
} else {
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ENGLISH INTERFACE
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $msg1  = "\"Display _MENU_ records\"";
    $msg2  = "\"Not found\"";
    $msg3  = "\"Display from _START_ to _END_ of _TOTAL_ files\"";
    $msg4  = "\"No files\"";
    $msg5  = "\"(total _MAX_)\"";
    $msg6  = "\"Filter/Search:\"";
    $msg7  = "\"First\"";
    $msg8  = "\"Previous\"";
    $msg9  = "\"Next\"";
    $msg10 = "\"Last\"";
    $msg11 = "\": activate to sort row ascending order\"";
    $msg12 = "\": activate to sort row descending order\"";
    
    define('AI_STR_001', 'AI-Bolit v@@VERSION@@ Scan Report:');
    define('AI_STR_002', '');
    define('AI_STR_003', 'Caution! Do not leave either ai-bolit.php or report file on server and do not provide direct links to the report file. Report file contains sensitive information about your website which could be used by hackers. So keep it in safe place and don\'t leave on website!');
    define('AI_STR_004', 'Path');
    define('AI_STR_005', 'iNode Changed');
    define('AI_STR_006', 'Modified');
    define('AI_STR_007', 'Size');
    define('AI_STR_008', 'PHP Info');
    define('AI_STR_009', "Your password for AI-BOLIT is too weak. Password must be more than 8 character length, contain both latin letters in upper and lower case, and digits. E.g. <b>%s</b>");
    define('AI_STR_010', "Open AI-BOLIT with password specified in the beggining of file in PASS variable. <br/>E.g. http://you_website.com/ai-bolit.php?p=<b>%s</b>");
    define('AI_STR_011', 'Current folder is not readable. Please change permission for <b>rwxr-xr-x</b> or using command line <b>chmod +r folder_name</b>');
    define('AI_STR_012', "<div class=\"rep\">%s malicious signatures known, %s virus signatures and other malicious code. Elapsed: <b>%s</b
>.<br/>Started: %s. Stopped: %s</div> ");
    define('AI_STR_013', 'Scanned %s folders and %s files.');
    define('AI_STR_014', '<div class="rep" style="color: #0000A0">Attention! Script has performed quick scan. It scans only .html/.js/.php files  in quick scan mode so some of malicious scripts might not be detected. <br>Please launch script from a command line thru SSH to perform full scan.');
    define('AI_STR_015', '<div class="title">Critical</div>');
    define('AI_STR_016', 'Shell script signatures detected. Might be a malicious or hacker\'s scripts');
    define('AI_STR_017', 'Shell scripts signatures not detected.');
    define('AI_STR_018', 'Javascript virus signatures detected:');
    define('AI_STR_019', 'Unix executables signatures and odd scripts detected. They might be a malicious binaries or rootkits:');
    define('AI_STR_020', 'Suspicious encoded strings, extra .php extention or external includes detected in PHP files. Might be a malicious or hacker\'s script:');
    define('AI_STR_021', 'Might be a malicious or hacker\'s script:');
    define('AI_STR_022', 'Symlinks:');
    define('AI_STR_023', 'Hidden files:');
    define('AI_STR_024', 'Files might be a part of doorway:');
    define('AI_STR_025', 'Doorway folders not detected');
    define('AI_STR_026', 'Warnings');
    define('AI_STR_027', 'Malicious code in .htaccess (redirect to external server, extention handler replacement or malicious code auto-append):');
    define('AI_STR_028', 'Non-PHP file has PHP signature. Check for malicious code:');
    define('AI_STR_029', 'This script has black-SEO links or linkfarm. Check if it was installed by yourself:');
    define('AI_STR_030', 'Reading error. Skipped.');
    define('AI_STR_031', 'These files have invisible links, might be black-seo stuff:');
    define('AI_STR_032', 'List of invisible links:');
    define('AI_STR_033', 'Displayed first ');
    define('AI_STR_034', 'Folders contained too many .php or .html files. Might be a doorway:');
    define('AI_STR_035', 'Suspicious code detected. It\'s usually used in malicious scrips:');
    define('AI_STR_036', 'The following list of files specified in .adirignore has been skipped:');
    define('AI_STR_037', 'CMS found:');
    define('AI_STR_038', 'Large files (greater than %s! Skipped:');
    define('AI_STR_039', 'Files greater than %s not found');
    define('AI_STR_040', 'Files recommended to be remove due to security reason:');
    define('AI_STR_041', 'Potentially unsafe! Folders which are writable for scripts:');
    define('AI_STR_042', 'Writable folders not found');
    define('AI_STR_043', 'Memory used: ');
    define('AI_STR_044', 'Quick scan through the files from ' . DOUBLECHECK_FILE . '. For full scan remove ' . DOUBLECHECK_FILE . ' and launch scanner once again.');
    define('AI_STR_045', '<div class="notice"><span class="vir">[!]</span> Ai-BOLIT is working in quick scan mode, only .php, .html, .htaccess files will be checked. Change the following setting \'scan_all_files\' => 1 to perform full scanning.</b>. </div>');
    define('AI_STR_050', "I'm sincerely appreciate reports for any bugs you may found in the script. Please email me: <a href=\"mailto:audit@revisium.com\">audit@revisium.com</a>.<p> Also I appriciate any reference to the script in your blog or forum posts. Thank you for the link to download page: <a href=\"https://revisium.com/aibo/\">https://revisium.com/aibo/</a>");
    define('AI_STR_051', 'Report for ');
    define('AI_STR_052', 'Heuristic Analyzer has detected suspicious files. Check if they are malware.');
    define('AI_STR_053', 'Function called by reference');
    define('AI_STR_054', 'Suspected for obfuscated variables');
    define('AI_STR_055', 'Suspected for $GLOBAL array usage');
    define('AI_STR_056', 'Abnormal split of string');
    define('AI_STR_057', 'Scanning has been done in simple mode. It is strongly recommended to perform scanning in "Expert" mode. See readme.txt for details.');
    define('AI_STR_058', 'Phishing pages detected:');
    
    define('AI_STR_059', 'Mobile redirects');
    define('AI_STR_060', 'Malware');
    define('AI_STR_061', 'JS viruses');
    define('AI_STR_062', 'Phishing pages');
    define('AI_STR_063', 'Unix executables');
    define('AI_STR_064', 'IFRAME injections');
    define('AI_STR_065', 'Skipped big files');
    define('AI_STR_066', 'Reading errors');
    define('AI_STR_067', 'Encrypted files');
    define('AI_STR_068', 'Suspicious (heuristics)');
    define('AI_STR_069', 'Symbolic links');
    define('AI_STR_070', 'Hidden files');
    define('AI_STR_072', 'Adware and spam links');
    define('AI_STR_073', 'Empty links');
    define('AI_STR_074', 'Summary');
    define('AI_STR_075', 'For non-commercial use only. In order to purchase the commercial license of the scanner contact us at ai@revisium.com');
    
    $tmp_str = <<<HTML_FOOTER
		   <div class="disclaimer"><span class="vir">[!]</span> Disclaimer: We're not liable to you for any damages, including general, special, incidental or consequential damages arising out of the use or inability to use the script (including but not limited to loss of data or report being rendered inaccurate or failure of the script). There's no warranty for the program. Use at your own risk. 
		   </div>
		   <div class="thanx">
		      We're greatly appreciate for any references in the social medias, forums or blogs to our scanner AI-BOLIT <a href="https://revisium.com/aibo/">https://revisium.com/aibo/</a>.<br/> 
		     <p>Contact us via email if you have any questions regarding the scanner or need report analysis: <a href="mailto:ai@revisium.com">ai@revisium.com</a>.</p> 
			</div>
HTML_FOOTER;
    define('AI_STR_076', $tmp_str);
    define('AI_STR_077', "Suspicious file mtime and ctime");
    define('AI_STR_078', "Suspicious file permissions");
    define('AI_STR_079', "Suspicious file location");
    define('AI_STR_081', "Vulnerable Scripts");
    define('AI_STR_082', "Added files");
    define('AI_STR_083', "Modified files");
    define('AI_STR_084', "Deleted files");
    define('AI_STR_085', "Added directories");
    define('AI_STR_086', "Deleted directories");
    define('AI_STR_087', "Integrity Check Report");
    
    $l_Offer = <<<HTML_OFFER_EN
<div>
 <div class="crit" style="font-size: 17px;"><b>Attention! The scanner has detected suspicious or malicious files.</b></div> 
 <br/>Most likely the website has been compromised. Please, <a href="https://revisium.com/en/contacts/" target=_blank>contact web security experts</a> from Revisium to check the report or clean the malware.
 <p><hr size=1></p>
 Also check your website for viruses with our free <b><a href="http://rescan.pro/?en&utm=aibo" target=_blank>online scanner ReScan.Pro</a></b>.
</div>
<br/>
<div>
   Revisium contacts: <a href="mailto:ai@revisium.com">ai@revisium.com</a>, <a href="https://revisium.com/en/contacts/">https://revisium.com/en/home/</a>
</div>
<div class="caution">@@CAUTION@@</div>
HTML_OFFER_EN;
    
    $l_Offer2 = '<b>Special Offers:</b><br/>
              <ul>
               <li style="margin-top: 10px"><font color=red><sup>[new]</sup></font><b><a href="http://ext.plesk.com/packages/b71916cf-614e-4b11-9644-a5fe82060aaf-revisium-antivirus">Antivirus for Plesk Onyx</a></b> hosting panel with one-click malware cleanup and scheduled website scanning.</li>
               <li style="margin-top: 10px"><font color=red></font><b><a href="https://www.ispsystem.com/addons-modules/revisium">Antivirus for ISPmanager Lite</a></b> hosting panel with one-click malware cleanup and scheduled website scanning.</li>
               <li style="margin-top: 10px">Professional malware cleanup and web-protection service with 6 month guarantee for only $99 (one-time payment): <a href="https://revisium.com/en/home/#order_form">https://revisium.com/en/home/</a>.</li>
              </ul>  
	</div>';
    
    define('AI_STR_080', "Notice! Some of detected files may not contain malicious code. Scanner tries to minimize a number of false positives, but sometimes it's impossible, because same piece of code may be used either in malware or in normal scripts.");
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$l_Template = <<<MAIN_PAGE
<html>
<head>
<!-- revisium.com/ai/ -->
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<META NAME="ROBOTS" CONTENT="NOINDEX,NOFOLLOW">
<title>@@HEAD_TITLE@@</title>
<style type="text/css" title="currentStyle">
	@import "https://cdn.revisium.com/ai/media/css/demo_page2.css";
	@import "https://cdn.revisium.com/ai/media/css/jquery.dataTables2.css";
</style>

<script type="text/javascript" language="javascript" src="https://cdn.revisium.com/ai/jquery.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.revisium.com/ai/datatables.min.js"></script>

<style type="text/css">
 body 
 {
   font-family: Tahoma;
   color: #5a5a5a;
   background: #FFFFFF;
   font-size: 14px;
   margin: 20px;
   padding: 0;
 }

.header
 {
   font-size: 34px;
   margin: 0 0 10px 0;
 }

 .hidd
 {
    display: none;
 }
 
 .ok
 {
    color: green;
 }
 
 .line_no
 {
   -webkit-border-radius: 4px;
   -moz-border-radius: 4px;
   border-radius: 4px;

   background: #DAF2C1;
   padding: 2px 5px 2px 5px;
   margin: 0 5px 0 5px;
 }
 
 .credits_header 
 {
  -webkit-border-radius: 4px;
   -moz-border-radius: 4px;
   border-radius: 4px;

   background: #F2F2F2;
   padding: 10px;
   font-size: 11px;
    margin: 0 0 10px 0;
 }
 
 .marker
 {
    color: #FF0090;
	font-weight: 100;
	background: #FF0090;
	padding: 2px 0px 2px 0px;
	width: 2px;
 }
 
 .title
 {
   font-size: 24px;
   margin: 20px 0 10px 0;
   color: #9CA9D1;
}

.summary 
{
  float: left;
  width: 500px;
}

.summary TD
{
  font-size: 12px;
  border-bottom: 1px solid #F0F0F0;
  font-weight: 700;
  padding: 10px 0 10px 0;
}
 
.crit, .vir
{
  color: #D84B55;
}

.intitem
{
  color:#4a6975;
}

.spacer
{
   margin: 0 0 50px 0;
   clear:both;
}

.warn
{
  color: #F6B700;
}

.clear
{
   clear: both;
}

.offer
{
  -webkit-border-radius: 4px;
   -moz-border-radius: 4px;
   border-radius: 4px;

   width: 500px;
   background: #F2F2F2;
   color: #747474;
   font-family: Helvetica, Arial;
   padding: 30px;
   margin: 20px 0 0 550px;
   font-size: 14px;
}

.offer2
{
  -webkit-border-radius: 4px;
   -moz-border-radius: 4px;
   border-radius: 4px;

   width: 500px;
   background: #f6f5e0;
   color: #747474;
   font-family: Helvetica, Arial;
   padding: 30px;
   margin: 20px 0 0 550px;
   font-size: 14px;
}


HR {
  margin-top: 15px;
  margin-bottom: 15px;
  opacity: .2;
}
 
.flist
{
   font-family: Henvetica, Arial;
}

.flist TD
{
   font-size: 11px;
   padding: 5px;
}

.flist TH
{
   font-size: 12px;
   height: 30px;
   padding: 5px;
   background: #CEE9EF;
}


.it
{
   font-size: 14px;
   font-weight: 100;
   margin-top: 10px;
}

.crit .it A {
   color: #E50931; 
   line-height: 25px;
   text-decoration: none;
}

.warn .it A {
   color: #F2C900; 
   line-height: 25px;
   text-decoration: none;
}



.details
{
   font-family: Calibri;
   font-size: 12px;
   margin: 10px 10px 10px 0px;
}

.crit .details
{
   color: #A08080;
}

.warn .details
{
   color: #808080;
}

.details A
{
  color: #FFF;
  font-weight: 700;
  text-decoration: none;
  padding: 2px;
  background: #E5CEDE;
  -webkit-border-radius: 7px;
   -moz-border-radius: 7px;
   border-radius: 7px;
}

.details A:hover
{
   background: #A0909B;
}

.ctd
{
   margin: 10px 0px 10px 0;
   align:center;
}

.ctd A 
{
   color: #0D9922;
}

.disclaimer
{
   color: darkgreen;
   margin: 10px 10px 10px 0;
}

.note_vir
{
   margin: 10px 0 10px 0;
   //padding: 10px;
   color: #FF4F4F;
   font-size: 15px;
   font-weight: 700;
   clear:both;
  
}

.note_warn
{
   margin: 10px 0 10px 0;
   color: #F6B700;
   font-size: 15px;
   font-weight: 700;
   clear:both;
}

.note_int
{
   margin: 10px 0 10px 0;
   color: #60b5d6;
   font-size: 15px;
   font-weight: 700;
   clear:both;
}

.updateinfo
{
  color: #FFF;
  text-decoration: none;
  background: #E5CEDE;
  -webkit-border-radius: 7px;
   -moz-border-radius: 7px;
   border-radius: 7px;

  margin: 10px 0 10px 0px;   
  padding: 10px;
}


.caution
{
  color: #EF7B75;
  text-decoration: none;
  margin: 20px 0 0px 0px;   
  font-size: 12px;
}

.footer
{
  color: #303030;
  text-decoration: none;
  background: #F4F4F4;
  -webkit-border-radius: 7px;
   -moz-border-radius: 7px;
   border-radius: 7px;

  margin: 80px 0 10px 0px;   
  padding: 10px;
}

.rep
{
  color: #303030;
  text-decoration: none;
  background: #94DDDB;
  -webkit-border-radius: 7px;
   -moz-border-radius: 7px;
   border-radius: 7px;

  margin: 10px 0 10px 0px;   
  padding: 10px;
  font-size: 12px;
}

</style>

</head>
<body>

<div class="header">@@MAIN_TITLE@@ @@PATH_URL@@ (@@MODE@@)</div>
<div class="credits_header">@@CREDITS@@</div>
<div class="details_header">
   @@STAT@@<br/>
   @@SCANNED@@ @@MEMORY@@.
 </div>

 @@WARN_QUICK@@
 
 <div class="summary">
@@SUMMARY@@
 </div>
 
 <div class="offer">
@@OFFER@@
 </div>

 <div class="offer2">
@@OFFER2@@
 </div> 
 
 <div class="clear"></div>
 
 @@MAIN_CONTENT@@
 
	<div class="footer">
	@@FOOTER@@
	</div>
	
<script language="javascript">

function hsig(id) {
  var divs = document.getElementsByTagName("tr");
  for(var i = 0; i < divs.length; i++){
     
     if (divs[i].getAttribute('o') == id) {
        divs[i].innerHTML = '';
     }
  }

  return false;
}


$(document).ready(function(){
    $('#table_crit').dataTable({
       "aLengthMenu": [[100 , 500, -1], [100, 500, "All"]],
       "aoColumns": [
                                     {"iDataSort": 7, "width":"70%"},
                                     {"iDataSort": 5},
                                     {"iDataSort": 6},
                                     {"bSortable": true},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false}
                     ],
		"paging": true,
       "iDisplayLength": 500,
		"oLanguage": {
			"sLengthMenu": $msg1,
			"sZeroRecords": $msg2,
			"sInfo": $msg3,
			"sInfoEmpty": $msg4,
			"sInfoFiltered": $msg5,
			"sSearch":       $msg6,
			"sUrl":          "",
			"oPaginate": {
				"sFirst": $msg7,
				"sPrevious": $msg8,
				"sNext": $msg9,
				"sLast": $msg10
			},
			"oAria": {
				"sSortAscending": $msg11,
				"sSortDescending": $msg12	
			}
		}

     } );

});

$(document).ready(function(){
    $('#table_vir').dataTable({
       "aLengthMenu": [[100 , 500, -1], [100, 500, "All"]],
		"paging": true,
       "aoColumns": [
                                     {"iDataSort": 7, "width":"70%"},
                                     {"iDataSort": 5},
                                     {"iDataSort": 6},
                                     {"bSortable": true},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false}
                     ],
       "iDisplayLength": 500,
		"oLanguage": {
			"sLengthMenu": $msg1,
			"sZeroRecords": $msg2,
			"sInfo": $msg3,
			"sInfoEmpty": $msg4,
			"sInfoFiltered": $msg5,
			"sSearch":       $msg6,
			"sUrl":          "",
			"oPaginate": {
				"sFirst": $msg7,
				"sPrevious": $msg8,
				"sNext": $msg9,
				"sLast": $msg10
			},
			"oAria": {
				"sSortAscending":  $msg11,
				"sSortDescending": $msg12	
			}
		},

     } );

});

if ($('#table_warn0')) {
    $('#table_warn0').dataTable({
       "aLengthMenu": [[100 , 500, -1], [100, 500, "All"]],
		"paging": true,
       "aoColumns": [
                                     {"iDataSort": 7, "width":"70%"},
                                     {"iDataSort": 5},
                                     {"iDataSort": 6},
                                     {"bSortable": true},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false}
                     ],
			         "iDisplayLength": 500,
			  		"oLanguage": {
			  			"sLengthMenu": $msg1,
			  			"sZeroRecords": $msg2,
			  			"sInfo": $msg3,
			  			"sInfoEmpty": $msg4,
			  			"sInfoFiltered": $msg5,
			  			"sSearch":       $msg6,
			  			"sUrl":          "",
			  			"oPaginate": {
			  				"sFirst": $msg7,
			  				"sPrevious": $msg8,
			  				"sNext": $msg9,
			  				"sLast": $msg10
			  			},
			  			"oAria": {
			  				"sSortAscending":  $msg11,
			  				"sSortDescending": $msg12	
			  			}
		}

     } );
}

if ($('#table_warn1')) {
    $('#table_warn1').dataTable({
       "aLengthMenu": [[100 , 500, -1], [100, 500, "All"]],
		"paging": true,
       "aoColumns": [
                                     {"iDataSort": 7, "width":"70%"},
                                     {"iDataSort": 5},
                                     {"iDataSort": 6},
                                     {"bSortable": true},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false}
                     ],
			         "iDisplayLength": 500,
			  		"oLanguage": {
			  			"sLengthMenu": $msg1,
			  			"sZeroRecords": $msg2,
			  			"sInfo": $msg3,
			  			"sInfoEmpty": $msg4,
			  			"sInfoFiltered": $msg5,
			  			"sSearch":       $msg6,
			  			"sUrl":          "",
			  			"oPaginate": {
			  				"sFirst": $msg7,
			  				"sPrevious": $msg8,
			  				"sNext": $msg9,
			  				"sLast": $msg10
			  			},
			  			"oAria": {
			  				"sSortAscending":  $msg11,
			  				"sSortDescending": $msg12	
			  			}
		}

     } );
}


</script>
<!-- @@SERVICE_INFO@@  -->
 </body>
</html>
MAIN_PAGE;

$g_AiBolitAbsolutePath = dirname(__FILE__);

if (file_exists($g_AiBolitAbsolutePath . '/ai-design.html')) {
    $l_Template = file_get_contents($g_AiBolitAbsolutePath . '/ai-design.html');
}

$l_Template = str_replace('@@MAIN_TITLE@@', AI_STR_001, $l_Template);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//BEGIN_SIG 12/09/2018 02:03:43
$g_DBShe = unserialize(gzinflate(/*1536707023*/base64_decode("jXwLQ9rKE+9X2XJSCRUCITxVVARUWhQOoLZV/5yQBEgJCU2CgH3cr35nZnfR9jzu7Tlqsq9sZufxm5ndmAeFgn7wzT3IHUYHevEgsS54xsfnTwa7Ml3PCROH7oGOVbmDRCOwHXs03o5usTQPpQZ0WARPzmi19AITayfQSVVG5+1Oa3B/9PXr8bnuGdjcwEGMg8TZ9ijSjz9sF50v/hwrCr9UDGaFjssrilhRkhV1P/BxAmGEdSWoK0CdsoqcsD51/DhiNWaGoblVExdBMPWcRJolBt4qXOLF1eD6LIixZxl6Qsd7IzT9RyyoiLdrmmt/ZPpTx8PSKpRWDhJ9ozm8+dgaEBmQRHlo+eRGbhyEw9C05k44cqOrYEwNkFD5wkHCChYjK/BjmFbWDGPX8hxbW86W1AjpppcPEkexG3vOcWsR9cJgs2VPVCvJZPp2GLh2xp2GZoZqCmKBarXawcHBwrThN1xTHZIKqi4Lmy5fsZKYfmEJZTleVuZl1xelSnUwX1MZvbx+kJgEy0CDaWsmb4uvXz1IlApaqaJVchoteI4PcGmG1szsuFSmi1ltNv1qdbGKnlzHzW1yVJcXg/e0mbbUBvCzpXJ6RyDTKJo5njcyY9ez3RFVFfhzf7IBVrE2FRb5kuU2tl3JU0lJjFD3gbgzM2Y0ElXhW+p5qOq0rtxr9qFfFzOtCHaqD3ofxfDjLesMqVK8r/m5b7qd3qxHHEvrnRd8z862rDEzQw8fuPRcn5rg68Nannm5wDaIdEZeTODsE3MHH7r9njv8SBWGIIftPLne80DO2MB3NoCt7kI3BpbBWTXMZWy6PmuEK9+asaFjLqhpkU/TyudyZclQRklOs1plV4HtTlw+2160tWa0EkZZ8JxiVavRDKTVNmNnsgr5BCp8VOz/MquqGNUKgrnr+ObCAQFLrF0H/yVIcJE+RkXSB6Z9wAarpRNmGuE2ik2PARPDjGbmFyfM08IVdEEc0WL3uAJSLQ98P2zVr9ig0W/3hu3rC5Zh/W7zutugNpKAje3YCV+mWijwRbBzC6AZqYdCUYhR0wznTaK35l5TTUnIKOeA9QvNX61hAellYHf3yRG8kmGtBbxbELJLEHvXn+5WpVARMgAPCjMuu3ImkWM7pG0KSEaDeGgB1Agi1tpY3ipyn+DSDlhzGAQeAwVACk8qmL89CYhCDXTR4NzdcIrXw5h1J9SQGhAZgUTn5hAkNBq6jefR+Yadb/LVwYxaIBHzQK3OKp7AizeDaGtuXVa3PZifG7q++0ztCmL945kbMfjfZMvQfTIY6NsnbhaKksgX5wN254wzuxUplsRKXVw2wI745lT0KAu5RQ2tO6BtTc+NiFDFihwMpmBu2UWQC5QW1RAnAn/OCn684pLO7pfB2gk5DeIocEmTl4h+qAdRMZMM/MOSlHQhDJf1xodWk4Gc9lv1zl29T7V5sWA0RggWkN2uwlXIOiABdDuAW39F71OSHOleXZpnbr/jXpCuKQk19qE+Wu2IUipyNu24z7lnl9azJOnUCaxVVH5pSvwHuuoqCAPLMn02WOLjIyBmpmW7sRtc49tdzLoR6a+SNGJXZmwuVtCMvyqSrgjF3SUsdTxzGJpnZsaxac0WYJ2YOwEh3aZJUsdm5JQKI8e3QJ7JVOa44l3kwIZtqETnhmaRmz3zJvl/fHDZEMr29xegSmnJlKstvfItVLgBKdSy0HBQ82eH9Qf0dmUi064UWI21wbiGE9PikygLnv6HevZ68Ipgv127ndkoC3t/bcS7skpOvIRgJ2C1gesJ5q/ou8rG3GniapybnmdOqTLPR3NAYiZPMxKoisGX/9oJpLRWCoJ40PkVIKoUZbE7ZX3jeeURTSslIdvXTrwOwvk5LKWQrd4lGaxKWaiH6/ZH4Omr7rDF7lpnmcFlq9OhBkiAPEy6y4BbyTayYf1Dxx2yVtP1Wletz9QMiaHD/HuX9ethfXBVz7Br5441Fk2CRjkxkV67Xx+2BqzRb92xu/qAXbb6JLJVXbQwWeQulsByYKuAv6y5HQREvmpeTLXTHZ73Wy0Gr8DOXjdAchn0tuuI9Z1FEDvUSAAD/4tjxWJdq0LcoPo9DGFyAFcUT8BOl7d10XFghe6S6FktCY0Dc+Pj37oOoaJqWUDbl+ehAvRdZCoTHvtEU8ksgfbUvsLlpHd5a24JxlWrgtC93oDpWo6BPvcy1tRla2DOHYfpOQkxeqETRaz7gcUBc/AxQLjY4W100Qb1L5jtF+yyKIRWwNvkuVyGOZ8DEz1n8Dn1i+XBV/EwibTDYpmm8LDDpLmiEMlwGth/RTjLV5MsCUqGjumZq3hWGzydNStFu329MniLshCG/ipf6AVRDKI1eOlfEdzwoW4HMbvxgX5hBPDgVZOqdDHC0+ft6AMYPQ6opUUcmBNnBODGAUFbmkAqwfK6LrX5wAzNyOyCpgED5VpOxKvzwiQMOB/iiko+RBI2P/BmhtAwF5mBY60AFGx/UQ86oW8xThBOZ2zX7Mqcms+uz9dKl0y3W6Mrc22Go0s35lhB1yXXDQZtJHPm1TPKwhoMwLlYvFgDXRcAbThzRmfOB7fPSwVmvTOaryhJIB3HXxesuQ7Y4WV8wur5CgFQxwuWXKU13amLWK27ii2T22I9L43gnRkD/PwUgP2LALA5C3gS2Au2NiM2A/vLWxsC1KHilS/OayTH3Q26+V8JSqAeIdY/ajM2geUBnO37jmheEip+sAAtS8v4+mnss9ngksDxPxqk0ANopTkbMUkho4NW0OxyAkrQfxVql+4Q4Bl3wHJclGxj/PMjL5GqvhHAfKwY1dQLwQ1pAQFHXF1dn3XPPvNyQ+raztlBD1DsTWN40L3utK9bo7P69QdAt7ydNAKNHDi3z+iE8XIBF67CS/PZEWUlPuOnnGcbaJV5qXBpP7zpdDh+1Y2dUxtq5jjwTG/Gy6vC11DA+7VHiH7NseeMJoEHDx9NVp63NGPeluB9pYCOqrOJTRB+hl5A7QEVpvP0kGBhsI7gtgiXVuDhpV7MPSSOE9qpMup1B8P7JDVNPmqJo6wc5fhoHB7zJ0jCglcyiZfjcBU71szhxlEnl6BKxvHFk9G5E/BvroxOvgCaeODV5QgU3YhekNcVRVfTXrj+abTcTsPVUgNx5tUlTnCQglWkF3lZecfA5JJoO1OqE+ovQPvWBlRBDMIEK4cY/4AdjY+PJuD+I1WCsPaHbeF/x/eKtbAfeeeqEHWLw42dIi7KMEzz4+jSMXFR7NBcc9Yk+F9BeoXeREuufPBC56qCq5I6TGoKLw7JWVMTPxMaVaXZ7y1Ex8Q0BBI5S9MN6fn8GZydYQbZXHw7uMgOVk+5mzA7M28+1W3f+HL153o8DqyLyaTuNPLVs+tqvDhz39u3ujff//KpeVPNN6qFL3bcdCf7m+6nLxelRme2MfSboLqpZp363TQ6+1DKzT/kF5311+evNn8uh9KILZfxVpX8swqTj6kUUxao+r/XWK4AJhNRq/rG+bXh+reG+X9ruPmtIRhhPgPyw2FB554ZPYEh18xoebJ1fNdGH6l29LZmzmN3gtVvOQNzDwhtsx+nVNuN5qM4AGU6ipYAPdWpE1trW02lsipY6MI7/AWP1ljiaswS+Pc8dBxGjeledXfjTKDm/2eYIz4R4t0SAq5Z6ExqiaMTkKSAJZQJ+FfuHNf3xHbBTtUU+pPVtGzi5DjBonjrObUECmfGdqwgNBFVHTA/EDxXFk5+Pwhi0npvkqnDyAE+8gKLGmv0yOQsjpcHvA/ZK9AyQLK+83XlRLE2ILfx1gxdlMdITUQExEbImonU2+OTc1JBPdA+SGneXLvpd7CkRS6JyptoTcBB/DkkRaUcQSM/VlU3An42bXyCqkxSbG8PgBtpOUeWpU5An4XHR7ENamqt6iltrCb64hKFVgUBspPpZP8umTZSKao4UP829r+Mg+0LqYMEXFAXoWFpuiXuT4DUq8kEPGHv6yqID5NpZeLDc5KJQxu8QPTKNHSKtWg1Xrixmjp8SB4ntVm88KKlY7mmB3YxjNQoBm/UV7HzMVjLhRmfQA8oxaJ0Ls3LMgaMrGla8gAbasmjrAmDQSsUfMeEt2VJ2fTViHy+ulBSz87MDWfkD/MKggegmt+fvrkNT9/t9S/765/vO2vt4vvGm/md9z9PdG287o434973N7e8kyE6ARaIgKMprKQu7CJI5qDVv23175OXw2FvdAliCiLKO3F1DnMA+2EjtZlr1ybm8T07MhkFUMHqXAYL54AlE/9IJHxRD8Uo8ZAAVRg5yzTbSVRKSyQ1MF80KBedh8QX88nk3HmAHkHTDWG9NNDCK6SPdI71koxPN3ikNzPcLmEayojXloSuPvIDsHdgEhTLdkPFQg/8KDs+ZiroZ7y5T0TuM8h6HCbATqaOsrwDvW8WWQyXh5tegJwhRdi5+qEwQQFkcx0FrY2aBPPKrMnzE0uCcnAiy1w6ZF3McLpTf8v8jrbcGwblVfwyzufcD3fVbfvyOmctvGf7sh28v3zvfV7cbj9/bEftxfl6bLzPtd35dGy0p5bR35ofoa07nVuL28Xnj+89y12744Xnj+9a7ofB2ZPlnsE475fY9kOjv/1899mDtttO473x+e79bHzZn/3TeHxyVaHQOoPctH95G1vN63n74n2xfX62tPzbyLwrrG5asz/b57b3yb8OrvKbqH35adP5Up9+ej6bf777c/rJn0+tL2dz60tr2p2veaicBzXAzqBtAAg7VZP/u78/GHumPz94fHxn2a/u9tX7/x0+7qeUJLCOsO9wBb2iFKciRUQwExEGK99Wc/vVipHTCv/1J5USUfuyDBUDnCVgoUmvhuIn/+lHlGV87j+8wrIM0P3dFyjLYMK/Bgp1iqoge9wBPAcccuHEfRClLUZ7VSVYNs3YvAdlaT2drSYTJ5R8RVGWAmJM5FSEk7VT9BzxaseGsgo6HfJeFICpIDJ1QE4AZoPuF0YlmwXoEg5Ai2svuqLf+vOmNRiObvrt5OOhOwFtC2rld2XSb523+q2+nBsP6ZTRleUgCSSHsE+aV1N4q4CRKXDHwRcZrMYYZ2A1GRxDE4mvz18jsYimEW+SkC9CsZ8CJYGW210mbPN4HwMgxYc+pl8VUoFgJYoQFSvoo3RajSHT2Xm/e8UW2+irp2Gei91hgAVQpQ+GV/0Li/5Ks+QpMOdfM/C6/xLjFMTavgEY3uh2P7Rb96D3osiOR3OOPynEhJpDMWuqMBs77aaSNR2FKk+npdJ6KpUuwm/NEg9A5ikCz29mLBOxRHYVhVlEA17WBMQyc7LRGCAGrp3NMs3BoAPgRt4umKLzUcoiyrRc2+yYXTi+Ax68q8Hq8/qKkI6z/s2wdd7tN6TLRPEpjA01zBXIAwOM44Ikg3sPkA6oM3Gnq9AU3ilFq9CXVeZmLXl0ks2e9VvJQ7iDe/itJeuND9nsCVepFLmqYGwS17UGNNmt+EUL+DZaIccq48De/r1yHFBlZEf/0NGWPFiV1lMZwb/a6RTg2MQDEVapIJX69oqZgc14J0OAUwx+xLNwhajQ8Z/UBLF5vdFo9YajTv364qZ+0eJdCjwIWY8Q6q54PISiYhgRBqOiHipL07bDmmlZzjJWG51263qYZlyAUoeWF0QO46Up9o33p6XHySOK9JwwXxPsgwKCSU+AbbF6SvLthIsI4QR6H2k9l66k0pmCEJOq1C6KDMdkji0uMmAirRksaBosJkBH1yeUKftRMAl02jfl244W6FilfvzYOZZVmTJQzPuZG0ePAFnZQ/jg/+H4NuDRcIs32DTPI3DAy74FLuhyFbPMiilwOULx4vCU2iFjYEjeAXfPUxNZ5PBoBoqDfmXcRFpFzPEuleMzzVNMDrn06HJ41Tk+umzVm8dHw/aw0zq2pm5GOH48JUrhOoTZPMyiJlY+MAC7bA+GqCsOGb8f1G9bWMb7FGS86LLe7N6xz7pe4RVFQSPFC6YA+U+XQeRuRsAxKxdQj5geriRi5/+nEXxH1m8kFO59UtjBpNBbeYr+YWzszUujBPfOI/TLH0UzXLkizKrn33rzu6uS8eb0j9M9+8Pmp3/VvLv62fw/2Vbk/9z8n1ITK3o/f6ZP/E/pu963XvCFD1EVi8ATx7gUO4sCLJB8RKeI5Y/39IR4SwogGmTt1TfKehaYCzcl/taof4Lf7DrgOiNG720HtBSDGERTc303BlQJQE3lxRpQsxcGwOOxC+5MKs38leelGWCtJzlUXswW/BkQVY0Y79KMZhSSgCUGBtOk/8N7IBdUDIFNfnFb15HDXeFvCl5SLnYWuJEGONXRfExt/WCOBwIr63/tKaZEkXKdP+A/Nm6gfTaTj/dJabSSjwiAViEoZy2RBeT6e0PeKCX0RF6XLPhqpZIryiJnzKQkUEmEUMhNt52J6zs26KTQXHyD5fyR+vbqppbwIpbxzMQP0bks+BdWFtZitDCnrjVCl8qJRtOlBeheoYd3V3ENFJS7jMBxn8Fa7YrlNCoy0CVcgKQCOAxwROf8xKQkQ+0J/IABGLaFuWePCYor/O8erSUv2V0mj3lbdLb4E5BvS6VX2pspoD+ImGTe7dViyTIZ5IiacgMK+Lp+1YICbL8OQrum9OqDwV23TwmYPAV5cTzqPCLGUhONfqs+bLFh/azTYn9tYGHd+C+m7q463euLs073jF13h+z6ptNJSaanyHClTGHBQoEB82B4UNXTVfyHJu1LtYIsF80y1CRxqCw8LABjVwWlo5hF4rh/xl7iIZSjQI0veWcZBmMHmQcdIOKwv9XE4FNJjJinQHNZf1GSqPeZfsyywKZZuMagH4n/IQOE9EvxIQMn6nXB7t1RJEpgK0h8kBMVTHGDHLPaT5b938OBqu2fpB7e8D+n9If1+u3bq8EF43fUJpWVzM83rMCQEZgbddBtfCjCuwFWTLNcmkWBNUezO3LB114GYWxCpYslID2YhwWmt5CLvwU/9vcPxSxLAiwpE0e89y96jsLeJXQFZ5jhVZUwWMOKcP6YgLs7G3E0B/A6Wnlx+urT4M/OCJiq24DHSsSH3eSIFbFcqFRAxk5fohmgJ86vKbqChVxxQEGKKUBfkKurcz4C+XC0hYTi5kSJ1vA3CtT7F7f3Oiw+CH88MuNAluVAm6RYEDLbdfgEaVSKz1eqJPf/ocESACISj/cJqcASj+lpENgjHvnUXqkw2ZK3SgmjZkiRuLlud6+ZgOTJXJIB4j46EekQ9YHDO2tpAZM6Gzc+ZCfH0Cb38n/7ethl3Ruy4yypBKsYJ8ofkherRgoQickjutiA6AsLgsK4856oIsXe1Nh5vTNoAcUpoQ+iF/JV41kHoA4P/9Ezb3qdbr3ZajKYh2I7zwnRlNwEdHYmK5/U3K+2VNChKIAJPUlsAyLMtlqiVvWn2kuVHLkkvAtYomSyVlMVe1I7BROKEERN2m7Ekw7isVESiP4NJ8x7l4VHffSWncPyt8CjYLdmGLG2z/4lnMiEAaW8hyEMKL3XTo5R0iLciaBq70BUeXPaH4FonzPRjphIbbRzgCd2OgmVMzZ4sXb8bQsSQZJU1uC5r6ASEVK00wUlgSrUFFYxkRCyx933UYsQDaJZ0ScvlhPfR8pagtSY4sxd3wLckuJKhxIjqHRGIxNGGsFM7hODq2GPkwowatMZr6aAB6e7kt4qdGjzIVzjdk+Adfz2kQ9ZEGB/6gVj0wMVhurkEnSUh1kFbgHhYmf44Drw7NGrrEOaD1QU2TtUWaCw9/IJdgBITcfb12qMcjCodBbmkn1Dxrf5JkEgaor9IN3s8RJwF0yfQrJqTsuBiypGKIu4yITCvsgFyzTYqa35vMN4lLopInAG/cxogxMS9oAdta97N2AbwfjWEnK9E2z4qQf3dM3ZjNI35LzY4xGu+SlXtDA50HMjewwcbwJVwCUCJybwdfFgyu6UyuR9wcyeTG8Fcv6NRdm97J4JRio7PYSbo+yeF4vr4+zeVF4nsjxkjHc/+IC0//D3YENytZzPf0NvifkcdB7OiAIff2sq8ZuYaF5EL6WMsintqR2Ng1hFDBrdyH238PagB+LAww1Zv4dfEMqMwCG9xoguBmneYEh2yZ9B1ryI2SwHIPZOHaiJPSWh7Z4MrPn6Fh5nzUIVMJH6ujiVMWDqXKopkYMKxAv8KZiV+CBWc2kjVQvpz2EGYHC5UDFKwAe7y7J48aLoewKeSy2p/XNsWhMZtH63Oxw1232+PZaSMIj3EXso38beHNyv+/zjD/adTUNnyRJhEMQHm4PcQS7BeyCzVoEfTlHh6DU1SanJbDLNL1wgFljEEAvQid/drJ3xry0xsYo343Hm14oOeoDZJH9cRdg0ngHVeeSLyTuMnu9u879U5neV2wDMtLuQtfKWqvlDqsKmoSlhiODj2Y9visAAQfjjpMH9xxqm/G9I7+5h6Jzu9xqrMASu4qkeCpPmKW+CSetTQMMYXXilYDFy2hoM2s0kV1kl6b4pACHtGiBFYJIIfmJMoSsuIGmseD0E3q+smEI335KunRQOBmU5MCGJe5cALqyjYCST43nKZpQRMZ9bM1iatHKOEp9WuksyaWmlTnyZVma2DfqY/mJOjy7gkVZaIXcoDXOyUwfRDFbQ5kMXhHbiOy21o+zyGMMVR1mMOh0fZZHWoIcIbfwAmVqC/w7uD2A8lQ9Ae+iKwmQTLt8hHWGnd3DnkHGgcLTLflCnh8SxwhMV6MEIx5JMtJogvxRUKddAJRlGOB+MrNmcpBhQzNiqgY+jonp2vAlGCRVogOVSGLD16Sncmes5H6ks4sbgBtosyzIENrQomrFjMDZumIXLubON5F/eS1r80NGwI9BahbbxfhLtfDINpJ76ixSgSd68KqYLMAyEi+2T9kIUc05JMPXFCTyZwDi1b7kfyeNv+o8skmLPH0fLQ87nlEdAX/1vSc6nlyQn3zUwQoNCSc54Ey9FhlP2+ROdtwHNQU2Iev4AXXg7fSdaAks5Gm4Qd1SRGr0ELhB5UbRgmtiGIIRLhZHEpTZ0NrGEtTzlgEEj31kzlDh4tGMuVEyzatAD3FJHxaVv+5NAa1IkPgi312TSqdGFE2M/LFExpov7vRwbizRZnkqlaWzcsKU1SL3zpxsiMfzbKyUwcqeyFJPEP0G/r6bv4URqCbYndh1jPljEqF2MwSCtACezxMMxNnJjvk8mz3eY5sAuglWWZOhhKMGJnTDS6ratquoQF6kBUCKFonsRunYbB8V0Xhh4ETogRLs0G3z1mmPUUVrTsdyF6aW0W7TdIFs2L+CPJb+vQCwBc8IpBXy/4bUTI3GXsEAhEojm/Fs9WlSqE1iWUjQYqrXAFAG0iIMlqD5rlmYNIEO3h6mPDqhgkSJRMAOAUba8MIOUv8F0wuV74/LLKrbmQX+y/Dip1vXnP7v5+rrZD/vOtrq6eBo6znO5+rVuBrqZC6cre/553q/0TT5ORcQxFTBIHAZHycfdaZskGrUkq4lJy9A8h1+EvhIPm9b5w+bsDH7OQZGiGqPGPBuDGQDQh6Ng6fhqsn05iMW++nxFnqcBfyPy3HlN+if8Vqh8SrigeZgQGCS8h3yDQQX0mKyZEwaC/SsyCd3OTq3P2aePubqeazb7zWm59TzP2vvGfuXr09evA/1Dbr/+8RPvVBCJ3m/y+fTKj1wBUioFIfoP4SiLgD9uDk0+1mpJ2w4ibn8r8tjKcOYwPJnA+qbYTpynbAhlBZ44Z/0EwPdW1bRUdgnOlpq0kumZs1EVQLpZZ8pNVEUe31mv11qci+RepnxF7vMCoOJEkUq07Z0308pU+MsAUgVNKEGCeRbzuVJZuptc7muVx5GrcgMAqOBpwBRdUza8Ii9cHhmIQROZmbDNEpwE5EPBglV5msnhMSie9OdVMklVybHMGMZmGZc58SyHtkI8vijiygi92MQD9x33WC09EGJmTmJBOb6Pt4i7ni8uWv2BJv7yyvIuxLjLqdDy4CzB5O/t/VIKUIZQMHepKNeAKj5ajZFFgZJaj0gJHlpanESosWG4At0YxXaAkcZXTdu9FpU7Yfi6fDBsdm/4A6rCZ7OdCbNNZwHoF9q7fi2ZtZ2nLIaUk7uhfy/DYV+VEcmNnHQx+JaYxP2bR3aJmgHcrX2Gb01mdR9uF+50FrOxw+xg7b958LGpVMysIbY5GJT4KLxEcXDDD8W1eGiXJfYx+xNE2m5TxT7vlxfqC6oEmyQJa5iea0bMi2oJzYvQI5kl2PEx+5ml69CSL2KIvF24Ar8jdL5SVHI9cn3QomBZg1VoOeduKGZJoAn39oXTpRmCZamDHsPNND28C1Xb4Vs6MJoL8wYdgcgAAKIVr2iXKR+mKIb524on30ZTe8wyS/bWBoalfbFvoyR7y1QoHwEGm7gbGJQPs8uSTdDm4P5WbemtAIlHGgqfmvjjW7i00MhpSHwL3LIfUACIGpR8lNLCFT9exlMrPEBEe65mQKIR9mO1Gksu1xg45i0rIrPtxlEw9wOMoHrOYsxPFhmUOSkUce8jBcpAeNRkPHPkMUXgqORoTOmiSQA3ei4HPjV1pRQKvMsRsBwAOG3GS3XxirSmWwb+qecArNPhCh2eb4xHIlEnQ5EdcKD5rPRbvc4nLOBbpg1dnhK87Z716+yifn3R5RUEsUHJAB8bebDXyjPySRGsZm6TK0/oX4r9jylbdnTE8ilgami0xUYGNdInrxo9Y6MCH1mGfE9/cZsntAU5in5N1ZPGR6DxqP29oUwPGrr0GxGDjgA4RqoyxSA6MCOQF0vSTPFw4zUQN014NuLOtkFpEFzk05d9UYmZGyeoJaokVcgU5TxgEZ3sOy3LSyoiL/z+8vPSynu5T6C1x/6f096gPh+c929uzqvNYa7aGdzcTm55l6pIieXsnIk/pXLJKk1K4DuVrHwuXyjZ5WpxUjbgL3XgW8qrdEgUJSELs8xSZsJO8ga6WCkljlb5e8od5NJWsAIFREUplmF6CggIN/rf6/XX9bI/Hzkv0P3ftxj8vsOAmsttM5grBQmIQV9lYscDH5WJAQsiEmVuV9BCh588/BjwU4CfIvyUeMOisKCYp0E8EcMcEw8gFfXGECPC7/Caa428RGq4L2gFSgK3qGcyLM3uuXPBRHiEKSDsTvjIEglGVxHvL8+bzF3s2LjsNNkDwKR46drseKfheaSMOsjt3TQ527JYhpdXBWAKC+bQ0uyeH7eyk+d4cK6PL43+JaeBIY8I4NahRTRlCu6051XyrAkN/CVwfXjrd2D8lyO84W1og4vBiczDQioC6BS7Jyh6gDdMETUIg1KPvKPcEY+alfG2Yks9+xYHc8f/wdsVfp+f7/I94QZFo1FZgA0A+jAkEq8oCRCz8mnq/fqdoAmFkxGfZTLNRqPZ7rN7D1o4G6Yg4lYVN8XyYoKSrHjAFCxWWBUEI+WJoBYEH2PYUmtGKizvAkDmvcAPrp18lEE0oyDPScmN2rvt9ij8vIku2PG37UX4e8QNFlfCBXmw01tZLu62OpUXEvMZFACmPT3oD2aOzzPH4KoJb8b7JTb3y94p8YCCAEoKKpxRFJsheHWaEuE5F7gHSwimkzZFaPIGNxPwzkURhuT5Wga09TW+L4SpvCzNPMefYg6DblHiZQG+bOrtr9ViXBlR23kTaaQ+mkwyo4Lq4B/tXoPyYCBKLxvH/imCp73en/NfVCEECByxXo6WgJ0isQULr4UZBiuMUJLVr5u8GEgXryKqWI09N5olWbffbPXxoOlf7eZfrNkaNPjoVaG8FZgOxmngTyTVIxP6EctSGV3IEEWQCwTvdkGfZFY9Oar1HaJRH9BSSnunntQe7jsP6f5DDZDYg+isCxDwuvObq3az9/2uDj8gFsE60hqt771e4/vACV0nKnERoIAwxk36Oe+i2/RmrXX9z3rnqk7/etlstri16lfl7ie49OH++Snb9XsTowr32TVvxkcyxArR3twg1g0V3TvHvFfBKAJiQ9Z693KZIesAYvqqbF/5khIrRMHeMt/gIXdMEFM8u0tYRUqo/lIumQcr936tchfTHfg3inJ775VpO3RQyvECQDNcCRblBygCcODANVlntgcgryBoh3QARkGJjzQFY3WjxQT3htnbpFiGslCgu5g2rLEQVVIquOaYVoHXBdwPjFEU7yrOMNkGukC8qCqcHygx55EzB+nxp0IsS+KDDZ9a122j1W/zQnk2U+l2uzn692q3Gm8iD2dm2q/s7hhIuRA2oCS3o724+WANnmhn9cuuNL73MCEmI0/QvdraBjTHnSFTM3akxJXkScQ7Zyw2GoHd5KeKjZJ0oAH8koniG1p5nfi8Rc/E6KBn8sKKeCjPMWBMKjoPwjb6EN1VDL95syon7FXB88RXHMry5OFodNtu3Q2G9WGrdd3of+oNW03eQnz7oRtcj86CLS/LC9PVd8zOqLe6dgezlhjQ4POzwe8HMj7zwgIHdJ8dO7fhJUURBTXHAHOC7+bYfbZlFA7ugCG+mwAS/e+m52xMn79nWSrK5dL6vnDt5fc1F2ZmOd8X8fz7l/zC+R5tF2NXMHBZOsanmE5Rldm94twrwePj0VEhtS/u9/exBOzZjx/Ok+mBgPJFKsu4gxLNDM9r4DEnXiHPcfZW/twJ8+KbK8Yu0nN0gqECHnP+482bP3jG2KBID0qx4i7khkK4TOfSYJ61VwWKm9/X4Xcho9Jl6rfawr6eT/ODDHxg8kJhYKj3eYR+XCrUdNpkSZd4rVh27TcLzFvz163IM2e7fb+4R3Vn53l8qPz6swMtv9lxBtzG745zIytvviMs4uUlUU5fevk+i60RL5cnGI/sID5uh21+xN+oyGO05Z4e2/vXd+BHt7Ozu/nnwu3HKm8itcG1638xb90Q7NClOKZpvGyEfUXjeJNWlvt5+JUHisKVfCmK/QBDGZulHvIP+OzObCsLu1jDkxv8GGGwSMhOhvBkgqEZV5pGM2pVkns/Zze5UqNxWTxUpp8GX3nLgsBrF+3zSrV+SHzBa6QC4HFjTs6rK248KNZjFEjKaWPUwVGE2pYvy9HXY+6WwAVXtRT+IYI48alt0yFrTHTzyooML7oRsrdUx+YTtJCnBo2qPKp3Zo63o2ZozvnJqEJOpqWEDuTeEXAGJVhH5CuORineVhd64Rdp4lV5AQFxG+busAq8wZ6zgHnswVWaN5RnlFOHTHH391NK6MRaDcVXjCRjIBxD5RdmNNcSqYfa/QN+iOkh8ahq705SAA12BSy1u8xGPDJXyIlPMGSzoQlYJpvlpfIQ+NGbTIYrdnbTa4JWzGSOeQt5VhLg/cTZBKG2+0BLTn7c4wq8AQ8MFH3BhVdVuVr83D27uRi2yI8r6NJDOTfnDibpnVAcKS7o0nyheB7gsTXKhx1y8eVNxNcXBqPH09H/bv7HC2UoUh5NVZFwvEry4mcnDJrmtrUR+3MKelHUDFZebPqXpis+LlDQ5Zc7GsFqaTvg6luiS5lTjz77NPecU14qPxEz9d2Ydo0C9AlD0YW8NgMD/TE4Hfdm/Ig7frQNvPxSC1fUiJxwvhMEHInlaLRe/rJ1nBfxpkJ0w1zO55/tKOSl+6DgEV9KY47iYITbrtcmJyz5zsjOR+PjZuBjgOmYKXITBIVD8NgSbyspdkxRbNq7csRrpPTiAcN3WXK05OHWAvnJqIEoGPvrxq3su8N3WRmK4a3Lgix8m+/L6ZuADDcXLPKEkS1PXd/yVuA1BT6IT5K2yPAWxGDw6uSqvTpQElkasv4uHY15Lco6R3Wf0lnRv6al3+bP3/JTowV+XBxDfeJAI2UvKav4cvKM3jPEfDnW0jE03lhU0EC6NJH8u2BadmdOeL3galCHQ9PgnzcoGPJTWorvrEeLYBXhl104W+3c6OyduWx4wI27hTCK/yqqO0eaq6hFIHfeFwyZoXgB7i/89w/+K+8kv7qFSg8T1knMsiceOFsaUrc+bPIOTS77jioK8hg0P83BMOHC6IT+j/8L")));
$gX_DBShe = unserialize(gzinflate(/*1536707023*/base64_decode("bVX9b+I4EP1XvDn2oFIpCUmgpNvqKLDtXT9V2L1dVVVkEhOsOB9rO7Swuvvbzx67tFodv5A8j59n3htPcDTwop80ck9ENIyclKxwQrhzQiNPIf0gcr5XDUpwiepGIoyKNERCclpmOqavYo4jp17XYk0Y05CvoEE/cj6ldIMShoU4dZasSnK0lNuaeM7Z+5VUVvUvyFIWzplmCgx5MhrtyUMD8XC4hwYm8dvFFKfpViNDu4+u90HHJujzC5BpZKQQT6X5N1miuQ5DS9jsaSE8TyuxoWw3f2XwQI4wci5xkpNURaMxW+ElkdVXymWDTZQV5NaX+7M93zLOZcWL4RtjYPHrKmnEOzy0qb1WeaTkhQVd6ihycCnpG/vQshRbwMgLSQA/NpmY2u5ywKBoZakO6ji8QF2OuiswEsrWmRPUpJhVAu1wxpsdlbCsqw/VKa2CCIEzgk4R4SSLOamZapiO8zGcfOz3nUPkmL/XwIMT2K918VTuteociZx5jQuSts8+LTlY3dcaBW7kCCKTqsop6SBd0Q8WP5NljNOClnEjCC/VPgdZUi2gr2wlTBC66qyaMpG0KmPyQoUUHQcEiUGRgwPYoaUNVRp0hTpUxAlmDC+ZSt8EIVym6IM6CnOOtxY9bKVU6CjNb3m0E35geDqtmvBCoN+R+zJxXfcAnZ7uH39COHikqkspR727C9T7BrC2yB8oljJhTUo6rXg+e/g6e3hsXy4W9/EX9RaPL2a3i/aTOXZk2njJ3WfhwyX1tW+Bqqi9lrJOj5KqXLUP25t1pRR4fUtWme4h/aQAal5gt2fr6NW8SnpiK3q50piw3hYXuFdLrryNRVLVBMK1i31fCb7BrLOijMQZkbEilaTUgusY3zaSkveZU2nk7W0w78FyYFuwdXF9dz6+nj+2Y/WDJTAnhJ17Y9ragvavxhhUNdk7ZwRwaGOUormrpIB74Gvt+wrKCkxZVxSy7tLyiB1lVZUxoiQqIMxOCNVt3HWh5/2RvVlTPQng2oPkgR2V07dRGXg29BHdr5WUL1v0BLgdB49JlRK+M5gWyNcD8kO3+5suBCVFeuq0wPPxZDK7Xzio2zUjMLCz4OmRV02ZdtyDJ5A5CF+HCi3GUr4lpwXwlIhTzPMJJ8+fOSVlCuIEQ5N43mfM91OAbNlX+ZXn+0OARpbhcjy5mk3R+Xc0X9w93MD4da17N+qKqW+CEQXIQ89uu+FH87Xq6DUuv3mjAaz1zeCaEppijv+F7g99eyn+omWtRlpV7AAOTKxXDv1Eem4JYGjPvVLfnXnOm1pd7MqcO/h/mqGhmZAyo7tLbGiODcj9jV9mQWkIRgY8v1b1frn9E5IbuHbUckmTnJE/nJN//gM=")));
$g_FlexDBShe = unserialize(gzinflate(/*1536707023*/base64_decode("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")));
$gX_FlexDBShe = unserialize(gzinflate(/*1536707023*/base64_decode("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")));
$gXX_FlexDBShe = unserialize(gzinflate(/*1536707023*/base64_decode("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")));
$g_ExceptFlex = unserialize(gzinflate(/*1536707023*/base64_decode("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")));
$g_AdwareSig = unserialize(gzinflate(/*1536707023*/base64_decode("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")));
$g_PhishingSig = unserialize(gzinflate(/*1536707023*/base64_decode("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")));
$g_JSVirSig = unserialize(gzinflate(/*1536707023*/base64_decode("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")));
$gX_JSVirSig = unserialize(gzinflate(/*1536707023*/base64_decode("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")));
$g_SusDB = unserialize(gzinflate(/*1536707023*/base64_decode("S7QysKquBQA=")));
$g_SusDBPrio = unserialize(gzinflate(/*1536707023*/base64_decode("S7QysKquBQA=")));
$g_DeMapper = unserialize(base64_decode("YTo1OntzOjEwOiJ3aXphcmQucGhwIjtzOjM3OiJjbGFzcyBXZWxjb21lU3RlcCBleHRlbmRzIENXaXphcmRTdGVwIjtzOjE3OiJ1cGRhdGVfY2xpZW50LnBocCI7czozNzoieyBDVXBkYXRlQ2xpZW50OjpBZGRNZXNzYWdlMkxvZygiZXhlYyI7czoxMToiaW5jbHVkZS5waHAiO3M6NDg6IkdMT0JBTFNbIlVTRVIiXS0+SXNBdXRob3JpemVkKCkgJiYgJGFyQXV0aFJlc3VsdCI7czo5OiJzdGFydC5waHAiO3M6NjA6IkJYX1JPT1QuJy9tb2R1bGVzL21haW4vY2xhc3Nlcy9nZW5lcmFsL3VwZGF0ZV9kYl91cGRhdGVyLnBocCI7czoxMDoiaGVscGVyLnBocCI7czo1ODoiSlBsdWdpbkhlbHBlcjo6Z2V0UGx1Z2luKCJzeXN0ZW0iLCJvbmVjbGlja2NoZWNrb3V0X3ZtMyIpOyI7fQ=="));

//END_SIG
////////////////////////////////////////////////////////////////////////////
if (!isCli() && !isset($_SERVER['HTTP_USER_AGENT'])) {
    echo "#####################################################\n";
    echo "# Error: cannot run on php-cgi. Requires php as cli #\n";
    echo "#                                                   #\n";
    echo "# See FAQ: http://revisium.com/ai/faq.php           #\n";
    echo "#####################################################\n";
    exit;
}


if (version_compare(phpversion(), '5.3.1', '<')) {
    echo "#####################################################\n";
    echo "# Warning: PHP Version < 5.3.1                      #\n";
    echo "# Some function might not work properly             #\n";
    echo "# See FAQ: http://revisium.com/ai/faq.php           #\n";
    echo "#####################################################\n";
    exit;
}

if (!(function_exists("file_put_contents") && is_callable("file_put_contents"))) {
    echo "#####################################################\n";
    echo "file_put_contents() is disabled. Cannot proceed.\n";
    echo "#####################################################\n";
    exit;
}

define('AI_VERSION', '20180912');

////////////////////////////////////////////////////////////////////////////

$l_Res = '';

$g_Structure = array();
$g_Counter   = 0;

$g_SpecificExt = false;

$g_UpdatedJsonLog    = 0;
$g_NotRead           = array();
$g_FileInfo          = array();
$g_Iframer           = array();
$g_PHPCodeInside     = array();
$g_CriticalJS        = array();
$g_Phishing          = array();
$g_Base64            = array();
$g_HeuristicDetected = array();
$g_HeuristicType     = array();
$g_UnixExec          = array();
$g_SkippedFolders    = array();
$g_UnsafeFilesFound  = array();
$g_CMS               = array();
$g_SymLinks          = array();
$g_HiddenFiles       = array();
$g_Vulnerable        = array();

$g_RegExpStat = array();

$g_TotalFolder = 0;
$g_TotalFiles  = 0;

$g_FoundTotalDirs  = 0;
$g_FoundTotalFiles = 0;

if (!isCli()) {
    $defaults['site_url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/';
}

define('CRC32_LIMIT', pow(2, 31) - 1);
define('CRC32_DIFF', CRC32_LIMIT * 2 - 2);

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
srand(time());

set_time_limit(0);
ini_set('max_execution_time', '900000');
ini_set('realpath_cache_size', '16M');
ini_set('realpath_cache_ttl', '1200');
ini_set('pcre.backtrack_limit', '1000000');
ini_set('pcre.recursion_limit', '200000');
ini_set('pcre.jit', '1');

if (!function_exists('stripos')) {
    function stripos($par_Str, $par_Entry, $Offset = 0) {
        return strpos(strtolower($par_Str), strtolower($par_Entry), $Offset);
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define('CMS_BITRIX', 'Bitrix');
define('CMS_WORDPRESS', 'WordPress');
define('CMS_JOOMLA', 'Joomla');
define('CMS_DLE', 'Data Life Engine');
define('CMS_IPB', 'Invision Power Board');
define('CMS_WEBASYST', 'WebAsyst');
define('CMS_OSCOMMERCE', 'OsCommerce');
define('CMS_DRUPAL', 'Drupal');
define('CMS_MODX', 'MODX');
define('CMS_INSTANTCMS', 'Instant CMS');
define('CMS_PHPBB', 'PhpBB');
define('CMS_VBULLETIN', 'vBulletin');
define('CMS_SHOPSCRIPT', 'PHP ShopScript Premium');

define('CMS_VERSION_UNDEFINED', '0.0');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
class CmsVersionDetector {
    private $root_path;
    private $versions;
    private $types;
    
    public function __construct($root_path = '.') {
        $this->root_path = $root_path;
        $this->versions  = array();
        $this->types     = array();
        
        $version = '';
        
        $dir_list   = $this->getDirList($root_path);
        $dir_list[] = $root_path;
        
        foreach ($dir_list as $dir) {
            if ($this->checkBitrix($dir, $version)) {
                $this->addCms(CMS_BITRIX, $version);
            }
            
            if ($this->checkWordpress($dir, $version)) {
                $this->addCms(CMS_WORDPRESS, $version);
            }
            
            if ($this->checkJoomla($dir, $version)) {
                $this->addCms(CMS_JOOMLA, $version);
            }
            
            if ($this->checkDle($dir, $version)) {
                $this->addCms(CMS_DLE, $version);
            }
            
            if ($this->checkIpb($dir, $version)) {
                $this->addCms(CMS_IPB, $version);
            }
            
            if ($this->checkWebAsyst($dir, $version)) {
                $this->addCms(CMS_WEBASYST, $version);
            }
            
            if ($this->checkOsCommerce($dir, $version)) {
                $this->addCms(CMS_OSCOMMERCE, $version);
            }
            
            if ($this->checkDrupal($dir, $version)) {
                $this->addCms(CMS_DRUPAL, $version);
            }
            
            if ($this->checkMODX($dir, $version)) {
                $this->addCms(CMS_MODX, $version);
            }
            
            if ($this->checkInstantCms($dir, $version)) {
                $this->addCms(CMS_INSTANTCMS, $version);
            }
            
            if ($this->checkPhpBb($dir, $version)) {
                $this->addCms(CMS_PHPBB, $version);
            }
            
            if ($this->checkVBulletin($dir, $version)) {
                $this->addCms(CMS_VBULLETIN, $version);
            }
            
            if ($this->checkPhpShopScript($dir, $version)) {
                $this->addCms(CMS_SHOPSCRIPT, $version);
            }
            
        }
    }
    
    function getDirList($target) {
        $remove      = array(
            '.',
            '..'
        );
        $directories = array_diff(scandir($target), $remove);
        
        $res = array();
        
        foreach ($directories as $value) {
            if (is_dir($target . '/' . $value)) {
                $res[] = $target . '/' . $value;
            }
        }
        
        return $res;
    }
    
    function isCms($name, $version) {
        for ($i = 0; $i < count($this->types); $i++) {
            if ((strpos($this->types[$i], $name) !== false) && (strpos($this->versions[$i], $version) !== false)) {
                return true;
            }
        }
        
        return false;
    }
    
    function getCmsList() {
        return $this->types;
    }
    
    function getCmsVersions() {
        return $this->versions;
    }
    
    function getCmsNumber() {
        return count($this->types);
    }
    
    function getCmsName($index = 0) {
        return $this->types[$index];
    }
    
    function getCmsVersion($index = 0) {
        return $this->versions[$index];
    }
    
    private function addCms($type, $version) {
        $this->types[]    = $type;
        $this->versions[] = $version;
    }
    
    private function checkBitrix($dir, &$version) {
        $version = CMS_VERSION_UNDEFINED;
        $res     = false;
        
        if (file_exists($dir . '/bitrix')) {
            $res = true;
            
            $tmp_content = @file_get_contents($this->root_path . '/bitrix/modules/main/classes/general/version.php');
            if (preg_match('|define\("SM_VERSION","(.+?)"\)|smi', $tmp_content, $tmp_ver)) {
                $version = $tmp_ver[1];
            }
            
        }
        
        return $res;
    }
    
    private function checkWordpress($dir, &$version) {
        $version = CMS_VERSION_UNDEFINED;
        $res     = false;
        
        if (file_exists($dir . '/wp-admin')) {
            $res = true;
            
            $tmp_content = @file_get_contents($dir . '/wp-includes/version.php');
            if (preg_match('|\$wp_version\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                $version = $tmp_ver[1];
            }
        }
        
        return $res;
    }
    
    private function checkJoomla($dir, &$version) {
        $version = CMS_VERSION_UNDEFINED;
        $res     = false;
        
        if (file_exists($dir . '/libraries/joomla')) {
            $res = true;
            
            // for 1.5.x
            $tmp_content = @file_get_contents($dir . '/libraries/joomla/version.php');
            if (preg_match('|var\s+\$RELEASE\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                $version = $tmp_ver[1];
                
                if (preg_match('|var\s+\$DEV_LEVEL\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                    $version .= '.' . $tmp_ver[1];
                }
            }
            
            // for 1.7.x
            $tmp_content = @file_get_contents($dir . '/includes/version.php');
            if (preg_match('|public\s+\$RELEASE\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                $version = $tmp_ver[1];
                
                if (preg_match('|public\s+\$DEV_LEVEL\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                    $version .= '.' . $tmp_ver[1];
                }
            }
            
            
            // for 2.5.x and 3.x 
            $tmp_content = @file_get_contents($dir . '/libraries/cms/version/version.php');
            
            if (preg_match('|const\s+RELEASE\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                $version = $tmp_ver[1];
                
                if (preg_match('|const\s+DEV_LEVEL\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                    $version .= '.' . $tmp_ver[1];
                }
            }
            
        }
        
        return $res;
    }
    
    private function checkDle($dir, &$version) {
        $version = CMS_VERSION_UNDEFINED;
        $res     = false;
        
        if (file_exists($dir . '/engine/engine.php')) {
            $res = true;
            
            $tmp_content = @file_get_contents($dir . '/engine/data/config.php');
            if (preg_match('|\'version_id\'\s*=>\s*"(.+?)"|smi', $tmp_content, $tmp_ver)) {
                $version = $tmp_ver[1];
            }
            
            $tmp_content = @file_get_contents($dir . '/install.php');
            if (preg_match('|\'version_id\'\s*=>\s*"(.+?)"|smi', $tmp_content, $tmp_ver)) {
                $version = $tmp_ver[1];
            }
            
        }
        
        return $res;
    }
    
    private function checkIpb($dir, &$version) {
        $version = CMS_VERSION_UNDEFINED;
        $res     = false;
        
        if (file_exists($dir . '/ips_kernel')) {
            $res = true;
            
            $tmp_content = @file_get_contents($dir . '/ips_kernel/class_xml.php');
            if (preg_match('|IP.Board\s+v([0-9\.]+)|si', $tmp_content, $tmp_ver)) {
                $version = $tmp_ver[1];
            }
            
        }
        
        return $res;
    }
    
    private function checkWebAsyst($dir, &$version) {
        $version = CMS_VERSION_UNDEFINED;
        $res     = false;
        
        if (file_exists($dir . '/wbs/installer')) {
            $res = true;
            
            $tmp_content = @file_get_contents($dir . '/license.txt');
            if (preg_match('|v([0-9\.]+)|si', $tmp_content, $tmp_ver)) {
                $version = $tmp_ver[1];
            }
            
        }
        
        return $res;
    }
    
    private function checkOsCommerce($dir, &$version) {
        $version = CMS_VERSION_UNDEFINED;
        $res     = false;
        
        if (file_exists($dir . '/includes/version.php')) {
            $res = true;
            
            $tmp_content = @file_get_contents($dir . '/includes/version.php');
            if (preg_match('|([0-9\.]+)|smi', $tmp_content, $tmp_ver)) {
                $version = $tmp_ver[1];
            }
            
        }
        
        return $res;
    }
    
    private function checkDrupal($dir, &$version) {
        $version = CMS_VERSION_UNDEFINED;
        $res     = false;
        
        if (file_exists($dir . '/sites/all')) {
            $res = true;
            
            $tmp_content = @file_get_contents($dir . '/CHANGELOG.txt');
            if (preg_match('|Drupal\s+([0-9\.]+)|smi', $tmp_content, $tmp_ver)) {
                $version = $tmp_ver[1];
            }
            
        }
        
        if (file_exists($dir . '/core/lib/Drupal.php')) {
            $res = true;
            
            $tmp_content = @file_get_contents($dir . '/core/lib/Drupal.php');
            if (preg_match('|VERSION\s*=\s*\'(\d+\.\d+\.\d+)\'|smi', $tmp_content, $tmp_ver)) {
                $version = $tmp_ver[1];
            }
            
        }
        
        if (file_exists($dir . 'modules/system/system.info')) {
            $res = true;
            
            $tmp_content = @file_get_contents($dir . 'modules/system/system.info');
            if (preg_match('|version\s*=\s*"\d+\.\d+"|smi', $tmp_content, $tmp_ver)) {
                $version = $tmp_ver[1];
            }
            
        }
        
        return $res;
    }
    
    private function checkMODX($dir, &$version) {
        $version = CMS_VERSION_UNDEFINED;
        $res     = false;
        
        if (file_exists($dir . '/manager/assets')) {
            $res = true;
            
            // no way to pick up version
        }
        
        return $res;
    }
    
    private function checkInstantCms($dir, &$version) {
        $version = CMS_VERSION_UNDEFINED;
        $res     = false;
        
        if (file_exists($dir . '/plugins/p_usertab')) {
            $res = true;
            
            $tmp_content = @file_get_contents($dir . '/index.php');
            if (preg_match('|InstantCMS\s+v([0-9\.]+)|smi', $tmp_content, $tmp_ver)) {
                $version = $tmp_ver[1];
            }
            
        }
        
        return $res;
    }
    
    private function checkPhpBb($dir, &$version) {
        $version = CMS_VERSION_UNDEFINED;
        $res     = false;
        
        if (file_exists($dir . '/includes/acp')) {
            $res = true;
            
            $tmp_content = @file_get_contents($dir . '/config.php');
            if (preg_match('|phpBB\s+([0-9\.x]+)|smi', $tmp_content, $tmp_ver)) {
                $version = $tmp_ver[1];
            }
            
        }
        
        return $res;
    }
    
    private function checkVBulletin($dir, &$version) {
        $version = CMS_VERSION_UNDEFINED;
        $res     = false;
        if (file_exists($dir . '/core/includes/md5_sums_vbulletin.php')) {
            $res = true;
            require_once($dir . '/core/includes/md5_sums_vbulletin.php');
            $version = $md5_sum_versions['vb5_connect'];
        } else if (file_exists($dir . '/includes/md5_sums_vbulletin.php')) {
            $res = true;
            require_once($dir . '/includes/md5_sums_vbulletin.php');
            $version = $md5_sum_versions['vbulletin'];
        }
        return $res;
    }
    
    private function checkPhpShopScript($dir, &$version) {
        $version = CMS_VERSION_UNDEFINED;
        $res     = false;
        
        if (file_exists($dir . '/install/consts.php')) {
            $res = true;
            
            $tmp_content = @file_get_contents($dir . '/install/consts.php');
            if (preg_match('|STRING_VERSION\',\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                $version = $tmp_ver[1];
            }
            
        }
        
        return $res;
    }
}

/**
 * Print file
 */
function printFile() {
    die("Not Supported");
 
    $l_FileName = $_GET['fn'];
    $l_CRC      = isset($_GET['c']) ? (int) $_GET['c'] : 0;
    $l_Content  = file_get_contents($l_FileName);
    $l_FileCRC  = realCRC($l_Content);
    if ($l_FileCRC != $l_CRC) {
        echo 'Доступ запрещен.';
        exit;
    }
    
    echo '<pre>' . htmlspecialchars($l_Content) . '</pre>';
}

/**
 *
 */
function realCRC($str_in, $full = false) {
    $in = crc32($full ? normal($str_in) : $str_in);
    return ($in > CRC32_LIMIT) ? ($in - CRC32_DIFF) : $in;
}


/**
 * Determine php script is called from the command line interface
 * @return bool
 */
function isCli() {
    return php_sapi_name() == 'cli';
}

function myCheckSum($str) {
    return hash('crc32b', $str);
}

function generatePassword($length = 9) {
    
    // start with a blank password
    $password = "";
    
    // define possible characters - any character in this string can be
    // picked for use in the password, so if you want to put vowels back in
    // or add special characters such as exclamation marks, this is where
    // you should do it
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
    
    // we refer to the length of $possible a few times, so let's grab it now
    $maxlength = strlen($possible);
    
    // check for length overflow and truncate if necessary
    if ($length > $maxlength) {
        $length = $maxlength;
    }
    
    // set up a counter for how many characters are in the password so far
    $i = 0;
    
    // add random characters to $password until $length is reached
    while ($i < $length) {
        
        // pick a random character from the possible ones
        $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
        
        // have we already used this character in $password?
        if (!strstr($password, $char)) {
            // no, so it's OK to add it onto the end of whatever we've already got...
            $password .= $char;
            // ... and increase the counter by one
            $i++;
        }
        
    }
    
    // done!
    return $password;
    
}

/**
 * Print to console
 * @param mixed $text
 * @param bool $add_lb Add line break
 * @return void
 */
function stdOut($text, $add_lb = true) {
    if (!isCli())
        return;
    
    if (is_bool($text)) {
        $text = $text ? 'true' : 'false';
    } else if (is_null($text)) {
        $text = 'null';
    }
    if (!is_scalar($text)) {
        $text = print_r($text, true);
    }
    
    if ((!BOOL_RESULT) && (!JSON_STDOUT)) {
        @fwrite(STDOUT, $text . ($add_lb ? "\n" : ''));
    }
}

/**
 * Print progress
 * @param int $num Current file
 */
function printProgress($num, &$par_File) {
    global $g_CriticalPHP, $g_Base64, $g_Phishing, $g_CriticalJS, $g_Iframer, $g_UpdatedJsonLog, $g_AddPrefix, $g_NoPrefix;
    
    $total_files  = $GLOBALS['g_FoundTotalFiles'];
    $elapsed_time = microtime(true) - START_TIME;
    $percent      = number_format($total_files ? $num * 100 / $total_files : 0, 1);
    $stat         = '';
    if ($elapsed_time >= 1) {
        $elapsed_seconds = round($elapsed_time, 0);
        $fs              = floor($num / $elapsed_seconds);
        $left_files      = $total_files - $num;
        if ($fs > 0) {
            $left_time = ($left_files / $fs); //ceil($left_files / $fs);
            $stat      = ' [Avg: ' . round($fs, 2) . ' files/s' . ($left_time > 0 ? ' Left: ' . seconds2Human($left_time) : '') . '] [Mlw:' . (count($g_CriticalPHP) + count($g_Base64)) . '|' . (count($g_CriticalJS) + count($g_Iframer) + count($g_Phishing)) . ']';
        }
    }
    
    $l_FN = $g_AddPrefix . str_replace($g_NoPrefix, '', $par_File);
    $l_FN = substr($par_File, -60);
    
    $text = "$percent% [$l_FN] $num of {$total_files}. " . $stat;
    $text = str_pad($text, 160, ' ', STR_PAD_RIGHT);
    stdOut(str_repeat(chr(8), 160) . $text, false);
    
    
    $data = array(
        'self' => __FILE__,
        'started' => AIBOLIT_START_TIME,
        'updated' => time(),
        'progress' => $percent,
        'time_elapsed' => $elapsed_seconds,
        'time_left' => round($left_time),
        'files_left' => $left_files,
        'files_total' => $total_files,
        'current_file' => substr($g_AddPrefix . str_replace($g_NoPrefix, '', $par_File), -160)
    );
    
    if (function_exists('aibolit_onProgressUpdate')) {
        aibolit_onProgressUpdate($data);
    }
    
    if (defined('PROGRESS_LOG_FILE') && (time() - $g_UpdatedJsonLog > 1)) {
        if (function_exists('json_encode')) {
            file_put_contents(PROGRESS_LOG_FILE, json_encode($data));
        } else {
            file_put_contents(PROGRESS_LOG_FILE, serialize($data));
        }
        
        $g_UpdatedJsonLog = time();
    }
}

/**
 * Seconds to human readable
 * @param int $seconds
 * @return string
 */
function seconds2Human($seconds) {
    $r        = '';
    $_seconds = floor($seconds);
    $ms       = $seconds - $_seconds;
    $seconds  = $_seconds;
    if ($hours = floor($seconds / 3600)) {
        $r .= $hours . (isCli() ? ' h ' : ' час ');
        $seconds = $seconds % 3600;
    }
    
    if ($minutes = floor($seconds / 60)) {
        $r .= $minutes . (isCli() ? ' m ' : ' мин ');
        $seconds = $seconds % 60;
    }
    
    if ($minutes < 3)
        $r .= ' ' . $seconds + ($ms > 0 ? round($ms) : 0) . (isCli() ? ' s' : ' сек');
    
    return $r;
}

if (isCli()) {
    
    $cli_options = array(
        'y' => 'deobfuscate',
        'c:' => 'avdb:',
        'm:' => 'memory:',
        's:' => 'size:',
        'a' => 'all',
        'd:' => 'delay:',
        'l:' => 'list:',
        'r:' => 'report:',
        'f' => 'fast',
        'j:' => 'file:',
        'p:' => 'path:',
        'q' => 'quite',
        'e:' => 'cms:',
        'x:' => 'mode:',
        'k:' => 'skip:',
        'i:' => 'idb:',
        'n' => 'sc',
        'o:' => 'json_report:',
        't:' => 'php_report:',
        'z:' => 'progress:',
        'g:' => 'handler:',
        'b' => 'smart',
        'u:' => 'username:',
        'h' => 'help'
    );
    
    $cli_longopts = array(
        'deobfuscate',
        'avdb:',
        'cmd:',
        'noprefix:',
        'addprefix:',
        'scan:',
        'one-pass',
        'smart',
        'quarantine',
        'with-2check',
        'skip-cache',
        'username:',
        'imake',
        'icheck',
        'no-html',
        'json-stdout', 
        'listing:'
    );
    
    $cli_longopts = array_merge($cli_longopts, array_values($cli_options));
    
    $options = getopt(implode('', array_keys($cli_options)), $cli_longopts);
    
    if (isset($options['h']) OR isset($options['help'])) {
        $memory_limit = ini_get('memory_limit');
        echo <<<HELP
Revisium AI-Bolit - an Intelligent Malware File Scanner for Websites.

Usage: php {$_SERVER['PHP_SELF']} [OPTIONS] [PATH]
Current default path is: {$defaults['path']}

  -j, --file=FILE      		Full path to single file to check
  -p, --path=PATH      		Directory path to scan, by default the file directory is used
                       		Current path: {$defaults['path']}
  -p, --listing=FILE      	Scan files from the listing. E.g. --listing=/tmp/myfilelist.txt
                                Use --listing=stdin to get listing from stdin stream
  -x, --mode=INT       		Set scan mode. 0 - for basic, 1 - for expert and 2 for paranoic.
  -k, --skip=jpg,...   		Skip specific extensions. E.g. --skip=jpg,gif,png,xls,pdf
      --scan=php,...   		Scan only specific extensions. E.g. --scan=php,htaccess,js

  -r, --report=PATH/EMAILS
  -o, --json_report=FILE	Full path to create json-file with a list of found malware
  -l, --list=FILE      		Full path to create plain text file with a list of found malware
      --no-html                 Disable HTML report

      --smart                   Enable smart mode (skip cache files and optimize scanning)
  -m, --memory=SIZE    		Maximum amount of memory a script may consume. Current value: $memory_limit
                       		Can take shorthand byte values (1M, 1G...)
  -s, --size=SIZE      		Scan files are smaller than SIZE. 0 - All files. Current value: {$defaults['max_size_to_scan']}
  -d, --delay=INT      		Delay in milliseconds when scanning files to reduce load on the file system (Default: 1)
  -a, --all            		Scan all files (by default scan. js,. php,. html,. htaccess)
      --one-pass       		Do not calculate remaining time
      --quarantine     		Archive all malware from report
      --with-2check    		Create or use AI-BOLIT-DOUBLECHECK.php file
      --imake
      --icheck
      --idb=file	   	Integrity Check database file

  -z, --progress=FILE  		Runtime progress of scanning, saved to the file, full path required. 
  -u, --username=<username>  	Run scanner with specific user id and group id, e.g. --username=www-data
  -g, --hander=FILE    		External php handler for different events, full path to php file required.
      --cmd="command [args...]"	Run command after scanning

      --help           		Display this help and exit

* Mandatory arguments listed below are required for both full and short way of usage.

HELP;
        exit;
    }
    
    $l_FastCli = false;

    if ((isset($options['memory']) AND !empty($options['memory']) AND ($memory = $options['memory'])) OR (isset($options['m']) AND !empty($options['m']) AND ($memory = $options['m']))) {
        $memory = getBytes($memory);
        if ($memory > 0) {
            $defaults['memory_limit'] = $memory;
            ini_set('memory_limit', $memory);
        }
    }
    
    
    $avdb = '';
    if ((isset($options['avdb']) AND !empty($options['avdb']) AND ($avdb = $options['avdb'])) OR (isset($options['c']) AND !empty($options['c']) AND ($avdb = $options['c']))) {
        if (file_exists($avdb)) {
            $defaults['avdb'] = $avdb;
        }
    }
    
    if ((isset($options['file']) AND !empty($options['file']) AND ($file = $options['file']) !== false) OR (isset($options['j']) AND !empty($options['j']) AND ($file = $options['j']) !== false)) {
        define('SCAN_FILE', $file);
    }
    
    
    if (isset($options['deobfuscate']) OR isset($options['y'])) {
        define('AI_DEOBFUSCATE', true);
    }
    
    if ((isset($options['list']) AND !empty($options['list']) AND ($file = $options['list']) !== false) OR (isset($options['l']) AND !empty($options['l']) AND ($file = $options['l']) !== false)) {
        
        define('PLAIN_FILE', $file);
    }
    
    if ((isset($options['listing']) AND !empty($options['listing']) AND ($listing = $options['listing']) !== false)) {
        
        if (file_exists($listing) && is_file($listing) && is_readable($listing)) {
            define('LISTING_FILE', $listing);
        }

        if ($listing == 'stdin') {
            define('LISTING_FILE', $listing);
        }
    }
    
    if ((isset($options['json_report']) AND !empty($options['json_report']) AND ($file = $options['json_report']) !== false) OR (isset($options['o']) AND !empty($options['o']) AND ($file = $options['o']) !== false)) {
        define('JSON_FILE', $file);

        if (!function_exists('json_encode')) {
           die('json_encode function is not available. Enable json extension in php.ini');
        }
    }
    
    if ((isset($options['php_report']) AND !empty($options['php_report']) AND ($file = $options['php_report']) !== false) OR (isset($options['t']) AND !empty($options['t']) AND ($file = $options['t']) !== false)) {
        define('PHP_FILE', $file);
    }
    
    if (isset($options['smart']) OR isset($options['b'])) {
        define('SMART_SCAN', 1);
    }
    
    if ((isset($options['handler']) AND !empty($options['handler']) AND ($file = $options['handler']) !== false) OR (isset($options['g']) AND !empty($options['g']) AND ($file = $options['g']) !== false)) {
        if (file_exists($file)) {
            define('AIBOLIT_EXTERNAL_HANDLER', $file);
        }
    }
    
    if ((isset($options['progress']) AND !empty($options['progress']) AND ($file = $options['progress']) !== false) OR (isset($options['z']) AND !empty($options['z']) AND ($file = $options['z']) !== false)) {
        define('PROGRESS_LOG_FILE', $file);
    }
    
    if ((isset($options['size']) AND !empty($options['size']) AND ($size = $options['size']) !== false) OR (isset($options['s']) AND !empty($options['s']) AND ($size = $options['s']) !== false)) {
        $size                         = getBytes($size);
        $defaults['max_size_to_scan'] = $size > 0 ? $size : 0;
    }
    
    if ((isset($options['username']) AND !empty($options['username']) AND ($username = $options['username']) !== false) OR (isset($options['u']) AND !empty($options['u']) AND ($username = $options['u']) !== false)) {
        
        if (!empty($username) && ($info = posix_getpwnam($username)) !== false) {
            posix_setgid($info['gid']);
            posix_setuid($info['uid']);
            $defaults['userid']  = $info['uid'];
            $defaults['groupid'] = $info['gid'];
        } else {
            echo ('Invalid username');
            exit(-1);
        }
    }
    
    if ((isset($options['file']) AND !empty($options['file']) AND ($file = $options['file']) !== false) OR (isset($options['j']) AND !empty($options['j']) AND ($file = $options['j']) !== false) AND (isset($options['q']))) {
        $BOOL_RESULT = true;
    }
    
    if (isset($options['json-stdout'])) {
       define('JSON_STDOUT', true);  
    } else {
       define('JSON_STDOUT', false);  
    }

    if (isset($options['f'])) {
        $l_FastCli = true;
    }
    
    if (isset($options['q']) || isset($options['quite'])) {
        $BOOL_RESULT = true;
    }
    
    if (isset($options['x'])) {
        define('AI_EXPERT', $options['x']);
    } else if (isset($options['mode'])) {
        define('AI_EXPERT', $options['mode']);
    } else {
        define('AI_EXPERT', AI_EXPERT_MODE);
    }
    
    if (AI_EXPERT < 2) {
        $g_SpecificExt              = true;
        $defaults['scan_all_files'] = false;
    } else {
        $defaults['scan_all_files'] = true;
    }
    
    define('BOOL_RESULT', $BOOL_RESULT);
    
    if ((isset($options['delay']) AND !empty($options['delay']) AND ($delay = $options['delay']) !== false) OR (isset($options['d']) AND !empty($options['d']) AND ($delay = $options['d']) !== false)) {
        $delay = (int) $delay;
        if (!($delay < 0)) {
            $defaults['scan_delay'] = $delay;
        }
    }
    
    if ((isset($options['skip']) AND !empty($options['skip']) AND ($ext_list = $options['skip']) !== false) OR (isset($options['k']) AND !empty($options['k']) AND ($ext_list = $options['k']) !== false)) {
        $defaults['skip_ext'] = $ext_list;
    }
    
    if (isset($options['n']) OR isset($options['skip-cache'])) {
        $defaults['skip_cache'] = true;
    }
    
    if (isset($options['scan'])) {
        $ext_list = strtolower(trim($options['scan'], " ,\t\n\r\0\x0B"));
        if ($ext_list != '') {
            $l_FastCli        = true;
            $g_SensitiveFiles = explode(",", $ext_list);
            for ($i = 0; $i < count($g_SensitiveFiles); $i++) {
                if ($g_SensitiveFiles[$i] == '.') {
                    $g_SensitiveFiles[$i] = '';
                }
            }
            
            $g_SpecificExt = true;
        }
    }
    
    
    if (isset($options['all']) OR isset($options['a'])) {
        $defaults['scan_all_files'] = true;
        $g_SpecificExt              = false;
    }
    
    if (isset($options['cms'])) {
        define('CMS', $options['cms']);
    } else if (isset($options['e'])) {
        define('CMS', $options['e']);
    }
    
    
    if (!defined('SMART_SCAN')) {
        define('SMART_SCAN', 1);
    }
    
    if (!defined('AI_DEOBFUSCATE')) {
        define('AI_DEOBFUSCATE', false);
    }
    
    
    $l_SpecifiedPath = false;
    if ((isset($options['path']) AND !empty($options['path']) AND ($path = $options['path']) !== false) OR (isset($options['p']) AND !empty($options['p']) AND ($path = $options['p']) !== false)) {
        $defaults['path'] = $path;
        $l_SpecifiedPath  = true;
    }
    
    if (isset($options['noprefix']) AND !empty($options['noprefix']) AND ($g_NoPrefix = $options['noprefix']) !== false) {
    } else {
        $g_NoPrefix = '';
    }
    
    if (isset($options['addprefix']) AND !empty($options['addprefix']) AND ($g_AddPrefix = $options['addprefix']) !== false) {
    } else {
        $g_AddPrefix = '';
    }
    
    
    
    $l_SuffixReport = str_replace('/var/www', '', $defaults['path']);
    $l_SuffixReport = str_replace('/home', '', $l_SuffixReport);
    $l_SuffixReport = preg_replace('#[/\\\.\s]#', '_', $l_SuffixReport);
    $l_SuffixReport .= "-" . rand(1, 999999);
    
    if ((isset($options['report']) AND ($report = $options['report']) !== false) OR (isset($options['r']) AND ($report = $options['r']) !== false)) {
        $report = str_replace('@PATH@', $l_SuffixReport, $report);
        $report = str_replace('@RND@', rand(1, 999999), $report);
        $report = str_replace('@DATE@', date('d-m-Y-h-i'), $report);
        define('REPORT', $report);
        define('NEED_REPORT', true);
    }
    
    if (isset($options['no-html'])) {
        define('REPORT', 'no@email.com');
    }
    
    if ((isset($options['idb']) AND ($ireport = $options['idb']) !== false)) {
        $ireport = str_replace('@PATH@', $l_SuffixReport, $ireport);
        $ireport = str_replace('@RND@', rand(1, 999999), $ireport);
        $ireport = str_replace('@DATE@', date('d-m-Y-h-i'), $ireport);
        define('INTEGRITY_DB_FILE', $ireport);
    }
    
    
    defined('REPORT') OR define('REPORT', 'AI-BOLIT-REPORT.html');
    
    defined('INTEGRITY_DB_FILE') OR define('INTEGRITY_DB_FILE', 'AINTEGRITY-' . $l_SuffixReport . '-' . date('d-m-Y_H-i'));
    
    $last_arg = max(1, sizeof($_SERVER['argv']) - 1);
    if (isset($_SERVER['argv'][$last_arg])) {
        $path = $_SERVER['argv'][$last_arg];
        if (substr($path, 0, 1) != '-' AND (substr($_SERVER['argv'][$last_arg - 1], 0, 1) != '-' OR array_key_exists(substr($_SERVER['argv'][$last_arg - 1], -1), $cli_options))) {
            $defaults['path'] = $path;
        }
    }    
    
    define('ONE_PASS', isset($options['one-pass']));
    
    define('IMAKE', isset($options['imake']));
    define('ICHECK', isset($options['icheck']));
    
    if (IMAKE && ICHECK)
        die('One of the following options must be used --imake or --icheck.');
    
} else {
    define('AI_EXPERT', AI_EXPERT_MODE);
    define('ONE_PASS', true);
}


if (isset($defaults['avdb']) && file_exists($defaults['avdb'])) {
    $avdb = explode("\n", gzinflate(base64_decode(str_rot13(strrev(trim(file_get_contents($defaults['avdb'])))))));
    
    $g_DBShe       = explode("\n", base64_decode($avdb[0]));
    $gX_DBShe      = explode("\n", base64_decode($avdb[1]));
    $g_FlexDBShe   = explode("\n", base64_decode($avdb[2]));
    $gX_FlexDBShe  = explode("\n", base64_decode($avdb[3]));
    $gXX_FlexDBShe = explode("\n", base64_decode($avdb[4]));
    $g_ExceptFlex  = explode("\n", base64_decode($avdb[5]));
    $g_AdwareSig   = explode("\n", base64_decode($avdb[6]));
    $g_PhishingSig = explode("\n", base64_decode($avdb[7]));
    $g_JSVirSig    = explode("\n", base64_decode($avdb[8]));
    $gX_JSVirSig   = explode("\n", base64_decode($avdb[9]));
    $g_SusDB       = explode("\n", base64_decode($avdb[10]));
    $g_SusDBPrio   = explode("\n", base64_decode($avdb[11]));
    $g_DeMapper    = array_combine(explode("\n", base64_decode($avdb[12])), explode("\n", base64_decode($avdb[13])));
    
    if (count($g_DBShe) <= 1) {
        $g_DBShe = array();
    }
    
    if (count($gX_DBShe) <= 1) {
        $gX_DBShe = array();
    }
    
    if (count($g_FlexDBShe) <= 1) {
        $g_FlexDBShe = array();
    }
    
    if (count($gX_FlexDBShe) <= 1) {
        $gX_FlexDBShe = array();
    }
    
    if (count($gXX_FlexDBShe) <= 1) {
        $gXX_FlexDBShe = array();
    }
    
    if (count($g_ExceptFlex) <= 1) {
        $g_ExceptFlex = array();
    }
    
    if (count($g_AdwareSig) <= 1) {
        $g_AdwareSig = array();
    }
    
    if (count($g_PhishingSig) <= 1) {
        $g_PhishingSig = array();
    }
    
    if (count($gX_JSVirSig) <= 1) {
        $gX_JSVirSig = array();
    }
    
    if (count($g_JSVirSig) <= 1) {
        $g_JSVirSig = array();
    }
    
    if (count($g_SusDB) <= 1) {
        $g_SusDB = array();
    }
    
    if (count($g_SusDBPrio) <= 1) {
        $g_SusDBPrio = array();
    }
    
    stdOut('Loaded external signatures from ' . $defaults['avdb']);
}

// use only basic signature subset
if (AI_EXPERT < 2) {
    $gX_FlexDBShe  = array();
    $gXX_FlexDBShe = array();
    $gX_JSVirSig   = array();
}

if (isset($defaults['userid'])) {
    stdOut('Running from ' . $defaults['userid'] . ':' . $defaults['groupid']);
}

stdOut('Malware signatures: ' . (count($g_JSVirSig) + count($gX_JSVirSig) + count($g_DBShe) + count($gX_DBShe) + count($gX_DBShe) + count($g_FlexDBShe) + count($gX_FlexDBShe) + count($gXX_FlexDBShe)));

if ($g_SpecificExt) {
    stdOut("Scan specific extensions: " . implode(',', $g_SensitiveFiles));
}

if (!DEBUG_PERFORMANCE) {
    OptimizeSignatures();
} else {
    stdOut("Debug Performance Scan");
}

$g_DBShe  = array_map('strtolower', $g_DBShe);
$gX_DBShe = array_map('strtolower', $gX_DBShe);

if (!defined('PLAIN_FILE')) {
    define('PLAIN_FILE', '');
}

// Init
define('MAX_ALLOWED_PHP_HTML_IN_DIR', 600);
define('BASE64_LENGTH', 69);
define('MAX_PREVIEW_LEN', 120);
define('MAX_EXT_LINKS', 1001);

if (defined('AIBOLIT_EXTERNAL_HANDLER')) {
    include_once(AIBOLIT_EXTERNAL_HANDLER);
    stdOut("\nLoaded external handler: " . AIBOLIT_EXTERNAL_HANDLER . "\n");
    if (function_exists("aibolit_onStart")) {
        aibolit_onStart();
    }
}

// Perform full scan when running from command line
if (isset($_GET['full'])) {
    $defaults['scan_all_files'] = 1;
}

if ($l_FastCli) {
    $defaults['scan_all_files'] = 0;
}

if (!isCli()) {
    define('ICHECK', isset($_GET['icheck']));
    define('IMAKE', isset($_GET['imake']));
    
    define('INTEGRITY_DB_FILE', 'ai-integrity-db');
}

define('SCAN_ALL_FILES', (bool) $defaults['scan_all_files']);
define('SCAN_DELAY', (int) $defaults['scan_delay']);
define('MAX_SIZE_TO_SCAN', getBytes($defaults['max_size_to_scan']));

if ($defaults['memory_limit'] AND ($defaults['memory_limit'] = getBytes($defaults['memory_limit'])) > 0) {
    ini_set('memory_limit', $defaults['memory_limit']);
    stdOut("Changed memory limit to " . $defaults['memory_limit']);
}

define('ROOT_PATH', realpath($defaults['path']));

if (!ROOT_PATH) {
    if (isCli()) {
        die(stdOut("Directory '{$defaults['path']}' not found!"));
    }
} elseif (!is_readable(ROOT_PATH)) {
    if (isCli()) {
        die2(stdOut("Cannot read directory '" . ROOT_PATH . "'!"));
    }
}

define('CURRENT_DIR', getcwd());
chdir(ROOT_PATH);

if (isCli() AND REPORT !== '' AND !getEmails(REPORT)) {
    $report      = str_replace('\\', '/', REPORT);
    $abs         = strpos($report, '/') === 0 ? DIR_SEPARATOR : '';
    $report      = array_values(array_filter(explode('/', $report)));
    $report_file = array_pop($report);
    $report_path = realpath($abs . implode(DIR_SEPARATOR, $report));
    
    define('REPORT_FILE', $report_file);
    define('REPORT_PATH', $report_path);
    
    if (REPORT_FILE AND REPORT_PATH AND is_file(REPORT_PATH . DIR_SEPARATOR . REPORT_FILE)) {
        @unlink(REPORT_PATH . DIR_SEPARATOR . REPORT_FILE);
    }
}

if (defined('REPORT_PATH')) {
    $l_ReportDirName = REPORT_PATH;
}

define('QUEUE_FILENAME', ($l_ReportDirName != '' ? $l_ReportDirName . '/' : '') . 'AI-BOLIT-QUEUE-' . md5($defaults['path']) . '-' . rand(1000, 9999) . '.txt');

if (function_exists('phpinfo')) {
    ob_start();
    phpinfo();
    $l_PhpInfo = ob_get_contents();
    ob_end_clean();
    
    $l_PhpInfo = str_replace('border: 1px', '', $l_PhpInfo);
    preg_match('|<body>(.*)</body>|smi', $l_PhpInfo, $l_PhpInfoBody);
}

////////////////////////////////////////////////////////////////////////////
$l_Template = str_replace("@@MODE@@", AI_EXPERT . '/' . SMART_SCAN, $l_Template);

if (AI_EXPERT == 0) {
    $l_Result .= '<div class="rep">' . AI_STR_057 . '</div>';
} else {
}

$l_Template = str_replace('@@HEAD_TITLE@@', AI_STR_051 . $g_AddPrefix . str_replace($g_NoPrefix, '', ROOT_PATH), $l_Template);

define('QCR_INDEX_FILENAME', 'fn');
define('QCR_INDEX_TYPE', 'type');
define('QCR_INDEX_WRITABLE', 'wr');
define('QCR_SVALUE_FILE', '1');
define('QCR_SVALUE_FOLDER', '0');

/**
 * Extract emails from the string
 * @param string $email
 * @return array of strings with emails or false on error
 */
function getEmails($email) {
    $email = preg_split('#[,\s;]#', $email, -1, PREG_SPLIT_NO_EMPTY);
    $r     = array();
    for ($i = 0, $size = sizeof($email); $i < $size; $i++) {
        if (function_exists('filter_var')) {
            if (filter_var($email[$i], FILTER_VALIDATE_EMAIL)) {
                $r[] = $email[$i];
            }
        } else {
            // for PHP4
            if (strpos($email[$i], '@') !== false) {
                $r[] = $email[$i];
            }
        }
    }
    return empty($r) ? false : $r;
}

/**
 * Get bytes from shorthand byte values (1M, 1G...)
 * @param int|string $val
 * @return int
 */
function getBytes($val) {
    $val  = trim($val);
    $last = strtolower($val{strlen($val) - 1});
    switch ($last) {
        case 't':
            $val *= 1024;
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    return intval($val);
}

/**
 * Format bytes to human readable
 * @param int $bites
 * @return string
 */
function bytes2Human($bites) {
    if ($bites < 1024) {
        return $bites . ' b';
    } elseif (($kb = $bites / 1024) < 1024) {
        return number_format($kb, 2) . ' Kb';
    } elseif (($mb = $kb / 1024) < 1024) {
        return number_format($mb, 2) . ' Mb';
    } elseif (($gb = $mb / 1024) < 1024) {
        return number_format($gb, 2) . ' Gb';
    } else {
        return number_format($gb / 1024, 2) . 'Tb';
    }
}

///////////////////////////////////////////////////////////////////////////
function needIgnore($par_FN, $par_CRC) {
    global $g_IgnoreList;
    
    for ($i = 0; $i < count($g_IgnoreList); $i++) {
        if (strpos($par_FN, $g_IgnoreList[$i][0]) !== false) {
            if ($par_CRC == $g_IgnoreList[$i][1]) {
                return true;
            }
        }
    }
    
    return false;
}

///////////////////////////////////////////////////////////////////////////
function makeSafeFn($par_Str, $replace_path = false) {
    global $g_AddPrefix, $g_NoPrefix;
    if ($replace_path) {
        $lines = explode("\n", $par_Str);
        array_walk($lines, function(&$n) {
            global $g_AddPrefix, $g_NoPrefix;
            $n = $g_AddPrefix . str_replace($g_NoPrefix, '', $n);
        });
        
        $par_Str = implode("\n", $lines);
    }
    
    return htmlspecialchars($par_Str, ENT_SUBSTITUTE | ENT_QUOTES);
}

function replacePathArray($par_Arr) {
    global $g_AddPrefix, $g_NoPrefix;
    array_walk($par_Arr, function(&$n) {
        global $g_AddPrefix, $g_NoPrefix;
        $n = $g_AddPrefix . str_replace($g_NoPrefix, '', $n);
    });
    
    return $par_Arr;
}

///////////////////////////////////////////////////////////////////////////
function getRawJsonVuln($par_List) {
    global $g_Structure, $g_NoPrefix, $g_AddPrefix;
    $results = array();
    $l_Src   = array(
        '&quot;',
        '&lt;',
        '&gt;',
        '&amp;',
        '&#039;',
        '<' . '?php.'
    );
    $l_Dst   = array(
        '"',
        '<',
        '>',
        '&',
        '\'',
        '<' . '?php '
    );
    
    for ($i = 0; $i < count($par_List); $i++) {
        $l_Pos      = $par_List[$i]['ndx'];
        $res['fn']  = convertToUTF8($g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$l_Pos]));
        $res['sig'] = $par_List[$i]['id'];
        
        $res['ct']    = $g_Structure['c'][$l_Pos];
        $res['mt']    = $g_Structure['m'][$l_Pos];
        $res['sz']    = $g_Structure['s'][$l_Pos];
        $res['sigid'] = 'vuln_' . md5($g_Structure['n'][$l_Pos] . $par_List[$i]['id']);
        
        $results[] = $res;
    }
    
    return $results;
}

///////////////////////////////////////////////////////////////////////////
function getRawJson($par_List, $par_Details = null, $par_SigId = null) {
    global $g_Structure, $g_NoPrefix, $g_AddPrefix;
    $results = array();
    $l_Src   = array(
        '&quot;',
        '&lt;',
        '&gt;',
        '&amp;',
        '&#039;',
        '<' . '?php.'
    );
    $l_Dst   = array(
        '"',
        '<',
        '>',
        '&',
        '\'',
        '<' . '?php '
    );
    
    for ($i = 0; $i < count($par_List); $i++) {
        if ($par_SigId != null) {
            $l_SigId = 'id_' . $par_SigId[$i];
        } else {
            $l_SigId = 'id_n' . rand(1000000, 9000000);
        }
        
        
        
        $l_Pos     = $par_List[$i];
        $res['fn'] = convertToUTF8($g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$l_Pos]));
        if ($par_Details != null) {
            $res['sig'] = preg_replace('|(L\d+).+__AI_MARKER__|smi', '[$1]: ...', $par_Details[$i]);
            $res['sig'] = preg_replace('/[^\x20-\x7F]/', '.', $res['sig']);
            $res['sig'] = preg_replace('/__AI_LINE1__(\d+)__AI_LINE2__/', '[$1] ', $res['sig']);
            $res['sig'] = preg_replace('/__AI_MARKER__/', ' @!!!>', $res['sig']);
            $res['sig'] = str_replace($l_Src, $l_Dst, $res['sig']);
        }
        
        $res['sig'] = convertToUTF8($res['sig']);

        $res['ct']    = $g_Structure['c'][$l_Pos];
        $res['mt']    = $g_Structure['m'][$l_Pos];
        $res['sz']    = $g_Structure['s'][$l_Pos];
        $res['hash']  = $g_Structure['crc'][$l_Pos];
        $res['sigid'] = $l_SigId;
        
        $results[] = $res;
    }
    
    return $results;
}

///////////////////////////////////////////////////////////////////////////
function printList($par_List, $par_Details = null, $par_NeedIgnore = false, $par_SigId = null, $par_TableName = null) {
    global $g_Structure, $g_NoPrefix, $g_AddPrefix;
    
    $i = 0;
    
    if ($par_TableName == null) {
        $par_TableName = 'table_' . rand(1000000, 9000000);
    }
    
    $l_Result = '';
    $l_Result .= "<div class=\"flist\"><table cellspacing=1 cellpadding=4 border=0 id=\"" . $par_TableName . "\">";
    
    $l_Result .= "<thead><tr class=\"tbgh" . ($i % 2) . "\">";
    $l_Result .= "<th width=70%>" . AI_STR_004 . "</th>";
    $l_Result .= "<th>" . AI_STR_005 . "</th>";
    $l_Result .= "<th>" . AI_STR_006 . "</th>";
    $l_Result .= "<th width=90>" . AI_STR_007 . "</th>";
    $l_Result .= "<th width=0 class=\"hidd\">CRC32</th>";
    $l_Result .= "<th width=0 class=\"hidd\"></th>";
    $l_Result .= "<th width=0 class=\"hidd\"></th>";
    $l_Result .= "<th width=0 class=\"hidd\"></th>";
    
    $l_Result .= "</tr></thead><tbody>";
    
    for ($i = 0; $i < count($par_List); $i++) {
        if ($par_SigId != null) {
            $l_SigId = 'id_' . $par_SigId[$i];
        } else {
            $l_SigId = 'id_z' . rand(1000000, 9000000);
        }
        
        $l_Pos = $par_List[$i];
        if ($par_NeedIgnore) {
            if (needIgnore($g_Structure['n'][$par_List[$i]], $g_Structure['crc'][$l_Pos])) {
                continue;
            }
        }
        
        $l_Creat = $g_Structure['c'][$l_Pos] > 0 ? date("d/m/Y H:i:s", $g_Structure['c'][$l_Pos]) : '-';
        $l_Modif = $g_Structure['m'][$l_Pos] > 0 ? date("d/m/Y H:i:s", $g_Structure['m'][$l_Pos]) : '-';
        $l_Size  = $g_Structure['s'][$l_Pos] > 0 ? bytes2Human($g_Structure['s'][$l_Pos]) : '-';
        
        if ($par_Details != null) {
            $l_WithMarker = preg_replace('|__AI_MARKER__|smi', '<span class="marker">&nbsp;</span>', $par_Details[$i]);
            $l_WithMarker = preg_replace('|__AI_LINE1__|smi', '<span class="line_no">', $l_WithMarker);
            $l_WithMarker = preg_replace('|__AI_LINE2__|smi', '</span>', $l_WithMarker);
            
            $l_Body = '<div class="details">';
            
            if ($par_SigId != null) {
                $l_Body .= '<a href="#" onclick="return hsig(\'' . $l_SigId . '\')">[x]</a> ';
            }
            
            $l_Body .= $l_WithMarker . '</div>';
        } else {
            $l_Body = '';
        }
        
        $l_Result .= '<tr class="tbg' . ($i % 2) . '" o="' . $l_SigId . '">';
        
        if (is_file($g_Structure['n'][$l_Pos])) {
            $l_Result .= '<td><div class="it"><a class="it">' . makeSafeFn($g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$l_Pos])) . '</a></div>' . $l_Body . '</td>';
        } else {
            $l_Result .= '<td><div class="it"><a class="it">' . makeSafeFn($g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$par_List[$i]])) . '</a></div></td>';
        }
        
        $l_Result .= '<td align=center><div class="ctd">' . $l_Creat . '</div></td>';
        $l_Result .= '<td align=center><div class="ctd">' . $l_Modif . '</div></td>';
        $l_Result .= '<td align=center><div class="ctd">' . $l_Size . '</div></td>';
        $l_Result .= '<td class="hidd"><div class="hidd">' . $g_Structure['crc'][$l_Pos] . '</div></td>';
        $l_Result .= '<td class="hidd"><div class="hidd">' . 'x' . '</div></td>';
        $l_Result .= '<td class="hidd"><div class="hidd">' . $g_Structure['m'][$l_Pos] . '</div></td>';
        $l_Result .= '<td class="hidd"><div class="hidd">' . $l_SigId . '</div></td>';
        $l_Result .= '</tr>';
        
    }
    
    $l_Result .= "</tbody></table></div><div class=clear style=\"margin: 20px 0 0 0\"></div>";
    
    return $l_Result;
}

///////////////////////////////////////////////////////////////////////////
function printPlainList($par_List, $par_Details = null, $par_NeedIgnore = false, $par_SigId = null, $par_TableName = null) {
    global $g_Structure, $g_NoPrefix, $g_AddPrefix;
    
    $l_Result = "";
    
    $l_Src = array(
        '&quot;',
        '&lt;',
        '&gt;',
        '&amp;',
        '&#039;'
    );
    $l_Dst = array(
        '"',
        '<',
        '>',
        '&',
        '\''
    );
    
    for ($i = 0; $i < count($par_List); $i++) {
        $l_Pos = $par_List[$i];
        if ($par_NeedIgnore) {
            if (needIgnore($g_Structure['n'][$par_List[$i]], $g_Structure['crc'][$l_Pos])) {
                continue;
            }
        }
        
        
        if ($par_Details != null) {
            
            $l_Body = preg_replace('|(L\d+).+__AI_MARKER__|smi', '$1: ...', $par_Details[$i]);
            $l_Body = preg_replace('/[^\x20-\x7F]/', '.', $l_Body);
            $l_Body = str_replace($l_Src, $l_Dst, $l_Body);
            
        } else {
            $l_Body = '';
        }
        
        if (is_file($g_Structure['n'][$l_Pos])) {
            $l_Result .= $g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$l_Pos]) . "\t\t\t" . $l_Body . "\n";
        } else {
            $l_Result .= $g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$par_List[$i]]) . "\n";
        }
        
    }
    
    return $l_Result;
}

///////////////////////////////////////////////////////////////////////////
function extractValue(&$par_Str, $par_Name) {
    if (preg_match('|<tr><td class="e">\s*' . $par_Name . '\s*</td><td class="v">(.+?)</td>|sm', $par_Str, $l_Result)) {
        return str_replace('no value', '', strip_tags($l_Result[1]));
    }
}

///////////////////////////////////////////////////////////////////////////
function QCR_ExtractInfo($par_Str) {
    $l_PhpInfoSystem    = extractValue($par_Str, 'System');
    $l_PhpPHPAPI        = extractValue($par_Str, 'Server API');
    $l_AllowUrlFOpen    = extractValue($par_Str, 'allow_url_fopen');
    $l_AllowUrlInclude  = extractValue($par_Str, 'allow_url_include');
    $l_DisabledFunction = extractValue($par_Str, 'disable_functions');
    $l_DisplayErrors    = extractValue($par_Str, 'display_errors');
    $l_ErrorReporting   = extractValue($par_Str, 'error_reporting');
    $l_ExposePHP        = extractValue($par_Str, 'expose_php');
    $l_LogErrors        = extractValue($par_Str, 'log_errors');
    $l_MQGPC            = extractValue($par_Str, 'magic_quotes_gpc');
    $l_MQRT             = extractValue($par_Str, 'magic_quotes_runtime');
    $l_OpenBaseDir      = extractValue($par_Str, 'open_basedir');
    $l_RegisterGlobals  = extractValue($par_Str, 'register_globals');
    $l_SafeMode         = extractValue($par_Str, 'safe_mode');
        
    $l_DisabledFunction = ($l_DisabledFunction == '' ? '-?-' : $l_DisabledFunction);
    $l_OpenBaseDir      = ($l_OpenBaseDir == '' ? '-?-' : $l_OpenBaseDir);
    
    $l_Result = '<div class="title">' . AI_STR_008 . ': ' . phpversion() . '</div>';
    $l_Result .= 'System Version: <span class="php_ok">' . $l_PhpInfoSystem . '</span><br/>';
    $l_Result .= 'PHP API: <span class="php_ok">' . $l_PhpPHPAPI . '</span><br/>';
    $l_Result .= 'allow_url_fopen: <span class="php_' . ($l_AllowUrlFOpen == 'On' ? 'bad' : 'ok') . '">' . $l_AllowUrlFOpen . '</span><br/>';
    $l_Result .= 'allow_url_include: <span class="php_' . ($l_AllowUrlInclude == 'On' ? 'bad' : 'ok') . '">' . $l_AllowUrlInclude . '</span><br/>';
    $l_Result .= 'disable_functions: <span class="php_' . ($l_DisabledFunction == '-?-' ? 'bad' : 'ok') . '">' . $l_DisabledFunction . '</span><br/>';
    $l_Result .= 'display_errors: <span class="php_' . ($l_DisplayErrors == 'On' ? 'ok' : 'bad') . '">' . $l_DisplayErrors . '</span><br/>';
    $l_Result .= 'error_reporting: <span class="php_ok">' . $l_ErrorReporting . '</span><br/>';
    $l_Result .= 'expose_php: <span class="php_' . ($l_ExposePHP == 'On' ? 'bad' : 'ok') . '">' . $l_ExposePHP . '</span><br/>';
    $l_Result .= 'log_errors: <span class="php_' . ($l_LogErrors == 'On' ? 'ok' : 'bad') . '">' . $l_LogErrors . '</span><br/>';
    $l_Result .= 'magic_quotes_gpc: <span class="php_' . ($l_MQGPC == 'On' ? 'ok' : 'bad') . '">' . $l_MQGPC . '</span><br/>';
    $l_Result .= 'magic_quotes_runtime: <span class="php_' . ($l_MQRT == 'On' ? 'bad' : 'ok') . '">' . $l_MQRT . '</span><br/>';
    $l_Result .= 'register_globals: <span class="php_' . ($l_RegisterGlobals == 'On' ? 'bad' : 'ok') . '">' . $l_RegisterGlobals . '</span><br/>';
    $l_Result .= 'open_basedir: <span class="php_' . ($l_OpenBaseDir == '-?-' ? 'bad' : 'ok') . '">' . $l_OpenBaseDir . '</span><br/>';
    
    if (phpversion() < '5.3.0') {
        $l_Result .= 'safe_mode (PHP < 5.3.0): <span class="php_' . ($l_SafeMode == 'On' ? 'ok' : 'bad') . '">' . $l_SafeMode . '</span><br/>';
    }
    
    return $l_Result . '<p>';
}

///////////////////////////////////////////////////////////////////////////
function addSlash($dir) {
    return rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
}

///////////////////////////////////////////////////////////////////////////
function QCR_Debug($par_Str = "") {
    if (!DEBUG_MODE) {
        return;
    }
    
    $l_MemInfo = ' ';
    if (function_exists('memory_get_usage')) {
        $l_MemInfo .= ' curmem=' . bytes2Human(memory_get_usage());
    }
    
    if (function_exists('memory_get_peak_usage')) {
        $l_MemInfo .= ' maxmem=' . bytes2Human(memory_get_peak_usage());
    }
    
    stdOut("\n" . date('H:i:s') . ': ' . $par_Str . $l_MemInfo . "\n");
}


///////////////////////////////////////////////////////////////////////////
function QCR_ScanDirectories($l_RootDir) {
    global $g_Structure, $g_Counter, $g_Doorway, $g_FoundTotalFiles, $g_FoundTotalDirs, $defaults, $g_SkippedFolders, $g_UrlIgnoreList, $g_DirIgnoreList, $g_UnsafeDirArray, $g_UnsafeFilesFound, $g_SymLinks, $g_HiddenFiles, $g_UnixExec, $g_IgnoredExt, $g_SensitiveFiles, $g_SuspiciousFiles, $g_ShortListExt, $l_SkipSample;
    
    static $l_Buffer = '';
    
    $l_DirCounter          = 0;
    $l_DoorwayFilesCounter = 0;
    $l_SourceDirIndex      = $g_Counter - 1;
    
    $l_SkipSample = array();
    
    QCR_Debug('Scan ' . $l_RootDir);
    
    $l_QuotedSeparator = quotemeta(DIR_SEPARATOR);
    if ($l_DIRH = @opendir($l_RootDir)) {
        while (($l_FileName = readdir($l_DIRH)) !== false) {
            if ($l_FileName == '.' || $l_FileName == '..')
                continue;
            
            $l_FileName = $l_RootDir . DIR_SEPARATOR . $l_FileName;
            
            $l_Type = filetype($l_FileName);
            if ($l_Type == "link") {
                $g_SymLinks[] = $l_FileName;
                continue;
            } else if ($l_Type != "file" && $l_Type != "dir") {                
                continue;
            }
            
            $l_Ext   = strtolower(pathinfo($l_FileName, PATHINFO_EXTENSION));
            $l_IsDir = is_dir($l_FileName);
            
            if (in_array($l_Ext, $g_SuspiciousFiles)) {
            }
            
            // which files should be scanned
            $l_NeedToScan = SCAN_ALL_FILES || (in_array($l_Ext, $g_SensitiveFiles));
            
            if (in_array(strtolower($l_Ext), $g_IgnoredExt)) {
                $l_NeedToScan = false;
            }
            
            // if folder in ignore list
            $l_Skip = false;
            for ($dr = 0; $dr < count($g_DirIgnoreList); $dr++) {
                if (($g_DirIgnoreList[$dr] != '') && preg_match('#' . $g_DirIgnoreList[$dr] . '#', $l_FileName, $l_Found)) {
                    if (!in_array($g_DirIgnoreList[$dr], $l_SkipSample)) {
                        $l_SkipSample[] = $g_DirIgnoreList[$dr];
                    } else {
                        $l_Skip       = true;
                        $l_NeedToScan = false;
                    }
                }
            }
            
            
            if ($l_IsDir) {
                // skip on ignore
                if ($l_Skip) {
                    $g_SkippedFolders[] = $l_FileName;
                    continue;
                }
                
                $l_BaseName = basename($l_FileName);
                
                if (ONE_PASS) {
                    $g_Structure['n'][$g_Counter] = $l_FileName . DIR_SEPARATOR;
                } else {
                    $l_Buffer .= $l_FileName . DIR_SEPARATOR . "\n";
                }
                
                $l_DirCounter++;
                
                if ($l_DirCounter > MAX_ALLOWED_PHP_HTML_IN_DIR) {
                    $g_Doorway[]  = $l_SourceDirIndex;
                    $l_DirCounter = -655360;
                }
                
                $g_Counter++;
                $g_FoundTotalDirs++;
                
                QCR_ScanDirectories($l_FileName);
            } else {
                if ($l_NeedToScan) {
                    $g_FoundTotalFiles++;
                    if (in_array($l_Ext, $g_ShortListExt)) {
                        $l_DoorwayFilesCounter++;
                        
                        if ($l_DoorwayFilesCounter > MAX_ALLOWED_PHP_HTML_IN_DIR) {
                            $g_Doorway[]           = $l_SourceDirIndex;
                            $l_DoorwayFilesCounter = -655360;
                        }
                    }
                    
                    if (ONE_PASS) {
                        QCR_ScanFile($l_FileName, $g_Counter++);
                    } else {
                        $l_Buffer .= $l_FileName . "\n";
                    }
                    
                    $g_Counter++;
                }
            }
            
            if (strlen($l_Buffer) > 32000) {
                file_put_contents(QUEUE_FILENAME, $l_Buffer, FILE_APPEND) or die2("Cannot write to file " . QUEUE_FILENAME);
                $l_Buffer = '';
            }
            
        }
        
        closedir($l_DIRH);
    }
    
    if (($l_RootDir == ROOT_PATH) && !empty($l_Buffer)) {
        file_put_contents(QUEUE_FILENAME, $l_Buffer, FILE_APPEND) or die2("Cannot write to file " . QUEUE_FILENAME);
        $l_Buffer = '';
    }
    
}


///////////////////////////////////////////////////////////////////////////
function getFragment($par_Content, $par_Pos) {
//echo "\n *********** --------------------------------------------------------\n";

    $l_MaxChars = MAX_PREVIEW_LEN;

    $par_Content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '~', $par_Content);

    $l_MaxLen   = strlen($par_Content);
    $l_RightPos = min($par_Pos + $l_MaxChars, $l_MaxLen);
    $l_MinPos   = max(0, $par_Pos - $l_MaxChars);
    
    $l_FoundStart = substr($par_Content, 0, $par_Pos);
    $l_FoundStart = str_replace("\r", '', $l_FoundStart);
    $l_LineNo     = strlen($l_FoundStart) - strlen(str_replace("\n", '', $l_FoundStart)) + 1;

//echo "\nMinPos=" . $l_MinPos . " Pos=" . $par_Pos . " l_RightPos=" . $l_RightPos . "\n";
//var_dump($par_Content);
//echo "\n-----------------------------------------------------\n";

                                                                                                                                                      
    $l_Res = '__AI_LINE1__' . $l_LineNo . "__AI_LINE2__  " . ($l_MinPos > 0 ? '…' : '') . substr($par_Content, $l_MinPos, $par_Pos - $l_MinPos) . '__AI_MARKER__' . substr($par_Content, $par_Pos, $l_RightPos - $par_Pos - 1);
    
    $l_Res = makeSafeFn(UnwrapObfu($l_Res));

    $l_Res = str_replace('~', ' ', $l_Res);

    $l_Res = preg_replace('~[\s\t]+~', ' ', $l_Res);
      
    $l_Res = str_replace('' . '?php', '' . '?php ', $l_Res);
    
//echo "\nFinal:\n";
//var_dump($l_Res);
//echo "\n-----------------------------------------------------\n";
    return $l_Res;
}

///////////////////////////////////////////////////////////////////////////
function escapedHexToHex($escaped) {
    $GLOBALS['g_EncObfu']++;
    return chr(hexdec($escaped[1]));
}
function escapedOctDec($escaped) {
    $GLOBALS['g_EncObfu']++;
    return chr(octdec($escaped[1]));
}
function escapedDec($escaped) {
    $GLOBALS['g_EncObfu']++;
    return chr($escaped[1]);
}

///////////////////////////////////////////////////////////////////////////
if (!defined('T_ML_COMMENT')) {
    define('T_ML_COMMENT', T_COMMENT);
} else {
    define('T_DOC_COMMENT', T_ML_COMMENT);
}

function UnwrapObfu($par_Content) {
    $GLOBALS['g_EncObfu'] = 0;
    
    $search      = array(
        ' ;',
        ' =',
        ' ,',
        ' .',
        ' (',
        ' )',
        ' {',
        ' }',
        '; ',
        '= ',
        ', ',
        '. ',
        '( ',
        '( ',
        '{ ',
        '} ',
        ' !',
        ' >',
        ' <',
        ' _',
        '_ ',
        '< ',
        '> ',
        ' $',
        ' %',
        '% ',
        '# ',
        ' #',
        '^ ',
        ' ^',
        ' &',
        '& ',
        ' ?',
        '? '
    );
    $replace     = array(
        ';',
        '=',
        ',',
        '.',
        '(',
        ')',
        '{',
        '}',
        ';',
        '=',
        ',',
        '.',
        '(',
        ')',
        '{',
        '}',
        '!',
        '>',
        '<',
        '_',
        '_',
        '<',
        '>',
        '$',
        '%',
        '%',
        '#',
        '#',
        '^',
        '^',
        '&',
        '&',
        '?',
        '?'
    );
    $par_Content = str_replace('@', '', $par_Content);
    $par_Content = preg_replace('~\s+~smi', ' ', $par_Content);
    $par_Content = str_replace($search, $replace, $par_Content);
    $par_Content = preg_replace_callback('~\bchr\(\s*([0-9a-fA-FxX]+)\s*\)~', function($m) {
        return "'" . chr(intval($m[1], 0)) . "'";
    }, $par_Content);
    
    $par_Content = preg_replace_callback('/\\\\x([a-fA-F0-9]{1,2})/i', 'escapedHexToHex', $par_Content);
    $par_Content = preg_replace_callback('/\\\\([0-9]{1,3})/i', 'escapedOctDec', $par_Content);
    
    $par_Content = preg_replace('/[\'"]\s*?\.+\s*?[\'"]/smi', '', $par_Content);
    $par_Content = preg_replace('/[\'"]\s*?\++\s*?[\'"]/smi', '', $par_Content);
    
    $content = str_replace('<?$', '<?php$', $content);
    $content = str_replace('<?php', '<?php ', $content);
    
    return $par_Content;
}

///////////////////////////////////////////////////////////////////////////
// Unicode BOM is U+FEFF, but after encoded, it will look like this.
define('UTF32_BIG_ENDIAN_BOM', chr(0x00) . chr(0x00) . chr(0xFE) . chr(0xFF));
define('UTF32_LITTLE_ENDIAN_BOM', chr(0xFF) . chr(0xFE) . chr(0x00) . chr(0x00));
define('UTF16_BIG_ENDIAN_BOM', chr(0xFE) . chr(0xFF));
define('UTF16_LITTLE_ENDIAN_BOM', chr(0xFF) . chr(0xFE));
define('UTF8_BOM', chr(0xEF) . chr(0xBB) . chr(0xBF));

function detect_utf_encoding($text) {
    $first2 = substr($text, 0, 2);
    $first3 = substr($text, 0, 3);
    $first4 = substr($text, 0, 3);
    
    if ($first3 == UTF8_BOM)
        return 'UTF-8';
    elseif ($first4 == UTF32_BIG_ENDIAN_BOM)
        return 'UTF-32BE';
    elseif ($first4 == UTF32_LITTLE_ENDIAN_BOM)
        return 'UTF-32LE';
    elseif ($first2 == UTF16_BIG_ENDIAN_BOM)
        return 'UTF-16BE';
    elseif ($first2 == UTF16_LITTLE_ENDIAN_BOM)
        return 'UTF-16LE';
    
    return false;
}

///////////////////////////////////////////////////////////////////////////
function QCR_SearchPHP($src) {
    if (preg_match("/(<\?php[\w\s]{5,})/smi", $src, $l_Found, PREG_OFFSET_CAPTURE)) {
        return $l_Found[0][1];
    }
    
    if (preg_match("/(<script[^>]*language\s*=\s*)('|\"|)php('|\"|)([^>]*>)/i", $src, $l_Found, PREG_OFFSET_CAPTURE)) {
        return $l_Found[0][1];
    }
    
    return false;
}


///////////////////////////////////////////////////////////////////////////
function knowUrl($par_URL) {
    global $g_UrlIgnoreList;
    
    for ($jk = 0; $jk < count($g_UrlIgnoreList); $jk++) {
        if (stripos($par_URL, $g_UrlIgnoreList[$jk]) !== false) {
            return true;
        }
    }
    
    return false;
}

///////////////////////////////////////////////////////////////////////////

function makeSummary($par_Str, $par_Number, $par_Style) {
    return '<tr><td class="' . $par_Style . '" width=400>' . $par_Str . '</td><td class="' . $par_Style . '">' . $par_Number . '</td></tr>';
}

///////////////////////////////////////////////////////////////////////////

function CheckVulnerability($par_Filename, $par_Index, $par_Content) {
    global $g_Vulnerable, $g_CmsListDetector;
    
    
    $l_Vuln = array();
    
    $par_Filename = strtolower($par_Filename);
    
    if ((strpos($par_Filename, 'libraries/joomla/session/session.php') !== false) && (strpos($par_Content, '&& filter_var($_SERVER[\'HTTP_X_FORWARDED_FOR') === false)) {
        $l_Vuln['id']   = 'RCE : https://docs.joomla.org/Security_hotfixes_for_Joomla_EOL_versions';
        $l_Vuln['ndx']  = $par_Index;
        $g_Vulnerable[] = $l_Vuln;
        return true;
    }
    
    if ((strpos($par_Filename, 'administrator/components/com_media/helpers/media.php') !== false) && (strpos($par_Content, '$format == \'\' || $format == false ||') === false)) {
        if ($g_CmsListDetector->isCms(CMS_JOOMLA, '1.5')) {
            $l_Vuln['id']   = 'AFU : https://docs.joomla.org/Security_hotfixes_for_Joomla_EOL_versions';
            $l_Vuln['ndx']  = $par_Index;
            $g_Vulnerable[] = $l_Vuln;
            return true;
        }
        
        return false;
    }
    
    if ((strpos($par_Filename, 'joomla/filesystem/file.php') !== false) && (strpos($par_Content, '$file = rtrim($file, \'.\');') === false)) {
        if ($g_CmsListDetector->isCms(CMS_JOOMLA, '1.5')) {
            $l_Vuln['id']   = 'AFU : https://docs.joomla.org/Security_hotfixes_for_Joomla_EOL_versions';
            $l_Vuln['ndx']  = $par_Index;
            $g_Vulnerable[] = $l_Vuln;
            return true;
        }
        
        return false;
    }
    
    if ((strpos($par_Filename, 'editor/filemanager/upload/test.html') !== false) || (stripos($par_Filename, 'editor/filemanager/browser/default/connectors/php/') !== false) || (stripos($par_Filename, 'editor/filemanager/connectors/uploadtest.html') !== false) || (strpos($par_Filename, 'editor/filemanager/browser/default/connectors/test.html') !== false)) {
        $l_Vuln['id']   = 'AFU : FCKEDITOR : http://www.exploit-db.com/exploits/17644/ & /exploit/249';
        $l_Vuln['ndx']  = $par_Index;
        $g_Vulnerable[] = $l_Vuln;
        return true;
    }
    
    if ((strpos($par_Filename, 'inc_php/image_view.class.php') !== false) || (strpos($par_Filename, '/inc_php/framework/image_view.class.php') !== false)) {
        if (strpos($par_Content, 'showImageByID') === false) {
            $l_Vuln['id']   = 'AFU : REVSLIDER : http://www.exploit-db.com/exploits/35385/';
            $l_Vuln['ndx']  = $par_Index;
            $g_Vulnerable[] = $l_Vuln;
            return true;
        }
        
        return false;
    }
    
    if ((strpos($par_Filename, 'elfinder/php/connector.php') !== false) || (strpos($par_Filename, 'elfinder/elfinder.') !== false)) {
        $l_Vuln['id']   = 'AFU : elFinder';
        $l_Vuln['ndx']  = $par_Index;
        $g_Vulnerable[] = $l_Vuln;
        return true;
    }
    
    if (strpos($par_Filename, 'includes/database/database.inc') !== false) {
        if (strpos($par_Content, 'foreach ($data as $i => $value)') !== false) {
            $l_Vuln['id']   = 'SQLI : DRUPAL : CVE-2014-3704';
            $l_Vuln['ndx']  = $par_Index;
            $g_Vulnerable[] = $l_Vuln;
            return true;
        }
        
        return false;
    }
    
    if (strpos($par_Filename, 'engine/classes/min/index.php') !== false) {
        if (strpos($par_Content, 'tr_replace(chr(0)') === false) {
            $l_Vuln['id']   = 'AFD : MINIFY : CVE-2013-6619';
            $l_Vuln['ndx']  = $par_Index;
            $g_Vulnerable[] = $l_Vuln;
            return true;
        }
        
        return false;
    }
    
    if ((strpos($par_Filename, 'timthumb.php') !== false) || (strpos($par_Filename, 'thumb.php') !== false) || (strpos($par_Filename, 'cache.php') !== false) || (strpos($par_Filename, '_img.php') !== false)) {
        if (strpos($par_Content, 'code.google.com/p/timthumb') !== false && strpos($par_Content, '2.8.14') === false) {
            $l_Vuln['id']   = 'RCE : TIMTHUMB : CVE-2011-4106,CVE-2014-4663';
            $l_Vuln['ndx']  = $par_Index;
            $g_Vulnerable[] = $l_Vuln;
            return true;
        }
        
        return false;
    }
    
    if (strpos($par_Filename, 'components/com_rsform/helpers/rsform.php') !== false) {
        if (strpos($par_Content, 'eval($form->ScriptDisplay);') !== false) {
            $l_Vuln['id']   = 'RCE : RSFORM : rsform.php, LINE 1605';
            $l_Vuln['ndx']  = $par_Index;
            $g_Vulnerable[] = $l_Vuln;
            return true;
        }
        
        return false;
    }
    
    if (strpos($par_Filename, 'fancybox-for-wordpress/fancybox.php') !== false) {
        if (strpos($par_Content, '\'reset\' == $_REQUEST[\'action\']') !== false) {
            $l_Vuln['id']   = 'CODE INJECTION : FANCYBOX';
            $l_Vuln['ndx']  = $par_Index;
            $g_Vulnerable[] = $l_Vuln;
            return true;
        }
        
        return false;
    }
    
    
    if (strpos($par_Filename, 'cherry-plugin/admin/import-export/upload.php') !== false) {
        if (strpos($par_Content, 'verify nonce') === false) {
            $l_Vuln['id']   = 'AFU : Cherry Plugin';
            $l_Vuln['ndx']  = $par_Index;
            $g_Vulnerable[] = $l_Vuln;
            return true;
        }
        
        return false;
    }
    
    
    if (strpos($par_Filename, 'tiny_mce/plugins/tinybrowser/tinybrowser.php') !== false) {
        $l_Vuln['id']   = 'AFU : TINYMCE : http://www.exploit-db.com/exploits/9296/';
        $l_Vuln['ndx']  = $par_Index;
        $g_Vulnerable[] = $l_Vuln;
        
        return true;
    }
    
    if (strpos($par_Filename, '/bx_1c_import.php') !== false) {
        if (strpos($par_Content, '$_GET[\'action\']=="getfiles"') !== false) {
            $l_Vuln['id']   = 'AFD : https://habrahabr.ru/company/dsec/blog/326166/';
            $l_Vuln['ndx']  = $par_Index;
            $g_Vulnerable[] = $l_Vuln;
            
            return true;
        }
    }
    
    if (strpos($par_Filename, 'scripts/setup.php') !== false) {
        if (strpos($par_Content, 'PMA_Config') !== false) {
            $l_Vuln['id']   = 'CODE INJECTION : PHPMYADMIN : http://1337day.com/exploit/5334';
            $l_Vuln['ndx']  = $par_Index;
            $g_Vulnerable[] = $l_Vuln;
            return true;
        }
        
        return false;
    }
    
    if (strpos($par_Filename, '/uploadify.php') !== false) {
        if (strpos($par_Content, 'move_uploaded_file($tempFile,$targetFile') !== false) {
            $l_Vuln['id']   = 'AFU : UPLOADIFY : CVE: 2012-1153';
            $l_Vuln['ndx']  = $par_Index;
            $g_Vulnerable[] = $l_Vuln;
            return true;
        }
        
        return false;
    }
    
    if (strpos($par_Filename, 'com_adsmanager/controller.php') !== false) {
        if (strpos($par_Content, 'move_uploaded_file($file[\'tmp_name\'], $tempPath.\'/\'.basename($file[') !== false) {
            $l_Vuln['id']   = 'AFU : https://revisium.com/ru/blog/adsmanager_afu.html';
            $l_Vuln['ndx']  = $par_Index;
            $g_Vulnerable[] = $l_Vuln;
            return true;
        }
        
        return false;
    }
    
    if (strpos($par_Filename, 'wp-content/plugins/wp-mobile-detector/resize.php') !== false) {
        if (strpos($par_Content, 'file_put_contents($path, file_get_contents($_REQUEST[\'src\']));') !== false) {
            $l_Vuln['id']   = 'AFU : https://www.pluginvulnerabilities.com/2016/05/31/aribitrary-file-upload-vulnerability-in-wp-mobile-detector/';
            $l_Vuln['ndx']  = $par_Index;
            $g_Vulnerable[] = $l_Vuln;
            return true;
        }
        
        return false;
    }
    
    
    if (strpos($par_Filename, 'core/lib/drupal.php') !== false) {
        $version = '';
        if (preg_match('|VERSION\s*=\s*\'(8\.\d+\.\d+)\'|smi', $par_Content, $tmp_ver)) {
            $version = $tmp_ver[1];
        }
        
        if (($version !== '') && (version_compare($version, '8.5.1', '<'))) {
            $l_Vuln['id']   = 'Drupageddon 2 : SA-CORE-2018–002';
            $l_Vuln['ndx']  = $par_Index;
            $g_Vulnerable[] = $l_Vuln;
            return true;
        }
        
        
        return false;
    }
    
    if (strpos($par_Filename, 'changelog.txt') !== false) {
        $version = '';
        if (preg_match('|Drupal\s+(7\.\d+),|smi', $par_Content, $tmp_ver)) {
            $version = $tmp_ver[1];
        }
        
        if (($version !== '') && (version_compare($version, '7.58', '<'))) {
            $l_Vuln['id']   = 'Drupageddon 2 : SA-CORE-2018–002';
            $l_Vuln['ndx']  = $par_Index;
            $g_Vulnerable[] = $l_Vuln;
            return true;
        }
        
        return false;
    }
    
    if (strpos($par_Filename, 'phpmailer.php') !== false) {
        if (strpos($par_Content, 'PHPMailer') !== false) {
            $l_Found = preg_match('~Version:\s*(\d+)\.(\d+)\.(\d+)~', $par_Content, $l_Match);
            
            if ($l_Found) {
                $l_Version = $l_Match[1] * 1000 + $l_Match[2] * 100 + $l_Match[3];
                
                if ($l_Version < 2520) {
                    $l_Found = false;
                }
            }
            
            if (!$l_Found) {
                
                $l_Found = preg_match('~Version\s*=\s*\'(\d+)\.*(\d+)\.(\d+)~', $par_Content, $l_Match);
                if ($l_Found) {
                    $l_Version = $l_Match[1] * 1000 + $l_Match[2] * 100 + $l_Match[3];
                    if ($l_Version < 5220) {
                        $l_Found = false;
                    }
                }
            }
            
            
            if (!$l_Found) {
                $l_Vuln['id']   = 'RCE : CVE-2016-10045, CVE-2016-10031';
                $l_Vuln['ndx']  = $par_Index;
                $g_Vulnerable[] = $l_Vuln;
                return true;
            }
        }
        
        return false;
    }
    
    
    
    
}

///////////////////////////////////////////////////////////////////////////
function QCR_GoScan($par_Offset) {
    global $g_IframerFragment, $g_Iframer, $g_Redirect, $g_Doorway, $g_EmptyLink, $g_Structure, $g_Counter, $g_HeuristicType, $g_HeuristicDetected, $g_TotalFolder, $g_TotalFiles, $g_WarningPHP, $g_AdwareList, $g_CriticalPHP, $g_Phishing, $g_CriticalJS, $g_UrlIgnoreList, $g_CriticalJSFragment, $g_PHPCodeInside, $g_PHPCodeInsideFragment, $g_NotRead, $g_WarningPHPFragment, $g_WarningPHPSig, $g_BigFiles, $g_RedirectPHPFragment, $g_EmptyLinkSrc, $g_CriticalPHPSig, $g_CriticalPHPFragment, $g_Base64Fragment, $g_UnixExec, $g_PhishingSigFragment, $g_PhishingFragment, $g_PhishingSig, $g_CriticalJSSig, $g_IframerFragment, $g_CMS, $defaults, $g_AdwareListFragment, $g_KnownList, $g_Vulnerable;
    
    QCR_Debug('QCR_GoScan ' . $par_Offset);
    
    $i = 0;
    
    try {
        $s_file = new SplFileObject(QUEUE_FILENAME);
        $s_file->setFlags(SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
        
        foreach ($s_file as $l_Filename) {
            QCR_ScanFile($l_Filename, $i++);
        }
        
        unset($s_file);
    }
    catch (Exception $e) {
        QCR_Debug($e->getMessage());
    }
}

///////////////////////////////////////////////////////////////////////////
function QCR_ScanFile($l_Filename, $i = 0) {
    global $g_IframerFragment, $g_Iframer, $g_Redirect, $g_Doorway, $g_EmptyLink, $g_Structure, $g_Counter, $g_HeuristicType, $g_HeuristicDetected, $g_TotalFolder, $g_TotalFiles, $g_WarningPHP, $g_AdwareList, $g_CriticalPHP, $g_Phishing, $g_CriticalJS, $g_UrlIgnoreList, $g_CriticalJSFragment, $g_PHPCodeInside, $g_PHPCodeInsideFragment, $g_NotRead, $g_WarningPHPFragment, $g_WarningPHPSig, $g_BigFiles, $g_RedirectPHPFragment, $g_EmptyLinkSrc, $g_CriticalPHPSig, $g_CriticalPHPFragment, $g_Base64Fragment, $g_UnixExec, $g_PhishingSigFragment, $g_PhishingFragment, $g_PhishingSig, $g_CriticalJSSig, $g_IframerFragment, $g_CMS, $defaults, $g_AdwareListFragment, $g_KnownList, $g_Vulnerable, $g_CriticalFiles, $g_DeMapper;
    
    global $g_CRC;
    static $_files_and_ignored = 0;
    
    $l_CriticalDetected = false;
    $l_Stat             = stat($l_Filename);
    
    if (substr($l_Filename, -1) == DIR_SEPARATOR) {
        // FOLDER
        $g_Structure['n'][$i] = $l_Filename;
        $g_TotalFolder++;
        printProgress($_files_and_ignored, $l_Filename);
        return;
    }
    
    QCR_Debug('Scan file ' . $l_Filename);
    printProgress(++$_files_and_ignored, $l_Filename);
        
    // FILE
    if ((MAX_SIZE_TO_SCAN > 0 AND $l_Stat['size'] > MAX_SIZE_TO_SCAN) || ($l_Stat['size'] < 0)) {
        $g_BigFiles[] = $i;
        
        if (function_exists('aibolit_onBigFile')) {
            aibolit_onBigFile($l_Filename);
        }
        
        AddResult($l_Filename, $i);
        
        $l_Ext = strtolower(pathinfo($l_Filename, PATHINFO_EXTENSION));
        if ((!AI_HOSTER) && in_array($l_Ext, $g_CriticalFiles)) {
            $g_CriticalPHP[]         = $i;
            $g_CriticalPHPFragment[] = "BIG FILE. SKIPPED.";
            $g_CriticalPHPSig[]      = "big_1";
        }
    } else {
        $g_TotalFiles++;
        
        $l_TSStartScan = microtime(true);
        
        $l_Ext = strtolower(pathinfo($l_Filename, PATHINFO_EXTENSION));
        if (filetype($l_Filename) == 'file') {
            $l_Content   = @file_get_contents($l_Filename);
            $l_Unwrapped = @php_strip_whitespace($l_Filename);
        }
                
        if ((($l_Content == '') || ($l_Unwrapped == '')) && ($l_Stat['size'] > 0)) {
            $g_NotRead[] = $i;
            if (function_exists('aibolit_onReadError')) {
                aibolit_onReadError($l_Filename, 'io');
            }
            AddResult('[io] ' . $l_Filename, $i);
            return;
        }

        // ignore itself
        if (strpos($l_Content, 'ba6bfe55ec4d64bb8d42eb36d83ecf31') !== false) {
           return false;
        }
        
        // unix executables
        if (strpos($l_Content, chr(127) . 'ELF') !== false) {
            // todo: add crc check 
            return;
        }
        
        $g_CRC = _hash_($l_Unwrapped);
        
        $l_UnicodeContent = detect_utf_encoding($l_Content);
        //$l_Unwrapped = $l_Content;
        
        // check vulnerability in files
        $l_CriticalDetected = CheckVulnerability($l_Filename, $i, $l_Content);
        
        if ($l_UnicodeContent !== false) {
            if (function_exists('iconv')) {
                $l_Unwrapped = iconv($l_UnicodeContent, "CP1251//IGNORE", $l_Unwrapped);
            } else {
                $g_NotRead[] = $i;
                if (function_exists('aibolit_onReadError')) {
                    aibolit_onReadError($l_Filename, 'ec');
                }
                AddResult('[ec] ' . $l_Filename, $i);
            }
        }
        
        // critical
        $g_SkipNextCheck = false;
        
        $l_DeobfType = '';
        if ((!AI_HOSTER) || AI_DEOBFUSCATE) {
            $l_DeobfType = getObfuscateType($l_Unwrapped);
        }
        
        if ($l_DeobfType != '') {
            $l_Unwrapped     = deobfuscate($l_Unwrapped);
            $g_SkipNextCheck = checkFalsePositives($l_Filename, $l_Unwrapped, $l_DeobfType);
        } else {
            if (DEBUG_MODE) {
                stdOut("\n...... NOT OBFUSCATED\n");
            }
        }
        
        $l_Unwrapped = UnwrapObfu($l_Unwrapped);
        
        if ((!$g_SkipNextCheck) && CriticalPHP($l_Filename, $i, $l_Unwrapped, $l_Pos, $l_SigId)) {
            if ($l_Ext == 'js') {
                $g_CriticalJS[]         = $i;
                $g_CriticalJSFragment[] = getFragment($l_Unwrapped, $l_Pos);
                $g_CriticalJSSig[]      = $l_SigId;
            } else {
                $g_CriticalPHP[]         = $i;
                $g_CriticalPHPFragment[] = getFragment($l_Unwrapped, $l_Pos);
                $g_CriticalPHPSig[]      = $l_SigId;
            }
            
            $g_SkipNextCheck = true;
        } else {
            if ((!$g_SkipNextCheck) && CriticalPHP($l_Filename, $i, $l_Content, $l_Pos, $l_SigId)) {
                if ($l_Ext == 'js') {
                    $g_CriticalJS[]         = $i;
                    $g_CriticalJSFragment[] = getFragment($l_Content, $l_Pos);
                    $g_CriticalJSSig[]      = $l_SigId;
                } else {
                    $g_CriticalPHP[]         = $i;
                    $g_CriticalPHPFragment[] = getFragment($l_Content, $l_Pos);
                    $g_CriticalPHPSig[]      = $l_SigId;
                }
                
                $g_SkipNextCheck = true;
            }
        }
        
        $l_TypeDe = 0;
        
        // critical JS
        if (!$g_SkipNextCheck) {
            $l_Pos = CriticalJS($l_Filename, $i, $l_Unwrapped, $l_SigId);
            if ($l_Pos !== false) {
                if ($l_Ext == 'js') {
                    $g_CriticalJS[]         = $i;
                    $g_CriticalJSFragment[] = getFragment($l_Unwrapped, $l_Pos);
                    $g_CriticalJSSig[]      = $l_SigId;
                } else {
                    $g_CriticalPHP[]         = $i;
                    $g_CriticalPHPFragment[] = getFragment($l_Unwrapped, $l_Pos);
                    $g_CriticalPHPSig[]      = $l_SigId;
                }
                
                $g_SkipNextCheck = true;
            }
        }
        
        // phishing
        if (!$g_SkipNextCheck) {
            $l_Pos = Phishing($l_Filename, $i, $l_Unwrapped, $l_SigId);
            if ($l_Pos === false) {
                $l_Pos = Phishing($l_Filename, $i, $l_Content, $l_SigId);
            }
            
            if ($l_Pos !== false) {
                $g_Phishing[]            = $i;
                $g_PhishingFragment[]    = getFragment($l_Unwrapped, $l_Pos);
                $g_PhishingSigFragment[] = $l_SigId;
                $g_SkipNextCheck         = true;
            }
        }
        
        
        if (!$g_SkipNextCheck) {
            // warnings
            $l_Pos = '';
            
            // adware
            if (Adware($l_Filename, $l_Unwrapped, $l_Pos)) {
                $g_AdwareList[]         = $i;
                $g_AdwareListFragment[] = getFragment($l_Unwrapped, $l_Pos);
                $l_CriticalDetected     = true;
            }
            
            // articles
            if (stripos($l_Filename, 'article_index')) {
                $g_AdwareList[]     = $i;
                $l_CriticalDetected = true;
            }
        }
    } // end of if (!$g_SkipNextCheck) {
    
    unset($l_Unwrapped);
    unset($l_Content);
    
    //printProgress(++$_files_and_ignored, $l_Filename);
    
    $l_TSEndScan = microtime(true);
    if ($l_TSEndScan - $l_TSStartScan >= 0.5) {
        usleep(SCAN_DELAY * 1000);
    }
    
    if ($g_SkipNextCheck || $l_CriticalDetected) {
        AddResult($l_Filename, $i);
    }
}

function AddResult($l_Filename, $i) {
    global $g_Structure, $g_CRC;
    
    $l_Stat                 = stat($l_Filename);
    $g_Structure['n'][$i]   = $l_Filename;
    $g_Structure['s'][$i]   = $l_Stat['size'];
    $g_Structure['c'][$i]   = $l_Stat['ctime'];
    $g_Structure['m'][$i]   = $l_Stat['mtime'];
    $g_Structure['crc'][$i] = $g_CRC;
}

///////////////////////////////////////////////////////////////////////////
function WarningPHP($l_FN, $l_Content, &$l_Pos, &$l_SigId) {
    global $g_SusDB, $g_ExceptFlex, $gXX_FlexDBShe, $gX_FlexDBShe, $g_FlexDBShe, $gX_DBShe, $g_DBShe, $g_Base64, $g_Base64Fragment;
    
    $l_Res = false;
    
    if (AI_EXTRA_WARN) {
        foreach ($g_SusDB as $l_Item) {
            if (preg_match('#' . $l_Item . '#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
                if (!CheckException($l_Content, $l_Found)) {
                    $l_Pos   = $l_Found[0][1];
                    $l_SigId = getSigId($l_Found);
                    return true;
                }
            }
        }
    }
    
    if (AI_EXPERT < 2) {
        foreach ($gXX_FlexDBShe as $l_Item) {
            if (preg_match('#' . $l_Item . '#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
                $l_Pos   = $l_Found[0][1];
                $l_SigId = getSigId($l_Found);
                return true;
            }
        }
        
    }
    
    if (AI_EXPERT < 1) {
        foreach ($gX_FlexDBShe as $l_Item) {
            if (preg_match('#' . $l_Item . '#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
                $l_Pos   = $l_Found[0][1];
                $l_SigId = getSigId($l_Found);
                return true;
            }
        }
        
        $l_Content_lo = strtolower($l_Content);
        
        foreach ($gX_DBShe as $l_Item) {
            $l_Pos = strpos($l_Content_lo, $l_Item);
            if ($l_Pos !== false) {
                $l_SigId = myCheckSum($l_Item);
                return true;
            }
        }
    }
    
}

///////////////////////////////////////////////////////////////////////////
function Adware($l_FN, $l_Content, &$l_Pos) {
    global $g_AdwareSig;
    
    $l_Res = false;
    
    foreach ($g_AdwareSig as $l_Item) {
        $offset = 0;
        while (preg_match('#' . $l_Item . '#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE, $offset)) {
            if (!CheckException($l_Content, $l_Found)) {
                $l_Pos = $l_Found[0][1];
                return true;
            }
            
            $offset = $l_Found[0][1] + 1;
        }
    }
    
    return $l_Res;
}

///////////////////////////////////////////////////////////////////////////
function CheckException(&$l_Content, &$l_Found) {
    global $g_ExceptFlex, $gX_FlexDBShe, $gXX_FlexDBShe, $g_FlexDBShe, $gX_DBShe, $g_DBShe, $g_Base64, $g_Base64Fragment;
    $l_FoundStrPlus = substr($l_Content, max($l_Found[0][1] - 10, 0), 70);
    
    foreach ($g_ExceptFlex as $l_ExceptItem) {
        if (@preg_match('#' . $l_ExceptItem . '#smi', $l_FoundStrPlus, $l_Detected)) {
            return true;
        }
    }
    
    return false;
}

///////////////////////////////////////////////////////////////////////////
function Phishing($l_FN, $l_Index, $l_Content, &$l_SigId) {
    global $g_PhishingSig, $g_PhishFiles, $g_PhishEntries;
    
    $l_Res = false;
    
    // need check file (by extension) ?
    $l_SkipCheck = SMART_SCAN;
    
    if ($l_SkipCheck) {
        foreach ($g_PhishFiles as $l_Ext) {
            if (strpos($l_FN, $l_Ext) !== false) {
                $l_SkipCheck = false;
                break;
            }
        }
    }
    
    // need check file (by signatures) ?
    if ($l_SkipCheck && preg_match('~' . $g_PhishEntries . '~smiS', $l_Content, $l_Found)) {
        $l_SkipCheck = false;
    }
    
    if ($l_SkipCheck && SMART_SCAN) {
        if (DEBUG_MODE) {
            echo "Skipped phs file, not critical.\n";
        }
        
        return false;
    }
    
    
    foreach ($g_PhishingSig as $l_Item) {
        $offset = 0;
        while (preg_match('#' . $l_Item . '#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE, $offset)) {
            if (!CheckException($l_Content, $l_Found)) {
                $l_Pos   = $l_Found[0][1];
                $l_SigId = getSigId($l_Found);
                
                if (DEBUG_MODE) {
                    echo "Phis: $l_FN matched [$l_Item] in $l_Pos\n";
                }
                
                return $l_Pos;
            }
            $offset = $l_Found[0][1] + 1;
            
        }
    }
    
    return $l_Res;
}

///////////////////////////////////////////////////////////////////////////
function CriticalJS($l_FN, $l_Index, $l_Content, &$l_SigId) {
    global $g_JSVirSig, $gX_JSVirSig, $g_VirusFiles, $g_VirusEntries, $g_RegExpStat;
    
    $l_Res = false;
    
    // need check file (by extension) ?
    $l_SkipCheck = SMART_SCAN;
    
    if ($l_SkipCheck) {
        foreach ($g_VirusFiles as $l_Ext) {
            if (strpos($l_FN, $l_Ext) !== false) {
                $l_SkipCheck = false;
                break;
            }
        }
    }
    
    // need check file (by signatures) ?
    if ($l_SkipCheck && preg_match('~' . $g_VirusEntries . '~smiS', $l_Content, $l_Found)) {
        $l_SkipCheck = false;
    }
    
    if ($l_SkipCheck && SMART_SCAN) {
        if (DEBUG_MODE) {
            echo "Skipped js file, not critical.\n";
        }
        
        return false;
    }
    
    
    foreach ($g_JSVirSig as $l_Item) {
        $offset = 0;
        if (DEBUG_PERFORMANCE) {
            $stat_start = microtime(true);
        }
        
        while (preg_match('#' . $l_Item . '#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE, $offset)) {
            
            if (!CheckException($l_Content, $l_Found)) {
                $l_Pos   = $l_Found[0][1];
                $l_SigId = getSigId($l_Found);
                
                if (DEBUG_MODE) {
                    echo "JS: $l_FN matched [$l_Item] in $l_Pos\n";
                }
                
                return $l_Pos;
            }
            
            $offset = $l_Found[0][1] + 1;
            
        }
        
        if (DEBUG_PERFORMANCE) {
            $stat_stop = microtime(true);
            $g_RegExpStat[$l_Item] += $stat_stop - $stat_start;
        }
        
    }
    
    if (AI_EXPERT > 1) {
        foreach ($gX_JSVirSig as $l_Item) {
            if (DEBUG_PERFORMANCE) {
                $stat_start = microtime(true);
            }
            
            if (preg_match('#' . $l_Item . '#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
                if (!CheckException($l_Content, $l_Found)) {
                    $l_Pos   = $l_Found[0][1];
                    //$l_SigId = myCheckSum($l_Item);
                    $l_SigId = getSigId($l_Found);
                    
                    if (DEBUG_MODE) {
                        echo "JS PARA: $l_FN matched [$l_Item] in $l_Pos\n";
                    }
                    
                    return $l_Pos;
                }
            }
            
            if (DEBUG_PERFORMANCE) {
                $stat_stop = microtime(true);
                $g_RegExpStat[$l_Item] += $stat_stop - $stat_start;
            }
            
        }
    }
    
    return $l_Res;
}

////////////////////////////////////////////////////////////////////////////
function pcre_error($par_FN, $par_Index) {
    global $g_NotRead, $g_Structure;
    
    $err = preg_last_error();
    if (($err == PREG_BACKTRACK_LIMIT_ERROR) || ($err == PREG_RECURSION_LIMIT_ERROR)) {
        if (!in_array($par_Index, $g_NotRead)) {
            if (function_exists('aibolit_onReadError')) {
                aibolit_onReadError($l_Filename, 're');
            }
            $g_NotRead[] = $par_Index;
            AddResult('[re] ' . $par_FN, $par_Index);
        }
        
        return true;
    }
    
    return false;
}



////////////////////////////////////////////////////////////////////////////
define('SUSP_MTIME', 1); // suspicious mtime (greater than ctime)
define('SUSP_PERM', 2); // suspicious permissions 
define('SUSP_PHP_IN_UPLOAD', 3); // suspicious .php file in upload or image folder 

function get_descr_heur($type) {
    switch ($type) {
        case SUSP_MTIME:
            return AI_STR_077;
        case SUSP_PERM:
            return AI_STR_078;
        case SUSP_PHP_IN_UPLOAD:
            return AI_STR_079;
    }
    
    return "---";
}

///////////////////////////////////////////////////////////////////////////
function CriticalPHP($l_FN, $l_Index, $l_Content, &$l_Pos, &$l_SigId) {
    global $g_ExceptFlex, $gXX_FlexDBShe, $gX_FlexDBShe, $g_FlexDBShe, $gX_DBShe, $g_DBShe, $g_Base64, $g_Base64Fragment, $g_CriticalFiles, $g_CriticalEntries, $g_RegExpStat;
    
    // need check file (by extension) ?
    $l_SkipCheck = SMART_SCAN;
    
    if ($l_SkipCheck) {
        foreach ($g_CriticalFiles as $l_Ext) {
            if ((strpos($l_FN, $l_Ext) !== false) && (strpos($l_FN, '.js') === false)) {
                $l_SkipCheck = false;
                break;
            }
        }
    }
    
    // need check file (by signatures) ?
    if ($l_SkipCheck && preg_match('~' . $g_CriticalEntries . '~smiS', $l_Content, $l_Found)) {
        $l_SkipCheck = false;
    }
    
    
    // if not critical - skip it 
    if ($l_SkipCheck && SMART_SCAN) {
        if (DEBUG_MODE) {
            echo "Skipped file, not critical.\n";
        }
        
        return false;
    }
    
    foreach ($g_FlexDBShe as $l_Item) {
        $offset = 0;
        
        if (DEBUG_PERFORMANCE) {
            $stat_start = microtime(true);
        }
        
        while (preg_match('#' . $l_Item . '#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE, $offset)) {
            if (!CheckException($l_Content, $l_Found)) {
                $l_Pos   = $l_Found[0][1];
                //$l_SigId = myCheckSum($l_Item);
                $l_SigId = getSigId($l_Found);
                
                if (DEBUG_MODE) {
                    echo "CRIT 1: $l_FN matched [$l_Item] in $l_Pos\n";
                }
                
                return true;
            }
            
            $offset = $l_Found[0][1] + 1;
            
        }
        
        if (DEBUG_PERFORMANCE) {
            $stat_stop = microtime(true);
            $g_RegExpStat[$l_Item] += $stat_stop - $stat_start;
        }
        
    }
    
    if (AI_EXPERT > 0) {
        foreach ($gX_FlexDBShe as $l_Item) {
            if (DEBUG_PERFORMANCE) {
                $stat_start = microtime(true);
            }
            
            if (preg_match('#' . $l_Item . '#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
                if (!CheckException($l_Content, $l_Found)) {
                    $l_Pos   = $l_Found[0][1];
                    $l_SigId = getSigId($l_Found);
                    
                    if (DEBUG_MODE) {
                        echo "CRIT 3: $l_FN matched [$l_Item] in $l_Pos\n";
                    }
                    
                    return true;
                }
            }
            
            if (DEBUG_PERFORMANCE) {
                $stat_stop = microtime(true);
                $g_RegExpStat[$l_Item] += $stat_stop - $stat_start;
            }
            
        }
    }
    
    if (AI_EXPERT > 1) {
        foreach ($gXX_FlexDBShe as $l_Item) {
            if (DEBUG_PERFORMANCE) {
                $stat_start = microtime(true);
            }
            
            if (preg_match('#' . $l_Item . '#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
                if (!CheckException($l_Content, $l_Found)) {
                    $l_Pos   = $l_Found[0][1];
                    $l_SigId = getSigId($l_Found);
                    
                    if (DEBUG_MODE) {
                        echo "CRIT 2: $l_FN matched [$l_Item] in $l_Pos\n";
                    }
                    
                    return true;
                }
            }
            
            if (DEBUG_PERFORMANCE) {
                $stat_stop = microtime(true);
                $g_RegExpStat[$l_Item] += $stat_stop - $stat_start;
            }
            
        }
    }
    
    $l_Content_lo = strtolower($l_Content);
    
    foreach ($g_DBShe as $l_Item) {
        $l_Pos = strpos($l_Content_lo, $l_Item);
        if ($l_Pos !== false) {
            $l_SigId = myCheckSum($l_Item);
            
            if (DEBUG_MODE) {
                echo "CRIT 4: $l_FN matched [$l_Item] in $l_Pos\n";
            }
            
            return true;
        }
    }
    
    if (AI_EXPERT > 0) {
        foreach ($gX_DBShe as $l_Item) {
            $l_Pos = strpos($l_Content_lo, $l_Item);
            if ($l_Pos !== false) {
                $l_SigId = myCheckSum($l_Item);
                
                if (DEBUG_MODE) {
                    echo "CRIT 5: $l_FN matched [$l_Item] in $l_Pos\n";
                }
                
                return true;
            }
        }
    }
    
    if (AI_HOSTER)
        return false;
    
    if (AI_EXPERT > 0) {
        if ((strpos($l_Content, 'GIF89') === 0) && (strpos($l_FN, '.php') !== false)) {
            $l_Pos = 0;
            
            if (DEBUG_MODE) {
                echo "CRIT 6: $l_FN matched [$l_Item] in $l_Pos\n";
            }
            
            return true;
        }
    }
    
    // detect uploaders / droppers
    if (AI_EXPERT > 1) {
        $l_Found = null;
        if ((filesize($l_FN) < 2048) && (strpos($l_FN, '.ph') !== false) && ((($l_Pos = strpos($l_Content, 'multipart/form-data')) > 0) || (($l_Pos = strpos($l_Content, '$_FILE[') > 0)) || (($l_Pos = strpos($l_Content, 'move_uploaded_file')) > 0) || (preg_match('|\bcopy\s*\(|smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)))) {
            if ($l_Found != null) {
                $l_Pos = $l_Found[0][1];
            }
            if (DEBUG_MODE) {
                echo "CRIT 7: $l_FN matched [$l_Item] in $l_Pos\n";
            }
            
            return true;
        }
    }
    
    return false;
}

///////////////////////////////////////////////////////////////////////////
if (!isCli()) {
    header('Content-type: text/html; charset=utf-8');
}

if (!isCli()) {
    
    $l_PassOK = false;
    if (strlen(PASS) > 8) {
        $l_PassOK = true;
    }
    
    if ($l_PassOK && preg_match('|[0-9]|', PASS, $l_Found) && preg_match('|[A-Z]|', PASS, $l_Found) && preg_match('|[a-z]|', PASS, $l_Found)) {
        $l_PassOK = true;
    }
    
    if (!$l_PassOK) {
        echo sprintf(AI_STR_009, generatePassword());
        exit;
    }
    
    if (isset($_GET['fn']) && ($_GET['ph'] == crc32(PASS))) {
        printFile();
        exit;
    }
    
    if ($_GET['p'] != PASS) {
        $generated_pass = generatePassword();
        echo sprintf(AI_STR_010, $generated_pass, $generated_pass);
        exit;
    }
}

if (!is_readable(ROOT_PATH)) {
    echo AI_STR_011;
    exit;
}

if (isCli()) {
    if (defined('REPORT_PATH') AND REPORT_PATH) {
        if (!is_writable(REPORT_PATH)) {
            die2("\nCannot write report. Report dir " . REPORT_PATH . " is not writable.");
        }
        
        else if (!REPORT_FILE) {
            die2("\nCannot write report. Report filename is empty.");
        }
        
        else if (($file = REPORT_PATH . DIR_SEPARATOR . REPORT_FILE) AND is_file($file) AND !is_writable($file)) {
            die2("\nCannot write report. Report file '$file' exists but is not writable.");
        }
    }
}


// detect version CMS
$g_KnownCMS        = array();
$tmp_cms           = array();
$g_CmsListDetector = new CmsVersionDetector(ROOT_PATH);
$l_CmsDetectedNum  = $g_CmsListDetector->getCmsNumber();
for ($tt = 0; $tt < $l_CmsDetectedNum; $tt++) {
    $g_CMS[]                                                  = $g_CmsListDetector->getCmsName($tt) . ' v' . makeSafeFn($g_CmsListDetector->getCmsVersion($tt));
    $tmp_cms[strtolower($g_CmsListDetector->getCmsName($tt))] = 1;
}

if (count($tmp_cms) > 0) {
    $g_KnownCMS = array_keys($tmp_cms);
    $len        = count($g_KnownCMS);
    for ($i = 0; $i < $len; $i++) {
        if ($g_KnownCMS[$i] == strtolower(CMS_WORDPRESS))
            $g_KnownCMS[] = 'wp';
        if ($g_KnownCMS[$i] == strtolower(CMS_WEBASYST))
            $g_KnownCMS[] = 'shopscript';
        if ($g_KnownCMS[$i] == strtolower(CMS_IPB))
            $g_KnownCMS[] = 'ipb';
        if ($g_KnownCMS[$i] == strtolower(CMS_DLE))
            $g_KnownCMS[] = 'dle';
        if ($g_KnownCMS[$i] == strtolower(CMS_INSTANTCMS))
            $g_KnownCMS[] = 'instantcms';
        if ($g_KnownCMS[$i] == strtolower(CMS_SHOPSCRIPT))
            $g_KnownCMS[] = 'shopscript';
        if ($g_KnownCMS[$i] == strtolower(CMS_DRUPAL))
            $g_KnownCMS[] = 'drupal';
    }
}


$g_DirIgnoreList = array();
$g_IgnoreList    = array();
$g_UrlIgnoreList = array();
$g_KnownList     = array();

$l_IgnoreFilename    = $g_AiBolitAbsolutePath . '/.aignore';
$l_DirIgnoreFilename = $g_AiBolitAbsolutePath . '/.adirignore';
$l_UrlIgnoreFilename = $g_AiBolitAbsolutePath . '/.aurlignore';

if (file_exists($l_IgnoreFilename)) {
    $l_IgnoreListRaw = file($l_IgnoreFilename);
    for ($i = 0; $i < count($l_IgnoreListRaw); $i++) {
        $g_IgnoreList[] = explode("\t", trim($l_IgnoreListRaw[$i]));
    }
    unset($l_IgnoreListRaw);
}

if (file_exists($l_DirIgnoreFilename)) {
    $g_DirIgnoreList = file($l_DirIgnoreFilename);
    
    for ($i = 0; $i < count($g_DirIgnoreList); $i++) {
        $g_DirIgnoreList[$i] = trim($g_DirIgnoreList[$i]);
    }
}

if (file_exists($l_UrlIgnoreFilename)) {
    $g_UrlIgnoreList = file($l_UrlIgnoreFilename);
    
    for ($i = 0; $i < count($g_UrlIgnoreList); $i++) {
        $g_UrlIgnoreList[$i] = trim($g_UrlIgnoreList[$i]);
    }
}


$l_SkipMask = array(
    '/template_\w{32}.css',
    '/cache/templates/.{1,150}\.tpl\.php',
    '/system/cache/templates_c/\w{1,40}\.php',
    '/assets/cache/rss/\w{1,60}',
    '/cache/minify/minify_\w{32}',
    '/cache/page/\w{32}\.php',
    '/cache/object/\w{1,10}/\w{1,10}/\w{1,10}/\w{32}\.php',
    '/cache/wp-cache-\d{32}\.php',
    '/cache/page/\w{32}\.php_expire',
    '/cache/page/\w{32}-cache-page-\w{32}\.php',
    '\w{32}-cache-com_content-\w{32}\.php',
    '\w{32}-cache-mod_custom-\w{32}\.php',
    '\w{32}-cache-mod_templates-\w{32}\.php',
    '\w{32}-cache-_system-\w{32}\.php',
    '/cache/twig/\w{1,32}/\d+/\w{1,100}\.php',
    '/autoptimize/js/autoptimize_\w{32}\.js',
    '/bitrix/cache/\w{32}\.php',
    '/bitrix/cache/.{1,200}/\w{32}\.php',
    '/bitrix/cache/iblock_find/',
    '/bitrix/managed_cache/MYSQL/user_option/[^/]+/',
    '/bitrix/cache/s1/bitrix/catalog\.section/',
    '/bitrix/cache/s1/bitrix/catalog\.element/',
    '/bitrix/cache/s1/bitrix/menu/',
    '/catalog.element/[^/]+/[^/]+/\w{32}\.php',
    '/bitrix/managed\_cache/.{1,150}/\.\w{32}\.php',
    '/core/cache/mgr/smarty/default/.{1,100}\.tpl\.php',
    '/core/cache/resource/web/resources/[0-9]{1,50}\.cache\.php',
    '/smarty/compiled/SC/.{1,100}/%%.{1,200}\.php',
    '/smarty/.{1,150}\.tpl\.php',
    '/smarty/compile/.{1,150}\.tpl\.cache\.php',
    '/files/templates_c/.{1,150}\.html\.php',
    '/uploads/javascript_global/.{1,150}\.js',
    '/assets/cache/rss/\w{32}',
    'сore/cache/resource/web/resources/\d+\.cache\.php',
    '/assets/cache/docid_\d+_\w{32}\.pageCache\.php',
    '/t3-assets/dev/t3/.{1,150}-cache-\w{1,20}-.{1,150}\.php',
    '/t3-assets/js/js-\w{1,30}\.js',
    '/temp/cache/SC/.{1,100}/\.cache\..{1,100}\.php',
    '/tmp/sess\_\w{32}$',
    '/assets/cache/docid\_.{1,100}\.pageCache\.php',
    '/stat/usage\_\w{1,100}\.html',
    '/stat/site\_\w{1,100}\.html',
    '/gallery/item/list/\w{1,100}\.cache\.php',
    '/core/cache/registry/.{1,100}/ext-.{1,100}\.php',
    '/core/cache/resource/shk\_/\w{1,50}\.cache\.php',
    '/cache/\w{1,40}/\w+-cache-\w+-\w{32,40}\.php',
    '/webstat/awstats.{1,150}\.txt',
    '/awstats/awstats.{1,150}\.txt',
    '/awstats/.{1,80}\.pl',
    '/awstats/.{1,80}\.html',
    '/inc/min/styles_\w+\.min\.css',
    '/inc/min/styles_\w+\.min\.js',
    '/logs/error\_log\.',
    '/logs/xferlog\.',
    '/logs/access_log\.',
    '/logs/cron\.',
    '/logs/exceptions/.{1,200}\.log$',
    '/hyper-cache/[^/]{1,50}/[^/]{1,50}/[^/]{1,50}/index\.html',
    '/mail/new/[^,]+,S=[^,]+,W=',
    '/mail/new/[^,]=,S=',
    '/application/logs/\d+/\d+/\d+\.php',
    '/sites/default/files/js/js_\w{32}\.js',
    '/yt-assets/\w{32}\.css',
    '/wp-content/cache/object/\w{1,5}/\w{1,5}/\w{32}\.php',
    '/catalog\.section/\w{1,5}/\w{1,5}/\w{32}\.php',
    '/simpla/design/compiled/[\w\.]{40,60}\.php',
    '/compile/\w{2}/\w{2}/\w{2}/[\w.]{40,80}\.php',
    '/sys-temp/static-cache/[^/]{1,60}/userCache/[\w\./]{40,100}\.php',
    '/session/sess_\w{32}',
    '/webstat/awstats\.[\w\./]{3,100}\.html',
    '/stat/webalizer\.current',
    '/stat/usage_\d+\.html'
);

$l_SkipSample = array();

if (SMART_SCAN) {
    $g_DirIgnoreList = array_merge($g_DirIgnoreList, $l_SkipMask);
}

QCR_Debug();

// Load custom signatures
if (file_exists($g_AiBolitAbsolutePath . "/ai-bolit.sig")) {
   try {
       $s_file = new SplFileObject($g_AiBolitAbsolutePath . "/ai-bolit.sig");
       $s_file->setFlags(SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
       foreach ($s_file as $line) {
           $g_FlexDBShe[] = preg_replace('~\G(?:[^#\\\\]+|\\\\.)*+\K#~', '\\#', $line); // escaping #
       }

       stdOut("Loaded " . $s_file->key() . " signatures from ai-bolit.sig");
       $s_file = null; // file handler is closed
   }
   catch (Exception $e) {
       QCR_Debug("Import ai-bolit.sig " . $e->getMessage());
   }
}

QCR_Debug();

$defaults['skip_ext'] = strtolower(trim($defaults['skip_ext']));
if ($defaults['skip_ext'] != '') {
    $g_IgnoredExt = explode(',', $defaults['skip_ext']);
    for ($i = 0; $i < count($g_IgnoredExt); $i++) {
        $g_IgnoredExt[$i] = trim($g_IgnoredExt[$i]);
    }
    
    QCR_Debug('Skip files with extensions: ' . implode(',', $g_IgnoredExt));
    stdOut('Skip extensions: ' . implode(',', $g_IgnoredExt));
}

// scan single file
if (defined('SCAN_FILE')) {
    if (file_exists(SCAN_FILE) && is_file(SCAN_FILE) && is_readable(SCAN_FILE)) {
        stdOut("Start scanning file '" . SCAN_FILE . "'.");
        QCR_ScanFile(SCAN_FILE);
    } else {
        stdOut("Error:" . SCAN_FILE . " either is not a file or readable");
    }
} else {
    if (isset($_GET['2check'])) {
        $options['with-2check'] = 1;
    }
    
    $use_doublecheck = isset($options['with-2check']) && file_exists(DOUBLECHECK_FILE);
    $use_listingfile = defined('LISTING_FILE');
    
    // scan list of files from file
    if (!(ICHECK || IMAKE) && ($use_doublecheck || $use_listingfile)) {
        if ($use_doublecheck) {
            $listing = DOUBLECHECK_FILE;
        } else {
            if ($use_listingfile) {
                $listing = LISTING_FILE;
            }
        }
        
        stdOut("Start scanning the list from '" . $listing . "'.\n");

        if ($listing == 'stdin') {
           $lines = explode("\n", getStdin());
        } else {
           $lines = file($listing);
        }

        for ($i = 0, $size = count($lines); $i < $size; $i++) {
            $lines[$i] = trim($lines[$i]);
            if (empty($lines[$i]))
                unset($lines[$i]);
        }
        
        $i = 0;
        if ($use_doublecheck) {
            /* skip first line with <?php die("Forbidden"); ?> */
            unset($lines[0]);
            $i = 1;
        }
        
        $g_FoundTotalFiles = count($lines);
        foreach ($lines as $l_FN) {
            is_dir($l_FN) && $g_TotalFolder++;
            printProgress($i++, $l_FN);
            $BOOL_RESULT = true; // display disable
            is_file($l_FN) && QCR_ScanFile($l_FN, $i);
            $BOOL_RESULT = false; // display enable
        }
        
        $g_FoundTotalDirs  = $g_TotalFolder;
        $g_FoundTotalFiles = $g_TotalFiles;
        
    } else {
        // scan whole file system
        stdOut("Start scanning '" . ROOT_PATH . "'.\n");
        
        file_exists(QUEUE_FILENAME) && unlink(QUEUE_FILENAME);
        if (ICHECK || IMAKE) {
            // INTEGRITY CHECK
            IMAKE and unlink(INTEGRITY_DB_FILE);
            ICHECK and load_integrity_db();
            QCR_IntegrityCheck(ROOT_PATH);
            stdOut("Found $g_FoundTotalFiles files in $g_FoundTotalDirs directories.");
            if (IMAKE)
                exit(0);
            if (ICHECK) {
                $i       = $g_Counter;
                $g_CRC   = 0;
                $changes = array();
                $ref =& $g_IntegrityDB;
                foreach ($g_IntegrityDB as $l_FileName => $type) {
                    unset($g_IntegrityDB[$l_FileName]);
                    $l_Ext2 = substr(strstr(basename($l_FileName), '.'), 1);
                    if (in_array(strtolower($l_Ext2), $g_IgnoredExt)) {
                        continue;
                    }
                    for ($dr = 0; $dr < count($g_DirIgnoreList); $dr++) {
                        if (($g_DirIgnoreList[$dr] != '') && preg_match('#' . $g_DirIgnoreList[$dr] . '#', $l_FileName, $l_Found)) {
                            continue 2;
                        }
                    }
                    $type = in_array($type, array(
                        'added',
                        'modified'
                    )) ? $type : 'deleted';
                    $type .= substr($l_FileName, -1) == '/' ? 'Dirs' : 'Files';
                    $changes[$type][] = ++$i;
                    AddResult($l_FileName, $i);
                }
                $g_FoundTotalFiles = count($changes['addedFiles']) + count($changes['modifiedFiles']);
                stdOut("Found changes " . count($changes['modifiedFiles']) . " files and added " . count($changes['addedFiles']) . " files.");
            }
            
        } else {
            QCR_ScanDirectories(ROOT_PATH);
            stdOut("Found $g_FoundTotalFiles files in $g_FoundTotalDirs directories.");
        }
        
        QCR_Debug();
        stdOut(str_repeat(' ', 160), false);
        QCR_GoScan(0);
        unlink(QUEUE_FILENAME);
        if (defined('PROGRESS_LOG_FILE') && file_exists(PROGRESS_LOG_FILE))
            @unlink(PROGRESS_LOG_FILE);
    }
}

QCR_Debug();

if (true) {
    $g_HeuristicDetected = array();
    $g_Iframer           = array();
    $g_Base64            = array();
}


// whitelist

$snum = 0;
$list = check_whitelist($g_Structure['crc'], $snum);

foreach (array(
    'g_CriticalPHP',
    'g_CriticalJS',
    'g_Iframer',
    'g_Base64',
    'g_Phishing',
    'g_AdwareList',
    'g_Redirect'
) as $p) {
    if (empty($$p))
        continue;
    
    $p_Fragment = $p . "Fragment";
    $p_Sig      = $p . "Sig";
    if ($p == 'g_Redirect')
        $p_Fragment = $p . "PHPFragment";
    if ($p == 'g_Phishing')
        $p_Sig = $p . "SigFragment";
    
    $count = count($$p);
    for ($i = 0; $i < $count; $i++) {
        $id = "{${$p}[$i]}";
        if (in_array($g_Structure['crc'][$id], $list)) {
            unset($GLOBALS[$p][$i]);
            unset($GLOBALS[$p_Sig][$i]);
            unset($GLOBALS[$p_Fragment][$i]);
        }
    }
    
    $$p          = array_values($$p);
    $$p_Fragment = array_values($$p_Fragment);
    if (!empty($$p_Sig))
        $$p_Sig = array_values($$p_Sig);
}


////////////////////////////////////////////////////////////////////////////
if (AI_HOSTER) {
    $g_IframerFragment       = array();
    $g_Iframer               = array();
    $g_Redirect              = array();
    $g_Doorway               = array();
    $g_EmptyLink             = array();
    $g_HeuristicType         = array();
    $g_HeuristicDetected     = array();
    $g_WarningPHP            = array();
    $g_AdwareList            = array();
    $g_Phishing              = array();
    $g_PHPCodeInside         = array();
    $g_PHPCodeInsideFragment = array();
    $g_WarningPHPFragment    = array();
    $g_WarningPHPSig         = array();
    $g_BigFiles              = array();
    $g_RedirectPHPFragment   = array();
    $g_EmptyLinkSrc          = array();
    $g_Base64Fragment        = array();
    $g_UnixExec              = array();
    $g_PhishingSigFragment   = array();
    $g_PhishingFragment      = array();
    $g_PhishingSig           = array();
    $g_IframerFragment       = array();
    $g_CMS                   = array();
    $g_AdwareListFragment    = array();
}

if (BOOL_RESULT && (!defined('NEED_REPORT'))) {
    if ((count($g_CriticalPHP) > 0) OR (count($g_CriticalJS) > 0) OR (count($g_PhishingSig) > 0)) {
        exit(2);
    } else {
        exit(0);
    }
}
////////////////////////////////////////////////////////////////////////////
$l_Template = str_replace("@@SERVICE_INFO@@", htmlspecialchars("[" . $int_enc . "][" . $snum . "]"), $l_Template);

$l_Template = str_replace("@@PATH_URL@@", (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $g_AddPrefix . str_replace($g_NoPrefix, '', addSlash(ROOT_PATH))), $l_Template);

$time_taken = seconds2Human(microtime(true) - START_TIME);

$l_Template = str_replace("@@SCANNED@@", sprintf(AI_STR_013, $g_TotalFolder, $g_TotalFiles), $l_Template);

$l_ShowOffer = false;

stdOut("\nBuilding report [ mode = " . AI_EXPERT . " ]\n");

//stdOut("\nLoaded signatures: " . count($g_FlexDBShe) . " / " . count($g_JSVirSig) . "\n");

////////////////////////////////////////////////////////////////////////////
// save 
if (!(ICHECK || IMAKE))
    if (isset($options['with-2check']) || isset($options['quarantine']))
        if ((count($g_CriticalPHP) > 0) OR (count($g_CriticalJS) > 0) OR (count($g_Base64) > 0) OR (count($g_Iframer) > 0) OR (count($g_UnixExec))) {
            if (!file_exists(DOUBLECHECK_FILE)) {
                if ($l_FH = fopen(DOUBLECHECK_FILE, 'w')) {
                    fputs($l_FH, '<?php die("Forbidden"); ?>' . "\n");
                    
                    $l_CurrPath = dirname(__FILE__);
                    
                    if (!isset($g_CriticalPHP)) {
                        $g_CriticalPHP = array();
                    }
                    if (!isset($g_CriticalJS)) {
                        $g_CriticalJS = array();
                    }
                    if (!isset($g_Iframer)) {
                        $g_Iframer = array();
                    }
                    if (!isset($g_Base64)) {
                        $g_Base64 = array();
                    }
                    if (!isset($g_Phishing)) {
                        $g_Phishing = array();
                    }
                    if (!isset($g_AdwareList)) {
                        $g_AdwareList = array();
                    }
                    if (!isset($g_Redirect)) {
                        $g_Redirect = array();
                    }
                    
                    $tmpIndex = array_merge($g_CriticalPHP, $g_CriticalJS, $g_Phishing, $g_Base64, $g_Iframer, $g_AdwareList, $g_Redirect);
                    $tmpIndex = array_values(array_unique($tmpIndex));
                    
                    for ($i = 0; $i < count($tmpIndex); $i++) {
                        $tmpIndex[$i] = str_replace($l_CurrPath, '.', $g_Structure['n'][$tmpIndex[$i]]);
                    }
                    
                    for ($i = 0; $i < count($g_UnixExec); $i++) {
                        $tmpIndex[] = str_replace($l_CurrPath, '.', $g_UnixExec[$i]);
                    }
                    
                    $tmpIndex = array_values(array_unique($tmpIndex));
                    
                    for ($i = 0; $i < count($tmpIndex); $i++) {
                        fputs($l_FH, $tmpIndex[$i] . "\n");
                    }
                    
                    fclose($l_FH);
                } else {
                    stdOut("Error! Cannot create " . DOUBLECHECK_FILE);
                }
            } else {
                stdOut(DOUBLECHECK_FILE . ' already exists.');
                if (AI_STR_044 != '')
                    $l_Result .= '<div class="rep">' . AI_STR_044 . '</div>';
            }
            
        }

////////////////////////////////////////////////////////////////////////////

$l_Summary = '<div class="title">' . AI_STR_074 . '</div>';
$l_Summary .= '<table cellspacing=0 border=0>';

if (count($g_Redirect) > 0) {
    $l_Summary .= makeSummary(AI_STR_059, count($g_Redirect), "crit");
}

if (count($g_CriticalPHP) > 0) {
    $l_Summary .= makeSummary(AI_STR_060, count($g_CriticalPHP), "crit");
}

if (count($g_CriticalJS) > 0) {
    $l_Summary .= makeSummary(AI_STR_061, count($g_CriticalJS), "crit");
}

if (count($g_Phishing) > 0) {
    $l_Summary .= makeSummary(AI_STR_062, count($g_Phishing), "crit");
}

if (count($g_NotRead) > 0) {
    $l_Summary .= makeSummary(AI_STR_066, count($g_NotRead), "crit");
}

if (count($g_BigFiles) > 0) {
    $l_Summary .= makeSummary(AI_STR_065, count($g_BigFiles), "warn");
}

if (count($g_SymLinks) > 0) {
    $l_Summary .= makeSummary(AI_STR_069, count($g_SymLinks), "warn");
}

$l_Summary .= "</table>";

$l_ArraySummary                      = array();
$l_ArraySummary["redirect"]          = count($g_Redirect);
$l_ArraySummary["critical_php"]      = count($g_CriticalPHP);
$l_ArraySummary["critical_js"]       = count($g_CriticalJS);
$l_ArraySummary["phishing"]          = count($g_Phishing);
$l_ArraySummary["unix_exec"]         = 0; // count($g_UnixExec);
$l_ArraySummary["iframes"]           = 0; // count($g_Iframer);
$l_ArraySummary["not_read"]          = count($g_NotRead);
$l_ArraySummary["base64"]            = 0; // count($g_Base64);
$l_ArraySummary["heuristics"]        = 0; // count($g_HeuristicDetected);
$l_ArraySummary["symlinks"]          = count($g_SymLinks);
$l_ArraySummary["big_files_skipped"] = count($g_BigFiles);

if (function_exists('json_encode')) {
    $l_Summary .= "<!--[json]" . json_encode($l_ArraySummary) . "[/json]-->";
}

$l_Summary .= "<div class=details style=\"margin: 20px 20px 20px 0\">" . AI_STR_080 . "</div>\n";

$l_Template = str_replace("@@SUMMARY@@", $l_Summary, $l_Template);

$l_Result .= AI_STR_015;

$l_Template = str_replace("@@VERSION@@", AI_VERSION, $l_Template);

////////////////////////////////////////////////////////////////////////////



if (function_exists("gethostname") && is_callable("gethostname")) {
    $l_HostName = gethostname();
} else {
    $l_HostName = '???';
}

$l_PlainResult = "# Malware list detected by AI-Bolit (https://revisium.com/ai/) on " . date("d/m/Y H:i:s", time()) . " " . $l_HostName . "\n\n";

$l_RawReport = array();

$l_RawReport['summary'] = array(
    'scan_path' => $defaults['path'],
    'report_time' => time(),
    'scan_time' => round(microtime(true) - START_TIME, 1),
    'total_files' => $g_FoundTotalFiles,
    'counters' => $l_ArraySummary,
    'ai_version' => AI_VERSION
);

if (!AI_HOSTER) {
    stdOut("Building list of vulnerable scripts " . count($g_Vulnerable));
    
    if (count($g_Vulnerable) > 0) {
        $l_Result .= '<div class="note_vir">' . AI_STR_081 . ' (' . count($g_Vulnerable) . ')</div><div class="crit">';
        foreach ($g_Vulnerable as $l_Item) {
            $l_Result .= '<li>' . makeSafeFn($g_Structure['n'][$l_Item['ndx']], true) . ' - ' . $l_Item['id'] . '</li>';
            $l_PlainResult .= '[VULNERABILITY] ' . replacePathArray($g_Structure['n'][$l_Item['ndx']]) . ' - ' . $l_Item['id'] . "\n";
        }
        
        $l_Result .= '</div><p>' . PHP_EOL;
        $l_PlainResult .= "\n";
    }
}


stdOut("Building list of shells " . count($g_CriticalPHP));

$l_RawReport['vulners'] = getRawJsonVuln($g_Vulnerable);

if (count($g_CriticalPHP) > 0) {
    $g_CriticalPHP              = array_slice($g_CriticalPHP, 0, 15000);
    $l_RawReport['php_malware'] = getRawJson($g_CriticalPHP, $g_CriticalPHPFragment, $g_CriticalPHPSig);
    $l_Result .= '<div class="note_vir">' . AI_STR_016 . ' (' . count($g_CriticalPHP) . ')</div><div class="crit">';
    $l_Result .= printList($g_CriticalPHP, $g_CriticalPHPFragment, true, $g_CriticalPHPSig, 'table_crit');
    $l_PlainResult .= '[SERVER MALWARE]' . "\n" . printPlainList($g_CriticalPHP, $g_CriticalPHPFragment, true, $g_CriticalPHPSig, 'table_crit') . "\n";
    $l_Result .= '</div>' . PHP_EOL;
    
    $l_ShowOffer = true;
} else {
    $l_Result .= '<div class="ok"><b>' . AI_STR_017 . '</b></div>';
}

stdOut("Building list of js " . count($g_CriticalJS));

if (count($g_CriticalJS) > 0) {
    $g_CriticalJS              = array_slice($g_CriticalJS, 0, 15000);
    $l_RawReport['js_malware'] = getRawJson($g_CriticalJS, $g_CriticalJSFragment, $g_CriticalJSSig);
    $l_Result .= '<div class="note_vir">' . AI_STR_018 . ' (' . count($g_CriticalJS) . ')</div><div class="crit">';
    $l_Result .= printList($g_CriticalJS, $g_CriticalJSFragment, true, $g_CriticalJSSig, 'table_vir');
    $l_PlainResult .= '[CLIENT MALWARE / JS]' . "\n" . printPlainList($g_CriticalJS, $g_CriticalJSFragment, true, $g_CriticalJSSig, 'table_vir') . "\n";
    $l_Result .= "</div>" . PHP_EOL;
    
    $l_ShowOffer = true;
}

stdOut("Building list of unread files " . count($g_NotRead));

if (count($g_NotRead) > 0) {
    $g_NotRead               = array_slice($g_NotRead, 0, AIBOLIT_MAX_NUMBER);
    $l_RawReport['not_read'] = $g_NotRead;
    $l_Result .= '<div class="note_vir">' . AI_STR_030 . ' (' . count($g_NotRead) . ')</div><div class="crit">';
    $l_Result .= printList($g_NotRead);
    $l_Result .= "</div><div class=\"spacer\"></div>" . PHP_EOL;
    $l_PlainResult .= '[SCAN ERROR / SKIPPED]' . "\n" . printPlainList($g_NotRead) . "\n\n";
}

if (!AI_HOSTER) {
    stdOut("Building list of phishing pages " . count($g_Phishing));
    
    if (count($g_Phishing) > 0) {
        $l_RawReport['phishing'] = getRawJson($g_Phishing, $g_PhishingFragment, $g_PhishingSigFragment);
        $l_Result .= '<div class="note_vir">' . AI_STR_058 . ' (' . count($g_Phishing) . ')</div><div class="crit">';
        $l_Result .= printList($g_Phishing, $g_PhishingFragment, true, $g_PhishingSigFragment, 'table_vir');
        $l_PlainResult .= '[PHISHING]' . "\n" . printPlainList($g_Phishing, $g_PhishingFragment, true, $g_PhishingSigFragment, 'table_vir') . "\n";
        $l_Result .= "</div>" . PHP_EOL;
        
        $l_ShowOffer = true;
    }
    
    stdOut("Building list of redirects " . count($g_Redirect));
    if (count($g_Redirect) > 0) {
        $l_RawReport['redirect'] = getRawJson($g_Redirect, $g_RedirectPHPFragment);
        $l_ShowOffer             = true;
        $l_Result .= '<div class="note_vir">' . AI_STR_027 . ' (' . count($g_Redirect) . ')</div><div class="crit">';
        $l_Result .= printList($g_Redirect, $g_RedirectPHPFragment, true);
        $l_Result .= "</div>" . PHP_EOL;
    }
    
    stdOut("Building list of symlinks " . count($g_SymLinks));
    
    if (count($g_SymLinks) > 0) {
        $g_SymLinks               = array_slice($g_SymLinks, 0, AIBOLIT_MAX_NUMBER);
        $l_RawReport['sym_links'] = $g_SymLinks;
        $l_Result .= '<div class="note_vir">' . AI_STR_022 . ' (' . count($g_SymLinks) . ')</div><div class="crit">';
        $l_Result .= nl2br(makeSafeFn(implode("\n", $g_SymLinks), true));
        $l_Result .= "</div><div class=\"spacer\"></div>";
    }
    
}

////////////////////////////////////
if (!AI_HOSTER) {
    $l_WarningsNum = count($g_HeuristicDetected) + count($g_HiddenFiles) + count($g_BigFiles) + count($g_PHPCodeInside) + count($g_AdwareList) + count($g_EmptyLink) + count($g_Doorway) + (count($g_WarningPHP[0]) + count($g_WarningPHP[1]) + count($g_SkippedFolders));
    
    if ($l_WarningsNum > 0) {
        $l_Result .= "<div style=\"margin-top: 20px\" class=\"title\">" . AI_STR_026 . "</div>";
    }
    
    stdOut("Building list of adware " . count($g_AdwareList));
    
    if (count($g_AdwareList) > 0) {
        $l_RawReport['adware'] = getRawJson($g_AdwareList, $g_AdwareListFragment);
        $l_Result .= '<div class="note_warn">' . AI_STR_029 . '</div><div class="warn">';
        $l_Result .= printList($g_AdwareList, $g_AdwareListFragment, true);
        $l_PlainResult .= '[ADWARE]' . "\n" . printPlainList($g_AdwareList, $g_AdwareListFragment, true) . "\n";
        $l_Result .= "</div>" . PHP_EOL;        
    }
    
    stdOut("Building list of bigfiles " . count($g_BigFiles));
    $max_size_to_scan = getBytes(MAX_SIZE_TO_SCAN);
    $max_size_to_scan = $max_size_to_scan > 0 ? $max_size_to_scan : getBytes('1m');
    
    if (count($g_BigFiles) > 0) {
        $g_BigFiles               = array_slice($g_BigFiles, 0, AIBOLIT_MAX_NUMBER);
        $l_RawReport['big_files'] = getRawJson($g_BigFiles);
        $l_Result .= "<div class=\"note_warn\">" . sprintf(AI_STR_038, bytes2Human($max_size_to_scan)) . '</div><div class="warn">';
        $l_Result .= printList($g_BigFiles);
        $l_Result .= "</div>";
        $l_PlainResult .= '[BIG FILES / SKIPPED]' . "\n" . printPlainList($g_BigFiles) . "\n\n";
    }
    
    stdOut("Building list of doorways " . count($g_Doorway));
    
    if ((count($g_Doorway) > 0) && (($defaults['report_mask'] & REPORT_MASK_DOORWAYS) == REPORT_MASK_DOORWAYS)) {
        $g_Doorway              = array_slice($g_Doorway, 0, AIBOLIT_MAX_NUMBER);
        $l_RawReport['doorway'] = getRawJson($g_Doorway);
        $l_Result .= '<div class="note_warn">' . AI_STR_034 . '</div><div class="warn">';
        $l_Result .= printList($g_Doorway);
        $l_Result .= "</div>" . PHP_EOL;
        
    }
    
    if (count($g_CMS) > 0) {
        $l_RawReport['cms'] = $g_CMS;
        $l_Result .= "<div class=\"note_warn\">" . AI_STR_037 . "<br/>";
        $l_Result .= nl2br(makeSafeFn(implode("\n", $g_CMS)));
        $l_Result .= "</div>";
    }
}

if (ICHECK) {
    $l_Result .= "<div style=\"margin-top: 20px\" class=\"title\">" . AI_STR_087 . "</div>";
    
    stdOut("Building list of added files " . count($changes['addedFiles']));
    if (count($changes['addedFiles']) > 0) {
        $l_Result .= '<div class="note_int">' . AI_STR_082 . ' (' . count($changes['addedFiles']) . ')</div><div class="intitem">';
        $l_Result .= printList($changes['addedFiles']);
        $l_Result .= "</div>" . PHP_EOL;
    }
    
    stdOut("Building list of modified files " . count($changes['modifiedFiles']));
    if (count($changes['modifiedFiles']) > 0) {
        $l_Result .= '<div class="note_int">' . AI_STR_083 . ' (' . count($changes['modifiedFiles']) . ')</div><div class="intitem">';
        $l_Result .= printList($changes['modifiedFiles']);
        $l_Result .= "</div>" . PHP_EOL;
    }
    
    stdOut("Building list of deleted files " . count($changes['deletedFiles']));
    if (count($changes['deletedFiles']) > 0) {
        $l_Result .= '<div class="note_int">' . AI_STR_084 . ' (' . count($changes['deletedFiles']) . ')</div><div class="intitem">';
        $l_Result .= printList($changes['deletedFiles']);
        $l_Result .= "</div>" . PHP_EOL;
    }
    
    stdOut("Building list of added dirs " . count($changes['addedDirs']));
    if (count($changes['addedDirs']) > 0) {
        $l_Result .= '<div class="note_int">' . AI_STR_085 . ' (' . count($changes['addedDirs']) . ')</div><div class="intitem">';
        $l_Result .= printList($changes['addedDirs']);
        $l_Result .= "</div>" . PHP_EOL;
    }
    
    stdOut("Building list of deleted dirs " . count($changes['deletedDirs']));
    if (count($changes['deletedDirs']) > 0) {
        $l_Result .= '<div class="note_int">' . AI_STR_086 . ' (' . count($changes['deletedDirs']) . ')</div><div class="intitem">';
        $l_Result .= printList($changes['deletedDirs']);
        $l_Result .= "</div>" . PHP_EOL;
    }
}

if (!isCli()) {
    $l_Result .= QCR_ExtractInfo($l_PhpInfoBody[1]);
}


if (function_exists('memory_get_peak_usage')) {
    $l_Template = str_replace("@@MEMORY@@", AI_STR_043 . bytes2Human(memory_get_peak_usage()), $l_Template);
}

$l_Template = str_replace('@@WARN_QUICK@@', ((SCAN_ALL_FILES || $g_SpecificExt) ? '' : AI_STR_045), $l_Template);

if ($l_ShowOffer) {
    $l_Template = str_replace('@@OFFER@@', $l_Offer, $l_Template);
} else {
    $l_Template = str_replace('@@OFFER@@', AI_STR_002, $l_Template);
}

$l_Template = str_replace('@@OFFER2@@', $l_Offer2, $l_Template);

$l_Template = str_replace('@@CAUTION@@', AI_STR_003, $l_Template);

$l_Template = str_replace('@@CREDITS@@', AI_STR_075, $l_Template);

$l_Template = str_replace('@@FOOTER@@', AI_STR_076, $l_Template);

$l_Template = str_replace('@@STAT@@', sprintf(AI_STR_012, $time_taken, date('d-m-Y в H:i:s', floor(START_TIME)), date('d-m-Y в H:i:s')), $l_Template);

////////////////////////////////////////////////////////////////////////////
$l_Template = str_replace("@@MAIN_CONTENT@@", $l_Result, $l_Template);

if (!isCli()) {
    echo $l_Template;
    exit;
}

if (!defined('REPORT') OR REPORT === '') {
    die2('Report not written.');
}

// write plain text result
if (PLAIN_FILE != '') {
    
    $l_PlainResult = preg_replace('|__AI_LINE1__|smi', '[', $l_PlainResult);
    $l_PlainResult = preg_replace('|__AI_LINE2__|smi', '] ', $l_PlainResult);
    $l_PlainResult = preg_replace('|__AI_MARKER__|smi', ' %> ', $l_PlainResult);
    
    if ($l_FH = fopen(PLAIN_FILE, "w")) {
        fputs($l_FH, $l_PlainResult);
        fclose($l_FH);
    }
}

// write json result
if (defined('JSON_FILE')) {
    $res = @json_encode($l_RawReport);
    if ($l_FH = fopen(JSON_FILE, "w")) {
        fputs($l_FH, $res);
        fclose($l_FH);
    }

    if (JSON_STDOUT) {
       echo $res;
    }
}

// write serialized result
if (defined('PHP_FILE')) {
    if ($l_FH = fopen(PHP_FILE, "w")) {
        fputs($l_FH, serialize($l_RawReport));
        fclose($l_FH);
    }
}

$emails = getEmails(REPORT);

if (!$emails) {
    if ($l_FH = fopen($file, "w")) {
        fputs($l_FH, $l_Template);
        fclose($l_FH);
        stdOut("\nReport written to '$file'.");
    } else {
        stdOut("\nCannot create '$file'.");
    }
} else {
    $headers = array(
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=UTF-8',
        'From: ' . ($defaults['email_from'] ? $defaults['email_from'] : 'AI-Bolit@myhost')
    );
    
    for ($i = 0, $size = sizeof($emails); $i < $size; $i++) {
        $res = @mail($emails[$i], 'AI-Bolit Report ' . date("d/m/Y H:i", time()), $l_Result, implode("\r\n", $headers));
    }
    
    if ($res) {
       stdOut("\nReport sended to " . implode(', ', $emails));
    }
}

$time_taken = microtime(true) - START_TIME;
$time_taken = number_format($time_taken, 5);

stdOut("Scanning complete! Time taken: " . seconds2Human($time_taken));

if (DEBUG_PERFORMANCE) {
    $keys = array_keys($g_RegExpStat);
    for ($i = 0; $i < count($keys); $i++) {
        $g_RegExpStat[$keys[$i]] = round($g_RegExpStat[$keys[$i]] * 1000000);
    }
    
    arsort($g_RegExpStat);
    
    foreach ($g_RegExpStat as $r => $v) {
        echo $v . "\t\t" . $r . "\n";
    }
    
    die();
}

stdOut("\n\n!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
stdOut("Attention! DO NOT LEAVE either ai-bolit.php or AI-BOLIT-REPORT-<xxxx>-<yy>.html \nfile on server. COPY it locally then REMOVE from server. ");
stdOut("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");

if (isset($options['quarantine'])) {
    Quarantine();
}

if (isset($options['cmd'])) {
    stdOut("Run \"{$options['cmd']}\" ");
    system($options['cmd']);
}

QCR_Debug();

# exit with code

$l_EC1 = count($g_CriticalPHP);
$l_EC2 = count($g_CriticalJS) + count($g_Phishing) + count($g_WarningPHP[0]) + count($g_WarningPHP[1]);
$code  = 0;

if ($l_EC1 > 0) {
    $code = 2;
} else {
    if ($l_EC2 > 0) {
        $code = 1;
    }
}

$stat = array(
    'php_malware' => count($g_CriticalPHP),
    'js_malware' => count($g_CriticalJS),
    'phishing' => count($g_Phishing)
);

if (function_exists('aibolit_onComplete')) {
    aibolit_onComplete($code, $stat);
}

stdOut('Exit code ' . $code);
exit($code);

############################################# END ###############################################

function Quarantine() {
    if (!file_exists(DOUBLECHECK_FILE)) {
        return;
    }
    
    $g_QuarantinePass = 'aibolit';
    
    $archive  = "AI-QUARANTINE-" . rand(100000, 999999) . ".zip";
    $infoFile = substr($archive, 0, -3) . "txt";
    $report   = REPORT_PATH . DIR_SEPARATOR . REPORT_FILE;
    
    
    foreach (file(DOUBLECHECK_FILE) as $file) {
        $file = trim($file);
        if (!is_file($file))
            continue;
        
        $lStat = stat($file);
        
        // skip files over 300KB
        if ($lStat['size'] > 300 * 1024)
            continue;
        
        // http://www.askapache.com/security/chmod-stat.html
        $p    = $lStat['mode'];
        $perm = '-';
        $perm .= (($p & 0x0100) ? 'r' : '-') . (($p & 0x0080) ? 'w' : '-');
        $perm .= (($p & 0x0040) ? (($p & 0x0800) ? 's' : 'x') : (($p & 0x0800) ? 'S' : '-'));
        $perm .= (($p & 0x0020) ? 'r' : '-') . (($p & 0x0010) ? 'w' : '-');
        $perm .= (($p & 0x0008) ? (($p & 0x0400) ? 's' : 'x') : (($p & 0x0400) ? 'S' : '-'));
        $perm .= (($p & 0x0004) ? 'r' : '-') . (($p & 0x0002) ? 'w' : '-');
        $perm .= (($p & 0x0001) ? (($p & 0x0200) ? 't' : 'x') : (($p & 0x0200) ? 'T' : '-'));
        
        $owner = (function_exists('posix_getpwuid')) ? @posix_getpwuid($lStat['uid']) : array(
            'name' => $lStat['uid']
        );
        $group = (function_exists('posix_getgrgid')) ? @posix_getgrgid($lStat['gid']) : array(
            'name' => $lStat['uid']
        );
        
        $inf['permission'][] = $perm;
        $inf['owner'][]      = $owner['name'];
        $inf['group'][]      = $group['name'];
        $inf['size'][]       = $lStat['size'] > 0 ? bytes2Human($lStat['size']) : '-';
        $inf['ctime'][]      = $lStat['ctime'] > 0 ? date("d/m/Y H:i:s", $lStat['ctime']) : '-';
        $inf['mtime'][]      = $lStat['mtime'] > 0 ? date("d/m/Y H:i:s", $lStat['mtime']) : '-';
        $files[]             = strpos($file, './') === 0 ? substr($file, 2) : $file;
    }
    
    // get config files for cleaning
    $configFilesRegex = 'config(uration|\.in[ic])?\.php$|dbconn\.php$';
    $configFiles      = preg_grep("~$configFilesRegex~", $files);
    
    // get columns width
    $width = array();
    foreach (array_keys($inf) as $k) {
        $width[$k] = strlen($k);
        for ($i = 0; $i < count($inf[$k]); ++$i) {
            $len = strlen($inf[$k][$i]);
            if ($len > $width[$k])
                $width[$k] = $len;
        }
    }
    
    // headings of columns
    $info = '';
    foreach (array_keys($inf) as $k) {
        $info .= str_pad($k, $width[$k], ' ', STR_PAD_LEFT) . ' ';
    }
    $info .= "name\n";
    
    for ($i = 0; $i < count($files); ++$i) {
        foreach (array_keys($inf) as $k) {
            $info .= str_pad($inf[$k][$i], $width[$k], ' ', STR_PAD_LEFT) . ' ';
        }
        $info .= $files[$i] . "\n";
    }
    unset($inf, $width);
    
    exec("zip -v 2>&1", $output, $code);
    
    if ($code == 0) {
        $filter = '';
        if ($configFiles && exec("grep -V 2>&1", $output, $code) && $code == 0) {
            $filter = "|grep -v -E '$configFilesRegex'";
        }
        
        exec("cat AI-BOLIT-DOUBLECHECK.php $filter |zip -@ --password $g_QuarantinePass $archive", $output, $code);
        if ($code == 0) {
            file_put_contents($infoFile, $info);
            $m = array();
            if (!empty($filter)) {
                foreach ($configFiles as $file) {
                    $tmp  = file_get_contents($file);
                    // remove  passwords
                    $tmp  = preg_replace('~^.*?pass.*~im', '', $tmp);
                    // new file name
                    $file = preg_replace('~.*/~', '', $file) . '-' . rand(100000, 999999);
                    file_put_contents($file, $tmp);
                    $m[] = $file;
                }
            }
            
            exec("zip -j --password $g_QuarantinePass $archive $infoFile $report " . DOUBLECHECK_FILE . ' ' . implode(' ', $m));
            stdOut("\nCreate archive '" . realpath($archive) . "'");
            stdOut("This archive have password '$g_QuarantinePass'");
            foreach ($m as $file)
                unlink($file);
            unlink($infoFile);
            return;
        }
    }
    
    $zip = new ZipArchive;
    
    if ($zip->open($archive, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) === false) {
        stdOut("Cannot create '$archive'.");
        return;
    }
    
    foreach ($files as $file) {
        if (in_array($file, $configFiles)) {
            $tmp = file_get_contents($file);
            // remove  passwords
            $tmp = preg_replace('~^.*?pass.*~im', '', $tmp);
            $zip->addFromString($file, $tmp);
        } else {
            $zip->addFile($file);
        }
    }
    $zip->addFile(DOUBLECHECK_FILE, DOUBLECHECK_FILE);
    $zip->addFile($report, REPORT_FILE);
    $zip->addFromString($infoFile, $info);
    $zip->close();
    
    stdOut("\nCreate archive '" . realpath($archive) . "'.");
    stdOut("This archive has no password!");
}



///////////////////////////////////////////////////////////////////////////
function QCR_IntegrityCheck($l_RootDir) {
    global $g_Structure, $g_Counter, $g_Doorway, $g_FoundTotalFiles, $g_FoundTotalDirs, $defaults, $g_SkippedFolders, $g_UrlIgnoreList, $g_DirIgnoreList, $g_UnsafeDirArray, $g_UnsafeFilesFound, $g_SymLinks, $g_HiddenFiles, $g_UnixExec, $g_IgnoredExt, $g_SuspiciousFiles, $l_SkipSample;
    global $g_IntegrityDB, $g_ICheck;
    static $l_Buffer = '';
    
    $l_DirCounter          = 0;
    $l_DoorwayFilesCounter = 0;
    $l_SourceDirIndex      = $g_Counter - 1;
    
    QCR_Debug('Check ' . $l_RootDir);
    
    if ($l_DIRH = @opendir($l_RootDir)) {
        while (($l_FileName = readdir($l_DIRH)) !== false) {
            if ($l_FileName == '.' || $l_FileName == '..')
                continue;
            
            $l_FileName = $l_RootDir . DIR_SEPARATOR . $l_FileName;
            
            $l_Type  = filetype($l_FileName);
            $l_IsDir = ($l_Type == "dir");
            if ($l_Type == "link") {
                $g_SymLinks[] = $l_FileName;
                continue;
            } else if ($l_Type != "file" && (!$l_IsDir)) {
                $g_UnixExec[] = $l_FileName;
                continue;
            }
            
            $l_Ext = substr($l_FileName, strrpos($l_FileName, '.') + 1);
            
            $l_NeedToScan = true;
            $l_Ext2       = substr(strstr(basename($l_FileName), '.'), 1);
            if (in_array(strtolower($l_Ext2), $g_IgnoredExt)) {
                $l_NeedToScan = false;
            }
            
            // if folder in ignore list
            $l_Skip = false;
            for ($dr = 0; $dr < count($g_DirIgnoreList); $dr++) {
                if (($g_DirIgnoreList[$dr] != '') && preg_match('#' . $g_DirIgnoreList[$dr] . '#', $l_FileName, $l_Found)) {
                    if (!in_array($g_DirIgnoreList[$dr], $l_SkipSample)) {
                        $l_SkipSample[] = $g_DirIgnoreList[$dr];
                    } else {
                        $l_Skip       = true;
                        $l_NeedToScan = false;
                    }
                }
            }
            
            if (getRelativePath($l_FileName) == "./" . INTEGRITY_DB_FILE)
                $l_NeedToScan = false;
            
            if ($l_IsDir) {
                // skip on ignore
                if ($l_Skip) {
                    $g_SkippedFolders[] = $l_FileName;
                    continue;
                }
                
                $l_BaseName = basename($l_FileName);
                
                $l_DirCounter++;
                
                $g_Counter++;
                $g_FoundTotalDirs++;
                
                QCR_IntegrityCheck($l_FileName);
                
            } else {
                if ($l_NeedToScan) {
                    $g_FoundTotalFiles++;
                    $g_Counter++;
                }
            }
            
            if (!$l_NeedToScan)
                continue;
            
            if (IMAKE) {
                write_integrity_db_file($l_FileName);
                continue;
            }
            
            // ICHECK
            // skip if known and not modified.
            if (icheck($l_FileName))
                continue;
            
            $l_Buffer .= getRelativePath($l_FileName);
            $l_Buffer .= $l_IsDir ? DIR_SEPARATOR . "\n" : "\n";
            
            if (strlen($l_Buffer) > 32000) {
                file_put_contents(QUEUE_FILENAME, $l_Buffer, FILE_APPEND) or die2("Cannot write to file " . QUEUE_FILENAME);
                $l_Buffer = '';
            }
            
        }
        
        closedir($l_DIRH);
    }
    
    if (($l_RootDir == ROOT_PATH) && !empty($l_Buffer)) {
        file_put_contents(QUEUE_FILENAME, $l_Buffer, FILE_APPEND) or die2("Cannot write to file " . QUEUE_FILENAME);
        $l_Buffer = '';
    }
    
    if (($l_RootDir == ROOT_PATH)) {
        write_integrity_db_file();
    }
    
}


function getRelativePath($l_FileName) {
    return "./" . substr($l_FileName, strlen(ROOT_PATH) + 1) . (is_dir($l_FileName) ? DIR_SEPARATOR : '');
}

/**
 *
 * @return true if known and not modified
 */
function icheck($l_FileName) {
    global $g_IntegrityDB, $g_ICheck;
    static $l_Buffer = '';
    static $l_status = array('modified' => 'modified', 'added' => 'added');
    
    $l_RelativePath = getRelativePath($l_FileName);
    $l_known        = isset($g_IntegrityDB[$l_RelativePath]);
    
    if (is_dir($l_FileName)) {
        if ($l_known) {
            unset($g_IntegrityDB[$l_RelativePath]);
        } else {
            $g_IntegrityDB[$l_RelativePath] =& $l_status['added'];
        }
        return $l_known;
    }
    
    if ($l_known == false) {
        $g_IntegrityDB[$l_RelativePath] =& $l_status['added'];
        return false;
    }
    
    $hash = is_file($l_FileName) ? hash_file('sha1', $l_FileName) : '';
    
    if ($g_IntegrityDB[$l_RelativePath] != $hash) {
        $g_IntegrityDB[$l_RelativePath] =& $l_status['modified'];
        return false;
    }
    
    unset($g_IntegrityDB[$l_RelativePath]);
    return true;
}

function write_integrity_db_file($l_FileName = '') {
    static $l_Buffer = '';
    
    if (empty($l_FileName)) {
        empty($l_Buffer) or file_put_contents('compress.zlib://' . INTEGRITY_DB_FILE, $l_Buffer, FILE_APPEND) or die2("Cannot write to file " . INTEGRITY_DB_FILE);
        $l_Buffer = '';
        return;
    }
    
    $l_RelativePath = getRelativePath($l_FileName);
    
    $hash = is_file($l_FileName) ? hash_file('sha1', $l_FileName) : '';
    
    $l_Buffer .= "$l_RelativePath|$hash\n";
    
    if (strlen($l_Buffer) > 32000) {
        file_put_contents('compress.zlib://' . INTEGRITY_DB_FILE, $l_Buffer, FILE_APPEND) or die2("Cannot write to file " . INTEGRITY_DB_FILE);
        $l_Buffer = '';
    }
}

function load_integrity_db() {
    global $g_IntegrityDB;
    file_exists(INTEGRITY_DB_FILE) or die2('Not found ' . INTEGRITY_DB_FILE);
    
    $s_file = new SplFileObject('compress.zlib://' . INTEGRITY_DB_FILE);
    $s_file->setFlags(SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
    
    foreach ($s_file as $line) {
        $i = strrpos($line, '|');
        if (!$i)
            continue;
        $g_IntegrityDB[substr($line, 0, $i)] = substr($line, $i + 1);
    }
    
    $s_file = null;
}


function getStdin()
{
    $stdin  = '';
    $f      = @fopen('php://stdin', 'r');
    while($line = fgets($f)) 
    {
        $stdin .= $line;
    }
    fclose($f);
    return $stdin;
}

function OptimizeSignatures() {
    global $g_DBShe, $g_FlexDBShe, $gX_FlexDBShe, $gXX_FlexDBShe;
    global $g_JSVirSig, $gX_JSVirSig;
    global $g_AdwareSig;
    global $g_PhishingSig;
    global $g_ExceptFlex, $g_SusDBPrio, $g_SusDB;
    
    (AI_EXPERT == 2) && ($g_FlexDBShe = array_merge($g_FlexDBShe, $gX_FlexDBShe, $gXX_FlexDBShe));
    (AI_EXPERT == 1) && ($g_FlexDBShe = array_merge($g_FlexDBShe, $gX_FlexDBShe));
    $gX_FlexDBShe = $gXX_FlexDBShe = array();
    
    (AI_EXPERT == 2) && ($g_JSVirSig = array_merge($g_JSVirSig, $gX_JSVirSig));
    $gX_JSVirSig = array();
    
    $count = count($g_FlexDBShe);
    
    for ($i = 0; $i < $count; $i++) {
        if ($g_FlexDBShe[$i] == '[a-zA-Z0-9_]+?\(\s*[a-zA-Z0-9_]+?=\s*\)')
            $g_FlexDBShe[$i] = '\((?<=[a-zA-Z0-9_].)\s*[a-zA-Z0-9_]++=\s*\)';
        if ($g_FlexDBShe[$i] == '([^\?\s])\({0,1}\.[\+\*]\){0,1}\2[a-z]*e')
            $g_FlexDBShe[$i] = '(?J)\.[+*](?<=(?<d>[^\?\s])\(..|(?<d>[^\?\s])..)\)?\g{d}[a-z]*e';
        if ($g_FlexDBShe[$i] == '$[a-zA-Z0-9_]\{\d+\}\s*\.$[a-zA-Z0-9_]\{\d+\}\s*\.$[a-zA-Z0-9_]\{\d+\}\s*\.')
            $g_FlexDBShe[$i] = '\$[a-zA-Z0-9_]\{\d+\}\s*\.\$[a-zA-Z0-9_]\{\d+\}\s*\.\$[a-zA-Z0-9_]\{\d+\}\s*\.';
        
        $g_FlexDBShe[$i] = str_replace('http://.+?/.+?\.php\?a', 'http://[^?\s]++(?<=\.php)\?a', $g_FlexDBShe[$i]);
        $g_FlexDBShe[$i] = preg_replace('~\[a-zA-Z0-9_\]\+\K\?~', '+', $g_FlexDBShe[$i]);
        $g_FlexDBShe[$i] = preg_replace('~^\\\\[d]\+&@~', '&@(?<=\d..)', $g_FlexDBShe[$i]);
        $g_FlexDBShe[$i] = str_replace('\s*[\'"]{0,1}.+?[\'"]{0,1}\s*', '.+?', $g_FlexDBShe[$i]);
        $g_FlexDBShe[$i] = str_replace('[\'"]{0,1}.+?[\'"]{0,1}', '.+?', $g_FlexDBShe[$i]);
        
        $g_FlexDBShe[$i] = preg_replace('~^\[\'"\]\{0,1\}\.?|^@\*|^\\\\s\*~', '', $g_FlexDBShe[$i]);
        $g_FlexDBShe[$i] = preg_replace('~^\[\'"\]\{0,1\}\.?|^@\*|^\\\\s\*~', '', $g_FlexDBShe[$i]);
    }
    
    optSig($g_FlexDBShe);
    
    optSig($g_JSVirSig);
    optSig($g_AdwareSig);
    optSig($g_PhishingSig);
    optSig($g_SusDB);
    //optSig($g_SusDBPrio);
    //optSig($g_ExceptFlex);
    
    // convert exception rules
    $cnt = count($g_ExceptFlex);
    for ($i = 0; $i < $cnt; $i++) {
        $g_ExceptFlex[$i] = trim(UnwrapObfu($g_ExceptFlex[$i]));
        if (!strlen($g_ExceptFlex[$i]))
            unset($g_ExceptFlex[$i]);
    }
    
    $g_ExceptFlex = array_values($g_ExceptFlex);
}

function optSig(&$sigs) {
    $sigs = array_unique($sigs);
    
    // Add SigId
    foreach ($sigs as &$s) {
        $s .= '(?<X' . myCheckSum($s) . '>)';
    }
    unset($s);
    
    $fix = array(
        '([^\?\s])\({0,1}\.[\+\*]\){0,1}\2[a-z]*e' => '(?J)\.[+*](?<=(?<d>[^\?\s])\(..|(?<d>[^\?\s])..)\)?\g{d}[a-z]*e',
        'http://.+?/.+?\.php\?a' => 'http://[^?\s]++(?<=\.php)\?a',
        '\s*[\'"]{0,1}.+?[\'"]{0,1}\s*' => '.+?',
        '[\'"]{0,1}.+?[\'"]{0,1}' => '.+?'
    );
    
    $sigs = str_replace(array_keys($fix), array_values($fix), $sigs);
    
    $fix = array(
        '~^\\\\[d]\+&@~' => '&@(?<=\d..)',
        '~^((\[\'"\]|\\\\s|@)(\{0,1\}\.?|[?*]))+~' => ''
    );
    
    $sigs = preg_replace(array_keys($fix), array_values($fix), $sigs);
    
    optSigCheck($sigs);
    
    $tmp = array();
    foreach ($sigs as $i => $s) {
        if (!preg_match('#^(?>(?!\.[*+]|\\\\\d)(?:\\\\.|\[.+?\]|.))+$#', $s)) {
            unset($sigs[$i]);
            $tmp[] = $s;
        }
    }
    
    usort($sigs, 'strcasecmp');
    $txt = implode("\n", $sigs);
    
    for ($i = 24; $i >= 1; ($i > 4) ? $i -= 4 : --$i) {
        $txt = preg_replace_callback('#^((?>(?:\\\\.|\\[.+?\\]|[^(\n]|\((?:\\\\.|[^)(\n])++\))(?:[*?+]\+?|\{\d+(?:,\d*)?\}[+?]?|)){' . $i . ',})[^\n]*+(?:\\n\\1(?![{?*+]).+)+#im', 'optMergePrefixes', $txt);
    }
    
    $sigs = array_merge(explode("\n", $txt), $tmp);
    
    optSigCheck($sigs);
}

function optMergePrefixes($m) {
    $limit = 8000;
    
    $prefix     = $m[1];
    $prefix_len = strlen($prefix);
    
    $len = $prefix_len;
    $r   = array();
    
    $suffixes = array();
    foreach (explode("\n", $m[0]) as $line) {
        
        if (strlen($line) > $limit) {
            $r[] = $line;
            continue;
        }
        
        $s = substr($line, $prefix_len);
        $len += strlen($s);
        if ($len > $limit) {
            if (count($suffixes) == 1) {
                $r[] = $prefix . $suffixes[0];
            } else {
                $r[] = $prefix . '(?:' . implode('|', $suffixes) . ')';
            }
            $suffixes = array();
            $len      = $prefix_len + strlen($s);
        }
        $suffixes[] = $s;
    }
    
    if (!empty($suffixes)) {
        if (count($suffixes) == 1) {
            $r[] = $prefix . $suffixes[0];
        } else {
            $r[] = $prefix . '(?:' . implode('|', $suffixes) . ')';
        }
    }
    
    return implode("\n", $r);
}

function optMergePrefixes_Old($m) {
    $prefix     = $m[1];
    $prefix_len = strlen($prefix);
    
    $suffixes = array();
    foreach (explode("\n", $m[0]) as $line) {
        $suffixes[] = substr($line, $prefix_len);
    }
    
    return $prefix . '(?:' . implode('|', $suffixes) . ')';
}

/*
 * Checking errors in pattern
 */
function optSigCheck(&$sigs) {
    $result = true;
    
    foreach ($sigs as $k => $sig) {
        if (trim($sig) == "") {
            if (DEBUG_MODE) {
                echo ("************>>>>> EMPTY\n     pattern: " . $sig . "\n");
            }
            unset($sigs[$k]);
            $result = false;
        }
        
        if (@preg_match('#' . $sig . '#smiS', '') === false) {
            $error = error_get_last();
            if (DEBUG_MODE) {
                echo ("************>>>>> " . $error['message'] . "\n     pattern: " . $sig . "\n");
            }
            unset($sigs[$k]);
            $result = false;
        }
    }
    
    return $result;
}

function _hash_($text) {
    static $r;
    
    if (empty($r)) {
        for ($i = 0; $i < 256; $i++) {
            if ($i < 33 OR $i > 127)
                $r[chr($i)] = '';
        }
    }
    
    return sha1(strtr($text, $r));
}

function check_whitelist($list, &$snum) {
    global $defaults;

    if (empty($list))
        return array();
    
    $file = dirname(__FILE__) . '/AIBOLIT-WHITELIST.db';
    if (isset($defaults['avdb'])) {
       $file = dirname($defaults['avdb']) . '/AIBOLIT-WHITELIST.db';
    }

    if (!file_exists($file)) {
        return array();
    }
    
    $snum = max(0, @filesize($file) - 1024) / 20;
    stdOut("\nLoaded " . ceil($snum) . " known files from " . $file . "\n");
    
    sort($list);
    
    $hash = reset($list);
    
    $fp = @fopen($file, 'rb');
    
    if (false === $fp)
        return array();
    
    $header = unpack('V256', fread($fp, 1024));
    
    $result = array();
    
    foreach ($header as $chunk_id => $chunk_size) {
        if ($chunk_size > 0) {
            $str = fread($fp, $chunk_size);
            
            do {
                $raw = pack("H*", $hash);
                $id  = ord($raw[0]) + 1;
                
                if ($chunk_id == $id AND binarySearch($str, $raw)) {
                    $result[] = $hash;
                }
                
            } while ($chunk_id >= $id AND $hash = next($list));
            
            if ($hash === false)
                break;
        }
    }
    
    fclose($fp);
    
    return $result;
}


function binarySearch($str, $item) {
    $item_size = strlen($item);
    if ($item_size == 0)
        return false;
    
    $first = 0;
    
    $last = floor(strlen($str) / $item_size);
    
    while ($first < $last) {
        $mid = $first + (($last - $first) >> 1);
        $b   = substr($str, $mid * $item_size, $item_size);
        if (strcmp($item, $b) <= 0)
            $last = $mid;
        else
            $first = $mid + 1;
    }
    
    $b = substr($str, $last * $item_size, $item_size);
    if ($b == $item) {
        return true;
    } else {
        return false;
    }
}

function getSigId($l_Found) {
    foreach ($l_Found as $key => &$v) {
        if (is_string($key) AND $v[1] != -1 AND strlen($key) == 9) {
            return substr($key, 1);
        }
    }
    
    return null;
}

function die2($str) {
    if (function_exists('aibolit_onFatalError')) {
        aibolit_onFatalError($str);
    }
    die($str);
}

function checkFalsePositives($l_Filename, $l_Unwrapped, $l_DeobfType) {
    global $g_DeMapper;
    
    if ($l_DeobfType != '') {
        if (DEBUG_MODE) {
            stdOut("\n-----------------------------------------------------------------------------\n");
            stdOut("[DEBUG]" . $l_Filename . "\n");
            var_dump(getFragment($l_Unwrapped, $l_Pos));
            stdOut("\n...... $l_DeobfType ...........\n");
            var_dump($l_Unwrapped);
            stdOut("\n");
        }
        
        switch ($l_DeobfType) {
            case '_GLOBALS_':
                foreach ($g_DeMapper as $fkey => $fvalue) {
                    if (DEBUG_MODE) {
                        stdOut("[$fkey] => [$fvalue]\n");
                    }
                    
                    if ((strpos($l_Filename, $fkey) !== false) && (strpos($l_Unwrapped, $fvalue) !== false)) {
                        if (DEBUG_MODE) {
                            stdOut("\n[DEBUG] *** SKIP: False Positive\n");
                        }
                        
                        return true;
                    }
                }
                break;
        }
        
        
        return false;
    }
}

$full_code = '';

function deobfuscate_bitrix($str) {
    $res      = $str;
    $funclist = array();
    $strlist  = array();
    $res      = preg_replace("|[\"']\s*\.\s*['\"]|smi", '', $res);
    $res      = preg_replace_callback('~(?:min|max)\(\s*\d+[\,\|\s\|+\|\-\|\*\|\/][\d\s\.\,\+\-\*\/]+\)~ms', "calc", $res);
    $res = preg_replace_callback('|(round\((.+?)\))|smi', function($matches) {
        return round($matches[2]);
    }, $res);
    $res = preg_replace_callback('|base64_decode\(["\'](.*?)["\']\)|smi', function($matches) {
        return "'" . base64_decode($matches[1]) . "'";
    }, $res);
    
    $res = preg_replace_callback('|["\'](.*?)["\']|sm', function($matches) {
        $temp = base64_decode($matches[1]);
        if (base64_encode($temp) === $matches[1] && preg_match('#^[ -~]*$#', $temp)) {
            return "'" . $temp . "'";
        } else {
            return "'" . $matches[1] . "'";
        }
    }, $res);
    
    
    if (preg_match_all('|\$GLOBALS\[\'(.+?)\'\]\s*=\s*Array\((.+?)\);|smi', $res, $founds, PREG_SET_ORDER)) {
        foreach ($founds as $found) {
            $varname            = $found[1];
            $funclist[$varname] = explode(',', $found[2]);
            $funclist[$varname] = array_map(function($value) {
                return trim($value, "'");
            }, $funclist[$varname]);
            
            $res = preg_replace_callback('|\$GLOBALS\[\'' . $varname . '\'\]\[(\d+)\]|smi', function($matches) use ($varname, $funclist) {
                return $funclist[$varname][$matches[1]];
            }, $res);
        }
    }
    
    
    if (preg_match_all('|function\s*(\w{1,60})\(\$\w+\){\$\w{1,60}\s*=\s*Array\((.{1,30000}?)\);[^}]+}|smi', $res, $founds, PREG_SET_ORDER)) {
        foreach ($founds as $found) {
            $strlist = explode(',', $found[2]);
            $res = preg_replace_callback('|' . $found[1] . '\((\d+)\)|smi', function($matches) use ($strlist) {
                return $strlist[$matches[1]];
            }, $res);
            
            //$res = preg_replace('~' . quotemeta(str_replace('~', '\\~', $found[0])) . '~smi', '', $res);
        }
    }
    
    $res = preg_replace('~<\?(php)?\s*\?>~smi', '', $res);
    if (preg_match_all('~<\?\s*function\s*(_+(.{1,60}?))\(\$[_0-9]+\)\{\s*static\s*\$([_0-9]+)\s*=\s*(true|false);.{1,30000}?\$\3=array\((.*?)\);\s*return\s*base64_decode\(\$\3~smi', $res, $founds, PREG_SET_ORDER)) {
        foreach ($founds as $found) {
            $strlist = explode("',", $found[5]);
            $res = preg_replace_callback('|' . $found[1] . '\((\d+)\)|sm', function($matches) use ($strlist) {
                return $strlist[$matches[1]] . "'";
            }, $res);
            
        }
    }
    
    return $res;
}

function calc($expr) {
    if (is_array($expr))
        $expr = $expr[0];
    preg_match('~(min|max)?\(([^\)]+)\)~msi', $expr, $expr_arr);
    if ($expr_arr[1] == 'min' || $expr_arr[1] == 'max')
        return $expr_arr[1](explode(',', $expr_arr[2]));
    else {
        preg_match_all('~([\d\.]+)([\*\/\-\+])?~', $expr, $expr_arr);
        if (in_array('*', $expr_arr[2]) !== false) {
            $pos  = array_search('*', $expr_arr[2]);
            $res  = $expr_arr[1][$pos] * $expr_arr[1][$pos + 1];
            $expr = str_replace($expr_arr[1][$pos] . "*" . $expr_arr[1][$pos + 1], $res, $expr);
            $expr = calc($expr);
        } elseif (in_array('/', $expr_arr[2]) !== false) {
            $pos  = array_search('/', $expr_arr[2]);
            $res  = $expr_arr[1][$pos] / $expr_arr[1][$pos + 1];
            $expr = str_replace($expr_arr[1][$pos] . "/" . $expr_arr[1][$pos + 1], $res, $expr);
            $expr = calc($expr);
        } elseif (in_array('-', $expr_arr[2]) !== false) {
            $pos  = array_search('-', $expr_arr[2]);
            $res  = $expr_arr[1][$pos] - $expr_arr[1][$pos + 1];
            $expr = str_replace($expr_arr[1][$pos] . "-" . $expr_arr[1][$pos + 1], $res, $expr);
            $expr = calc($expr);
        } elseif (in_array('+', $expr_arr[2]) !== false) {
            $pos  = array_search('+', $expr_arr[2]);
            $res  = $expr_arr[1][$pos] + $expr_arr[1][$pos + 1];
            $expr = str_replace($expr_arr[1][$pos] . "+" . $expr_arr[1][$pos + 1], $res, $expr);
            $expr = calc($expr);
        } else {
            return $expr;
        }
        
        return $expr;
    }
}

function my_eval($matches) {
    $string = $matches[0];
    $string = substr($string, 5, strlen($string) - 7);
    return decode($string);
}

function decode($string, $level = 0) {
    if (trim($string) == '')
        return '';
    if ($level > 100)
        return '';
    
    if (($string[0] == '\'') || ($string[0] == '"')) {
        return substr($string, 1, strlen($string) - 2); //
    } elseif ($string[0] == '$') {
        global $full_code;
        $string = str_replace(")", "", $string);
        preg_match_all('~\\' . $string . '\s*=\s*(\'|")([^"\']+)(\'|")~msi', $full_code, $matches);
        return $matches[2][0]; //
    } else {
        $pos      = strpos($string, '(');
        $function = substr($string, 0, $pos);
        
        $arg = decode(substr($string, $pos + 1), $level + 1);
        if (strtolower($function) == 'base64_decode')
            return @base64_decode($arg);
        else if (strtolower($function) == 'gzinflate')
            return @gzinflate($arg);
        else if (strtolower($function) == 'gzuncompress')
            return @gzuncompress($arg);
        else if (strtolower($function) == 'strrev')
            return @strrev($arg);
        else if (strtolower($function) == 'str_rot13')
            return @str_rot13($arg);
        else
            return $arg;
    }
}

function deobfuscate_eval($str) {
    global $full_code;
    $res = preg_replace_callback('~eval\((base64_decode|gzinflate|strrev|str_rot13|gzuncompress).*?\);~msi', "my_eval", $str);
    return str_replace($str, $res, $full_code);
}

function getEvalCode($string) {
    preg_match("/eval\((.*?)\);/", $string, $matches);
    return (empty($matches)) ? '' : end($matches);
}

function getTextInsideQuotes($string) {
    if (preg_match_all('/("(.*?)")/', $string, $matches))
        return @end(end($matches));
    elseif (preg_match_all('/(\'(.*?)\')/', $string, $matches))
        return @end(end($matches));
    else
        return '';
}

function deobfuscate_lockit($str) {
    $obfPHP        = $str;
    $phpcode       = base64_decode(getTextInsideQuotes(getEvalCode($obfPHP)));
    $hexvalues     = getHexValues($phpcode);
    $tmp_point     = getHexValues($obfPHP);
    $pointer1      = hexdec($tmp_point[0]);
    $pointer2      = hexdec($hexvalues[0]);
    $pointer3      = hexdec($hexvalues[1]);
    $needles       = getNeedles($phpcode);
    $needle        = $needles[count($needles) - 2];
    $before_needle = end($needles);
    
    
    $phpcode = base64_decode(strtr(substr($obfPHP, $pointer2 + $pointer3, $pointer1), $needle, $before_needle));
    return "<?php {$phpcode} ?>";
}


function getNeedles($string) {
    preg_match_all("/'(.*?)'/", $string, $matches);
    
    return (empty($matches)) ? array() : $matches[1];
}

function getHexValues($string) {
    preg_match_all('/0x[a-fA-F0-9]{1,8}/', $string, $matches);
    return (empty($matches)) ? array() : $matches[0];
}

function deobfuscate_als($str) {
    preg_match('~__FILE__;\$[O0]+=[0-9a-fx]+;eval\(\$[O0]+\(\'([^\']+)\'\)\);return;~msi', $str, $layer1);
    preg_match('~\$[O0]+=(\$[O0]+\()+\$[O0]+,[0-9a-fx]+\),\'([^\']+)\',\'([^\']+)\'\)\);eval\(~msi', base64_decode($layer1[1]), $layer2);
    $res = explode("?>", $str);
    if (strlen(end($res)) > 0) {
        $res = substr(end($res), 380);
        $res = base64_decode(strtr($res, $layer2[2], $layer2[3]));
    }
    return "<?php {$res} ?>";
}

function deobfuscate_byterun($str) {
    global $full_code;
    preg_match('~\$_F=__FILE__;\$_X=\'([^\']+)\';\s*eval\s*\(\s*\$?\w{1,60}\s*\(\s*[\'"][^\'"]+[\'"]\s*\)\s*\)\s*;~msi', $str, $matches);
    $res = base64_decode($matches[1]);
    $res = strtr($res, '123456aouie', 'aouie123456');
    return "<?php " . str_replace($matches[0], $res, $full_code) . " ?>";
}

function deobfuscate_urldecode($str) {
    preg_match('~(\$[O0_]+)=urldecode\("([%0-9a-f]+)"\);((\$[O0_]+=(\1\{\d+\}\.?)+;)+)~msi', $str, $matches);
    $alph  = urldecode($matches[2]);
    $funcs = $matches[3];
    for ($i = 0; $i < strlen($alph); $i++) {
        $funcs = str_replace($matches[1] . '{' . $i . '}.', $alph[$i], $funcs);
        $funcs = str_replace($matches[1] . '{' . $i . '}', $alph[$i], $funcs);
    }
    
    $str   = str_replace($matches[3], $funcs, $str);
    $funcs = explode(';', $funcs);
    foreach ($funcs as $func) {
        $func_arr = explode("=", $func);
        if (count($func_arr) == 2) {
            $func_arr[0] = str_replace('$', '', $func_arr[0]);
            $str         = str_replace('${"GLOBALS"}["' . $func_arr[0] . '"]', $func_arr[1], $str);
        }
    }
    
    return $str;
}


function formatPHP($string) {
    $string = str_replace('<?php', '', $string);
    $string = str_replace('?>', '', $string);
    $string = str_replace(PHP_EOL, "", $string);
    $string = str_replace(";", ";\n", $string);
    return $string;
}

function deobfuscate_fopo($str) {
    $phpcode = formatPHP($str);
    $phpcode = base64_decode(getTextInsideQuotes(getEvalCode($phpcode)));
    @$phpcode = gzinflate(base64_decode(str_rot13(getTextInsideQuotes(end(explode(':', $phpcode))))));
    $old = '';
    while (($old != $phpcode) && (strlen(strstr($phpcode, '@eval($')) > 0)) {
        $old   = $phpcode;
        $funcs = explode(';', $phpcode);
        if (count($funcs) == 5)
            $phpcode = gzinflate(base64_decode(str_rot13(getTextInsideQuotes(getEvalCode($phpcode)))));
        else if (count($funcs) == 4)
            $phpcode = gzinflate(base64_decode(getTextInsideQuotes(getEvalCode($phpcode))));
    }
    
    return substr($phpcode, 2);
}

function getObfuscateType($str) {
    if (preg_match('~\$GLOBALS\[\s*[\'"]_+\w{1,60}[\'"]\s*\]\s*=\s*\s*array\s*\(\s*base64_decode\s*\(~msi', $str))
        return "_GLOBALS_";
    if (preg_match('~function\s*_+\d+\s*\(\s*\$i\s*\)\s*{\s*\$a\s*=\s*Array~msi', $str))
        return "_GLOBALS_";
    if (preg_match('~__FILE__;\$[O0]+=[0-9a-fx]+;eval\(\$[O0]+\(\'([^\']+)\'\)\);return;~msi', $str))
        return "ALS-Fullsite";
    if (preg_match('~\$[O0]*=urldecode\(\'%66%67%36%73%62%65%68%70%72%61%34%63%6f%5f%74%6e%64\'\);\s*\$GLOBALS\[\'[O0]*\'\]=\$[O0]*~msi', $str))
        return "LockIt!";
    if (preg_match('~\$\w+="(\\\x?[0-9a-f]+){13}";@eval\(\$\w+\(~msi', $str))
        return "FOPO";
    if (preg_match('~\$_F=__FILE__;\$_X=\'([^\']+\');eval\(~ms', $str))
        return "ByteRun";
    if (preg_match('~(\$[O0_]+)=urldecode\("([%0-9a-f]+)"\);((\$[O0_]+=(\1\{\d+\}\.?)+;)+)~msi', $str))
        return "urldecode_globals";
    if (preg_match('~eval\((base64_decode|gzinflate|strrev|str_rot13|gzuncompress)~msi', $str))
        return "eval";
}

function deobfuscate($str) {
    switch (getObfuscateType($str)) {
        case '_GLOBALS_':
            $str = deobfuscate_bitrix(($str));
            break;
        case 'eval':
            $str = deobfuscate_eval(($str));
            break;
        case 'ALS-Fullsite':
            $str = deobfuscate_als(($str));
            break;
        case 'LockIt!':
            $str = deobfuscate_lockit($str);
            break;
        case 'FOPO':
            $str = deobfuscate_fopo(($str));
            break;
        case 'ByteRun':
            $str = deobfuscate_byterun(($str));
            break;
        case 'urldecode_globals':
            $str = deobfuscate_urldecode(($str));
            break;
    }
    
    return $str;
}

function convertToUTF8($text)
{
    if (function_exists('mb_convert_encoding')) {
       $text = @mb_convert_encoding($text, 'utf-8', 'auto');
       $text = @mb_convert_encoding($text, 'UTF-8', 'UTF-8');
    }

    return $text;
}
