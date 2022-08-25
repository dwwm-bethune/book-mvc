<?php

namespace Book\Mvc\Controller;

use Book\Mvc\Model\Book;

class CartController extends Controller
{
    public function index()
    {
        $cart = $_SESSION['cart'] ?? [];

        $total = array_sum(array_map(function ($item) {
            return $item['book']->price * $item['quantity'] * 1.2;
        }, $cart));

        return $this->render('cart', [
            'cart' => $cart,
            'total' => number_format($total, 2, ',', ''),
        ]);
    }

    public function create($id)
    {
        $cart = $_SESSION['cart'] ?? [];
        $exists = false;

        // On regarde si le produit existe dans le tableau et on modifie sa quantité
        // Le & permet de modifier un élément du tableau par référence
        foreach ($cart as &$item) {
            if ($item['book']->id === $id) {
                $item['quantity']++;
                $exists = true;
            }
        }

        // Si le produit n'existe pas déjà dans le panier, on l'ajoute
        if (! $exists) {
            $cart[] = [
                'book' => Book::find($id),
                'quantity' => 1,
            ];
        }

        $_SESSION['cart'] = $cart;

        return $this->redirect(BASE_URL.'/cart');
    }

    public function delete($id)
    {
        $cart = $_SESSION['cart'] ?? [];

        foreach ($cart as $key => $item) {
            if ($item['book']->id === $id) {
                unset($cart[$key]);
            }
        }

        $_SESSION['cart'] = $cart;

        return $this->redirect(BASE_URL.'/cart');
    }
}
