<?php

namespace Book\Mvc\Model;

use Book\Mvc\DB;

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

    public function realPrice($withDiscount = true)
    {
        $price = $this->price;

        if ($withDiscount) {
            $price -= $this->price * $this->discount / 100;
        }

        return $price;
    }

    public function price($withDiscount = true)
    {
        return number_format($this->realPrice($withDiscount) * 1.2, 2, ',', '');
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

    public static function filters($options)
    {
        $table = self::getTable();

        $where = [];

        if (! empty($min = $options['min_price'])) {
            $where[] = 'price >= '.(int) $min;
        }

        if (! empty($max = $options['max_price'])) {
            $where[] = 'price <= '.(int) $max;
        }

        $where = ! empty($where) ? 'WHERE '.implode(' AND ', $where) : '';

        $sql = "SELECT * FROM $table $where ORDER BY {$options['order_by']} {$options['direction']}";

        return DB::select($sql, [], static::class);
    }
}
