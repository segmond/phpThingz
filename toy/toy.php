<?php
interface FetchDataStrategy {
    function fetchFile($filename);
}

class SFTPStrategy implements FetchDataStrategy {
    public function fetchFile($company) {
        echo "Fetching $company file via sftp\n";
        if ($company == 'acme') return true;
    }
}

class LocalFileStrategy implements FetchDataStrategy {
    public function fetchFile($company) {
        echo "Fetching $company file via filesystem\n";
        if ($company == 'wonkay') return true;
    }
}

class DataFetcher {
    private $strategy;
    private $name;

    public function __construct(FetchDataStrategy $s) {
        $this->strategy = $s;
    }

    public function fetch($name) {
        return $this->strategy->fetchFile($name);
    }

    public function setStrategy(FetchDataStrategy $s) {
        $this->strategy = $s;
    }
        
}


abstract class ProcessData
{
    protected $successor;

    public function setSuccessor(ProcessData $successor) {
        $this->successor = $successor;
    }

    abstract public function processFile(DataFile $request);
}

class AcmeProcessData extends ProcessData 
{
    public function processFile(DataFile $file) {
        if ($file->getPrefix() == 'acme') {
            echo "processing acme file\n";
        } else if ($this->successor != null) {
            $this->successor->processFile($file);
        }
    }
}

class XYZCorpProcessData extends ProcessData 
{
    public function processFile(DataFile $file) {
        if ($file->getPrefix() == 'xyzcorp') {
            echo "processing xyzcorp file\n";
        } else if ($this->successor != null) {
            $this->successor->processFile($file);
        }
    }
}

class WonkayProcessData extends ProcessData 
{
    public function processFile(DataFile $file) {
        if ($file->getPrefix() == 'wonkay') {
            echo "processing wonkay file\n";
        } else {
            echo "unknown file type\n";
        }
    }
}


class DataFile
{
    private $prefix;
    private $name;

    public function __construct($prefix, $name) {
        $this->prefix = $prefix;
        $this->name = $name;
    }

    public function getPrefix() {
        return $this->prefix;
    }
}


/**
 * Making use of the chain of responsibility & strategy together
 */
class Tester 
{
    public static function main() {
        $companies = array('acme', 'xyzcorp', 'wonkay');

        $data_fetcher = new DataFetcher(new SFTPStrategy());

        $acmeProcessor = new AcmeProcessData();
        $fdProcessor = new XYZCorpProcessData();
        $wonkayProcessor = new WonkayProcessData();

        $acmeProcessor->setSuccessor($fdProcessor);
        $fdProcessor->setSuccessor($wonkayProcessor);

        foreach ($companies as $key => $company) {
            $data_file = $data_fetcher->fetch($company);
            if ($data_file != null) {
                unset($companies[$key]);
                $acmeProcessor->processFile(new DataFile($company, $data_file));
            } 
        }

        $data_fetcher->setStrategy(new LocalFileStrategy());
        foreach ($companies as $company) {
            $data_file = $data_fetcher->fetch($company);
            if ($data_file != null) {
                unset($companies[$key]);
                $acmeProcessor->processFile(new DataFile($company, $data_file));
            } 
        }

    }
}

Tester::main();

