<?php

/** Component */
interface File {
    public function rename($newName);
    public function delete();
    public function display();
}

/** Leaf */
class Document implements File {
    private $fileName;

    public function __construct($fileName) {
        $this->fileName = $fileName;
    }

    public function rename($newName) {
        echo "Renaming file $this->fileName to $newName\n";
        $this->fileName = $newName;
    }

    public function delete() {
        $this->fileName = null;
    }

    public function display() {
        echo "File $this->fileName\n";
    }
}

/** Composite */
class Folder implements File {
    private $fileName;
    private $folderContent;

    public function __construct($fileName) {
        $this->fileName = $fileName;
        $this->folderContent = array();
    }

    public function add(File $fileName) {
        $this->folderContent[] = $fileName;
    }

    public function rename($newName) {
        echo "Renaming file $this->fileName to $newName\n";
        $this->fileName = $newName;
    }

    public function deleteFile($fileName) {
        $key = array_search($fileName, $this->folderContent, true);
        if ($key !== false) {
            unset($this->folderContent[$key]);
        }
    }

    public function delete() {
        $this->fileName = null;
    }

    public function display() {
        echo "Folder $this->fileName\n";
        foreach ($this->folderContent as $file) {
            echo "\t";
            echo $file->display();
        }
    }
}

/** Client */
class Program {
    public static function main() {
        $note = new Document('note.txt');
        $pic = new Document('pic.jpg');
        $mp3 = new Document('music.mp3');
        $rockmp3 = new Document('rockmusic.mp3');

        $homeDir = new Folder('/home');
        $homeDir->add($pic);
        $homeDir->add($note);
        $homeDir->add($mp3);
        $homeDir->add($rockmp3);

        $homeDir->display();

        $codeDir = new Folder('code');

        $php = new Document('code.php');
        $asm = new Document('x86.asm');

        $codeDir->add($php);
        $codeDir->add($asm);

        $homeDir->add($codeDir);

        $homeDir->display();
        $homeDir->deleteFile($codeDir);
        $homeDir->deleteFile($pic);
        $homeDir->display();

    }
}

Program::main();
