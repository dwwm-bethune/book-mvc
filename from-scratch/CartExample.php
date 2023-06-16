<?php

class Cart
{
    private $items = [];
    private $total = 0;
    private $count = 0;

    public function add($name, $price, $quantity) {
        $this->items[] = [
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
        ];

        $this->count += $quantity;
        $this->total += $price * $quantity;
    }

    public function delete($name) {
        foreach ($this->items as $index => $item) {
            if ($name === $item['name']) {
                $this->count -= $item['quantity'];
                $this->total -= $item['price'] * $item['quantity'];
                unset($this->items[$index]);
            }
        }
    }

    public function update($name, $quantity) {
        foreach ($this->items as &$item) {
            if ($name === $item['name']) {
                $this->count -= $item['quantity'];
                $this->total -= $item['price'] * $item['quantity'];
                $item['quantity'] = $quantity;
                $this->count += $item['quantity'];
                $this->total += $item['price'] * $item['quantity'];
            }
        }
    }

    public function total() {
        return "Le panier a un total de $this->total pour $this->count produits.";
    }
}

$cart1 = new Cart();
$cart1->add('iPhone', 1000, 1);
$cart1->add('Macbook', 1000, 2);
$cart1->delete('iPhone');
$cart1->update('Macbook', 1);
echo $cart1->total();
$cart2 = new Cart();
$cart2->add('TV', 1000, 1);
echo $cart2->total();

echo '<pre>';
var_dump($cart1, $cart2);
echo '</pre>';