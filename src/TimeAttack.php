<?php
namespace DevTools;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class TimeAttack
{
	private $start;
	private $finish;
	private $splitTimeFrom;
	private $splitTimeTo;
	private $isShowSectionTime;
	/**
	 * @var Logger
	 */
	private $logger;

	public function __construct($name = null, $logPath = '/tmp/timeattack.log')
	{
		$output = "[%datetime%] [%channel%] %message%\n";
		$format = new LineFormatter($output);
		$stream = new StreamHandler($logPath, Logger::INFO);
		$stream->setFormatter($format);
		$this->logger = new Logger($name);
		$this->logger->pushHandler($stream);
	}

	public function start($showSection = false)
	{
		if($showSection) $this->isShowSectionTime = true;
		$this->start = microtime(true);
		$this->splitTimeFrom = microtime(true);
		$this->output('Start');
	}

	public function split($label = null)
	{
		$start = $this->start;
		$this->splitTimeTo = microtime(true);
		$res = round($this->splitTimeTo - $start, 2);
		$ret = 'Temporary time: ' . $res . ' sec';
		if($label)
		{
			$ret = '[' . $label . '] ' . $ret;
		}
		if($this->isShowSectionTime)
		{
			$sectionTime = round($this->splitTimeTo - $this->splitTimeFrom, 2);
			$ret .= '  Section Time: ' . $sectionTime . ' sec';
			$this->splitTimeFrom = microtime(true);
		}
		$this->output($ret);
	}

	public function finish()
	{
		$this->finish = microtime(true);
		$ret = 'Result ' . $this->result() . ' sec' . "\n";
		$this->output($ret);
		$ret = 'Finish';
		$this->output($ret);
	}

	private function output($val = null)
	{
		$this->logger->info($val);
	}

	private function result()
	{
		$start = $this->start;
		$finish = $this->finish;
		$res = round($finish - $start, 2);
		return $res;
	}
}