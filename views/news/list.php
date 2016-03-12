<?php 
use yii\helpers\Url;
 ?>                     
                                        <?php if(isset($provider)) foreach ($provider->models as  $news){?>
                                         <div class="feed-element tan1" var1="<?=$news->news_id?>">
                                            <a href="profile.html#" class="pull-left">
                                                <img alt="image" class="img-circle" src="<?=$news->cover?>">
                                            </a>
                                            <div class="media-body h_media">
                                               
                                                <strong style="font-size:20px;"><?=$news->title?></strong> 
                                                <span style="font-size:9px; float:right;"><?=date('m-d',$news->create_time)?></span> 
                                                <br>
                                               
                                                <div class="well">
                                                    <?php
                                                        $newstr = strip_tags($news->content);
                                                        $newstr = mb_substr($newstr,0,250,'utf-8');
                                                        echo $newstr.'...';
                                                    ?>
                                                </div>
                                               
                                            </div>
                                        </div>
                                        <?php } ?>
