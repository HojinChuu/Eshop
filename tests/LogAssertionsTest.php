<?php

use PHPUnit\Framework\TestCase;

class LogAssertionsTest extends TestCase
{
    public function setUp(): void
    {
        $access_log_file = fopen("access_test.log", "wr+");
        shell_exec("chmod o+w access_test.log");
        shell_exec("cat /var/log/apache2/access.log.1 > access_test.log");
        fclose($access_log_file);
    }

    public function tearDown(): void
    {
        unlink("access_test.log");
    }

    public function testUniqueUserValidation()
    {
        $user_ip = [];
        exec(ACCESS_TEST_ROOT . IP . RULE, $user_ip);

        foreach ($user_ip as $key => $ip) {
            $ip_result[] = explode(" ", trim($ip));
        }
        foreach ($ip_result as $item) {
            $uu[] = $item[1];
        }
        $expected = count(array_unique($uu));
        $result = count($uu);

        $this->assertEquals($expected, $result, "Err = The same user IP exists");
    }

    public function testPageViewValidation()
    {
        // 他のIPを入れると期待する値ではなくてエラーだと判断
        // shell_exec("echo '192.168.1.1 - - [07/Jan/2020:18:23:44 +0900] \"GET /logs/adminLogPage HTTP/1.1\" 200 612 \"http://192.168.9.95/users/admin\" \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36' >> access_test.log");

        $access_page = [];
        exec(ACCESS_TEST_ROOT . PAGE . RULE, $access_page);

        $pv = 0;
        foreach ($access_page as $key => $page) {
            $page_result[] = explode(" ", trim($page));
            if (strpos($page_result[$key][1], "/") == 0) {
                $divided = explode("/", $page_result[$key][1]);
                if (isset($divided[1]) && !empty($divided[1])) {
                    if ($divided[1] == "favicon.ico" ||
                        $divided[1] == "img" ||
                        $divided[1] == "upload" ||
                        $divided[1] == "js" ||
                        $divided[1] == "css" ||
                        $divided[0] == "*") {
                        unset($page_result[$key]);
                    } else {
                        $pv += $page_result[$key][0];
                    }
                }
            }
        }
        $expected = $pv;

        $logClass = new Logs();
        $pvId = $logClass->logModel->getLastColumnId();
        $pvColumn = $logClass->logModel->getLog($pvId->id);
        $result = $pvColumn->pv;

        $this->assertEquals($expected, $result);
    }

    public function testRankingValidation()
    {
        $this->assertTrue(true);
    }

    public function testOrderCountValidation()
    {
        $this->assertTrue(true);
    }

    public function testDateValueValidationOnlyYesterday()
    {
        // 昨日ではない日付を入れると期待する値ではなくてエラーだと判断
        // shell_exec("echo '192.168.1.1 - - [07/Jan/2020:18:23:44 +0900] \"GET /logs/adminLogPage HTTP/1.1\" 200 612 \"http://192.168.9.95/users/admin\" \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36' >> access_test.log");

        $access_time = [];
        exec(ACCESS_TEST_ROOT . TIME . RULE, $access_time);
        foreach ($access_time as $item) {
            $time_result[] = explode(" ", trim($item));
        }
        foreach ($time_result as $item) {
            $datetime = substr($item[1], 1, 11);
            $date_result = strtr($datetime, '/', '-');
            $date_result = strtotime($date_result);
            $dates[] = date('Y-m-d', $date_result);
        }
        $yesterday = date('Y-m-d', $_SERVER['REQUEST_TIME'] - 86400);

        foreach ($dates as $date) {
            $this->assertIsString($date, "Date type invalid");
            if ($date != $yesterday) {
                $this->assertSame($yesterday, $date, "Date is Only YesterDay");
            }
        }
        $this->assertTrue(true);
    }
}