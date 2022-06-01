<?php

// Facade: provides a simplified interface to a complex set of classes

class FacadeReader
{
    public function listen(int $id): string
    {
        $factory = new class { function create(int $id) {
            $book = new BookReader();
            $book->id = $id;
            return (new BiblioStandard)->persist(
                $book,
                (new AudioClassifier)
            );
        }};
        return $factory->create($id);
    }
}

final class BookReader
{
    public $id = 2;
    public $title = 'my_one';
}

final class BiblioStandard
{
    public function persist(BookReader $book, AudioClassifier $audio): string
    {
        return $audio->classify($book);
    }
}

final class AudioClassifier
{
    public function classify(BookReader $book): string
    {
        return $book->id . '*' . $book->title;
    }
}

// usage
$facade = new FacadeReader();
return "listen:5*my_one" === 'listen:' . $facade->listen(5);
