<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
	private $fileName1;
	private $fileName2;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
	    $this->fileName1 = 'test_files\firstFile.txt';
	    $this->fileName2 = 'test_files\secondFile.txt';
    }

    /**
     * @Given I have two files
     */
    public function iHaveTwoFiles()
    {
	    $text1 = "Some text for testing\r\n";
    	$file1 = fopen($this->fileName1, "w+");
	    fwrite($file1, $text1);

	    if (!file_exists($this->fileName1)) throw new \Error('First file doesn`t exist');

	    fclose($file1);

	    $text2 = "Some text for testing\r\n";
	    $file2 = fopen($this->fileName2, "w+");
	    fwrite($file2, $text2);

	    if (!file_exists($this->fileName2)) throw new \Error('Second file doesn`t exist');

	    fclose($file2);

	    return 1;
    }

    /**
     * @Then I know that this files are identical
     */
    public function iKnowThatThisFilesAreIdentical()
    {
	    // Check if filesize is different
	    if(filesize($this->fileName1) !== filesize($this->fileName2))
		    throw new \Error('Files are different');

	    // Check if content is different
	    $file1 = fopen($this->fileName1, 'rb');
	    $file2 = fopen($this->fileName2, 'rb');

	    while(!feof($file1))
	    {
		    if(fread($file1, filesize($this->fileName1)) !== fread($file2, filesize($this->fileName2)))
		    {
			    throw new \Error('Files are different123');
		    }
	    }

	    fclose($file1);
	    fclose($file2);

	    return 1;
    }
}
