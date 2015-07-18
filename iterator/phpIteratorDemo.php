<?php


interface IContainer {
    /** @return IIterator */
    public function createIterator();
}

class BooksCollection implements IContainer {
    private $titles = array();

    public function createIterator() {
        return new BookIterator($this);
    }

    public function setTitle($book_title) {
        $this->titles[] = $book_title;
    }
    
    public function getTitles() {
        return $this->titles;
    }
}

/** Make use of PHP's own iterator instead */
class BookIterator implements Iterator {
    private $position = 0;
    private $booksCollection;
    private $titles;

    public function __construct(BooksCollection $books) {
        $this->booksCollection = $books;
        $this->titles = $this->booksCollection->getTitles();
    }

    public function valid() {
        if ($this->position < count($this->booksCollection->getTitles())) {
            return true;
        }
        return false;
    }

    public function next() {
        return ++$this->position;
    }


    public function rewind() {
        $this->position = 0;
    }

    public function current() {
        return $this->titles[$this->position];
    }

    public function key() {
        return $this->position;
    }
}

class App {
    public static function main() {
        $booksCollection = new BooksCollection();

        $booksCollection->setTitle("Design Patterns");
        $booksCollection->setTitle("PHP for lame programmers");
        $booksCollection->setTitle("Python for dorks");
        $booksCollection->setTitle("Ruby for hipsters");

        $iterator = $booksCollection->createIterator();

        foreach ($iterator as $key => $value) {
            echo "$key -> $value\n";
        }

        $iterator->rewind();

        foreach ($iterator as $key => $value) {
            echo "$key -> $value\n";
        }

    }
}

App::main();
