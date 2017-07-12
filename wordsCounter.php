#!/usr/bin/php
<?php

class ThreadWordCounter extends Thread
{

	/**
	 * @var int
	 */
	private $numberOfWords = 0;
	/**
	 * @var string
	 */
	private $filePath;

	/**
	 * ThreadWordCounter constructor.
	 * @param string $filePath
	 */
	public function __construct(string $filePath)
	{
		$this->filePath = $filePath;
	}

	/**
	 * @return int
	 */
	public function getNumberOfWords(): int
	{
		return $this->numberOfWords;
	}

	public function run()
	{
		if (file_exists($this->filePath)) {
			$this->numberOfWords = $this->countWordsViaPHP($this->filePath);
//			$this->numberOfWords = $this->countWordsViaWC($this->filePath);
		}
	}

	/**
	 * @param string $filePath
	 * @return int
	 */
	private function countWordsViaPHP(string $filePath): int
	{
		return (int)str_word_count(file_get_contents($filePath));
	}

	/**
	 * Bad way. It used a hint with string conversion to numbers, if string start with number.
	 * @param string $filePath
	 * @return int
	 */
	private function countWordsViaWC(string $filePath): int
	{
		return (int)exec('wc -w ' . $filePath);
	}
}

if ($argc === 1) {
	echo "Need a path to file or dir.\n";
	die();
} elseif ($argc > 2) {
	echo "Only first argument is used.\n";
}


list(, $filePath) = $argv;
if (!file_exists($filePath)) {
	echo "Wrong path!\n";
	die();
}

$recursiveII = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($filePath), RecursiveIteratorIterator::SELF_FIRST);
/** @var ThreadWordCounter[] $wordCounterObjects */
$wordCounterObjects = [];
/** @var \SplFileInfo $element */
foreach ($recursiveII as $element) {
	if ($element->isDir()) {
		continue;
	}
	$object = new ThreadWordCounter($element->getPathname());
	$object->start();
	$wordCounterObjects[] = $object;
}


foreach ($wordCounterObjects as $object) {
	$object->join();
}

$numberOfWords = 0;
foreach ($wordCounterObjects as $object) {
	$numberOfWords += $object->getNumberOfWords();
}

echo "Number of words: " . $numberOfWords . "\n";