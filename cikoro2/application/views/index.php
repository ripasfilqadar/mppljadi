<html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Cikoro Farm Online Store</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<link rel="icon" type="image/x-icon" href="<?php echo base_url('themes/images/logo.png');?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('themes/css/style.css');?>">
		<link href="<?php echo base_url('themes/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">      
		<link href="<?php echo base_url('themes/bootstrap/css/bootstrap-responsive.min.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('themes/css/bootstrappage.css');?>" rel="stylesheet"/>
		<link href="<?php echo base_url('themes/css/flexslider.css');?>" rel="stylesheet"/>
		<link href="<?php echo base_url('themes/css/main.css');?>" rel="stylesheet"/>
		<script src="<?php echo base_url('themes/js/jquery-1.7.2.min.js');?>"></script>
		<script src="<?php echo base_url('themes/bootstrap/js/bootstrap.min.js');?>"></script>				
		<script src="<?php echo base_url('themes/js/superfish.js');?>"></script>	
		<script src="<?php echo base_url('themes/js/jquery.scrolltotop.js');?>"></script>

		<script type="text/javascript">
            // To confirm clear all data in cart.
            function clear_cart() {
                var result = confirm('Apakah anda yakin menghapus semua pemesanan?');

                if (result) {
                    window.location = "<?php echo base_url(); ?>shopping/remove/all";
                } else {
                    return false; // cancel button
                }
            }
        </script>

        <style>
  		.carousel-inner > .item > img,
  		.carousel-inner > .item > a > img 
  		{width: 70%;
     	 margin: auto;}
  </style>
	</head>
    <body style="width:100%">		
		


		<div id="top-bar" class="container">
			<div class="row">
				<div class="">
					<div class="account pull-right">
							<ul class="user-menu">								
							<li><a href="<?php echo base_url()?>login">Login</a></li>		
						</ul>
					</div>
				</div>
			</div>
		</div>




		<div id="wrapper" class="container">
			
			<section class="navbar main-menu">
				<div class="navbar-inner main-menu">				
					<a href="<?php echo base_url()?>" class="logo pull-left"><img src="<?php echo base_url('/themes/images/logo_new.png');?>" width="100" height="85" class="site_logo" alt=""></a>					
					<nav id="menu" class="pull-right">
						<ul>
							<li><a href="#">About</a>					
								<ul>
									<li><a href="<?php echo base_url()?>index.php/main/cikoro">Cikoro Farm</a></li>									
									<li><a href="<?php echo base_url()?>index.php/main/lp3m">LP3M (Lembaga Pengkajian Pedesaan, Pantai dan Masyarakat) Makassar</a></li>									
								</ul>
							</li>															
							<li><a href="<?php echo base_url()?>index.php/main/hto">How to Order</a></li>			
							<li><a href="<?php echo base_url()?>main/kontak">Contact Us</a></li>							
						</ul>
					</nav>
				</div>
			</section>
		</div>
			


			<section class="main-content">
				<div class="row">
					<br>
          <br>

					<div class="span12">													
						<div class="row">
						<div class="span1"></div>
							<div class="span11">
								<h4 class="title">
									<span class="pull-left"><span class="line">Hasil <strong>Perkebunan</strong></span></span>
									<span class="pull-right">
										
									</span>
								</h4>
							</div>						
						</div>
					</div>
								
        
        <center> 
        <div class="span2"></div>
        <div class="span10">
        <h4>
            <?php  $cart_check = $this->cart->contents();
            // If cart is empty, this will show below message.
             if(empty($cart_check)) {
             echo 'Klik tombol "Add to Cart" untuk menambahkan pada daftar Pembelian Anda'; 
             }  ?>
		    </h4> 
        </div>
        </center>
          
            



            <table id=" table" style="margin:auto; width=80% ";  >
                  <?php
                  // All values of cart store in "$cart". 
                  if ($cart = $this->cart->contents()): ?>
                    <tr id= "main_heading">
                        <td style="padding-left:40px;padding-right:40px" >Serial</td>
                        <td style="padding-left:40px;padding-right:40px">Name</td>
                        <td style="padding-left:40px;padding-right:40px">Price</td>
                        <td style="padding-left:40px;padding-right:40px">Qty</td>
                        <td style="padding-left:42px;padding-right:42px">Amount</td>
                        <td style="padding-left:45px;padding-right:45px">Cancel Product</td>
                    </tr>
                   <?php
                     // Create form and send all values in "shopping/update_cart" function.
                    echo form_open('shopping/update_cart');
                    $grand_total = 0;
                    $i = 1;

                    foreach ($cart as $item):
                        //   echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
                        //  Will produce the following output.
                        // <input type="hidden" name="cart[1][id]" value="1" />
                        
                        echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
                        echo form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']);
                        echo form_hidden('cart[' . $item['id'] . '][name]', $item['name']);
                        echo form_hidden('cart[' . $item['id'] . '][price]', $item['price']);
                        echo form_hidden('cart[' . $item['id'] . '][qty]', $item['qty']);
                        ?>
                        <tr>
                            <td style="text-align:center">
                       <?php echo $i++; ?>
                            </td>
                            <td style="text-align:center">
                      <?php echo $item['name']; ?>
                            </td>
                            <td style="text-align:center">
                                Rp <?php echo number_format($item['price'], 2); ?>
                            </td>
                            <td style="text-align:center">
                            <?php echo form_input('cart[' . $item['id'] . '][qty]', $item['qty'], 'maxlength="3" size="1" style="text-align: right"'); ?>
                            </td>
                        <?php $grand_total = $grand_total + $item['subtotal']; ?>
                            <td style="text-align:center">
                                Rp <?php echo number_format($item['subtotal'], 2) ?>
                            </td>
                            <td style="text-align:center">
                              
                            <?php 
                            // cancel image.
                            $path = "<img src='".base_url()."themes/images/cart_cross.jpg' width='25px' height='20px'>";
                            echo anchor('shopping/remove/' . $item['rowid'], $path); ?>
                            </td>
                     <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td><b>Order Total: Rp <?php 
                        
                        //Grand Total.
                        echo number_format($grand_total, 2); ?></b></td>
                        
                        <?php // "clear cart" button call javascript confirmation message ?>
                        <td colspan="5" align="right" padding="200px"><input type="button" class ='fg-button teal' value="Clear Cart" onclick="clear_cart()">
                            
                            <?php //submit button. ?>
                            <input type="submit" class ='fg-button teal' value="Update Cart">
                            <?php echo form_close(); ?>
                            
                            <!-- "Place order button" on click send "billing" controller  -->
                            <input type="button" class ='fg-button teal' value="Place Order" onclick="window.location = 'shopping/billing_view'"></td>
                    </tr>
					<?php endif; ?>
            </table>
        





        <div class="span12" align="center" style="margin-left:15%">

            
            <?php
            
            // "$products" send from "shopping" controller,its stores all product which available in database. 
            foreach ($products as $product) {
                $id = $product['ID_BARANG'];
                $name = $product['NAMA_BARANG'];
                $description = $product['DESKRIPSI'];
                $price = $product['HARGA'];
                ?>

                <div id='product_div'>  
                    <div id='image_div'>
                        <img src="<?php echo base_url()?>picture/<?php echo $product['FOTO']?>.png"/>
                    </div>
                    <div id='info_product'>
                        <div id='name'><?php echo $name; ?></div>
                        <div id='desc'>  <?php echo $description; ?></div>
                        <div id='rs'><b>Price</b>:<big style="color:green">
                            Rp <?php echo $price; ?></big></div>
                        <?php
                        
                        // Create form and send values in 'shopping/add' function.
                        echo form_open('shopping/add');
                        echo form_hidden('id', $id);
                        echo form_hidden('name', $name);
                        echo form_hidden('price', $price);
                        ?> 
                    </div> 
                    
                    <div id='add_button'>
                        <?php
                        $btn = array(
                            'class' => 'fg-button teal',
                            'value' => 'Add to Cart',
                            'name' => 'action'
                        );
                        
                        // Submit Button.
                        echo form_submit($btn);
                        echo form_close();
                        ?>
                    </div>

                </div>
			<?php } ?>

        </div>


	</section>


<div class="container">
  <br>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <center> 
        <div class="span12">
        <h3>
             Our Gallery :
        </h3> 
        </div>
    </center>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="<?php echo base_url('themes/images/carousel/1.jpg');?>" alt="buah" >
      </div>

      <div class="item">
        <img src="<?php echo base_url('themes/images/carousel/3.jpg');?>" alt="kebun" >
      </div>
    
      <div class="item">
        <img src="<?php echo base_url('themes/images/carousel/4.jpg');?>" alt="buah2" >
      </div>

      <div class="item">
        <img src="<?php echo base_url('themes/images/carousel/5.jpg');?>" alt="kebun2" >
      </div>

      <div class="item">
        <img src="<?php echo base_url('themes/images/carousel/6.jpg');?>" alt="kebun3" >
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only"></span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only"></span>
    </a>
  </div>

		
			<section id="copyright" style="bottom:0; position:relative">
				<span class="span10" >Copyright 2015</span>
			
				<span class="social_icons">
					<a class="facebook" href="https://www.facebook.com/pages/Lembaga-Pengkajian-Pedesaan-Pantai-dan-Masyarakat-LP3M-Makassar/155812491140375?fref=ts"><img src="<?php echo base_url('themes/images/fb.jpg');?>" style="width:30px; " class="site_logo" alt=""></a>
					<a class="twitter" href="#"><img src="<?php echo base_url('themes/images/twit.png');?>" style="width:30px" class="site_logo" alt=""></a>
				</span>	
			</section>
		</div>
</div>
		<script src="<?php echo base_url('themes/js/common.js');?>"></script>
		<script src="<?php echo base_url('themes/js/jquery.flexslider-min.js');?>"></script>
		<script type="text/javascript">
			$(function() {
				$(document).ready(function() {
					$('.flexslider').flexslider({
						animation: "fade",
						slideshowSpeed: 4000,
						animationSpeed: 600,
						controlNav: false,
						directionNav: true,
						controlsContainer: ".flex-container"
				});
			});
		</script>
    </body>
</html>