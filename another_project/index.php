<?php
include('functions/userfunctions.php');
include('includes/header.php'); 
include('includes/slider.php'); 
?>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>Trending Product</h4>
                <div style="height: 5px;width: 150px;background-color: red;border-radius: 20px;" class="underline mb-2"></div>
                <hr>
                
                    <div class="owl-carousel">
                    <?php
                        $trendingProducts = getAllTrending();
                        if(mysqli_num_rows($trendingProducts) > 0)
                        {
                            foreach($trendingProducts as $item)
                            {
                                ?>
                                    <div class="item">
                                        <a href="product-view.php?product=<?= $item['slug']; ?>">
                                            <div class="car shadow">
                                                <div class="card-body">
                                                    <img src="uploads/<?= $item['image']; ?>" alt="Product Image" class="w-100">
                                                    <h6 class="text-center"><?= $item['name'] ?></h6>
                                                </div>
                                            </div>
                                        </a>    
                                    </div>
                                    
                                <?php
                            }
                        }
                    ?>
                    </div>
                
            </div>
        </div>
    </div>
</div>


<div style="background-color: #f2f2f2" class="py-5 bg-f2f2f2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>About Us</h4>
                <div style="height: 5px;width: 150px;background-color: red;border-radius: 20px;" class="underline mb-2"></div>
                <p>
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Modi, consequatur nulla. Repudiandae nemo molestiae, quisquam est neque totam autem harum non temporibus reprehenderit repellat alias minima maxime sit quae sapiente.
                </p>
                <p>
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Modi, consequatur nulla. Repudiandae nemo molestiae, quisquam est neque totam autem harum non temporibus reprehenderit repellat alias minima maxime sit quae sapiente.
                    <hr>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste rerum blanditiis tempore quibusdam ullam? Temporibus quis maiores nesciunt eius. Nam sequi eos temporibus, aperiam aliquid quam quod delectus molestias similique?
                </p>
            </div>
        </div>
    </div>
</div>

<div class="py-5 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h4 class="text-white">E-shop</h4>
                <div style="height: 5px;width: 150px;background-color: red;border-radius: 20px;" class="underline mb-2"></div>
                <a href="index.php" class="text-white"> <i class="fa fa-angle-right"></i> Home</a> <br />
                <a href="#" class="text-white"> <i class="fa fa-angle-right"></i> About Us</a> <br />
                <a href="cart.php" class="text-white"> <i class="fa fa-angle-right"></i> My Cart</a> <br />
                <a href="categories.php" class="text-white"> <i class="fa fa-angle-right"></i> Our Collections</a>
            </div>
            <div class="col-md-3">
                <h4 class="text-white">Address</h4>
                <p class="text-white">
                    #24, Ground Floor,
                    2nd street, xyz layout,
                    VietName Ha Noi
                </p>
                <a href="tel:+091823718297" class="text-white"> <id class="fa fa-phone"></id>+91 8712 87237</a> <br />
                <a href="mailto:asdm@gmail.com" class="text-white"> <id class="fa fa-envelope"></id>asdm@gmail.com</a>
            </div>
            <div class="col-md-6">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62911.94730585721!2d105.33951980656396!3d9.766345113385697!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0c2f4f69fd8b5%3A0xd805001c1249beb3!2zVsSpbmggSMOyYSwgVHAuIFbhu4sgVGhhbmgsIEjhuq11IEdpYW5nLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1691776453011!5m2!1svi!2s" class="w-100" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>
<div class="py-2 bg-danger">
    <div class="text-center">
        <p class="mb-0 text-white">All right reserved. Copyright @ <a href="https://www.youtube.com" target="_blank" class="text-white"></a>ngoc</a> - <?= date('Y') ?></p>
    </div>
</div>
    

<?php include('includes/footer.php'); ?>   
<script>
$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    }
})
</script>