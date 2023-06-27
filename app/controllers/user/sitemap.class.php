<?php

namespace App\Controllers\User;

class Sitemap {
    private static $mapStart = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    private static $mapEnd = '</urlset>';
    private static $lastModeStatic = 1602345619;
	private static function urlTemplate($url, $lastMode, $priority) {
		return '<url><loc>' . $url . '</loc><lastmod>' . date(DATE_W3C, $lastMode) . '</lastmod><priority>' . $priority . '</priority></url>';
	}
    public static function get() {
        $xml = self::$mapStart;
        $staticUrl = array(
            'https://sushiko52.ru/',
            'https://sushiko52.ru/news',
            'https://sushiko52.ru/sales',
            'https://sushiko52.ru/about',
            'https://sushiko52.ru/contact'
        );
        foreach ( $staticUrl as $url ) {
            $xml .= self::urlTemplate($url, self::$lastModeStatic, '1.0');

        }
        $DB = new \App\Core\DB;
        $posts = $DB->get('articles', ['article_type', 'article_link', 'article_date'], 'article_deleted = 0');
        foreach( $posts as $post ) {
            $url = 'https://sushiko52.ru/' . $post['article_type'] . '/' . $post['article_link'];
            $xml .= self::urlTemplate($url, (int)$post['article_date'], '0.8');
        }
        $xml .= self::$mapEnd;
        return $xml;
    }
    public static function update() {
        $filename = $_SERVER['DOCUMENT_ROOT'] . '/sitemap.xml';
        $xml = self::get();
        $handle = fopen($filename, 'w');
        fwrite($handle, $xml);
        fclose($handle);
        // // Вначале давайте убедимся, что файл существует и доступен для записи.
        // if (is_writable($filename)) {

        //     // В нашем примере мы открываем $filename в режиме "дописать в конец".
        //     // Таким образом, смещение установлено в конец файла и
        //     // наш $somecontent допишется в конец при использовании fwrite().
        //     if (!$handle = fopen($filename, 'w')) {
        //         echo "Не могу открыть файл ($filename)";
        //         exit;
        //     }

        //     // Записываем $somecontent в наш открытый файл.
        //     if (fwrite($handle, $somecontent) === FALSE) {
        //         echo "Не могу произвести запись в файл ($filename)";
        //         exit;
        //     }
            
        //     echo "Ура! Записали ($somecontent) в файл ($filename)";
            
        //     fclose($handle);

        // } else {
        //     echo "Файл $filename недоступен для записи";
        // }
    }
}