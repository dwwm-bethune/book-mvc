<?php

namespace Book\Mvc\Controller;

use Book\Mvc\Cart;
use Book\Mvc\Model\Book;

class CartController extends Controller
{
    public function index()
    {
        $cart = new Cart();

        return $this->render('cart', [
            'cart' => $cart,
            'total' => $cart->total(),
        ]);
    }

    public function create($id)
    {
        $cart = new Cart();
        $cart->add(Book::find($id), 1);

        return $this->redirect(BASE_URL.'/cart');
    }

    public function delete($id)
    {
        $cart = new Cart();
        $cart->delete($id);

        return $this->redirect(BASE_URL.'/cart');
    }
}
