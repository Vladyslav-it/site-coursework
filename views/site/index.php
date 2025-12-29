<?php

/** @var yii\web\View $this */

$this->title = 'YourHealth';
?>
<div class="site-index">

    <div class="welcome-block text-center py-4 px-3 mb-1">
        <h2>Ласкаво просимо до блогу!</h2>
        <p>Тут ви знайдете поради щодо здорового харчування!</p>
    </div>

    <!-- Слайдер -->
    <div id="carousel" class="carousel slide carousel-fade mb-4" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/slide1.jpg" class="d-block w-100" alt="slide1">
            </div>
            <div class="carousel-item">
                <img src="images/slide2.jpg" class="d-block w-100" alt="slide2">
            </div>
            <div class="carousel-item">
                <img src="images/slide3.jpg" class="d-block w-100" alt="slide3">
            </div>
        </div>
    </div>

    <div class="body-content">
        <div class="items">
            <div class="row gy-4 text-center">

                <div class="col-lg-3 col-sm-6">
                    <div class="item p-3">
                        <p><i class="fa-solid fa-apple-whole"></i></p>
                        <h5>Фрукти та овочі</h5>
                        <p>Їжте та додавайте більше фруктів та овочів у свій раціон щодня обов’язково.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="item p-3">
                        <p><i class="fa-solid fa-drumstick-bite"></i></p>
                        <h5>Білки</h5>
                        <p>Обирайте будь ласка корисні джерела білка: рибу, курку, бобові та горіхи.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="item p-3">
                        <p><i class="fa-solid fa-bottle-water"></i></p>
                        <h5>Вода</h5>
                        <p>Пийте достатню кількість води протягом дня для підтримки вашого здоров’я.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="item p-3">
                        <p><i class="fa-solid fa-seedling"></i></p>
                        <h5>Збалансованість</h5>
                        <p>Слідкуйте за балансом між жирами, білками та вуглеводами у вашому раціоні.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>