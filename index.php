<?php 
session_start();

include_once "DB.php";
include_once "Product.php";
include_once "Basket.php";

DB::instance();
?>

<?php include "default/header.php"; ?>

<?php 
if (isset($_SESSION["User"])) {
    /* Cейчас объект не принадлежит классу User, а принадлежит __PHP_Incomplete_Class Object - это неправильно.
    вам необходимо погуглить и избавиться от этого. 
    Объект должен принадлежать своему классу.
    Если объект User, значит принадлежит классу User,
    Если объект Admin, значит принадлежит классу Admin,
    но никак не __PHP_Incomplete_Class Object
    */

    echo "<pre>";
    print_r($_SESSION["User"]);
    echo "<pre>";
    

} else {
    echo "Сессия пустая";
}

?>

<!-- АВТОРИЗАЦИЯ -->
<section>
    <form class="auth" action="#">
        <div class="auth__tile">Авторизация</div>
        <input name="login" type="text" value="" placeholder="Логин">
        <input name="password" type="password" value="" placeholder="Пароль">
        <button class="auth__submit" type="button" value="logIn">Войти</button>
        <input class="auth__change" type="button" value="Зарегистрироваться">
    </form>
</section>

<!-- КАТАЛОГ -->
<section class="products">
    <div class="products__title">КАТАЛОГ</div>
    <div class="products__articles">
        <?php foreach(Product::getProducts() as $product): ?>
            <article data-productid="<?= $product->product_id ?>" class="products__card">
                <div class="products__name"><?= $product->name ?></div>
                <div class="products__price">Цена: <?= $product->price ?></div>
                <div class="products__weight">Вес: <?= $product->weight ?></div>
                <button value="addToBasket" class="product__add">+</button>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<!-- КОРЗИНА -->
<section class="basket">
    <div class="basket__title">КОРЗИНА</div>
    <div class="basket__articles">
        <?php if (isset($_SESSION["User"])) foreach(Basket::getProducts($_SESSION["User"]->user_id) as $product): ?>
            <article data-productid="<?= $product->product_id ?>" class="basket__card">
                <div class="basket__name"><?= $product->name ?></div>
                <div class="basket__price">Цена (шт): <?= $product->price ?></div>
                <div class="basket__weight">Вес (шт): <?= $product->weight ?></div>
                <div class="basket__count">Количество: <?= $product->count ?></div>
                <div class="basket__all-weight">Вес: <?= ($product->count * $product->weight) ?></div>
                <div class="basket__all-price">Цена: <?= ($product->count * $product->price) ?></div>
                <button value="addToBasket" class="basket__add">+</button>
                <button value="delFromBasket" class="basket__del">-</button>
            </article>
        <?php endforeach; ?>
    </div>

    <div class="basket__weightall">Итоговый вес: <?= Basket::getWeight() ?> кг.</div>
    <div class="basket__priceall">Итоговый цена: <?= Basket::getPrice() ?> руб.</div>
</section>


<?php include "default/footer.php"; ?>

    
