<?php

namespace Book\Mvc\Model;

class Book extends Model
{
    protected $id;
    protected $title;
    protected $price;
    protected $discount;
    protected $isbn;
    protected $author;
    protected $published_at;
    protected $image;

    public function image()
    {
        return route($this->image);
    }

    public function price($withDiscount = true)
    {
        $price = $this->price;

        if ($withDiscount) {
            $price -= $this->price * $this->discount / 100;
        }

        return number_format($price * 1.2, 2, ',', '');
    }

    public function publishedAt()
    {
        return date('d/m/Y', strtotime($this->published_at));
    }

    public function year()
    {
        return date('Y', strtotime($this->published_at));
    }

    public function isbn()
    {
        $result = $this->isbn[0].'-';

        $keep = (strlen($this->isbn) === 13) ? 6 : 4;
        $result .= implode('-', str_split(substr($this->isbn, 1), $keep));

        return $result;
    }

    /**
     * @todo Bien vérifier le ISBN 10 ou 13.
     */
    public function validIsbn()
    {
        return strlen($this->isbn) === 10 || strlen($this->isbn) === 13;
    }
}
