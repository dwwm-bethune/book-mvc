<?php

namespace Book\Mvc\Model;

class Book extends Model
{
    protected $id;
    protected $title;
    protected $price;
    protected $isbn;
    protected $author;
    protected $published_at;
    protected $image;

    public function image()
    {
        return BASE_URL.'/'.$this->image;
    }

    public function price()
    {
        return number_format($this->price * 1.2, 2, ',', '');
    }

    public function publishedAt()
    {
        return date('d/m/Y', strtotime($this->published_at));
    }

    public function year()
    {
        return date('Y', strtotime($this->published_at));
    }
}
