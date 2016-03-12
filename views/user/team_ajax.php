<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>                      
                                        <div class="table-responsive" style="border:1px solid #ddd;">
                                        <table class="table table-striped he_table">
                                            <thead>
                                                <tr>

                                                    <th>用户ID</th>
                                                    <th>姓名</th>
                                                    <th>用户名</th>
                                                    <th>级别</th>
                                                    <th>团队人数</th> 
                                                    <th>状态</th>                   
                                                    <th>加入时间</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if($user_list) foreach($user_list->models as $models):?>
                                                
                                                <tr >
                                                    <td><?=$models->user_id?></td>
                                                    <td><?=$models->usert->nickname?></td>
                                                    <td><?=$models->usert->account?></td>
                                                    <td><?=$models->usert->level->name?></td>
                                                    <td><a href=""><?=$user_list_count?></a></td>
                                                    <td><?=$models->usert->is_active == 1 ? '已激活' : '未激活'?></td>
                                                    <td><?=date('Y-m-d H:s',$models->usert->create_time)?></td>                                                          
                                                </tr>
                                            <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    <?php if(isset($user_list)) { ?>
                                    <?=
                                            LinkPager::widget([
                                            'pagination' => $user_list->pagination,
                                            'options' => ['class' => 'pagination pull-left', 'style' => 'align:center;'],
                                            ]);
                                     } ?>                
