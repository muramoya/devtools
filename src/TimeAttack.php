<?php
namespace muramoya\DevTools;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class TimeAttack
{
    /**
     * @var float
     */
	private static $start;

    /**
     * @var float
     */
	private static $finish;

    /**
     * @var float
     */
	private static $splitTimeFrom;

    /**
     * @var float
     */
	private static $splitTimeTo;

    /**
     * @var bool
     */
	private static $isShowSectionTime;

    /**
     * @var bool
     */
	private static $doesOutputFile = false;

    /**
     * @var int
     */
	private static $roundPrecision = 2;

	/**
	 * @var Logger
	 */
	private static $logger;

    /**
     * @var string
     */
    private static $logLevel = 'info';


    private const LOG_LEVELS = [
        'debug',
        'info',
        'notice',
        'warn',
        'warning',
        'err',
        'error',
        'crit',
        'critical',
        'alert',
        'emerg',
        'emergency',
    ];

    public static function enableFileOutput(string $filePath = null, string $outputFormat = null, string $logName = null): void
    {
        self::$doesOutputFile = true;
        $filePath = $filePath ?? '/tmp/timeattack.log';
        $output = $outputFormat ?? "[%datetime%] [%channel%] %message%\n";
		$format = new LineFormatter($output);
		$stream = new StreamHandler($filePath, Logger::INFO);
		$stream->setFormatter($format);
		self::$logger = new Logger($logName);
		self::$logger->pushHandler($stream);
    }

    public static function changeRoundPrecision(int $precision): void
    {
        self::$roundPrecision = $precision;
    }

    public static function setLogLevel(string $logLevel): void
    {
        if (self::$doesOutputFile) {
            if (!in_array($logLevel, self::LOG_LEVELS, true)) throw new \Exception('setLogLevel: Invalid log level.');
            self::$logLevel = $logLevel;
        }
    }

	public static function start(bool $showSection = false): string
	{
		self::$isShowSectionTime = $showSection;
		self::$start = microtime(true);
		self::$splitTimeFrom = microtime(true);
		return self::output('Start');
	}

	public static function split(string $label = null): string
	{
		$start = self::$start;
		self::$splitTimeTo = microtime(true);
		$res = round(self::$splitTimeTo - $start, self::$roundPrecision);
		$ret = 'Temporary time: ' . $res . ' sec';
		if($label) {
			$ret = '[' . $label . '] ' . $ret;
		}

		if(self::$isShowSectionTime) {
			$sectionTime = round(self::$splitTimeTo - self::$splitTimeFrom, self::$roundPrecision);
			$ret .= '  Section Time: ' . $sectionTime . ' sec';
			self::$splitTimeFrom = microtime(true);
		}

		return self::output($ret);
	}

	public static function finish(): string
	{
		self::$finish = microtime(true);
		$ret = 'Result ' . self::result() . ' sec' . "\n" . 'Finish';
		return self::output($ret);
	}

	private static function output($val = null): string
	{
	    if (self::$doesOutputFile) {
	        $method = self::$logLevel;
            self::$logger->$method($val);
        }

	    return $val;
	}

	private static function result(): float
	{
		return round(self::$finish - self::$start, self::$roundPrecision);
	}
}