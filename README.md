Problem:

> Create a CLI-based application that would:
> - take a folder path as argument;
> - count words in all text files in the given folder in threaded way 
> - one thread per file;
> - print total counter to output.

PHP70 compiling with ZTS mode. Used [pthread](http://php.net/manual/en/book.pthreads.php) lib.

**Usage examples:**

<pre><code>php wordsCounter.php
Need a path to file or dir.</code></pre>

<pre><code>php wordsCounter.php test
Number of words: 6</code></pre>

<pre><code>php wordsCounter.php test asdf
Only first argument is used.
Number of words: 6</code></pre>

for mac: `brew install homebrew/php/php70-pthreads`