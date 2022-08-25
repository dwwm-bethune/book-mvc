<?php

namespace Book\Mvc;

class Cart
{
    public $items = [];

    public function __construct()
    {
        $this->items = $_SESSION['cart'] ?? [];
    }

    public function total()
    {
        $total = array_sum(array_map(function ($item) {
            return $item['book']->price * $item['quantity'] * 1.2;
        }, $this->items));

        return number_format($total, 2, ',', '');
    }

    public function price($item)
    {
        return number_format($item['book']->price * $item['quantity'] * 1.2, 2, ',', '');
    }

    public function add($book, $quantity)
    {
        $exists = false;

        // On regarde si le produit existe dans le tableau et on modifie sa quantité
        // Le & permet de modifier un élément du tableau par référence
        foreach ($this->items as &$item) {
            if ($item['book']->id === $book->id) {
                $item['quantity'] += $quantity;
                $exists = true;
            }
        }

        // Si le produit n'existe pas déjà dans le panier, on l'ajoute
        if (! $exists) {
            $this->items[] = [
                'book' => $book,
                'quantity' => $quantity,
            ];
        }

        $_SESSION['cart'] = $this->items;
    }

    public function delete($id)
    {
        foreach ($this->items as $key => $item) {
            if ($item['book']->id === $id) {
                unset($this->items[$key]);
            }
        }

        $_SESSION['cart'] = $this->items;
    }
}
