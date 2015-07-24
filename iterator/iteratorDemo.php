<?php

interface IIterator {
    /** @return boolean */
    public function hasNext();
    public function next();
    public function rewind();
}

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

class BookIterator implements IIterator {
    private $position = 0;
    private $booksCollection;
    private $titles;

    public function __construct(BooksCollection $books) {
        $this->booksCollection = $books;
        $this->titles = $this->booksCollection->getTitles();
    }

    public function hasNext() {
        if ($this->position < count($this->booksCollection->getTitles())) {
            return true;
        }
        return false;
    }

    public function next() {
        if ($this->hasNext()) {
            return $this->titles[$this->position++];
        } else {
            return null;
        }
    }

    public function rewind() {
        $this->position = 0;
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

        while ($iterator->hasNext()) {
            echo $iterator->next() . "\n";
        }

        $iterator->rewind();

        while ($iterator->hasNext()) {
            echo $iterator->next() . "\n";
        }
    }
}

App::main();
