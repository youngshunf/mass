
		<?php foreach ($news as $v){?>
		<div class="swiper-slide news" data-newsid="<?= $v->newsid?>" style="text-align: left; ">
		<p style="padding: 5px;"><span class="red-circle"></span><?= $v->title?></p>
		</div>
		
    <?php }?>
    
